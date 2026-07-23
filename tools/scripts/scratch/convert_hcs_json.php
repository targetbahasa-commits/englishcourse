<?php
$json = file_get_contents(__DIR__.'/hcs_temp.json');
$data = json_decode($json, true);

if ($data && count($data) > 0) {
    file_put_contents(__DIR__.'/../../../config/pte_highlight_correct_summary.php', "<?php\n\nreturn " . var_export($data, true) . ";\n");
    echo "Converted successfully!\n";
} else {
    echo "Invalid JSON data\n";
}
