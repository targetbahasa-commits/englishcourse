<?php $dirs = ["/home/u822472458/domains/targetbahasa.com/public_html/storage/framework/cache/data/", "/home/u822472458/domains/targetbahasa.com/public_html/storage/framework/"]; foreach($dirs as $d) { $files = @scandir($d); if ($files) { foreach($files as $f) { if ($f != "." && $f != "..") echo "$d$f
"; } } }
