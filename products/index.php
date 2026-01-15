<?php
if (isset($_GET["p"])) {
    require_once(dirname(__FILE__, 2) . '/assets/view/product_display.php');
} else if (isset($_GET["c"])) {
    require_once(dirname(__FILE__, 2) . '/assets/view/categorie_display.php');
} else {
    require_once(dirname(__FILE__, 2) . '/assets/view/product_list.php');
    echo "1";
}
