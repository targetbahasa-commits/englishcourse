<?php

namespace App\Http\Controllers\Admin;

use App\Application\OutreachMessage\ManageOutreachMessages;
use App\Http\Controllers\Controller;
use App\Models\OutreachMessage;
use Illuminate\Http\Request;

class OutreachMessageController extends Controller
{
    public function __construct(
        private readonly ManageOutreachMessages $useCase
    ) {}

    public function index()
    {
        $messages = $this->useCase->listAll(15);
        return view('admin.outreach-messages.index', compact('messages'));
    }

    public function create()
    {
        $programs = $this->useCase->getActiveProgramOptions();
        return view('admin.outreach-messages.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'test_type'       => 'required|string|max:255',
            'target_role'     => 'required|in:guest,student',
            'program_id'      => 'nullable|exists:programs,id',
            'min_score'       => 'required|numeric|min:0',
            'max_score'       => 'required|numeric|gte:min_score',
            'message_content' => 'required|string',
        ]);

        $this->useCase->create($validated);

        return redirect()->route('admin.outreach-messages.index')
            ->with('success', 'Outreach message created successfully.');
    }

    public function edit(OutreachMessage $outreachMessage)
    {
        $programs = $this->useCase->getActiveProgramOptions();
        return view('admin.outreach-messages.edit', compact('outreachMessage', 'programs'));
    }

    public function update(Request $request, OutreachMessage $outreachMessage)
    {
        $validated = $request->validate([
            'test_type'       => 'required|string|max:255',
            'target_role'     => 'required|in:guest,student',
            'program_id'      => 'nullable|exists:programs,id',
            'min_score'       => 'required|numeric|min:0',
            'max_score'       => 'required|numeric|gte:min_score',
            'message_content' => 'required|string',
        ]);

        $this->useCase->update($outreachMessage, $validated);

        return redirect()->route('admin.outreach-messages.index')
            ->with('success', 'Outreach message updated successfully.');
    }

    public function destroy(OutreachMessage $outreachMessage)
    {
        $this->useCase->delete($outreachMessage);
        return redirect()->route('admin.outreach-messages.index')
            ->with('success', 'Outreach message deleted successfully.');
    }
}
