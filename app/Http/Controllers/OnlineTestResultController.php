<?php

namespace App\Http\Controllers;

use App\Application\OnlineTest\OnlineTestCatalog;
use App\Application\OnlineTest\StoreOnlineTestResult;
use App\Models\OnlineTestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineTestResultController extends Controller
{
    public function __construct(
        private readonly OnlineTestCatalog $catalog,
        private readonly StoreOnlineTestResult $storeOnlineTestResult,
    ) {
    }

    public function start(string $slug)
    {
        $test = $this->catalog->getEnabledTestBySlug($slug);

        if ($test === null) {
            abort(404);
        }

        $attempt = $this->storeOnlineTestResult->start(Auth::user(), $test);

        return redirect()
            ->route('online-test.exam', ['slug' => $slug, 'onlineTestResult' => $attempt->id])
            ->with('success', 'Ujian dimulai. Silakan kerjakan sesuai alokasi waktu.');
    }

    public function submit(Request $request, string $slug, OnlineTestResult $onlineTestResult)
    {
        $test = $this->catalog->getTestBySlug($slug);

        if ($test === null) {
            abort(404);
        }

        if ((string) $onlineTestResult->test_slug !== $slug || (int) $onlineTestResult->user_id !== (int) Auth::id()) {
            abort(403);
        }

        if ($onlineTestResult->status === 'completed') {
            return redirect()->route('online-test.result', ['slug' => $slug, 'onlineTestResult' => $onlineTestResult->id]);
        }

        $validated = $request->validate([
            'answers' => ['nullable', 'array'],
            'answers.*' => ['nullable', 'string', 'max:5000'],
            'time_spent_seconds' => ['nullable', 'integer', 'min:0'],
        ]);

        $this->storeOnlineTestResult->submit(
            $onlineTestResult,
            $test,
            $validated['answers'] ?? [],
            isset($validated['time_spent_seconds']) ? (int) $validated['time_spent_seconds'] : null
        );

        return redirect()->route('online-test.result', ['slug' => $slug, 'onlineTestResult' => $onlineTestResult->id]);
    }
}
