<?php
function buildHistoryWhereClause($user_role, $user_id)
{
    $where_clause = "";
    $params = [];

    switch ($user_role) {
        case 1: // président voit tout
            break;
        case 2: // chef de composante voit les transactions de sa composante
            $where_clause = " WHERE c.id_utilisateur = :user_id";
            $params[':user_id'] = $user_id;
            break;
        case 3: // chef de département vois les transactions de son département
            $where_clause = " WHERE d.id_utilisateur = :user_id";
            $params[':user_id'] = $user_id;
            break;
        case 4: // responsable de service voit les transactions de son service
            $where_clause = " WHERE s.id_utilisateur = :user_id";
            $params[':user_id'] = $user_id;
            break;
        default: // autres rôles ne voient rien (cheeeeeeh)
            $where_clause = " WHERE 1=0";
            break;
    }

    return ['clause' => $where_clause, 'params' => $params];
}

function countHistoryItems($pdo, $user_role, $user_id)
{
    $count_query = "
        SELECT COUNT(*) as total
        FROM recuperer r
        JOIN objet o ON r.id_objet = o.id_objet
        JOIN inventaire i ON r.id_donneur = i.id_inventaire
        JOIN utilisateur u ON r.id_recepteur = u.id_utilisateur
        LEFT JOIN departement d ON i.id_inventaire = d.id_inventaire
        LEFT JOIN service s ON i.id_inventaire = s.id_inventaire
        LEFT JOIN composante c ON d.id_composante = c.id_composante OR s.id_composante = c.id_composante
    ";

    $where_data = buildHistoryWhereClause($user_role, $user_id);
    $stmt = $pdo->prepare($count_query . $where_data['clause']);

    foreach ($where_data['params'] as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

function getHistoryItems($pdo, $user_role, $user_id, $limit, $offset)
{
    $base_query = "
        SELECT 
            o.id_objet, o.nom_objet, o.quantity,
            r.date_ajout,
            c.id_composante, c.nom_composante,
            u.id_utilisateur, u.nom_utilisateur, u.prenom_utilisateur,
            u.id_role,
            rol.nom_role
        FROM recuperer r
        JOIN objet o ON r.id_objet = o.id_objet
        JOIN inventaire i ON r.id_donneur = i.id_inventaire
        JOIN utilisateur u ON r.id_recepteur = u.id_utilisateur
        JOIN role rol ON u.id_role = rol.id_role
        LEFT JOIN departement d ON i.id_inventaire = d.id_inventaire
        LEFT JOIN service s ON i.id_inventaire = s.id_inventaire
        LEFT JOIN composante c ON d.id_composante = c.id_composante OR s.id_composante = c.id_composante
    ";

    $where_data = buildHistoryWhereClause($user_role, $user_id);
    $final_query = $base_query . $where_data['clause'] . " ORDER BY r.date_ajout DESC LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($final_query);

    foreach ($where_data['params'] as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getSortieType($id_role)
{
    $external_roles = [6, 7, 8];
    return in_array($id_role, $external_roles) ? 'externe' : 'interne';
}
