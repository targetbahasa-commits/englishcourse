#!/bin/bash
/Applications/MAMP/bin/php/php8.4.1/bin/php artisan serve --port=8001 > /dev/null 2>&1 &
echo $! > server.pid
echo "Server started on port 8001"
