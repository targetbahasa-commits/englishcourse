import random
import os

voices = ['af_heart', 'am_fenrir', 'af_bella', 'am_michael', 'af_sky']

def write_php_config(filename, topics):
    php_content = "<?php\n\nreturn [\n"
    for topic in topics:
        php_content += "    [\n"
        for key, value in topic.items():
            if isinstance(value, list):
                php_content += f"        '{key}' => [\n"
                for item in value:
                    safe_item = str(item).replace("'", "\\'")
                    php_content += f"            '{safe_item}',\n"
                php_content += "        ],\n"
            else:
                safe_value = str(value).replace("'", "\\'")
                php_content += f"        '{key}' => '{safe_value}',\n"
        php_content += "    ],\n"
    php_content += "];\n"
    
    with open(f"config/{filename}.php", "w") as f:
        f.write(php_content)
    print(f"Generated {len(topics)} items for config/{filename}.php")

# 1. Retell Lecture
rl_templates = [
    {"transcript": "The industrial revolution changed the way people worked and lived. Instead of farming, people moved to cities to work in factories.", "key_points": ["industrial revolution", "moved to cities", "worked in factories"]},
    {"transcript": "Climate change is having a profound impact on global weather patterns. We are seeing more extreme storms and prolonged droughts.", "key_points": ["climate change", "global weather patterns", "extreme storms"]},
    {"transcript": "In biology, photosynthesis is the process used by plants to convert light energy into chemical energy that can later be released to fuel the organisms' activities.", "key_points": ["biology", "photosynthesis", "light energy to chemical energy"]}
]

# 2. Answer Short Question
asq_templates = [
    {"transcript": "What do we call the instrument used for measuring temperature?", "answer": "Thermometer"},
    {"transcript": "What is the capital city of Australia?", "answer": "Canberra"},
    {"transcript": "Which month comes right after November?", "answer": "December"}
]

# 3. Listening MCMA
lmcma_templates = [
    {"transcript": "The new campus library will feature several modern amenities, including private study pods, a 24-hour cafe, and an extensive digital archive. However, the physical book collection will be slightly reduced.", "question": "What new features will the library have?", "options": ["Private study pods", "A 24-hour cafe", "More physical books", "A gym"], "correct_answers": ["Private study pods", "A 24-hour cafe"]},
    {"transcript": "Students must submit their assignments online by Friday. Late submissions will incur a penalty of 10% per day. Extension requests must be made by Wednesday.", "question": "Which of the following statements are true?", "options": ["Assignments must be submitted online", "Late penalty is 5%", "Extensions can be requested on Thursday", "Deadline is Friday"], "correct_answers": ["Assignments must be submitted online", "Deadline is Friday"]}
]

# 4. Listening FIB
lfib_templates = [
    {"transcript": "The primary cause of this phenomenon is still under investigation by researchers.", "text": "The [blank] cause of this [blank] is still under investigation by [blank].", "answers": ["primary", "phenomenon", "researchers"]},
    {"transcript": "Please ensure you have completed all mandatory modules before the final exam.", "text": "Please [blank] you have completed all [blank] modules before the [blank] exam.", "answers": ["ensure", "mandatory", "final"]}
]

# 5. Highlight Correct Summary
hcs_templates = [
    {"transcript": "The professor discussed how ancient Romans built extensive aqueduct systems to supply water to their cities, which was a marvel of engineering at the time.", "options": ["Romans built aqueducts for water supply.", "Romans invented water.", "Aqueducts were mainly for decoration.", "Engineering was not advanced in Rome."], "correct_answer": "Romans built aqueducts for water supply."},
    {"transcript": "The study reveals that people who sleep for 8 hours tend to have better memory retention compared to those who sleep less.", "options": ["Sleep doesn't affect memory.", "8 hours of sleep improves memory retention.", "People should sleep less.", "Memory retention is only related to diet."], "correct_answer": "8 hours of sleep improves memory retention."}
]

# 6. Listening MCSA
lmcsa_templates = [
    {"transcript": "Due to the upcoming holiday, the university campus will be closed on Monday and will reopen on Tuesday at 8 AM.", "question": "When will the campus reopen?", "options": ["Sunday", "Monday", "Tuesday", "Wednesday"], "correct_answer": "Tuesday"},
    {"transcript": "The keynote speaker for the conference had to cancel due to illness, so Dr. Smith will present instead.", "question": "Why did the keynote speaker cancel?", "options": ["Flight delay", "Illness", "Schedule conflict", "No reason given"], "correct_answer": "Illness"}
]

# 7. Select Missing Word
smw_templates = [
    {"transcript": "In conclusion, the experiment was a complete [beep].", "options": ["success", "banana", "tree", "car"], "correct_answer": "success"},
    {"transcript": "If you need further assistance, please don't hesitate to contact our [beep].", "options": ["support team", "enemy", "building", "weather"], "correct_answer": "support team"}
]

# 8. Highlight Incorrect Words
hiw_templates = [
    {"transcript": "The rapid development of technology has changed our lives significantly.", "text": "The fast development of technology has modified our lives significantly.", "incorrect_words": ["fast", "modified"]},
    {"transcript": "She decided to study economics at the local university.", "text": "She chose to study economics at the nearby university.", "incorrect_words": ["chose", "nearby"]}
]

# 9. Write From Dictation
wfd_templates = [
    {"transcript": "The library is located on the north side of the campus."},
    {"transcript": "Please submit your assignment before the deadline."},
    {"transcript": "Students must attend all lectures and tutorials."}
]

configs_to_generate = [
    ("pte_retell_lecture", rl_templates),
    ("pte_answer_short_question", asq_templates),
    ("pte_listening_mcma", lmcma_templates),
    ("pte_listening_fib", lfib_templates),
    ("pte_highlight_correct_summary", hcs_templates),
    ("pte_listening_mcsa", lmcsa_templates),
    ("pte_select_missing_word", smw_templates),
    ("pte_highlight_incorrect_words", hiw_templates),
    ("pte_write_from_dictation", wfd_templates)
]

for filename, templates in configs_to_generate:
    generated_items = []
    # Generate 15 items for each by looping and shuffling voices
    for i in range(15):
        template = templates[i % len(templates)].copy()
        template['voice'] = random.choice(voices)
        generated_items.append(template)
    
    write_php_config(filename, generated_items)

print("All audio-based PTE config files have been generated successfully!")
