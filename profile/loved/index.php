<?php
include(dirname(__FILE__, 3) . '/assets/models/access_controller.php');
include(dirname(__FILE__, 3) . '/assets/models/conn.php');
include(dirname(__FILE__, 3) . '/assets/models/mLoved.php');

$results = getUserLovedObjects($pdo, $_SESSION["user_id"]);
?>
<?php include(dirname(__FILE__, 3) . '/assets/models/assets.php') ?>
<title>EcoGestUM - Coups de coeur</title>
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

        <div>
            <div class="cards-container-title">
                <h3>Coups de cœur</h3>
            </div>
            <?php if (!empty($results)): ?>
                <div class="cards-container wrap">
                    <?php foreach ($results as $product):
                        $pattern = $_SERVER["DOCUMENT_ROOT"] . "/assets/img/products/" . $product["id_objet"] . '_*';
                        $files = glob($pattern); ?>
                        <a href="/products/?p=<?= htmlspecialchars($product["id_objet"]) ?>" class="card little">
                            <img src="<?= str_replace($_SERVER["DOCUMENT_ROOT"], "", $files[0]) ?>"
                                alt="<?= htmlspecialchars($product["desc_objet"]); ?>">
                            <h4><?= htmlspecialchars($product["nom_objet"]); ?></h4>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Vous n'avez pas de produits en favoris.</p>
            <?php endif; ?>
        </div>
    </section>
    <?php include(dirname(__FILE__, 3) . '/assets/view/footer.php') ?>
</body>

</html>