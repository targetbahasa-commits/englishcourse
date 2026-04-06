import ftplib

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

content = b"""<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
echo "<pre>";
if (!file_exists('composer.phar')) {
    echo "Downloading composer...\\n";
    copy('https://getcomposer.org/composer.phar', 'composer.phar');
}
putenv('COMPOSER_HOME=' . __DIR__ . '/.composer');
echo "Running composer install...\\n";
$output = shell_exec('php composer.phar install --no-dev --optimize-autoloader 2>&1');
echo $output;
echo "\\nDONE!";
?>"""

with open('c_install.php', 'wb') as f:
    f.write(content)

with open('c_install.php', 'rb') as f:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/c_install.php', f)

ftp.quit()
