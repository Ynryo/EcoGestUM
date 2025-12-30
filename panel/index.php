<?php
include_once(dirname(__FILE__, 2) . '/assets/models/files_header.php');
include_once(dirname(__FILE__, 2) . '/assets/models/conn.php');
include_once(dirname(__FILE__, 2) . '/assets/models/mProfile.php');

$stmt = $pdo->prepare("SELECT u.nom_utilisateur, u.prenom_utilisateur, u.mail_univ, r.id_role FROM utilisateur u JOIN role r on u.id_role = r.id_role WHERE u.id_utilisateur = :u;");
$stmt->bindParam(':u', $_SESSION["user_id"]);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM - Profil</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(dirname(__FILE__, 2) . '/assets/models/assets.php') ?>
    <link rel="stylesheet" href="/assets/css/search.css">
    <link rel="stylesheet" href="/assets/css/boxs.css">
    <link rel="stylesheet" href="/assets/css/navbar.css">
</head>

<body>
    <?php include(dirname(__FILE__, 2) . '/assets/view/header.php') ?>
    <section class="main">
        <?php 
        include(dirname(__FILE__, 2) . '/assets/models/navbar.php');
        include(dirname(__FILE__, 2) . '/assets/view/panel/navbar.php');
        ?>
    </section>

    <?php include(dirname(__FILE__, 2) . '/assets/view/footer.php') ?>
</body>

</html>