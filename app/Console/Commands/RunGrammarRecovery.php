<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunGrammarRecovery extends Command
{
    /**
     * Run consolidated grammar writing recovery routines.
     */
    protected $signature = 'grammar:recovery {--no-seed : Skip db:seed execution and only show availability}';

    protected $description = 'Run consolidated Grammar for Writing recovery (meetings 1-20 coverage).';

    public function handle(): int
    {
        if ($this->option('no-seed')) {
            $this->info('grammar:recovery is available. Use without --no-seed to execute recovery.');
            return self::SUCCESS;
        }

        $this->info('Running GrammarWritingRecoverySeeder...');

        $exitCode = Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\GrammarWritingRecoverySeeder',
            '--force' => true,
        ]);

        $this->line(trim((string) Artisan::output()));

        if ($exitCode !== 0) {
            $this->error('Grammar recovery failed.');
            return self::FAILURE;
        }

        $this->info('Grammar recovery completed successfully.');
        return self::SUCCESS;
    }
}
