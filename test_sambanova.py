import os, requests
key = os.environ.get("SAMBANOVA_API_KEY")
url = "https://api.sambanova.ai/v1/chat/completions"
headers = {"Authorization": f"Bearer {key}", "Content-Type": "application/json"}
models = ["Meta-Llama-3.1-70B-Instruct", "Meta-Llama-3.2-3B-Instruct", "Meta-Llama-3.3-70B-Instruct"]
for m in models:
    payload = {
        "model": m,
        "messages": [{"role": "user", "content": "Hello"}],
    }
    resp = requests.post(url, headers=headers, json=payload)
    print(m, resp.status_code)
