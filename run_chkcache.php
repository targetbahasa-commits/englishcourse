<?php $bs = "/home/u822472458/domains/targetbahasa.com/public_html/bootstrap/cache/"; $files = scandir($bs); foreach($files as $f) { if ($f != "." && $f != "..") { echo $f . " - " . date("Y-m-d H:i", filemtime($bs.$f)) . "
"; } }
