import json
import random
import re

# Load source texts (we will take text from sst_topics but shuffle it so it's not identical in order)
with open('/Applications/MAMP/htdocs/TargetBahasaCourse/PTE/sst_topics.json', 'r') as f:
    sst_data = json.load(f)

texts = [item['text'] for item in sst_data if len(item['text'].split()) > 40]
random.seed(42)
random.shuffle(texts)

# Fallback words to substitute
substitute_pool = [
    "tragedy", "apple", "window", "banana", "guitar", "elephant", "computer", "mountain", "river", "ocean",
    "quickly", "happily", "sadly", "dangerously", "safely", "loudly", "quietly", "softly", "beautifully",
    "red", "blue", "green", "yellow", "orange", "purple", "black", "white", "gray", "brown",
    "car", "bus", "train", "airplane", "bicycle", "motorcycle", "boat", "ship", "helicopter",
    "run", "walk", "jump", "swim", "fly", "crawl", "climb", "dive", "slide", "skate",
    "happy", "sad", "angry", "surprised", "scared", "disgusted", "tired", "hungry", "thirsty",
    "strategic", "logical", "physical", "chemical", "biological", "historical", "mathematical", "philosophical"
]

voices = ['am_michael', 'af_heart', 'am_fenrir', 'af_sky', 'af_bella', 'am_adam']

hiw_data = []

for i in range(300):
    text_source = texts[i % len(texts)]
    words = text_source.split()
    
    # We want to replace 4 to 6 words
    num_replacements = random.randint(4, 6)
    
    # Choose indices to replace (avoid first and last few words, and avoid very short words)
    valid_indices = [idx for idx, w in enumerate(words) if len(re.sub(r'[^\w\s]', '', w)) > 4]
    
    if len(valid_indices) < num_replacements:
        replace_indices = valid_indices
    else:
        replace_indices = random.sample(valid_indices, num_replacements)
        
    incorrect_words = []
    modified_words = list(words)
    
    for idx in replace_indices:
        original_word = modified_words[idx]
        # Keep punctuation intact
        match = re.match(r'^([^\w]*)([\w]+)([^\w]*)$', original_word)
        if match:
            prefix, core, suffix = match.groups()
            sub = random.choice(substitute_pool)
            modified_words[idx] = prefix + sub + suffix
            incorrect_words.append(sub.lower())
        else:
            sub = random.choice(substitute_pool)
            modified_words[idx] = sub
            incorrect_words.append(sub.lower())
            
    audio_text = text_source
    display_text = " ".join(modified_words)
    
    hiw_data.append({
        "id": i,
        "audio_text": audio_text,
        "text": display_text,
        "incorrect_words": incorrect_words,
        "voice": random.choice(voices),
        "filename": f"hiw_topic_{i}.mp3",
        "folder": "kokoro-tts/highlight-incorrect-words"
    })

with open('/Applications/MAMP/htdocs/TargetBahasaCourse/PTE/highlight_incorrect_words.json', 'w') as f:
    json.dump(hiw_data, f, indent=4)

print("Generated 300 HIW items.")
