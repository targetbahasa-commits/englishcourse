<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateIeltsSpeakingTopicsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ielts:migrate-speaking-topics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate hardcoded IELTS Speaking topics to the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration of Part 1 topics...');
        $part1Topics = app(\App\Application\IeltsSpeaking\BuildIeltsSpeakingPart1Topics::class)->handle();
        foreach ($part1Topics as $topicData) {
            \App\Models\IeltsSpeakingTopic::updateOrCreate(
                ['slug' => $topicData['slug']],
                array_merge($topicData, ['part' => 1])
            );
        }

        $this->info('Starting migration of Part 2 & 3 topics...');
        $part2Topics = app(\App\Application\IeltsSpeaking\BuildIeltsSpeakingPart2Topics::class)->handle();
        foreach ($part2Topics as $topicData) {
            \App\Models\IeltsSpeakingTopic::updateOrCreate(
                ['slug' => $topicData['slug']],
                array_merge($topicData, ['part' => 2])
            );
        }

        $this->info('Migration completed successfully.');
    }
}
