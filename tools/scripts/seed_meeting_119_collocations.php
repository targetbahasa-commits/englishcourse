<?php

use App\Models\IeltsWritingMeeting;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$id = 119;
$meeting = IeltsWritingMeeting::find($id);

if ($meeting) {
    echo "Updating Meeting {$id}: {$meeting->title}...\n";

    $idioms = [
        [
            "phrase" => "hustle and bustle",
            "meaning" => "Busy and noisy activity, typical of a city.",
            "example" => "She moved to the countryside to escape the hustle and bustle of London."
        ],
        [
            "phrase" => "peace and quiet",
            "meaning" => "A state of calm and silence, usually associated with rural areas.",
            "example" => "We went to the mountains to enjoy some peace and quiet."
        ],
        [
            "phrase" => "rat race",
            "meaning" => "A way of life in which people are caught up in a fiercely competitive struggle for wealth or power.",
            "example" => "He decided to quit the rat race and become a farmer."
        ],
        [
            "phrase" => "close to nature",
            "meaning" => "Living in an environment surrounded by natural elements like trees and animals.",
            "example" => "Growing up in a village allowed me to be close to nature."
        ],
        [
            "phrase" => "concrete jungle",
            "meaning" => "A modern city or urban area, especially when perceived as unpleasant or dominating.",
            "example" => "New York can feel like a concrete jungle sometimes."
        ]
    ];

    $collocations = [
        [
            "word" => "Urban",
            "meaning" => "Relating to a city or town.",
            "example" => "Urban development has increased significantly in the last decade."
        ],
        [
            "phrase" => "Rural area",
            "meaning" => "A geographic area that is located outside towns and cities.",
            "example" => "Access to healthcare can be a challenge in some rural areas."
        ],
        [
            "phrase" => "Cost of living",
            "meaning" => "The level of prices relating to a range of everyday items.",
            "example" => "The cost of living in the city is much higher than in the countryside."
        ],
        [
            "phrase" => "Traffic congestion",
            "meaning" => "A condition on transport networks that occurs as use increases, characterized by slower speeds.",
            "example" => "Traffic congestion is a major issue for city commuters."
        ],
        [
            "phrase" => "Sense of community",
            "meaning" => "A feeling that members have of belonging, a feeling that members matter to one another.",
            "example" => "Small towns often have a stronger sense of community than large cities."
        ]
    ];

    try {
        $meeting->idioms = $idioms;
        $meeting->collocations = $collocations;
        $meeting->save();
        echo "Successfully updated idioms and collocations.\n";
    } catch (\Exception $e) {
        echo "Error saving meeting: " . $e->getMessage() . "\n";
    }

} else {
    echo "Meeting with ID $id not found.\n";
}
