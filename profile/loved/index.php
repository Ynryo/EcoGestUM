<?php
include(dirname(__FILE__, 3) . '/assets/src/files_header.php');
include(dirname(__FILE__, 3) . '/assets/src/conn.php');

$stmt = $pdo->prepare("SELECT u.nom_utilisateur, u.prenom_utilisateur, u.mail_univ, r.id_role FROM utilisateur u JOIN role r on u.id_role = r.id_role;");
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM - Coups de coeur</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(dirname(__FILE__, 3) . '/assets/src/assets.php') ?>
    <link rel="stylesheet" href="/assets/css/search.css">
    <link rel="stylesheet" href="/assets/css/boxs.css">
</head>

<body>
    <?php include(dirname(__FILE__, 3) . '/assets/view/header.php') ?>
    <section class="main">
        <div class="ariane-link">
            <a href="/" class="link">Accueil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            <a href="/profile/" class="link">Profil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            Coups de coeur
        </div>

    </section>
    <?php include(dirname(__FILE__, 3) . '/assets/view/footer.php') ?>
</body>

</html>