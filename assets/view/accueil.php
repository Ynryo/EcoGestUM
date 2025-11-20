<?php
session_start();

$current_user = [
    "identifiant" => $_SESSION["user"]["identifiant"] ?? "i2400001",
    "prenom_utilisateur" => $_SESSION["user"]["prenom_utilisateur"] ?? "Ewen",
    "nom_utilisateur" => $_SESSION["user"]["nom_utilisateur"] ?? "Inconnu",
    "id_role" => $_SESSION["user"]["id_role"] ?? 1,
    "nom_role" => $_SESSION["user"]["nom_role"] ?? 'Président de l\'université',
];

$title = $title ?? "Tableau de bord";
$userName = $current_user["nom_utilisateur"];

$all_nav_links = [
    "Accueil" => ["icon" => "fa-house", "url" => "/panel", "active" => true],
    "Statistiques" => ["icon" => "fa-chart-simple", "url" => "/panel/stats.php"],
    "Serveur" => ["icon" => "fa-server", "url" => "/panel/server.php"],
    "Inventaire" => ["icon" => "fa-box", "url" => "/panel/inventory.php"],
    "Communiqués" => ["icon" => "fa-newspaper", "url" => "/panel/communique.php"],
    "17 ODD" => ["icon" => "fa-globe", "url" => "/panel/odd.php"],
    "Paramètres BDD" => ["icon" => "fa-screwdriver-wrench", "url" => "/panel/settings_db.php"],
    "Historique" => ["icon" => "fa-clock-rotate-left", "url" => "/panel/history.php"],
];

$permissions_map = [
    1 => ["Accueil", "Statistiques", "Inventaire", "Communiqués", "17 ODD", "Historique"],
    5 => ["Accueil", "Statistiques", "Serveur", "Inventaire", "Communiqués", "Paramètres BDD", "Historique"],
    2 => ["Accueil", "Statistiques", "Inventaire", "Historique"],
    3 => ["Accueil", "Statistiques", "Inventaire", "Historique"],
    4 => ["Accueil", "Statistiques", "Inventaire", "Historique"],
    "default" => ["Accueil", "Inventaire"],
];

$allowed_links_labels =
    $permissions_map[$current_user["id_role"]] ?? $permissions_map["default"];

$stats = $stats ?? [
    "Objets inventoriés" => 10,
    "Communiqués" => 10,
    "Utilisateurs" => 10,
    "Événements" => 10,
];

$alerts = $alerts ?? [];

function e($v)
{
    return htmlspecialchars((string) $v, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title><?= e($title) ?> | EcoGestUM</title>
        <link rel="stylesheet" href="/assets/css/panel-index-view.css">
    </head>
    <body>
        <header class="app-header">
            <div class="logo-container">
                <img src="/assets/img/logo-le-mans-universite.png" alt="Logo Le Mans Université" class="university-logo">
                <span class="university-name">Le Mans Université</span>
                <span class="app-title">EcoGestUM</span>
            </div>
        </header>

        <div class="app-container">
            <aside class="sidebar" role="navigation">
                <nav class="nav-menu">
                    <?php foreach ($all_nav_links as $label => $props): ?>
                    <?php if (in_array($label, $allowed_links_labels)): ?>
                        <a href="<?= e($props['url']) ?>" 
                           class="menu-item <?= isset($props['active']) ? 'active' : '' ?>">
                            <i class="fa-solid <?= e($props['icon']) ?> icon"></i>
                            <?= e($label) ?>
                        </a>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </nav>
                
                <div class="nav-menu logout-section">
                    <a href="/logout.php" class="menu-item logout-btn">
                        <i class="fa-solid fa-right-from-bracket icon"></i> Se déconnecter
                    </a>
                </div>
            </aside>
            
            <main class="main-content">
                <?php foreach ($alerts as $a): ?>
                    <div class="alert alert-<?= e($a['type'] ?? 'info')?>">
                        <?= e($a['msg'] ?? '') ?>
                    </div>
                <?php endforeach; ?>

                <h2 class="welcome-title">Bonjour <?= e($userName) ?> !</h2>
                <div class="welcome-meta">
                    <span class="meta-text">Bienvenue sur votre espace</span>
                    <span class="role-badge">
                        <?= e($current_user['nom_role']) ?>
                    </span>
                </div>

                <div class="stats-grid">
                    <?php foreach ($stats as $label => $value): ?>
                    <div class="stat-card">
                        <div class="card-body">
                            <h6 class="stat-label"><?= e($label) ?></h6>
                            <h3 class="stat-value"><?= e($value) ?></h3>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <section class="recent-actions">
                    <div class="card-header">
                        Actions récentes
                        <a href="/panel/activity.php" class="view-all-btn">Voir tout</a>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Aucune activité récente. Les actions passeront ici.</p>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>