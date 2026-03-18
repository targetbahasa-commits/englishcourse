<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

class GrammarWritingRecoverySeeder extends Seeder
{
    /**
     * Run grammar-writing recovery seeders for meetings that rely on DB content.
     */
    public function run(): void
    {
        $this->call([
            Meeting1And4RecoverySeeder::class,
            Meeting2Seeder::class,
            Meeting3Seeder::class,
            Meeting6MigrationSeeder::class,
            Meeting7MigrationSeeder::class,
            Meeting8MigrationSeeder::class,
        ]);

        // Meeting 5 uses a console command that seeds its full question/vocab set.
        Artisan::call('populate:meeting5');
        $this->command?->line(trim((string) Artisan::output()));

        $scripts = [
            'migrate_meeting9.php',
            'migrate_meeting10.php',
            'migrate_meeting10_paragraph.php',
            'migrate_meeting11.php',
            'migrate_meeting11_paragraph.php',
            'migrate_meeting12.php',
            'migrate_meeting13.php',
            'migrate_meeting14.php',
            'migrate_meeting15.php',
            'migrate_meeting16.php',
            'migrate_meeting17.php',
            'migrate_meeting18.php',
            'migrate_meeting19.php',
            'migrate_meeting20.php',
        ];

        foreach ($scripts as $script) {
            $this->runPhpScript($script);
        }
    }

    private function runPhpScript(string $relativePath): void
    {
        $process = new Process(['php', base_path($relativePath)]);
        $process->setTimeout(120);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException("Failed running {$relativePath}: " . $process->getErrorOutput());
        }

        $output = trim($process->getOutput());
        if ($output !== '') {
            $this->command?->line($output);
        }
    }
}
