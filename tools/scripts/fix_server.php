<?php
// Fix .env in laravel_app
if (!file_exists(__DIR__ . '/../laravel_app/.env') && file_exists(__DIR__ . '/.env')) {
    copy(__DIR__ . '/.env', __DIR__ . '/../laravel_app/.env');
}

// Fix index.php to boot from laravel_app
$index_php = __DIR__ . '/index.php';
$content = file_get_contents($index_php);
$content = preg_replace("/__DIR__\.'\/\.\.\/vendor\/autoload\.php'/", "__DIR__.'/../laravel_app/vendor/autoload.php'", $content);
$content = preg_replace("/__DIR__\.'\/\.\.\/bootstrap\/app\.php'/", "__DIR__.'/../laravel_app/bootstrap/app.php'", $content);
file_put_contents($index_php, $content);

// Create symlinks or copy assets
$assets = ['css', 'js', 'images', 'fonts'];
foreach ($assets as $asset) {
    if (file_exists(__DIR__ . '/../laravel_app/public/' . $asset)) {
        // If it exists in public_html and is a directory (not a symlink), copy contents to avoid deleting user files
        // Actually, just recursively copy instead of symlink to avoid permission issues
        shell_exec("cp -r " . __DIR__ . "/../laravel_app/public/$asset/* " . __DIR__ . "/$asset/ 2>/dev/null || true");
    }
}
echo "FIXED";
