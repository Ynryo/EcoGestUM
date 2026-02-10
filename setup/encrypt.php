<?php
include_once dirname(__FILE__, 2) . '/assets/models/conn.php';

$stmt = $pdo->prepare("SELECT * FROM utilisateur;");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $user):
        $stmt = $pdo->prepare("UPDATE utilisateur SET mdp_univ = '" . password_hash($user['mdp_univ'], PASSWORD_DEFAULT) . "' WHERE id_utilisateur = " . $user['id_utilisateur'] . ";");
        $stmt->execute();
endforeach;
