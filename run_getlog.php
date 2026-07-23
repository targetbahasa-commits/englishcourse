<?php $log = file_get_contents("/home/u822472458/domains/targetbahasa.com/public_html/storage/logs/laravel.log"); $lines = array_filter(explode("
", $log)); $last = array_slice($lines, -80); echo implode("
", $last);
