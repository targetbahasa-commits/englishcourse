<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DirectMessage;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = collect();
        $inboxMessages = collect();
        $sentMessages = collect();

        if ($user->role === 'admin') {
            // Admin sees messages sent to general admin or specifically to them
            $inboxMessages = DirectMessage::with('sender')
                ->whereNull('receiver_id')
                ->orWhere('receiver_id', $user->id)
                ->latest()
                ->get();
                
            $sentMessages = DirectMessage::with('receiver')
                ->where('sender_id', $user->id)
                ->latest()
                ->get();
        } else {
            // Students and Teachers see broadcasts (notifications), replies from admin, and messages they sent
            $notifications = $user->notifications;
            
            $inboxMessages = DirectMessage::with('sender')
                ->where('receiver_id', $user->id)
                ->latest()
                ->get();
                
            $sentMessages = DirectMessage::with('receiver')
                ->where('sender_id', $user->id)
                ->latest()
                ->get();
        }

        return view('inbox.index', compact('user', 'notifications', 'inboxMessages', 'sentMessages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'receiver_id' => 'nullable|exists:users,id',
        ]);

        $user = Auth::user();
        
        // Ensure non-admins do not specify a receiver_id, forcing it to null (Admin inbox)
        $receiverId = $request->receiver_id;
        if ($user->role !== 'admin') {
            $receiverId = null;
        }

        DirectMessage::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'subject' => $request->subject,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully.');
    }

    public function markAsRead(Request $request, $id)
    {
        $type = $request->input('type');

        if ($type === 'notification') {
            $notification = Auth::user()->notifications()->find($id);
            if ($notification) {
                $notification->markAsRead();
            }
        } elseif ($type === 'direct') {
            $message = DirectMessage::find($id);
            // Verify permission
            if ($message && (
                $message->receiver_id == Auth::id() || 
                (Auth::user()->role === 'admin' && is_null($message->receiver_id))
            )) {
                $message->update(['read_at' => now()]);
            }
        }

        return redirect()->back();
    }
}
