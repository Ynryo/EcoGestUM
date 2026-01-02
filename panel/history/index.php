<?php
include_once(dirname(__FILE__, 3) . '/assets/models/access_controller.php');
include_once(dirname(__FILE__, 3) . '/assets/models/conn.php');
include_once(dirname(__FILE__, 3) . '/assets/models/assets.php');
include_once(dirname(__FILE__, 3) . '/assets/models/mHistory.php');

$user_id = $_SESSION["user_id"];
$user_role = $_SESSION["id_role"];

// Pagination
$items_per_page = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $items_per_page;

// Récupération des données
$total_items = countHistoryItems($pdo, $user_role, $user_id);
$total_pages = ceil($total_items / $items_per_page);
$transactions = getHistoryItems($pdo, $user_role, $user_id, $items_per_page, $offset);
?>
<title>EcoGestUM - Historique</title>
<link rel="stylesheet" href="/assets/css/boxs.css">
<link rel="stylesheet" href="/assets/css/navbar.css">
<link rel="stylesheet" href="/assets/css/tables.css">
<link rel="stylesheet" href="/assets/css/history.css">
</head>

<body>
    <?php include(dirname(__FILE__, 3) . '/assets/view/header.php') ?>
    <section class="main panel">
        <?php
        include(dirname(__FILE__, 3) . '/assets/models/navbar.php');
        include(dirname(__FILE__, 3) . '/assets/view/panel/navbar.php');
        ?>
        <div class="container">
            <h2>Historique</h2>
            <p class="history-count">Affichage de <?= $offset + 1 ?> à
                <?= min($offset + $items_per_page, $total_items) ?> sur <?= $total_items ?> lignes
            </p>

            <div class="history-table">
                <div class="history-table-header">
                    <span class="col-name">Nom de l'objet</span>
                    <span class="col-qty">Quantité</span>
                    <span class="col-date">Date</span>
                    <span class="col-recycleur">Recycleur</span>
                    <span class="col-repreneur">Repreneur</span>
                    <span class="col-sortie">Sortie</span>
                </div>

                <?php if (empty($transactions)): ?>
                    <div class="history-row">
                        <div class="history-row-content no-data">
                            Aucune transaction enregistrée
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($transactions as $trans):
                        $sortie_type = getSortieType($trans['id_role']);
                        ?>
                        <div class="history-row">
                            <span class="col-name"><?= htmlspecialchars($trans['nom_objet']) ?></span>
                            <span class="col-qty"><?= htmlspecialchars($trans['quantity']) ?></span>
                            <span class="col-date"><?= date('d/m/Y', strtotime($trans['date_ajout'])) ?></span>
                            <span class="col-recycleur">
                                <span class="composante c<?= htmlspecialchars($trans['id_composante']) ?>"></span>
                            </span>
                            <span class="col-repreneur">
                                <?= htmlspecialchars($trans['prenom_utilisateur'] . ' ' . $trans['nom_utilisateur']) ?>
                                <span class="role r<?= $trans['id_role'] ?>"></span>
                            </span>
                            <span class="col-sortie">
                                <span class="sortie-badge <?= $sortie_type ?>"></span>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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
</body>

</html>