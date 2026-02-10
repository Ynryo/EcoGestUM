<?php
$max_files = 4;
$max_size = 5 * 1024 * 1024;
$target_dir = $_SERVER["DOCUMENT_ROOT"] . "/assets/img/products/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once dirname(__FILE__, 2) . '/assets/models/conn.php';
    include_once dirname(__FILE__, 2) . '/assets/models/mDonation.php';

    $name_objet = strip_tags($_POST["name_objet"]);
    $desc = strip_tags($_POST["desc"]);
    $color = strip_tags($_POST["color"]);
    $size = strip_tags($_POST["size"]);
    $quantity = strip_tags($_POST["quantity"]);
    $categorie = strip_tags($_POST["categorie"]);
    $etat = strip_tags($_POST["etat"]);
    $inventaire = strip_tags($_POST["inventaire"]);

    // Vérifier si des fichiers ont été uploadés
    if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
        echo "<h2>Aucun fichier soumis.</h2>";
        exit;
    }

    $files = $_FILES['images'];

    // Vérifier le nombre maximum de fichiers
    if (count($files['name']) > $max_files) {
        echo "<h2>Erreur : maximum d'images autorisé : {$max_files}.</h2>";
        exit;
    }

    // Créer le répertoire si nécessaire
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Récupérer le prochain ID d'objet
    $last_id = getNextObjectId($pdo);

    // Upload des images
    for ($i = 0; $i < count($files['name']); $i++) {
        $file_info = [
            'name' => $files['name'][$i],
            'type' => $files['type'][$i],
            'tmp_name' => $files['tmp_name'][$i],
            'error' => $files['error'][$i],
            'size' => $files['size'][$i],
        ];

        $upload_result = handleSingleUpload($file_info, $max_size, $target_dir, $last_id, $i);
        if (!$upload_result['success']) {
            echo "<p class=\"error\">Erreur : " . htmlspecialchars($upload_result['message']) . "</p>";
            exit();
        }
    }

    // Créer l'objet
    $object_data = [
        'name' => $name_objet,
        'desc' => $desc,
        'etat' => $etat,
        'color' => $color,
        'size' => $size,
        'quantity' => $quantity,
        'categorie' => $categorie
    ];

    $create_result = createObject($pdo, $object_data);
    if (!$create_result['success']) {
        die("<p class=\"error\">" . htmlspecialchars($create_result['message']) . "</p>");
    }

    // Assigner l'objet à l'inventaire
    $assign_result = assignObjectToInventory($pdo, $last_id, $inventaire);
    if (!$assign_result['success']) {
        die("<p class=\"error\">" . htmlspecialchars($assign_result['message']) . "</p>");
    }

    header("Location: /");
}
