<?php
/**
 * Met à jour le statut d'un objet vers disponible (proposer au recyclage)
 */
function proposeToRecycle($pdo, $id_objet)
{
    $stmt = $pdo->prepare("UPDATE objet SET statut = 'disponible' WHERE id_objet = :id_objet");
    $stmt->bindParam(":id_objet", $id_objet);
    return $stmt->execute();
}

/**
 * Met à jour le statut d'un objet vers indisponible (retirer du recyclage)
 */
function removeFromRecycle($pdo, $id_objet)
{
    $stmt = $pdo->prepare("UPDATE objet SET statut = 'indisponible' WHERE id_objet = :id_objet");
    $stmt->bindParam(":id_objet", $id_objet);
    return $stmt->execute();
}

/**
 * Construit la clause WHERE selon le rôle de l'utilisateur
 * @return array ['clause' => string, 'params' => array]
 */
function buildWhereClauseByRole($user_role, $user_id)
{
    $where_clause = "";
    $params = [];

    switch ($user_role) {
        case 1: // Président voit tout
            break;
        case 2: // Chef de composante voit les objets de sa composante
            $where_clause = " WHERE c.id_utilisateur = :user_id";
            $params[':user_id'] = $user_id;
            break;
        case 3: // Chef de département voit les objets de son département
            $where_clause = " WHERE d.id_utilisateur = :user_id";
            $params[':user_id'] = $user_id;
            break;
        case 4: // Responsable de service voit les objets de son service
            $where_clause = " WHERE s.id_utilisateur = :user_id";
            $params[':user_id'] = $user_id;
            break;
        default: // Autres rôles ne voient rien (cheh)
            $where_clause = " WHERE 1=0";
            break;
    }

    return ['clause' => $where_clause, 'params' => $params];
}

/**
 * Compte le nombre total d'objets visibles pour l'utilisateur
 */
function countInventoryItems($pdo, $user_role, $user_id)
{
    $count_query = "
        SELECT COUNT(DISTINCT o.id_objet) as total
        FROM objet o
        JOIN agencer a ON o.id_objet = a.id_objet
        JOIN inventaire i ON a.id_inventaire = i.id_inventaire
        LEFT JOIN departement d ON i.id_inventaire = d.id_inventaire
        LEFT JOIN service s ON i.id_inventaire = s.id_inventaire
        LEFT JOIN composante c ON d.id_composante = c.id_composante OR s.id_composante = c.id_composante
    ";

    $where_data = buildWhereClauseByRole($user_role, $user_id);
    $stmt = $pdo->prepare($count_query . $where_data['clause']);

    foreach ($where_data['params'] as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

/**
 * Récupère les objets de l'inventaire avec pagination
 */
function getInventoryItems($pdo, $user_role, $user_id, $limit, $offset)
{
    $base_query = "
        SELECT DISTINCT 
            o.id_objet, o.nom_objet, o.desc_objet, o.quantity, o.etat, o.statut,
            c.id_composante, cat.titre_categorie
        FROM objet o
        JOIN agencer a ON o.id_objet = a.id_objet
        JOIN inventaire i ON a.id_inventaire = i.id_inventaire
        LEFT JOIN departement d ON i.id_inventaire = d.id_inventaire
        LEFT JOIN service s ON i.id_inventaire = s.id_inventaire
        LEFT JOIN composante c ON d.id_composante = c.id_composante OR s.id_composante = c.id_composante
        LEFT JOIN categorie cat ON o.id_categorie = cat.id_categorie
    ";

    $where_data = buildWhereClauseByRole($user_role, $user_id);
    $final_query = $base_query . $where_data['clause'] . " ORDER BY o.id_objet LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($final_query);

    foreach ($where_data['params'] as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère l'historique des mouvements d'un objet
 */
function getObjectHistory($pdo, $id_objet)
{
    $stmt = $pdo->prepare("
        SELECT r.date_ajout, r.date_fin, i.nom_inventaire, c.nom_composante, c.id_composante
        FROM recuperer r
        JOIN inventaire i ON r.id_donneur = i.id_inventaire
        LEFT JOIN departement d ON i.id_inventaire = d.id_inventaire
        LEFT JOIN service s ON i.id_inventaire = s.id_inventaire
        LEFT JOIN composante c ON d.id_composante = c.id_composante OR s.id_composante = c.id_composante
        WHERE r.id_objet = :id_objet
        ORDER BY r.date_ajout DESC
    ");
    $stmt->bindParam(':id_objet', $id_objet);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Traite les actions POST (recycle/unrecycle)
 * @return array ['success' => string, 'error' => string]
 */
function handleInventoryAction($pdo)
{
    $success_message = "";
    $error_message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST["action"];
        $id_objet = intval($_POST["id_objet"] ?? 0);

        if ($id_objet <= 0) {
            return ['success' => $success_message, 'error' => $error_message];
        }

        try {
            if ($action === "recycle") {
                proposeToRecycle($pdo, $id_objet);
                $success_message = "L'objet a été proposé au recyclage avec succès !";
            } elseif ($action === "unrecycle") {
                removeFromRecycle($pdo, $id_objet);
                $success_message = "L'objet a été retiré du recyclage avec succès !";
            }
        } catch (PDOException $e) {
            $error_message = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
    return ['success' => $success_message, 'error' => $error_message];
}
