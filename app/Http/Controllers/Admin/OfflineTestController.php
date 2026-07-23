<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfflineTestResult;
use App\Models\OfflineTestCertificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfflineTestController extends Controller
{
    public function index(Request $request)
    {
        $query = OfflineTestResult::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('program', 'like', "%{$search}%")
                  ->orWhere('batch', 'like', "%{$search}%");
            });
        }

        if ($request->has('test_type') && $request->input('test_type') !== '') {
            $query->where('test_type', $request->input('test_type'));
        }

        $results = $query->latest()->paginate(20)->withQueryString();

        $testTypes = [
            'toefl_itp' => 'TOEFL ITP',
            'ielts_academic' => 'IELTS Academic',
            'ielts_general' => 'IELTS General Training'
        ];

        return view('admin.offline-tests.index', compact('results', 'testTypes'));
    }

    public function create()
    {
        $testTypes = [
            'toefl_itp' => 'TOEFL ITP',
            'ielts_academic' => 'IELTS Academic',
            'ielts_general' => 'IELTS General Training'
        ];
        return view('admin.offline-tests.create', compact('testTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'test_type' => 'required|string',
            'name' => 'required|string|max:255',
            'program' => 'nullable|string|max:255',
            'batch' => 'nullable|string|max:255',
            'score' => 'required|numeric',
        ]);

        // Attempt to find user to get email
        $user = User::where('name', 'like', "%{$validated['name']}%")
            ->where(function($q) use ($validated) {
                if ($validated['program']) {
                    $q->whereHas('programAccesses', function($q2) use ($validated) {
                        $q2->whereHas('program', function($q3) use ($validated) {
                            $q3->where('name', 'like', "%{$validated['program']}%");
                        });
                    });
                }
            })
            ->first();

        $email = $user ? $user->email : $request->input('email');
        if (!$email) {
            return back()->withInput()->with('error', 'User email could not be found automatically. Please provide an email or ensure the name is correct.');
        }

        $result = OfflineTestResult::create([
            'user_id' => $user ? $user->id : null,
            'name' => $validated['name'],
            'email' => $email,
            'program' => $validated['program'],
            'batch' => $validated['batch'],
            'test_type' => $validated['test_type'],
            'score' => $validated['score'],
        ]);

        // Send certificate
        $this->generateAndSendCertificate($result);

        return redirect()->route('offline-tests.index')->with('success', 'Test result saved and certificate sent successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'test_type' => 'required|string',
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $testType = $request->input('test_type');
        $file = $request->file('file');
        
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle); // Skip header

        $count = 0;
        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                // Expected format: Name, Program, Batch, Score, Email (optional)
                if (count($row) >= 4) {
                    $name = trim($row[0]);
                    $program = trim($row[1]);
                    $batch = trim($row[2]);
                    $score = floatval($row[3]);
                    $email = isset($row[4]) ? trim($row[4]) : null;

                    if (empty($name)) continue;

                    if (!$email) {
                        $user = User::where('name', 'like', "%{$name}%")->first();
                        $email = $user ? $user->email : null;
                    }

                    if ($email) {
                        $result = OfflineTestResult::create([
                            'user_id' => isset($user) && $user ? $user->id : null,
                            'name' => $name,
                            'email' => $email,
                            'program' => $program,
                            'batch' => $batch,
                            'test_type' => $testType,
                            'score' => $score,
                        ]);
                        $this->generateAndSendCertificate($result);
                        $count++;
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error during import: ' . $e->getMessage());
        } finally {
            fclose($handle);
        }

        return redirect()->route('offline-tests.index')->with('success', "{$count} test results imported and certificates sent successfully.");
    }

    public function resendCertificate($id)
    {
        $result = OfflineTestResult::findOrFail($id);
        if (!$result->email) {
            return back()->with('error', 'No email address found for this result.');
        }

        $this->generateAndSendCertificate($result);

        return back()->with('success', 'Certificate resent successfully to ' . $result->email);
    }

    public function destroy($id)
    {
        $result = OfflineTestResult::findOrFail($id);
        $result->delete();
        return back()->with('success', 'Offline test result deleted successfully.');
    }

    private function generateAndSendCertificate(OfflineTestResult $result)
    {
        $certificate = OfflineTestCertificate::where('test_type', $result->test_type)->first();
        if (!$certificate || !$certificate->is_active) {
            return;
        }

        \App\Jobs\SendOfflineTestCertificateEmailJob::dispatch($result->id);
    }
}
