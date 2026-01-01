<?php
include_once(dirname(__FILE__, 3) . '/assets/models/access_controller.php');
include_once(dirname(__FILE__, 3) . '/assets/models/conn.php');
include_once(dirname(__FILE__, 3) . '/assets/models/assets.php');

$user_id = $_SESSION["user_id"];
$user_role = $_SESSION["id_role"];

// Pagination
$items_per_page = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $items_per_page;

// Build query based on user role
$base_query = "
    SELECT DISTINCT 
        o.id_objet, o.nom_objet, o.desc_objet, o.quantity, o.etat, o.statut,
        c.id_composante, cat.titre_categorie
    FROM objet o
    JOIN agencer a ON o.id_objet = a.id_objet
    JOIN inventaire i ON a.id_inventaire = i.id_inventaire
    LEFT JOIN departement d ON i.id_inventaire = d.id_inventaire
    LEFT JOIN service s ON i.id_inventaire = s.id_inventaire
    LEFT JOIN composante c ON d.id_composante = c.id_composante OR s.id_composante = c.id_composante
    LEFT JOIN categorie cat ON o.id_categorie = cat.id_categorie
";

$count_query = "
    SELECT COUNT(DISTINCT o.id_objet) as total
    FROM objet o
    JOIN agencer a ON o.id_objet = a.id_objet
    JOIN inventaire i ON a.id_inventaire = i.id_inventaire
    LEFT JOIN departement d ON i.id_inventaire = d.id_inventaire
    LEFT JOIN service s ON i.id_inventaire = s.id_inventaire
    LEFT JOIN composante c ON d.id_composante = c.id_composante OR s.id_composante = c.id_composante
";

$where_clause = "";
$params = [];

switch ($user_role) {
    case 1: // Président - voit tout
        // Pas de filtre
        break;
    case 2: // Chef de composante - voit les objets de sa composante
        $where_clause = " WHERE c.id_utilisateur = :user_id";
        $params[':user_id'] = $user_id;
        break;
    case 3: // Chef de département - voit les objets de son département
        $where_clause = " WHERE d.id_utilisateur = :user_id";
        $params[':user_id'] = $user_id;
        break;
    case 4: // Responsable de service - voit les objets de son service
        $where_clause = " WHERE s.id_utilisateur = :user_id";
        $params[':user_id'] = $user_id;
        break;
    default:
        // Autres rôles - ne voient rien
        $where_clause = " WHERE 1=0";
        break;
}

// Count total items
$stmt_count = $pdo->prepare($count_query . $where_clause);
foreach ($params as $key => $value) {
    $stmt_count->bindValue($key, $value);
}
$stmt_count->execute();
$total_items = $stmt_count->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_items / $items_per_page);

// Fetch objects
$final_query = $base_query . $where_clause . " ORDER BY o.id_objet LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($final_query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$objects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function to get movement history for an object
function getObjectHistory($pdo, $id_objet)
{
    $stmt = $pdo->prepare("
        SELECT r.date_ajout, r.date_fin, i.nom_inventaire, c.nom_composante
        FROM recuperer r
        JOIN inventaire i ON r.id_donneur = i.id_inventaire
        LEFT JOIN departement d ON i.id_inventaire = d.id_inventaire
        LEFT JOIN service s ON i.id_inventaire = s.id_inventaire
        LEFT JOIN composante c ON d.id_composante = c.id_composante OR s.id_composante = c.id_composante
        WHERE r.id_objet = :id_objet
        ORDER BY r.date_ajout DESC
    ");
    $stmt->bindParam(':id_objet', $id_objet);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Status badge class mapping
function getStatusClass($statut)
{
    switch ($statut) {
        case 'Disponible':
            return 'oui';
        case 'Réservé':
            return 'en-cours';
        case 'Indisponible':
            return 'non';
        case 'En élimination':
            return 'non';
        case 'Supprimé':
            return 'non';
        default:
            return 'non';
    }
}
?>
<title>EcoGestUM - Inventaire</title>
<link rel="stylesheet" href="/assets/css/boxs.css">
<link rel="stylesheet" href="/assets/css/navbar.css">
<link rel="stylesheet" href="/assets/css/tables.css">
<link rel="stylesheet" href="/assets/css/inventory.css">
</head>

<body>
    <?php include(dirname(__FILE__, 3) . '/assets/view/header.php') ?>
    <section class="main panel">
        <?php
        include(dirname(__FILE__, 3) . '/assets/models/navbar.php');
        include(dirname(__FILE__, 3) . '/assets/view/panel/navbar.php');
        ?>
        <div class="container">
            <h2>Inventaire</h2>
            <p class="inventory-count">Affichage de <?= $offset + 1 ?> à
                <?= min($offset + $items_per_page, $total_items) ?> sur <?= $total_items ?> lignes
            </p>

            <div class="inventory-table">
                <div class="inventory-table-header">
                    <span class="col-name">Nom de l'objet</span>
                    <span class="col-qty">Quantité</span>
                    <span class="col-composante">Composante</span>
                    <span class="col-category">Catégorie</span>
                    <span class="col-etat">État</span>
                    <span class="col-status">Statut</span>
                    <span class="col-arrow"></span>
                </div>

                <?php foreach ($objects as $obj):
                    $history = getObjectHistory($pdo, $obj['id_objet']);
                ?>
                    <div class="inventory-row" onclick="toggleRow(this)">
                        <div class="inventory-row-header">
                            <span class="col-name"><?= htmlspecialchars($obj['nom_objet']) ?></span>
                            <span class="col-qty"><?= htmlspecialchars($obj['quantity']) ?></span>
                            <span class="col-composante">
                                <span class="composante c<?= htmlspecialchars($obj['id_composante']) ?>"></span>
                            </span>
                            <span class="col-category"><?= htmlspecialchars($obj['titre_categorie'] ?? 'N/A') ?></span>
                            <span class="col-etat"><?= htmlspecialchars($obj['etat'] ?? 'N/A') ?></span>
                            <span class="col-status">
                                <span class="status <?= $obj['statut'] ?>"></span>
                            </span>
                            <span class="col-arrow">
                                <span class="material-symbols-outlined arrow-icon">expand_more</span>
                            </span>
                        </div>
                        <div class="inventory-row-content">
                            <div class="inventory-detail">
                                <img class="inventory-image" src="/assets/img/products/<?= htmlspecialchars($obj['id_objet']) ?>_1.png" alt="">
                                <div class="inventory-info">
                                    <h3><?= htmlspecialchars($obj['nom_objet']) ?></h3>
                                    <div class="info-row">
                                        <span class="info-label">Description</span>
                                        <span
                                            class="info-value"><?= htmlspecialchars($obj['desc_objet'] ?? 'Aucune description') ?></span>
                                    </div>
                                    <div class="history-section">
                                        <span class="info-label">Historique</span>
                                        <div class="timeline">
                                            <?php if (empty($history)): ?>
                                                <p class="no-history">Aucun historique de mouvement</p>
                                            <?php else: ?>
                                                <?php foreach ($history as $h): ?>
                                                    <div class="timeline-item">
                                                        <div class="timeline-dot"></div>
                                                        <div class="timeline-content">
                                                            <span
                                                                class="composante c<?= htmlspecialchars($obj['id_composante']) ?>"></span>
                                                            <span
                                                                class="timeline-date"><?= date('d/m/Y', strtotime($h['date_ajout'])) ?></span>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <button class="button orange recycle-btn">Proposer l'objet au recyclage</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <span class="pagination-label">Voir</span>
                <?php foreach ([10, 25, 50, 100] as $limit): ?>
                    <a href="?limit=<?= $limit ?>&page=1"
                        class="pagination-option <?= $items_per_page == $limit ? 'active' : '' ?>"><?= $limit ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include(dirname(__FILE__, 3) . '/assets/view/footer.php') ?>

    <script>
        function toggleRow(row) {
            row.classList.toggle('expanded');
        }
    </script>
</body>

</html>