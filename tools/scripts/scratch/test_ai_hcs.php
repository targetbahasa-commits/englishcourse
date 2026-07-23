<?php
require __DIR__.'/../../../vendor/autoload.php';
$app = require_once __DIR__.'/../../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$support = $app->make(App\Application\IeltsWriting\IeltsWritingAiSupport::class);

$prompt = "Transcript:
We frequently encounter news stories about public emergencies where bystanders fail to intervene, often leading to accusations that modern society has become morally bankrupt or indifferent. While it is easy to label these witnesses as uncaring, social psychology offers a more nuanced concept known as the bystander effect. This phenomenon suggests that the presence of others actually inhibits helping behavior through a process called diffusion of responsibility. When a single individual witnesses an accident, they feel a direct burden to act. However, in a group, that sense of obligation is diluted; individuals frequently assume someone else—perhaps someone more qualified—will take charge. Additionally, in ambiguous situations, we look to those around us for guidance. If others appear calm or detached, we often collectively assume there is no real danger, creating a cycle of inaction. Thus, the failure to act is rarely due to a lack of compassion, but rather a complex reaction to the social dynamic of the crowd.

Generate 4 options for a multiple choice question where the student must select the best summary of the transcript.
1 option must be the correct summary.
3 options must be incorrect summaries or misinterpretations.
Make sure the options are concise (1-2 sentences each).

Return JSON format:
{
    \"correct_answer\": \"(the correct option text)\",
    \"options\": [
        \"option A\",
        \"option B\",
        \"option C\",
        \"option D\"
    ]
}
";

echo "Sending to AI...\n";
$json = $support->runJsonPrompt($prompt, 300, 4096, false, true);
print_r($json);
