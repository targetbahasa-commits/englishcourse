<?php

namespace App\Http\Controllers;

use App\Application\Dictionary\ResolveWordTranslation;
use Illuminate\Http\Request;

class ToeflDictionaryController extends Controller
{
    public function __construct(private readonly ResolveWordTranslation $resolveWordTranslation)
    {
    }

    public function lookup(Request $request)
    {
        $rawWord = $request->query('word');
        $word = strtolower(trim($rawWord));
        // Allow alpha-numeric and simple punctuation like hyphens/apostrophes
        $cleanWord = preg_replace('/[^a-z0-9\-\']/', '', $word);

        if (empty($cleanWord)) {
            return response()->json(['found' => false]);
        }

        // 1. Check Local DB
        $entry = \App\Models\ToeflDictionary::where('word', $cleanWord)->first();
        if ($entry) {
            // No longer fetch synonyms here. We return what we have (null/'-' or text)
            // and let the frontend request synonyms separately if needed.
            return $this->itemResponse($entry->word, $entry->translation, $entry->synonyms);
        }

        // 2. Fallback chain (see ResolveWordTranslation for provider order/timeouts)
        $translation = $this->resolveWordTranslation->handle($cleanWord);

        // 3. Save if found
        if ($translation) {
            $newEntry = $this->saveToDictionary($cleanWord, $translation, null); // Leave synonyms null for background fetch
            return $this->itemResponse($newEntry->word, $newEntry->translation, $newEntry->synonyms);
        }

        return response()->json([
            'found' => false,
            'word' => $cleanWord,
            'message' => 'Translation not available at the moment'
        ]);
    }

    /**
     * On-demand, sentence-aware recheck - deliberately bypasses the
     * ToeflDictionary cache in both directions (doesn't read it, doesn't
     * write to it). That cache is one global translation per word forever;
     * baking a sentence-specific answer into it would just move the "wrong
     * context" bug onto the next student who looks up the same word in a
     * different sentence. See ResolveWordTranslation::handleWithContext().
     */
    public function lookupInContext(Request $request)
    {
        $rawWord = $request->query('word');
        $word = strtolower(trim($rawWord));
        $cleanWord = preg_replace('/[^a-z0-9\-\']/', '', $word);
        $sentence = trim((string) $request->query('sentence'));

        if (empty($cleanWord) || empty($sentence)) {
            return response()->json(['found' => false]);
        }

        // Guard against a runaway sentence extraction (e.g. a whole
        // paragraph with no detected punctuation) blowing up the prompt.
        $sentence = mb_substr($sentence, 0, 400);

        $translation = $this->resolveWordTranslation->handleWithContext($cleanWord, $sentence);

        if (!$translation) {
            return response()->json([
                'found' => false,
                'word' => $cleanWord,
                'message' => 'Context translation not available at the moment',
            ]);
        }

        return response()->json([
            'found' => true,
            'word' => $cleanWord,
            'translation' => $translation,
        ]);
    }

    public function synonyms(Request $request)
    {
        $rawWord = $request->query('word');
        $word = strtolower(trim($rawWord));
        $cleanWord = preg_replace('/[^a-z0-9\-\']/', '', $word);

        if (empty($cleanWord)) {
            return response()->json(['synonyms' => '-']);
        }

        $entry = \App\Models\ToeflDictionary::where('word', $cleanWord)->first();

        if ($entry) {
            if (!empty($entry->synonyms) && $entry->synonyms !== '-') {
                return response()->json(['synonyms' => $entry->synonyms]);
            }

            // Fetch missing synonyms
            $synonyms = $this->resolveWordTranslation->fetchSynonyms($cleanWord) ?: '-';
            $entry->update(['synonyms' => $synonyms]);
            return response()->json(['synonyms' => $synonyms]);
        }

        // If not in DB, just fetch and return (this shouldn't happen often if lookup is called first)
        $synonyms = $this->resolveWordTranslation->fetchSynonyms($cleanWord) ?: '-';
        return response()->json(['synonyms' => $synonyms]);
    }

    private function itemResponse($word, $translation, $synonyms = '-') {
        return response()->json([
            'found' => true,
            'word' => $word,
            'translation' => $translation,
            'synonyms' => $synonyms
        ]);
    }

    private function saveToDictionary($word, $translation, $synonyms = null) {
        return \App\Models\ToeflDictionary::create([
            'word' => $word,
            'translation' => $translation,
            'synonyms' => $synonyms
        ]);
    }
}
