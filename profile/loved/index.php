<?php
include(dirname(__FILE__, 3) . '/assets/src/files_header.php');
include(dirname(__FILE__, 3) . '/assets/src/conn.php');

$stmt = $pdo->prepare("SELECT * FROM aimer a JOIN utilisateur u ON a.id_utilisateur = u.id_utilisateur JOIN objet o ON o.id_objet = a.id_objet WHERE u.id_utilisateur = :u;");
$stmt->bindParam(':u', $_SESSION["user_id"]);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM - Coups de coeur</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(dirname(__FILE__, 3) . '/assets/src/assets.php') ?>
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
            <h3>Coups de cœur</h3>
            <div class="cards-container wrap">
                <?php foreach ($results as $product):
                    $pattern = $_SERVER["DOCUMENT_ROOT"] . "/assets/img/products/" . $product["id_objet"] . '_*';
                    $files = glob($pattern); ?>
                    <a href="/products/?p=<?= htmlspecialchars($product["id_objet"]) ?>" class="card little">
                        <img src="<?= str_replace($_SERVER["DOCUMENT_ROOT"], "", $files[0]) ?>" alt="<?= htmlspecialchars($product["desc_objet"]); ?>">
                        <h4><?= htmlspecialchars($product["nom_objet"]); ?></h4>
                    </a>
                <?php endforeach; ?>
        </div>

    </section>
    <?php include(dirname(__FILE__, 3) . '/assets/view/footer.php') ?>
</body>

</html>