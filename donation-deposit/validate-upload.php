<?php
$max_files = 4;
$max_size = 5 * 1024 * 1024;
$target_dir = $_SERVER["DOCUMENT_ROOT"] . "/assets/img/products/"; // Le répertoire où stocker les fichiers

function handle_single_upload($file_info, $max_size, $target_dir, $id, $i)
{
    if ($file_info["size"] > $max_size) { //check max size
        $max_size_mb = number_format($max_size / (1024 * 1024), 1);
        echo "<p class=\"error\">Erreur : Le fichier '{$file_info["name"]}' dépasse la taille maximale autorisée de {$max_size_mb} MB.</p>";
        exit();
    }

    $tmp_file = $file_info["tmp_name"]; // temp path du fichier
    $original_file_name = basename($file_info["name"]); // origin name (utilisé juste pour get extension)
    $allowed_extensions = ["png", "jpeg", "jpg", "webp"];

    $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo "<p class=\"error\">Erreur : Le fichier '{$file_info["name"]}' n'est pas une image valide.</p>";
        exit();
    }

    $check = getimagesize($tmp_file); //getimagesize marche po si c'est pas une vraie img
    if ($check === false) {
        echo "<p class=\"error\">Erreur : Le fichier '{$file_info["name"]}' n'est pas une image valide.</p>";
        exit();
    }

    $new_file_name = $id . "_" . $i + 1 . "." . $imageFileType; //MODIF POUR GET ID OBJET +1
    $target_file = $target_dir . $new_file_name;

    if (move_uploaded_file($tmp_file, $target_file)) {
        echo "<p class=\"error\">Succès</p>";
        echo $target_file;
    } else {
        echo "<p class=\"error\">Erreur : Impossible de déplacer le fichier '{$file_info["name"]}'.</p>";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name_objet = strip_tags($_POST["name_objet"]);
    $desc = strip_tags($_POST["desc"]);
    $color = strip_tags($_POST["color"]);
    $size = strip_tags($_POST["size"]);
    $quantity = strip_tags($_POST["quantity"]);
    $categorie = strip_tags($_POST["categorie"]);
    $etat = strip_tags($_POST["etat"]);
    $inventaire = strip_tags($_POST["inventaire"]); //join table agencer

    //check if files uploaded
    if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
        echo "<h2>Aucun fichier soumis.</h2>";
        exit;
    }

    $files = $_FILES['images'];

    if (count($files['name']) > $max_files) { //check if too many files (max4)
        echo "<h2>Erreur : maximum d'images autorisé : {$max_files}.</h2>";
        exit;
    }

    if (!is_dir($target_dir)) { //check if dest folder exists
        mkdir($target_dir, 0755, true);
    }

    include(dirname(__FILE__, 2) . '/assets/models/conn.php');
    $stmt = $pdo->prepare("SELECT id_objet FROM objet ORDER BY id_objet DESC LIMIT 1");
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        die("<p class=\"error\">Erreur SQL : " . $e->getMessage() . "</p>");
    }
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $last_id = $result["id_objet"] + 1;

    for ($i = 0; $i < count($files['name']); $i++) {
        $file_info = [
            'name' => $files['name'][$i],
            'type' => $files['type'][$i],
            'tmp_name' => $files['tmp_name'][$i],
            'error' => $files['error'][$i],
            'size' => $files['size'][$i],
        ];
        handle_single_upload($file_info, $max_size, $target_dir, $last_id, $i);
    }

    $stmt = $pdo->prepare("INSERT INTO `objet` (`nom_objet`, `desc_objet`, `etat`, `color`, `size`, `quantity`, `date_ajout`, `statut`, `id_categorie`) VALUES (:nom_objet, :desc_objet, :etat, :color, :size, :quantity, :date_ajout, :statut, :categorie)");
    $stmt->bindValue(":nom_objet", $name_objet);
    $stmt->bindValue(":desc_objet", $desc);
    $stmt->bindValue(":etat", $etat);
    $stmt->bindValue(":color", $color);
    $stmt->bindValue(":size", $size);
    $stmt->bindValue(":quantity", $quantity);
    $stmt->bindValue(":date_ajout", date('Y-m-d'));
    $stmt->bindValue(":statut", "En attente");
    $stmt->bindValue(":categorie", $categorie);
    $stmt->execute();

    $stmt = $pdo->prepare("INSERT INTO `agencer` (`id_objet`, `id_inventaire`) VALUES (:id, :inventaire)");
    $stmt->bindValue(":id", $last_id);
    $stmt->bindValue(":inventaire", $inventaire);
    $stmt->execute();

    header("Location: /");
}
