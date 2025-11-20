<?php
include(dirname(__FILE__, 2) . '/assets/src/files_header.php');
include_once dirname(__FILE__, 2) . '/assets/src/conn.php';   

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: /login/'); 
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION["user_name"] ?? "Utilisateur";

$stmt_role = $pdo->prepare("SELECT nom_role, UTILISATEUR.id_role FROM UTILISATEUR JOIN ROLE ON ROLE.id_role = UTILISATEUR.id_role WHERE id_utilisateur = ?");
$stmt_role->execute([$user_id]);
$user_data = $stmt_role->fetch(PDO::FETCH_ASSOC);

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

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>EcoGestUM - <?= ucfirst($view) ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include dirname(__FILE__, 2) . '/assets/src/assets.php';    ?>
    <link rel="stylesheet" href="/assets/css/session.css"> 
    <?php if ($view == 'statistiques'): ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <?php endif; ?>
</head>

<body>
    <div class="main-layout"> 
        
        <aside class="sidebar">
            <div class="header-logo">
                <img src="/assets/img/lmu-logo.png" alt="Logo LMU" class="lmu-logo">
                <h1>EcoGestUM</h1>
            </div>
            <nav class="nav-menu">
                
            <?php if ($role_id == 1):?>
                
                <a href="?view=accueil" class="nav-item <?= ($view == 'accueil' ? 'active' : '') ?>"><i class="fas fa-home"></i> Accueil</a>
                <a href="?view=statistiques" class="nav-item <?= ($view == 'statistiques' ? 'active' : '') ?>"><i class="fas fa-chart-bar"></i> Statistiques</a>
                <a href="?view=inventaire" class="nav-item <?= ($view == 'inventaire' ? 'active' : '') ?>"><i class="fas fa-box"></i> Inventaire</a>
                <a href="?view=communiques" class="nav-item <?= ($view == 'communiques' ? 'active' : '') ?>"><i class="fas fa-comments"></i> Communiqués</a>
                <a href="?view=odd" class="nav-item <?= ($view == 'odd' ? 'active' : '') ?>"><i class="fas fa-seedling"></i> 17 ODD</a>
                <a href="?view=historique" class="nav-item <?= ($view == 'historique' ? 'active' : '') ?>"><i class="fas fa-history"></i> Historique</a>

            <?php elseif ($role_id >= 2 && $role_id <= 6):?>

                <a href="?view=accueil" class="nav-item <?= ($view == 'accueil' ? 'active' : '') ?>"><i class="fas fa-home"></i> Accueil</a>
                <a href="?view=statistiques" class="nav-item <?= ($view == 'statistiques' ? 'active' : '') ?>"><i class="fas fa-chart-bar"></i> Statistiques</a>
                <a href="?view=serveur" class="nav-item <?= ($view == 'serveur' ? 'active' : '') ?>"><i class="fas fa-check-square"></i> Serveur</a>
                <a href="?view=inventaire" class="nav-item <?= ($view == 'inventaire' ? 'active' : '') ?>"><i class="fas fa-box"></i> Inventaire</a>
                <a href="?view=communiques" class="nav-item <?= ($view == 'communiques' ? 'active' : '') ?>"><i class="fas fa-comments"></i> Communiqués</a>
                <a href="?view=parametres" class="nav-item <?= ($view == 'parametres' ? 'active' : '') ?>"><i class="fas fa-cog"></i> Paramètres</a>

            <?php endif; ?>
                <a href="/logout.php" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a>
            </nav>
        </aside>

        <main class="content-area">
            <?php
            $view_file = __DIR__ . '/assets/views/' . $view . '.php';

            if (file_exists($view_file)) {
                include($view_file); 
            } else {
                echo '<h2>Erreur 404</h2><p>La page demandée est introuvable.</p>';
            }
            ?>
        </main>
    </div>
</body>
</html>