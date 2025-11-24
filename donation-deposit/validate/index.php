<?php
$max_files = 4; 
$max_size = 5 * 1024 * 1024; 
$target_dir = "/uploads/assets/img/products"; // Le répertoire où stocker les fichiers
$allowed_extensions = ["png", "jpeg", "jpg", "webp"];

function handle_single_upload($file_info, $max_size, $allowed_extensions, $target_dir) {
    if ($file_info["size"] > $max_size) { //check max size
        $max_size_mb = number_format($max_size / (1024 * 1024), 1);
        echo "<p class=\"error\">Erreur : Le fichier '{$file_info["name"]}' dépasse la taille maximale autorisée de {$max_size_mb} MB.</p>";
    }
    
    $tmp_file = $file_info["tmp_name"]; // temp path du fichier
    $original_file_name = basename($file_info["name"]); // origin name (utilisé juste pour get extension)
    
    $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo "<p class=\"error\">Erreur : Le fichier '{$file_info["name"]}' n'est pas une image valide.</p>";
    }
    
    $check = getimagesize($tmp_file); //getimagesize marche po si c'est pas une vraie img
    if ($check === false) {
        echo "<p class=\"error\">Erreur : Le fichier '{$file_info["name"]}' n'est pas une image valide.</p>";
    }
    
    $new_file_name = uniqid('img_', true) . "." . $imageFileType; //MODIF POUR GET ID OBJET +1
    $target_file = $target_dir . $new_file_name;

    if (move_uploaded_file($tmp_file, $target_file)) {
        echo "<p class=\"error\">Succès</p>";
    } else {
        echo "<p class=\"error\">Erreur : Impossible de déplacer le fichier '{$file_info["name"]}'.</p>";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = strip_tags($_POST["identifiant"]);
    $desc = strip_tags($_POST["desc"]);
    $color = strip_tags($_POST["color"]);
    $size = strip_tags($_POST["size"]);
    $size = strip_tags($_POST["quantity"]);
    $categorie = strip_tags($_POST["categorie"]);
    $file = strip_tags($_POST["images"]); //verifs image + rename
    $etat = strip_tags($_POST["etat"]);
    $localisation = strip_tags($_POST["localisation"]); //join table agencer

    //check if files uploaded
    if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
        echo "<h2>Aucun fichier soumis.</h2>";
        exit;
    }

    $files = $_FILES['images'];

    if ($file_count > $max_files) { //check if too many files (max4)
        echo "<h2>Erreur : maximum d'images autorisé : {$max_files}.</h2>";
        exit;
    }

    if (!is_dir($target_dir)) { //check if dest folder exists
        mkdir($target_dir, 0755, true);
    }

    for ($i = 0; $i < count($files['name']); $i++) {
        $file_info = [
            'name' => $files['name'][$i],
            'type' => $files['type'][$i],
            'tmp_name' => $files['tmp_name'][$i],
            'error' => $files['error'][$i],
            'size' => $files['size'][$i],
        ];

        handle_single_upload($file_info, $max_size, $allowed_extensions, $target_dir);
    }

    include(dirname(__FILE__, 3) . '/assets/src/conn.php');
    $stmt = $pdo->prepare("INSERT INTO `objet` (`nom_objet`, `desc_objet`, `etat`, `color`, `size`, `quantity`, `date_ajout`, `statut`, `id_categorie`) VALUES (:nom_objet, :desc_objet, :etat, :color, :size, :quantity, :date_ajout, :statut, :categorie)");
    $stmt->bindValue(":nom_objet", $username);
    $stmt->bindValue(":desc_objet", $desc);
    $stmt->bindValue(":etat", $etat);
    $stmt->bindValue(":color", $color);
    $stmt->bindValue(":size", $size);
    $stmt->bindValue(":quantity", $quantity);
    $stmt->bindValue(":date_ajout", date('Y-m-d'));
    $stmt->bindValue(":statut", "disponible");
    $stmt->bindValue(":categorie", $categorie);
    $stmt->execute();
}