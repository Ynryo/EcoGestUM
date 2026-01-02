<?php
include_once(dirname(__FILE__, 3) . '/assets/models/access_controller.php');
include_once(dirname(__FILE__, 3) . '/assets/models/conn.php');
include_once(dirname(__FILE__, 3) . '/assets/models/assets.php');
include_once(dirname(__FILE__, 3) . '/assets/models/mInventory.php');

$user_id = $_SESSION["user_id"];
$user_role = $_SESSION["id_role"];

// Traitement des actions POST
$action_result = handleInventoryAction($pdo);
$success_message = $action_result['success'];
$error_message = $action_result['error'];

// Pagination
$items_per_page = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $items_per_page;

// Récupération des données
$total_items = countInventoryItems($pdo, $user_role, $user_id);
$total_pages = ceil($total_items / $items_per_page);
$objects = getInventoryItems($pdo, $user_role, $user_id, $items_per_page, $offset);
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
            <?php if ($success_message): ?>
                <p class="success"><?= htmlspecialchars($success_message) ?></p>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <p class="error"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>

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
                    <span class="col-status">Statut public</span>
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
                                <img class="inventory-image"
                                    src="<?= htmlspecialchars(getImage($obj['id_objet'])) ?>" alt="">
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
                                                                class="composante c<?= htmlspecialchars($h['id_composante'] ?? $obj['id_composante']) ?>"></span>
                                                            <span
                                                                class="timeline-date"><?= date('d/m/Y', strtotime($h['date_ajout'])) ?></span>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if ($obj["statut"] == "indisponible" && !in_array($_SESSION["id_role"], [1, 2])): ?>
                                        <form method="POST" action="" style="display: inline;"
                                            onclick="event.stopPropagation();">
                                            <input type="hidden" name="action" value="recycle">
                                            <input type="hidden" name="id_objet" value="<?= $obj['id_objet'] ?>">
                                            <button type="submit" class="button orange recycle-btn">Proposer l'objet au
                                                recyclage</button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if ($obj["statut"] == "disponible"): ?>
                                        <!-- le button s'affiche pour le président car il peut retirer un objet du recyclage -->
                                        <form method="POST" action="" style="display: inline;"
                                            onclick="event.stopPropagation();">
                                            <input type="hidden" name="action" value="unrecycle">
                                            <input type="hidden" name="id_objet" value="<?= $obj['id_objet'] ?>">
                                            <button type="submit" class="button blue recycle-btn">Retirer du recyclage</button>
                                        </form>
                                    <?php endif; ?>
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