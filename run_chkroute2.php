<?php $content = file_get_contents("/home/u822472458/domains/targetbahasa.com/public_html/routes/web.php"); echo "Size: " . strlen($content) . "
"; if (strpos($content, "offline-tests") !== false) { echo "offline-tests found in routes!
"; } else { echo "offline-tests NOT found in routes!
"; } if (strpos($content, "OfflineTestController") !== false) { echo "OfflineTestController found!
"; } else { echo "OfflineTestController NOT found!
"; }
