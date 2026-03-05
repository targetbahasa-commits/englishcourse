<?php

use App\Models\IeltsWritingMeeting;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$id = 115;
$meeting = IeltsWritingMeeting::find($id);

if ($meeting) {
    echo "Updating Meeting {$id}: {$meeting->title}...\n";

    // 20 Collocations categorized by field
    $collocations = [
        // Economy / Business
        [
            "category" => "Economy & Business",
            "phrase" => "Economic growth",
            "meaning" => "An increase in the amount of goods and services produced per head of the population over a period of time.",
            "example" => "The government is implementing policies to stimulate economic growth."
        ],
        [
            "category" => "Economy & Business",
            "phrase" => "Disposable income",
            "meaning" => "Income remaining after deduction of taxes and other mandatory charges, available to be spent or saved as one wishes.",
            "example" => "With rising inflation, people have less disposable income for luxury items."
        ],
        [
            "category" => "Economy & Business",
            "phrase" => "Financial stability",
            "meaning" => "A state in which financial components are functioning effectively and can withstand shocks.",
            "example" => "Achieving financial stability is a primary goal for many young professionals."
        ],
        [
            "category" => "Economy & Business",
            "phrase" => "Job market",
            "meaning" => "The total number of vacant jobs that are open to be filled.",
            "example" => "The job market for software engineers remains very competitive."
        ],
        [
            "category" => "Economy & Business",
            "phrase" => "Cost-effective",
            "meaning" => "Effective or productive in relation to its cost.",
            "example" => "Solar panels are becoming a more cost-effective energy solution."
        ],

        // Culture & Society
        [
            "category" => "Culture & Society",
            "phrase" => "Cultural heritage",
            "meaning" => "The legacy of physical artifacts and intangible attributes of a group or society that are inherited from past generations.",
            "example" => "Preserving our cultural heritage is vital for national identity."
        ],
        [
            "category" => "Culture & Society",
            "phrase" => "Social cohesion",
            "meaning" => "The willingness of members of a society to cooperate with each other in order to survive and prosper.",
            "example" => "Community events can help strengthen social cohesion."
        ],
        [
            "category" => "Culture & Society",
            "phrase" => "Multicultural society",
            "meaning" => "A society that includes people with many different customs and beliefs.",
            "example" => "Living in a multicultural society exposes you to diverse perspectives."
        ],
        [
            "category" => "Culture & Society",
            "phrase" => "Public opinion",
            "meaning" => "The collective opinion of the people of a society or state on an issue or problem.",
            "example" => "Public opinion has shifted significantly regarding environmental protection."
        ],
        [
            "category" => "Culture & Society",
            "phrase" => "Standard of living",
            "meaning" => "The degree of wealth and material comfort available to a person or community.",
            "example" => "The standard of living in developed countries is generally higher."
        ],

        // Environment
        [
            "category" => "Environment",
            "phrase" => "Climate change",
            "meaning" => "A change in global or regional climate patterns, largely attributed to increased levels of atmospheric carbon dioxide.",
            "example" => "Climate change poses a serious threat to global biodiversity."
        ],
        [
            "category" => "Environment",
            "phrase" => "Sustainable development",
            "meaning" => "Economic development that is conducted without depletion of natural resources.",
            "example" => "Companies are increasingly adopting sustainable development practices."
        ],
        [
            "category" => "Environment",
            "phrase" => "Carbon footprint",
            "meaning" => "The amount of carbon dioxide and other carbon compounds emitted due to the consumption of fossil fuels by a particular person or group.",
            "example" => "We can reduce our carbon footprint by using public transport."
        ],
        [
            "category" => "Environment",
            "phrase" => "Natural resources",
            "meaning" => "Materials or substances such as minerals, forests, water, and fertile land that occur in nature and can be used for economic gain.",
            "example" => "The rapid depletion of natural resources is a major concern."
        ],
        [
            "category" => "Environment",
            "phrase" => "Renewable energy",
            "meaning" => "Energy from a source that is not depleted when used, such as wind or solar power.",
            "example" => "Investment in renewable energy is crucial for a greener future."
        ],

        // Technology / General
        [
            "category" => "Technology",
            "phrase" => "Technological advancement",
            "meaning" => "The generation of information or the discovery of knowledge that advances the understanding of technology.",
            "example" => "Rapid technological advancement has transformed the way we communicate."
        ],
        [
            "category" => "Technology",
            "phrase" => "Artificial intelligence",
            "meaning" => "The theory and development of computer systems able to perform tasks that normally require human intelligence.",
            "example" => "Artificial intelligence is revolutionizing the healthcare industry."
        ],
        [
            "category" => "Technology",
            "phrase" => "Digital age",
            "meaning" => "The time period starting in the 1970s with the introduction of the personal computer with subsequent technology introduced providing the ability to transfer information freely and quickly.",
            "example" => "In the digital age, access to information is easier than ever."
        ],
        [
            "category" => "General",
            "phrase" => "Key factor",
            "meaning" => "A very important fact or situation that influences a result.",
            "example" => "Education is a key factor in reducing poverty."
        ],
        [
            "category" => "General",
            "phrase" => "Integral part",
            "meaning" => "Essential or necessary for completeness.",
            "example" => "Trust is an integral part of any healthy relationship."
        ]
    ];

    try {
        // Keep existing idioms if any, or init empty array
        // We only want to update collocations
        $meeting->collocations = $collocations;
        $meeting->save();
        echo "Successfully updated collocations for Meeting {$id}.\n";
        echo "Count: " . count($collocations) . "\n";
    } catch (\Exception $e) {
        echo "Error saving meeting: " . $e->getMessage() . "\n";
    }

} else {
    echo "Meeting with ID $id not found.\n";
}
