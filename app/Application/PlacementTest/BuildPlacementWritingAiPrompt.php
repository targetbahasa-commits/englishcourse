<?php

namespace App\Application\PlacementTest;

class BuildPlacementWritingAiPrompt
{
    public function build(string $promptText, string $essay): string
    {
        return <<<PROMPT
You are an expert English language assessor. Assess the following essay written in response to a prompt, and estimate the writer's CEFR level (A1, A2, B1, B2, C1, or C2).

Prompt given to the writer:
"{$promptText}"

Essay:
"{$essay}"

Score the essay on a 0-100 scale for each of these criteria:
- task_achievement: how well the essay addresses the prompt
- coherence_cohesion: organization and logical flow
- vocabulary: range and accuracy of vocabulary
- grammar: grammatical range and accuracy

Then estimate an overall CEFR level for this writing sample.

Respond with ONLY valid JSON in this exact shape:
{
  "scores": {
    "task_achievement": <0-100>,
    "coherence_cohesion": <0-100>,
    "vocabulary": <0-100>,
    "grammar": <0-100>
  },
  "cefr_estimate": "<A1|A2|B1|B2|C1|C2>",
  "feedback": "<2-3 sentence feedback in Indonesian, constructive and encouraging>"
}
PROMPT;
    }
}
