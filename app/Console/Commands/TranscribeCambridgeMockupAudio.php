<?php

namespace App\Console\Commands;

use App\Application\IeltsShared\ManageCambridgeMockupMaterial;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TranscribeCambridgeMockupAudio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cambridge:transcribe-audio
                            {edition : Cambridge edition number}
                            {test_id : Test ID (1-4)}
                            {part : Audio part (1-4)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Whisper transcription for a Cambridge Mockup audio file in the background';

    public function __construct(
        private readonly ManageCambridgeMockupMaterial $manageCambridgeMockupMaterial,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $edition = (int) $this->argument('edition');
        $testId  = (int) $this->argument('test_id');
        $part    = (int) $this->argument('part');

        $this->info("Starting Whisper transcription: Cambridge {$edition} Test {$testId} Part {$part}");

        try {
            $this->manageCambridgeMockupMaterial->transcribeExistingAudio($edition, $testId, $part);
            $this->info("Transcription completed successfully.");
            return Command::SUCCESS;
        } catch (\RuntimeException $e) {
            $this->error("Transcription failed: " . $e->getMessage());
            Log::error("cambridge:transcribe-audio failed [{$edition}/{$testId}/part{$part}]: " . $e->getMessage());
            return Command::FAILURE;
        } catch (\Exception $e) {
            $this->error("Unexpected error: " . $e->getMessage());
            Log::error("cambridge:transcribe-audio unexpected error [{$edition}/{$testId}/part{$part}]: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
