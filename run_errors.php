<?php $log = file_get_contents("/home/u822472458/domains/targetbahasa.com/public_html/storage/logs/laravel.log"); preg_match_all("/\[.*?\] local\.ERROR: (.*?)(?=\[|\z)/s", $log, $matches); $errors = $matches[0]; $last = array_slice($errors, -3); foreach($last as $e) { echo substr($e, 0, 600); echo "
---
"; }
