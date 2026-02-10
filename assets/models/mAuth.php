<?php
/**
 * Model pour l'authentification et la gestion des utilisateurs
 */

/**
 * Authentifie un utilisateur
 * @return array ['success' => bool, 'message' => string, 'user' => array|null]
 */
function authenticateUser($pdo, $username, $password)
{
    $result = ['success' => false, 'message' => '', 'user' => null];

    try {
        $stmt = $pdo->prepare("SELECT id_utilisateur, mdp_univ, prenom_utilisateur, id_role FROM utilisateur WHERE identifiant = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $result['message'] = 'Aucun utilisateur trouvé avec cet identifiant.';
        } elseif (!password_verify($password, $user['mdp_univ'])) {
            $result['message'] = 'Mot de passe invalide.';
        } else {
            $result['success'] = true;
            $result['message'] = 'Connexion réussie';
            $result['user'] = [
                'id' => $user['id_utilisateur'],
                'prenom' => $user['prenom_utilisateur'],
                'id_role' => $user['id_role']
            ];
        }
    } catch (PDOException $e) {
        $result['message'] = 'Erreur SQL: ' . $e->getMessage();
    }

    return $result;
}

/**
 * Récupère tous les rôles disponibles
 */
function getAllRoles($pdo)
{
    $stmt = $pdo->prepare("SELECT id_role, nom_role FROM role ORDER BY id_role");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Vérifie si un utilisateur existe déjà (par identifiant ou email)
 */
function checkUserExists($pdo, $identifiant, $email)
{
    $stmt = $pdo->prepare("SELECT id_utilisateur FROM utilisateur WHERE identifiant = :identifiant OR mail_univ = :email");
    $stmt->bindParam(":identifiant", $identifiant);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    return $stmt->fetch() !== false;
}

/**
 * Crée un nouvel utilisateur
 * @return array ['success' => bool, 'message' => string]
 */
function createUser($pdo, $data)
{
    $result = ['success' => false, 'message' => ''];

    if (
        empty($data['identifiant']) || empty($data['nom']) || empty($data['prenom']) ||
        empty($data['email']) || empty($data['password']) || empty($data['id_role'])
    ) {
        $result['message'] = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $result['message'] = "L'adresse email n'est pas valide.";
    } elseif (isset($data['confirm_password']) && $data['password'] !== $data['confirm_password']) {
        $result['message'] = 'Les mots de passe ne correspondent pas.';
    } elseif (checkUserExists($pdo, $data['identifiant'], $data['email'])) {
        $result['message'] = 'Un utilisateur avec cet identifiant ou cette adresse email existe déjà.';
    } else {
        try {
            $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
                INSERT INTO utilisateur (identifiant, nom_utilisateur, prenom_utilisateur, mail_univ, mdp_univ, id_role)
                VALUES (:identifiant, :nom, :prenom, :email, :password, :id_role)
            ");
            $stmt->bindParam(":identifiant", $data['identifiant']);
            $stmt->bindParam(":nom", $data['nom']);
            $stmt->bindParam(":prenom", $data['prenom']);
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":password", $hashed_password);
            $stmt->bindParam(":id_role", $data['id_role']);
            $stmt->execute();

            $result['success'] = true;
            $result['message'] = 'Utilisateur créé avec succès !';
        } catch (PDOException $e) {
            $result['message'] = 'Erreur lors de la création: ' . $e->getMessage();
        }
    }

    return $result;
}
