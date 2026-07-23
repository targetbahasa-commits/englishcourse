import json
import random

# A set of long, PTE-style paragraphs.
# We use {word} for words that CAN be blanked out.
# The script will randomly pick 4 of these {word} tags to become actual blanks.
# The rest will just be normal text.
paragraphs = [
    {
        "text": "Coding languages, {integral} to modern technology, emerged from the {convergence} of mathematical logic and electronic engineering. Initially {developed} for specific tasks, they evolved to create {complex} systems and applications. Python, known for its {simplicity} and readability, has become widely used in {diverse} fields from web development to data science. Moreover, it is constantly evolving and improving, as new {features} and enhancements are {incorporated} into the language and its library every year.",
        "distractors": ["reverse", "frugal", "mixed", "static", "ignored", "limited", "abandoned", "narrow", "outdated", "superficial"]
    },
    {
        "text": "The {phenomenon} of globalization has fundamentally {transformed} the way businesses operate on an international scale. Companies are no longer {restricted} to local markets but can access a {global} consumer base. This expansion, while {lucrative}, also brings significant {challenges}, such as navigating different regulatory frameworks and cultural nuances. Successful organizations must {adapt} quickly and maintain {flexibility} to thrive in this highly competitive environment.",
        "distractors": ["declined", "isolated", "stagnant", "rigid", "temporary", "trivial", "avoided", "rejected"]
    },
    {
        "text": "Climate change poses an {unprecedented} threat to global biodiversity and {ecosystems}. Rising temperatures have {disrupted} natural habitats, forcing many species to {migrate} or face extinction. The {melting} of polar ice caps contributes to rising sea levels, which {endangers} coastal communities worldwide. Implementing {sustainable} practices and reducing carbon emissions are {crucial} steps in mitigating these devastating environmental impacts.",
        "distractors": ["beneficial", "promoted", "stabilized", "frozen", "safe", "optional", "minor", "ignored"]
    },
    {
        "text": "The advent of artificial intelligence has {revolutionized} numerous industries, from healthcare to finance. Machine learning algorithms can {analyze} vast amounts of data to identify {patterns} that would be impossible for humans to detect. While this technology offers {immense} benefits, it also raises {ethical} concerns regarding privacy and job displacement. Policymakers and technologists must {collaborate} to establish clear {guidelines} for the responsible development and {deployment} of AI systems.",
        "distractors": ["destroyed", "ignore", "randomness", "minimal", "trivial", "compete", "obstacles", "removal"]
    },
    {
        "text": "Urban planning plays a {vital} role in shaping the quality of life in {metropolitan} areas. Effective city design must {balance} economic growth with environmental sustainability and social {equity}. The development of {efficient} public transportation networks reduces traffic congestion and lowers {pollution} levels. Furthermore, integrating {green} spaces into the urban landscape {enhances} public health and fosters a stronger sense of community.",
        "distractors": ["insignificant", "rural", "ignore", "inequality", "wasteful", "cleanliness", "industrial", "diminishes"]
    }
]

topics_php = "<?php\n\nreturn [\n"

for i in range(1, 301):
    para_data = random.choice(paragraphs)
    raw_text = para_data["text"]
    
    # Extract all possible blank words (words inside {})
    import re
    possible_blanks = re.findall(r'\{(.*?)\}', raw_text)
    
    # Pick 4 random words to become blanks
    chosen_blanks = random.sample(possible_blanks, 4)
    
    # Replace the chosen ones with HTML blanks, and the unchosen ones with just the word
    passage = raw_text
    correct_answers = {}
    blank_idx = 1
    
    # We iterate over all possible blanks in the text
    for word in possible_blanks:
        if word in chosen_blanks:
            # Replace the first occurrence of {word} with the blank HTML
            blank_id = f"blank{blank_idx}"
            passage = passage.replace(f"{{{word}}}", f"<div class=\"blank-space dropzone\" data-id=\"{blank_id}\"></div>", 1)
            correct_answers[blank_id] = word
            blank_idx += 1
        else:
            # Replace {word} with just word
            passage = passage.replace(f"{{{word}}}", word, 1)
            
    # Select distractors
    distractors = random.sample(para_data["distractors"], 3)
    
    # Combine correct answers and distractors
    words = chosen_blanks + distractors
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

print("Successfully generated 300 topics with varying blank layouts.")
