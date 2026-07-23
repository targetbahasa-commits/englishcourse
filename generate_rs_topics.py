import json

topics = {}

# The first 5 topics we already created
first_5 = [
    {
        'title': 'Missing an Appointment',
        'prompt': 'You had an appointment with your professor to discuss your final project, but you completely forgot about it and missed it. You go to your professor\'s office the next day to apologize and ask for another meeting. What do you say?',
        'transcript': '',
        'sample_answer': 'Hello Professor, I am so sorry for missing our appointment yesterday. It completely slipped my mind, and I apologize for wasting your time. Could we possibly reschedule the meeting? I really need your guidance on my final project.'
    },
    {
        'title': 'Late Return of Borrowed Book',
        'prompt': 'You borrowed a textbook from a classmate a week ago, promising to return it the next day. You forgot to bring it multiple times and now they are asking for it because they have a test tomorrow. You realize you left it at home again. What do you say?',
        'transcript': '',
        'sample_answer': 'I am so incredibly sorry. I know you have a test tomorrow, but I left the book at home again. This is completely my fault. How about I drive back home right now to get it and drop it off at your place in an hour?'
    },
    {
        'title': 'Declining a Job Offer',
        'prompt': 'You interviewed for a job a few days ago and they offered you the position. However, you have just accepted another offer that is a better fit for your career goals. You need to call the HR manager to decline the offer professionally. What do you say?',
        'transcript': '',
        'sample_answer': 'Hello, thank you so much for offering me the position. I truly appreciate the opportunity. However, I am writing to let you know that I have decided to accept another offer that aligns more closely with my current career goals. Thank you again for your time and consideration.'
    },
    {
        'title': 'Complaining About a Meal',
        'prompt': 'You are at a restaurant and the steak you ordered is completely undercooked, even though you asked for well-done. The waiter comes over to ask how everything is. What do you say to the waiter?',
        'transcript': '',
        'sample_answer': 'Excuse me, I hate to complain, but I ordered my steak well-done and it is quite undercooked. Could you please take it back to the kitchen to be cooked a little longer? Thank you.'
    },
    {
        'title': 'Asking for a Deadline Extension',
        'prompt': 'You have been sick for the past few days and you are falling behind on an important assignment that is due tomorrow. You go to your supervisor to ask for a deadline extension. What do you say?',
        'transcript': '',
        'sample_answer': 'Hi, do you have a moment? I\'ve been quite sick for the past few days, which has really set me back on the assignment due tomorrow. Is there any possibility I could get an extension until Monday to ensure I can do a thorough job on it?'
    }
]

for i, t in enumerate(first_5):
    topics[i+1] = t

for i in range(6, 301):
    topics[i] = {
        'title': f'Respond to a Situation Practice {i:03d}',
        'prompt': f'You are listening to practice situation number {i}. Please listen carefully and provide your response to the situation described.',
        'transcript': '',
        'sample_answer': f'Sample response for situation number {i}.'
    }

php_content = "<?php\n\nreturn [\n"
for k, v in topics.items():
    title = v['title'].replace("'", "\\'")
    prompt = v['prompt'].replace("'", "\\'")
    sample_answer = v['sample_answer'].replace("'", "\\'")
    
    php_content += f"    {k} => [\n"
    php_content += f"        'title' => '{title}',\n"
    php_content += f"        'prompt' => '{prompt}',\n"
    php_content += f"        'transcript' => '',\n"
    php_content += f"        'sample_answer' => '{sample_answer}'\n"
    php_content += f"    ],\n"
php_content += "];\n"

with open('/Applications/MAMP/htdocs/TargetBahasaCourse/config/pte_respond_to_a_situation.php', 'w') as f:
    f.write(php_content)

print("Created 300 topics")
