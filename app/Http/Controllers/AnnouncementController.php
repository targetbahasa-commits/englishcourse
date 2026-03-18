<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $hasAnnouncementReadsTable = Schema::hasTable('announcement_user_reads');

        if ($user->isAdmin()) {
            return redirect()->route('admin.announcements.index');
        }

        $announcements = Announcement::query()
            ->active()
            ->visibleTo($user)
            ->latest()
            ->paginate(15);

        $visibleIds = $announcements->getCollection()->pluck('id');
        $justReadIds = $visibleIds->isEmpty()
            ? collect()
            : $user->unreadAnnouncements()
                ->whereIn('announcements.id', $visibleIds)
                ->pluck('announcements.id');

        $allUnreadIds = $user->unreadAnnouncements()->pluck('announcements.id');

        if ($hasAnnouncementReadsTable && $allUnreadIds->isNotEmpty()) {
            $timestamp = now();

            DB::table('announcement_user_reads')->upsert(
                $allUnreadIds->map(fn ($announcementId) => [
                    'announcement_id' => $announcementId,
                    'user_id' => $user->id,
                    'read_at' => $timestamp,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ])->all(),
                ['announcement_id', 'user_id'],
                ['read_at', 'updated_at']
            );
        }

        return view('announcements.index', [
            'announcements' => $announcements,
            'justReadIds' => $justReadIds->map(fn ($id) => (int) $id)->all(),
        ]);
    }
}
