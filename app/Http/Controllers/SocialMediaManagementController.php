<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaPost;
use App\Models\SocialMediaLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SocialMediaManagementController extends Controller
{
    private static array $validPrograms = [
        'grammar-writing', 'toefl-itp', 'ielts-academic',
        'ielts-general', 'toefl-ibt', 'pte-academic', 'speaking',
    ];

    /**
     * "All Programs" overview index
     */
    public function allPrograms(Request $request)
    {
        $query = SocialMediaPost::with('links')->where('is_archived', false);

        $this->applyFilters($query, $request);

        $posts = $query->orderBy('publish_date', 'asc')->orderBy('publish_time', 'asc')->paginate(25);

        $stats = $this->globalStats();

        // Calendar data — cross-program
        $calendarYear  = (int) $request->input('cal_year',  now()->year);
        $calendarMonth = (int) $request->input('cal_month', now()->month);

        $calendarPosts = SocialMediaPost::where('is_archived', false)
            ->whereIn('status', ['draft', 'scheduled', 'published'])
            ->whereYear('publish_date', $calendarYear)
            ->whereMonth('publish_date', $calendarMonth)
            ->select('id', 'title', 'program', 'platforms', 'status', 'publish_date', 'publish_time')
            ->orderBy('publish_date')
            ->orderBy('publish_time')
            ->get()
            ->groupBy(fn($p) => $p->publish_date->day);

        return view('admin.social-media.all', compact(
            'posts', 'stats', 'calendarPosts', 'calendarYear', 'calendarMonth'
        ));
    }

    /**
     * Per-program index
     */
    public function index(Request $request, string $program)
    {
        abort_unless(in_array($program, self::$validPrograms), 404);

        $query = SocialMediaPost::with('links')
            ->where('program', $program)
            ->where('is_archived', false);

        $this->applyFilters($query, $request);

        $posts = $query->orderBy('publish_date', 'asc')->orderBy('publish_time', 'asc')->paginate(25);

        $stats = $this->programStats($program);

        $programLabel = SocialMediaPost::programLabel($program);

        // Calendar data: scheduled/published this month
        $calendarYear  = $request->input('cal_year', now()->year);
        $calendarMonth = $request->input('cal_month', now()->month);

        $calendarPosts = SocialMediaPost::where('program', $program)
            ->where('is_archived', false)
            ->whereIn('status', ['scheduled', 'published'])
            ->whereYear('publish_date', $calendarYear)
            ->whereMonth('publish_date', $calendarMonth)
            ->select('id', 'title', 'platforms', 'status', 'publish_date', 'publish_time')
            ->get()
            ->groupBy(fn($p) => $p->publish_date->day);

        return view('admin.social-media.index', compact(
            'posts', 'stats', 'program', 'programLabel',
            'calendarPosts', 'calendarYear', 'calendarMonth'
        ));
    }

    /**
     * Store a new post
     */
    public function store(Request $request, string $program)
    {
        abort_unless(in_array($program, self::$validPrograms), 404);

        $validated = $this->validatePost($request);
        $validated['program'] = $program;

        $post = SocialMediaPost::create($validated);

        $this->syncLinks($post, $request->input('links', []));

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'post' => $post->load('links')]);
        }

        return back()->with('success', 'Post created successfully!');
    }

    /**
     * Show a single post (JSON for modal)
     */
    public function show(Request $request, string $program, int $id)
    {
        $post = SocialMediaPost::with('links')
            ->where('program', $program)
            ->findOrFail($id);

        return response()->json($post);
    }

    /**
     * Update a post
     */
    public function update(Request $request, string $program, int $id)
    {
        $post = SocialMediaPost::where('program', $program)->findOrFail($id);

        $validated = $this->validatePost($request);
        $post->update($validated);

        $this->syncLinks($post, $request->input('links', []));

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'post' => $post->fresh('links')]);
        }

        return back()->with('success', 'Post updated successfully!');
    }

    /**
     * Delete a post
     */
    public function destroy(Request $request, string $program, int $id)
    {
        $post = SocialMediaPost::where('program', $program)->findOrFail($id);
        $post->links()->delete();
        $post->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Post deleted.');
    }

    /**
     * Duplicate a post
     */
    public function duplicate(string $program, int $id)
    {
        $original = SocialMediaPost::with('links')->where('program', $program)->findOrFail($id);

        $new = $original->replicate();
        $new->title = $original->title . ' (Copy)';
        $new->status = 'draft';
        $new->publish_date = null;
        $new->checklist_caption = false;
        $new->checklist_design  = false;
        $new->checklist_video   = false;
        $new->checklist_review  = false;
        $new->checklist_publish = false;
        $new->save();

        foreach ($original->links as $link) {
            $new->links()->create($link->only(['type', 'url', 'description']));
        }

        return response()->json(['success' => true, 'post' => $new->load('links')]);
    }

    /**
     * Mark as published
     */
    public function markPublished(string $program, int $id)
    {
        $post = SocialMediaPost::where('program', $program)->findOrFail($id);
        $post->update(['status' => 'published', 'checklist_publish' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Update checklist item
     */
    public function updateChecklist(Request $request, string $program, int $id)
    {
        $post = SocialMediaPost::where('program', $program)->findOrFail($id);

        $field = $request->input('field');
        $value = $request->boolean('value');

        $allowed = ['checklist_caption', 'checklist_design', 'checklist_video', 'checklist_review', 'checklist_publish'];
        abort_unless(in_array($field, $allowed), 422);

        $post->update([$field => $value]);

        return response()->json([
            'success' => true,
            'percentage' => $post->fresh()->checklist_percentage,
        ]);
    }

    /**
     * Update manual statistics
     */
    public function updateStats(Request $request, string $program, int $id)
    {
        $post = SocialMediaPost::where('program', $program)->findOrFail($id);

        $post->update($request->only([
            'stat_views', 'stat_likes', 'stat_comments',
            'stat_shares', 'stat_clicks', 'stat_leads', 'stat_registrations',
        ]));

        return response()->json(['success' => true]);
    }

    /**
     * Archive a post
     */
    public function archive(string $program, int $id)
    {
        $post = SocialMediaPost::where('program', $program)->findOrFail($id);
        $post->update(['is_archived' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Export CSV
     */
    public function exportCsv(Request $request, string $program)
    {
        abort_unless(in_array($program, self::$validPrograms) || $program === 'all', 404);

        $query = SocialMediaPost::with('links')->where('is_archived', false);

        if ($program !== 'all') {
            $query->where('program', $program);
        }

        $this->applyFilters($query, $request);
        $posts = $query->orderBy('publish_date')->get();

        $filename = 'social-media-' . $program . '-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($posts) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID', 'Program', 'Title', 'Content Type', 'Platforms',
                'Status', 'Publish Date', 'Publish Time', 'Assigned To',
                'Reviewer', 'Caption', 'CTA', 'Hashtags', 'Notes',
                'Checklist %', 'Views', 'Likes', 'Comments', 'Shares', 'Clicks', 'Leads', 'Registrations',
            ]);

            foreach ($posts as $post) {
                fputcsv($handle, [
                    $post->id,
                    SocialMediaPost::programLabel($post->program),
                    $post->title,
                    $post->content_type,
                    implode(', ', $post->platforms ?? []),
                    $post->status,
                    $post->publish_date?->format('Y-m-d'),
                    $post->publish_time,
                    $post->assigned_to,
                    $post->reviewer,
                    $post->caption,
                    $post->cta,
                    $post->hashtags,
                    $post->notes,
                    $post->checklist_percentage . '%',
                    $post->stat_views,
                    $post->stat_likes,
                    $post->stat_comments,
                    $post->stat_shares,
                    $post->stat_clicks,
                    $post->stat_leads,
                    $post->stat_registrations,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ===========================
    // Private Helpers
    // ===========================

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('filter_program')) {
            $query->where('program', $request->filter_program);
        }
        if ($request->filled('filter_platform')) {
            $query->whereJsonContains('platforms', $request->filter_platform);
        }
        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }
        if ($request->filled('filter_content_type')) {
            $query->where('content_type', $request->filter_content_type);
        }
        if ($request->filled('filter_month')) {
            [$year, $month] = explode('-', $request->filter_month);
            $query->whereYear('publish_date', $year)->whereMonth('publish_date', $month);
        }
        if ($request->filled('filter_assigned')) {
            $query->where('assigned_to', 'like', '%' . $request->filter_assigned . '%');
        }
        if ($request->filled('search')) {
            $q = '%' . $request->search . '%';
            $query->where(fn($s) => $s->where('title', 'like', $q)->orWhere('caption', 'like', $q));
        }
    }

    private function programStats(string $program): array
    {
        $base = SocialMediaPost::where('program', $program)->where('is_archived', false);

        return [
            'total'       => (clone $base)->count(),
            'draft'       => (clone $base)->where('status', 'draft')->count(),
            'scheduled'   => (clone $base)->where('status', 'scheduled')->count(),
            'published'   => (clone $base)->where('status', 'published')->count(),
            'this_month'  => (clone $base)->whereMonth('publish_date', now()->month)->whereYear('publish_date', now()->year)->count(),
        ];
    }

    private function globalStats(): array
    {
        $base = SocialMediaPost::where('is_archived', false);

        return [
            'total'       => (clone $base)->count(),
            'draft'       => (clone $base)->where('status', 'draft')->count(),
            'scheduled'   => (clone $base)->where('status', 'scheduled')->count(),
            'published'   => (clone $base)->where('status', 'published')->count(),
            'this_month'  => (clone $base)->whereMonth('publish_date', now()->month)->whereYear('publish_date', now()->year)->count(),
        ];
    }

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'title'            => 'required|string|max:255',
            'content_type'     => 'required|string',
            'platforms'        => 'required|array|min:1',
            'platforms.*'      => 'string',
            'caption'          => 'nullable|string',
            'cta'              => 'nullable|string|max:500',
            'hashtags'         => 'nullable|string',
            'publish_date'     => 'nullable|date',
            'publish_time'     => 'nullable',
            'assigned_to'      => 'nullable|string|max:255',
            'reviewer'         => 'nullable|string|max:255',
            'status'           => 'required|in:draft,scheduled,published,cancelled',
            'notes'            => 'nullable|string',
            'checklist_caption' => 'boolean',
            'checklist_design'  => 'boolean',
            'checklist_video'   => 'boolean',
            'checklist_review'  => 'boolean',
            'checklist_publish' => 'boolean',
        ]);
    }

    private function syncLinks(SocialMediaPost $post, array $links): void
    {
        $post->links()->delete();

        foreach ($links as $link) {
            if (!empty($link['url'])) {
                $post->links()->create([
                    'type'        => $link['type'] ?? 'Other',
                    'url'         => $link['url'],
                    'description' => $link['description'] ?? null,
                ]);
            }
        }
    }
}
