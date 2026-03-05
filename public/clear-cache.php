<?php
// Simple cache clearing script for emergency use
require __DIR__ . '/../bootstrap/app.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

try {
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    
    // Clear various caches
    $kernel->call('view:clear');
    $kernel->call('cache:clear');
    $kernel->call('config:clear');
    
    echo json_encode([
        'success' => true,
        'message' => 'Cache cleared successfully'
    ], JSON_PRETTY_PRINT);
} catch (\Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
?>
