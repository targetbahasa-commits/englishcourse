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
