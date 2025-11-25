<?php
session_start();
if (isset($_SESSION["user_id"])) {
    //check if objects is not already reserved by curent user
    include(dirname(__FILE__, 2) . '/assets/src/conn.php');
    $p = strip_tags($_GET["p"]);
    $stmt = $pdo->prepare("SELECT * FROM recuperer WHERE id_objet = :p;");
    $stmt->bindParam(":p", $p);
    $stmt->execute();
    $reserved = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reserved) {
        //get id_donneur
        $stmt = $pdo->prepare("SELECT id_inventaire FROM agencer WHERE id_objet = :p;");
        $stmt->bindParam(":p", $p);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die("<p class=\"error\">Erreur SQL : " . $e->getMessage() . "</p>");
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $donneur = $result["id_inventaire"];


        //add to user's resrvations
        $stmt = $pdo->prepare("INSERT INTO recuperer (id_donneur, id_recepteur, id_objet, date_ajout) VALUES (:id_donneur, :id_recepteur, :p, :date);");
        $stmt->bindParam(":p", $p);
        $stmt->bindParam(":id_donneur", $donneur);
        $stmt->bindParam(":id_recepteur", $_SESSION["user_id"]);
        $stmt->bindParam(":date", date("Y-m-d"));
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die("<p class=\"error\">Erreur SQL : " . $e->getMessage() . "</p>");
        }

        //change objet's statuts
        $stmt = $pdo->prepare("UPDATE `objet` SET `statut` = 'Réservé' WHERE `objet`.`id_objet` = :p;");
        $stmt->bindParam(":p", $p);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die("<p class=\"error\">Erreur SQL : " . $e->getMessage() . "</p>");
        }
        header("Location: /reservations/");
        echo "<p class=\"success\">Objet réservé avec succès</p>";
    } else {
        echo "<p class=\"error\">Objet déjà reservé</p>";
    }
} else {
    echo "<p class=\"error\">Session not start</p>";
}