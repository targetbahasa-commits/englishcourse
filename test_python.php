<?php
echo "<pre>";
echo "Testing Python3...\n";
$output = shell_exec('python3 --version 2>&1');
echo $output . "\n";
echo "Testing Kokoro imports...\n";
$output2 = shell_exec('python3 -c "import torch; import kokoro; print(\'OK\')" 2>&1');
echo $output2 . "\n";
echo "</pre>";
