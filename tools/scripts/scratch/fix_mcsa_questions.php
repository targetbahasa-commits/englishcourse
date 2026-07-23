<?php
$mcsa = require 'config/pte_listening_mcsa.php';

$stopwords = ['about', 'above', 'across', 'after', 'again', 'against', 'all', 'almost', 'alone', 'along', 'already', 'also', 'although', 'always', 'among', 'and', 'another', 'any', 'anybody', 'anyone', 'anything', 'anywhere', 'are', 'area', 'areas', 'around', 'away', 'back', 'backed', 'backing', 'backs', 'became', 'because', 'become', 'becomes', 'been', 'before', 'began', 'behind', 'being', 'beings', 'below', 'between', 'both', 'but', 'came', 'can', 'cannot', 'case', 'cases', 'certain', 'certainly', 'clear', 'clearly', 'come', 'could', 'did', 'differ', 'different', 'differently', 'do', 'does', 'done', 'down', 'down', 'downed', 'downing', 'downs', 'during', 'each', 'early', 'either', 'end', 'ended', 'ending', 'ends', 'enough', 'even', 'evenly', 'ever', 'every', 'everybody', 'everyone', 'everything', 'everywhere', 'face', 'faces', 'fact', 'facts', 'far', 'felt', 'few', 'find', 'finds', 'first', 'for', 'four', 'from', 'full', 'fully', 'further', 'furthered', 'furthering', 'furthers', 'gave', 'general', 'generally', 'get', 'gets', 'give', 'given', 'gives', 'go', 'going', 'good', 'goods', 'got', 'great', 'greater', 'greatest', 'group', 'grouped', 'grouping', 'groups', 'had', 'has', 'have', 'having', 'he', 'her', 'here', 'herself', 'high', 'high', 'high', 'higher', 'highest', 'him', 'himself', 'his', 'how', 'however', 'if', 'important', 'in', 'interest', 'interested', 'interesting', 'interests', 'into', 'is', 'it', 'its', 'itself', 'just', 'keep', 'keeps', 'kind', 'knew', 'know', 'known', 'knows', 'large', 'largely', 'last', 'later', 'latest', 'least', 'less', 'let', 'lets', 'like', 'likely', 'long', 'longer', 'longest', 'made', 'make', 'making', 'man', 'many', 'may', 'me', 'member', 'members', 'men', 'might', 'more', 'most', 'mostly', 'mr', 'mrs', 'much', 'must', 'my', 'myself', 'necessary', 'need', 'needed', 'needing', 'needs', 'never', 'new', 'new', 'newer', 'newest', 'next', 'no', 'nobody', 'non', 'noone', 'not', 'nothing', 'now', 'nowhere', 'number', 'numbers', 'of', 'off', 'often', 'old', 'older', 'oldest', 'on', 'once', 'one', 'only', 'open', 'opened', 'opening', 'opens', 'or', 'order', 'ordered', 'ordering', 'orders', 'other', 'others', 'our', 'out', 'over', 'part', 'parted', 'parting', 'parts', 'per', 'perhaps', 'place', 'places', 'point', 'pointed', 'pointing', 'points', 'possible', 'present', 'presented', 'presenting', 'presents', 'problem', 'problems', 'put', 'puts', 'quite', 'rather', 'really', 'right', 'right', 'room', 'rooms', 'said', 'same', 'saw', 'say', 'says', 'second', 'seconds', 'see', 'seem', 'seemed', 'seeming', 'seems', 'sees', 'several', 'shall', 'she', 'should', 'show', 'showed', 'showing', 'shows', 'side', 'sides', 'since', 'small', 'smaller', 'smallest', 'so', 'some', 'somebody', 'someone', 'something', 'somewhere', 'state', 'states', 'still', 'still', 'such', 'sure', 'take', 'taken', 'than', 'that', 'the', 'their', 'them', 'then', 'there', 'therefore', 'these', 'they', 'thing', 'things', 'think', 'thinks', 'this', 'those', 'though', 'thought', 'thoughts', 'three', 'through', 'thus', 'to', 'today', 'together', 'too', 'took', 'toward', 'turn', 'turned', 'turning', 'turns', 'two', 'under', 'until', 'up', 'upon', 'us', 'use', 'used', 'uses', 'very', 'want', 'wanted', 'wanting', 'wants', 'was', 'way', 'ways', 'we', 'well', 'wells', 'went', 'were', 'what', 'when', 'where', 'whether', 'which', 'while', 'who', 'whole', 'whose', 'why', 'will', 'with', 'within', 'without', 'work', 'worked', 'working', 'works', 'would', 'year', 'years', 'yet', 'you', 'young', 'younger', 'youngest', 'your', 'yours'];

function getTopic($text, $stopwords) {
    $words = str_word_count($text, 1);
    $candidates = [];
    foreach ($words as $word) {
        $clean = strtolower(preg_replace('/[^a-zA-Z]/', '', $word));
        if (strlen($clean) > 5 && !in_array($clean, $stopwords)) {
            $candidates[] = $word; // keep original case
        }
    }
    
    // Check for capitalized words first
    foreach ($candidates as $c) {
        if (ctype_upper(substr($c, 0, 1))) {
            return $c;
        }
    }
    
    if (count($candidates) > 0) {
        // Find longest word ending in ion, ment, ity, ness, ance, ence
        foreach ($candidates as $c) {
            $cl = strtolower($c);
            if (str_ends_with($cl, 'ion') || str_ends_with($cl, 'ment') || str_ends_with($cl, 'ity') || str_ends_with($cl, 'ness') || str_ends_with($cl, 'ance') || str_ends_with($cl, 'ence')) {
                return $c;
            }
        }
        // Fallback to random long candidate
        return $candidates[array_rand($candidates)];
    }
    
    return null;
}

$genericQuestions = [
    "Which of the following statements best reflects the speaker's main point?",
    "What is the primary conclusion drawn by the speaker?",
    "According to the speaker, which of the following is true?",
    "Which of the following best summarizes the opinion expressed in the lecture?",
    "What is the central theme of the passage?",
    "Which of the following statements is supported by the speaker?",
    "What is the main idea conveyed in this audio?",
    "Which statement most accurately reflects the speaker's perspective?",
    "What is the core message of the lecture?",
    "Which of the following best describes the speaker's primary focus?"
];

$topicQuestions = [
    "What is the speaker's main point about %s?",
    "According to the speaker, what is true regarding %s?",
    "Which of the following best summarizes the speaker's view on %s?",
    "What does the speaker imply regarding %s?",
    "Which statement most accurately reflects the speaker's perspective on %s?",
    "What is the central theme concerning %s?",
    "Which of the following statements is best related to the opinion expressed about %s?",
    "What conclusion does the speaker draw regarding %s?",
    "According to the passage, what is a key aspect of %s?",
    "What is the primary message conveyed about %s?"
];

foreach ($mcsa as $i => &$item) {
    $topic = getTopic($item['correct_answer'], $stopwords);
    if ($topic && rand(0, 1) == 1) { // 50% chance for topic question if topic exists
        $template = $topicQuestions[array_rand($topicQuestions)];
        $item['question'] = sprintf($template, strtolower($topic));
    } else {
        $item['question'] = $genericQuestions[array_rand($genericQuestions)];
    }
}
unset($item);

file_put_contents('config/pte_listening_mcsa.php', "<?php\n\nreturn " . var_export($mcsa, true) . ";\n");
echo "Done fixing MCSA question texts!\n";
