import os, json, re, time
import requests
from dotenv import load_dotenv

load_dotenv("live.env")

GEMINI_API_KEY = os.environ.get("GEMINI_API_KEY")

def get_transcripts():
    with open("config/pte_listening_fib.php", "r", encoding="utf-8") as f:
        content = f.read()
    transcripts = []
    matches = re.finditer(r"'transcript'\s*=>\s*'(.*?(?<!\\))'", content, re.DOTALL)
    for m in matches:
        t = m.group(1).replace("\\'", "'")
        transcripts.append(t)
    return transcripts

def fetch_mcsa(idx, transcript):
    prompt = f"""You are generating a PTE Academic 'Multiple Choice Single Answer' question.
Given the following transcript, generate a single multiple-choice question about the transcript.
Provide 4 short options (1-4 words each usually). 
One must be the CORRECT answer to the question.
Three must be INCORRECT answers (distractors) that are plausible but wrong based on the transcript.

Transcript: "{transcript}"

Return ONLY a valid JSON object in this exact format (no markdown blocks, no other text):
{{
  "question": "The question text",
  "options": [
    "Option 1",
    "Option 2",
    "Option 3",
    "Option 4"
  ],
  "correct_answer": "The exact string of the correct option"
}}"""
    url = f"https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={GEMINI_API_KEY}"
    headers = {"Content-Type": "application/json"}
    payload = {
        "contents": [{"parts": [{"text": prompt}]}],
        "generationConfig": {
            "temperature": 0.5,
            "responseMimeType": "application/json"
        }
    }
        
    for attempt in range(5):
        try:
            resp = requests.post(url, headers=headers, json=payload, timeout=20)
            if resp.status_code == 200:
                data = resp.json()
                content = data["candidates"][0]["content"]["parts"][0]["text"].strip()
                try:
                    parsed = json.loads(content)
                    return parsed
                except Exception as e:
                    pass
            elif resp.status_code == 429:
                time.sleep(10)
            else:
                time.sleep(4)
        except Exception as e:
            time.sleep(4)
    return None

def fetch_hcs(idx, transcript):
    prompt = f"""You are generating a PTE Academic 'Highlight Correct Summary' question.
Given the following transcript, provide 4 summary options. 
One must be the CORRECT summary that accurately captures the main points.
Three must be INCORRECT summaries (distractors) that contain slight inaccuracies, misrepresent the main idea, or focus on minor details of the SAME transcript. Do NOT write summaries of completely different topics.

Transcript: "{transcript}"

Return ONLY a valid JSON object in this exact format (no markdown blocks, no other text):
{{
  "options": [
    "Summary 1",
    "Summary 2",
    "Summary 3",
    "Summary 4"
  ],
  "correct_answer": "The exact string of the correct summary"
}}"""
    url = f"https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={GEMINI_API_KEY}"
    headers = {"Content-Type": "application/json"}
    payload = {
        "contents": [{"parts": [{"text": prompt}]}],
        "generationConfig": {
            "temperature": 0.5,
            "responseMimeType": "application/json"
        }
    }
        
    for attempt in range(5):
        try:
            resp = requests.post(url, headers=headers, json=payload, timeout=20)
            if resp.status_code == 200:
                data = resp.json()
                content = data["candidates"][0]["content"]["parts"][0]["text"].strip()
                try:
                    parsed = json.loads(content)
                    return parsed
                except Exception as e:
                    pass
            elif resp.status_code == 429:
                time.sleep(10)
            else:
                time.sleep(4)
        except Exception as e:
            time.sleep(4)
    return None

def main():
    transcripts = get_transcripts()
    
    print("Generating remaining HCS...")
    hcs_results = [None] * len(transcripts)
    if os.path.exists("hcs_ai_results.json"):
        with open("hcs_ai_results.json", "r") as f:
            saved = json.load(f)
            if len(saved) == len(transcripts):
                hcs_results = saved

    for i, t in enumerate(transcripts):
        if hcs_results[i] is None or hcs_results[i].get("options", [])[0] == "Error generation" or "Failed" in str(hcs_results[i]):
            time.sleep(4.1) # Respect 15 RPM
            res = fetch_hcs(i, t)
            if res:
                hcs_results[i] = res
                with open("hcs_ai_results.json", "w") as f:
                    json.dump(hcs_results, f)
                print(f"HCS {i+1}/{len(transcripts)} generated (Gemini 2.0)", flush=True)
            else:
                print(f"Failed HCS {i+1}", flush=True)

    print("Generating remaining MCSA...")
    mcsa_results = [None] * len(transcripts)
    if os.path.exists("mcsa_ai_results.json"):
        with open("mcsa_ai_results.json", "r") as f:
            saved = json.load(f)
            if len(saved) == len(transcripts):
                mcsa_results = saved

    for i, t in enumerate(transcripts):
        if mcsa_results[i] is None or mcsa_results[i].get("options", [])[0] == "Error" or "Failed" in str(mcsa_results[i]):
            time.sleep(4.1)
            res = fetch_mcsa(i, t)
            if res:
                mcsa_results[i] = res
                with open("mcsa_ai_results.json", "w") as f:
                    json.dump(mcsa_results, f)
                print(f"MCSA {i+1}/{len(transcripts)} generated (Gemini 2.0)", flush=True)
            else:
                print(f"Failed MCSA {i+1}", flush=True)

    # Run application script
    os.system("python3 apply_hcs_mcsa_ai.py")
    os.system("php artisan config:clear && php artisan cache:clear")

if __name__ == "__main__":
    main()
