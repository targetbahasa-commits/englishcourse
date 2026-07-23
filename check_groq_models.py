import os, requests, json
url = "https://api.groq.com/openai/v1/models"
key = os.environ.get("GROQ_API_KEY")
headers = {"Authorization": f"Bearer {key}"}
resp = requests.get(url, headers=headers)
models = resp.json().get('data', [])
for m in models:
    print(m.get('id'))
