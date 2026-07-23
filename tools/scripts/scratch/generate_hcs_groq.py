import os
import json
import time
import requests
import concurrent.futures

GROQ_API_KEY = "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"
HEADERS = {
    "Authorization": f"Bearer {GROQ_API_KEY}",
    "Content-Type": "application/json"
}

with open('tools/scripts/scratch/hcs_temp.json', 'r') as f:
    hcs_data = json.load(f)

def generate_options(item):
    # Some items might have been successfully updated by previous Gemini calls
    if isinstance(item.get('options'), list) and len(item['options']) == 4:
        # Check if correct_answer is short (less than 40 words roughly)
        if len(item['correct_answer'].split()) < 40:
            return item
    
    prompt = f"Transcript:\n{item['transcript']}\n\nGenerate 4 options for a multiple choice question where the student must select the best summary of the transcript. 1 option must be the correct summary. 3 options must be incorrect summaries or misinterpretations. Make sure the options are concise (1-2 sentences each).\n\nReturn JSON format:\n{{\n    \"correct_answer\": \"(the correct option text)\",\n    \"options\": [\n        \"option A\",\n        \"option B\",\n        \"option C\",\n        \"option D\"\n    ]\n}}"
    
    payload = {
        "model": "llama-3.3-70b-versatile",
        "messages": [{"role": "user", "content": prompt}],
        "response_format": {"type": "json_object"},
        "temperature": 0.5
    }
    
    while True:
        try:
            resp = requests.post("https://api.groq.com/openai/v1/chat/completions", headers=HEADERS, json=payload, timeout=30)
            if resp.status_code == 429:
                # Rate limit hit
                retry_after = int(resp.headers.get('retry-after', 2))
                print(f"Rate limited, sleeping for {retry_after}s...")
                time.sleep(retry_after + 1)
                continue
            
            resp.raise_for_status()
            data = resp.json()
            content = data['choices'][0]['message']['content']
            parsed = json.loads(content)
            
            if 'correct_answer' in parsed and 'options' in parsed and len(parsed['options']) == 4:
                item['correct_answer'] = parsed['correct_answer']
                item['options'] = parsed['options']
                return item
        except Exception as e:
            print(f"Error: {e}, retrying in 2s...")
            time.sleep(2)

print(f"Processing {len(hcs_data)} items...")
results = []
# Process sequentially to avoid aggressive rate limits (Groq allows ~30 requests per minute on free tier, 
# which is 1 request per 2 seconds. Let's just do sequential with a small sleep).

for i, item in enumerate(hcs_data):
    if i % 10 == 0:
        print(f"Processed {i}/{len(hcs_data)}")
        
    start = time.time()
    updated_item = generate_options(item)
    results.append(updated_item)
    
    # Sleep to stay within 30 RPM (1 request every 2 seconds)
    elapsed = time.time() - start
    if elapsed < 2.0:
        time.sleep(2.0 - elapsed)

with open('tools/scripts/scratch/hcs_temp.json', 'w') as f:
    json.dump(results, f, indent=4)

print("Done processing!")
