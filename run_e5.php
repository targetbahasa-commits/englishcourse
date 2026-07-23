<?php $log = file_get_contents("/home/u822472458/domains/targetbahasa.com/public_html/storage/logs/laravel.log"); echo "Log size: " . strlen($log) . " bytes
"; echo "First 500 chars:
" . substr($log, 0, 500) . "
---
Last 500 chars:
" . substr($log, -500);
