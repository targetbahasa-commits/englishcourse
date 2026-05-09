<?php
// Render the blade view as authenticated admin
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Find admin user
$user = App\Models\User::where('role', 'admin')->first();
if (!$user) {
    die("No admin user found\n");
}

// Simulate logged in request
$request = Illuminate\Http\Request::create(
    '/assignments/toefl-itp/reading-practice/package/1',
    'GET',
    [],  // query
    [],  // cookies
    [],  // files
    ['SERVER_NAME' => 'targetbahasacourse.test']
);

// Log in the user
$request->setLaravelSession($app->make('session')->driver());
$request->session()->put('_token', csrf_token());
Auth::login($user);

$response = $kernel->handle($request);
$html = $response->getContent();
$status = $response->getStatusCode();

echo "Status: $status\n";
echo "Content length: " . strlen($html) . "\n";

if ($status !== 200) {
    echo "Location: " . $response->headers->get('Location') . "\n";
    exit;
}

// Check for key elements
echo "Has <main: " . (strpos($html, '<main') !== false ? 'YES' : 'NO') . "\n";
echo "Has toefl-practice-shell: " . (strpos($html, 'toefl-practice-shell') !== false ? 'YES' : 'NO') . "\n";
echo "Has readingPracticePage: " . (strpos($html, 'readingPracticePage') !== false ? 'YES' : 'NO') . "\n";
echo "Has header tag: " . (strpos($html, '<header') !== false ? 'YES' : 'NO') . "\n";
echo "Has passages-panel: " . (strpos($html, 'passages-panel') !== false ? 'YES' : 'NO') . "\n";

// Check if error
if (strpos($html, 'Whoops') !== false || strpos($html, 'Symfony\Component\Debug') !== false) {
    echo "\n=== ERROR FOUND ===\n";
    // Extract error message
    preg_match('/<div class="exception-message[^"]*">(.*?)<\/div>/s', $html, $m);
    echo $m[1] ?? "Unknown error\n";
}

// Save to file for inspection
file_put_contents('/tmp/debug_reading_output.html', $html);
echo "\nHTML saved to /tmp/debug_reading_output.html\n";
echo "Check: grep -n 'main\|toefl-practice-shell\|readingPracticePage' /tmp/debug_reading_output.html | head -20\n";
