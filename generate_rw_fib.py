import random
import json

templates = [
    {
        "text": "At the height of summer the {Place}, tourist ships move gently around the coast. Even {Number} years ago such sights would have been unthinkable, but today people are willing to pay large sums of money to see the last real wilderness in the world. In the {Region}, careless human exploitation [BLANK1] the fragile ecosystem. Today concerned governments are trying to find ways to develop the region [BLANK2] special natural environment. [BLANK3] the {Place} is less accessible than the {Region}, it is still largely undamaged by humans.",
        "vars": {
            "Place": ["Antarctic", "Arctic", "Galapagos", "Greenland", "Patagonia"],
            "Number": ["10", "20", "30", "50", "100"],
            "Region": ["Northern Hemisphere", "Southern Hemisphere", "Polar Region", "Tundra", "Ice Caps"]
        },
        "blanks": {
            "BLANK1": {"ans": "has damaged", "opts": ["have damaged", "has damaged", "damaging", "damage"]},
            "BLANK2": {"ans": "in the future", "opts": ["in the future", "ever before", "in the past", "on one side"]},
            "BLANK3": {"ans": "Although", "opts": ["Because", "Since", "Although", "When"]}
        }
    },
    {
        "text": "The evolution of {Subject} has fundamentally changed how we understand the {Concept}. Historically, researchers believed that {Noun} [BLANK1] a minor role. However, recent studies have demonstrated that it is [BLANK2] to the overall system. As we continue to explore this fascinating field, it becomes [BLANK3] that our previous models were incomplete. Future breakthroughs will likely [BLANK4] heavily on interdisciplinary collaboration.",
        "vars": {
            "Subject": ["quantum physics", "marine biology", "cognitive psychology", "astrophysics", "genetics"],
            "Concept": ["universe", "human mind", "oceanic ecosystem", "cellular structure", "solar system"],
            "Noun": ["temperature", "gravity", "DNA", "consciousness", "bacteria"]
        },
        "blanks": {
            "BLANK1": {"ans": "played", "opts": ["plays", "playing", "played", "play"]},
            "BLANK2": {"ans": "crucial", "opts": ["trivial", "crucial", "optional", "irrelevant"]},
            "BLANK3": {"ans": "evident", "opts": ["evident", "obscure", "doubtful", "hidden"]},
            "BLANK4": {"ans": "rely", "opts": ["rely", "relying", "relied", "relies"]}
        }
    },
    {
        "text": "In the context of global {Issue}, governments face unprecedented challenges. The most [BLANK1] problem is the allocation of scarce resources. While some argue that immediate [BLANK2] is necessary, others believe that long-term strategies are more effective. Consequently, policymakers must [BLANK3] a delicate balance between competing interests. Ultimately, the success of these initiatives will [BLANK4] on international cooperation.",
        "vars": {
            "Issue": ["climate change", "economic inequality", "public health", "food security", "cybersecurity"],
        },
        "blanks": {
            "BLANK1": {"ans": "pressing", "opts": ["pressing", "relaxed", "minor", "solved"]},
            "BLANK2": {"ans": "action", "opts": ["action", "acting", "acted", "actions"]},
            "BLANK3": {"ans": "strike", "opts": ["strike", "striking", "struck", "strikes"]},
            "BLANK4": {"ans": "depend", "opts": ["depend", "depending", "depended", "depends"]}
        }
    },
    {
        "text": "Recent advancements in {Technology} have paved the way for innovative applications. For instance, the use of [BLANK1] algorithms has optimized data processing speeds. Furthermore, these systems are [BLANK2] capable of learning from vast amounts of information without explicit programming. Critics, however, [BLANK3] concerns regarding data privacy and security. Addressing these ethical issues remains a [BLANK4] priority for developers.",
        "vars": {
            "Technology": ["machine learning", "robotics", "nanotechnology", "blockchain", "virtual reality"],
        },
        "blanks": {
            "BLANK1": {"ans": "sophisticated", "opts": ["sophisticated", "simple", "outdated", "basic"]},
            "BLANK2": {"ans": "increasingly", "opts": ["increasingly", "decreasingly", "rarely", "never"]},
            "BLANK3": {"ans": "raise", "opts": ["raise", "raises", "raising", "raised"]},
            "BLANK4": {"ans": "top", "opts": ["top", "bottom", "low", "zero"]}
        }
    },
    {
        "text": "The history of {Civilization} offers valuable insights into human resilience. Despite facing numerous [BLANK1], these ancient people managed to thrive in harsh environments. Their agricultural practices were particularly [BLANK2], allowing them to sustain large populations. Additionally, their architectural [BLANK3] continue to astound modern engineers. Exploring their legacy helps us [BLANK4] the complexities of early societies.",
        "vars": {
            "Civilization": ["Ancient Egypt", "the Maya", "Mesopotamia", "the Indus Valley", "Ancient Rome"],
        },
        "blanks": {
            "BLANK1": {"ans": "hardships", "opts": ["hardships", "comforts", "luxuries", "ease"]},
            "BLANK2": {"ans": "ingenious", "opts": ["ingenious", "foolish", "clumsy", "destructive"]},
            "BLANK3": {"ans": "marvels", "opts": ["marvels", "failures", "disasters", "ruins"]},
            "BLANK4": {"ans": "understand", "opts": ["understand", "misunderstand", "ignore", "forget"]}
        }
    }
]

def generate_select_html(opts, ans):
    html = f'<select class="pte-select" data-answer="{ans}">'
    html += '<option value="" disabled selected>Select Answer</option>'
    for opt in opts:
        html += f'<option value="{opt}">{opt}</option>'
    html += '</select>'
    return html

topics = []
for i in range(1, 301):
    template = random.choice(templates)
    text = template["text"]
    
    # Fill variables
    for var_name, options in template.get("vars", {}).items():
        text = text.replace(f"{{{var_name}}}", random.choice(options))
        
    # Replace blanks
    for blank_id, blank_data in template["blanks"].items():
        html_select = generate_select_html(blank_data["opts"], blank_data["ans"])
        text = text.replace(f"[{blank_id}]", html_select)
        
    topics.append(text)

with open('config/pte_rw_fib_topics.php', 'w') as f:
    f.write("<?php\n\nreturn [\n")
    for prompt in topics:
        escaped_prompt = prompt.replace("'", "\\'")
        f.write(f"    '{escaped_prompt}',\n")
    f.write("];\n")

