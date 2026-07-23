import os, json, random, asyncio
import requests
import subprocess
import edge_tts

AUDIO_DIR = "public/storage/kokoro-tts"
os.makedirs(AUDIO_DIR, exist_ok=True)
tts_url = "http://127.0.0.1:8100/api/generate-listening"

EDGE_VOICES = [
    "en-US-JennyNeural", "en-US-GuyNeural", "en-GB-SoniaNeural", 
    "en-GB-RyanNeural", "en-AU-NatashaNeural", "en-AU-WilliamNeural",
    "en-CA-ClaraNeural", "en-CA-LiamNeural"
]

async def generate_edge_tts(text, output_path):
    voice = random.choice(EDGE_VOICES)
    communicate = edge_tts.Communicate(text, voice)
    await communicate.save(output_path)

async def main():
    php_script = """
    <?php
    $files = [
        'config/pte_retell_lecture.php' => 'rl',
        'config/pte_answer_short_question.php' => 'asq',
        'config/pte_listening_mcma.php' => 'lmcma',
        'config/pte_listening_fib.php' => 'fib',
        'config/pte_highlight_correct_summary.php' => 'hcs',
        'config/pte_listening_mcsa.php' => 'lmcsa',
        'config/pte_select_missing_word.php' => 'smw',
        'config/pte_highlight_incorrect_words.php' => 'hiw',
        'config/pte_write_from_dictation.php' => 'wfd'
    ];
    $all = [];
    foreach ($files as $f => $prefix) {
        if(file_exists($f)){
            $data = include $f;
            $all[$prefix] = $data;
        }
    }
    echo json_encode($all);
    """
    with open('tmp_dump.php', 'w') as f:
        f.write(php_script)

    out = subprocess.check_output(['php', 'tmp_dump.php'])
    os.remove('tmp_dump.php')

    data = json.loads(out)

    for prefix, items in data.items():
        print(f"Generating audio for {prefix}...")
        
        # PHP arrays might become lists or dicts in JSON depending on keys
        iterator = items.items() if isinstance(items, dict) else enumerate(items)
        
        for key, item in iterator:
            if isinstance(item, dict) and 'transcript' in item:
                text = item['transcript']
                
                mp3_filename = f"{prefix}_{key}.mp3"
                mp3_path = os.path.join(AUDIO_DIR, mp3_filename)
                
                if os.path.exists(mp3_path) and os.path.getsize(mp3_path) > 1000:
                    continue
                    
                # Mix: 50% Kokoro, 50% Edge
                use_kokoro = random.choice([True, False])
                
                if use_kokoro:
                    # Coba Kokoro TTS
                    payload = {
                        "text": text,
                        "voice": "af_bella",
                        "speed": 1.0,
                        "lang": "en-us"
                    }
                    try:
                        response = await asyncio.to_thread(requests.post, "http://127.0.0.1:8100/v1/audio/speech", json=payload, timeout=30)
                        if response.status_code == 200:
                            with open(mp3_path, "wb") as f:
                                f.write(response.content)
                            print(f"Generated {mp3_filename} via Kokoro")
                            continue # Berhasil, lanjut ke file berikutnya
                        else:
                            print(f"Failed {mp3_filename} Kokoro: {response.status_code}. Falling back to Edge TTS...")
                    except Exception as e:
                        print(f"Failed {mp3_filename} Kokoro exception: {e}. Falling back to Edge TTS...")
                
                # Edge TTS (digunakan jika use_kokoro false, atau jika Kokoro gagal)
                try:
                    await generate_edge_tts(text, mp3_path)
                    print(f"Generated {mp3_filename} via Edge TTS")
                except Exception as e:
                    print(f"Error {mp3_filename} Edge: {e}")

if __name__ == "__main__":
    asyncio.run(main())
