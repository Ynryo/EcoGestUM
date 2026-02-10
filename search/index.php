<?php
include_once dirname(__FILE__, 2) . '/assets/models/access_controller.php';

$results = [];
if (isset($_GET["q"])) {
    include_once dirname(__FILE__, 2) . '/assets/models/conn.php';
    include_once dirname(__FILE__, 2) . '/assets/models/mSearch.php';

    $q = strip_tags($_GET["q"]);
    $results = searchObjects($pdo, $q);
}
?>
<?php include_once dirname(__FILE__, 2) . '/assets/models/assets.php' ?>
<title>EcoGestUM - Rechercher</title>
<link rel="stylesheet" href="/assets/css/search.css">
<link rel="stylesheet" href="/assets/css/boxs.css">
</head>

<body>
    <?php include_once dirname(__FILE__, 2) . '/assets/view/header.php' ?>
    <section class="main">
        <div class="ariane-link">
            <a href="/" class="link">Accueil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            <a href="/products/" class="link">Produits</a>

            <?php if (isset($_GET["q"])): ?>
                <span class="material-symbols-outlined">arrow_forward_ios</span>
                Recherche : <?= htmlspecialchars($_GET["q"]) ?>
            <?php endif; ?>
        </div>

        <div class="cards-container">
            <?php if (!empty($results)):
                foreach ($results as $product):
                    $pattern = $_SERVER["DOCUMENT_ROOT"] . "/assets/img/products/" . $product["id_objet"] . '_*';
                    $files = glob($pattern); ?>
                    <a href="/products/?p=<?= htmlspecialchars($product["id_objet"]) ?>" class="card little">
                        <img src="<?= str_replace($_SERVER["DOCUMENT_ROOT"], "", $files[0]) ?>"
                            alt="<?= htmlspecialchars($product["desc_objet"]); ?>">
                        <h4><?= htmlspecialchars($product["nom_objet"]); ?></h4>
                        <p>(<?= htmlspecialchars($product["titre_categorie"]); ?>)</p>
                        <span class="status <?= htmlspecialchars($product["statut"]) ?>"></span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun résultat trouvé.</p>
        <?php endif; ?>
    </section>
    <?php include_once dirname(__FILE__, 2) . '/assets/view/footer.php' ?>
</body>

</html>