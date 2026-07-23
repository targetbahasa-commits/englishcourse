import os, requests
key = os.environ.get("GROQ_API_KEY")
print("Key length:", len(key) if key else "None")
