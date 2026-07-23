import re

with open('resources/views/assignments/ielts/listening/partials/audio-player.blade.php', 'r') as f:
    content = f.read()

# Fix audioData initialization to handle cases where audio_file_1 doesn't exist (fallback to audio_file)
old_audio_data = """            audioData: {
                @for($i = 1; $i <= 4; $i++)
                {{ $i }}: {
                    url: '{{ isset($section) && $section->{'audio_file_'.$i} ? asset($section->{'audio_file_'.$i}) : "" }}',
                    hasAudio: {{ isset($section) && filled($section->{'audio_file_'.$i}) ? 'true' : 'false' }},
                    hasTranscript: {{ isset($section) && (filled($section->{'transcript_en_'.$i}) || filled($section->{'transcript_id_'.$i})) ? 'true' : 'false' }}
                },
                @endfor
            },"""

new_audio_data = """            audioData: {
                @for($i = 1; $i <= 4; $i++)
                @php
                    $aud = isset($section) ? ($section->{'audio_file_'.$i} ?? ($i === 1 ? ($section->audio_file ?? null) : null)) : null;
                    $tEn = isset($section) ? ($section->{'transcript_en_'.$i} ?? ($i === 1 ? ($section->transcript_en ?? null) : null)) : null;
                    $tId = isset($section) ? ($section->{'transcript_id_'.$i} ?? ($i === 1 ? ($section->transcript_id ?? null) : null)) : null;
                @endphp
                {{ $i }}: {
                    url: '{{ $aud ? asset($aud) : "" }}',
                    hasAudio: {{ filled($aud) ? 'true' : 'false' }},
                    hasTranscript: {{ (filled($tEn) || filled($tId)) ? 'true' : 'false' }}
                },
                @endfor
            },"""
content = content.replace(old_audio_data, new_audio_data)

# Same for transcripts in drawer
old_transcript_en = """                            @php
                                $transcriptEn = $section->{'transcript_en_' . $i} ?? null;
                            @endphp"""
new_transcript_en = """                            @php
                                $transcriptEn = $section->{'transcript_en_' . $i} ?? ($i === 1 ? ($section->transcript_en ?? null) : null);
                            @endphp"""
content = content.replace(old_transcript_en, new_transcript_en)

old_transcript_id = """                            @php
                                $transcriptId = $section->{'transcript_id_' . $i} ?? null;
                            @endphp"""
new_transcript_id = """                            @php
                                $transcriptId = $section->{'transcript_id_' . $i} ?? ($i === 1 ? ($section->transcript_id ?? null) : null);
                            @endphp"""
content = content.replace(old_transcript_id, new_transcript_id)

# Wrap modals with @if(isset($testId) && isset($edition))
content = content.replace("    {{-- Upload SRT Modal --}}", "@if(isset($testId) && isset($edition))\n    {{-- Upload SRT Modal --}}")
content = content.replace("        </div>\n    </div>\n@endif\n\n<script>", "        </div>\n    </div>\n@endif\n@endif\n\n<script>")

with open('resources/views/assignments/ielts/listening/partials/audio-player.blade.php', 'w') as f:
    f.write(content)

print("fixed audio player")
