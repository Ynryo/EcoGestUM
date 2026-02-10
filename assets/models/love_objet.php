<?php
session_start();

if (isset($_GET["request"])) {
    include_once dirname(__FILE__, 3) . '/assets/models/conn.php';
    if ($_GET["request"] == "load") {
        $stmt = $pdo->prepare("SELECT a.id_objet, a.id_utilisateur FROM aimer a JOIN utilisateur u ON a.id_utilisateur = u.id_utilisateur JOIN objet o ON o.id_objet = a.id_objet WHERE u.id_utilisateur = :u AND o.id_objet = :p;");
        $stmt->bindParam(':u', $_SESSION["user_id"]);
        $stmt->bindParam(':p', $_GET["p"]);
        $stmt->execute();
        $objet = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($objet == null) {
            echo json_encode(0);
        } else {
            echo json_encode(1);
        }
    } elseif ($_GET["request"] == "add") {
        $stmt = $pdo->prepare("INSERT INTO aimer (id_utilisateur, id_objet) VALUES (:u, :p);");
        $stmt->bindParam(':u', $_SESSION["user_id"]);
        $stmt->bindParam(':p', $_GET["p"]);
        $stmt->execute();
    } elseif ($_GET["request"] == "remove") {
        $stmt = $pdo->prepare("DELETE FROM aimer WHERE id_utilisateur = :u AND id_objet = :p;");
        $stmt->bindParam(':u', $_SESSION["user_id"]);
        $stmt->bindParam(':p', $_GET["p"]);
        $stmt->execute();
    } else {
        echo json_encode($_GET["request"]);
    }
} else {
    echo json_encode("request undefined");
}
