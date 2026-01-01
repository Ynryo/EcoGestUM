<?php
include_once(dirname(__FILE__, 3) . '/assets/models/access_controller.php');
include_once(dirname(__FILE__, 3) . '/assets/models/conn.php');
require_once dirname(__FILE__, 3) . '/assets/models/date.php';

$stmt = $pdo->prepare("SELECT o.nom_objet, o.desc_objet, o.etat, o.color, o.size, o.quantity, o.date_ajout, o.statut, c.id_composante, c.coords_composante, i.id_inventaire, i.nom_inventaire, cat.id_categorie, cat.titre_categorie FROM `objet` o JOIN agencer a ON o.id_objet = a.id_objet JOIN inventaire i ON a.id_inventaire = i.id_inventaire JOIN departement d ON d.id_inventaire = i.id_inventaire JOIN composante c on d.id_composante = c.id_composante JOIN categorie cat ON cat.id_categorie = o.id_categorie WHERE o.id_objet = :p;");
$stmt->bindParam(':p', $_GET["p"]);

$stmt->execute();
$objet = $stmt->fetch(PDO::FETCH_ASSOC);

if ($objet == null) {
    header('HTTP/1.0 404 Not Found');
    header('Location: /errors/404');
    exit();
}
?>
<?php include(dirname(__FILE__, 3) . '/assets/models/assets.php') ?>
<title>EcoGestUM - <?= htmlspecialchars($objet["nom_objet"]) ?></title>
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
        <div class="row">
            <?php
            $pattern = $_SERVER["DOCUMENT_ROOT"] . "/assets/img/products/" . $_GET["p"] . '_*';
            $files = glob($pattern);
            ?>
            <div class="row">
                <div class="product-img grid<?= count($files) ?>">
                    <?php
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    foreach ($files as $file):
                        if (finfo_file($finfo, $file) === 'image/png' || finfo_file($finfo, $file) === 'image/jpeg' || finfo_file($finfo, $file) === 'image/webp'):
                            $img = str_replace($_SERVER["DOCUMENT_ROOT"], "", $file); ?>
                            <img src="<?= htmlspecialchars($img) ?>" alt="">
                        <?php endif;
                    endforeach;
                    finfo_close($finfo);
                    ?>
                </div>
                <a class="link love" id="love-button">
                    <span class="material-symbols-outlined">
                        favorite
                    </span>
                </a>
            </div>
            <div class="column">
                <h3><?= htmlspecialchars($objet["nom_objet"]) ?></h3>
                <h4 class="poppins"><?= htmlspecialchars($objet["size"]) ?> | <?= htmlspecialchars($objet["etat"]) ?>
                </h4>
                <p>Ajouté il y a <?= getDuration($objet["date_ajout"]) ?></p>
                <span class="status <?= htmlspecialchars($objet["statut"]) ?>"></span>
                <hr>
                <p>Couleur : <?= htmlspecialchars($objet["color"]) ?></p>
                <p>Etat : <?= htmlspecialchars($objet["etat"]) ?></p>
                <p>Taille : <?= htmlspecialchars($objet["size"]) ?></p>
                <p>Quantité : <?= htmlspecialchars($objet["quantity"]) ?></p>
                <p>Localisation : <span class="composante c<?= htmlspecialchars($objet["id_composante"]) ?>"></span></p>
                <p>Publié par : <a class="link"
                        href="/inventory/people/?id=<?= htmlspecialchars($objet["id_inventaire"]) ?>"><?= htmlspecialchars($objet["nom_inventaire"]) ?></a>
                </p>
                <hr>
                <p><?= htmlspecialchars($objet["desc_objet"]) ?><br>Brewen was here</p>
                <hr>
                <?php
                if ($objet["statut"] == "Réservé") {
                    echo "<a class=\"button blue full disabled\">Déjà réservé</a>";
                } else {
                    echo "<a href=\"/products/reserve.php?p=" . $_GET["p"] . "&action=new\" class=\"button blue full\">Réserver</a>";
                }
                ?>
                <a href="/messages/?to=<?= htmlspecialchars($objet["id_inventaire"]) ?>"
                    class="button blue secondary full">Envoyer un message</a>
                <a href="https://www.google.fr/maps/@<?= htmlspecialchars($objet["coords_composante"]) ?>,555m"
                    class="button blue secondary full">Voir sur la carte</a>
            </div>
        </div>
    </section>
    <?php include(dirname(__FILE__, 3) . '/assets/view/footer.php') ?>
    <script src="/assets/js/love-button.js"></script>
</body>

</html>