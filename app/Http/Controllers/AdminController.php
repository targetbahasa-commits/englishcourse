<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RegistrationLead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    private function resolveExportActivitySort(Request $request): string
    {
        $allowed = ['newest', 'oldest', 'rows_desc'];
        $selected = (string) $request->query('export_activity_sort', 'newest');

        return in_array($selected, $allowed, true) ? $selected : 'newest';
    }

    private function extractRowsFromMeta($meta): int
    {
        if (empty($meta)) {
            return 0;
        }

        $decoded = json_decode((string) $meta, true);
        if (!is_array($decoded)) {
            return 0;
        }

        return (int) ($decoded['rows'] ?? 0);
    }

    private function resolveExportActivityType(Request $request): string
    {
        $allowed = ['all', 'registration_leads', 'campaign_signups'];
        $selected = (string) $request->query('export_activity_type', 'all');

        return in_array($selected, $allowed, true) ? $selected : 'all';
    }

    private function mapExportActionByType(string $type): ?string
    {
        return match ($type) {
            'registration_leads' => 'registration_leads_export',
            'campaign_signups' => 'campaign_signups_export',
            default => null,
        };
    }

    private function resolveCampaignWindowDays(Request $request): int
    {
        $allowedWindows = [7, 14, 30, 90];
        $window = (int) $request->query('campaign_window', 30);

        return in_array($window, $allowedWindows, true) ? $window : 30;
    }

    private function trackedRoles(): array
    {
        return ['student', 'guest'];
    }

    private function campaignLabelExpression(): string
    {
        return "COALESCE(NULLIF(utm_campaign, ''), 'Organic / Direct')";
    }

    private function sourcePageExpression(): string
    {
        return "COALESCE(NULLIF(acquisition_source_page, ''), 'general_site')";
    }

    private function variantExpression(): string
    {
        return "COALESCE(NULLIF(acquisition_variant, ''), 'unknown')";
    }

    public function index(Request $request)
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalPrograms = \App\Models\Program::count();
        $activeAssignments = \App\Models\Meeting::count();
        $campaignWindowDays = $this->resolveCampaignWindowDays($request);
        $exportActivityType = $this->resolveExportActivityType($request);
        $exportActivitySort = $this->resolveExportActivitySort($request);
        $exportActionFilter = $this->mapExportActionByType($exportActivityType);
        $trackedRoles = $this->trackedRoles();
        $campaignLabelExpr = $this->campaignLabelExpression();
        $sourcePageExpr = $this->sourcePageExpression();
        $variantExpr = $this->variantExpression();

        $threshold = Carbon::now()->subHours(24)->timestamp;

        $activeStudents = DB::table('sessions')
            ->whereNotNull('user_id')
            ->where('last_activity', '>=', $threshold)
            ->join('users', 'sessions.user_id', '=', 'users.id')
            ->whereIn('users.role', ['teacher', 'student', 'guest'])
            ->leftJoin('programs', 'users.program_id', '=', 'programs.id')
            ->select(
                'users.id',
                'users.name',
                'users.role',
                'programs.name as program_name',
                'sessions.last_activity'
            )
            ->orderBy('sessions.last_activity', 'desc')
            ->get()
            ->unique('id')
            ->values();

        $trackedSignupsLast30Days = User::whereIn('role', $trackedRoles)
            ->where('created_at', '>=', now()->subDays($campaignWindowDays))
            ->whereRaw("COALESCE(utm_campaign, '') <> '' OR COALESCE(acquisition_source_page, '') <> ''")
            ->count();

        $whvAttributedUsers = User::whereIn('role', $trackedRoles)
            ->where('created_at', '>=', now()->subDays($campaignWindowDays))
            ->where('acquisition_source_page', 'whv_applications')
            ->count();

        $trackedSignupsLast7Days = User::whereIn('role', $trackedRoles)
            ->where('created_at', '>=', now()->subDays(7))
            ->whereRaw("COALESCE(utm_campaign, '') <> '' OR COALESCE(acquisition_source_page, '') <> ''")
            ->count();

        $whvVariantBreakdown = User::selectRaw("{$variantExpr} as variant_label, COUNT(*) as total")
            ->whereIn('role', $trackedRoles)
            ->where('created_at', '>=', now()->subDays($campaignWindowDays))
            ->where('acquisition_source_page', 'whv_applications')
            ->groupBy(DB::raw($variantExpr))
            ->orderByDesc('total')
            ->get();

        $campaignSignups = User::selectRaw("{$campaignLabelExpr} as campaign_label, {$sourcePageExpr} as source_page, SUM(CASE WHEN role = 'guest' THEN 1 ELSE 0 END) as guest_signups, SUM(CASE WHEN role = 'student' THEN 1 ELSE 0 END) as student_signups, COUNT(*) as total_signups")
            ->whereIn('role', $trackedRoles)
            ->where('created_at', '>=', now()->subDays($campaignWindowDays))
            ->whereRaw("COALESCE(utm_campaign, '') <> '' OR COALESCE(acquisition_source_page, '') <> ''")
            ->groupBy(DB::raw($campaignLabelExpr), DB::raw($sourcePageExpr))
            ->orderByDesc('total_signups')
            ->limit(6)
            ->get();

        $leadCampaignExpr = "COALESCE(NULLIF(utm_campaign, ''), 'Organic / Direct')";
        $leadSourceExpr = "COALESCE(NULLIF(acquisition_source_page, ''), 'general_site')";

        $trackedLeadsWindow = RegistrationLead::where('created_at', '>=', now()->subDays($campaignWindowDays))
            ->whereRaw("COALESCE(utm_campaign, '') <> '' OR COALESCE(acquisition_source_page, '') <> ''");

        $trackedLeadsTotal = (clone $trackedLeadsWindow)->count();
        $trackedLeadsConverted = (clone $trackedLeadsWindow)->where('status', 'converted')->count();

        $leadCampaignPerformance = RegistrationLead::selectRaw("{$leadCampaignExpr} as campaign_label, {$leadSourceExpr} as source_page, COUNT(*) as total_leads, SUM(CASE WHEN status = 'converted' THEN 1 ELSE 0 END) as converted_leads, ROUND((SUM(CASE WHEN status = 'converted' THEN 1 ELSE 0 END) / NULLIF(COUNT(*), 0)) * 100, 1) as cvr_percent")
            ->where('created_at', '>=', now()->subDays($campaignWindowDays))
            ->whereRaw("COALESCE(utm_campaign, '') <> '' OR COALESCE(acquisition_source_page, '') <> ''")
            ->groupBy(DB::raw($leadCampaignExpr), DB::raw($leadSourceExpr))
            ->orderByDesc('cvr_percent')
            ->orderByDesc('total_leads')
            ->limit(6)
            ->get();

        $lastExportActivity = null;
        $recentExportActivities = collect();
        if (Schema::hasTable('admin_activity_logs')) {
            $lastExportQuery = DB::table('admin_activity_logs')
                ->leftJoin('users', 'admin_activity_logs.user_id', '=', 'users.id')
                ->whereIn('admin_activity_logs.action', ['campaign_signups_export', 'registration_leads_export']);

            if (!empty($exportActionFilter)) {
                $lastExportQuery->where('admin_activity_logs.action', $exportActionFilter);
            }

            $lastExportActivity = $lastExportQuery
                ->select('admin_activity_logs.action', 'admin_activity_logs.preset', 'admin_activity_logs.created_at', 'users.name as user_name')
                ->orderByDesc('admin_activity_logs.created_at')
                ->first();

            $recentExportQuery = DB::table('admin_activity_logs')
                ->leftJoin('users', 'admin_activity_logs.user_id', '=', 'users.id')
                ->whereIn('admin_activity_logs.action', ['campaign_signups_export', 'registration_leads_export']);

            if (!empty($exportActionFilter)) {
                $recentExportQuery->where('admin_activity_logs.action', $exportActionFilter);
            }

            $recentExportQuery->select('admin_activity_logs.action', 'admin_activity_logs.preset', 'admin_activity_logs.meta', 'admin_activity_logs.created_at', 'users.name as user_name');

            if ($exportActivitySort === 'oldest') {
                $recentExportActivities = $recentExportQuery
                    ->orderBy('admin_activity_logs.created_at')
                    ->limit(10)
                    ->get();
            } elseif ($exportActivitySort === 'rows_desc') {
                $recentExportActivities = $recentExportQuery
                    ->orderByDesc('admin_activity_logs.created_at')
                    ->limit(200)
                    ->get()
                    ->sortByDesc(fn ($item) => $this->extractRowsFromMeta($item->meta))
                    ->values()
                    ->take(10);
            } else {
                $recentExportActivities = $recentExportQuery
                    ->orderByDesc('admin_activity_logs.created_at')
                    ->limit(10)
                    ->get();
            }
        }

        // Program Performance Summary
        $programPerformance = \App\Models\Program::withCount([
            'users as students_count' => function ($q) {
                $q->where('role', 'student');
            },
            'users as active_students_count' => function ($q) use ($threshold) {
                $q->where('role', 'student')
                    ->join('sessions', 'users.id', '=', 'sessions.user_id')
                    ->where('sessions.last_activity', '>=', $threshold)
                    ->distinct('users.id');
            },
        ])
            ->orderByDesc('students_count')
            ->limit(5)
            ->get();

        // Teacher Activity Summary
        $teacherActivitySummary = User::where('role', 'teacher')
            ->selectRaw('users.id, users.name, COUNT(DISTINCT programs.id) as program_count')
            ->leftJoin('programs', 'users.program_id', '=', 'programs.id')
            ->leftJoin('sessions', 'users.id', '=', 'sessions.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByRaw('MAX(sessions.last_activity) DESC')
            ->limit(5)
            ->get();

        $dbStatus = 'Disconnected';
        try {
            DB::connection()->getPdo();
            $dbStatus = 'Connected';
        } catch (\Exception $e) {
        }

        $appVersion = config('app.version', 'v' . app()->version());
        $mailService = config('mail.default', 'smtp');

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalPrograms',
            'activeAssignments',
            'activeStudents',
            'campaignWindowDays',
            'trackedSignupsLast30Days',
            'trackedSignupsLast7Days',
            'whvAttributedUsers',
            'whvVariantBreakdown',
            'campaignSignups',
            'trackedLeadsTotal',
            'trackedLeadsConverted',
            'leadCampaignPerformance',
            'lastExportActivity',
            'recentExportActivities',
            'exportActivityType',
            'exportActivitySort',
            'programPerformance',
            'teacherActivitySummary',
            'dbStatus',
            'appVersion',
            'mailService'
        ));
    }

    public function exportCampaignSignups(Request $request)
    {
        $campaignWindowDays = $this->resolveCampaignWindowDays($request);
        $campaignLabelExpr = $this->campaignLabelExpression();
        $sourcePageExpr = $this->sourcePageExpression();
        $variantExpr = $this->variantExpression();

        $rows = User::selectRaw("name, email, role, {$campaignLabelExpr} as campaign_label, {$sourcePageExpr} as source_page, {$variantExpr} as variant_label, COALESCE(NULLIF(utm_source, ''), '') as utm_source, COALESCE(NULLIF(utm_medium, ''), '') as utm_medium, COALESCE(NULLIF(acquisition_last_cta, ''), '') as last_cta, created_at")
            ->whereIn('role', $this->trackedRoles())
            ->where('created_at', '>=', now()->subDays($campaignWindowDays))
            ->whereRaw("COALESCE(utm_campaign, '') <> '' OR COALESCE(acquisition_source_page, '') <> ''")
            ->orderByDesc('created_at')
            ->get();

        $preset = (string) $request->query('export_preset', 'campaign_signups');
        $this->logExportAction($preset, [
            'filters' => $request->query(),
            'rows' => $rows->count(),
        ]);

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'Email', 'Role', 'Campaign', 'Source Page', 'Variant', 'UTM Source', 'UTM Medium', 'Last CTA', 'Created At']);

            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row->name,
                    $row->email,
                    $row->role,
                    $row->campaign_label,
                    $row->source_page,
                    $row->variant_label,
                    $row->utm_source,
                    $row->utm_medium,
                    $row->last_cta,
                    optional($row->created_at)->toDateTimeString(),
                ]);
            }

            fclose($handle);
        }, 'campaign-signups.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function logExportAction(string $preset, array $meta = []): void
    {
        try {
            if (!Schema::hasTable('admin_activity_logs')) {
                return;
            }

            DB::table('admin_activity_logs')->insert([
                'user_id' => Auth::id(),
                'action' => 'campaign_signups_export',
                'preset' => $preset,
                'meta' => json_encode($meta, JSON_UNESCAPED_SLASHES),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Export should not fail if logging table is unavailable.
        }
    }

    public function impersonate($role)
    {
        // Only admins can impersonate (this should be protected by middleware ideally, but handled here as fallback)
        $currentUser = Auth::user();

        if ($currentUser && $currentUser->role === 'admin' && in_array($role, ['teacher', 'student', 'guest'])) {
            session(['view_as_role' => $role]);
        }
        
        if ($role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        } elseif ($role === 'student' || $role === 'guest') {
            return redirect()->route('dashboard');
        }

        return back();
    }

    public function stopImpersonate()
    {
        session()->forget('view_as_role');
        return redirect()->route('admin.dashboard');
    }
}
