<?php
include_once(dirname(__FILE__, 3) . '/assets/models/access_controller.php');
include_once(dirname(__FILE__, 3) . '/assets/models/conn.php');
include_once(dirname(__FILE__, 3) . '/assets/models/mProfile.php');

$stmt = $pdo->prepare("SELECT * FROM INVENTAIRE i JOIN DEPARTEMENT d ON i.id_inventaire = d.id_inventaire WHERE i.id_inventaire = :inventaire;");
$stmt->bindParam(':inventaire', $_GET["id"]);

$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// if ($objet == null) {
//     header('HTTP/1.0 404 Not Found');
//     header('Location: /errors/404');
//     exit();
// }
?>
<?php include(dirname(__FILE__, 3) . '/assets/models/assets.php') ?>
<title>EcoGestUM - Inventaire</title>
<link rel="stylesheet" href="/assets/css/search.css">
<link rel="stylesheet" href="/assets/css/products.css">
</head>

<body>
    <?php include(dirname(__FILE__, 3) . '/assets/view/header.php') ?>
    <section class="main">
        <div class="ariane-link">
            <a href="/" class="link">Accueil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            Produits

            <?php if (isset($_GET["p"])): ?>
                <span class="material-symbols-outlined">arrow_forward_ios</span>
                <a href="/products/?c=<?= $objet["id_categorie"] ?>"
                    class="link"><?= htmlspecialchars($objet["titre_categorie"]) ?></a>
                <span class="material-symbols-outlined">arrow_forward_ios</span>
                <?= htmlspecialchars($objet["nom_objet"]) ?>
            <?php endif; ?>
        </div>
        <?php
        // foreach($result)
        var_dump($result);
        ?>
    </section>
    <?php include(dirname(__FILE__, 3) . '/assets/view/footer.php') ?>
    <script src="/assets/js/love-button.js"></script>
</body>

</html>