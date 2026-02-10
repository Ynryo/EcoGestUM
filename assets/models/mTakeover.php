<?php
/**
 * Model pour les demandes de reprise
 * Objets réservés en attente d'acceptation (date_fin IS NULL, statut = réservé)
 */

/**
 * Récupère les demandes de reprise pour un département ou service
 */
function getTakeoverRequests($pdo, $user_role, $user_id)
{
    $base_query = "
        SELECT
            r.id_donneur, r.id_recepteur, r.id_objet, r.date_ajout,
            o.nom_objet, o.quantity, o.statut,
            i.id_inventaire, i.nom_inventaire,
            c.id_composante, c.nom_composante,
            u.nom_utilisateur, u.prenom_utilisateur, u.id_role,
            rol.nom_role
        FROM recuperer r
        JOIN objet o ON r.id_objet = o.id_objet
        JOIN inventaire i ON r.id_donneur = i.id_inventaire
        JOIN utilisateur u ON r.id_recepteur = u.id_utilisateur
        JOIN role rol ON u.id_role = rol.id_role
        LEFT JOIN departement d ON i.id_inventaire = d.id_inventaire
        LEFT JOIN service s ON i.id_inventaire = s.id_inventaire
        LEFT JOIN composante c ON d.id_composante = c.id_composante OR s.id_composante = c.id_composante
        WHERE r.date_fin IS NULL AND o.statut = 'réservé'
    ";

    $where_clause = "";
    $params = [];

    switch ($user_role) {
        case 3: // chef de département voit les demandes de son département
            $where_clause = " AND d.id_utilisateur = :user_id";
            $params[':user_id'] = $user_id;
            break;
        case 4: // responsable de service voit les demandes de son service
            $where_clause = " AND s.id_utilisateur = :user_id";
            $params[':user_id'] = $user_id;
            break;
        default:
            // autres rôles ne voient rien
            return [];
    }

    $stmt = $pdo->prepare($base_query . $where_clause . " ORDER BY r.date_ajout DESC");
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Accepte une demande de reprise
 * - Si repreneur role 1-5 (interne): status = indisponible, déplacer dans agencer
 * - Si repreneur role 6-8 (externe): status = recyclé, supprimer de agencer
 */
function acceptTakeoverRequest($pdo, $id_objet, $id_donneur, $id_recepteur)
{
    try {
        $pdo->beginTransaction();

        // Récupérer le rôle du repreneur
        $stmt = $pdo->prepare("SELECT id_role FROM utilisateur WHERE id_utilisateur = :id_recepteur");
        $stmt->bindParam(':id_recepteur', $id_recepteur);
        $stmt->execute();
        $repreneur = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$repreneur) {
            throw new Exception("Repreneur non trouvé");
        }

        $repreneur_role = $repreneur['id_role'];
        $external_roles = [6, 7, 8]; // BDE, Enseignant, Etudiant

        if (in_array($repreneur_role, $external_roles)) {
            // Sortie externe: recyclé, supprimer de agencer
            $stmt = $pdo->prepare("UPDATE objet SET statut = 'recyclé' WHERE id_objet = :id_objet");
            $stmt->bindParam(':id_objet', $id_objet);
            $stmt->execute();

            // Supprimer de l'inventaire source
            $stmt = $pdo->prepare("DELETE FROM agencer WHERE id_objet = :id_objet AND id_inventaire = :id_inventaire");
            $stmt->bindParam(':id_objet', $id_objet);
            $stmt->bindParam(':id_inventaire', $id_donneur);
            $stmt->execute();
        } else {
            // Sortie interne: indisponible, déplacer l'inventaire
            $stmt = $pdo->prepare("UPDATE objet SET statut = 'indisponible' WHERE id_objet = :id_objet");
            $stmt->bindParam(':id_objet', $id_objet);
            $stmt->execute();

            // Récupérer l'inventaire du repreneur (via département ou service)
            $stmt = $pdo->prepare("
                SELECT COALESCE(d.id_inventaire, s.id_inventaire) as id_inventaire
                FROM utilisateur u
                LEFT JOIN departement d ON u.id_utilisateur = d.id_utilisateur
                LEFT JOIN service s ON u.id_utilisateur = s.id_utilisateur
                WHERE u.id_utilisateur = :id_recepteur
            ");
            $stmt->bindParam(':id_recepteur', $id_recepteur);
            $stmt->execute();
            $new_inventory = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($new_inventory && $new_inventory['id_inventaire']) {
                // Mettre à jour agencer vers le nouvel inventaire
                $stmt = $pdo->prepare("UPDATE agencer SET id_inventaire = :new_inv WHERE id_objet = :id_objet AND id_inventaire = :old_inv");
                $stmt->bindParam(':new_inv', $new_inventory['id_inventaire']);
                $stmt->bindParam(':id_objet', $id_objet);
                $stmt->bindParam(':old_inv', $id_donneur);
                $stmt->execute();
            }
        }

        // Marquer la transaction comme terminée (date_fin)
        $stmt = $pdo->prepare("UPDATE recuperer SET date_fin = NOW() WHERE id_objet = :id_objet AND id_donneur = :id_donneur AND id_recepteur = :id_recepteur");
        $stmt->bindParam(':id_objet', $id_objet);
        $stmt->bindParam(':id_donneur', $id_donneur);
        $stmt->bindParam(':id_recepteur', $id_recepteur);
        $stmt->execute();

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

/**
 * Refuse une demande de reprise
 * Remet le statut à disponible et supprime la demande
 */
function refuseTakeoverRequest($pdo, $id_objet, $id_donneur, $id_recepteur)
{
    try {
        $pdo->beginTransaction();

        // Remettre le statut à disponible
        $stmt = $pdo->prepare("UPDATE objet SET statut = 'disponible' WHERE id_objet = :id_objet");
        $stmt->bindParam(':id_objet', $id_objet);
        $stmt->execute();

        // Supprimer la demande de recuperer
        $stmt = $pdo->prepare("DELETE FROM recuperer WHERE id_objet = :id_objet AND id_donneur = :id_donneur AND id_recepteur = :id_recepteur");
        $stmt->bindParam(':id_objet', $id_objet);
        $stmt->bindParam(':id_donneur', $id_donneur);
        $stmt->bindParam(':id_recepteur', $id_recepteur);
        $stmt->execute();

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

/**
 * Traite les actions sur les demandes de reprise
 */
function handleTakeoverAction($pdo)
{
    $success_message = "";
    $error_message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
        $action = $_POST["action"];
        $id_objet = intval($_POST["id_objet"] ?? 0);
        $id_donneur = intval($_POST["id_donneur"] ?? 0);
        $id_recepteur = intval($_POST["id_recepteur"] ?? 0);

        if ($id_objet <= 0 || $id_donneur <= 0 || $id_recepteur <= 0) {
            return ['success' => $success_message, 'error' => "Paramètres invalides"];
        }

        try {
            if ($action === "accept") {
                acceptTakeoverRequest($pdo, $id_objet, $id_donneur, $id_recepteur);
                $success_message = "Demande acceptée avec succès !";
            } elseif ($action === "refuse") {
                refuseTakeoverRequest($pdo, $id_objet, $id_donneur, $id_recepteur);
                $success_message = "Demande refusée.";
            }
        } catch (Exception $e) {
            $error_message = "Erreur : " . $e->getMessage();
        }
    }

    return ['success' => $success_message, 'error' => $error_message];
}
