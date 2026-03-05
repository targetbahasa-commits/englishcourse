<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Exception;

class WhisperService
{
    /**
     * Transcribe audio file using OpenAI Whisper
     *
     * @param string $audioPath Path to audio file
     * @param string $language Language code (e.g., 'en', 'id')
     * @param string $outputFormat Output format (txt, vtt, srt, json)
     * @return array|string Transcription result
     */
    public static function transcribe($audioPath, $language = 'en', $outputFormat = 'srt')
    {
        if (!file_exists($audioPath)) {
            throw new Exception("Audio file not found: {$audioPath}");
        }

        // Create temp directory for output
        $tempDir = sys_get_temp_dir() . '/whisper_' . uniqid();
        if (!mkdir($tempDir, 0755, true) && !is_dir($tempDir)) {
            throw new Exception("Failed to create temp directory: {$tempDir}");
        }

        try {
            // Build whisper command
            $command = [
                'whisper',
                $audioPath,
                '--model', 'base', // Options: tiny, base, small, medium, large
                '--language', $language,
                '--output_format', $outputFormat,
                '--output_dir', $tempDir,
                '--fp16', 'false', // Disable for better compatibility
            ];

            $process = new Process($command);
            $process->setTimeout(300); // 5 minutes timeout
            $process->run();

            if (!$process->isSuccessful()) {
                throw new Exception("Whisper transcription failed: " . $process->getErrorOutput());
            }

            // Get output file
            $audioFileName = pathinfo($audioPath, PATHINFO_FILENAME);
            $outputFile = $tempDir . '/' . $audioFileName . '.' . $outputFormat;

            if (!file_exists($outputFile)) {
                throw new Exception("Transcription output file not found: {$outputFile}");
            }

            // Read output
            $result = file_get_contents($outputFile);

            // Clean up
            self::deleteDirectory($tempDir);

            return $result;
        } catch (Exception $e) {
            // Clean up on error
            if (is_dir($tempDir)) {
                self::deleteDirectory($tempDir);
            }
            throw $e;
        }
    }

    /**
     * Transcribe and save as SRT subtitle file
     *
     * @param string $audioPath Path to audio file
     * @param string $language Language code
     * @return string SRT content
     */
    public static function transcribeToSRT($audioPath, $language = 'en')
    {
        return self::transcribe($audioPath, $language, 'srt');
    }

    /**
     * Transcribe and save as VTT subtitle file
     *
     * @param string $audioPath Path to audio file
     * @param string $language Language code
     * @return string VTT content
     */
    public static function transcribeToVTT($audioPath, $language = 'en')
    {
        return self::transcribe($audioPath, $language, 'vtt');
    }

    /**
     * Transcribe and get JSON result
     *
     * @param string $audioPath Path to audio file
     * @param string $language Language code
     * @return array Parsed JSON result
     */
    public static function transcribeToJSON($audioPath, $language = 'en')
    {
        $json = self::transcribe($audioPath, $language, 'json');
        return json_decode($json, true);
    }

    /**
     * Recursively delete directory
     *
     * @param string $dir Directory path
     * @return bool
     */
    private static function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return true;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                self::deleteDirectory($path);
            } else {
                @unlink($path);
            }
        }
        return @rmdir($dir);
    }
}
