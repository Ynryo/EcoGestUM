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
    try {
        $stmt = $pdo->prepare("SELECT id_utilisateur, mdp_univ, prenom_utilisateur, id_role FROM utilisateur WHERE identifiant = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Aucun utilisateur trouvé avec cet identifiant.',
                'user' => null
            ];
        }

        if (!password_verify($password, $user['mdp_univ'])) {
            return [
                'success' => false,
                'message' => 'Mot de passe invalide.',
                'user' => null
            ];
        }

        return [
            'success' => true,
            'message' => 'Connexion réussie',
            'user' => [
                'id' => $user['id_utilisateur'],
                'prenom' => $user['prenom_utilisateur'],
                'id_role' => $user['id_role']
            ]
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Erreur SQL: ' . $e->getMessage(),
            'user' => null
        ];
    }
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
    // Validation des champs obligatoires
    if (
        empty($data['identifiant']) || empty($data['nom']) || empty($data['prenom']) ||
        empty($data['email']) || empty($data['password']) || empty($data['id_role'])
    ) {
        return ['success' => false, 'message' => 'Veuillez remplir tous les champs obligatoires.'];
    }

    // Validation de l'email
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => "L'adresse email n'est pas valide."];
    }

    // Vérification des mots de passe
    if (isset($data['confirm_password']) && $data['password'] !== $data['confirm_password']) {
        return ['success' => false, 'message' => 'Les mots de passe ne correspondent pas.'];
    }

    // Vérifier si l'utilisateur existe déjà
    if (checkUserExists($pdo, $data['identifiant'], $data['email'])) {
        return ['success' => false, 'message' => 'Un utilisateur avec cet identifiant ou cette adresse email existe déjà.'];
    }

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

        return ['success' => true, 'message' => 'Utilisateur créé avec succès !'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur lors de la création: ' . $e->getMessage()];
    }
}
