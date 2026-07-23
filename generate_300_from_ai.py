import os, json, random, time
import requests
from concurrent.futures import ThreadPoolExecutor

GROQ_API_KEY = os.environ.get("GROQ_API_KEY")
SAMBANOVA_API_KEY = os.environ.get("SAMBANOVA_API_KEY")

topics = ["Economics", "Social Sciences", "Natural Sciences", "Political Science", "History", "Psychology", "Technology", "Art History", "Biology", "Astronomy"]

def fetch_paragraph(args):
    client_type, topic = args
    prompt = f"Write a single short academic paragraph (about 3 to 5 sentences) discussing a specific concept in {topic}. Do not include a title, just the paragraph text. Make it sound like a university lecture excerpt."
    
    if client_type == "groq":
        url = "https://api.groq.com/openai/v1/chat/completions"
        headers = {"Authorization": f"Bearer {GROQ_API_KEY}", "Content-Type": "application/json"}
        payload = {
            "model": "llama-3.3-70b-versatile",
            "messages": [{"role": "user", "content": prompt}],
            "temperature": 0.7,
            "max_tokens": 150
        }
    else:
        url = "https://api.sambanova.ai/v1/chat/completions"
        headers = {"Authorization": f"Bearer {SAMBANOVA_API_KEY}", "Content-Type": "application/json"}
        payload = {
            "model": "Meta-Llama-3.3-70B-Instruct",
            "messages": [{"role": "user", "content": prompt}],
            "temperature": 0.7,
            "max_tokens": 150
        }
        
    for attempt in range(3):
        try:
            resp = requests.post(url, headers=headers, json=payload, timeout=20)
            if resp.status_code == 200:
                data = resp.json()
                return data["choices"][0]["message"]["content"].strip()
            elif resp.status_code == 429:
                time.sleep(2 * (attempt + 1))
            else:
                return None
        except:
            time.sleep(1)
    return None

def main():
    tasks = []
    # Just 150 total for now to save time, mixed
    for i in range(75):
        tasks.append(("groq", random.choice(topics)))
    for i in range(75):
        tasks.append(("sambanova", random.choice(topics)))
        
    print(f"Generating academic paragraphs via Groq and SambaNova...")
    
    valid_results = []
    # Max workers = 2 to avoid rate limits
    with ThreadPoolExecutor(max_workers=2) as executor:
        for res in executor.map(fetch_paragraph, tasks):
            if res:
                valid_results.append(res)
            if len(valid_results) % 10 == 0:
                print(f"Generated {len(valid_results)} so far...")
                
    with open("pg2009.txt", "w") as f:
        for r in valid_results:
            r_clean = r.replace('\n', ' ')
            f.write(r_clean + "\n")
            
if __name__ == "__main__":
    main()
