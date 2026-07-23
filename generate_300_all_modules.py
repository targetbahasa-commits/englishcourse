import urllib.request
import re
import random
import ftplib
import json
import os

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

voices = ['af_bella', 'af_sky', 'am_fenrir', 'am_michael', 'af_heart']

print("Reading source text from local pg2009.txt (Wikipedia Academic Articles)...")
with open("pg2009.txt", "r", encoding="utf-8") as f:
    combined_text = f.read()

# Stopwords to filter out simple words
stopwords = set([
    "the", "and", "of", "to", "in", "is", "that", "it", "he", "was", "for", "on", "are", "as", "with", "his", "they", 
    "but", "not", "what", "all", "were", "we", "when", "your", "can", "said", "there", "use", "an", "each", "which", 
    "she", "how", "their", "if", "will", "up", "other", "about", "out", "many", "then", "them", "these", "so", "some", 
    "her", "would", "him", "into", "has", "more", "two", "like", "himself", "herself", "themselves", "their", "ourselves",
    "this", "have", "from", "had", "been", "only", "than", "very", "who", "its", "which", "after", "before", "should"
])

# Extract sentences
sentences = []
sents = re.split(r'(?<=[.!?])\s+', combined_text)
for s in sents:
    s = re.sub(r'\s+', ' ', s).strip()
    words = re.findall(r'\b[A-Za-z]+\b', s)
    if 10 <= len(words) <= 22 and len(s) < 160:
        # Avoid sentences containing Gutenberg headers
        if not any(x in s for x in ["Gutenberg", "License", "Project", "http"]):
            sentences.append(s)

sentences = list(set(sentences))
random.shuffle(sentences)
print(f"Collected {len(sentences)} short sentences.")

# Clean up newlines for paragraph extraction
paragraphs = re.split(r'\n+', combined_text)
clean_paragraphs = []
for p in paragraphs:
    p = re.sub(r'\s+', ' ', p).strip()
    # Paragraphs should be clean and of academic size (30 - 250 words)
    if 30 <= len(p.split()) <= 250:
        if not any(x in p for x in ["Gutenberg", "License", "Project", "http", "Illustration"]):
            clean_paragraphs.append(p)

clean_paragraphs = list(set(clean_paragraphs))
random.shuffle(clean_paragraphs)
print(f"Collected {len(clean_paragraphs)} paragraphs.")

# Extract academic vocabulary (words longer than 5 chars, not in stopwords)
vocab = []
for word in re.findall(r'\b[a-zA-Z]{6,15}\b', combined_text):
    w_lower = word.lower()
    if w_lower not in stopwords:
        vocab.append(w_lower)
vocab = list(set(vocab))
print(f"Academic vocabulary size: {len(vocab)} words.")

# Helper to get academic words from a specific text
def get_words_from_text(text, num=2):
    found = []
    for word in re.findall(r'\b[a-zA-Z]{6,15}\b', text):
        w_lower = word.lower()
        if w_lower not in stopwords and w_lower not in found:
            found.append(word) # keep original casing
    if len(found) < num:
        # fallback
        found += random.sample(vocab, num - len(found))
    return random.sample(found, num)

# Trivia QA for Short Questions
print("Generating Short Questions...")
qa_pairs = []
base_qa = [
    ("What is the opposite of hot?", "cold"),
    ("What is the opposite of day?", "night"),
    ("What day comes after Sunday?", "Monday"),
    ("How many months are in a year?", "twelve"),
    ("What is the color of the sky on a clear day?", "blue"),
    ("How many hours are in a day?", "twenty-four"),
    ("What is the capital of France?", "Paris"),
    ("What is the freezing point of water in Celsius?", "zero"),
    ("How many days are in a week?", "seven"),
    ("What do you use to write on a blackboard?", "chalk"),
    ("What is the opposite of large?", "small"),
    ("What instrument is used to measure temperature?", "thermometer"),
    ("What is the name of the planet we live on?", "Earth"),
    ("What force pulls objects toward the center of the Earth?", "gravity"),
    ("What is the opposite of fast?", "slow"),
    ("What season comes after winter?", "spring"),
    ("What is the main source of light for the Earth?", "sun"),
    ("How many legs does a spider have?", "eight"),
    ("What do bees make using pollen and nectar?", "honey"),
    ("What is the opposite of wet?", "dry")
]
days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"]
months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]

for i in range(len(days)):
    qa_pairs.append((f"What day comes after {days[i]}?", days[(i+1)%7]))
    qa_pairs.append((f"What day comes before {days[i]}?", days[(i-1)%7]))

for i in range(len(months)):
    qa_pairs.append((f"What month comes after {months[i]}?", months[(i+1)%12]))
    qa_pairs.append((f"What month comes before {months[i]}?", months[(i-1)%12]))

for i in range(1, 150):
    qa_pairs.append((f"What is {i} plus {i}?", str(i+i)))
    qa_pairs.append((f"What is {i+1} minus one?", str(i)))
    qa_pairs.append((f"What is {i} times two?", str(i*2)))

qa_pairs = qa_pairs + base_qa
random.shuffle(qa_pairs)
qa_pairs = list(set(qa_pairs))[:300]


# Helper to escape PHP strings
def esc(s):
    return s.replace("'", "\\'")

configs_to_write = []

# 1. pte_answer_short_question
php1 = "<?php\n\nreturn [\n"
for i in range(300):
    q, a = qa_pairs[i%len(qa_pairs)]
    php1 += f"  {i} => [\n"
    php1 += f"    'transcript' => '{esc(q)}',\n"
    php1 += f"    'options' => ['{esc(a)}', 'I dont know'],\n"
    php1 += f"    'correct_answer' => '{esc(a)}',\n"
    php1 += f"    'voice' => '{random.choice(voices)}',\n"
    php1 += f"  ],\n"
php1 += "];\n"
configs_to_write.append(("config/pte_answer_short_question.php", php1))

# 2. pte_highlight_correct_summary
php2 = "<?php\n\nreturn [\n"
for i in range(300):
    p = clean_paragraphs[i%len(clean_paragraphs)]
    # Extract first sentence as correct summary
    sentences_in_p = re.split(r'(?<=[.!?])\s+', p)
    correct = sentences_in_p[0]
    if len(correct.split()) < 8 and len(sentences_in_p) > 1:
        correct = sentences_in_p[0] + " " + sentences_in_p[1]
        
    fakes = []
    for offset in [1, 2, 3]:
        other_p = clean_paragraphs[(i + offset * 7) % len(clean_paragraphs)]
        other_sents = re.split(r'(?<=[.!?])\s+', other_p)
        fakes.append(other_sents[0])
        
    options = [correct] + fakes
    random.shuffle(options)
    php2 += f"  {i} => [\n"
    php2 += f"    'transcript' => '{esc(p)}',\n"
    php2 += f"    'options' => [\n"
    for opt in options:
        php2 += f"      '{esc(opt)}',\n"
    php2 += f"    ],\n"
    php2 += f"    'correct_answer' => '{esc(correct)}',\n"
    php2 += f"    'voice' => '{random.choice(voices)}',\n"
    php2 += f"  ],\n"
php2 += "];\n"
configs_to_write.append(("config/pte_highlight_correct_summary.php", php2))

# 3. pte_highlight_incorrect_words
php3 = "<?php\n\nreturn [\n"
for i in range(300):
    s = sentences[i%len(sentences)]
    words = s.split()
    
    # Find words to change (length > 5, not capitalized, not stopwords)
    eligible_indices = []
    for idx, w in enumerate(words):
        cleaned = re.sub(r'[^A-Za-z]', '', w)
        if len(cleaned) > 5 and cleaned.islower() and cleaned not in stopwords:
            eligible_indices.append(idx)
            
    num_errors = min(3, len(eligible_indices))
    if num_errors == 0:
        # Fallback to any word > 4 chars
        for idx, w in enumerate(words):
            cleaned = re.sub(r'[^A-Za-z]', '', w)
            if len(cleaned) > 4 and cleaned.islower():
                eligible_indices.append(idx)
        num_errors = min(2, len(eligible_indices))
        
    idx_to_change = random.sample(eligible_indices, num_errors) if eligible_indices else []
    text_words = words.copy()
    incorrect_words = []
    for idx in idx_to_change:
        original = re.sub(r'[^A-Za-z]', '', words[idx])
        original_clean = original.lower()
        # Find a vocab word of similar length
        similar_words = [v for v in vocab if abs(len(v) - len(original_clean)) <= 1 and v != original_clean]
        if similar_words:
            fake = random.choice(similar_words)
            # Retain original casing/punctuation
            if words[idx].istitle():
                fake = fake.title()
            # Restore punctuation
            pfx = re.match(r'^[^A-Za-z]+', words[idx])
            sfx = re.search(r'[^A-Za-z]+$', words[idx])
            pfx_str = pfx.group(0) if pfx else ""
            sfx_str = sfx.group(0) if sfx else ""
            
            text_words[idx] = pfx_str + fake + sfx_str
            incorrect_words.append(fake)
            
    text = " ".join(text_words)
    php3 += f"  {i} => [\n"
    php3 += f"    'transcript' => '{esc(s)}',\n"
    php3 += f"    'text' => '{esc(text)}',\n"
    php3 += f"    'incorrect_words' => [\n"
    for w in incorrect_words:
        php3 += f"      '{esc(w)}',\n"
    php3 += f"    ],\n"
    php3 += f"    'voice' => '{random.choice(voices)}',\n"
    php3 += f"  ],\n"
php3 += "];\n"
configs_to_write.append(("config/pte_highlight_incorrect_words.php", php3))

# 4. pte_listening_mcma
php4 = "<?php\n\nreturn [\n"
for i in range(300):
    p = clean_paragraphs[(i+300)%len(clean_paragraphs)]
    # Extract 2 real academic words from this paragraph
    corrects = get_words_from_text(p, 2)
    # Extract 2 fakes from other paragraphs
    fakes = []
    attempts = 0
    while len(fakes) < 2 and attempts < 20:
        attempts += 1
        other_p = clean_paragraphs[(i + 50 + len(fakes)*13) % len(clean_paragraphs)]
        other_words = get_words_from_text(other_p, 2)
        for ow in other_words:
            if ow.lower() not in p.lower() and ow.lower() not in [f.lower() for f in fakes]:
                fakes.append(ow)
                if len(fakes) == 2: break
                
    if len(fakes) < 2:
        fakes = random.sample(vocab, 2)
        
    options = corrects + fakes
    random.shuffle(options)
    mcma_qs = [
        "Which of the following terms or concepts are mentioned in the passage?",
        "According to the lecture, which of the following statements are correct? (Choose multiple)",
        "What are the main points discussed by the speaker?",
        "Which of the following concepts are primarily discussed in the lecture?",
        "Select all the topics that are mentioned in the text."
    ]
    q = random.choice(mcma_qs)
    php4 += f"  {i} => [\n"
    php4 += f"    'transcript' => '{esc(p)}',\n"
    php4 += f"    'question' => '{q}',\n"
    php4 += f"    'options' => [\n"
    for opt in options:
        php4 += f"      '{esc(opt)}',\n"
    php4 += f"    ],\n"
    php4 += f"    'correct_answers' => [\n"
    for corr in corrects:
        php4 += f"      '{esc(corr)}',\n"
    php4 += f"    ],\n"
    php4 += f"    'voice' => '{random.choice(voices)}',\n"
    php4 += f"  ],\n"
php4 += "];\n"
configs_to_write.append(("config/pte_listening_mcma.php", php4))

# 5. pte_listening_mcsa
php5 = "<?php\n\nreturn [\n"
for i in range(300):
    p = clean_paragraphs[(i+600)%len(clean_paragraphs)]
    correct = get_words_from_text(p, 1)[0]
    
    fakes = []
    attempts = 0
    while len(fakes) < 3 and attempts < 30:
        attempts += 1
        other_p = clean_paragraphs[(i + 120 + len(fakes)*17) % len(clean_paragraphs)]
        other_words = get_words_from_text(other_p, 2)
        for ow in other_words:
            if ow.lower() not in p.lower() and ow.lower() not in [f.lower() for f in fakes]:
                fakes.append(ow)
                if len(fakes) == 3: break
                
    if len(fakes) < 3:
        fakes = random.sample(vocab, 3)
        
    options = [correct] + fakes
    random.shuffle(options)
    mcsa_qs = [
        "What is the primary subject or concept discussed in this passage?",
        "According to the lecture, which of the following is true?",
        "What is the main topic of the speaker's discussion?",
        "Which of the following best summarizes the speaker's point?",
        "Which concept is primarily discussed in the lecture?"
    ]
    q = random.choice(mcsa_qs)
    php5 += f"  {i} => [\n"
    php5 += f"    'transcript' => '{esc(p)}',\n"
    php5 += f"    'question' => '{q}',\n"
    php5 += f"    'options' => [\n"
    for opt in options:
        php5 += f"      '{esc(opt)}',\n"
    php5 += f"    ],\n"
    php5 += f"    'correct_answer' => '{esc(correct)}',\n"
    php5 += f"    'voice' => '{random.choice(voices)}',\n"
    php5 += f"  ],\n"
php5 += "];\n"
configs_to_write.append(("config/pte_listening_mcsa.php", php5))

# 6. pte_repeat_sentence
php6 = "<?php\n\nreturn [\n"
for i in range(300):
    s = sentences[(i+300)%len(sentences)]
    php6 += f"  {i+1} => [\n"
    php6 += f"    'title' => 'Topic #{i+1:03d}',\n"
    php6 += f"    'content' => '{esc(s)}',\n"
    php6 += f"  ],\n"
php6 += "];\n"
configs_to_write.append(("config/pte_repeat_sentence.php", php6))

# 7. pte_retell_lecture
php7 = "<?php\n\nreturn [\n"
for i in range(300):
    p = clean_paragraphs[(i+900)%len(clean_paragraphs)]
    k = get_words_from_text(p, 3)
    php7 += f"  {i} => [\n"
    php7 += f"    'transcript' => '{esc(p)}',\n"
    php7 += f"    'key_points' => ['{esc(k[0])}', '{esc(k[1])}', '{esc(k[2])}'],\n"
    php7 += f"    'voice' => '{random.choice(voices)}',\n"
    php7 += f"  ],\n"
php7 += "];\n"
configs_to_write.append(("config/pte_retell_lecture.php", php7))

# 8. pte_select_missing_word
php8 = "<?php\n\nreturn [\n"
for i in range(300):
    s = sentences[(i+600)%len(sentences)]
    words = s.split()
    if len(words) < 5: 
        s = sentences[(i+1200)%len(sentences)]
        words = s.split()
    
    last_word_full = words[-1]
    last_word_clean = re.sub(r'[^A-Za-z]', '', last_word_full)
    
    # Retain punctuation at the end of the beep
    pfx = re.match(r'^[^A-Za-z]+', last_word_full)
    sfx = re.search(r'[^A-Za-z]+$', last_word_full)
    pfx_str = pfx.group(0) if pfx else ""
    sfx_str = sfx.group(0) if sfx else ""
    
    words[-1] = pfx_str + "[beep]" + sfx_str
    text = " ".join(words)
    
    # Choose 3 fakes of similar length
    similar_vocab = [v for v in vocab if abs(len(v) - len(last_word_clean)) <= 2 and v.lower() != last_word_clean.lower()]
    if len(similar_vocab) < 3:
        similar_vocab = vocab
    fakes = random.sample(similar_vocab, 3)
    
    options = [last_word_clean] + fakes
    random.shuffle(options)
    
    php8 += f"  {i} => [\n"
    php8 += f"    'transcript' => '{esc(text)}',\n"
    php8 += f"    'options' => [\n"
    for opt in options:
        php8 += f"      '{esc(opt)}',\n"
    php8 += f"    ],\n"
    php8 += f"    'correct_answer' => '{esc(last_word_clean)}',\n"
    php8 += f"    'voice' => '{random.choice(voices)}',\n"
    php8 += f"  ],\n"
php8 += "];\n"
configs_to_write.append(("config/pte_select_missing_word.php", php8))

# 9. pte_listening_sst_topics
php9 = "<?php\n\nreturn [\n"
for i in range(300):
    p = clean_paragraphs[(i+1200)%len(clean_paragraphs)]
    k = get_words_from_text(p, 4)
    php9 += f"  {i} => [\n"
    php9 += f"    'transcript' => '{esc(p)}',\n"
    php9 += f"    'key_points' => ['{esc(k[0])}', '{esc(k[1])}', '{esc(k[2])}', '{esc(k[3])}'],\n"
    php9 += f"    'voice' => '{random.choice(voices)}',\n"
    php9 += f"  ],\n"
php9 += "];\n"
configs_to_write.append(("config/pte_listening_sst_topics.php", php9))

# 10. pte_write_from_dictation
php10 = "<?php\n\nreturn [\n"
for i in range(300):
    s = sentences[(i+900)%len(sentences)]
    php10 += f"  {i} => [\n"
    php10 += f"    'transcript' => '{esc(s)}',\n"
    php10 += f"    'voice' => '{random.choice(voices)}',\n"
    php10 += f"  ],\n"
php10 += "];\n"
configs_to_write.append(("config/pte_write_from_dictation.php", php10))


print("Saving files locally and uploading to FTP...")
ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)

for local_path, content in configs_to_write:
    with open(local_path, "w") as f:
        f.write(content)
    
    filename = os.path.basename(local_path)
    remote_path = f"/domains/targetbahasa.com/public_html/config/{filename}"
    with open(local_path, 'rb') as f:
        ftp.storbinary(f"STOR {remote_path}", f)
    print(f"Uploaded {filename}")

ftp.quit()
print("All configs generated and uploaded successfully.")
