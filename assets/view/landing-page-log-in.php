<?php
include(dirname(__FILE__, 3) . '/assets/src/conn.php');

$stmt = $pdo->prepare("SELECT id_objet, nom_objet, desc_objet FROM objet ORDER BY date_ajout ASC LIMIT 10");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(dirname(__FILE__, 3) . '/assets/src/assets.php') ?>
    <link rel="preload" fetchpriority="high" as="image" href="/assets/img/landing-page-background.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/search.css">
    <link rel="stylesheet" href="/assets/css/boxs.css">
    <link rel="stylesheet" href="/assets/css/post-ads.css">
</head>

<body>
    <?php
    include(dirname(__FILE__, 3) . '/assets/view/header.php') ?>
    <section class="main">
        <h2>Bonjour <?= htmlspecialchars($_SESSION["user_name"]) ?> !</h2>

        <div class="invit-to-post">
            <div class="box blue">
                <h4>Des objets qui trainent ? C'est le moment de vous lancer !</h4>
                <a href="/donation-deposit/" class="button blue">Publier une annonce de don</a>
            </div>
        </div>

        <div>
            <div class="cards-container-title">
                <h3>Coups de cœur</h3>
                <a href="/profile/loved/" class="link icon">
                    voir plus
                    <span class="material-symbols-outlined">
                        arrow_right_alt
                    </span>
                </a>
            </div>
            <div class="cards-container">
                <?php foreach ($results as $product):
                    $pattern = $_SERVER["DOCUMENT_ROOT"] . "/assets/img/products/" . $product["id_objet"] . '_*';
                    $files = glob($pattern); ?>
                    <a href="/products/?p=<?= htmlspecialchars($product["id_objet"]) ?>" class="card little">
                        <img src="<?= str_replace($_SERVER["DOCUMENT_ROOT"], "", $files[0]) ?>" alt="<?= htmlspecialchars($product["desc_objet"]); ?>">
                        <h4><?= htmlspecialchars($product["nom_objet"]); ?></h4>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include(dirname(__FILE__, 3) . '/assets/view/footer.php') ?>
</body>

</html>