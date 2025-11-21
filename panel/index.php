<?php
include(dirname(__FILE__, 2) . '/assets/src/files_header.php');
include(dirname(__FILE__, 2) . '/assets/src/conn.php');

$stmt = $pdo->prepare("SELECT u.nom_utilisateur, u.prenom_utilisateur, u.mail_univ, r.id_role FROM utilisateur u JOIN role r on u.id_role = r.id_role WHERE u.id_utilisateur = :u;");
$stmt->bindParam(':u', $_SESSION["user_id"]);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('Location: /login/');
    exit;
}

$role_name = $user_data['role_utilisateur'] ?? 'Président de l\'université';
$role_id = $user_data['id_role'] ?? 1;
$view = $_GET['view'] ?? 'accueil'; 

$objets_recycles = 345;
$nouveaux_objets = 67;
$composante_active = "Faculté des Lettres, Langues & Sciences Humaines";
$objets_recycles_composante = 43;

$demandes_publications = [
    ['Nom' => 'Ordinateurs', 'Quantité' => 5, 'Composante' => 'IUT Le Mans'],
    ['Nom' => 'Ordinateurs', 'Quantité' => 5, 'Composante' => 'IUT Le Mans'],
    ['Nom' => 'Ordinateurs', 'Quantité' => 5, 'Composante' => 'IUT Le Mans'],
    ['Nom' => 'Ordinateurs', 'Quantité' => 5, 'Composante' => 'IUT Le Mans'],
    ['Nom' => 'Ordinateurs', 'Quantité' => 5, 'Composante' => 'IUT Le Mans'],
    ['Nom' => 'Ordinateurs', 'Quantité' => 5, 'Composante' => 'IUT Le Mans'],
    ['Nom' => 'Ordinateurs', 'Quantité' => 5, 'Composante' => 'IUT Le Mans'],
    ['Nom' => 'Ordinateurs', 'Quantité' => 5, 'Composante' => 'IUT Le Mans'],
];
?>
<?php include(dirname(__FILE__, 2) . '/assets/view/panel.php')

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM - PdC - Accueil</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(dirname(__FILE__, 2) . '/assets/src/assets.php') ?>
    <link rel="stylesheet" href="/assets/css/search.css">
    <link rel="stylesheet" href="/assets/css/boxs.css">
    <link rel="stylesheet" href="/assets/css/profile.css">
</head>
</html>