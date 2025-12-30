<?php
include_once(dirname(__FILE__, 3) . "/assets/models/access_controller.php");
include_once(dirname(__FILE__, 3) . "/assets/models/assets.php");
include_once(dirname(__FILE__, 3) . "/assets/models/conn.php");

// Traitement du formulaire
$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = trim($_POST["titre"] ?? "");
    $contenu = trim($_POST["contenu"] ?? "");

    if (empty($titre) || empty($contenu)) {
        $error_message = "<p class=\"error\">Veuillez remplir tous les champs obligatoires.</p>";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO communique (titre_communique, contenu, cat_communique, date_publication, id_utilisateur) VALUES (:titre, :contenu, :categorie, NOW(), :id_utilisateur)");
            $stmt->bindParam(":titre", $titre);
            $stmt->bindParam(":contenu", $contenu);
            $categorie = "Général";
            $stmt->bindParam(":categorie", $categorie);
            $stmt->bindParam(":id_utilisateur", $_SESSION["user_id"]);
            $stmt->execute();
            $success_message = "<p class=\"success\">Communiqué publié avec succès !</p>";
        } catch (PDOException $e) {
            $error_message = "<p class=\"error\">Erreur lors de la publication : " . $e->getMessage() . "</p>";
        }
    }
}
?>
<title>EcoGestUM - Communiqué</title>
<link rel="stylesheet" href="/assets/css/search.css">
<link rel="stylesheet" href="/assets/css/boxs.css">
<link rel="stylesheet" href="/assets/css/navbar.css">
<link rel="stylesheet" href="/assets/css/inputs.css">
<link rel="stylesheet" href="/assets/css/buttons.css">
</head>

<body>
    <?php include(dirname(__FILE__, 3) . "/assets/view/header.php") ?>
    <section class="main panel">
        <?php
        include(dirname(__FILE__, 3) . "/assets/models/navbar.php");
        include(dirname(__FILE__, 3) . "/assets/view/panel/navbar.php");
        ?>
        <div class="container">
            <h2>Publier un communiqué</h2>

            <?php if ($success_message): ?>
                <?= $success_message ?>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <?= $error_message ?>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="input-group">
                    <input type="text" name="titre" id="titre" class="input-text" required placeholder=" ">
                    <label for="titre" class="label-text">Titre*</label>
                </div>

                <div class="input-group">
                    <textarea name="contenu" id="contenu" class="input-text" rows="10" required placeholder=" "
                        style="resize: vertical; min-height: 200px;"></textarea>
                    <label for="contenu" class="label-text">Contenu*</label>
                </div>

                <button type="submit" class="button blue">Envoyer</button>
            </form>
        </div>
    </section>

    <?php include(dirname(__FILE__, 3) . "/assets/view/footer.php") ?>
</body>

</html>