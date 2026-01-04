<?php
include_once(dirname(__FILE__, 3) . '/assets/models/access_controller.php');
include_once(dirname(__FILE__, 3) . '/assets/models/conn.php');
include_once(dirname(__FILE__, 3) . '/assets/models/assets.php');
include_once(dirname(__FILE__, 3) . '/assets/models/mTakeover.php');

$user_id = $_SESSION["user_id"];
$user_role = $_SESSION["id_role"];

// Vérifier que l'utilisateur a accès (role 3 ou 4)
if (!in_array($user_role, [3, 4])) {
    header("Location: /panel/");
    exit;
}

// Traitement des actions
$action_result = handleTakeoverAction($pdo);
$success_message = $action_result['success'];
$error_message = $action_result['error'];

// Récupération des demandes
$requests = getTakeoverRequests($pdo, $user_role, $user_id);
?>
<title>EcoGestUM - Demandes de reprise</title>
<link rel="stylesheet" href="/assets/css/boxs.css">
<link rel="stylesheet" href="/assets/css/navbar.css">
<link rel="stylesheet" href="/assets/css/tables.css">
<link rel="stylesheet" href="/assets/css/takeover.css">
</head>

<body>
    <?php include(dirname(__FILE__, 3) . '/assets/view/header.php') ?>
    <section class="main panel">
        <?php
        include(dirname(__FILE__, 3) . '/assets/models/navbar.php');
        include(dirname(__FILE__, 3) . '/assets/view/panel/navbar.php');
        ?>
        <div class="container">
            <h2>Demandes de reprise</h2>
            <p class="takeover-subtitle">Objets en attente de validation</p>

            <?php if ($success_message): ?>
                <p class="success"><?= htmlspecialchars($success_message) ?></p>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <p class="error"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>

            <div class="takeover-table">
                <div class="takeover-table-header">
                    <span class="col-name">Nom de l'objet</span>
                    <span class="col-qty">Quantité</span>
                    <span class="col-date">Date demande</span>
                    <span class="col-repreneur">Repreneur</span>
                    <span class="col-sortie">Type sortie</span>
                    <span class="col-actions">Actions</span>
                </div>

                <?php if (empty($requests)): ?>
                    <div class="takeover-row no-data">
                        <span>Aucune demande en attente</span>
                    </div>
                <?php else: ?>
                    <?php foreach ($requests as $req):
                        $external_roles = [6, 7, 8];
                        $sortie_type = in_array($req['id_role'], $external_roles) ? 'externe' : 'interne';
                        ?>
                        <div class="takeover-row">
                            <span class="col-name"><?= htmlspecialchars($req['nom_objet']) ?></span>
                            <span class="col-qty"><?= htmlspecialchars($req['quantity']) ?></span>
                            <span class="col-date"><?= date('d/m/Y', strtotime($req['date_ajout'])) ?></span>
                            <span class="col-repreneur">
                                <?= htmlspecialchars($req['prenom_utilisateur'] . ' ' . $req['nom_utilisateur']) ?>
                                <span class="role r<?= $req['id_role'] ?>"></span>
                            </span>
                            <span class="col-sortie">
                                <span class="sortie-badge <?= $sortie_type ?>"></span>
                            </span>
                            <span class="col-actions">
                                <form method="POST" action="" style="display: inline;">
                                    <input type="hidden" name="action" value="accept">
                                    <input type="hidden" name="id_objet" value="<?= $req['id_objet'] ?>">
                                    <input type="hidden" name="id_donneur" value="<?= $req['id_donneur'] ?>">
                                    <input type="hidden" name="id_recepteur" value="<?= $req['id_recepteur'] ?>">
                                    <button type="submit" class="button green small">Accepter</button>
                                </form>
                                <form method="POST" action="" style="display: inline;">
                                    <input type="hidden" name="action" value="refuse">
                                    <input type="hidden" name="id_objet" value="<?= $req['id_objet'] ?>">
                                    <input type="hidden" name="id_donneur" value="<?= $req['id_donneur'] ?>">
                                    <input type="hidden" name="id_recepteur" value="<?= $req['id_recepteur'] ?>">
                                    <button type="submit" class="button red small">Refuser</button>
                                </form>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include(dirname(__FILE__, 3) . '/assets/view/footer.php') ?>
</body>

</html>