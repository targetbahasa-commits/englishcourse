import json
import random
import string

subjects = [
    "technology", "education", "the environment", "globalization", "social media",
    "public health", "tourism", "remote work", "space exploration", "artificial intelligence",
    "history of science", "urban planning", "renewable energy", "psychology", "modern art"
]

templates = [
    [
        "The concept of {Subject} has fundamentally changed how we live.",
        "Initially, many people were skeptical about its potential impact.",
        "However, as time passed, its benefits became undeniable.",
        "Today, it is considered an essential part of modern society."
    ],
    [
        "Research into {Subject} has accelerated in recent decades.",
        "Early studies focused primarily on identifying the core challenges.",
        "Subsequent breakthroughs provided innovative solutions to these problems.",
        "Future research is expected to explore even more advanced applications."
    ],
    [
        "The impact of {Subject} on our daily lives is profound.",
        "A few years ago, it was merely a niche topic of discussion.",
        "Now, it dominates global conversations and policy decisions.",
        "Experts believe this trend will only continue to grow."
    ],
    [
        "Understanding {Subject} is critical for future generations.",
        "Schools are beginning to incorporate it into their curricula.",
        "This ensures that students are well-prepared for upcoming challenges.",
        "Ultimately, education is the key to mastering this complex field."
    ]
]

topics_php = "<?php\n\nreturn [\n"

for i in range(1, 301):
    subject = random.choice(subjects)
    template = random.choice(templates)
    
    # Original ordered paragraphs
    original_paras = [para.replace("{Subject}", subject) for para in template]
    
    # Create pairs of (original_index, text)
    para_objects = list(enumerate(original_paras))
    
    # Shuffle them to create the display order (A, B, C, D)
    random.shuffle(para_objects)
    
    # The shuffled array represents A, B, C, D.
    # We need to map the original index back to A, B, C, D.
    # original_paras[0] is at some position in shuffled array.
    
    alphabet = list(string.ascii_uppercase)
    display_paras = []
    correct_order_letters = [''] * len(original_paras)
    
    for display_idx, (orig_idx, text) in enumerate(para_objects):
        letter = alphabet[display_idx]
        display_paras.append(text)
        correct_order_letters[orig_idx] = letter
        
    topics_php += "    [\n"
    topics_php += f"        'paragraphs' => [\n"
    for text in display_paras:
        escaped_text = text.replace("'", "\\'")
        topics_php += f"            '{escaped_text}',\n"
    topics_php += f"        ],\n"
    
    topics_php += f"        'correctOrder' => [\n"
    for letter in correct_order_letters:
        topics_php += f"            '{letter}',\n"
    topics_php += f"        ]\n"
    topics_php += "    ],\n"

topics_php += "];\n"

with open("config/pte_reading_reorder_paragraphs_topics.php", "w") as f:
    f.write(topics_php)

print("Successfully generated 300 topics.")
