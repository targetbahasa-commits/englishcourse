<?php

namespace App\Application\ToeflListeningPractice;

class ToeflListeningSourceAudioOptions
{
    public function handle(): array
    {
        $baseRelative = 'audio/toefl/listening';

        $candidatePaths = [
            public_path($baseRelative),
            base_path('public/' . $baseRelative),
        ];

        $baseAbsolute = null;
        foreach ($candidatePaths as $candidate) {
            if (is_dir($candidate)) {
                $baseAbsolute = $candidate;
                break;
            }
        }

        if (!$baseAbsolute) {
            return [];
        }

        $publicRoot = rtrim(str_replace('\\', '/', $baseAbsolute), '/');
        $publicRoot = substr($publicRoot, 0, -(strlen($baseRelative)));
        $publicRoot = rtrim(str_replace('\\', '/', $publicRoot), '/');

        $allowedExt = ['mp3', 'wav', 'ogg', 'm4a'];
        $options = [];

        try {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($baseAbsolute, \FilesystemIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if (!$file->isFile()) {
                    continue;
                }

                $ext = strtolower($file->getExtension());
                if (!in_array($ext, $allowedExt, true)) {
                    continue;
                }

                $absolutePath = str_replace('\\', '/', $file->getPathname());
                $relativePath = ltrim(substr($absolutePath, strlen($publicRoot)), '/');
                $label = str_replace('audio/toefl/listening/', '', $relativePath);

                $options[] = [
                    'value' => $relativePath,
                    'label' => $label,
                ];
            }
        } catch (\Throwable) {
            return [];
        }

        usort($options, fn (array $left, array $right) => strcmp($left['label'], $right['label']));

        return $options;
    }
}