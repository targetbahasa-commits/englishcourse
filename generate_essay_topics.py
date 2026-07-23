import json
import random

subjects = [
    "technology", "education", "the environment", "globalization", "social media",
    "public health", "tourism", "remote work", "space exploration", "the arts",
    "sports", "public transport", "urbanization", "consumerism", "artificial intelligence",
    "automation", "online learning", "traditional media", "youth", "elderly population",
    "government funding", "taxation", "animal rights", "renewable energy", "overpopulation"
]

actions = [
    "has had a more positive than negative impact on society",
    "should be heavily regulated by the government",
    "is the most pressing issue of our time",
    "will inevitably lead to the decline of traditional values",
    "brings more disadvantages than advantages",
    "is essential for the economic development of a country",
    "has fundamentally changed the way we interact with each other",
    "should be funded primarily by private corporations rather than governments",
    "causes more harm than good in the long run",
    "is a necessary step for human progress"
]

tasks = [
    "Discuss both views and give your own opinion.",
    "To what extent do you agree or disagree with this statement?",
    "What are the main causes of this and what solutions can you suggest?",
    "Do you think the advantages outweigh the disadvantages?",
    "What is your opinion on this issue?",
    "Discuss the positive and negative effects of this trend.",
    "How does this affect individuals and society as a whole?"
]

topics = []
for i in range(1, 301):
    if i == 1:
        prompt = "Do you agree that technology has had a more positive than negative impact on the quality of education? Discuss both views and give your own opinion. Write 200–300 words."
    else:
        subject = random.choice(subjects)
        action = random.choice(actions)
        task = random.choice(tasks)
        prompt = f"Some people argue that {subject} {action}. {task} Write 200-300 words."
    
    topics.append(prompt)

with open('config/pte_essay_topics.php', 'w') as f:
    f.write("<?php\n\nreturn [\n")
    for prompt in topics:
        escaped_prompt = prompt.replace("'", "\\'")
        f.write(f"    '{escaped_prompt}',\n")
    f.write("];\n")

