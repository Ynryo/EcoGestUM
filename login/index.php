<?php
include_once dirname(__FILE__, 2) . '/assets/models/access_controller.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once dirname(__FILE__, 2) . '/assets/models/conn.php';
    include_once dirname(__FILE__, 2) . '/assets/models/mAuth.php';

    $username = strip_tags($_POST['identifiant']);
    $password = strip_tags($_POST['password']);

    $result = authenticateUser($pdo, $username, $password);

    if ($result['success']) {
        $_SESSION['user_id'] = $result['user']['id'];
        $_SESSION["user_name"] = $result['user']['prenom'];
        $_SESSION["id_role"] = $result['user']['id_role'];
        header("Location: /");
        exit();
    } else {
        $error_message = $result['message'];
    }
} ?>

<?php include_once dirname(__FILE__, 2) . '/assets/models/assets.php' ?>
<title>EcoGestUM - Connexion</title>
<link rel="stylesheet" href="/assets/css/session.css">
<link rel="stylesheet" href="/assets/css/inputs.css">
</head>

<body>
    <section class="login-container">
        <div class="login-box">
            <img src="/assets/img/lmu-logo.png" alt="Logo de Le Mans Université">
            <?php if (!empty($error_message)) {
                echo "<p class=\"error\">" . htmlspecialchars($error_message) . "</p>";
            }
            ?>
            <form action="" method="POST">
                <div class="input-group">
                    <input type="text" id="identifiant" name="identifiant" class="input-text" required>
                    <label class="label-text" for="identifiant">Identifiant: *</label>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="input-text" required>
                    <label class="label-text" for="password">Mot de passe: *</label>
                </div>
                <button class="button blue">Connexion</button>
                <a href="/signup/" class="button blue secondary">1ère connexion</a>
                <a href="https://activation.univ-lemans.fr/cgi-bin/activation/mdp-perdu.pl" class="link blue">Mot de
                    passe oublié ?</a>
                <p>Pour des raisons de sécurité, veuillez vous <a href="/logout/" class="link blue">déconnecter</a> et
                    fermer votre navigateur lorsque vous avez fini d'accéder aux services authentifiés.</p>
            </form>
        </div>
    </section>
    <section class="cas-background"></section>
</body>

</html>