import os
import json
import asyncio
import edge_tts

async def generate_tts(text, voice, output_path):
    try:
        communicate = edge_tts.Communicate(text, voice)
        await communicate.save(output_path)
        return True
    except Exception as e:
        print(f"TTS Error: {e}")
        return False

async def main():
    with open("PTE/select_missing_word.json", "r") as f:
        data = json.load(f)
    
    for i in range(1, 301):
        audio_filename = f"topic_{str(i).zfill(3)}.mp3"
        audio_path = f"public/storage/kokoro-tts/listening-select-missing-word/{audio_filename}"
        
        if not os.path.exists(audio_path):
            item_data = data[i-1]
            if not item_data:
                print(f"Item {i} is empty in JSON!")
                continue
            
            text_to_speak = item_data.get("transcript_text", item_data.get("transcript", item_data.get("text", "")))
            if not text_to_speak:
                print(f"No text found for {i}")
                continue
                
            voice = "en-US-ChristopherNeural"
            
            print(f"Generating missing audio for {i}: {audio_path}")
            await generate_tts(text_to_speak, voice, audio_path)

if __name__ == "__main__":
    asyncio.run(main())
