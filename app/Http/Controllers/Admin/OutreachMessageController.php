<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OutreachMessage;
use Illuminate\Http\Request;

class OutreachMessageController extends Controller
{
    public function index()
    {
        $messages = OutreachMessage::latest()->paginate(15);
        return view('admin.outreach-messages.index', compact('messages'));
    }

    public function create()
    {
        return view('admin.outreach-messages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'test_type' => 'required|string|max:255',
            'target_role' => 'required|in:guest,student',
            'min_score' => 'required|numeric|min:0',
            'max_score' => 'required|numeric|gte:min_score',
            'message_content' => 'required|string',
        ]);

        OutreachMessage::create($validated);

        return redirect()->route('admin.outreach-messages.index')
            ->with('success', 'Outreach message created successfully.');
    }

    public function edit(OutreachMessage $outreachMessage)
    {
        return view('admin.outreach-messages.edit', compact('outreachMessage'));
    }

    public function update(Request $request, OutreachMessage $outreachMessage)
    {
        $validated = $request->validate([
            'test_type' => 'required|string|max:255',
            'target_role' => 'required|in:guest,student',
            'min_score' => 'required|numeric|min:0',
            'max_score' => 'required|numeric|gte:min_score',
            'message_content' => 'required|string',
        ]);

        $outreachMessage->update($validated);

        return redirect()->route('admin.outreach-messages.index')
            ->with('success', 'Outreach message updated successfully.');
    }

    public function destroy(OutreachMessage $outreachMessage)
    {
        $outreachMessage->delete();
        return redirect()->route('admin.outreach-messages.index')
            ->with('success', 'Outreach message deleted successfully.');
    }
}
