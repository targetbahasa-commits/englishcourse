<?php

namespace App\Http\Controllers\Admin;

use App\Application\Partner\ManagePartners;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function __construct(
        private readonly ManagePartners $managePartners,
    ) {}

    public function index(Request $request): View
    {
        $query = Partner::query()->withCount('employees');

        if ($search = trim((string) $request->query('search', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('pic_name', 'like', "%{$search}%")
                    ->orWhere('registration_code', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $partners = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.partners.index', compact('partners'));
    }

    public function create(): View
    {
        $suggestedCode = $this->managePartners->generateCode();
        $programs = Program::withoutMockTests()->where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return view('admin.partners.create', compact('suggestedCode', 'programs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        $partner = $this->managePartners->create($validated, Auth::id());

        return redirect()->route('admin.partners.show', $partner)->with('success', "Partner \"{$partner->name}\" berhasil ditambahkan.");
    }

    public function show(Partner $partner): View
    {
        $partner->load('program');
        $stats = $this->managePartners->stats($partner);

        return view('admin.partners.show', compact('partner', 'stats'));
    }

    public function edit(Partner $partner): View
    {
        $programs = Program::withoutMockTests()->where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return view('admin.partners.edit', compact('partner', 'programs'));
    }

    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $validated = $this->validated($request, $partner);

        $this->managePartners->update($partner, $validated);

        return redirect()->route('admin.partners.show', $partner)->with('success', 'Data partner berhasil diperbarui.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        $name = $partner->name;
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', "Partner \"{$name}\" berhasil dihapus.");
    }

    public function searchUsers(Request $request): \Illuminate\Http\JsonResponse
    {
        $search = trim((string) $request->query('q', ''));

        $users = User::where('role', 'student')
            ->whereNull('partner_id')
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->limit(20)
            ->get(['id', 'name', 'email']);

        return response()->json(['users' => $users]);
    }

    public function attachUser(Request $request, Partner $partner): RedirectResponse
    {
        $request->validate(['user_id' => 'required|integer|exists:users,id']);

        $ok = $this->managePartners->attachExistingUser($partner, (int) $request->user_id);

        return back()->with($ok ? 'success' : 'error', $ok ? 'Siswa berhasil ditautkan ke partner ini.' : 'Siswa tidak ditemukan.');
    }

    public function detachUser(Partner $partner, User $user): RedirectResponse
    {
        $this->managePartners->detachUser($partner, $user->id);

        return back()->with('success', 'Siswa berhasil dilepas dari partner ini.');
    }

    public function exportScoreSheet(Partner $partner): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $rows = $this->managePartners->scoreSheetRows($partner);
        $filename = 'lembar-nilai-' . \Illuminate\Support\Str::slug($partner->name) . '-' . now()->format('Ymd') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama Karyawan', 'Email', 'Program', 'Meeting', 'Nilai', 'Tanggal Submit']);

            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row->user->name ?? '',
                    $row->user->email ?? '',
                    $row->program->name ?? '',
                    $row->meeting_number,
                    $row->score ?? '',
                    $row->submitted_at?->format('Y-m-d H:i') ?? '',
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    private function validated(Request $request, ?Partner $partner = null): array
    {
        return $request->validate([
            'name'              => 'required|string|max:255',
            'pic_name'          => 'nullable|string|max:255',
            'pic_phone'         => 'nullable|string|max:50',
            'pic_email'         => 'nullable|email|max:255',
            'industry'          => 'nullable|string|max:255',
            'program_id'        => 'nullable|exists:programs,id',
            'total_meetings'    => 'nullable|integer|min:1|max:200',
            'program_start_date' => 'nullable|date',
            'program_end_date' => 'nullable|date|after_or_equal:program_start_date',
            'status'            => 'required|in:prospecting,negotiating,active,inactive',
            'registration_code' => 'nullable|string|max:50|unique:partners,registration_code' . ($partner ? ',' . $partner->id : ''),
            'discount_type'     => 'nullable|in:percentage,fixed',
            'discount_value'    => 'nullable|integer|min:0',
            'certificate_delivery_mode' => 'required|in:certificate,score_sheet',
            'is_active'         => 'boolean',
            'notes'             => 'nullable|string',
        ]);
    }
}
