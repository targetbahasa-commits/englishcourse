<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\IeltsListeningMaterial;
use App\Models\IeltsListeningMockup;
use App\Models\IeltsSection;
use App\Models\ListeningBank;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminAudioLibraryController extends Controller
{
    /**
     * Get all used audio paths from the database.
     */
    private function getUsedAudioPaths()
    {
        $usedPaths = [];

        // 1. IeltsListeningMaterial
        $materials = IeltsListeningMaterial::whereNotNull('audio_file')->pluck('audio_file');
        foreach ($materials as $path) {
            $usedPaths[] = ltrim($path, '/');
        }

        // 2. IeltsListeningMockup
        $mockups = IeltsListeningMockup::select('audio_file_1', 'audio_file_2', 'audio_file_3', 'audio_file_4')->get();
        foreach ($mockups as $mockup) {
            if ($mockup->audio_file_1) $usedPaths[] = ltrim($mockup->audio_file_1, '/');
            if ($mockup->audio_file_2) $usedPaths[] = ltrim($mockup->audio_file_2, '/');
            if ($mockup->audio_file_3) $usedPaths[] = ltrim($mockup->audio_file_3, '/');
            if ($mockup->audio_file_4) $usedPaths[] = ltrim($mockup->audio_file_4, '/');
        }

        // 3. IeltsSection
        $sections = IeltsSection::whereNotNull('audio_file')->pluck('audio_file');
        foreach ($sections as $path) {
            $usedPaths[] = ltrim($path, '/');
        }

        // 4. ListeningBank (usually in storage, but just to be safe)
        $banks = ListeningBank::whereNotNull('audio')->pluck('audio');
        foreach ($banks as $path) {
            $usedPaths[] = ltrim($path, '/');
        }

        return array_unique($usedPaths);
    }

    /**
     * Scan public/audio directory for all audio files.
     */
    private function scanAudioFiles()
    {
        $audioDir = public_path('audio');
        $files = [];

        if (!File::exists($audioDir)) {
            return $files;
        }

        $allFiles = File::allFiles($audioDir);
        $allowedExtensions = ['mp3', 'wav', 'ogg', 'm4a'];

        foreach ($allFiles as $file) {
            if (in_array(strtolower($file->getExtension()), $allowedExtensions)) {
                // Get path relative to public folder, e.g., 'audio/ielts/...'
                $relativePath = 'audio/' . $file->getRelativePathname();
                $relativePath = str_replace('\\', '/', $relativePath); // normalize slashes

                $module = 'Lainnya';
                if (str_contains($relativePath, 'mockup')) $module = 'IELTS Mockup';
                elseif (str_contains($relativePath, 'ielts')) $module = 'IELTS';
                elseif (str_contains($relativePath, 'toefl')) $module = 'TOEFL';
                elseif (str_contains($relativePath, 'pte')) $module = 'PTE';

                $files[] = [
                    'name' => $file->getFilename(),
                    'path' => $relativePath,
                    'full_path' => $file->getPathname(),
                    'size' => $file->getSize(),
                    'modified_at' => $file->getMTime(),
                    'module' => $module,
                ];
            }
        }

        return $files;
    }

    public function index(Request $request)
    {
        $allFiles = $this->scanAudioFiles();
        $usedPaths = $this->getUsedAudioPaths();

        // Mark used/unused
        foreach ($allFiles as &$file) {
            $file['is_used'] = in_array($file['path'], $usedPaths);
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
        $page = $request->get('page', 1);
        $perPage = 15;
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

        if (in_array($path, $usedPaths)) {
            return back()->with('error', 'Gagal menghapus! File audio ini masih terhubung dengan soal/materi di database.');
        }

        $fullPath = public_path($path);

        // Protect directory traversal
        if (File::exists($fullPath) && str_starts_with(realpath($fullPath), realpath(public_path('audio')))) {
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
            if (in_array($file['path'], $usedPaths)) {
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
