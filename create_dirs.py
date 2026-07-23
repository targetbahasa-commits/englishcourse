import ftplib

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)

audio_dirs = [
    "listening-summarize-spoken-text",
    "listening-fill-blanks",
    "listening-highlight-correct-summary",
    "listening-mcma",
    "listening-multiple-choice-single-answer",
    "listening-select-missing-word",
    "highlight-incorrect-words",
]

for subdir in audio_dirs:
    path = f"/domains/targetbahasa.com/public_html/public/storage/kokoro-tts/{subdir}"
    try:
        ftp.mkd(path)
        print(f"Created {path}")
    except Exception as e:
        print(f"Dir {path} exists or error: {e}")

ftp.quit()
