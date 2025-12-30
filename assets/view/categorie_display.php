<?php
include(dirname(__FILE__, 3) . '/assets/models/access_controller.php');
include(dirname(__FILE__, 3) . '/assets/models/conn.php');

$stmt = $pdo->prepare("SELECT * FROM categorie c JOIN objet o ON c.id_categorie = o.id_categorie WHERE c.id_categorie = :c");
$stmt->bindParam(':c', $_GET["c"]);
$stmt->execute();
$cat = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cat)) {
    header('HTTP/1.0 404 Not Found');
    header('Location: /errors/404');
    exit();
}
?>
<?php include(dirname(__FILE__, 3) . '/assets/models/assets.php') ?>
<title>EcoGestUM - <?= htmlspecialchars($cat[0]["titre_categorie"]) ?></title>
<link rel="stylesheet" href="/assets/css/search.css">
<link rel="stylesheet" href="/assets/css/products.css">
</head>

<body>
    <?php include(dirname(__FILE__, 3) . '/assets/view/header.php') ?>
    <section class="main">
        <div class="ariane-link">
            <a href="/" class="link">Accueil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            <a href="/products/" class="link">Produits</a>

            <?php if (isset($_GET["c"])): ?>
                <span class="material-symbols-outlined">arrow_forward_ios</span>
                <?= htmlspecialchars($cat[0]["titre_categorie"]) ?>
            <?php endif; ?>
        </div>

        <div class="cards-container">
            <?php if (!empty($cat)):
                foreach ($cat as $product):
                    $pattern = $_SERVER["DOCUMENT_ROOT"] . "/assets/img/products/" . $product["id_objet"] . '_*';
                    $files = glob($pattern); ?>
                    <a href="/products/?p=<?= htmlspecialchars($product["id_objet"]) ?>" class="card little">
                        <img src="<?= str_replace($_SERVER["DOCUMENT_ROOT"], "", $files[0]) ?>"
                            alt="<?= htmlspecialchars($product["desc_objet"]); ?>">
                        <h4><?= htmlspecialchars($product["nom_objet"]); ?></h4>
                        <p>(<?= htmlspecialchars($product["titre_categorie"]); ?>)</p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun objet dans cette catégorie.</p>
        <?php endif; ?>
    </section>
    <?php include(dirname(__FILE__, 3) . '/assets/view/footer.php') ?>
</body>

</html>