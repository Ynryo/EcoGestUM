<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    echo "<p class=\"error\">Session non démarrée</p>";
    exit;
}

require_once(dirname(__FILE__, 2) . '/assets/models/conn.php');
require_once(dirname(__FILE__, 2) . '/assets/models/mReservation.php');

$p = strip_tags($_GET["p"]);
$donneur = getInventoryFromObject($pdo, $p);

if (!$donneur) {
    echo "<p class=\"error\">Objet non trouvé</p>";
    exit;
}

switch ($_GET["action"]) {
    case "new":
        $result = newReservation($pdo, $donneur, $p, $_SESSION["user_id"]);
        if ($result['success']) {
            header("Location: /reservations/");
            exit;
        } else {
            echo "<p class=\"error\">" . htmlspecialchars($result['message']) . "</p>";
        }
        break;

    case "cancel":
        $result = cancelReservation($pdo, $donneur, $p, $_SESSION["user_id"]);
        if ($result['success']) {
            header("Location: /reservations/");
            exit;
        } else {
            echo "<p class=\"error\">" . htmlspecialchars($result['message']) . "</p>";
        }
        break;

    default:
        exit;
}
