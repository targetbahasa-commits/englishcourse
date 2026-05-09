<?php

namespace App\Http\Controllers;

use App\Application\Inbox\ManageInbox;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function __construct(
        private readonly ManageInbox $manageInbox,
    ) {
    }

    public function index()
    {
        $user = Auth::user();

        $notifications = DatabaseNotification::query()
            ->where('notifiable_type', get_class($user))
            ->where('notifiable_id', $user->id)
            ->latest()
            ->get();

        $messages = $this->manageInbox->getMessagesForUser($user);

        return view('inbox.index', array_merge(compact('user', 'notifications'), $messages));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject'     => 'required|string|max:255',
            'content'     => 'required|string',
            'receiver_id' => 'nullable|exists:users,id',
        ]);

        $this->manageInbox->send(Auth::user(), $request->only(['subject', 'content', 'receiver_id']));

        return redirect()->back()->with('success', 'Message sent successfully.');
    }

    public function markAsRead(Request $request, $id)
    {
        $type = $request->input('type');

        if ($type === 'notification') {
            $notification = DatabaseNotification::query()
                ->where('notifiable_type', get_class(Auth::user()))
                ->where('notifiable_id', Auth::id())
                ->find($id);
            if ($notification) {
                $notification->markAsRead();
            }
        } elseif ($type === 'direct') {
            $this->manageInbox->markDirectMessageAsRead((int) $id, Auth::user());
        }

        return redirect()->back();
    }
}
