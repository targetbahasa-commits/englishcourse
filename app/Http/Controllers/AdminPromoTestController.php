<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IeltsWritingMeeting;
use App\Models\IeltsSpeakingTopic;
use App\Models\ToeflListeningMeeting;
use App\Models\ToeflStructureMeeting;
use App\Models\ToeflReadingMeeting;

class AdminPromoTestController extends Controller
{
    public function previewWriting()
    {
        $submission = \Illuminate\Support\Facades\DB::table('free_test_submissions')->where('test_type', 'like', 'writing%')->latest('id')->first();
        if (!$submission) return back()->with('error', 'Belum ada submission Writing untuk dipreview.');
        $test_id = $submission->test_id ?? 1;
        return redirect()->route('promo.test.result', ['type' => $submission->test_type, 'id' => $test_id, 'submission_id' => $submission->id]);
    }

    public function previewSpeaking(\Illuminate\Http\Request $request)
    {
        $submission = \Illuminate\Support\Facades\DB::table('free_test_submissions')->where('test_type', 'like', 'speaking%')->latest('id')->first();
        if (!$submission) return back()->with('error', 'Belum ada submission Speaking untuk dipreview.');
        $test_id = $submission->test_id ?? 1;
        return redirect()->route('promo.test.result', ['type' => $submission->test_type, 'id' => $test_id, 'submission_id' => $submission->id] + $request->query());
    }

    public function previewToefl()
    {
        $result = \Illuminate\Support\Facades\DB::table('free_test_results')->latest('id')->first();
        if (!$result) return back()->with('error', 'Belum ada hasil evaluasi TOEFL untuk dipreview.');
        return redirect()->route('free-test.result', ['id' => $result->id]);
    }

    public function index()
    {
        $writingTests = IeltsWritingMeeting::where('category', 'practice')->where('title', 'NOT LIKE', '%General%')->orderBy('id', 'desc')->get();
        $writingGeneralTests = IeltsWritingMeeting::where('category', 'practice')->where('title', 'LIKE', '%General%')->orderBy('id', 'desc')->get();
        $speakingTests = IeltsSpeakingTopic::where('title', 'NOT LIKE', '%lesson%')->where('slug', 'NOT LIKE', '%lesson%')->orderBy('id', 'desc')->get();
        
        $toeflCondition = function($q) {
            $q->where('meeting_number', '>', 50)
              ->orWhere('title', 'LIKE', '%Paket%')
              ->orWhere('title', 'LIKE', '%Test%')
              ->orWhere('title', 'LIKE', '%Practice%')
              ->orWhere('title', 'LIKE', '%Mockup%');
        };

        $toeflListening = ToeflListeningMeeting::where($toeflCondition)->orderBy('id', 'desc')->get()->map(function($i){ $i->toefl_type = 'listening'; return $i; });
        $toeflStructure = ToeflStructureMeeting::where($toeflCondition)->orderBy('id', 'desc')->get()->map(function($i){ $i->toefl_type = 'structure'; return $i; });
        $toeflReading = ToeflReadingMeeting::where($toeflCondition)->orderBy('id', 'desc')->get()->map(function($i){ $i->toefl_type = 'reading'; return $i; });

        $listeningProgram = \App\Models\Program::where('slug', 'ielts-academic-listening')->first();
        $listeningTests = $listeningProgram ? \App\Models\Meeting::where('program_id', $listeningProgram->id)->orderBy('meeting_number')->get() : collect();

        $readingGeneralProgram = \App\Models\Program::where('slug', 'ielts-general')->first();
        $readingGeneralTests = $readingGeneralProgram ? \App\Models\Meeting::where('program_id', $readingGeneralProgram->id)->orderBy('meeting_number')->get() : collect();

        $readingAcademicProgram = \App\Models\Program::where('slug', 'ielts-academic-reading')->first();
        $readingAcademicTests = $readingAcademicProgram ? \App\Models\Meeting::where('program_id', $readingAcademicProgram->id)->orderBy('meeting_number')->get() : collect();

        $grammarPrograms = \App\Models\Program::where('slug', 'like', '%grammar%')->get();
        $grammarTests = \App\Models\Meeting::whereIn('program_id', $grammarPrograms->pluck('id'))->orderBy('program_id')->orderBy('meeting_number')->get();

        return view('admin.promo-tests.index', compact('writingTests', 'writingGeneralTests', 'speakingTests', 'toeflListening', 'toeflStructure', 'toeflReading', 'listeningTests', 'readingGeneralTests', 'readingAcademicTests', 'grammarTests'));
    }

    public function updateWriting(Request $request, $id)
    {
        $meeting = IeltsWritingMeeting::findOrFail($id);
        
        $meeting->update([
            'title' => $request->title ?: $meeting->title,
            'prompt' => $request->prompt ?: $meeting->prompt,
            'is_free_tier' => $request->has('is_free_tier'),
            'test_type' => $request->test_type,
            'system_prompt_override' => $request->system_prompt_override,
            'graph_data_json' => $request->graph_data_json,
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);

        return back()->with('success', 'Promo settings for Writing Test updated successfully.');
    }

    public function storeWriting(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'prompt' => 'required|string',
            'test_type' => 'required|string'
        ]);

        $maxMeetingNumber = IeltsWritingMeeting::max('meeting_number') ?? 0;

        IeltsWritingMeeting::create([
            'title' => $request->title,
            'prompt' => $request->prompt,
            'test_type' => $request->test_type,
            'task_type' => str_contains($request->test_type, 't2') ? 2 : 1,
            'category' => 'practice',
            'meeting_number' => $maxMeetingNumber + 1,
            'is_free_tier' => $request->has('is_free_tier'),
        ]);

        return back()->with('success', 'New Writing Test created successfully.');
    }

    public function destroyWriting($id)
    {
        IeltsWritingMeeting::findOrFail($id)->delete();
        return back()->with('success', 'Writing Test deleted successfully.');
    }

    public function updateSpeaking(Request $request, $id)
    {
        $topic = IeltsSpeakingTopic::findOrFail($id);
        
        $topic->update([
            'title' => $request->title ?: $topic->title,
            'questions' => $request->questions ?: $topic->questions,
            'is_free_tier' => $request->has('is_free_tier'),
            'test_type' => $request->test_type,
            'system_prompt_override' => $request->system_prompt_override,
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);

        return back()->with('success', 'Promo settings for Speaking Topic updated successfully.');
    }

    public function renderSpeaking($id)
    {
        $scriptPath = base_path('storage/app/scripts/batch_prerender_unified.py');
        $logPath = storage_path('logs/prerender.log');
        // Run in background using exec
        $command = "python3 " . escapeshellarg($scriptPath) . " " . escapeshellarg($id) . " >> " . escapeshellarg($logPath) . " 2>&1 &";
        exec($command);

        return back()->with('success', 'Rendering started in the background. It will take ~5-10 minutes. Please check the website later.');
    }

    public function updateColab(Request $request)
    {
        $request->validate(['colab_url' => 'nullable|url']);
        $path = base_path('.env');
        
        if (file_exists($path)) {
            $url = $request->colab_url ? rtrim($request->colab_url, '/') : '';
            $env = file_get_contents($path);
            
            if (str_contains($env, 'SADTALKER_API_URL=')) {
                $env = preg_replace('/^SADTALKER_API_URL=.*$/m', 'SADTALKER_API_URL=' . $url, $env);
            } else {
                $env .= "\nSADTALKER_API_URL=" . $url . "\n";
            }
            file_put_contents($path, $env);
        }

        return back()->with('success', 'Colab API Link updated successfully!');
    }

    public function storeSpeaking(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'questions' => 'required|string',
        ]);

        IeltsSpeakingTopic::create([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title) . '-' . time(),
            'questions' => $request->questions,
            'is_free_tier' => $request->has('is_free_tier'),
        ]);

        return back()->with('success', 'New Speaking Topic created successfully.');
    }

    public function destroySpeaking($id)
    {
        IeltsSpeakingTopic::findOrFail($id)->delete();
        return back()->with('success', 'Speaking Topic deleted successfully.');
    }

    public function updateListening(Request $request, $id)
    {
        $meeting = \App\Models\Meeting::findOrFail($id);
        $meeting->update([
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for IELTS Listening updated successfully.');
    }

    public function updateGrammar(Request $request, $id)
    {
        $meeting = \App\Models\Meeting::findOrFail($id);
        $meeting->update([
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for Grammar Test updated successfully.');
    }

    public function updateReadingGeneral(Request $request, $id)
    {
        $meeting = \App\Models\Meeting::findOrFail($id);
        $meeting->update([
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for IELTS Reading General updated successfully.');
    }

    public function updateReadingAcademic(Request $request, $id)
    {
        $meeting = \App\Models\Meeting::findOrFail($id);
        $meeting->update([
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for IELTS Reading Academic updated successfully.');
    }

    public function updateToeflListening(Request $request, $id)
    {
        $meeting = ToeflListeningMeeting::findOrFail($id);
        $meeting->update([
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for TOEFL Listening updated successfully.');
    }

    public function updateToeflStructure(Request $request, $id)
    {
        $meeting = ToeflStructureMeeting::findOrFail($id);
        $meeting->update([
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for TOEFL Structure updated successfully.');
    }

    public function updateToeflReading(Request $request, $id)
    {
        $meeting = ToeflReadingMeeting::findOrFail($id);
        $meeting->update([
            'title' => $request->title ?: $meeting->title,
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for TOEFL Reading updated successfully.');
    }

    public function bulkUpdate(Request $request)
    {
        $tests = $request->tests;
        $action = $request->action;

        if (!$tests || !is_array($tests) || count($tests) === 0) {
            return back()->with('error', 'No tests selected.');
        }

        $is_free_tier = $action === 'activate' ? 1 : 0;

        foreach ($tests as $test) {
            $id = $test['id'] ?? null;
            $type = $test['type'] ?? null;
            if (!$id || !$type) continue;

            switch ($type) {
                case 'writing':
                case 'writing_general':
                    IeltsWritingMeeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'speaking':
                    IeltsSpeakingTopic::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'ielts_listening':
                    \App\Models\Meeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'ielts_reading_general':
                    \App\Models\Meeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'ielts_reading_academic':
                    \App\Models\Meeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'toefl_listening':
                    ToeflListeningMeeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'toefl_structure':
                    ToeflStructureMeeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'toefl_reading':
                    ToeflReadingMeeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
            }
        }

        return back()->with('success', 'Bulk ' . $action . ' applied successfully.');
    }
}
