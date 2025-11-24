<?php
include(dirname(__FILE__, 2) . '/assets/src/files_header.php');
include(dirname(__FILE__, 2) . '/assets/src/conn.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(dirname(__FILE__, 2) . '/assets/src/assets.php') ?>
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
        <form action="/donation-deposit/validate/" method="post">
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
                <option value="0">Taille unique</option>
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
                <?php
                $stmt = $pdo->prepare("SELECT * FROM categorie");
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results as $result): ?>
                    <option value="<?= htmlspecialchars($result["id_categorie"]) ?>"><?= htmlspecialchars($result["titre_categorie"]) ?></option>
                <?php endforeach; ?>
                <option value="0">Autre</option>
            </select>


            <h4>Ajoutez des photos</h4>
            <input type="file" name="images" id="img" accept="image/png, image/jpeg, image/webp" multiple required>

            <h4>Etat de l'objet</h4>
            <div class="radio">
                <input type="radio" name="etat" id="etat-neuf" checked>
                <label for="etat-neuf">Neuf</label>
            </div>
            <div class="radio">
                <input type="radio" name="etat" id="etat-tres-bon">
                <label for="etat-tres-bon">Très bon état</label>
            </div>
            <div class="radio">
                <input type="radio" name="etat" id="etat-bon">
                <label for="etat-bon">Bon état</label>
            </div>
            <div class="radio">
                <input type="radio" name="etat" id="etat-moyen">
                <label for="etat-moyen">Satisfaisant</label>
            </div>

            <h4>Localisation</h4>
            <select name="localisation" id="localisation">
                <?php
                $stmt = $pdo->prepare("SELECT * FROM composante");
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results as $result): ?>
                    <option value="<?= htmlspecialchars($result["id_composante"]) ?>"><?= htmlspecialchars($result["nom_composante"]) ?></option>
                <?php endforeach; ?>
            </select>

            <button class="button blue">Publier</button>
        </form>

    </section>
    <?php include(dirname(__FILE__, 2) . '/assets/view/footer.php') ?>
</body>

</html>