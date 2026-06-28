<?php

namespace App\Http\Controllers;

use App\Application\IeltsSpeaking\ManageIeltsSpeakingTopics;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\RequiresAdminAccess;
use Illuminate\Http\Request;

class IeltsSpeakingAdminController extends Controller
{
    use HandlesAssignmentAccess, RequiresAdminAccess;

    public function __construct(
        private readonly ManageIeltsSpeakingTopics $manageIeltsSpeakingTopics,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function toggleLock(int $id)
    {
        $this->requireAdmin();

        $isLocked = $this->manageIeltsSpeakingTopics->toggleLock($id);
        $newLabel = $isLocked ? 'LOCKED' : 'OPEN';

        return back()
            ->with('success', 'Speaking topic is now ' . $newLabel . '.')
            ->with('success_state', $isLocked ? 'locked' : 'open');
    }

    public function storeTopic(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:ielts_speaking_topics,slug',
            'icon' => 'required|string',
            'color' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
            'is_free_tier' => 'boolean',
            'test_type' => 'nullable|string|max:50',
            'system_prompt_override' => 'nullable|string',
        ]);

        $this->manageIeltsSpeakingTopics->create($validated);

        return back()->with('success', 'Speaking topic created successfully.');
    }

    public function updateTopic(Request $request, int $id)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:ielts_speaking_topics,slug,' . $id,
            'icon' => 'required|string',
            'color' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
            'is_free_tier' => 'boolean',
            'test_type' => 'nullable|string|max:50',
            'system_prompt_override' => 'nullable|string',
        ]);

        $this->manageIeltsSpeakingTopics->update($id, $validated);

        return back()->with('success', 'Speaking topic updated successfully.');
    }

    public function updateContent(Request $request, int $id)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'questions' => 'nullable|array',
            'questions.*' => 'nullable|string',
            'idioms' => 'nullable|array',
            'collocations' => 'nullable|array',
            'advanced_verbs' => 'nullable|array',
            'advanced_adverbs' => 'nullable|array',
            'advanced_adjectives' => 'nullable|array',
            'part3_questions' => 'nullable|array',
            'part3_idioms' => 'nullable|array',
            'part3_collocations' => 'nullable|array',
        ]);

        $topic = \App\Models\IeltsSpeakingTopic::findOrFail($id);
        
        $dataToUpdate = [];
        if (isset($validated['questions'])) {
            $dataToUpdate['questions'] = array_values(array_filter($validated['questions'], 'trim'));
        }
        
        $vocabFields = ['idioms', 'collocations', 'advanced_verbs', 'advanced_adverbs', 'advanced_adjectives', 'part3_questions', 'part3_idioms', 'part3_collocations'];
        foreach ($vocabFields as $field) {
            if ($request->has($field)) {
                // Filter out empty rows (where phrase is empty, or for part3_questions where string is empty)
                if ($field === 'part3_questions') {
                    $dataToUpdate[$field] = array_values(array_filter($validated[$field], 'trim'));
                } else {
                    $dataToUpdate[$field] = array_values(array_filter($validated[$field], function($item) {
                        return !empty($item['phrase']);
                    }));
                }
            }
        }

        $topic->update($dataToUpdate);

        return back()->with('success', 'Speaking content updated successfully.');
    }

    public function destroyTopic(int $id)
    {
        $this->requireAdmin();

        $this->manageIeltsSpeakingTopics->destroy($id);

        return back()->with('success', 'Speaking topic deleted successfully.');
    }
}