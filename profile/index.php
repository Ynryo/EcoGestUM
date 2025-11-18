<?php
include(dirname(__FILE__, 2) . '/assets/src/files_header.php');
include(dirname(__FILE__, 2) . '/assets/src/conn.php');

$stmt = $pdo->prepare("SELECT o.id_objet, o.nom_objet, o.desc_objet, c.titre_categorie FROM OBJET AS o JOIN CATEGORIE AS c ON o.id_categorie = c.id_categorie WHERE nom_objet LIKE CONCAT('%', :q, '%') OR desc_objet LIKE CONCAT('%', :q, '%')");
$stmt->bindParam(':q', $_GET["q"]);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM - Profil</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(dirname(__FILE__, 2) . '/assets/src/assets.php') ?>
    <link rel="stylesheet" href="/assets/css/search.css">
    <link rel="stylesheet" href="/assets/css/boxs.css">
</head>

<body>
    <?php include(dirname(__FILE__, 2) . '/assets/view/header.php') ?>
    <section class="main">
        <div class="ariane-link">
            <a href="/" class="link">Accueil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            <a href="/products/" class="link">Profil</a>
        </div>
        <div>
            <img src="/assets/img/profile_pictures/1.jpg" alt="Photo de profil de l'utilisateur">
            <div>
                
            </div>
        </div>
    </section>
    <?php include(dirname(__FILE__, 2) . '/assets/view/footer.php') ?>
</body>

</html>