-- TOEFL Reading Meeting 2 - SQL Insert Script
-- Run this in your MySQL database

-- Insert or get Meeting 2
INSERT INTO toefl_reading_meetings (meeting_number, title, is_locked, created_at, updated_at)
VALUES (2, 'Main Ideas 2', 0, NOW(), NOW())
ON DUPLICATE KEY UPDATE title = 'Main Ideas 2';

-- Get the meeting_id (replace X with actual ID after running above)
SET @meeting_id = (SELECT id FROM toefl_reading_meetings WHERE meeting_number = 2);

-- Passage 1: American Folk Music
INSERT INTO toefl_reading_passages (meeting_id, passage_number, content, created_at, updated_at)
VALUES (
    @meeting_id,
    1,
    'American folk music originated with ordinary people at a time when the rural population was isolated and music was not yet spread by radio, audios, compact disks, or music DVDs. It was transmitted by oral tradition and is noted for its energy, humor, and emotional impact. The major source of early American folk songs was music from the British Isles, but songs from Africa as well as songs of the American Indians have a significant part in its heritage. Later settlers from other countries also contributed songs. In the nineteenth century, composer Stephen Foster wrote some of the most enduringly popular of all American songs, which soon became part of the folk tradition. Beginning in the 1930\'s, Woody Guthrie gained great popularity by adapting traditional melodies and lyrics and supplying new ones as well. In the 1950\'s and 1960\'s, singer-composers such as Pete Seeger, Bob Dylan, and Joan Baez continued this tradition by creating "urban" folk music. Many of these songs dealt with important social issues, such as racial integration and the war in Vietnam.',
    NOW(),
    NOW()
);

SET @passage1_id = LAST_INSERT_ID();

-- Question for Passage 1
INSERT INTO toefl_reading_questions (passage_id, question_number, question_text, option_a, option_b, option_c, option_d, correct_answer, created_at, updated_at)
VALUES (
    @passage1_id,
    1,
    'The primary purpose of this passage is to',
    'trace the development of American folk music',
    'explain the oral tradition',
    'contrast the styles of folk musicians',
    'point out the influence of social issues on "urban" folk music',
    'A',
    NOW(),
    NOW()
);

-- Passage 2: Psychology Language
INSERT INTO toefl_reading_passages (meeting_id, passage_number, content, created_at, updated_at)
VALUES (
    @meeting_id,
    2,
    'Every scientific discipline tends to develop its own special language because it finds ordinary words inadequate, and psychology is no different. The purpose of this special jargon is not to mystify non-psychologists; rather, it allows psychologists to accurately describe the phenomena they are discussing and to communicate with each other effectively. Of course, psychological terminology consists in part of everyday words such as emotion, intelligence, and motivation, but psychologists use these words somewhat differently. For example, laymen use the term anxiety to mean nervousness or fear, but most psychologists reserve the term to describe a condition produced when one fears events over which one has no control.',
    NOW(),
    NOW()
);

SET @passage2_id = LAST_INSERT_ID();

-- Question for Passage 2
INSERT INTO toefl_reading_questions (passage_id, question_number, question_text, option_a, option_b, option_c, option_d, correct_answer, created_at, updated_at)
VALUES (
    @passage2_id,
    2,
    'The main topic of this passage is',
    'effective communication',
    'the special language of psychology',
    'two definitions of the word anxiety',
    'the jargon of science',
    'B',
    NOW(),
    NOW()
);

-- Passage 3: Gifford Pinchot
INSERT INTO toefl_reading_passages (meeting_id, passage_number, content, created_at, updated_at)
VALUES (
    @meeting_id,
    3,
    'Gifford Pinchot was the first professionally trained forester in the United States. After he graduated from Yale in 1889, he studied forestry in Europe. In the 1890\'s he managed the forest on the Biltmore estate in North Carolina (now Pisgah National Forest) and became the first to practice scientific forestry. Perhaps his most important contribution to conservation was persuading President Theodore Roosevelt to set aside millions of acres in the West as forest reserves. These lands now make up much of the national parks and national forests of the United States. Pinchot became the Chief Forester of the U.S. Forest Service in 1905. Although he held that post for only five years, he established guidelines that set forest policy for decades to come.',
    NOW(),
    NOW()
);

-- Note: No question provided for Passage 3 in the screenshot
-- Add question manually if needed
