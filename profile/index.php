<?php
include(dirname(__FILE__, 2) . '/assets/src/files_header.php');
include(dirname(__FILE__, 2) . '/assets/src/conn.php');

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
    <?php include(dirname(__FILE__, 2) . '/assets/src/assets.php') ?>
    <link rel="stylesheet" href="/assets/css/search.css">
    <link rel="stylesheet" href="/assets/css/boxs.css">
    <link rel="stylesheet" href="/assets/css/profile.css">
</head>

<body>
    <?php include(dirname(__FILE__, 2) . '/assets/view/header.php') ?>
    <section class="main profile">
        <div class="ariane-link">
            <a href="/" class="link">Accueil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            Profil
        </div>
        <div>
            <img src="/assets/img/profile_pictures/1.jpg" alt="Photo de profil de l'utilisateur">
            <div>
                <h1><?= htmlspecialchars($results["prenom_utilisateur"]) ?> <?= htmlspecialchars($results["nom_utilisateur"]) ?></h1>
                <span class="role r<?= htmlspecialchars($results["id_role"]) ?>"></span>
                <a href="mailto:<?= htmlspecialchars($results["mail_univ"]) ?>" class="link">Email : <?= htmlspecialchars($results["mail_univ"]) ?></a>
            </div>
        </div>
        <div class="nav-container">
            <a href="/panel/" class="content">
                <h4>Panneau de gestion</h4>
                <span class="material-symbols-outlined">
                    discover_tune
                </span>
            </a>
            <a href="https://activation.univ-lemans.fr/cgi-bin/activation/change-mdp.pl" class="content">
                <h4>Modifier mot de passe</h4>
                <span class="material-symbols-outlined">
                    person_edit
                </span>
            </a>
            <a href="/profile/loved/" class="content">
                <h4>Coups de coeur</h4>
                <span class="material-symbols-outlined">
                    favorite
                </span>
            </a>
        </div>
    </section>
    <?php include(dirname(__FILE__, 2) . '/assets/view/footer.php') ?>
</body>

</html>