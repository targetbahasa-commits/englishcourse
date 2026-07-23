import ftplib

# Upload a temporary artisan runner to clear cache on production
php_content = b"""<?php
// Temporary cache clearer - delete this file after use
define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\\Contracts\\Console\\Kernel::class);
$status = $kernel->handle(
    $input = new Symfony\\Component\\Console\\Input\\ArrayInput(['command' => 'route:clear']),
    new Symfony\\Component\\Console\\Output\\ConsoleOutput()
);
$kernel->handle(
    $input = new Symfony\\Component\\Console\\Input\\ArrayInput(['command' => 'view:clear']),
    new Symfony\\Component\\Console\\Output\\ConsoleOutput()
);
$kernel->handle(
    $input = new Symfony\\Component\\Console\\Input\\ArrayInput(['command' => 'config:clear']),
    new Symfony\\Component\\Console\\Output\\ConsoleOutput()
);
echo "\\nCache cleared!\\n";
"""

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

import io
ftp.storbinary('STOR /domains/targetbahasa.com/public_html/public/clear_cache_tmp.php', io.BytesIO(php_content))
print("Uploaded cache clearer to: https://targetbahasa.com/clear_cache_tmp.php")
ftp.quit()
