import os
import json
import random
import time
import requests
from dotenv import load_dotenv

# Load .env variables
load_dotenv()
GROQ_API_KEY = os.getenv("GROQ_API_KEY")

if not GROQ_API_KEY:
    print("Error: GROQ_API_KEY not found in .env")
    exit(1)

# --- RESUME SETTING ---
# Jika script terhenti, ubah angka ini ke nomor soal terakhir yang berhasil.
# Contoh: jika terputus di soal ke-50, ubah ke 50.
START_FROM = 89
# ----------------------

TOTAL_ITEMS = 300

# 300 topik akademis yang beragam
TOPICS = [
    # Sains & Teknologi
    "the discovery of DNA and its implications for modern medicine",
    "how vaccines work and their role in public health",
    "the theory of relativity and its impact on our understanding of time",
    "the role of artificial intelligence in diagnosing diseases",
    "how the internet has changed global communication",
    "the science behind climate change and rising sea levels",
    "the discovery of the Higgs boson particle",
    "how CRISPR gene editing technology works",
    "the development of renewable energy sources",
    "the science of sleep and its effects on health",
    "how antibiotics work and the problem of antibiotic resistance",
    "the history and future of space exploration",
    "how machine learning algorithms learn from data",
    "the role of microplastics in ocean ecosystems",
    "the development of quantum computing",
    "how the human brain processes language",
    "the biology of cancer and modern treatment approaches",
    "the science of nutrition and its effects on longevity",
    "how GPS satellites work",
    "the impact of social media on adolescent mental health",

    # Ilmu Sosial & Humaniora
    "the causes and effects of the French Revolution",
    "how urbanization affects social inequality",
    "the psychology of decision-making under pressure",
    "the role of education in reducing poverty",
    "the history of the United Nations and international diplomacy",
    "how colonialism shaped modern Africa",
    "the psychology of conformity and social influence",
    "the economics of global trade agreements",
    "the history and evolution of democracy",
    "how language shapes culture and identity",
    "the causes of the 2008 global financial crisis",
    "the sociology of gender roles in modern society",
    "the history of the civil rights movement in America",
    "the impact of immigration on national economies",
    "the role of the free press in a democratic society",
    "the psychology of motivation and achievement",
    "how ancient civilizations influenced modern governance",
    "the ethics of artificial intelligence and automation",
    "the history of globalization and its effects on local cultures",
    "the sociology of crime and punishment",

    # Lingkungan & Ekologi
    "the Amazon rainforest and its role as Earth's lungs",
    "the causes and consequences of deforestation",
    "how coral reefs are formed and why they are under threat",
    "the water cycle and freshwater scarcity",
    "the concept of biodiversity and its importance to ecosystems",
    "the impact of industrial farming on the environment",
    "the role of wetlands in flood prevention",
    "how wildfires are connected to climate change",
    "the melting of polar ice caps and its global effects",
    "how cities can become more sustainable",

    # Ekonomi & Bisnis
    "the principles of supply and demand in a free market",
    "how inflation affects the purchasing power of consumers",
    "the role of central banks in managing national economies",
    "the concept of microfinance and its impact on poverty",
    "the economics of the sharing economy",
    "how cryptocurrency challenges traditional banking",
    "the history of the stock market and financial crashes",
    "the role of entrepreneurship in economic growth",
    "the impact of automation on the future of work",
    "the concept of corporate social responsibility",

    # Seni & Budaya
    "the influence of the Renaissance on Western art",
    "how music therapy is used in healthcare",
    "the history and cultural significance of the Olympic Games",
    "the role of museums in preserving cultural heritage",
    "how architecture reflects the values of a society",
    "the evolution of cinema from silent films to digital age",
    "the cultural impact of Shakespeare's works",
    "the history of photography and its role in journalism",
    "how video games have become a form of art and storytelling",
    "the role of folklore in preserving indigenous cultures",
]

# Perpanjang topics hingga 300 dengan perulangan dan variasi
while len(TOPICS) < TOTAL_ITEMS:
    TOPICS.extend(TOPICS[:TOTAL_ITEMS - len(TOPICS)])

# Pastikan tidak ada duplikat topic berurutan
random.shuffle(TOPICS)

voices = ["af_bella", "af_sky", "am_fenrir", "am_michael", "af_heart",
          "bf_emma", "bf_isabella", "bm_george", "bm_lewis"]


def generate_sst_transcript(topic, length_seconds, retries=5):
    """Generate a single academic SST transcript using Groq API."""
    # 150 wpm average speaking rate
    word_count = int(length_seconds * 2.5)

    system_prompt = f"""You are an expert PTE Academic content creator specializing in Summarize Spoken Text (SST) tasks.
Your task is to write an academic lecture transcript on the given topic.

Output MUST be a strict JSON object with a SINGLE key 'transcript'.
Example: {{"transcript": "Today, we will explore..."}}

Guidelines:
- The lecture must be approximately {word_count} words long ({length_seconds} seconds of speaking).
- Write in a natural academic lecture style, as if a university professor is speaking.
- The content must be factually accurate, educational, and cover multiple aspects of the topic.
- DO NOT use bullet points, headings, or markdown. Write only in flowing paragraphs.
- DO NOT include any meta-text like "Transcript:" or "Lecture:".
- The transcript should start directly with the lecture content (e.g., "Today we will examine...", "In recent decades...", "The concept of...").
"""

    prompt = f"Write an academic lecture transcript about: '{topic}'"

    headers = {
        "Authorization": f"Bearer {GROQ_API_KEY}",
        "Content-Type": "application/json"
    }

    payload = {
        "model": "llama-3.1-8b-instant",
        "messages": [
            {"role": "system", "content": system_prompt},
            {"role": "user", "content": prompt}
        ],
        "temperature": 0.75,
        "max_tokens": 1024,
        "response_format": {"type": "json_object"}
    }

    for attempt in range(retries):
        try:
            response = requests.post(
                "https://api.groq.com/openai/v1/chat/completions",
                json=payload, headers=headers, timeout=30
            )
            response.raise_for_status()
            content = response.json()['choices'][0]['message']['content']
            data = json.loads(content)
            return data.get("transcript", "")
        except requests.exceptions.HTTPError as e:
            if response.status_code == 429:
                sleep_time = (2 ** attempt) + random.uniform(1, 2)
                print(f"    ⏳ Rate limited. Retrying in {sleep_time:.1f}s...")
                time.sleep(sleep_time)
            else:
                print(f"    ❌ HTTP Error: {e}")
                return None
        except Exception as e:
            print(f"    ❌ Error: {e}")
            if attempt < retries - 1:
                time.sleep(2)
    return None


def main():
    json_path = "/Applications/MAMP/htdocs/TargetBahasaCourse/PTE/sst_topics.json"

    # Load existing data if resuming
    existing_data = []
    if START_FROM > 0 and os.path.exists(json_path):
        with open(json_path, 'r') as f:
            existing_data = json.load(f)
        print(f"📂 Resuming from item {START_FROM}. Loaded {len(existing_data)} existing items.")

    print(f"\n🚀 Generating SST academic transcripts ({START_FROM + 1} to {TOTAL_ITEMS})...\n")

    for i in range(START_FROM, TOTAL_ITEMS):
        topic = TOPICS[i]
        # Durasi bervariasi: 60-120 detik (untuk SST biasanya 60-90s)
        length_seconds = random.randint(60, 120)
        voice = random.choice(voices)
        filename = f"sst_topic_{i}.mp3"

        print(f"[{i+1}/{TOTAL_ITEMS}] 📚 Topic: {topic[:60]}... ({length_seconds}s)")

        transcript = generate_sst_transcript(topic, length_seconds)

        if not transcript or len(transcript.strip()) < 50:
            print(f"    ⚠️  Failed to generate, skipping.")
            continue

        word_count = len(transcript.split())
        print(f"    ✅ Generated: {word_count} words")

        item = {
            "id": i,
            "text": transcript,
            "voice": voice,
            "filename": filename,
            "folder": "kokoro-tts/summarize-spoken-text"
        }

        existing_data.append(item)

        # Save progress after every item
        with open(json_path, 'w', encoding='utf-8') as f:
            json.dump(existing_data, f, indent=4, ensure_ascii=False)

        # Sleep to avoid rate limiting
        time.sleep(1.5)

    print(f"\n🎉 DONE! Generated {len(existing_data)} SST topics.")
    print(f"📁 Saved to: {json_path}")


if __name__ == "__main__":
    main()
