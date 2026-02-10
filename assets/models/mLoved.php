<?php
/**
 * Model pour les favoris / coups de coeur
 */

/**
 * Récupère les objets favoris d'un utilisateur
 */
function getUserLovedObjects($pdo, $user_id)
{
    $stmt = $pdo->prepare("
        SELECT * FROM aimer a
        JOIN utilisateur u ON a.id_utilisateur = u.id_utilisateur
        JOIN objet o ON o.id_objet = a.id_objet
        WHERE u.id_utilisateur = :u;
    ");
    $stmt->bindParam(':u', $user_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
