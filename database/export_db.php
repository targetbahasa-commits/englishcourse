<?php
$sqlitePath = __DIR__ . '/database.sqlite';
$pdo = new PDO("sqlite:$sqlitePath");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Tables to ignore
$ignore = [
    'migrations', 'cache', 'cache_locks', 'sessions', 'jobs', 'failed_jobs', 'job_batches', 'sqlite_sequence'
];

$tablesQuery = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
$tables = $tablesQuery->fetchAll(PDO::FETCH_COLUMN);

$sql = "";

foreach ($tables as $table) {
    if (in_array($table, $ignore)) continue;

    $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
    if (empty($rows)) continue;

    echo "Exporting $table (" . count($rows) . " rows)\n";

    $columns = array_keys($rows[0]);
    $colsStr = "`" . implode("`, `", $columns) . "`";

    $sql .= "TRUNCATE TABLE `$table`;;;\n";

    foreach ($rows as $row) {
        $values = [];
        foreach ($columns as $col) {
            $val = $row[$col];
            
            if ($val === null) {
                $values[] = 'NULL';
            } elseif (is_numeric($val)) {
                $values[] = $val;
            } else {
                // Fix invalid PHP array syntax in JSON columns
                $jsonCols = ['vocab_helper', 'answers', 'options', 'content', 'example', 'data', 'subtopics', 'ai_raw_json_feedback', 'ai_raw_feedback', 'questions', 'metadata'];
                if (in_array($col, $jsonCols) && is_string($val) && strpos(trim($val), '[') === 0) {
                    $val = str_replace(["['", "']", "' => '", "', '"], ['{"', '"}', '":"', '","'], trim($val));
                }
                
                // For MySQL JSON columns, empty string is invalid, so if it's an empty string and the column is nullable in MySQL, we should probably cast to NULL, but to be safe we'll use an empty object {} if it's meant to be JSON, or let MySQL throw. Actually, let's cast '' to '{}' for known JSON columns
                if ($val === '' && in_array($col, $jsonCols) && $col !== 'content') {
                    $val = '{}';
                }
                
                // Use MySQL-compatible escaping (backslash, not double-single-quote like SQLite)
                $escaped = str_replace(
                    ["\\", "'", "\r", "\n", "\x00", "\x1a"],
                    ["\\\\", "\\'", "\\r", "\\n", "\\0", "\\Z"],
                    $val
                );
                $values[] = "'$escaped'";
            }
        }
        $valsStr = implode(", ", $values);
        $sql .= "INSERT INTO `$table` ($colsStr) VALUES ($valsStr);;;\n";
    }
}

file_put_contents(__DIR__ . '/../data_import_with_cols.sql', $sql);
echo "Export done! Size: " . filesize(__DIR__ . '/../data_import_with_cols.sql') . " bytes\n";
