<?php
/**
 * Model pour la gestion des notifications/messages
 */

/**
 * Traite une action sur une notification (accepter/refuser)
 * @return array ['success' => bool, 'message' => string]
 */
function handleNotificationAction($pdo, $user_id, $notification_id, $action)
{
    // Vérifier que la notification appartient bien à l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM NOTIFICATION WHERE id_recepteur = :u AND id_notification = :n");
    $stmt->bindParam(':u', $user_id);
    $stmt->bindParam(':n', $notification_id);
    $stmt->execute();
    $notification = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$notification) {
        return ['success' => false, 'message' => 'Notification non trouvée'];
    }

    try {
        switch ($action) {
            case "refuse":
            case "accept":
                // Dans les deux cas, on supprime la notification
                // (l'action "accept" pourrait envoyer un mail dans une version future)
                $stmt = $pdo->prepare("DELETE FROM notification WHERE id_notification = :n");
                $stmt->bindParam(':n', $notification_id);
                $stmt->execute();
                $result = ['success' => true, 'message' => 'Notification traitée'];
                break;
            default:
                $result = ['success' => false, 'message' => 'Action non reconnue'];
                break;
        }
    } catch (PDOException $e) {
        $result = ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
    }

    return $result;
}

/**
 * Récupère toutes les notifications d'un utilisateur
 */
function getUserNotifications($pdo, $user_id)
{
    $stmt = $pdo->prepare("
        SELECT
            id_notification, titre_notification, date_envoi, id_emetteur,
            u1.nom_utilisateur as 'nom_emetteur', u1.prenom_utilisateur as 'prenom_emetteur',
            id_recepteur,
            u2.nom_utilisateur as 'nom_recepteur', u2.prenom_utilisateur as 'prenom_recepteur'
        FROM notification
        JOIN utilisateur u1 ON notification.id_emetteur = u1.id_utilisateur
        JOIN utilisateur u2 ON notification.id_recepteur = u2.id_utilisateur
        WHERE id_recepteur = :u;
    ");
    $stmt->bindParam(':u', $user_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
