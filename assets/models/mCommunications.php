<?php
/**
 * Model pour les communiqués de presse
 */

/**
 * Crée un nouveau communiqué
 * @return array ['success' => bool, 'message' => string]
 */
function createCommunique($pdo, $titre, $contenu, $user_id)
{
    if (empty($titre) || empty($contenu)) {
        return ['success' => false, 'message' => 'Veuillez remplir tous les champs obligatoires.'];
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO communique (titre_communique, contenu, cat_communique, date_publication, id_utilisateur) 
            VALUES (:titre, :contenu, :categorie, NOW(), :id_utilisateur)
        ");
        $stmt->bindParam(":titre", $titre);
        $stmt->bindParam(":contenu", $contenu);
        $categorie = "Général";
        $stmt->bindParam(":categorie", $categorie);
        $stmt->bindParam(":id_utilisateur", $user_id);
        $stmt->execute();

        return ['success' => true, 'message' => 'Communiqué publié avec succès !'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur lors de la publication: ' . $e->getMessage()];
    }
}

/**
 * Récupère tous les communiqués avec leurs auteurs
 */
function getAllCommuniques($pdo)
{
    $stmt = $pdo->prepare("
        SELECT 
            c.titre_communique, c.contenu, c.cat_communique, c.date_publication, 
            u.prenom_utilisateur, u.nom_utilisateur, u.id_role 
        FROM communique c 
        JOIN utilisateur u ON c.id_utilisateur = u.id_utilisateur 
        ORDER BY c.date_publication DESC
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
