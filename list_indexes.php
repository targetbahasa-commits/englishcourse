<?php

$db = new SQLite3('database/database.sqlite');
$results = $db->query("SELECT name FROM sqlite_master WHERE type='index' AND tbl_name='toefl_listening_questions'");

while ($row = $results->fetchArray()) {
    echo $row['name'] . PHP_EOL;
}
