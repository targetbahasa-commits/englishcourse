<?php

namespace App\Http\Controllers;

use App\Application\Guest\RegisterGuestUser;
use App\Application\PlacementTest\FinalizePlacementTestAttempt;
use App\Application\PlacementTest\StartPlacementTestAttempt;
use App\Application\PlacementTest\SubmitPlacementSectionAnswers;
use App\Domain\Guest\Repositories\GuestUserRepository;
use App\Models\PlacementListeningBank;
use App\Models\PlacementReadingPassage;
use App\Models\PlacementSpeakingPrompt;
use App\Models\PlacementTestPackage;
use App\Models\PlacementTestResult;
use App\Models\PlacementWritingPrompt;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlacementTestController extends Controller
{
    private const SECTIONS = ['reading', 'listening', 'writing', 'speaking'];

    public function __construct(
        private readonly RegisterGuestUser $registerGuestUser,
        private readonly StartPlacementTestAttempt $startAttempt,
        private readonly SubmitPlacementSectionAnswers $submitAnswers,
        private readonly FinalizePlacementTestAttempt $finalizeAttempt,
    ) {
    }

    public function intro()
    {
        if (Auth::check()) {
            return redirect()->route('placement-test.section', ['section' => 'reading']);
        }

        $hasActivePackage = PlacementTestPackage::effectivelyActive()->exists();

        return view('placement-test.intro', compact('hasActivePackage'));
    }

    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('placement-test.section', ['section' => 'reading']);
        }

        if (!PlacementTestPackage::effectivelyActive()->exists()) {
            return redirect()->route('placement-test.intro')->with('error', 'Tes kompetensi belum tersedia saat ini. Silakan coba lagi nanti.');
        }

        return view('placement-test.register');
    }

    public function registerAndStart(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        try {
            $guestUserRepository = app(GuestUserRepository::class);
            $existing = $guestUserRepository->findByEmail($data['email']);

            if ($existing && $existing->role === 'student') {
                $quickGuest = $guestUserRepository->createQuickGuestUser([
                    'name' => $data['name'],
                    'phone_number' => $data['phone_number'],
                ]);
                Auth::login($quickGuest);
            } else {
                $result = $this->registerGuestUser->handle($data, Auth::user());
                Auth::login($result);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Pendaftaran gagal, email mungkin sudah digunakan.']);
        }

        return redirect()->route('placement-test.section', ['section' => 'reading']);
    }

    public function section(Request $request, string $section)
    {
        if (!in_array($section, self::SECTIONS, true)) {
            abort(404);
        }

        $result = $this->startAttempt->execute(Auth::id());

        if (!$result) {
            return redirect()->route('placement-test.intro')->with('error', 'Tes kompetensi belum tersedia saat ini. Silakan coba lagi nanti.');
        }

        if ($result->isCompleted()) {
            return redirect()->route('placement-test.result', $result);
        }

        $packageId = $result->placement_test_package_id;
        $data = compact('result', 'section');

        switch ($section) {
            case 'reading':
                $passages = PlacementReadingPassage::where('placement_test_package_id', $packageId)->where('status', 'ready')->with('questions')->orderBy('order')->get();
                if ($passages->sum(fn ($p) => $p->questions->count()) === 0) {
                    return $this->skipSection($result, 'listening');
                }
                return view('placement-test.section', $data + ['passages' => $passages]);

            case 'listening':
                $banks = PlacementListeningBank::where('placement_test_package_id', $packageId)->where('status', 'ready')->with('questions')->orderBy('order')->get();
                if ($banks->sum(fn ($b) => $b->questions->count()) === 0) {
                    return $this->skipSection($result, 'writing');
                }
                return view('placement-test.section', $data + ['banks' => $banks]);

            case 'writing':
                $prompt = PlacementWritingPrompt::where('placement_test_package_id', $packageId)->where('status', 'ready')->inRandomOrder()->first();
                if (!$prompt) {
                    return $this->skipSection($result, 'speaking');
                }
                return view('placement-test.section', $data + ['prompt' => $prompt]);

            case 'speaking':
                $prompt = PlacementSpeakingPrompt::where('placement_test_package_id', $packageId)->where('status', 'ready')->inRandomOrder()->first();
                if (!$prompt) {
                    $result = $this->finalizeAttempt->execute($result);
                    return redirect()->route('placement-test.result', $result);
                }
                return view('placement-test.section', $data + ['prompt' => $prompt]);
        }
    }

    private function skipSection(PlacementTestResult $result, string $next)
    {
        return redirect()->route('placement-test.section', ['section' => $next]);
    }

    public function submitSection(Request $request, string $section)
    {
        if (!in_array($section, self::SECTIONS, true)) {
            abort(404);
        }

        $result = $this->startAttempt->execute(Auth::id());

        if (!$result) {
            return redirect()->route('placement-test.intro')->with('error', 'Tes kompetensi belum tersedia saat ini. Silakan coba lagi nanti.');
        }

        if ($result->isCompleted()) {
            return redirect()->route('placement-test.result', $result);
        }

        switch ($section) {
            case 'reading':
                $answers = $request->validate(['answers' => 'required|array'])['answers'];
                $this->submitAnswers->submitReading($result, $answers);
                $next = 'listening';
                break;

            case 'listening':
                $answers = $request->validate(['answers' => 'required|array'])['answers'];
                $this->submitAnswers->submitListening($result, $answers);
                $next = 'writing';
                break;

            case 'writing':
                $data = $request->validate([
                    'prompt_id' => 'required|integer|exists:placement_writing_prompts,id',
                    'essay' => 'required|string|min:10',
                ]);
                $this->submitAnswers->submitWriting($result, (int) $data['prompt_id'], $data['essay']);
                $next = 'speaking';
                break;

            case 'speaking':
                $data = $request->validate([
                    'prompt_id' => 'required|integer|exists:placement_speaking_prompts,id',
                    'audio' => 'required|file|mimes:webm,mp3,wav,m4a,ogg|max:20480',
                ]);
                $audioPath = $request->file('audio')->store('placement-speaking-recordings', 'public');
                $this->submitAnswers->submitSpeaking($result, (int) $data['prompt_id'], $audioPath);
                $next = null;
                break;

            default:
                abort(404);
        }

        if ($next === null) {
            $result = $this->finalizeAttempt->execute($result);

            return redirect()->route('placement-test.result', $result);
        }

        return redirect()->route('placement-test.section', ['section' => $next]);
    }

    public function result(PlacementTestResult $result)
    {
        if ($result->user_id !== Auth::id()) {
            abort(403);
        }

        $recommendedPrograms = collect();
        if (!empty($result->recommended_program_ids)) {
            $recommendedPrograms = Program::whereIn('id', $result->recommended_program_ids)->get();
        }

        return view('placement-test.result', compact('result', 'recommendedPrograms'));
    }
}
