<?php
$dirs = [
    __DIR__ . '/storage/framework/views',
    __DIR__ . '/../storage/framework/views'
];
$total = 0;
foreach ($dirs as $viewsDir) {
    if (is_dir($viewsDir)) {
        $files = glob($viewsDir . '/*.php');
        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                    $total++;
                }
            }
        }
    }
}
echo "Deleted $total cached view files successfully!";
