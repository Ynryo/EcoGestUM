<?php
function getInventoriesFromChefCompo($pdo)
{
    $stmt = $pdo->prepare("SELECT DISTINCT uc.identifiant AS dir_compo, c.id_composante, c.nom_composante, ud.identifiant AS chef_dep, d.id_departement, d.nom_departement, i.nom_inventaire FROM INVENTAIRE i JOIN DEPARTEMENT d ON i.id_inventaire = d.id_inventaire JOIN utilisateur ud ON ud.id_utilisateur = d.id_utilisateur JOIN composante c ON c.id_composante = d.id_composante JOIN utilisateur uc ON uc.id_utilisateur = c.id_utilisateur WHERE uc.id_utilisateur = :user;");
    $stmt->bindParam(':user', $_SESSION["user_id"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCompoFromChefCompo($pdo)
{
    $stmt = $pdo->prepare("SELECT DISTINCT uc.identifiant AS dir_compo, c.id_composante, c.nom_composante FROM composante c JOIN utilisateur uc ON uc.id_utilisateur = c.id_utilisateur WHERE uc.id_utilisateur = :user;");
    $stmt->bindParam(':user', $_SESSION["user_id"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDepFromChefDep($pdo)
{
    $stmt = $pdo->prepare("SELECT DISTINCT ud.identifiant AS chef_dep, d.id_departement, d.nom_departement FROM departement d JOIN utilisateur ud ON ud.id_utilisateur = d.id_utilisateur WHERE ud.id_utilisateur = :user;");
    $stmt->bindParam(':user', $_SESSION["user_id"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}