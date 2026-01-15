<?php
/**
 * Model pour la recherche d'objets
 */

/**
 * Recherche des objets par nom ou description
 */
function searchObjects($pdo, $query)
{
    $stmt = $pdo->prepare("
        SELECT 
            o.id_objet, o.nom_objet, o.desc_objet, c.titre_categorie, o.statut 
        FROM objet AS o 
        JOIN categorie AS c ON o.id_categorie = c.id_categorie 
        WHERE nom_objet LIKE CONCAT('%', :q, '%') OR desc_objet LIKE CONCAT('%', :q, '%')
    ");
    $stmt->bindParam(':q', $query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
