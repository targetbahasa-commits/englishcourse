<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
echo "<pre>";
if (!file_exists('composer.phar')) {
    echo "Downloading composer...\n";
    copy('https://getcomposer.org/composer.phar', 'composer.phar');
}
putenv('COMPOSER_HOME=' . __DIR__ . '/.composer');
echo "Running composer install...\n";
$output = shell_exec('php composer.phar install --no-dev --optimize-autoloader 2>&1');
echo $output;
echo "\nDONE!";
?>