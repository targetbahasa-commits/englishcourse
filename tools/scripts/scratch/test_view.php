<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$user = App\Models\User::first();
Auth::login($user);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/assignments/ielts-academic/writing/2/meeting/204', 'GET')
);
$content = $response->getContent();
preg_match('/<div id="ideas-component"([^>]+)>/', $content, $matches);
print_r($matches);
