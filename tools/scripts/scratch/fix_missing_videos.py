import json
import os
import hashlib
import subprocess

DB_PATH = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/scripts/web_assets/database.json"
VID_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/scripts/web_assets/videos"

texts = [
    "Can someone be too polite?",
    "How should we deal with rude people?"
]

with open(DB_PATH, 'r') as f:
    db = json.load(f)

source_video = os.path.join(VID_DIR, "video_808448d0d899.mp4")

for text in texts:
    hash_id = hashlib.sha1(text.encode()).hexdigest()[:12]
    audio_path = f"temp_audio_{hash_id}.mp3"
    out_video = os.path.join(VID_DIR, f"video_{hash_id}.mp4")
    
    # Generate audio
    subprocess.run(["python3", "-m", "edge_tts", "--voice", "en-US-AriaNeural", "--text", text, "--write-media", audio_path], check=True)
    
    # Mux audio with source video (loop video if audio is longer, or truncate video if audio is shorter)
    subprocess.run([
        "ffmpeg", "-y", "-stream_loop", "-1", "-i", source_video, "-i", audio_path, 
        "-c:v", "copy", "-c:a", "aac", "-map", "0:v:0", "-map", "1:a:0", "-shortest", out_video
    ], check=True)
    
    # Add to DB
    if not any(entry['text'] == text for entry in db):
        db.append({
            "text": text,
            "video_path": f"/web_assets/videos/video_{hash_id}.mp4"
        })
        
    os.remove(audio_path)

with open(DB_PATH, 'w') as f:
    json.dump(db, f, indent=4)

print("Done! Fixed missing videos.")
