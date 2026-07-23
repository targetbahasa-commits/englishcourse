<?php $log = file_get_contents("/home/u822472458/domains/targetbahasa.com/public_html/storage/logs/laravel.log"); $lines = explode("
", $log); $errors = []; foreach($lines as $l) { if (strpos($l, "local.ERROR") !== false) { $errors[] = $l; } } $last = array_slice($errors, -5); echo implode("
", $last);
