<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BroadcastMessage;
use App\Models\User;
use App\Notifications\BroadcastInboxNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BroadcastMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = BroadcastMessage::latest()->paginate(15);
        return view('admin.broadcast-messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.broadcast-messages.create');
    }

    /**
     * Store and dispatch the broadcast message.
     */
    public function store(Request $request, \App\Services\WhatsApp\WhatsAppGatewayInterface $whatsapp)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_role' => 'required|in:all,student,teacher',
        ]);

        $sendViaEmail = $request->has('send_via_email');
        $sendViaWhatsapp = $request->has('send_via_whatsapp');
        $sendViaInbox = $request->has('send_via_inbox');

        if (!$sendViaEmail && !$sendViaWhatsapp && !$sendViaInbox) {
            return back()->withInput()->withErrors(['channels' => 'Please select at least one delivery channel.']);
        }

        // Create the record
        $broadcast = BroadcastMessage::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'target_role' => $validated['target_role'],
            'send_via_email' => $sendViaEmail,
            'send_via_whatsapp' => $sendViaWhatsapp,
            'send_via_inbox' => $sendViaInbox,
            'status' => 'processing',
        ]);

        // Get recipients
        $query = User::query();
        if ($validated['target_role'] !== 'all') {
            $query->where('role', $validated['target_role']);
        }
        $users = $query->get();
        $broadcast->update(['recipients_count' => $users->count()]);

        // Dispatch
        foreach ($users as $user) {
            // 1. Inbox (Database Notification) & Email
            if ($sendViaInbox || $sendViaEmail) {
                $user->notify(new BroadcastInboxNotification($broadcast));
            }

            // 2. WhatsApp
            if ($sendViaWhatsapp && !empty($user->phone_number)) {
                $whatsapp->sendMessage($user->phone_number, '*' . $broadcast->title . "*\n\n" . $broadcast->content);
            }
        }

        $broadcast->update(['status' => 'completed']);

        return redirect()->route('admin.broadcast-messages.index')
            ->with('success', 'Broadcast message has been dispatched successfully to ' . $users->count() . ' users.');
    }
}
