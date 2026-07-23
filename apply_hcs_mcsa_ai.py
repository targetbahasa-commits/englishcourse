import json
import random
import re

def escape_str(s):
    if not isinstance(s, str):
        return ""
    return s.replace("'", "\\'")

def write_hcs():
    with open("hcs_ai_results.json", "r") as f:
        data = json.load(f)
    
    with open("config/pte_listening_fib.php", "r", encoding="utf-8") as f:
        content = f.read()
    transcripts = [m.group(1).replace("\\'", "'") for m in re.finditer(r"'transcript'\s*=>\s*'(.*?(?<!\\))'", content)]
    
    voices = ["af_bella", "af_sky", "af_heart", "am_michael", "am_fenrir", "am_adam"]
    
    php = "<?php\n\nreturn [\n"
    for i in range(300):
        t = transcripts[i]
        d = data[i]
        
        if not d:
            d = {
                "options": ["Error generation", "Distractor 1", "Distractor 2", "Distractor 3"],
                "correct_answer": "Error generation"
            }
        
        options = d.get("options", [])
        if not isinstance(options, list):
            options = ["Error generation"] * 4
            
        correct = d.get("correct_answer", "")
        # Ensure correct is in options
        if correct not in options and len(options) >= 1:
            options[0] = correct
            
        # Shuffle options
        random.shuffle(options)
        
        voice = random.choice(voices)
        
        php += f"  {i} => [\n"
        php += f"    'transcript' => '{escape_str(t)}',\n"
        php += f"    'options' => [\n"
        for opt in options:
            php += f"      '{escape_str(opt)}',\n"
        php += f"    ],\n"
        php += f"    'correct_answer' => '{escape_str(correct)}',\n"
        php += f"    'voice' => '{voice}',\n"
        php += f"    'folder' => 'kokoro-tts/listening-fill-blanks',\n"
        php += f"    'filename' => 'lfb_topic_{i}.mp3',\n"
        php += f"  ],\n"
    php += "];\n"
    
    with open("config/pte_highlight_correct_summary.php", "w", encoding="utf-8") as f:
        f.write(php)

def write_mcsa():
    with open("mcsa_ai_results.json", "r") as f:
        data = json.load(f)
    
    with open("config/pte_listening_fib.php", "r", encoding="utf-8") as f:
        content = f.read()
    transcripts = [m.group(1).replace("\\'", "'") for m in re.finditer(r"'transcript'\s*=>\s*'(.*?(?<!\\))'", content)]
    
    voices = ["af_bella", "af_sky", "af_heart", "am_michael", "am_fenrir", "am_adam"]
    
    php = "<?php\n\nreturn [\n"
    for i in range(300):
        t = transcripts[i]
        d = data[i]
        
        if not d:
            d = {
                "question": "What is the main topic?",
                "options": ["Error", "Distractor 1", "Distractor 2", "Distractor 3"],
                "correct_answer": "Error"
            }
        
        question = d.get("question", "What is the main topic?")
        options = d.get("options", [])
        if not isinstance(options, list):
            options = ["Error"] * 4
            
        correct = d.get("correct_answer", "")
        if correct not in options and len(options) >= 1:
            options[0] = correct
            
        random.shuffle(options)
        
        voice = random.choice(voices)
        
        php += f"  {i} => [\n"
        php += f"    'transcript' => '{escape_str(t)}',\n"
        php += f"    'question' => '{escape_str(question)}',\n"
        php += f"    'options' => [\n"
        for opt in options:
            php += f"      '{escape_str(opt)}',\n"
        php += f"    ],\n"
        php += f"    'correct_answer' => '{escape_str(correct)}',\n"
        php += f"    'voice' => '{voice}',\n"
        php += f"    'folder' => 'kokoro-tts/listening-fill-blanks',\n"
        php += f"    'filename' => 'lfb_topic_{i}.mp3',\n"
        php += f"  ],\n"
    php += "];\n"
    
    with open("config/pte_listening_mcsa.php", "w", encoding="utf-8") as f:
        f.write(php)

if __name__ == '__main__':
    write_hcs()
    write_mcsa()
