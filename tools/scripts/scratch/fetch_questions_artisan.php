<?php
$questions = DB::table('grammar_topic_questions')
    ->whereIn('topic_id', [41, 42, 43, 44, 45, 46])
    ->where('type', 'sentence')
    ->get(['id', 'topic_id', 'question', 'translation', 'example']);
echo json_encode($questions, JSON_PRETTY_PRINT);
