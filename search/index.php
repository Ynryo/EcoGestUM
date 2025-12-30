<?php
include(dirname(__FILE__, 2) . '/assets/models/files_header.php');

if (isset($_GET["q"])) {
    include(dirname(__FILE__, 2) . '/assets/models/conn.php');

    $q = strip_tags($_GET["q"]);
    $stmt = $pdo->prepare("SELECT o.id_objet, o.nom_objet, o.desc_objet, c.titre_categorie, o.statut FROM objet AS o JOIN categorie AS c ON o.id_categorie = c.id_categorie WHERE nom_objet LIKE CONCAT('%', :q, '%') OR desc_objet LIKE CONCAT('%', :q, '%')");
    $stmt->bindParam(':q', $q);
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        die("<p class=\"error\">Erreur SQL : " . $e->getMessage() . "</p>");
    }
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM - Rechercher</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(dirname(__FILE__, 2) . '/assets/models/assets.php') ?>
    <link rel="stylesheet" href="/assets/css/search.css">
    <link rel="stylesheet" href="/assets/css/boxs.css">
</head>

<body>
    <?php include(dirname(__FILE__, 2) . '/assets/view/header.php') ?>
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
                        <span class="statut-objet"><?= htmlspecialchars($product["statut"]); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun résultat trouvé.</p>
        <?php endif; ?>
    </section>
    <?php include(dirname(__FILE__, 2) . '/assets/view/footer.php') ?>
</body>

</html>