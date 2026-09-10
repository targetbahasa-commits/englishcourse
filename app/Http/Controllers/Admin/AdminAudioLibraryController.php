<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\IeltsListeningMaterial;
use App\Models\IeltsListeningMockup;
use App\Models\IeltsSection;
use App\Models\ListeningBank;
use App\Models\ToeflListeningQuestion;
use App\Models\ToeflMockupQuestion;
use App\Models\ToeflMockupListeningDirectionAudio;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminAudioLibraryController extends Controller
{
    /**
     * Get all used audio paths from all database tables and config files across IELTS, PTE, and TOEFL.
     */
    private function getUsedAudioPaths()
    {
        $usedPaths = [];

        // 1. IeltsListeningMaterial
        try {
            if (Schema::hasTable('ielts_listening_materials') && Schema::hasColumn('ielts_listening_materials', 'audio_file')) {
                $materials = IeltsListeningMaterial::whereNotNull('audio_file')->pluck('audio_file');
                foreach ($materials as $path) {
                    if ($path) $usedPaths[] = $this->normalizePath($path);
                }
            }
        } catch (\Throwable $e) {}

        // 2. IeltsListeningMockup
        try {
            if (Schema::hasTable('ielts_listening_mockups')) {
                $mockups = IeltsListeningMockup::all();
                foreach ($mockups as $mockup) {
                    if (!empty($mockup->audio_file_1)) $usedPaths[] = $this->normalizePath($mockup->audio_file_1);
                    if (!empty($mockup->audio_file_2)) $usedPaths[] = $this->normalizePath($mockup->audio_file_2);
                    if (!empty($mockup->audio_file_3)) $usedPaths[] = $this->normalizePath($mockup->audio_file_3);
                    if (!empty($mockup->audio_file_4)) $usedPaths[] = $this->normalizePath($mockup->audio_file_4);
                }
            }
        } catch (\Throwable $e) {}

        // 3. IeltsSection
        try {
            if (Schema::hasTable('ielts_sections') && Schema::hasColumn('ielts_sections', 'audio_file')) {
                $sections = IeltsSection::whereNotNull('audio_file')->pluck('audio_file');
                foreach ($sections as $path) {
                    if ($path) $usedPaths[] = $this->normalizePath($path);
                }
            }
        } catch (\Throwable $e) {}

        // 4. ListeningBank
        try {
            if (Schema::hasTable('listening_banks') && Schema::hasColumn('listening_banks', 'audio')) {
                $banks = ListeningBank::whereNotNull('audio')->pluck('audio');
                foreach ($banks as $path) {
                    if ($path) $usedPaths[] = $this->normalizePath($path);
                }
            }
        } catch (\Throwable $e) {}

        // 5. ToeflListeningQuestion
        try {
            if (Schema::hasTable('toefl_listening_questions') && Schema::hasColumn('toefl_listening_questions', 'audio_file')) {
                $toeflQ = ToeflListeningQuestion::whereNotNull('audio_file')->pluck('audio_file');
                foreach ($toeflQ as $path) {
                    if ($path) $usedPaths[] = $this->normalizePath($path);
                }
            }
        } catch (\Throwable $e) {}

        // 6. ToeflMockupQuestion
        try {
            if (Schema::hasTable('toefl_mockup_questions') && Schema::hasColumn('toefl_mockup_questions', 'audio_file')) {
                $toeflMQ = ToeflMockupQuestion::whereNotNull('audio_file')->pluck('audio_file');
                foreach ($toeflMQ as $path) {
                    if ($path) $usedPaths[] = $this->normalizePath($path);
                }
            }
        } catch (\Throwable $e) {}

        // 7. ToeflMockupListeningDirectionAudio
        try {
            if (Schema::hasTable('toefl_mockup_listening_direction_audios')) {
                $toeflDir = ToeflMockupListeningDirectionAudio::all();
                foreach ($toeflDir as $item) {
                    if (!empty($item->audio_part_a)) $usedPaths[] = $this->normalizePath($item->audio_part_a);
                    if (!empty($item->audio_part_b)) $usedPaths[] = $this->normalizePath($item->audio_part_b);
                    if (!empty($item->audio_part_c)) $usedPaths[] = $this->normalizePath($item->audio_part_c);
                }
            }
        } catch (\Throwable $e) {}

        // 8. Generic scan for any table containing audio/sound columns
        try {
            $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
            foreach ($tables as $table) {
                $columns = Schema::getColumnListing($table);
                foreach ($columns as $col) {
                    if (str_contains($col, 'audio') || str_contains($col, 'sound') || str_contains($col, 'mp3') || str_contains($col, 'voice')) {
                        try {
                            $rows = DB::table($table)->whereNotNull($col)->where($col, '!=', '')->pluck($col);
                            foreach ($rows as $r) {
                                if (is_string($r) && (str_contains($r, '.mp3') || str_contains($r, '.wav') || str_contains($r, '.ogg') || str_contains($r, '.m4a'))) {
                                    $usedPaths[] = $this->normalizePath($r);
                                }
                            }
                        } catch (\Exception $e) {
                            // ignore individual query error
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // ignore doctrine error
        }

        return array_unique(array_filter($usedPaths));
    }

    /**
     * Helper to normalize path for matching.
     */
    private function normalizePath($path)
    {
        $path = str_replace('\\', '/', $path);
        $path = ltrim($path, '/');
        // Remove leading http/https domain if present
        if (preg_match('#^https?://[^/]+/(.*)$#i', $path, $m)) {
            $path = $m[1];
        }
        return $path;
    }

    /**
     * Scan public directory, base audio directory, and storage directory for all audio files across IELTS, PTE, and TOEFL.
     */
    private function scanAudioFiles()
    {
        $audioExtensions = ['mp3', 'wav', 'ogg', 'm4a', 'aac', 'flac'];
        $scannedFiles = [];
        $seenPaths = [];

        // Directories to scan:
        $scanRoots = [
            'public' => public_path(),
            'audio_root' => base_path('audio'),
            'storage_public' => storage_path('app/public'),
        ];

        foreach ($scanRoots as $rootKey => $dir) {
            if (!File::exists($dir)) {
                continue;
            }

            try {
                $allFiles = File::allFiles($dir);
                foreach ($allFiles as $file) {
                    $ext = strtolower($file->getExtension());
                    if (in_array($ext, $audioExtensions)) {
                        $fullPath = $file->getPathname();
                        if (isset($seenPaths[$fullPath])) {
                            continue;
                        }
                        $seenPaths[$fullPath] = true;

                        // Calculate relative path for web access
                        $relativePath = '';
                        if (str_starts_with($fullPath, public_path())) {
                            $relativePath = ltrim(substr($fullPath, strlen(public_path())), '/\\');
                        } elseif (str_starts_with($fullPath, storage_path('app/public'))) {
                            $relativePath = 'storage/' . ltrim(substr($fullPath, strlen(storage_path('app/public'))), '/\\');
                        } elseif (str_starts_with($fullPath, base_path())) {
                            $relativePath = ltrim(substr($fullPath, strlen(base_path())), '/\\');
                        }

                        $relativePath = str_replace('\\', '/', $relativePath);

                        // Classify module
                        $module = 'Lainnya';
                        $lowerPath = strtolower($relativePath);
                        if (str_contains($lowerPath, 'pte')) {
                            $module = 'PTE Academic';
                        } elseif (str_contains($lowerPath, 'mockup')) {
                            $module = 'IELTS Mockup';
                        } elseif (str_contains($lowerPath, 'ielts')) {
                            $module = 'IELTS';
                        } elseif (str_contains($lowerPath, 'toefl')) {
                            $module = 'TOEFL ITP';
                        } elseif (str_contains($lowerPath, 'kokoro') || str_contains($lowerPath, 'tts') || str_contains($lowerPath, 'piper')) {
                            $module = 'AI Voice / TTS';
                        }

                        $scannedFiles[] = [
                            'name' => $file->getFilename(),
                            'path' => $relativePath,
                            'full_path' => $fullPath,
                            'size' => $file->getSize(),
                            'modified_at' => $file->getMTime(),
                            'module' => $module,
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Ignore scanner error for single folder
            }
        }

        return $scannedFiles;
    }

    public function index(Request $request)
    {
        $allFiles = $this->scanAudioFiles();
        $usedPaths = $this->getUsedAudioPaths();

        // Mark used/unused
        foreach ($allFiles as &$file) {
            $isUsed = false;
            foreach ($usedPaths as $used) {
                if ($file['path'] === $used || str_ends_with($file['path'], $used) || str_ends_with($used, $file['path'])) {
                    $isUsed = true;
                    break;
                }
            }
            $file['is_used'] = $isUsed;
        }
        unset($file);

        // Apply filters
        $filteredFiles = collect($allFiles);

        if ($request->filled('module')) {
            $filteredFiles = $filteredFiles->where('module', $request->module);
        }

        if ($request->filled('status')) {
            $isUsed = $request->status === 'used';
            $filteredFiles = $filteredFiles->where('is_used', $isUsed);
        }

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $filteredFiles = $filteredFiles->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['name']), $search) || str_contains(strtolower($item['path']), $search);
            });
        }

        // Sort by modified desc
        $filteredFiles = $filteredFiles->sortByDesc('modified_at')->values();

        // Calculate stats
        $stats = [
            'total_files' => count($allFiles),
            'total_size' => collect($allFiles)->sum('size'),
            'used_count' => collect($allFiles)->where('is_used', true)->count(),
            'orphaned_count' => collect($allFiles)->where('is_used', false)->count(),
        ];

        // Manual pagination
        $page = (int)$request->get('page', 1);
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $paginatedFiles = new LengthAwarePaginator(
            $filteredFiles->slice($offset, $perPage)->values(),
            $filteredFiles->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.audio-library.index', compact('paginatedFiles', 'stats'));
    }

    public function destroy(Request $request)
    {
        $path = $request->input('path');
        
        if (!$path) {
            return back()->with('error', 'Path audio tidak valid.');
        }

        $usedPaths = $this->getUsedAudioPaths();

        foreach ($usedPaths as $used) {
            if ($path === $used || str_ends_with($path, $used) || str_ends_with($used, $path)) {
                return back()->with('error', 'Gagal menghapus! File audio ini masih terhubung dengan soal/materi di database.');
            }
        }

        $fullPath = public_path($path);
        if (!File::exists($fullPath)) {
            $fullPath = base_path($path);
        }

        if (File::exists($fullPath)) {
            File::delete($fullPath);
            return back()->with('success', 'File audio berhasil dihapus.');
        }

        return back()->with('error', 'File tidak ditemukan di server.');
    }

    public function stats()
    {
        $allFiles = $this->scanAudioFiles();
        $usedPaths = $this->getUsedAudioPaths();

        $usedCount = 0;
        $totalSize = 0;

        foreach ($allFiles as $file) {
            $totalSize += $file['size'];
            $isUsed = false;
            foreach ($usedPaths as $used) {
                if ($file['path'] === $used || str_ends_with($file['path'], $used) || str_ends_with($used, $file['path'])) {
                    $isUsed = true;
                    break;
                }
            }
            if ($isUsed) {
                $usedCount++;
            }
        }

        return response()->json([
            'total_files' => count($allFiles),
            'total_size_mb' => round($totalSize / 1048576, 2),
            'used_count' => $usedCount,
            'orphaned_count' => count($allFiles) - $usedCount,
        ]);
    }
}
