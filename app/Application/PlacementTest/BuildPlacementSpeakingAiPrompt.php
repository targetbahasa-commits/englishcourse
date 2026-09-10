<?php

namespace App\Application\PlacementTest;

class BuildPlacementSpeakingAiPrompt
{
    public function build(string $promptText, string $transcript): string
    {
        return <<<PROMPT
You are an expert English language assessor. A speaker was asked to respond verbally to the prompt below. You are given a transcript of their spoken response (transcribed by speech-to-text). Assess the speaker's CEFR level (A1, A2, B1, B2, C1, or C2) based on the vocabulary, grammar, and coherence evident in the transcript.

Note: the transcript may contain minor transcription errors - do not penalize for likely transcription artifacts, focus on the underlying language ability.

Prompt given to the speaker:
"{$promptText}"

Transcript of spoken response:
"{$transcript}"

Score on a 0-100 scale for each of these criteria:
- fluency_coherence: how connected and logically organized the response is
- vocabulary: range and appropriateness of vocabulary used
- grammar: grammatical range and accuracy

Then estimate an overall CEFR level for this spoken response.

Respond with ONLY valid JSON in this exact shape:
{
  "scores": {
    "fluency_coherence": <0-100>,
    "vocabulary": <0-100>,
    "grammar": <0-100>
  },
  "cefr_estimate": "<A1|A2|B1|B2|C1|C2>",
  "feedback": "<2-3 sentence feedback in Indonesian, constructive and encouraging>"
}
PROMPT;
    }
}
