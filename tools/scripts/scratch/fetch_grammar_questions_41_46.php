<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=targetbahasa', 'root', 'root');
$stmt = $db->query("SELECT id, topic_id, question, translation FROM grammar_topic_questions WHERE topic_id IN (41, 42, 43, 44, 45, 46) AND type = 'sentence'");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($results, JSON_PRETTY_PRINT);
