<?php

namespace App\Application\Dictionary;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Shared by ToeflDictionaryController (live student lookups) and the
 * dictionary:prewarm command (bulk background caching) so both go through
 * the exact same provider order/timeouts - a speed fix made here benefits
 * both call sites automatically instead of drifting apart.
 */
class ResolveWordTranslation
{
    /**
     * MyMemory first (best quality - real translation-memory matches, not
     * machine translation), Google Translate's unofficial endpoint second,
     * then an LLM as a last resort. LibreTranslate and Argos were dropped
     * from this chain - LibreTranslate's public instance now rejects
     * unauthenticated requests (requires a paid API key) and Argos's public
     * instance is unreachable; both were failing on every single call,
     * doing nothing but adding a wasted request per word.
     *
     * The LLM fallback exists because MyMemory's "translation memory" is
     * crowd-sourced and contains plenty of bad reference pairs (e.g. a
     * stored match of "theory" -> "Theory") that look like a confident,
     * high-score result but are just the input echoed back - isUsableTranslation()
     * catches the exact-match case, but that still leaves the word
     * untranslated for genuinely MT-resistant entries, and Google's free
     * endpoint 429s under any real load. Reuses the same multi-provider LLM
     * pool already relied on elsewhere in the app (Grammar Writing grading,
     * lesson explanations), so it inherits that infrastructure's
     * reliability instead of depending on either free scraping endpoint.
     */
    public function handle(string $word): ?string
    {
        return $this->tryMyMemory($word)
            ?? $this->tryGoogleTranslate($word)
            ?? $this->tryAiTranslation($word);
    }

    /**
     * Context-aware single-word translation, deliberately NOT part of the
     * handle()/ToeflDictionary caching chain above: that cache stores one
     * translation per bare word forever, for every student, in every
     * passage - correct for a context-free word like "elephant", actively
     * wrong for a word whose sense depends on usage ("aid" as the verb
     * "membantu" in "bacteria aid digestion" vs the cached noun "bantuan").
     * Only MyMemory/Google's word-for-word lookups get skipped here - they
     * have no mechanism to use the sentence at all - straight to the LLM,
     * which can actually read it. Callers are expected to NOT persist this
     * into ToeflDictionary; it's a request-scoped answer for this specific
     * sentence, not a new global default.
     */
    public function handleWithContext(string $word, string $sentence): ?string
    {
        try {
            $result = \App\Services\MultiProviderAiClient::chat(
                ['groq', 'cerebras', 'sambanova', 'gemini', 'siliconflow', 'openrouter', 'deepinfra', 'openai'],
                'You are a precise English-to-Indonesian dictionary. You will be given a sentence and one English word from that sentence. Translate the word into Indonesian exactly as it is being used in THIS sentence - matching its real grammatical role here (verb, noun, adjective, etc.), not just its most common dictionary sense. Respond with ONLY the Indonesian translation - one to three lowercase words, nothing else. No label, no quotes, no explanation.',
                "Sentence: \"{$sentence}\"\nWord to translate (as used in this exact sentence): \"{$word}\"",
                [
                    'groq_feature' => 'dictionary-context',
                    'max_tokens' => 200,
                    'temperature' => 0.1,
                    'json_mode' => false,
                    'timeout' => 15,
                ]
            );

            if (!$result || empty($result['content'])) {
                return null;
            }

            return $this->extractTranslationFromAiResponse($result['content']);
        } catch (\Exception $e) {
            Log::warning('Context-aware AI translation failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Both providers occasionally echo the input straight back (just with
     * different casing, e.g. "Festival") instead of a real failure response
     * when they have no actual translation - accepting that at face value
     * is how ~200 English words ended up permanently cached in
     * ToeflDictionary as their own "Indonesian translation" (lookup() only
     * calls this resolver once per word, on first-ever lookup, then always
     * serves the cached row after that). Treating an echoed word as "no
     * result" here makes the chain fall through to the next provider
     * instead of silently caching junk.
     */
    private function isUsableTranslation(string $word, ?string $candidate): bool
    {
        if ($candidate === null) {
            return false;
        }

        $trimmed = $this->normalizeCandidate($candidate);
        if ($trimmed === '' || $this->looksLikeGarbage($trimmed)) {
            return false;
        }

        return strcasecmp($trimmed, trim($word)) !== 0;
    }

    /**
     * Strips surrounding quotes/colons/trailing punctuation some providers
     * leave on an otherwise-good answer (MyMemory: "'Mendaur ulang'",
     * "Sasaran :") so those land in ToeflDictionary clean instead of with
     * stray formatting baked into the stored word.
     */
    private function normalizeCandidate(string $candidate): string
    {
        return trim($candidate, " \t\n\r\0\x0B\"'.,:;-");
    }

    /**
     * MyMemory's translation memory is crowd-sourced, and its corpus
     * contains contributed junk unrelated to the queried word - full
     * sentences, debug/log strings, even spam ("naughty" -> an unrelated
     * sexual-content sentence; "urgent" -> a loan-scam pitch with an email
     * address) that passed the plain non-empty/not-the-same-word checks
     * above and got cached as if it were a real translation. A genuine
     * single-word dictionary answer is always short and plain text, so
     * anything structurally sentence-like or containing contact info gets
     * rejected here regardless of source.
     */
    private function looksLikeGarbage(string $text): bool
    {
        if (mb_strlen($text) > 30) {
            return true;
        }

        if (str_contains($text, "\n") || str_contains($text, "\r")) {
            return true;
        }

        // A genuine single-word dictionary answer rarely needs more than a
        // few words even for a short descriptive phrase ("hunter-gatherer"
        // -> "pemburu-pengumpul") - 4 was still letting full sentences
        // through ("garden" -> "Ayah dan ibuku ada di kebun" is exactly 6
        // words).
        if (str_word_count($text) > 4) {
            return true;
        }

        if (preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/i', $text)) {
            return true;
        }

        if (preg_match('/https?:\/\//i', $text)) {
            return true;
        }

        if (preg_match('/%d|%s|Thread-Id|\[state\]|<x id=|<\/?[a-z]+>/i', $text)) {
            return true;
        }

        // A real dictionary answer always contains actual letters and is
        // more than one character - bare punctuation, a lone digit string,
        // or a single stray letter ("..", "20", "T") are MT scraps that
        // passed every check above simply by being short.
        if (mb_strlen($text) <= 1 || !preg_match('/\p{L}/u', $text)) {
            return true;
        }

        return false;
    }

    public function fetchSynonyms(string $word): ?string
    {
        try {
            $response = Http::withOptions(['verify' => false, 'timeout' => 5])
                ->get('https://api.datamuse.com/words', [
                    'rel_syn' => $word,
                    'max' => 5,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (is_array($data) && count($data) > 0) {
                    return implode(', ', array_column($data, 'word'));
                }
            }
        } catch (\Exception $e) {
            Log::warning('Datamuse API failed: ' . $e->getMessage());
        }

        return null;
    }

    private function tryMyMemory(string $word): ?string
    {
        try {
            $response = Http::withOptions(['verify' => false, 'timeout' => 4])
                ->get('https://api.mymemory.translated.net/get', [
                    'q' => $word,
                    'langpair' => 'en|id',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['responseData']['translatedText'])) {
                    $candidate = $data['responseData']['translatedText'];
                    return $this->isUsableTranslation($word, $candidate) ? $this->normalizeCandidate($candidate) : null;
                }
            }
        } catch (\Exception $e) {
            Log::warning('MyMemory API failed: ' . $e->getMessage());
        }

        return null;
    }

    private function tryGoogleTranslate(string $word): ?string
    {
        try {
            $response = Http::withOptions(['verify' => false, 'timeout' => 4])
                ->get('https://translate.googleapis.com/translate_a/single', [
                    'client' => 'gtx',
                    'sl' => 'en',
                    'tl' => 'id',
                    'dt' => 't',
                    'q' => $word,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[0][0][0]) && !empty($data[0][0][0])) {
                    $candidate = $data[0][0][0];
                    return $this->isUsableTranslation($word, $candidate) ? $this->normalizeCandidate($candidate) : null;
                }
            }
        } catch (\Exception $e) {
            Log::warning('Google Translate failed: ' . $e->getMessage());
        }

        return null;
    }

    private function tryAiTranslation(string $word): ?string
    {
        try {
            $result = \App\Services\MultiProviderAiClient::chat(
                ['groq', 'cerebras', 'sambanova', 'gemini', 'siliconflow', 'openrouter', 'deepinfra', 'openai'],
                'You are a precise English-to-Indonesian dictionary. You will be given one English word. Respond with ONLY its single most common Indonesian translation - one or two lowercase words, nothing else. If the word is also commonly used unchanged as a loanword in Indonesian (e.g. "data", "festival", "digital"), respond with that same word - that is a correct answer. Do not add a label, quotes, punctuation, or any explanation.',
                "Translate this English word to Indonesian: \"{$word}\"",
                [
                    'groq_feature' => 'dictionary',
                    // Some models in this pool (observed: Gemini via
                    // OpenRouter) are reasoning models that spend part of
                    // their token budget on hidden "thinking" tokens before
                    // the visible answer even starts - a tight max_tokens
                    // here cut generation off mid-word (e.g. "discovered"
                    // came back as literally "ditem", not "ditemukan"),
                    // which is worse than no translation since it looks
                    // plausible enough to accept at a glance. 200 leaves
                    // comfortable room for thinking tokens plus a short
                    // preamble plus the actual 1-2 word answer on every
                    // model in the pool.
                    'max_tokens' => 200,
                    'temperature' => 0.1,
                    'json_mode' => false,
                    'timeout' => 15,
                ]
            );

            if (!$result || empty($result['content'])) {
                return null;
            }

            // Unlike the two MT providers above, this tier is the
            // authoritative last resort and the prompt explicitly allows an
            // unchanged loanword as a valid answer - so an identical result
            // here is a deliberate confirmation it's a genuine cognate
            // ("data" -> "data"), not an echoed failure, and skips
            // isUsableTranslation()'s same-word rejection accordingly.
            return $this->extractTranslationFromAiResponse($result['content']);
        } catch (\Exception $e) {
            Log::warning('AI translation fallback failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Pulls the actual translation out of a raw LLM response, which despite
     * the system prompt's "ONLY the translation" instruction sometimes comes
     * back as a label ("Translation: ideal"), wrapped in markdown emphasis
     * ("**ideal**"), or with a short preamble line before the real answer.
     */
    private function extractTranslationFromAiResponse(string $raw): ?string
    {
        $lines = array_values(array_filter(array_map('trim', explode("\n", $raw)), fn ($l) => $l !== ''));
        if (empty($lines)) {
            return null;
        }

        // The real translation is usually the last non-empty line - a
        // preamble (if any) comes first, never after.
        $candidate = end($lines);
        $candidate = preg_replace('/^(translation|terjemahan|indonesian|jawaban|answer|input)\s*[:\-]\s*/i', '', $candidate);
        // Drop a trailing parenthetical aside some models add despite
        // instructions (e.g. "industri (no separate adjective form)" ->
        // "industri"); without this the leftover ") ..." fragment from a
        // mid-parenthesis line split was getting cached as the translation.
        $candidate = preg_replace('/\s*\([^)]*\)?\s*$/', '', $candidate);
        $candidate = trim($candidate, " \t\n\r\0\x0B\"'.*:-");

        // A genuine single-word/short-phrase answer is short - if what's
        // left still reads like a sentence, the model talked past its
        // instructions and this is explanatory text, not a translation.
        // looksLikeGarbage() additionally catches the rarer case of a
        // hallucinated email/URL/debug-looking fragment slipping through.
        if ($candidate !== '' && (str_word_count($candidate) > 3 || $this->looksLikeGarbage($candidate))) {
            return null;
        }

        return $candidate === '' ? null : $candidate;
    }

}
