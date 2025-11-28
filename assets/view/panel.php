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

<head>
    <title>EcoGestUM | Panneau de Configuration</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(dirname(__FILE__, 3) . '/assets/src/assets.php') ?>
    <link rel="stylesheet" href="/assets/css/globals.css">
    <link rel="stylesheet" href="/assets/css/panel.css">
    <link rel="stylesheet" href="/assets/css/search.css">
    <link rel="stylesheet" href="/assets/css/boxs.css">
    <link rel="stylesheet" href="/assets/css/post-ads.css">
</head>

<?php
$current_user = [
    "identifiant" => $_SESSION["user"]["identifiant"] ?? "i2400001",
    "prenom_utilisateur" => $_SESSION["user"]["prenom_utilisateur"] ?? "",
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

$demandes = [];

try {
    $sql = "
        SELECT
            O.nom_objet AS nom,
            SUM(O.quantity) AS quantite, 
            COALESCE(COM.nom_composante, 'Non assignée') AS composante 
        FROM OBJET O
        
        JOIN AGENCER A ON O.id_objet = A.id_objet
        JOIN INVENTAIRE INV ON A.id_inventaire = INV.id_inventaire
        LEFT JOIN DEPARTEMENT D ON INV.id_inventaire = D.id_inventaire
        LEFT JOIN SERVICE S ON INV.id_inventaire = S.id_inventaire
        LEFT JOIN COMPOSANTE COM ON D.id_composante = COM.id_composante OR S.id_composante = COM.id_composante
        
        GROUP BY O.nom_objet, COM.nom_composante 
        
        ORDER BY O.id_objet ASC
    ";

    $stmt = $pdo->query($sql);
    $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    error_log("Erreur de requête BDD: " . $e->getMessage());
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
<!DOCTYPE html>
<html lang="fr">

<body>
    <div class="dashboard-container">
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
        </div>
        <?php if ($currentPage === 'accueil'):
            switch ($current_user["id_role"]) {
                case 1:
        ?>
                    <div class="card-container">
                        <div style="margin-bottom: 5px;">
                            <h1 class="goia">Bonjour <?= htmlspecialchars($current_user["prenom_utilisateur"]) ?> !</h1>
                        </div>
                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                            <h3 style="font-weight: 400; font-size: 18px;">Bienvenue sur votre espace</h3>
                            <div class="role r<?= htmlspecialchars($current_user["id_role"]) ?>"></div>
                        </div>
                        <div class="card stats">
                            <h4 style="color: var(--medium);">Objets recyclés ce mois-ci</h4>
                            <div class="number">
                                345
                                <span class="material-symbols-outlined arrow-up">arrow_upward</span>
                            </div>
                            <p style="color: var(--dark); font-weight: 500;">
                                18 de plus que le mois dernier
                        </div>

                        <div class="card stats">
                            <h4 style="color: var(--medium);">Nouveaux objets enregistrés ce mois-ci</h4>
                            <div class="number">
                                67
                                <span class="material-symbols-outlined arrow-down">arrow_downward</span>
                            </div>
                            <p style="color: var(--dark); font-weight: 500;">
                                9 de moins que le mois dernier
                        </div>
                        <div class="card most-active-composante">
                            <h4 style="color: var(--dark);">Composante la plus active</h4>
                            <div style="margin: 10px 0;">
                                <span class="composante c2"></span>
                            </div>
                            <p style="color: var(--dark); font-weight: 500;">
                                43 objets recyclés ce mois ci
                                <span class="material-symbols-outlined arrow-up" style="font-size: 18px;">arrow_upward</span>
                            </p>
                        </div>
                    </div>
                    <div class="card inventory-resume">
                        <h2>Demandes de publications</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Quantité</th>
                                    <th>Composante</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rowCount = 0;
                                foreach ($demandes as $demande) {
                                    if ($rowCount >= 4) {
                                        break;
                                    }
                                ?>
                                    <tr>
                                        <td class="data-row"><?php echo htmlspecialchars($demande['nom']); ?></td>
                                        <td class="data-row"><?php echo htmlspecialchars($demande['quantite']); ?></td>
                                        <td class="data-row">
                                            <span class="component-tag">
                                                <?php echo htmlspecialchars($demande['composante']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php
                                    $rowCount++;
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php
                    break;
                case 2:
                    ?>
                        <div class="card-container">
                            <div style="margin-bottom: 5px;">
                                <h1 class="goia">Bonjour <?= htmlspecialchars($current_user["prenom_utilisateur"]) ?> !</h1>
                            </div>
                            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                                <h3 style="font-weight: 400; font-size: 18px;">Bienvenue sur votre espace</h3>
                                <div class="role r<?= htmlspecialchars($current_user["id_role"]) ?>"></div>
                            </div>
                            <div class="card stats">
                                <h4 style="color: var(--medium);">Objets recyclés ce mois-ci</h4>
                                <div class="number">
                                    345
                                    <span class="material-symbols-outlined arrow-up">arrow_upward</span>
                                </div>
                                <p style="color: var(--dark); font-weight: 500;">
                                    18 de plus que le mois dernier
                            </div>

                            <div class="card stats">
                                <h4 style="color: var(--medium);">Nouveaux objets enregistrés ce mois-ci</h4>
                                <div class="number">
                                    67
                                    <span class="material-symbols-outlined arrow-down">arrow_downward</span>
                                </div>
                                <p style="color: var(--dark); font-weight: 500;">
                                    9 de moins que le mois dernier
                            </div>
                            <div class="card most-active-composante">
                                <h4 style="color: var(--dark);">Composante la plus active</h4>
                                <div style="margin: 10px 0;">
                                    <span class="composante c2"></span>
                                </div>
                                <p style="color: var(--dark); font-weight: 500;">
                                    43 objets recyclés ce mois ci
                                    <span class="material-symbols-outlined arrow-up" style="font-size: 18px;">arrow_upward</span>
                                </p>
                            </div>
                        </div>
                        <div class="card inventory-resume">
                            <h2>Demandes de publications</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Quantité</th>
                                        <th>Composante</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rowCount = 0;
                                    foreach ($demandes as $demande) {
                                        if ($rowCount >= 4) {
                                            break;
                                        }
                                    ?>
                                        <tr>
                                            <td class="data-row"><?php echo htmlspecialchars($demande['nom']); ?></td>
                                            <td class="data-row"><?php echo htmlspecialchars($demande['quantite']); ?></td>
                                            <td class="data-row">
                                                <span class="component-tag">
                                                    <?php echo htmlspecialchars($demande['composante']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php
                                        $rowCount++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php
                        break;
                    case 3:
                        ?>
                            <div class="card-container">
                                <div style="margin-bottom: 5px;">
                                    <h1 class="goia">Bonjour <?= htmlspecialchars($current_user["prenom_utilisateur"]) ?> !</h1>
                                </div>
                                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                                    <h3 style="font-weight: 400; font-size: 18px;">Bienvenue sur votre espace</h3>
                                    <div class="role r<?= htmlspecialchars($current_user["id_role"]) ?>"></div>
                                </div>
                                <div class="card stats">
                                    <h4 style="color: var(--medium);">Objets recyclés ce mois-ci</h4>
                                    <div class="number">
                                        345
                                        <span class="material-symbols-outlined arrow-up">arrow_upward</span>
                                    </div>
                                    <p style="color: var(--dark); font-weight: 500;">
                                        18 de plus que le mois dernier
                                </div>

                                <div class="card stats">
                                    <h4 style="color: var(--medium);">Nouveaux objets enregistrés ce mois-ci</h4>
                                    <div class="number">
                                        67
                                        <span class="material-symbols-outlined arrow-down">arrow_downward</span>
                                    </div>
                                    <p style="color: var(--dark); font-weight: 500;">
                                        9 de moins que le mois dernier
                                </div>
                                <div class="card most-active-composante">
                                    <h4 style="color: var(--dark);">Composante la plus active</h4>
                                    <div style="margin: 10px 0;">
                                        <span class="composante c2"></span>
                                    </div>
                                    <p style="color: var(--dark); font-weight: 500;">
                                        43 objets recyclés ce mois ci
                                        <span class="material-symbols-outlined arrow-up" style="font-size: 18px;">arrow_upward</span>
                                    </p>
                                </div>
                            </div>
                            <div class="card inventory-resume">
                                <h2>Demandes de publications</h2>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Quantité</th>
                                            <th>Composante</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rowCount = 0;
                                        foreach ($demandes as $demande) {
                                            if ($rowCount >= 4) {
                                                break;
                                            }
                                        ?>
                                            <tr>
                                                <td class="data-row"><?php echo htmlspecialchars($demande['nom']); ?></td>
                                                <td class="data-row"><?php echo htmlspecialchars($demande['quantite']); ?></td>
                                                <td class="data-row">
                                                    <span class="component-tag">
                                                        <?php echo htmlspecialchars($demande['composante']); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php
                                            $rowCount++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            <?php
                            break;
                        case 4:
                            ?>
                                <div class="card-container">
                                    <div style="margin-bottom: 5px;">
                                        <h1 class="goia">Bonjour <?= htmlspecialchars($current_user["prenom_utilisateur"]) ?> !</h1>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                                        <h3 style="font-weight: 400; font-size: 18px;">Bienvenue sur votre espace</h3>
                                        <div class="role r<?= htmlspecialchars($current_user["id_role"]) ?>"></div>
                                    </div>
                                    <div class="card stats">
                                        <h4 style="color: var(--medium);">Objets recyclés ce mois-ci</h4>
                                        <div class="number">
                                            345
                                            <span class="material-symbols-outlined arrow-up">arrow_upward</span>
                                        </div>
                                        <p style="color: var(--dark); font-weight: 500;">
                                            18 de plus que le mois dernier
                                    </div>

                                    <div class="card stats">
                                        <h4 style="color: var(--medium);">Nouveaux objets enregistrés ce mois-ci</h4>
                                        <div class="number">
                                            67
                                            <span class="material-symbols-outlined arrow-down">arrow_downward</span>
                                        </div>
                                        <p style="color: var(--dark); font-weight: 500;">
                                            9 de moins que le mois dernier
                                    </div>
                                    <div class="card most-active-composante">
                                        <h4 style="color: var(--dark);">Composante la plus active</h4>
                                        <div style="margin: 10px 0;">
                                            <span class="composante c2"></span>
                                        </div>
                                        <p style="color: var(--dark); font-weight: 500;">
                                            43 objets recyclés ce mois ci
                                            <span class="material-symbols-outlined arrow-up" style="font-size: 18px;">arrow_upward</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="card inventory-resume">
                                    <h2>Demandes de publications</h2>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Nom</th>
                                                <th>Quantité</th>
                                                <th>Composante</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $rowCount = 0;
                                            foreach ($demandes as $demande) {
                                                if ($rowCount >= 4) {
                                                    break;
                                                }
                                            ?>
                                                <tr>
                                                    <td class="data-row"><?php echo htmlspecialchars($demande['nom']); ?></td>
                                                    <td class="data-row"><?php echo htmlspecialchars($demande['quantite']); ?></td>
                                                    <td class="data-row">
                                                        <span class="component-tag">
                                                            <?php echo htmlspecialchars($demande['composante']); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php
                                                $rowCount++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                <?php
                                break;
                            case 5:
                                ?>
                                    <div class="card-container">
                                        <div style="margin-bottom: 5px;">
                                            <h1 class="goia">Bonjour <?= htmlspecialchars($current_user["prenom_utilisateur"]) ?> !</h1>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                                            <h3 style="font-weight: 400; font-size: 18px;">Bienvenue sur votre espace</h3>
                                            <div class="role r<?= htmlspecialchars($current_user["id_role"]) ?>"></div>
                                        </div>
                                        <div class="card stats">
                                            <h4 style="color: var(--medium);">Objets recyclés ce mois-ci</h4>
                                            <div class="number">
                                                345
                                                <span class="material-symbols-outlined arrow-up">arrow_upward</span>
                                            </div>
                                            <p style="color: var(--dark); font-weight: 500;">
                                                18 de plus que le mois dernier
                                        </div>

                                        <div class="card stats">
                                            <h4 style="color: var(--medium);">Nouveaux objets enregistrés ce mois-ci</h4>
                                            <div class="number">
                                                67
                                                <span class="material-symbols-outlined arrow-down">arrow_downward</span>
                                            </div>
                                            <p style="color: var(--dark); font-weight: 500;">
                                                9 de moins que le mois dernier
                                        </div>
                                        <div class="card most-active-composante">
                                            <h4 style="color: var(--dark);">Composante la plus active</h4>
                                            <div style="margin: 10px 0;">
                                                <span class="composante c2"></span>
                                            </div>
                                            <p style="color: var(--dark); font-weight: 500;">
                                                43 objets recyclés ce mois ci
                                                <span class="material-symbols-outlined arrow-up" style="font-size: 18px;">arrow_upward</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card inventory-resume">
                                        <h2>Demandes de publications</h2>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Quantité</th>
                                                    <th>Composante</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $rowCount = 0;
                                                foreach ($demandes as $demande) {
                                                    if ($rowCount >= 4) {
                                                        break;
                                                    }
                                                ?>
                                                    <tr>
                                                        <td class="data-row"><?php echo htmlspecialchars($demande['nom']); ?></td>
                                                        <td class="data-row"><?php echo htmlspecialchars($demande['quantite']); ?></td>
                                                        <td class="data-row">
                                                            <span class="component-tag">
                                                                <?php echo htmlspecialchars($demande['composante']); ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $rowCount++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                <?php
                                break;
                            default:
                                header('Location: /errors/403/');
                                exit;
                        }
                                ?>
                                <?php if (count($demandes) > 4) { ?>
                                    <div class="footer text-center">
                                        <a href="<?php echo $base_url; ?>/inventory" class="btn btn-primary btn-sm">
                                            Voir plus de demandes (<?php echo count($demandes); ?> au total)
                                        </a>
                                    </div>
                                <?php } ?>
                                </table>
                                    </div>
                                <?php elseif ($currentPage === 'statistiques'): ?>
                                    <div class="card-container">
                                        <div style="margin-bottom: 5px;">
                                            <h1 class="goia">Statistiques</h1>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                                            <h3 style="font-weight: 400; font-size: 18px;">Vue d'ensemble des statistiques</h3>
                                            <div class="role r<?= htmlspecialchars($current_user["id_role"]) ?>"></div>
                                        </div>
                                        <div class="card stats">
                                            <h4 style="color: var(--medium);">Objets recyclés ce mois-ci</h4>
                                            <div class="number">
                                                345
                                                <span class="material-symbols-outlined arrow-up">arrow_upward</span>
                                            </div>
                                            <p style="color: var(--dark); font-weight: 500;">
                                                18 de plus que le mois dernier
                                        </div>

                                        <div class="card stats">
                                            <h4 style="color: var(--medium);">Nouveaux objets enregistrés ce mois-ci</h4>
                                            <div class="number">
                                                67
                                                <span class="material-symbols-outlined arrow-down">arrow_downward</span>
                                            </div>
                                            <p style="color: var(--dark); font-weight: 500;">
                                                9 de moins que le mois dernier
                                        </div>
                                        <div class="card most-active-composante">
                                            <h4 style="color: var(--dark);">Composante la plus active</h4>
                                            <div style="margin: 10px 0;">
                                                <span class="composante c2"></span>
                                            </div>
                                            <p style="color: var(--dark); font-weight: 500;">
                                                43 objets recyclés ce mois ci
                                                <span class="material-symbols-outlined arrow-up" style="font-size: 18px;">arrow_upward</span>
                                            </p>
                                        </div>
                                        <div class="card graph-box pie-chart-container" style="display: flex; align-items: center; justify-content: space-between; padding: 20px;">
                                            <div>
                                                <h3 style="color: var(--dark); margin-bottom: 15px;">Répartition des recyclages par composante de l'université</h3>
                                                <div style="width: 250px; height: 250px;">
                                                    <canvas id="pieChart"></canvas>
                                                </div>
                                            </div>

                                            <div class="legend-box" style="margin-left: 20px;">
                                                <h4 style="color: var(--medium); margin-bottom: 10px;">Légende</h4>
                                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                                    <div class="legend-item"><span style="background-color: #f7b760; display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-right: 8px;"></span> IUT Le Mans</div>
                                                    <div class="legend-item"><span style="background-color: #9d3363; display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-right: 8px;"></span> IUT Laval</div>
                                                    <div class="legend-item"><span style="background-color: #457b9d; display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-right: 8px;"></span> ENSIM</div>
                                                    <div class="legend-item"><span style="background-color: #546b8b; display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-right: 8px;"></span> F. Lettres, Langues & SH</div>
                                                    <div class="legend-item"><span style="background-color: #e63946; display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-right: 8px;"></span> F. Droit, Sc. Éco & Gestion</div>
                                                    <div class="legend-item"><span style="background-color: #4cc9f0; display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-right: 8px;"></span> F. Sciences & Techniques</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card graph-box line-graph-container" style="margin-top: 20px; padding: 20px;user-select: none;">
                                            <canvas id="lineChart"></canvas>
                                        </div>

                                    </div>

                                    <script src="assets/js/chart.js"></script>
                                </div>
                            <?php elseif ($currentPage === 'inventaire'): ?>
                                <div class="card inventory-resume">
                                    <h2>Demandes de publications</h2>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th style="width: 50%;">Nom</th>
                                                <th style="width: 20%;">Quantité</th>
                                                <th style="width: 30%;">Composante</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($demandes as $demande) {
                                            ?>
                                                <tr>
                                                    <td class="data-row"><?php echo htmlspecialchars($demande['nom']); ?></td>
                                                    <td class="data-row"><?php echo htmlspecialchars($demande['quantite']); ?></td>
                                                    <td class="data-row">
                                                        <span class="component-tag">
                                                            <?php echo htmlspecialchars($demande['composante']); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php elseif ($currentPage === 'communiques'): ?>
                                <h2>Publier un communiqué</h2>
                                <div class="input-group">
                                    <label class="label-text" for="identifiant">Titre *</label>
                                </div><?php endif; ?>
                            </div>
                        </div>
                    </div>
</body>