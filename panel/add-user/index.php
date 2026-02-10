<?php
include_once dirname(__FILE__, 3) . "/assets/models/access_controller.php";
include_once dirname(__FILE__, 3) . "/assets/models/assets.php";
include_once dirname(__FILE__, 3) . "/assets/models/conn.php";
include_once dirname(__FILE__, 3) . "/assets/models/mAuth.php";

// Récupération des rôles depuis la BDD
$roles = getAllRoles($pdo);

// Traitement du formulaire
$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        'identifiant' => trim($_POST["identifiant"] ?? ""),
        'nom' => trim($_POST["nom"] ?? ""),
        'prenom' => trim($_POST["prenom"] ?? ""),
        'email' => trim($_POST["email"] ?? ""),
        'password' => $_POST["password"] ?? "",
        'confirm_password' => $_POST["confirm_password"] ?? "",
        'id_role' => intval($_POST["id_role"] ?? 0)
    ];

    $result = createUser($pdo, $data);

    if ($result['success']) {
        $success_message = "<p class=\"success\">" . htmlspecialchars($result['message']) . "</p>";
    } else {
        $error_message = "<p class=\"error\">" . htmlspecialchars($result['message']) . "</p>";
    }
}
?>
<title>EcoGestUM - Ajouter un utilisateur</title>
<link rel="stylesheet" href="/assets/css/boxs.css">
<link rel="stylesheet" href="/assets/css/navbar.css">
<link rel="stylesheet" href="/assets/css/inputs.css">
<link rel="stylesheet" href="/assets/css/buttons.css">
</head>

<body>
    <?php include_once dirname(__FILE__, 3) . "/assets/view/header.php" ?>
    <section class="main panel">
        <?php
        include_once dirname(__FILE__, 3) . "/assets/models/navbar.php";
        include_once dirname(__FILE__, 3) . "/assets/view/panel/navbar.php";
        ?>
        <div class="container">
            <h2>Ajouter un utilisateur</h2>

            <?php if ($success_message): ?>
                <?= $success_message ?>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <?= $error_message ?>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="input-group">
                    <input type="text" name="identifiant" id="identifiant" class="input-text" required placeholder=" ">
                    <label for="identifiant" class="label-text">Identifiant*</label>
                </div>

                <div class="input-group">
                    <input type="text" name="nom" id="nom" class="input-text" required placeholder=" ">
                    <label for="nom" class="label-text">Nom*</label>
                </div>

                <div class="input-group">
                    <input type="text" name="prenom" id="prenom" class="input-text" required placeholder=" ">
                    <label for="prenom" class="label-text">Prénom*</label>
                </div>

                <div class="input-group">
                    <input type="email" name="email" id="email" class="input-text" required placeholder=" ">
                    <label for="email" class="label-text">Email universitaire*</label>
                </div>

                <div class="input-group">
                    <input type="password" name="password" id="password" class="input-text" required placeholder=" ">
                    <label for="password" class="label-text">Mot de passe*</label>
                </div>

                <div class="input-group">
                    <input type="password" name="confirm_password" id="confirm_password" class="input-text" required
                        placeholder=" ">
                    <label for="confirm_password" class="label-text">Confirmer le mot de passe*</label>
                </div>

                <div class="input-group">
                    <select name="id_role" id="id_role" class="input-text" required>
                        <option value="">-- Sélectionner un rôle --</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role['id_role'] ?>"><?= htmlspecialchars($role['nom_role']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="id_role" class="label-text">Rôle*</label>
                </div>

                <button type="submit" class="button blue">Créer l'utilisateur</button>
            </form>
        </div>
    </section>

    <?php include_once dirname(__FILE__, 3) . "/assets/view/footer.php" ?>
</body>

</html>