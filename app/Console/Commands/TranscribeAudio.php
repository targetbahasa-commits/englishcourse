<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhisperService;

class TranscribeAudio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audio:transcribe
                            {audioPath : Path to audio file}
                            {--language=en : Language code (en, id, etc)}
                            {--format=srt : Output format (srt, vtt, json, txt)}
                            {--output= : Output file path (optional)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transcribe audio file using OpenAI Whisper';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $audioPath = $this->argument('audioPath');
        $language = $this->option('language');
        $format = $this->option('format');
        $outputFile = $this->option('output');

        if (!file_exists($audioPath)) {
            $this->error("Audio file not found: {$audioPath}");
            return 1;
        }

        try {
            $this->info("Transcribing {$audioPath} ({$language})...");
            
            $result = WhisperService::transcribe($audioPath, $language, $format);

            if ($outputFile) {
                file_put_contents($outputFile, $result);
                $this->info("Transcription saved to: {$outputFile}");
            } else {
                $this->line($result);
            }

            $this->info("Transcription completed!");
            return 0;
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }
    }
}
