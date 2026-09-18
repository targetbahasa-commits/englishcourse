import ftplib
import os

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

REMOTE_CONFIG = "/domains/targetbahasa.com/public_html/config"
REMOTE_AUDIO = "/domains/targetbahasa.com/public_html/public/storage/kokoro-tts"

# Config files to upload
config_files = [
    "config/pte_listening_sst_topics.php",
    "config/pte_retell_lecture.php",
    "config/pte_answer_short_question.php",
    "config/pte_listening_mcma.php",
    "config/pte_listening_fib.php",
    "config/pte_highlight_correct_summary.php",
    "config/pte_listening_mcsa.php",
    "config/pte_select_missing_word.php",
    "config/pte_highlight_incorrect_words.php",
    "config/pte_write_from_dictation.php",
]

# Audio subdirectories to upload
audio_dirs = [
    "listening-summarize-spoken-text",
    "listening-fill-blanks",
    "listening-highlight-correct-summary",
    "listening-mcma",
    "listening-multiple-choice-single-answer",
    "listening-select-missing-word",
    "highlight-incorrect-words",
]

def ensure_remote_dir(ftp, path):
    """Create remote directory if it doesn't exist"""
    try:
        ftp.mkd(path)
    except:
        pass

def upload_file(ftp, local_path, remote_path):
    with open(local_path, "rb") as f:
        ftp.storbinary(f"STOR {remote_path}", f)

print("Connecting to FTP...")
ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)
print("Connected!")

# 1. Upload config files
print("\n=== Uploading Config Files ===")
for cfg in config_files:
    local_path = cfg
    if os.path.exists(local_path):
        filename = os.path.basename(local_path)
        remote_path = f"{REMOTE_CONFIG}/{filename}"
        try:
            upload_file(ftp, local_path, remote_path)
            print(f"  ✓ Uploaded {filename}")
        except Exception as e:
            print(f"  ✗ Failed {filename}: {e}")
    else:
        print(f"  - Skipped {cfg} (not found locally)")

# 2. Upload audio files
print("\n=== Uploading Audio Files ===")
local_audio_base = "public/storage/kokoro-tts"

for subdir in audio_dirs:
    local_dir = os.path.join(local_audio_base, subdir)
    remote_dir = f"{REMOTE_AUDIO}/{subdir}"
    
    if not os.path.isdir(local_dir):
        print(f"  - Skipped {subdir} (not found locally)")
        continue
    
    ensure_remote_dir(ftp, remote_dir)
    
    files = [f for f in os.listdir(local_dir) if f.endswith(".mp3")]
    total = len(files)
    print(f"\n  Uploading {subdir}/ ({total} files)...")
    
    for i, filename in enumerate(sorted(files), 1):
        local_path = os.path.join(local_dir, filename)
        remote_path = f"{remote_dir}/{filename}"
        try:
            upload_file(ftp, local_path, remote_path)
            if i % 50 == 0 or i == total:
                print(f"    [{i}/{total}] uploaded...")
        except Exception as e:
            print(f"    ✗ Failed {filename}: {e}")

# 3. Also upload root-level mp3s (rl_, asq_, wfd_, etc.)
print("\n=== Uploading Root-level Audio Files ===")
root_mp3s = [f for f in os.listdir(local_audio_base) if f.endswith(".mp3")]
total_root = len(root_mp3s)
print(f"  Found {total_root} root-level MP3 files")
for i, filename in enumerate(sorted(root_mp3s), 1):
    local_path = os.path.join(local_audio_base, filename)
    remote_path = f"{REMOTE_AUDIO}/{filename}"
    try:
        upload_file(ftp, local_path, remote_path)
        if i % 50 == 0 or i == total_root:
            print(f"    [{i}/{total_root}] uploaded...")
    except Exception as e:
        print(f"    ✗ Failed {filename}: {e}")

ftp.quit()
print("\n=== DONE! All files uploaded to production. ===")
