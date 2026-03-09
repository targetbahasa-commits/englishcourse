<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\FreeTestResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the scholarships.
     */
    public function index()
    {
        $scholarships = Scholarship::latest()->paginate(10);
        return view('admin.scholarships.index', compact('scholarships'));
    }

    /**
     * Show the form for creating a new scholarship.
     */
    public function create()
    {
        return view('admin.scholarships.create');
    }

    /**
     * Store a newly created scholarship in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'level_of_study' => 'required|string|max:255',
            'opening_date' => 'nullable|date',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'requires_certification' => 'boolean',
            'country' => 'nullable|string|max:255',
            'min_ielts' => 'nullable|numeric|min:0|max:9',
            'min_toefl' => 'nullable|integer|min:0|max:677',
            'benefits' => 'required|string',
            'deadline' => 'required|date',
            'apply_link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $scholarship = new Scholarship($validated);
        $scholarship->is_active = $request->boolean('is_active', true);
        $scholarship->requires_certification = $request->boolean('requires_certification', true);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('scholarships', 'public');
            $scholarship->image_path = $imagePath;
        }

        $scholarship->save();

        return redirect()->route('admin.scholarships.index')
                         ->with('success', 'Scholarship created successfully.');
    }

    /**
     * Show the form for editing the specified scholarship.
     */
    public function edit(Scholarship $scholarship)
    {
        return view('admin.scholarships.edit', compact('scholarship'));
    }

    /**
     * Update the specified scholarship in storage.
     */
    public function update(Request $request, Scholarship $scholarship)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'level_of_study' => 'required|string|max:255',
            'opening_date' => 'nullable|date',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'requires_certification' => 'boolean',
            'country' => 'nullable|string|max:255',
            'min_ielts' => 'nullable|numeric|min:0|max:9',
            'min_toefl' => 'nullable|integer|min:0|max:677',
            'benefits' => 'required|string',
            'deadline' => 'required|date',
            'apply_link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $scholarship->fill($validated);
        $scholarship->is_active = $request->boolean('is_active', false);
        $scholarship->requires_certification = $request->boolean('requires_certification', false);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($scholarship->image_path) {
                Storage::disk('public')->delete($scholarship->image_path);
            }
            $imagePath = $request->file('image')->store('scholarships', 'public');
            $scholarship->image_path = $imagePath;
        }

        $scholarship->save();

        return redirect()->route('admin.scholarships.index')
                         ->with('success', 'Scholarship updated successfully.');
    }

    /**
     * Remove the specified scholarship from storage.
     */
    public function destroy(Scholarship $scholarship)
    {
        if ($scholarship->image_path) {
            Storage::disk('public')->delete($scholarship->image_path);
        }
        
        $scholarship->delete();

        return redirect()->route('admin.scholarships.index')
                         ->with('success', 'Scholarship deleted successfully.');
    }

    /**
     * Show the CSV bulk import form.
     */
    public function importForm()
    {
        return view('admin.scholarships.import');
    }

    /**
     * Process the uploaded CSV and bulk-insert scholarships.
     */
    public function importProcess(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        // Read and skip the header row
        $header = fgetcsv($handle);

        $imported = 0;
        $errors   = [];

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 8) {
                $errors[] = 'Skipped a row with insufficient columns.';
                continue;
            }

            // Expected CSV columns (in order):
            // title, provider, location, level_of_study, deadline, apply_link, min_ielts, min_toefl
            // Optional extra columns: country, description, requirements, benefits
            [$title, $provider, $location, $level_of_study, $deadline, $apply_link, $min_ielts, $min_toefl] = $row;

            $country      = $row[8]  ?? null;
            $description  = $row[9]  ?? 'Imported via CSV – please update the description.';
            $requirements = $row[10] ?? 'See official website for requirements.';
            $benefits     = $row[11] ?? 'See official website for benefits.';

            if (empty($title) || empty($deadline) || empty($apply_link)) {
                $errors[] = "Skipped row: title='{$title}' – missing required fields.";
                continue;
            }

            try {
                Scholarship::create([
                    'title'          => trim($title),
                    'provider'       => trim($provider),
                    'location'       => trim($location),
                    'level_of_study' => trim($level_of_study),
                    'deadline'       => date('Y-m-d', strtotime(trim($deadline))),
                    'apply_link'     => trim($apply_link),
                    'min_ielts'      => is_numeric(trim($min_ielts)) ? (float) trim($min_ielts) : null,
                    'min_toefl'      => is_numeric(trim($min_toefl)) ? (int) trim($min_toefl) : null,
                    'country'        => trim($country) ?: null,
                    'description'    => trim($description),
                    'requirements'   => trim($requirements),
                    'benefits'       => trim($benefits),
                    'is_active'      => true,
                    'requires_certification' => (!empty($min_ielts) || !empty($min_toefl)),
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Failed to import '{$title}': " . $e->getMessage();
            }
        }

        fclose($handle);

        $message = "Successfully imported {$imported} scholarship(s).";
        if ($errors) {
            $message .= ' Skipped ' . count($errors) . ' row(s) with issues.';
        }

        return redirect()->route('admin.scholarships.index')->with('success', $message);
    }

    /**
     * Smart Match: find students whose best IELTS or TOEFL score meets the scholarship requirement.
     */
    public function smartMatch(Scholarship $scholarship)
    {
        // For each user who has at least one free test result, get their best relevant score.
        $hasIelts = $scholarship->min_ielts !== null;
        $hasToefl = $scholarship->min_toefl !== null;

        // Build a list of user_ids that qualify
        $eligibleIelts = collect();
        $eligibleToefl = collect();

        if ($hasIelts) {
            // IELTS test_type examples: 'ielts_academic', 'ielts_general'
            $eligibleIelts = FreeTestResult::whereIn('test_type', ['ielts_academic', 'ielts_general', 'ielts'])
                ->select('user_id', DB::raw('MAX(score) as best_score'))
                ->groupBy('user_id')
                ->having('best_score', '>=', $scholarship->min_ielts)
                ->with('user')
                ->get();
        }

        if ($hasToefl) {
            // TOEFL test_type examples: 'toefl_itp', 'toefl'
            $eligibleToefl = FreeTestResult::whereIn('test_type', ['toefl_itp', 'toefl'])
                ->select('user_id', DB::raw('MAX(score) as best_score'))
                ->groupBy('user_id')
                ->having('best_score', '>=', $scholarship->min_toefl)
                ->with('user')
                ->get();
        }

        // Merge and de-duplicate by user_id, keeping highest score representation
        $allUserIds = $eligibleIelts->pluck('user_id')
            ->merge($eligibleToefl->pluck('user_id'))
            ->unique();

        $matchedUsers = User::whereIn('id', $allUserIds)->get()->map(function ($user) use ($eligibleIelts, $eligibleToefl) {
            $ieltsEntry = $eligibleIelts->firstWhere('user_id', $user->id);
            $toeflEntry = $eligibleToefl->firstWhere('user_id', $user->id);
            $user->best_ielts = $ieltsEntry ? $ieltsEntry->best_score : null;
            $user->best_toefl = $toeflEntry ? $toeflEntry->best_score : null;
            return $user;
        });

        return view('admin.scholarships.match', compact('scholarship', 'matchedUsers'));
    }
}

