import json
import random

templates = [
    {
        "transcript": "In this lecture, we're going to discuss the impact of artificial intelligence on the modern workforce. While many fear that automation will inevitably lead to massive job losses, historical evidence suggests a more nuanced reality. Previous technological revolutions, such as the industrial revolution, did displace workers in certain sectors, but they also created entirely new industries and job categories. The key difference with AI is the pace of change. It's happening much faster. Therefore, the focus should not solely be on job protection, but on upskilling and reskilling the workforce. Education systems need to adapt rapidly, shifting from rote memorization to fostering critical thinking, creativity, and emotional intelligence, which are skills less easily replicated by machines. Ultimately, the future of work will likely involve a collaborative relationship between humans and AI, augmenting human capabilities rather than replacing them entirely.",
        "key_points": ["Artificial intelligence impact on workforce", "Historical technological revolutions created new jobs", "Pace of AI change is rapid", "Focus on upskilling and reskilling", "Education must foster critical thinking and creativity", "Collaborative relationship between humans and AI"]
    },
    {
        "transcript": "Today, I want to talk about the psychological concept of neuroplasticity. For a long time, scientists believed that the brain's structure was fixed after early childhood. We now know this is completely false. Neuroplasticity refers to the brain's remarkable ability to reorganize itself by forming new neural connections throughout life. This happens in response to learning, experience, or even after an injury. For instance, when you learn a new language or how to play a musical instrument, your brain is actually changing its physical structure. This discovery has profound implications for rehabilitation after strokes, and it also means that we have much more control over our cognitive abilities as we age than we previously thought. It challenges the notion that intelligence or abilities are entirely innate, emphasizing the power of continuous learning and mental exercise.",
        "key_points": ["Neuroplasticity definition", "Brain structure is not fixed after childhood", "Brain reorganizes by forming new neural connections", "Learning and experience change brain structure", "Implications for stroke rehabilitation", "Control over cognitive abilities as we age"]
    },
    {
        "transcript": "Let's turn our attention to the global water crisis. It's a common misconception that because the Earth is covered mostly by water, we have an abundant supply. In reality, less than three percent of the world's water is freshwater, and a significant portion of that is locked up in glaciers and ice caps. The accessible freshwater is unevenly distributed and increasingly under threat from pollution, climate change, and over-extraction for agriculture and industry. As populations grow, the demand for water is skyrocketing, leading to severe scarcity in many regions. This isn't just an environmental issue; it's a profound economic and social challenge. Addressing this requires a multifaceted approach, including investing in efficient irrigation technologies, improving wastewater recycling, and fundamentally changing our consumption habits to value water as a precious, finite resource.",
        "key_points": ["Global water crisis misconception", "Less than 3 percent of Earth water is freshwater", "Freshwater is unevenly distributed", "Threats include pollution, climate change, over-extraction", "Growing population increases water demand", "Solutions require efficient technology and changing consumption habits"]
    },
    {
        "transcript": "The architectural history of ancient Rome is a fascinating study in engineering innovation. The Romans didn't just build impressive structures; they developed new materials and techniques that allowed them to construct on an unprecedented scale. One of their most significant contributions was the invention of Roman concrete, or opus caementicium. Unlike modern concrete, the Roman recipe included volcanic ash, which made it incredibly durable, even underwater. This material enabled the construction of massive domes, like the Pantheon, and extensive aqueduct systems that transformed urban living by supplying clean water over vast distances. Furthermore, their mastery of the arch allowed them to build stronger bridges and towering aqueducts using less material than solid walls. These engineering feats not only demonstrated Rome's power but also laid the foundation for modern architectural practices.",
        "key_points": ["Roman architectural engineering innovation", "Invention of Roman concrete (opus caementicium)", "Volcanic ash made concrete durable and waterproof", "Enabled massive domes and aqueducts", "Mastery of the arch for stronger structures", "Laid foundation for modern architectural practices"]
    },
    {
        "transcript": "We are increasingly recognizing the vital role that gut microbiota plays in human health. The human digestive tract is home to trillions of microorganisms, primarily bacteria, which we collectively call the gut microbiome. Traditionally, bacteria were viewed mostly as pathogens that cause disease. However, research over the last decade has revealed that a healthy, diverse microbiome is essential for digesting food, synthesizing essential vitamins, and maintaining a robust immune system. Interestingly, there's also a strong connection between the gut and the brain, often referred to as the gut-brain axis. The bacteria in our gut can produce neurotransmitters like serotonin, which affect our mood and mental health. Therefore, maintaining a healthy gut through a balanced diet rich in fiber and fermented foods is not just about physical health, but also crucial for mental well-being.",
        "key_points": ["Vital role of gut microbiota in human health", "Gut microbiome consists of trillions of microorganisms", "Essential for digestion, vitamins, and immune system", "Connection between gut and brain (gut-brain axis)", "Gut bacteria produce neurotransmitters affecting mood", "Healthy diet crucial for physical and mental well-being"]
    }
]

topics_php = "<?php\n\nreturn [\n"

voices = ['af_heart', 'am_fenrir', 'af_bella', 'am_michael', 'af_sky']

for i in range(1, 301):
    template = random.choice(templates)
    
    transcript = template["transcript"].replace("'", "\\'")
    key_points = template["key_points"]
    voice = random.choice(voices)
    
    topics_php += "    [\n"
    topics_php += f"        'transcript' => '{transcript}',\n"
    topics_php += f"        'voice' => '{voice}',\n"
    
    topics_php += f"        'key_points' => [\n"
    for kp in key_points:
        kp_safe = kp.replace("'", "\\'")
        topics_php += f"            '{kp_safe}',\n"
    topics_php += f"        ],\n"
    topics_php += "    ],\n"

topics_php += "];\n"

with open("config/pte_listening_sst_topics.php", "w") as f:
    f.write(topics_php)

print("Successfully generated 300 topics for Summarize Spoken Text.")
