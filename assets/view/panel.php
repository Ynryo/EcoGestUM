<header>
    <a class="menu-button" id="menu-button">
        <span class="material-symbols-outlined">
            menu
        </span>
    </a>
    <a href="/">
        <img src="/assets/img/ecogestum-logo.png" alt="Logo de Le Mans Université">
    </a>
</header>

<?php
$current_user = [
    "identifiant" => $_SESSION["user"]["identifiant"] ?? "i2400001",
    "prenom_utilisateur" => $_SESSION["user"]["prenom_utilisateur"] ?? "Ewen",
    "nom_utilisateur" => $_SESSION["user"]["nom_utilisateur"] ?? "Inconnu",
    "id_role" => $_SESSION["user"]["id_role"] ?? 1,
    "nom_role" => $_SESSION["user"]["nom_role"] ?? 'Président de l\'université',
];

$allowed_panel_roles = [1, 2, 3, 4, 5];
$current_role_id = $current_user["id_role"];

if (!in_array($current_role_id, $allowed_panel_roles)) {
    header('Location: /errors/403/');
    exit;
}

$title = $title ?? "Panneau de Configuration";
$userName = $current_user["nom_utilisateur"];

$base_url = '/panel';
$current_uri = $_SERVER['REQUEST_URI'];

$linkMapping = [
    'index' => 'accueil',
    'statistics' => 'statistiques',
    'server' => 'serveur',
    'inventory' => 'inventaire',
    'communications' => 'communiques',
    'settings' => 'parametres',
    'odds' => 'odd',
    'history' => 'historique'
];

$uri = $_SERVER['REQUEST_URI'] ?? '/panel/index';
$path = parse_url($uri, PHP_URL_PATH);
$segments = array_filter(explode('/', $path));
$uriSegment = strtolower(end($segments));
$activeKey = ($uriSegment === 'panel' || $uriSegment === '') ? 'index' : $uriSegment;
$currentPage = $linkMapping[$activeKey] ?? 'accueil';

function isActive(string $linkName, string $currentPage): string
{
    if ($linkName === $currentPage) {
        return ' active';
    }
    return '';
}

$roleWords = explode(' ', strtolower($current_user["nom_role"]));
$shortRole = ucfirst($roleWords[0]);

function getPageTitle(string $page): string
{
    $titles = [
        'accueil' => 'Accueil',
        'statistiques' => 'Statistiques',
        'serveur' => 'Serveur',
        'inventaire' => 'Inventaire',
        'communiques' => 'Communiqués',
        'parametres' => 'Paramètres',
        'odd' => '17 ODD',
        'historique' => 'Historique'
    ];
    return $titles[$page] ?? 'Page Inconnue';
}

$pageTitle = getPageTitle($currentPage);
$contentTitle = $pageTitle . " " . $shortRole;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM | <?= htmlspecialchars($title) ?></title>
</head>

<body>
    <div class="nav-panel">
        <a href="<?= $base_url ?>/index" class="nav-item<?php echo isActive('accueil', $currentPage); ?>">
            <span class="material-symbols-outlined">home</span>
            Accueil
        </a>

        <a href="<?= $base_url ?>/statistics" class="nav-item<?php echo isActive('statistiques', $currentPage); ?>">
            <span class="material-symbols-outlined">query_stats</span>
            Statistiques
        </a>

        <a href="<?= $base_url ?>/server" class="nav-item<?php echo isActive('serveur', $currentPage); ?>">
            <span class="material-symbols-outlined">dns</span>
            Serveur
        </a>

        <a href="<?= $base_url ?>/inventory" class="nav-item<?php echo isActive('inventaire', $currentPage); ?>">
            <span class="material-symbols-outlined">inventory</span>
            Inventaire
        </a>

        <a href="<?= $base_url ?>/communications" class="nav-item<?php echo isActive('communiques', $currentPage); ?>">
            <span class="material-symbols-outlined">campaign</span>
            Communiqués
        </a>

        <a href="<?= $base_url ?>/settings" class="nav-item<?php echo isActive('parametres', $currentPage); ?>">
            <span class="material-symbols-outlined">settings</span>
            Paramètres
        </a>

        <a href="<?= $base_url ?>/odds" class="nav-item<?php echo isActive('odd', $currentPage); ?>">
            <span class="material-symbols-outlined">lightbulb</span>
            17 ODD
        </a>

        <a href="<?= $base_url ?>/history" class="nav-item<?php echo isActive('historique', $currentPage); ?>">
            <span class="material-symbols-outlined">history</span>
            Historique
        </a>

        <a href="/logout/">
            <span class="material-symbols-outlined">logout</span>
            Se déconnecter
        </a>

        </a>
    </div>
    <div class="dashboard-container">

        <div class="nav-panel">
        </div>
        <div class="card-container">
            <div style="margin-bottom: 5px;">
                <h1 class="goia">Bonjour <?= htmlspecialchars($current_user["prenom_utilisateur"]) ?> !</h1>
            </div>

            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                <h3 style="font-weight: 400; font-size: 18px;">Bienvenue sur votre espace</h3>
                <div class="role-badge"><?= htmlspecialchars($current_user["nom_role"]) ?></div>
            </div>

            <div class="card-container">

                <div class="card stats">
                    <h4 style="color: var(--medium);">Objets recyclés ce mois-ci</h4>
                    <div class="number">
                        345
                        <span class="material-symbols-outlined arrow-up">arrow_upward</span>
                    </div>
                </div>

                <div class="card stats">
                    <h4 style="color: var(--medium);">Nouveaux objets enregistrés ce mois-ci</h4>
                    <div class="number">
                        67
                        <span class="material-symbols-outlined arrow-down">arrow_downward</span>
                    </div>
                </div>

                <div class="card full-width">
                    <h4 style="color: var(--dark);">Composante la plus active</h4>
                    <div style="margin: 10px 0;">
                        <span class="composante-badge">Faculté des Lettres, Langues & Sciences Humaines</span>
                    </div>
                    <p style="color: var(--dark); font-weight: 500;">43 objets recyclés ce mois ci <span class="material-symbols-outlined arrow-up" style="font-size: 18px;">arrow_upward</span></p>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</body>