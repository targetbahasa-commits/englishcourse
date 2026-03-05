<?php

$content = '{
  "scores": {
    "task_achievement": 6.5,
    "coherence_cohesion": 6.0,
    "lexical_resource": 7.0,
    "grammatical_range": 6.0,
    "overall_band": 6.5
  },
  "feedback": {
    "task_achievement": "The essay partially addresses the topic, but could be more focused and developed.",
    "coherence_cohesion": "The essay has some coherence issues, with abrupt transitions between ideas.",
    "lexical_resource": "The vocabulary is generally good, but could be more varied and sophisticated.",
    "grammatical_range": "The grammar is mostly accurate, but there are some errors in verb tense and sentence structure.",
    "overall_comment": "A decent attempt at the task, but needs improvement in coherence, grammar, and vocabulary."
  },
  "correction_html": "<p>Some people think social media is very bad for society, but other people think it is good because {GREEN}it allows us to connect with others{/GREEN}. I will discuss both views and give my opinion.</p><p>{RED}Firstly,/RED> social media has many negative impacts on people. Many people use social media too much time every day and forget about real life. This makes people lazy and not talk face-to-face with other people. {YELLOW}suggestion: consider using a more formal phrase, such as \"social media has several drawbacks\" or \"social media poses several problems\"{/YELLOW} For example, young people always look at their phones and don\'t care about the family around them. Also, social media makes people stressed because they see other people\'s lives are better. Fake news also spreads very fast in social media and people believe it without thinking.</p><p>On the other hand, social media also has a positive side. {GREEN}It helps people connect with friends and family who live far away{/GREEN}. People can chat, send messages, and video call easily. Social media also helps businesses sell products online and get many customers. Many people use social media to learn new things and get information. So, social media is not always bad for society.</p><p>In my opinion, social media is both good and bad. {YELLOW}suggestion: consider using a more formal phrase, such as \"in my view\" or \"I believe\"{/YELLOW} It depends on how people use it. If people use too much, it will give problems. But if people use it in a good way, social media can help many things in life. The government should control social media and people must use it wisely.</p><p>In conclusion, social media has both negative and positive impacts. People should not use social media too much and balance it with real life.</p>"
}';

$json = json_decode($content, true);

if ($json) {
    echo "SUCCESS\n";
} else {
    echo "FAIL: " . json_last_error_msg() . "\n";
}
