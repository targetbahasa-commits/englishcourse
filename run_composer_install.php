<?php
$composerUrl = "https://getcomposer.org/download/latest-stable/composer.phar";
$composerPath = __DIR__ . "/composer.phar";
if (!file_exists($composerPath)) {
    file_put_contents($composerPath, file_get_contents($composerUrl));
}
putenv("COMPOSER_HOME=" . __DIR__ . "/.composer");
$output = shell_exec("php " . $composerPath . " install --no-dev --optimize-autoloader 2>&1");
echo $output;

