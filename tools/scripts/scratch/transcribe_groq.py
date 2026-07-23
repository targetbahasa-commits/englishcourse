import os
import sys
import requests

GROQ_API_KEY = "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"
headers = {
    "Authorization": f"Bearer {GROQ_API_KEY}"
}

file_path = sys.argv[1]
files = {
    "file": (os.path.basename(file_path), open(file_path, "rb")),
}
data = {
    "model": "whisper-large-v3"
}

resp = requests.post("https://api.groq.com/openai/v1/audio/transcriptions", headers=headers, files=files, data=data)
print(resp.json())
