<?php include(dirname(__FILE__, 2) . '/assets/models/access_controller.php') ?>
<?php include(dirname(__FILE__, 2) . '/assets/models/assets.php') ?>
<title>EcoGestUM - Communiqués</title>
<link rel="preload" fetchpriority="high" as="image" href="/assets/img/lmu-logo-for-titles.png" type="image/png">
<link rel="stylesheet" href="/assets/css/press-releases.css">
<link rel="stylesheet" href="/assets/css/search.css">
</head>

<body>
    <section class="top-container">
        <?php include(dirname(__FILE__, 2) . '/assets/view/header.php') ?>
        <div class="main-title">
            <h1>Communiqués de presse</h1>
        </div>
    </section>
    <div class="main">
        <div class="ariane-link">
            <a href="/" class="link">Accueil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            Communiqués de presse
        </div>
        <?php
        include(dirname(__FILE__, 2) . '/assets/models/conn.php');

        $stmt = $pdo->prepare("SELECT c.titre_communique, c.contenu, c.cat_communique, c.date_publication, u.prenom_utilisateur, u.nom_utilisateur, u.id_role FROM communique c JOIN utilisateur u ON c.id_utilisateur = u.id_utilisateur ORDER BY c.date_publication DESC");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $result): ?>
            <div class="pr-container">
                <div class="top-content">
                    <div class="publisher">
                        <h3><?= htmlspecialchars($result["prenom_utilisateur"]) . " " . htmlspecialchars($result["nom_utilisateur"]) ?>
                        </h3>
                        <span class="role r<?= htmlspecialchars($result["id_role"]) ?>"></span>
                    </div>
                    <div class="timedate">
                        <span><?= htmlspecialchars(date_format(date_create($result["date_publication"]), "d/m/Y")) ?></span>
                        <span>&#x2022</span>
                        <span><?= htmlspecialchars(date_format(date_create($result["date_publication"]), "H:i")) ?></span>
                    </div>
                </div>
                <div class="content">
                    <?= strip_tags($result["contenu"], "<br>") ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php include(dirname(__FILE__, 2) . '/assets/view/footer.php') ?>
</body>

</html>