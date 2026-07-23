<?php
require __DIR__.'/../../../vendor/autoload.php';
$app = require_once __DIR__.'/../../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use GuzzleHttp\Client;
use GuzzleHttp\Promise;

$hcs = require __DIR__.'/../../../config/pte_highlight_correct_summary.php';
$keys = \App\Services\AiProviderKeyManager::getKeys('openrouter');
if (empty($keys)) {
    $keys = \App\Services\AiProviderKeyManager::getKeys('gemini');
}

$client = new Client();
$promises = [];
$results = [];

$batchSize = 20;
$total = count($hcs);

for ($i = 0; $i < $total; $i += $batchSize) {
    echo "Processing batch " . ($i / $batchSize + 1) . " of " . ceil($total / $batchSize) . "\n";
    $batch = array_slice($hcs, $i, $batchSize, true);
    $promises = [];
    
    foreach ($batch as $index => $item) {
        $prompt = "Transcript:\n" . $item['transcript'] . "\n\nGenerate 4 options for a multiple choice question where the student must select the best summary of the transcript. 1 option must be the correct summary. 3 options must be incorrect summaries or misinterpretations. Make sure the options are concise (1-2 sentences each).\n\nReturn JSON format:\n{\n    \"correct_answer\": \"(the correct option text)\",\n    \"options\": [\n        \"option A\",\n        \"option B\",\n        \"option C\",\n        \"option D\"\n    ]\n}";
        
        $payload = [
            'model' => 'gemini-2.5-flash',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'response_format' => ['type' => 'json_object']
        ];
        
        $key = $keys[array_rand($keys)];
        
        $promises[$index] = $client->postAsync("https://generativelanguage.googleapis.com/v1beta/openai/chat/completions", [
            'headers' => [
                'Authorization' => 'Bearer ' . $key,
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
            'timeout' => 60
        ]);
    }
    
    $responses = Promise\Utils::settle($promises)->wait();
    
    foreach ($responses as $index => $response) {
        if ($response['state'] === 'fulfilled') {
            $body = $response['value']->getBody()->getContents();
            $data = json_decode($body, true);
            $content = $data['choices'][0]['message']['content'] ?? '';
            $json = json_decode($content, true);
            
            if ($json && isset($json['correct_answer']) && isset($json['options'])) {
                $hcs[$index]['correct_answer'] = $json['correct_answer'];
                $hcs[$index]['options'] = $json['options'];
            } else {
                echo "Failed to parse JSON for index $index\n";
            }
        } else {
            echo "Request failed for index $index: " . $response['reason']->getMessage() . "\n";
        }
    }
}

file_put_contents(__DIR__.'/../../../config/pte_highlight_correct_summary.php', "<?php\n\nreturn " . var_export($hcs, true) . ";\n");
echo "Done generating new HCS options!\n";
