<?php
include_once(dirname(__FILE__, 2) . '/assets/src/files_header.php');
include_once(dirname(__FILE__, 2) . '/assets/src/conn.php');

$stmt = $pdo->prepare("SELECT * FROM recuperer r JOIN objet o ON r.id_objet = o.id_objet WHERE id_recepteur = :u;");
$stmt->bindParam(':u', $_SESSION["user_id"]);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM - Réservations</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(dirname(__FILE__, 2) . '/assets/src/assets.php') ?>
    <link rel="stylesheet" href="/assets/css/search.css">
    <link rel="stylesheet" href="/assets/css/boxs.css">
</head>

<body>
    <?php include(dirname(__FILE__, 2) . '/assets/view/header.php') ?>
    <section class="main">
        <div class="ariane-link">
            <a href="/" class="link">Accueil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            <a href="/profile/" class="link">Profil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            Réservations
        </div>

        <div>
            <div class="cards-container-title">
                <h3>Réservations</h3>
            </div>
            <?php if (!empty($results)): ?>
                <div class="cards-container wrap">
                    <?php foreach ($results as $product):
                        $pattern = $_SERVER["DOCUMENT_ROOT"] . "/assets/img/products/" . $product["id_objet"] . '_*';
                        $files = glob($pattern); ?>
                        <a href="/products/?p=<?= htmlspecialchars($product["id_objet"]) ?>" class="card little">
                            <img src="<?= str_replace($_SERVER["DOCUMENT_ROOT"], "", $files[0]) ?>" alt="<?= htmlspecialchars($product["desc_objet"]); ?>">
                            <h4><?= htmlspecialchars($product["nom_objet"]); ?></h4>
                            <span class="statut-objet"><?= htmlspecialchars($product["statut"]); ?></span>
                            <a href="/products/reserve.php?p=<?= htmlspecialchars($product["id_objet"]) ?>&action=cancel" class="button blue little">Annuler réservation</a>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Vous n'avez pas de produits en cours de réservation.</p>
            <?php endif; ?>
        </div>
    </section>
    <?php include(dirname(__FILE__, 2) . '/assets/view/footer.php') ?>
</body>

</html>