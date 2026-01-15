<?php
include(dirname(__FILE__, 2) . '/assets/models/access_controller.php');
include(dirname(__FILE__, 2) . '/assets/models/conn.php');
include(dirname(__FILE__, 2) . '/assets/models/mDonation.php');

$categories = getAllCategories($pdo);
$inventaires = getAllInventories($pdo);
?>
<?php include(dirname(__FILE__, 2) . '/assets/models/assets.php') ?>
<title>EcoGestUM</title>
<link rel="preload" fetchpriority="high" as="image" href="/assets/img/landing-page-background.png" type="image/png">
<link rel="stylesheet" href="/assets/css/search.css">
<link rel="stylesheet" href="/assets/css/boxs.css">
<link rel="stylesheet" href="/assets/css/inputs.css">
</head>

<body>
    <?php include(dirname(__FILE__, 2) . '/assets/view/header.php') ?>
    <section class="main">
        <div class="ariane-link">
            <a href="/" class="link">Accueil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            Déposer une annonce de don
        </div>
        <form action="/donation-deposit/validate-upload.php" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <input type="text" id="name_objet" name="name_objet" class="input-text" required>
                <label class="label-text" for="name_objet">Nom de l'objet: *</label>
            </div>
            <div class="input-group">
                <input type="text" id="desc" name="desc" class="input-text" required>
                <label class="label-text" for="desc">Description: *</label>
            </div>
            <div class="input-group">
                <input type="text" id="color" name="color" class="input-text" required>
                <label class="label-text" for="color">Couleur: *</label>
            </div>

            <h4>Taille de l'objet</h4>
            <select name="size" id="size">
                <option value="Taille unique">Taille unique</option>
                <option value="Enfant">Enfant</option>
                <option value="XS">XS</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
                <option value="3XL">3XL</option>
                <option value="4XL">4XL</option>
            </select>

            <div class="input-group">
                <input type="text" id="quantity" name="quantity" class="input-text" required>
                <label class="label-text" for="quantity">Quantité: *</label>
            </div>

            <h4>Choissiez une catégorie</h4>
            <select name="categorie" id="categorie">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat["id_categorie"]) ?>">
                        <?= htmlspecialchars($cat["titre_categorie"]) ?>
                    </option>
                <?php endforeach; ?>
                <option value="0">Autre</option>
            </select>


            <h4>Ajoutez des photos</h4>
            <input type="file" name="images[]" id="images" accept="image/png, image/jpeg, image/webp" multiple required>

            <h4>Etat de l'objet</h4>
            <div class="radio">
                <input type="radio" name="etat" id="etat-neuf" value="Neuf" checked>
                <label for="etat-neuf">Neuf</label>
            </div>
            <div class="radio">
                <input type="radio" name="etat" id="etat-tres-bon" value="Très bon état">
                <label for="etat-tres-bon">Très bon état</label>
            </div>
            <div class="radio">
                <input type="radio" name="etat" id="etat-bon" value="Bon état">
                <label for="etat-bon">Bon état</label>
            </div>
            <div class="radio">
                <input type="radio" name="etat" id="etat-moyen" value="Satisfaisant">
                <label for="etat-moyen">Satisfaisant</label>
            </div>

            <h4>Localisation</h4>
            <select name="inventaire" id="localisation">
                <?php foreach ($inventaires as $inv): ?>
                    <option value="<?= htmlspecialchars($inv["id_inventaire"]) ?>">
                        <?= htmlspecialchars($inv["nom_inventaire"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button class="button blue">Publier</button>
        </form>

    </section>
    <?php include(dirname(__FILE__, 2) . '/assets/view/footer.php') ?>
</body>

</html>