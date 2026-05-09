<?php

namespace App\Http\Controllers;

use App\Application\Announcement\GetAnnouncementsForUser;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function __construct(
        private readonly GetAnnouncementsForUser $getAnnouncementsForUser,
    ) {
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.announcements.index');
        }

        $result = $this->getAnnouncementsForUser->handle($user, 15);

        return view('announcements.index', $result);
    }
}
