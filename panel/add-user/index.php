<?php
include_once(dirname(__FILE__, 3) . "/assets/models/access_controller.php");
include_once(dirname(__FILE__, 3) . "/assets/models/assets.php");
include_once(dirname(__FILE__, 3) . "/assets/models/conn.php");

// Récupération des rôles depuis la BDD
$stmt_roles = $pdo->prepare("SELECT id_role, nom_role FROM role ORDER BY id_role");
$stmt_roles->execute();
$roles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire
$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifiant = trim($_POST["identifiant"] ?? "");
    $nom = trim($_POST["nom"] ?? "");
    $prenom = trim($_POST["prenom"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";
    $id_role = intval($_POST["id_role"] ?? 0);

    // Validation des champs
    if (empty($identifiant) || empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($id_role)) {
        $error_message = "<p class=\"error\">Veuillez remplir tous les champs obligatoires.</p>";
    } elseif ($password !== $confirm_password) {
        $error_message = "<p class=\"error\">Les mots de passe ne correspondent pas.</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "<p class=\"error\">L'adresse email n'est pas valide.</p>";
    } else {
        try {
            // Vérifier si l'utilisateur existe déjà (identifiant ou email)
            $stmt_check = $pdo->prepare("SELECT id_utilisateur FROM utilisateur WHERE identifiant = :identifiant OR mail_univ = :email");
            $stmt_check->bindParam(":identifiant", $identifiant);
            $stmt_check->bindParam(":email", $email);
            $stmt_check->execute();

            if ($stmt_check->fetch()) {
                $error_message = "<p class=\"error\">Un utilisateur avec cet identifiant ou cette adresse email existe déjà.</p>";
            } else {
                // Hasher le mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insertion de l'utilisateur
                $stmt = $pdo->prepare("INSERT INTO utilisateur (identifiant, nom_utilisateur, prenom_utilisateur, mail_univ, mdp_univ, id_role) VALUES (:identifiant, :nom, :prenom, :email, :password, :id_role)");
                $stmt->bindParam(":identifiant", $identifiant);
                $stmt->bindParam(":nom", $nom);
                $stmt->bindParam(":prenom", $prenom);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":password", $hashed_password);
                $stmt->bindParam(":id_role", $id_role);
                $stmt->execute();

                $success_message = "<p class=\"success\">Utilisateur créé avec succès !</p>";
            }
        } catch (PDOException $e) {
            $error_message = "<p class=\"error\">Erreur lors de la création : " . $e->getMessage() . "</p>";
        }
    }
}
?>
<title>EcoGestUM - Ajouter un utilisateur</title>
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

    <?php include(dirname(__FILE__, 3) . "/assets/view/footer.php") ?>
</body>

</html>