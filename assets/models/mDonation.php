<?php
/**
 * Model pour le dépôt de dons/objets
 */

/**
 * Récupère toutes les catégories
 */
function getAllCategories($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM categorie");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère tous les inventaires (localisations)
 */
function getAllInventories($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM inventaire");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère le prochain ID d'objet disponible
 */
function getNextObjectId($pdo)
{
    $stmt = $pdo->prepare("SELECT id_objet FROM objet ORDER BY id_objet DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result["id_objet"] + 1 : 1;
}

/**
 * Gère l'upload d'un fichier image
 * @return array ['success' => bool, 'message' => string, 'path' => string|null]
 */
function handleSingleUpload($file_info, $max_size, $target_dir, $id, $i)
{
    // Vérifier la taille
    if ($file_info["size"] > $max_size) {
        $max_size_mb = number_format($max_size / (1024 * 1024), 1);
        return [
            'success' => false,
            'message' => "Le fichier '{$file_info["name"]}' dépasse la taille maximale autorisée de {$max_size_mb} MB."
        ];
    }

    $tmp_file = $file_info["tmp_name"];
    $original_file_name = basename($file_info["name"]);
    $allowed_extensions = ["png", "jpeg", "jpg", "webp"];

    $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, $allowed_extensions)) {
        return [
            'success' => false,
            'message' => "Le fichier '{$file_info["name"]}' n'est pas une image valide."
        ];
    }

    // Vérifier que c'est une vraie image
    $check = getimagesize($tmp_file);
    if ($check === false) {
        return [
            'success' => false,
            'message' => "Le fichier '{$file_info["name"]}' n'est pas une image valide."
        ];
    }

    $new_file_name = $id . "_" . ($i + 1) . "." . $imageFileType;
    $target_file = $target_dir . $new_file_name;

    if (move_uploaded_file($tmp_file, $target_file)) {
        return [
            'success' => true,
            'message' => 'Fichier uploadé avec succès',
            'path' => $target_file
        ];
    } else {
        return [
            'success' => false,
            'message' => "Impossible de déplacer le fichier '{$file_info["name"]}'."
        ];
    }
}

/**
 * Crée un nouvel objet dans la base de données
 * @return array ['success' => bool, 'message' => string, 'id' => int|null]
 */
function createObject($pdo, $data)
{
    try {
        $stmt = $pdo->prepare("
            INSERT INTO `objet` (`nom_objet`, `desc_objet`, `etat`, `color`, `size`, `quantity`, `date_ajout`, `statut`, `id_categorie`) 
            VALUES (:nom_objet, :desc_objet, :etat, :color, :size, :quantity, :date_ajout, :statut, :categorie)
        ");
        $stmt->bindValue(":nom_objet", $data['name']);
        $stmt->bindValue(":desc_objet", $data['desc']);
        $stmt->bindValue(":etat", $data['etat']);
        $stmt->bindValue(":color", $data['color']);
        $stmt->bindValue(":size", $data['size']);
        $stmt->bindValue(":quantity", $data['quantity']);
        $stmt->bindValue(":date_ajout", date('Y-m-d'));
        $stmt->bindValue(":statut", "disponible");
        $stmt->bindValue(":categorie", $data['categorie']);
        $stmt->execute();

        return [
            'success' => true,
            'message' => 'Objet créé avec succès',
            'id' => $pdo->lastInsertId()
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Erreur SQL: ' . $e->getMessage()
        ];
    }
}

/**
 * Assigne un objet à un inventaire
 */
function assignObjectToInventory($pdo, $id_objet, $id_inventaire)
{
    try {
        $stmt = $pdo->prepare("INSERT INTO `agencer` (`id_objet`, `id_inventaire`) VALUES (:id, :inventaire)");
        $stmt->bindValue(":id", $id_objet);
        $stmt->bindValue(":inventaire", $id_inventaire);
        $stmt->execute();
        return ['success' => true, 'message' => 'Objet assigné à l\'inventaire'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
    }
}
