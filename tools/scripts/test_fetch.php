<?php
$ch = curl_init('http://localhost:8001/auto-login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$res = curl_exec($ch);
file_put_contents('live_output.html', $res);
echo "Fetched.";
