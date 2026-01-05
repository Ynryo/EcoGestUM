<?php
function newReservation($pdo, $donneur, $p)
{
    echo "1";
    //check if objects is not already reserved by curent user
    $stmt = $pdo->prepare("SELECT * FROM recuperer WHERE id_objet = :p AND id_donneur = :donneur AND date_fin IS NULL;");
    $stmt->bindParam(":p", $p);
    $stmt->bindParam(":donneur", $donneur);
    $stmt->execute();
    $reserved = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "2";
    if (!$reserved) {
        echo "3";
        //add to user's resrvations
        $stmt = $pdo->prepare("INSERT INTO recuperer (id_donneur, id_recepteur, id_objet, date_ajout) VALUES (:id_donneur, :id_recepteur, :p, NOW());");
        $stmt->bindParam(":p", $p);
        $stmt->bindParam(":id_donneur", $donneur);
        $stmt->bindParam(":id_recepteur", $_SESSION["user_id"]);
        $stmt->execute();
        echo "4";
        //change objet's statuts
        $stmt = $pdo->prepare("UPDATE objet SET statut = 'réservé' WHERE objet.id_objet = :p;");
        $stmt->bindParam(":p", $p);
        $stmt->execute();
        header("Location: /reservations/");
        echo "<p class=\"success\">Objet réservé avec succès</p>";
    } else {
        echo "<p class=\"error\">Objet déjà reservé</p>";
    }
}

function cancelReservation($pdo, $donneur, $p)
{
    //check if objects is already reserved by curent user
    $stmt = $pdo->prepare("SELECT * FROM recuperer WHERE id_objet = :p AND id_donneur = :donneur;");
    $stmt->bindParam(":p", $p);
    $stmt->bindParam(":donneur", $donneur);
    $stmt->execute();
    $reserved = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reserved) {
        //remove from user reservations
        $stmt = $pdo->prepare("DELETE FROM recuperer WHERE id_donneur = :donneur AND id_recepteur = :recepteur AND id_objet = :p");
        $stmt->bindParam(":p", $p);
        $stmt->bindParam(":donneur", $donneur);
        $stmt->bindParam(":recepteur", $_SESSION["user_id"]);
        $stmt->execute();

        //change object status
        $stmt = $pdo->prepare("UPDATE objet SET statut = 'disponible' WHERE objet.id_objet = :p;");
        $stmt->bindParam(":p", $p);
        $stmt->execute();
        header("Location: /reservations/");
        echo "<p class=\"success\">Réservation annulée avec succès</p>";
    }
}

session_start();
if (isset($_SESSION["user_id"])) {
    require_once(dirname(__FILE__, 2) . '/assets/models/conn.php');

    //get id_donneur
    $p = strip_tags($_GET["p"]);
    $stmt = $pdo->prepare("SELECT id_inventaire FROM agencer WHERE id_objet = :p;");
    $stmt->bindParam(":p", $p);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $donneur = $result["id_inventaire"];

    switch ($_GET["action"]) {
        case "new":
            newReservation($pdo, $donneur, $p);
            break;

        case "cancel":
            cancelReservation($pdo, $donneur, $p);
            break;

        default:
            exit;
    }
} else {
    echo "<p class=\"error\">Session not start</p>";
}
