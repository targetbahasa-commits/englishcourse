import json
import random

templates = [
    {
        "passage": "B-15 broke off from the Ross Ice Shelf in Antarctica. It was the largest iceberg ever documented, with a surface area of more than 4,200 square miles - more than twice the size of the state of Delaware. After it started breaking up, the largest of its pieces, B-15a, drifted along the coast of Antarctica, lingered on a shallow seamount, and collided with an ice tongue, before running aground and breaking again. Late in 2007, the largest remaining chunk floated out into the South Pacific where, in the warmer water, it began to disintegrate.",
        "question": "Where did the largest piece off from B-15 eventually go?",
        "correct_option": "South Pacific",
        "distractors": ["Chile", "Seafloor", "Antarctica"]
    },
    {
        "passage": "The first printed books were often created to look like the handwritten manuscripts they replaced. Early printers went to great lengths to imitate the scribal handwriting styles of their regions. In Germany, for example, the Gothic typeface became standard because it closely resembled the local manuscript hand. This mimicking of the old form in a new medium helped to ease the transition for readers who were accustomed to handwritten texts.",
        "question": "Why did early printed books resemble handwritten manuscripts?",
        "correct_option": "To ease the transition for readers",
        "distractors": ["Because printers lacked original ideas", "To save on printing costs", "Because Gothic typeface was cheaper"]
    },
    {
        "passage": "A new study reveals that honeybees can understand the concept of zero, a mathematical notion previously thought to be exclusive to humans and a few other highly intelligent animals, like dolphins and primates. Researchers trained bees to choose the smaller of two numbers displayed on screens. When presented with a blank screen alongside a screen with one object, the bees consistently chose the blank screen, demonstrating an understanding of 'zero' as a quantity less than one.",
        "question": "What did the recent study discover about honeybees?",
        "correct_option": "They understand the concept of zero",
        "distractors": ["They are as intelligent as dolphins", "They can count up to ten", "They prefer blank screens over images"]
    },
    {
        "passage": "The Great Wall of China is not a single continuous wall, but rather a collection of walls and fortifications built across different dynasties. The most famous and best-preserved sections were built during the Ming Dynasty (1368-1644) to protect the Chinese Empire from nomadic incursions from the north. Unlike earlier walls made of rammed earth, the Ming walls were constructed primarily of brick and stone, making them much more formidable.",
        "question": "What material was primarily used for the Ming Dynasty sections of the Great Wall?",
        "correct_option": "Brick and stone",
        "distractors": ["Rammed earth", "Wood and iron", "Concrete and steel"]
    },
    {
        "passage": "Sleep is crucial for cognitive function, particularly for memory consolidation. During the deep stages of sleep, the brain actively reorganizes and strengthens neural connections formed during the day. This process helps transform short-term memories into long-term ones. Individuals who consistently lack adequate sleep often struggle with recall and cognitive processing, highlighting the vital role rest plays in learning.",
        "question": "What is the primary cognitive benefit of deep sleep mentioned in the passage?",
        "correct_option": "Memory consolidation",
        "distractors": ["Muscle repair", "Emotional regulation", "Increased alertness"]
    },
    {
        "passage": "The invention of the telegraph in the 19th century revolutionized communication. Before its advent, information could only travel as fast as a horse or a train. The telegraph allowed messages to be transmitted almost instantaneously over long distances via electrical signals. This breakthrough significantly impacted business, journalism, and personal communication, laying the groundwork for the modern interconnected world.",
        "question": "How did the telegraph impact the speed of communication?",
        "correct_option": "It allowed near-instantaneous transmission",
        "distractors": ["It replaced the need for trains", "It made communication slightly faster", "It slowed down business transactions"]
    }
]

topics_php = "<?php\n\nreturn [\n"

alphabet = ['A', 'B', 'C', 'D']

for i in range(1, 301):
    template = random.choice(templates)
    
    passage = template["passage"]
    question = template["question"]
    correct_option = template["correct_option"]
    distractors = template["distractors"]
    
    options = distractors + [correct_option]
    random.shuffle(options)
    
    correct_letter = alphabet[options.index(correct_option)]
    
    p_safe = passage.replace("'", "\\'")
    q_safe = question.replace("'", "\\'")
    
    topics_php += "    [\n"
    topics_php += f"        'passage' => '{p_safe}',\n"
    topics_php += f"        'question' => '{q_safe}',\n"
    
    topics_php += f"        'options' => [\n"
    for opt in options:
        opt_safe = opt.replace("'", "\\'")
        topics_php += f"            '{opt_safe}',\n"
    topics_php += f"        ],\n"
    
    topics_php += f"        'correctAnswer' => '{correct_letter}'\n"
    topics_php += "    ],\n"

topics_php += "];\n"

with open("config/pte_reading_mcsa_topics.php", "w") as f:
    f.write(topics_php)

print("Successfully generated 300 topics for MCSA.")
