
$m = App\Models\IeltsListeningMockup::first();
$audioPath = public_path($m->audio_file_1);
echo "Processing $audioPath\n";
$whisper = app(App\Services\WhisperTranscriptionService::class);
$publicPath = 'audio/ielts-academic/mockup/cambridge-16-test-1';
$transcription = $whisper->transcribeAndTranslate($audioPath, $publicPath);

if (!empty($transcription['formatted_en'])) {
    $m->update(['transcript_en_1' => $transcription['formatted_en']]);
    echo "Saved formatted_en\n";
} elseif (!empty($transcription['srt_en'])) {
    $blocksEn = app(App\Application\ToeflMockup\SrtTranscriptParser::class)->parse($transcription['srt_en']);
    $m->update(['transcript_en_1' => json_encode($blocksEn)]);
    echo "Saved srt_en\n";
}

if (!empty($transcription['formatted_id'])) {
    $m->update(['transcript_id_1' => $transcription['formatted_id']]);
    echo "Saved formatted_id\n";
} elseif (!empty($transcription['id'])) {
    $m->update(['transcript_id_1' => $transcription['id']]);
    echo "Saved id\n";
}
echo "Done.\n";
