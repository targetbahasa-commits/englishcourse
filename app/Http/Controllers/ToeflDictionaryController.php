<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToeflDictionaryController extends Controller
{
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



        // 2. Fallback Chain
        $translation = $this->tryGoogleTranslate($cleanWord);
        
        if (!$translation) {
            $translation = $this->tryLibreTranslate($cleanWord);
        }
        
        if (!$translation) {
            $translation = $this->tryMyMemory($cleanWord);
        }
        
        if (!$translation) {
            $translation = $this->tryArgosTranslate($cleanWord);
        }

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
            $synonyms = $this->fetchSynonyms($cleanWord) ?: '-';
            $entry->update(['synonyms' => $synonyms]);
            return response()->json(['synonyms' => $synonyms]);
        }
        
        // If not in DB, just fetch and return (this shouldn't happen often if lookup is called first)
        $synonyms = $this->fetchSynonyms($cleanWord) ?: '-';
        return response()->json(['synonyms' => $synonyms]);
    }

    private function tryGoogleTranslate($word)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false, 'timeout' => 10])
                ->get('https://translate.googleapis.com/translate_a/single', [
                    'client' => 'gtx',
                    'sl' => 'en',
                    'tl' => 'id',
                    'dt' => 't',
                    'q' => $word
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[0][0][0]) && !empty($data[0][0][0])) {
                    return $data[0][0][0];
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Google Translate failed: ' . $e->getMessage());
        }
        return null;
    }

    private function tryLibreTranslate($word)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false, 'timeout' => 10])
                ->post('https://libretranslate.com/translate', [
                    'q' => $word,
                    'source' => 'en',
                    'target' => 'id',
                    'format' => 'text'
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['translatedText']) && !empty($data['translatedText'])) {
                    return $data['translatedText'];
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('LibreTranslate failed: ' . $e->getMessage());
        }
        return null;
    }

    private function tryArgosTranslate($word)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false, 'timeout' => 10])
                ->post('https://translate.argosopentech.com/translate', [
                    'q' => $word,
                    'source' => 'en',
                    'target' => 'id',
                    'format' => 'text'
                ]);

            if ($response->successful() && isset($response['translatedText'])) {
                return $response['translatedText'];
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Argos Translate failed: ' . $e->getMessage());
        }
        return null;
    }

    private function tryMyMemory($word)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false, 'timeout' => 10])
                ->get('https://api.mymemory.translated.net/get', [
                    'q' => $word,
                    'langpair' => 'en|id'
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['responseData']['translatedText'])) {
                    // MyMemory sometimes returns the input if no translation found, or specific error messages.
                    // But usually it's okay for single words.
                    return $data['responseData']['translatedText'];
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('MyMemory API failed: ' . $e->getMessage());
        }
        return null;
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

    private function fetchSynonyms($word)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false, 'timeout' => 5])
                ->get('https://api.datamuse.com/words', [
                    'rel_syn' => $word,
                    'max' => 5
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (is_array($data) && count($data) > 0) {
                    $synonyms = array_column($data, 'word');
                    return implode(', ', $synonyms);
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Datamuse API failed: ' . $e->getMessage());
        }
        return null;
    }
}
