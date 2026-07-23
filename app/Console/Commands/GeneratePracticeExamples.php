<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GrammarTopic;
use App\Models\GrammarTopicQuestion;
use Illuminate\Support\Facades\Http;

class GeneratePracticeExamples extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'practice:generate-examples';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate unique examples for all grammar practice questions using Gemini API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            $this->error('GEMINI_API_KEY not found in .env');
            return;
        }

        $topics = GrammarTopic::all();

        foreach ($topics as $topic) {
            $this->info("Processing Topic: {$topic->title}");
            
            $questions = GrammarTopicQuestion::where('grammar_topic_id', $topic->id)
                                             ->where('type', 'sentence')
                                             ->orderBy('id')
                                             ->get();
            
            if ($questions->isEmpty()) {
                continue;
            }

            // To avoid the next-question problem, we generate unique examples for all of them at once.
            $prompt = "You are an English teacher. I have a list of {$questions->count()} Indonesian practice questions for the grammar topic '{$topic->title}'.\n";
            $prompt .= "For EACH question, generate a UNIQUE example sentence that uses the EXACT SAME grammatical structure but DIFFERENT vocabulary. The example should be related to the same grammar rule but distinct from the question and distinct from each other.\n\n";
            $prompt .= "Return ONLY a JSON array of objects. Each object must have exactly two keys: 'id' (Indonesian translation) and 'en' (English translation). The array must have exactly {$questions->count()} items, strictly corresponding to the order of the questions below.\n\n";
            
            foreach ($questions as $index => $q) {
                $qText = strip_tags($q->question_id);
                $prompt .= ($index + 1) . ". {$qText}\n";
            }

            $maxRetries = 5;
            $retryCount = 0;
            $success = false;
            
            while ($retryCount < $maxRetries && !$success) {
                $this->info("Generating examples for {$questions->count()} questions... (Attempt " . ($retryCount + 1) . ")");

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'response_mime_type' => 'application/json',
                    ]
                ]);

                if ($response->failed()) {
                    if ($response->status() === 429) {
                        $this->warn("Rate limit hit for topic {$topic->title}. Retrying in 15 seconds...");
                        sleep(15);
                        $retryCount++;
                        continue;
                    } else {
                        $this->error("Failed API call for topic {$topic->title}: " . $response->body());
                        break;
                    }
                }

                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                
                if (!$text) {
                    $this->error("No text generated for topic {$topic->title}");
                    break;
                }

                $examples = json_decode($text, true);

                if (!is_array($examples) || count($examples) < $questions->count()) {
                    $this->error("Invalid JSON response or mismatch count for topic {$topic->title}");
                    break;
                }

                foreach ($questions as $index => $q) {
                    if (isset($examples[$index])) {
                        $q->example = [
                            'id' => $examples[$index]['id'],
                            'en' => $examples[$index]['en']
                        ];
                        $q->save();
                    }
                }
                
                $this->info("Saved examples for topic {$topic->title}\n");
                $success = true;
                
                // Brief pause to avoid rate limits on the next one
                sleep(6);
            }
            
            if (!$success) {
                $this->error("Failed to process topic {$topic->title} after $maxRetries retries.");
            }
        }

        $this->info('All examples generated and updated successfully!');
    }
}
