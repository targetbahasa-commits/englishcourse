import random
import json

passages = [
    {
        "text": "There's bad news for parents who frequently plop their kids in front of the TV to give themselves a break: It might actually end up leaving moms and dads more stressed. Why? Because the more television that kids watch, the more they're exposed to advertising messages. The more advertising they see, the more likely they are to insist on purchasing items when they go with their parents to the store -- and perhaps make a fuss if told 'no.' All that, researchers say, may contribute to parents' overall stress levels, well beyond a single shopping trip.",
        "question": "Which of the following statements are supported by the passage?",
        "options": [
            "Children's habit of watching TV has a potential impact on parents' stress level.",
            "When watching one television ad, children purchase one thing from it.",
            "For parents, putting their children in front of the TV tends to make themselves happy.",
            "Parents can reduce their stress by limiting their children to watch TV.",
            "Children will ask for more things when they watch more ads, which can lead to more conflict."
        ],
        "answers": ['A', 'E']
    },
    {
        "text": "The discovery of penicillin revolutionized modern medicine, turning once-deadly bacterial infections into easily treatable conditions. However, the overprescription and misuse of antibiotics in both human medicine and agriculture have led to the rise of antibiotic-resistant bacteria, often called 'superbugs.' These superbugs pose a significant threat to global public health, as standard treatments are becoming less effective, leading to longer hospital stays and higher mortality rates.",
        "question": "According to the passage, what are the consequences of antibiotic misuse?",
        "options": [
            "Bacterial infections are now entirely eradicated.",
            "The effectiveness of standard treatments has decreased.",
            "Antibiotics are no longer used in agriculture.",
            "Patients may experience longer stays in hospitals.",
            "The discovery of penicillin was a mistake."
        ],
        "answers": ['B', 'D']
    },
    {
        "text": "Urban green spaces, such as parks and community gardens, are essential for the well-being of city dwellers. Not only do they provide a recreational area for physical activities, but they also act as 'green lungs' for the city, absorbing carbon dioxide and reducing the urban heat island effect. Furthermore, studies have shown that access to nature can significantly lower stress levels and improve mental health among urban populations.",
        "question": "What benefits of urban green spaces are mentioned in the text?",
        "options": [
            "They help in reducing the temperature of the city.",
            "They provide a place for residents to park their cars.",
            "They contribute to better mental health for city residents.",
            "They are primarily used for commercial agriculture.",
            "They act as carbon sinks by absorbing carbon dioxide."
        ],
        "answers": ['A', 'C', 'E']
    },
    {
        "text": "The transition to renewable energy sources, like solar and wind power, is crucial for combating climate change. While the initial costs of setting up renewable infrastructure can be high, the long-term benefits include reduced greenhouse gas emissions and greater energy independence. However, the intermittent nature of solar and wind energy requires significant advancements in battery storage technology to ensure a stable and reliable power supply.",
        "question": "Which of the following points are discussed in the passage?",
        "options": [
            "Renewable energy sources produce zero greenhouse gas emissions during setup.",
            "Switching to renewable energy can increase a country's energy independence.",
            "Solar and wind power provide a constant and uninterrupted energy supply.",
            "Improved battery storage is needed to handle the intermittency of renewable energy.",
            "The initial setup costs for renewable energy are generally very low."
        ],
        "answers": ['B', 'D']
    },
    {
        "text": "Artificial Intelligence (AI) has made significant strides in recent years, particularly in the fields of natural language processing and image recognition. While AI offers immense potential to increase efficiency in industries like healthcare and finance, it also raises ethical concerns. Issues such as algorithmic bias, data privacy, and the potential displacement of human workers are fiercely debated topics among policymakers and technologists.",
        "question": "What are some of the concerns associated with AI mentioned in the passage?",
        "options": [
            "AI has failed to improve image recognition technology.",
            "There is a risk of bias in AI algorithms.",
            "AI could potentially lead to job losses for human workers.",
            "AI will completely replace human doctors in healthcare.",
            "The use of AI raises issues regarding the privacy of data."
        ],
        "answers": ['B', 'C', 'E']
    }
]

topics = []
for i in range(1, 301):
    template = random.choice(passages)
    
    opts = template["options"].copy()
    ans_indices = [ord(char) - 65 for char in template["answers"]]
    correct_opt_texts = [opts[idx] for idx in ans_indices]
    
    random.shuffle(opts)
    
    new_answers = []
    for idx, opt in enumerate(opts):
        if opt in correct_opt_texts:
            new_answers.append(chr(65 + idx))
            
    new_answers.sort()
    
    topic = {
        "passage": template["text"],
        "question": template["question"],
        "options": opts,
        "answers": new_answers
    }
    topics.append(topic)

with open('config/pte_reading_mcma_topics.php', 'w') as f:
    f.write("<?php\n\nreturn [\n")
    for t in topics:
        f.write("    [\n")
        escaped_passage = t['passage'].replace("'", "\\'")
        escaped_question = t['question'].replace("'", "\\'")
        f.write(f"        'passage' => '{escaped_passage}',\n")
        f.write(f"        'question' => '{escaped_question}',\n")
        f.write("        'options' => [\n")
        for o in t['options']:
            escaped_o = o.replace("'", "\\'")
            f.write(f"            '{escaped_o}',\n")
        f.write("        ],\n")
        f.write("        'answers' => [\n")
        for a in t['answers']:
            f.write(f"            '{a}',\n")
        f.write("        ]\n")
        f.write("    ],\n")
    f.write("];\n")

