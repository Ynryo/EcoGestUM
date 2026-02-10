<?php
include_once dirname(__FILE__, 3) . '/assets/models/access_controller.php';
include_once dirname(__FILE__, 3) . '/assets/models/conn.php';

$stmt = $pdo->prepare("SELECT o.id_objet, o.nom_objet, o.desc_objet, c.titre_categorie, o.statut FROM objet AS o JOIN categorie AS c ON o.id_categorie = c.id_categorie ORDER BY o.id_objet DESC LIMIT 50");
$stmt->execute();
$cat = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cat)) {
    header('HTTP/1.0 404 Not Found');
    header('Location: /errors/404');
    exit();
}
?>
<?php include_once dirname(__FILE__, 3) . '/assets/models/assets.php' ?>
<title>EcoGestUM - Produits</title>
<link rel="stylesheet" href="/assets/css/search.css">
<link rel="stylesheet" href="/assets/css/products.css">
</head>

<body>
    <?php include_once dirname(__FILE__, 3) . '/assets/view/header.php' ?>
    <section class="main">
        <div class="ariane-link">
            <a href="/" class="link">Accueil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            Produits
        </div>

        <div class="cards-container wrap">
            <?php if (!empty($cat)):
                foreach ($cat as $product):
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
            <p>Aucun objet dans cette catégorie.</p>
        <?php endif; ?>
    </section>
    <?php include_once dirname(__FILE__, 3) . '/assets/view/footer.php' ?>
</body>

</html>