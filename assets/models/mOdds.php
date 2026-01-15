<?php
/**
 * Model pour les Objectifs de Développement Durable (ODD)
 */

/**
 * Récupère tous les ODD
 */
function getAllOdds($pdo)
{
    $stmt = $pdo->prepare("SELECT id_odd, num_odd, titre_odd, desc_odd, link_odd FROM odd ORDER BY id_odd");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Extrait le numéro d'un ODD depuis son identifiant (ex: "ODD 4" -> 4)
 */
function extractOddNumber($num_odd)
{
    preg_match('/\d+/', $num_odd, $matches);
    return intval($matches[0] ?? 0);
}

/**
 * Génère l'URL de l'image SVG d'un ODD
 */
function getOddImageUrl($odd_number)
{
    return "https://www.agenda-2030.fr/IMG/svg/odd" . $odd_number . ".svg";
}
