<?php
include_once dirname(__FILE__, 1) . '/conn.php';
$stmt = $pdo->prepare("UPDATE `utilisateur` SET `mdp_univ` = :pwd WHERE `utilisateur`.`id_utilisateur` = 1;");
$pwd_hashed = password_hash("fhd586scv", PASSWORD_DEFAULT);
$stmt->bindParam(':pwd', $pwd_hashed);
$stmt->execute();
echo "mdp change successfully";
