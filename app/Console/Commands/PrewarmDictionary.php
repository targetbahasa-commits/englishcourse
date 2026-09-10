<?php

namespace App\Console\Commands;

use App\Application\Dictionary\ResolveWordTranslation;
use App\Models\GrammarQuestion;
use App\Models\ToeflDictionary;
use Illuminate\Console\Command;

/**
 * Bulk-translates the English vocabulary that actually appears across the
 * grammar-writing exercises (where the Dictionary tool is used almost
 * exclusively) and caches it in toefl_dictionaries ahead of time, so real
 * student lookups hit the fast local-DB path instead of a ~1s external API
 * round trip. Safe to re-run any time - already-cached words are always
 * skipped, so this can be run incrementally across multiple sessions/days
 * (useful if a translation provider's free-tier daily quota is a concern).
 */
class PrewarmDictionary extends Command
{
    protected $signature = 'dictionary:prewarm {--limit= : Max number of NEW words to fetch this run} {--delay=300 : Milliseconds to wait between API calls}';

    protected $description = 'Bulk-translate and cache grammar-writing vocabulary so live dictionary lookups are instant.';

    /**
     * Standard English stopwords (articles, pronouns, prepositions, common
     * auxiliary/modal verbs) - nobody looks these up in a dictionary, and
     * skipping them keeps the batch focused on words actually worth caching.
     */
    private const STOPWORDS = [
        'a', 'an', 'the', 'and', 'or', 'but', 'if', 'then', 'else', 'when',
        'at', 'by', 'for', 'with', 'about', 'against', 'between', 'into',
        'through', 'during', 'before', 'after', 'above', 'below', 'to',
        'from', 'up', 'down', 'in', 'out', 'on', 'off', 'over', 'under',
        'again', 'further', 'once', 'here', 'there', 'all', 'any', 'both',
        'each', 'few', 'more', 'most', 'other', 'some', 'such', 'no', 'nor',
        'not', 'only', 'own', 'same', 'so', 'than', 'too', 'very', 's', 't',
        'can', 'will', 'just', 'don', 'should', 'now', 'i', 'me', 'my',
        'myself', 'we', 'our', 'ours', 'ourselves', 'you', 'your', 'yours',
        'yourself', 'yourselves', 'he', 'him', 'his', 'himself', 'she',
        'her', 'hers', 'herself', 'it', 'its', 'itself', 'they', 'them',
        'their', 'theirs', 'themselves', 'what', 'which', 'who', 'whom',
        'this', 'that', 'these', 'those', 'am', 'is', 'are', 'was', 'were',
        'be', 'been', 'being', 'have', 'has', 'had', 'having', 'do', 'does',
        'did', 'doing', 'of', 'as', 'until', 'while', 'because',
    ];

    public function handle(ResolveWordTranslation $resolveWordTranslation): int
    {
        $this->info('Extracting distinct words from grammar_questions.correct_answer...');

        $words = $this->extractWords();
        $this->info(count($words) . ' distinct candidate words found.');

        $alreadyCached = ToeflDictionary::pluck('word')->flip();
        $toFetch = $words->reject(fn ($word) => $alreadyCached->has($word))->values();

        if ($limit = $this->option('limit')) {
            $toFetch = $toFetch->take((int) $limit);
        }

        $this->info(
            $toFetch->count() . ' words to fetch this run '
            . "(skipping {$alreadyCached->count()} already cached)."
        );

        if ($toFetch->isEmpty()) {
            $this->info('Nothing to do.');

            return self::SUCCESS;
        }

        $delayMicroseconds = (int) $this->option('delay') * 1000;
        $bar = $this->output->createProgressBar($toFetch->count());
        $bar->start();

        $success = 0;
        $failed = 0;

        foreach ($toFetch as $word) {
            try {
                $translation = $resolveWordTranslation->handle($word);

                if ($translation) {
                    ToeflDictionary::updateOrCreate(['word' => $word], ['translation' => $translation]);
                    $success++;
                } else {
                    $failed++;
                }
            } catch (\Throwable $e) {
                $failed++;
                $this->newLine();
                $this->warn("Failed on \"{$word}\": " . $e->getMessage());
            }

            $bar->advance();
            usleep($delayMicroseconds);
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Done. {$success} cached, {$failed} failed.");

        return self::SUCCESS;
    }

    private function extractWords(): \Illuminate\Support\Collection
    {
        $sentences = GrammarQuestion::whereNotNull('correct_answer')->pluck('correct_answer');

        $words = collect();
        foreach ($sentences as $sentence) {
            preg_match_all('/[a-zA-Z]+(?:-[a-zA-Z]+)*/', (string) $sentence, $matches);
            foreach ($matches[0] as $word) {
                $words->push(strtolower($word));
            }
        }

        return $words->unique()
            ->reject(fn ($word) => strlen($word) <= 2)
            ->reject(fn ($word) => in_array($word, self::STOPWORDS, true))
            ->values();
    }
}
