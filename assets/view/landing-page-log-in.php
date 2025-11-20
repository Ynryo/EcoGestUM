<?php include(dirname(__FILE__, 3) . '/assets/src/conn.php') ?>
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
        <p>Votre role: <span class="role r<?= htmlspecialchars($results['id_role']) ?>"></p>

        <div class="invit-to-post">
            <div class="box blue">
                <h4>Des objets qui trainent ? C'est le moment de vous lancer !</h4>
                <a href="/donation-deposit/" class="button blue">Publier une annonce de don</a>
            </div>
        </div>
        <?php
        $stmt = $pdo->prepare("SELECT * FROM aimer a JOIN utilisateur u ON a.id_utilisateur = u.id_utilisateur JOIN objet o ON o.id_objet = a.id_objet WHERE u.id_utilisateur = :u LIMIT 4;");
        $stmt->bindParam(':u', $_SESSION["user_id"]);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($results)): ?>
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
        <?php endif; ?>

        <?php
        $stmt = $pdo->prepare("SELECT * FROM objet LIMIT 8;");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div>
            <div class="cards-container-title">
                <h3>Tous les produits</h3>
                <a href="/search/?q=" class="link icon">
                    voir plus
                    <span class="material-symbols-outlined">
                        arrow_right_alt
                    </span>
                </a>
            </div>
            <div class="cards-container-grid">
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