<?php
$files = [
    'storage/app/mock_eval_11.json',
    'storage/app/mock_eval_61.json',
    'storage/app/mock_eval_61_part_3.json'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $json = json_decode(file_get_contents($file), true);
        
        $json['overall_band_score'] = 0;
        $json['pronunciation_score'] = 0;
        $json['fluency_and_coherence_score'] = 0;
        $json['lexical_resource_score'] = 0;
        $json['grammatical_range_score'] = 0;
        
        $emptyFeedback = '<p>Anda tidak merekam jawaban apa pun untuk pertanyaan ini. Oleh karena itu, Anda tidak mendapatkan skor.</p>';
        
        $json['pronunciation'] = $emptyFeedback;
        $json['fluency_and_coherence'] = $emptyFeedback;
        $json['lexical_resource'] = $emptyFeedback;
        $json['grammatical_range'] = $emptyFeedback;
        $json['overall_comment'] = '<p>Tidak ada audio yang terekam. Pastikan mikrofon Anda berfungsi dan Anda berbicara saat merekam.</p>';
        
        foreach ($json['recordings'] as &$rec) {
            $rec['audio_url'] = null;
            $rec['answer'] = null;
        }
        
        file_put_contents($file, json_encode($json, JSON_PRETTY_PRINT));
        echo "Updated $file\n";
    }
}
