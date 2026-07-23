import json
import random

subjects = [
    "technology", "education", "the environment", "globalization", "social media",
    "public health", "tourism", "remote work", "space exploration", "artificial intelligence",
    "history of science", "urban planning", "renewable energy", "psychology", "modern art",
    "e-commerce", "nanotechnology", "quantum computing", "biotechnology", "marine biology"
]

templates = [
    {
        "text": "The evolution of {subject} has profoundly <div class=\"blank-space dropzone\" data-id=\"blank1\"></div> modern society. In the early days, it was <div class=\"blank-space dropzone\" data-id=\"blank2\"></div> to a small group of experts. However, recent advancements have <div class=\"blank-space dropzone\" data-id=\"blank3\"></div> its reach globally. Today, researchers are <div class=\"blank-space dropzone\" data-id=\"blank4\"></div> exploring new ways to integrate it into daily life.",
        "blanks": [
            ["impacted", "shaped", "transformed", "altered"],
            ["restricted", "confined", "limited", "exclusive"],
            ["expanded", "broadened", "widened", "extended"],
            ["actively", "continuously", "constantly", "vigorously"]
        ],
        "distractors": ["ignored", "stagnant", "reduced", "passively", "declined"]
    },
    {
        "text": "When discussing {subject}, one must <div class=\"blank-space dropzone\" data-id=\"blank1\"></div> the historical context. Without understanding the past, it is <div class=\"blank-space dropzone\" data-id=\"blank2\"></div> to predict future trends. Many scholars have <div class=\"blank-space dropzone\" data-id=\"blank3\"></div> that the current trajectory is unsustainable. Therefore, a <div class=\"blank-space dropzone\" data-id=\"blank4\"></div> approach is necessary to ensure long-term success.",
        "blanks": [
            ["consider", "acknowledge", "recognize", "examine"],
            ["impossible", "difficult", "challenging", "hard"],
            ["argued", "suggested", "proposed", "stated"],
            ["comprehensive", "holistic", "thorough", "systematic"]
        ],
        "distractors": ["forget", "easy", "denied", "partial", "ignored"]
    },
    {
        "text": "The implementation of {subject} in rural areas remains a <div class=\"blank-space dropzone\" data-id=\"blank1\"></div> issue. While urban centers have <div class=\"blank-space dropzone\" data-id=\"blank2\"></div> adapted, remote regions face significant barriers. Infrastructure deficits and lack of funding are <div class=\"blank-space dropzone\" data-id=\"blank3\"></div> obstacles. Addressing these disparities requires <div class=\"blank-space dropzone\" data-id=\"blank4\"></div> effort from both government and private sectors.",
        "blanks": [
            ["complex", "complicated", "difficult", "challenging"],
            ["rapidly", "quickly", "swiftly", "readily"],
            ["primary", "major", "main", "key"],
            ["collaborative", "joint", "combined", "collective"]
        ],
        "distractors": ["simple", "slowly", "minor", "individual", "resolved"]
    },
    {
        "text": "Recent studies on {subject} have <div class=\"blank-space dropzone\" data-id=\"blank1\"></div> surprising results. Contrary to popular belief, the data indicates a <div class=\"blank-space dropzone\" data-id=\"blank2\"></div> trend. This anomaly has <div class=\"blank-space dropzone\" data-id=\"blank3\"></div> researchers to re-evaluate their initial hypotheses. Further investigation is <div class=\"blank-space dropzone\" data-id=\"blank4\"></div> to fully understand the underlying mechanisms.",
        "blanks": [
            ["yielded", "produced", "revealed", "uncovered"],
            ["positive", "favorable", "promising", "beneficial"],
            ["prompted", "forced", "compelled", "driven"],
            ["required", "needed", "necessary", "essential"]
        ],
        "distractors": ["hidden", "negative", "stopped", "optional", "declined"]
    },
    {
        "text": "The study of {subject}, <div class=\"blank-space dropzone\" data-id=\"blank1\"></div> to our understanding of the modern world, emerged from complex historical shifts. Initially <div class=\"blank-space dropzone\" data-id=\"blank2\"></div> for specific regional purposes, its concepts evolved to address global challenges. Today, it is widely applied across <div class=\"blank-space dropzone\" data-id=\"blank3\"></div> fields. Furthermore, it is constantly evolving as new theories are <div class=\"blank-space dropzone\" data-id=\"blank4\"></div> into academic curricula every year.",
        "blanks": [
            ["crucial", "integral", "essential", "vital"],
            ["developed", "created", "designed", "built"],
            ["diverse", "various", "multiple", "numerous"],
            ["incorporated", "integrated", "embedded", "included"]
        ],
        "distractors": ["reverse", "frugal", "mixed", "static", "abandoned"]
    },
    {
        "text": "Advances in {subject} are <div class=\"blank-space dropzone\" data-id=\"blank1\"></div> at an unprecedented rate. What was once considered science fiction is now becoming a <div class=\"blank-space dropzone\" data-id=\"blank2\"></div>. Consumers are <div class=\"blank-space dropzone\" data-id=\"blank3\"></div> adopting these new innovations into their daily routines. However, ethical concerns <div class=\"blank-space dropzone\" data-id=\"blank4\"></div> regarding data privacy and security.",
        "blanks": [
            ["occurring", "happening", "proceeding", "advancing"],
            ["reality", "fact", "certainty", "truth"],
            ["eagerly", "enthusiastically", "quickly", "rapidly"],
            ["persist", "remain", "continue", "linger"]
        ],
        "distractors": ["stopping", "myth", "reluctantly", "disappear", "fiction"]
    },
    {
        "text": "The economic impact of {subject} cannot be <div class=\"blank-space dropzone\" data-id=\"blank1\"></div>. It has created millions of jobs and <div class=\"blank-space dropzone\" data-id=\"blank2\"></div> local economies. Small businesses, in particular, have <div class=\"blank-space dropzone\" data-id=\"blank3\"></div> immensely from these changes. As the sector continues to grow, it will likely <div class=\"blank-space dropzone\" data-id=\"blank4\"></div> traditional business models.",
        "blanks": [
            ["overstated", "exaggerated", "ignored", "underestimated"],
            ["boosted", "stimulated", "revitalized", "strengthened"],
            ["benefited", "profited", "gained", "prospered"],
            ["disrupt", "transform", "alter", "change"]
        ],
        "distractors": ["measured", "harmed", "suffered", "preserve", "declined"]
    }
]

topics_php = "<?php\n\nreturn [\n"

for i in range(1, 301):
    subject = random.choice(subjects)
    template = random.choice(templates)
    
    passage = template["text"].replace("{subject}", subject)
    
    word1 = random.choice(template["blanks"][0])
    word2 = random.choice(template["blanks"][1])
    word3 = random.choice(template["blanks"][2])
    word4 = random.choice(template["blanks"][3])
    
    correct_answers = {
        "blank1": word1,
        "blank2": word2,
        "blank3": word3,
        "blank4": word4
    }
    
    distractors = random.sample(template["distractors"], 3)
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

print("Successfully generated 300 varied topics.")
