<?php
/**
 * Model pour les réservations d'objets
 */

/**
 * Récupère l'id de l'inventaire (donneur) à partir de l'id d'un objet
 */
function getInventoryFromObject($pdo, $id_objet)
{
    $stmt = $pdo->prepare("SELECT id_inventaire FROM agencer WHERE id_objet = :p;");
    $stmt->bindParam(":p", $id_objet);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result["id_inventaire"] : null;
}

/**
 * Vérifie si un objet est déjà réservé par un utilisateur donné
 */
function isObjectReserved($pdo, $id_objet, $donneur)
{
    $stmt = $pdo->prepare("SELECT * FROM recuperer WHERE id_objet = :p AND id_donneur = :donneur AND date_fin IS NULL;");
    $stmt->bindParam(":p", $id_objet);
    $stmt->bindParam(":donneur", $donneur);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
}

/**
 * Crée une nouvelle réservation
 * @return array ['success' => bool, 'message' => string]
 */
function newReservation($pdo, $donneur, $id_objet, $user_id)
{
    // Vérifier si l'objet n'est pas déjà réservé
    if (isObjectReserved($pdo, $id_objet, $donneur)) {
        return ['success' => false, 'message' => 'Objet déjà réservé'];
    }

    try {
        // Ajouter aux réservations de l'utilisateur
        $stmt = $pdo->prepare("INSERT INTO recuperer (id_donneur, id_recepteur, id_objet, date_ajout) VALUES (:id_donneur, :id_recepteur, :p, NOW());");
        $stmt->bindParam(":p", $id_objet);
        $stmt->bindParam(":id_donneur", $donneur);
        $stmt->bindParam(":id_recepteur", $user_id);
        $stmt->execute();

        // Mettre à jour le statut de l'objet
        $stmt = $pdo->prepare("UPDATE objet SET statut = 'réservé' WHERE objet.id_objet = :p;");
        $stmt->bindParam(":p", $id_objet);
        $stmt->execute();

        return ['success' => true, 'message' => 'Objet réservé avec succès'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur lors de la réservation: ' . $e->getMessage()];
    }
}

/**
 * Annule une réservation existante
 * @return array ['success' => bool, 'message' => string]
 */
function cancelReservation($pdo, $donneur, $id_objet, $user_id)
{
    // Vérifier si l'objet est bien réservé
    $stmt = $pdo->prepare("SELECT * FROM recuperer WHERE id_objet = :p AND id_donneur = :donneur;");
    $stmt->bindParam(":p", $id_objet);
    $stmt->bindParam(":donneur", $donneur);
    $stmt->execute();
    $reserved = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reserved) {
        return ['success' => false, 'message' => 'Réservation non trouvée'];
    }

    try {
        // Supprimer la réservation
        $stmt = $pdo->prepare("DELETE FROM recuperer WHERE id_donneur = :donneur AND id_recepteur = :recepteur AND id_objet = :p");
        $stmt->bindParam(":p", $id_objet);
        $stmt->bindParam(":donneur", $donneur);
        $stmt->bindParam(":recepteur", $user_id);
        $stmt->execute();

        // Remettre le statut à disponible
        $stmt = $pdo->prepare("UPDATE objet SET statut = 'disponible' WHERE objet.id_objet = :p;");
        $stmt->bindParam(":p", $id_objet);
        $stmt->execute();

        return ['success' => true, 'message' => 'Réservation annulée avec succès'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur lors de l\'annulation: ' . $e->getMessage()];
    }
}

/**
 * Récupère les réservations en cours d'un utilisateur
 */
function getUserReservations($pdo, $user_id)
{
    $stmt = $pdo->prepare("SELECT * FROM recuperer r JOIN objet o ON r.id_objet = o.id_objet WHERE id_recepteur = :u AND date_fin IS NULL;");
    $stmt->bindParam(':u', $user_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
