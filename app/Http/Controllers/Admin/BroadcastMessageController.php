<?php

namespace App\Http\Controllers\Admin;

use App\Application\Broadcast\DispatchBroadcast;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BroadcastMessageController extends Controller
{
    public function __construct(
        private readonly DispatchBroadcast $dispatchBroadcast
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = $this->dispatchBroadcast->listAll(15);
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_role' => 'required|in:all,student,teacher,lead',
        ]);

        $sendViaEmail = $request->has('send_via_email');
        $sendViaWhatsapp = $request->has('send_via_whatsapp');
        $sendViaInbox = $request->has('send_via_inbox');

        if (!$sendViaEmail && !$sendViaWhatsapp && !$sendViaInbox) {
            return back()->withInput()->withErrors(['channels' => 'Please select at least one delivery channel.']);
        }

        $broadcast = $this->dispatchBroadcast->create(
            $validated,
            $sendViaEmail,
            $sendViaWhatsapp,
            $sendViaInbox
        );

        return redirect()->route('admin.broadcast-messages.index')
            ->with('success', 'Broadcast message has been dispatched successfully to ' . $broadcast->recipients_count . ' users.');
    }
}
