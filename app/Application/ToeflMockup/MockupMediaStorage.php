<?php

namespace App\Application\ToeflMockup;

use Illuminate\Http\UploadedFile;
use RuntimeException;

class MockupMediaStorage
{
    public function ensurePublicDirectoryExists(string $relativePath): string
    {
        $publicPath = public_path($relativePath);

        if (!file_exists($publicPath) && !mkdir($publicPath, 0777, true) && !is_dir($publicPath)) {
            throw new RuntimeException('Failed to create directory: ' . $publicPath);
        }

        return $publicPath;
    }

    public function publicFilePath(string $directory, string $filename): string
    {
        return $this->ensurePublicDirectoryExists($directory) . '/' . $filename;
    }

    public function writePublicFile(string $directory, string $filename, string $content): string
    {
        $absolutePath = $this->publicFilePath($directory, $filename);
        file_put_contents($absolutePath, $content);

        return $absolutePath;
    }

    public function storeUploadedFileWithOriginalName(string $directory, UploadedFile $file, string $filenamePrefix = ''): string
    {
        $publicPath = $this->ensurePublicDirectoryExists($directory);
        $filename = $filenamePrefix . time() . '_' . $file->getClientOriginalName();
        $file->move($publicPath, $filename);

        return $directory . '/' . $filename;
    }

    public function storeUploadedFileWithExtension(string $directory, UploadedFile $file, string $filenamePrefix = 'audio', bool $appendTime = true): string
    {
        if (!$file->isValid()) {
            throw new RuntimeException('Uploaded file is invalid.');
        }

        $publicPath = $this->ensurePublicDirectoryExists($directory);
        $filename = $filenamePrefix . ($appendTime ? '_' . time() : '') . '.' . $file->getClientOriginalExtension();
        $file->move($publicPath, $filename);

        return $directory . '/' . $filename;
    }

    public function deletePublicFile(?string $relativePath): void
    {
        if (!$relativePath) {
            return;
        }

        $absolutePath = public_path($relativePath);
        if (file_exists($absolutePath)) {
            @unlink($absolutePath);
        }
    }

    public function deletePublicFileWithinPrefix(?string $relativePath, string $safeDirPrefix): void
    {
        if (!$relativePath) {
            return;
        }

        $normalizedPath = str_replace('\\', '/', $relativePath);
        if (!str_starts_with($normalizedPath, $safeDirPrefix)) {
            return;
        }

        $this->deletePublicFile($normalizedPath);
    }

    public function resolveSelectedAudioPath(?UploadedFile $audioFile, ?string $existingAudioPath, string $publicPath, string $directory, string $filenamePrefix): string
    {
        if ($audioFile !== null) {
            return $this->storeUploadedFileWithExtension($directory, $audioFile, $filenamePrefix);
        }

        $selectedPath = str_replace('\\', '/', trim((string) $existingAudioPath));
        $selectedPath = ltrim($selectedPath, '/');

        if ($selectedPath === '' || str_contains($selectedPath, '..')) {
            throw new RuntimeException('Invalid audio path selection.');
        }

        $sourceAbsolutePath = public_path($selectedPath);
        if (!file_exists($sourceAbsolutePath) || !is_file($sourceAbsolutePath)) {
            throw new RuntimeException('Selected source audio file was not found.');
        }

        return $selectedPath;
    }

    public function copySelectedToeflListeningAudio(string $existingAudioPath, string $publicPath, string $directory, string $filenamePrefix = 'audio'): string
    {
        $selectedPath = str_replace('\\', '/', trim($existingAudioPath));
        $selectedPath = ltrim($selectedPath, '/');

        if ($selectedPath === '' || str_contains($selectedPath, '..')) {
            throw new RuntimeException('Invalid audio path selection.');
        }

        if (!str_starts_with($selectedPath, 'audio/toefl/listening/')) {
            throw new RuntimeException('Selected audio must be from the TOEFL listening audio folder.');
        }

        $sourceAbsolutePath = public_path($selectedPath);
        if (!file_exists($sourceAbsolutePath) || !is_file($sourceAbsolutePath)) {
            throw new RuntimeException('Selected source audio file was not found.');
        }

        $ext = strtolower(pathinfo($sourceAbsolutePath, PATHINFO_EXTENSION));
        if (!in_array($ext, ['mp3', 'wav', 'ogg', 'm4a'], true)) {
            throw new RuntimeException('Unsupported source audio format.');
        }

        $safeBaseName = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($sourceAbsolutePath));
        $filename = $filenamePrefix . '_' . time() . '_' . $safeBaseName;

        if (!copy($sourceAbsolutePath, $publicPath . '/' . $filename)) {
            throw new RuntimeException('Failed to copy selected source audio.');
        }

        return $directory . '/' . $filename;
    }
}