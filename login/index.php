<?php
include(dirname(__FILE__, 2) . '/assets/src/files_header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include dirname(__FILE__, 2) . '/assets/src/conn.php';
    $username = $_POST['identifiant'];
    $password = $_POST['password'];


    $stmt = $pdo->prepare("SELECT id_utilisateur, mdp_univ, prenom_utilisateur, id_role FROM utilisateur WHERE identifiant = ?");
    try {
        $stmt->execute([$username]);
    } catch (PDOException $e) {
        die("<p class=\"error\">Erreur SQL : " . $e->getMessage() . "</p>");
    }
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['mdp_univ'])) {
            $_SESSION['user_id'] = $user['id_utilisateur'];
            $_SESSION["user_name"] = $user["prenom_utilisateur"];
            $_SESSION["id_role"] = $user["id_role"];
            header("Location: /");
            exit();
        } else {
            $error_message = "Mot de passe invalide.";
        }
    } else {
        $error_message = "No user found with that username.";
    }
} ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM - Connexion</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(dirname(__FILE__, 2) . '/assets/src/assets.php') ?>
    <link rel="stylesheet" href="/assets/css/session.css">
    <link rel="stylesheet" href="/assets/css/inputs.css">
</head>

<body>
    <section class="login-container">
        <div class="login-box">
            <img src="/assets/img/lmu-logo.png" alt="Logo de Le Mans Université">
            <?php if (isset($error_message)) {
                echo "<p class=\"error\">" . $error_message . "</p>";
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
                <a href="https://activation.univ-lemans.fr/cgi-bin/activation/mdp-perdu.pl" class="link blue">Mot de passe oublié ?</a>
                <p>Pour des raisons de sécurité, veuillez vous <a href="https://cas.univ-lemans.fr/cas/logout" class="link blue">déconnecter</a> et fermer votre navigateur lorsque vous avez fini d’accéder aux services authentifiés.</p>
            </form>
        </div>
    </section>
    <section class="cas-background"></section>
</body>

</html>