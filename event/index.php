<?php include(dirname(__FILE__, 2) . '/assets/models/files_header.php') ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM - Événements</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" fetchpriority="high" as="image" href="/assets/img/lmu-logo-for-titles.png" type="image/png">
    <?php include(dirname(__FILE__, 2) . '/assets/models/assets.php') ?>
    <link rel="stylesheet" href="/assets/css/press-releases.css">
    <link rel="stylesheet" href="/assets/css/search.css">
</head>

<body>
    <section class="top-container">
        <?php include(dirname(__FILE__, 2) . '/assets/view/header.php') ?>
        <div class="main-title">
            <h1>Événements</h1>
        </div>
    </section>
    <div class="main">
        <div class="ariane-link">
            <a href="/" class="link">Accueil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            Événements
        </div>
        <?php
        include(dirname(__FILE__, 2) . '/assets/models/conn.php');

        $stmt = $pdo->prepare("SELECT * FROM evenement ORDER BY date_debut ASC");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $result): ?>
            <div class="pr-container">
                <div class="top-content">
                    <div class="publisher">
                        <h3><?= htmlspecialchars($result["titre_evenement"]) ?></h3>
                    </div>
                    <div class="timedate">
                        <span><?= htmlspecialchars(date_format(date_create($result["date_debut"]), "d/m/Y H:i")) ?></span>
                        <span>&#x2022</span>
                        <span><?= htmlspecialchars(date_format(date_create($result["date_fin"]), "d/m/Y H:i")) ?></span>
                    </div>
                </div>
                <div class="content">
                    <p>Lieu : <span class="composante c<?= htmlspecialchars($result["id_composante"]) ?>"></span></p>
                    <?= strip_tags($result["desc_evenement"], "<br>") ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php include(dirname(__FILE__, 2) . '/assets/view/footer.php') ?>
</body>

</html>