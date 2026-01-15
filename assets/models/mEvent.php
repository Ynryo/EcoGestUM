<?php
/**
 * Model pour les événements
 */

/**
 * Récupère tous les événements triés par date de début décroissante
 */
function getAllEvents($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM evenement ORDER BY date_debut DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
