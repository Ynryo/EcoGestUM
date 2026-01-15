<?php
include_once(dirname(__FILE__, 3) . "/assets/models/access_controller.php");
include_once(dirname(__FILE__, 3) . "/assets/models/assets.php");
include_once(dirname(__FILE__, 3) . "/assets/models/conn.php");
include_once(dirname(__FILE__, 3) . "/assets/models/mCommunications.php");

// Traitement du formulaire
$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = trim($_POST["titre"] ?? "");
    $contenu = trim($_POST["contenu"] ?? "");

    $result = createCommunique($pdo, $titre, $contenu, $_SESSION["user_id"]);

    if ($result['success']) {
        $success_message = "<p class=\"success\">" . htmlspecialchars($result['message']) . "</p>";
    } else {
        $error_message = "<p class=\"error\">" . htmlspecialchars($result['message']) . "</p>";
    }
}
?>
<title>EcoGestUM - Communiqué</title>
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