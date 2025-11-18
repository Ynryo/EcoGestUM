<?php
session_start();
include(dirname(__FILE__, 2) . '/assets/src/files_header.php');
include_once dirname(__FILE__, 2) . '/assets/src/conn.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: /login/');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION["user_name"] ?? "Utilisateur";
$stmt_role = $pdo->prepare("SELECT role_utilisateur FROM UTILISATEUR WHERE id_utilisateur = :id");
$stmt_role->bindParam(':id', $user_id);
$stmt_role->execute();
$role = $stmt_role->fetchColumn() ?? 'Président de l\'université'; 
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
    <title>EcoGestUM - Accueil</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(dirname(__FILE__, 2) . '/assets/src/assets.php') ?>
    <link rel="stylesheet" href="/assets/css/dashboard.css"> 
</head>
<body>
    <div class="main-layout"> 
        <aside class="sidebar">
            <div class="header-logo">
                <img src="/assets/img/lmu-logo.png" alt="Logo LMU" class="lmu-logo">
                <h1>EcoGestUM</h1>
            </div>
            <nav class="nav-menu">
                <a href="/accueil/" class="nav-item active"><i class="fas fa-home"></i> Accueil</a>
                <a href="/statistiques/" class="nav-item"><i class="fas fa-chart-bar"></i> Statistiques</a>
                <a href="/inventaire/" class="nav-item"><i class="fas fa-box"></i> Inventaire</a>
                <a href="/communiques/" class="nav-item"><i class="fas fa-comments"></i> Communiqués</a>
                <a href="/odd/" class="nav-item"><i class="fas fa-seedling"></i> 17 ODD</a>
                <a href="/historique/" class="nav-item"><i class="fas fa-history"></i> Historique</a>
                <a href="/logout.php" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a>
            </nav>
        </aside>

        <main class="content-area">
            
            <h2>Bonjour <?= htmlspecialchars($user_name) ?> !</h2>
            <p class="welcome-subtitle">Bienvenue sur votre espace 
                <span class="user-role"><?= htmlspecialchars($role) ?></span>
            </p>
            <section class="stat-cards-container">
                <div class="stat-card stat-recycles">
                    <h3>Objets recyclés ce mois-ci</h3>
                    <div class="stat-value"><?= $objets_recycles ?> <i class="fas fa-arrow-up green"></i></div>
                </div>
                <div class="stat-card stat-nouveaux">
                    <h3>Nouveaux objets enregistrés ce mois-ci</h3>
                    <div class="stat-value"><?= $nouveaux_objets ?> <i class="fas fa-arrow-down red"></i></div>
                </div>
                <div class="stat-card stat-composante">
                    <h3>Composante la plus active</h3>
                    <p class="composante-name"><?= htmlspecialchars($composante_active) ?></p>
                    <p class="composante-details"><?= $objets_recycles_composante ?> objets recyclés ce mois ci <i class="fas fa-arrow-up green"></i></p>
                </div>
            </section>
            <section class="publications-table-container">
                <h3>Demandes de publications</h3>
                <div class="table-card">
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Quantité</th>
                                <th>Composante</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($demandes_publications as $demande): ?>
                            <tr>
                                <td><?= htmlspecialchars($demande['Nom']) ?></td>
                                <td><?= htmlspecialchars($demande['Quantité']) ?></td>
                                <td><span class="composante-badge"><?= htmlspecialchars($demande['Composante']) ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <a href="/publications/" class="voir-plus">Voir plus <i class="fas fa-external-link-alt"></i></a>
                </div>
            </section>
        </main>

    </div>
</body>
</html>