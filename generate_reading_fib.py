import json
import random

subjects = [
    "technology", "education", "the environment", "globalization", "social media",
    "public health", "tourism", "remote work", "space exploration", "artificial intelligence",
    "history of science", "urban planning", "renewable energy", "psychology", "modern art"
]

adjectives = ["crucial", "integral", "essential", "vital", "fundamental"]
verbs = ["developed", "created", "designed", "built", "established"]
adjectives2 = ["diverse", "various", "multiple", "numerous", "countless"]
verbs2 = ["incorporated", "integrated", "embedded", "included", "added"]
distractors_list = ["reverse", "frugal", "mixed", "static", "ignored", "limited", "abandoned", "narrow"]

topics_php = "<?php\n\nreturn [\n"

for i in range(1, 301):
    subject = random.choice(subjects)
    word1 = random.choice(adjectives)
    word2 = random.choice(verbs)
    word3 = random.choice(adjectives2)
    word4 = random.choice(verbs2)
    
    passage = f"The study of {subject}, <div class=\"blank-space dropzone\" data-id=\"blank1\"></div> to our understanding of the modern world, emerged from complex historical shifts. Initially <div class=\"blank-space dropzone\" data-id=\"blank2\"></div> for specific regional purposes, its concepts evolved to address global challenges. Today, it is widely applied across <div class=\"blank-space dropzone\" data-id=\"blank3\"></div> fields ranging from policy making to cultural studies. Furthermore, it is constantly evolving as new theories and methodologies are <div class=\"blank-space dropzone\" data-id=\"blank4\"></div> into academic curricula every year."
    
    correct_answers = {
        "blank1": word1,
        "blank2": word2,
        "blank3": word3,
        "blank4": word4
    }
    
    # 3 distractors
    distractors = random.sample(distractors_list, 3)
    words = [word1, word2, word3, word4] + distractors
    random.shuffle(words)
    
    topics_php += "    [\n"
    topics_php += f"        'passage' => '{passage}',\n"
    
    topics_php += f"        'words' => [\n"
    for w in words:
        topics_php += f"            '{w}',\n"
    topics_php += f"        ],\n"
    
    topics_php += f"        'correctAnswers' => [\n"
    for k, v in correct_answers.items():
        topics_php += f"            '{k}' => '{v}',\n"
    topics_php += f"        ]\n"
    topics_php += "    ],\n"

topics_php += "];\n"

with open("config/pte_reading_fill_blanks_topics.php", "w") as f:
    f.write(topics_php)

print("Successfully generated 300 topics.")
