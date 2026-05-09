    public function uploadToeflItpMockupAudio(Request $request, $package)
    {
        $user = Auth::user();

        // Check if user is admin or teacher
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:51200', // 50MB max
            'existing_audio_path' => 'nullable|string|max:500',
        ]);

        if (!$request->hasFile('audio_file') && !$request->filled('existing_audio_path')) {
            return redirect()->back()->with('error', 'Please upload a file or choose audio from folder.');
        }

        try {
            $questions = \App\Models\ToeflMockupQuestion::where('package_number', $package)->where('section', 'listening')->get();

            $directory = 'audio/toefl-itp/mockup/package-' . $package;
            $publicPath = $this->ensurePublicDirectoryExists($directory);

            $selectedPath = null;
            if ($request->hasFile('audio_file')) {
                $file = $request->file('audio_file');
                if (!$file || !$file->isValid()) {
                    return redirect()->back()->with('error', 'Uploaded file is invalid.');
                }

                $filename = 'audio_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($publicPath, $filename);
                $selectedPath = $directory . '/' . $filename;
            } else {
                $selectedPath = str_replace('\\', '/', trim((string) $request->input('existing_audio_path')));
                $selectedPath = ltrim($selectedPath, '/');

                if (str_contains($selectedPath, '..')) {
                    return redirect()->back()->with('error', 'Invalid audio path selection.');
                }
                
                $sourceAbsolutePath = public_path($selectedPath);
                if (!file_exists($sourceAbsolutePath) || !is_file($sourceAbsolutePath)) {
                    return redirect()->back()->with('error', 'Selected source audio file was not found.');
                }
            }

            if ($questions->isNotEmpty()) {
                \App\Models\ToeflMockupQuestion::where('package_number', $package)
                    ->where('section', 'listening')
                    ->update(['audio_file' => $selectedPath]);
            } else {
                return redirect()->back()->with('error', 'Listening questions not found for this mock test package.');
            }

            return redirect()->back()->with('success', 'Mockup audio uploaded successfully!');
        } catch (\Exception $e) {
            \Log::error('uploadToeflItpMockupAudio Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while uploading audio: ' . $e->getMessage());
        }
    }

    public function uploadToeflItpMockupSrt(Request $request, $package)
    {
        $user = Auth::user();

        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'srt_file' => 'nullable|file|mimes:txt,srt|max:2048',
            'srt_content' => 'nullable|string',
            'language' => 'required|in:en,id'
        ]);

        if (!$request->hasFile('srt_file') && !$request->filled('srt_content')) {
            return redirect()->back()->with('error', 'Please provide an SRT file or paste the content.');
        }

        try {
            $questions = \App\Models\ToeflMockupQuestion::where('package_number', $package)->where('section', 'listening')->get();

            if ($questions->isEmpty()) {
                return redirect()->back()->with('error', 'Listening questions not found for this mock test package.');
            }

            $content = '';
            if ($request->hasFile('srt_file')) {
                $content = file_get_contents($request->file('srt_file')->getRealPath());
            } else {
                $content = $request->input('srt_content');
            }

            $parsedData = (new \App\Http\Controllers\AssignmentController)->parseSrtContent($content);
            $jsonTranscript = json_encode($parsedData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            
            $updateField = $request->input('language') === 'id' ? 'transcript_id' : 'transcript_en';

            \App\Models\ToeflMockupQuestion::where('package_number', $package)
                ->where('section', 'listening')
                ->update([$updateField => $jsonTranscript]);

            return redirect()->back()->with('success', 'SRT transcript successfully parsed and saved as JSON!');
        } catch (\Exception $e) {
            \Log::error('uploadToeflItpMockupSrt Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing SRT: ' . $e->getMessage());
        }
    }

    public function updateToeflItpMockupTranscript(Request $request, $package)
    {
        $user = Auth::user();

        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'transcript_en' => 'nullable|string',
            'transcript_id' => 'nullable|string',
        ]);

        try {
            $questions = \App\Models\ToeflMockupQuestion::where('package_number', $package)->where('section', 'listening')->get();

            if ($questions->isEmpty()) {
                return redirect()->back()->with('error', 'Listening questions not found for this mock test package.');
            }

            \App\Models\ToeflMockupQuestion::where('package_number', $package)
                ->where('section', 'listening')
                ->update([
                    'transcript_en' => $request->input('transcript_en'),
                    'transcript_id' => $request->input('transcript_id'),
                ]);

            return redirect()->back()->with('success', 'Transcript saved successfully!');
        } catch (\Exception $e) {
            \Log::error('updateToeflItpMockupTranscript Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving transcripts: ' . $e->getMessage());
        }
    }
