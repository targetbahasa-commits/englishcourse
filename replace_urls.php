<?php
$file = __DIR__ . '/resources/views/welcome.blade.php';
$content = file_get_contents($file);
$content = str_replace('https://targetbahasacourse.test/free-tests', "{{ route('guest.free-tests') }}", $content);
$content = str_replace('http://targetbahasacourse.test/daftar', "{{ route('guest.register') }}", $content);
file_put_contents($file, $content);
echo "Replaced successfully.\n";
