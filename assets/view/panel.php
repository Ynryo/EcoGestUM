<?php
// Ensure variables are set (Controller should provide these)
$current_user = $_SESSION["user"] ?? [];
$userName = $current_user["nom_utilisateur"] ?? "Inconnu";
$userRole = $current_user["id_role"] ?? 1;

// Fallback for direct access (though Controller protects this)
if (empty($current_user)) {
    header('Location: /login/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoGestUM | <?= htmlspecialchars($pageTitle ?? 'Panel') ?></title>

    <?php include(dirname(__FILE__, 3) . '/assets/src/assets.php') ?>

    <link rel="stylesheet" href="/assets/css/globals.css">
    <link rel="stylesheet" href="/assets/css/panel.css">
    <link rel="stylesheet" href="/assets/css/search.css">
    <link rel="stylesheet" href="/assets/css/boxs.css">
    <link rel="stylesheet" href="/assets/css/nav-panel.css">
    <link rel="stylesheet" href="/assets/css/profile.css">
</head>

<body>
    <header>
        <a class="menu-button" id="menu-button">
            <span class="material-symbols-outlined">menu</span>
        </a>
        <a href="/">
            <img src="/assets/img/ecogestum-logo.png" alt="Logo de Le Mans Université">
        </a>
    </header>

    <div class="dashboard-container">
        <?php include(dirname(__FILE__, 3) . '/assets/view/panel/navbar.php') ?>

        <main class="content-area">
            <?php if ($currentPage === 'accueil'): ?>
                <!-- Accueil Dashboard -->
                <div class="card-container">
                    <div class="dashboard-header">
                        <h1 class="goia">Bonjour <?= htmlspecialchars($current_user["prenom_utilisateur"] ?? '') ?> !</h1>
                    </div>
                    <div class="welcome-section">
                        <h3 class="welcome-title">Bienvenue sur votre espace</h3>
                        <div class="role r<?= htmlspecialchars($userRole) ?>"></div>
                    </div>

                    <div class="card stats">
                        <h4 class="card-title">Objets recyclés ce mois-ci</h4>
                        <div class="number">
                            <?= $objets_recycles ?? 0 ?>
                            <span class="material-symbols-outlined arrow-up">arrow_upward</span>
                        </div>
                        <p class="card-text">
                            18 de plus que le mois dernier
                        </p>
                    </div>

                    <div class="card stats">
                        <h4 class="card-title">Nouveaux objets enregistrés ce mois-ci</h4>
                        <div class="number">
                            <?= $nouveaux_objets ?? 0 ?>
                            <span class="material-symbols-outlined arrow-down">arrow_downward</span>
                        </div>
                        <p class="card-text">
                            9 de moins que le mois dernier
                        </p>
                    </div>

                    <div class="card most-active-composante">
                        <h4 style="color: var(--dark);">Composante la plus active</h4>
                        <div class="composante-container">
                            <span class="composante c2"></span>
                        </div>
                        <p class="card-text">
                            <?= $objets_recycles_composante ?? 0 ?> objets recyclés ce mois ci
                            <span class="material-symbols-outlined arrow-up arrow-icon-small">arrow_upward</span>
                        </p>
                    </div>
                </div>

                <div class="card inventory-resume">
                    <h2>Demandes de publications</h2>
                    <table>
                        <thead>
                            <tr>
                                <th class="col-name">Nom</th>
                                <th class="col-qty">Quantité</th>
                                <th class="col-comp">Composante</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rowCount = 0;
                            if (!empty($demandes)) {
                                foreach ($demandes as $demande) {
                                    if ($rowCount >= 4)
                                        break;
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
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php if (count($demandes ?? []) > 4) { ?>
                        <div class="footer text-center">
                            <a href="<?= $base_url ?>/inventory" class="btn btn-primary btn-sm">
                                Voir plus de demandes (<?= count($demandes) ?> au total)
                            </a>
                        </div>
                    <?php } ?>
                </div>

            <?php elseif ($currentPage === 'statistiques'): ?>
                <!-- Statistiques View -->
                <div class="card-container">
                    <div class="dashboard-header">
                        <h1 class="goia">Statistiques</h1>
                    </div>
                    <div class="welcome-section">
                        <h3 class="welcome-title">Vue d'ensemble des statistiques</h3>
                        <div class="role r<?= htmlspecialchars($userRole) ?>"></div>
                    </div>

                    <div class="card stats">
                        <h4 class="card-title">Objets recyclés ce mois-ci</h4>
                        <div class="number">
                            <?= $objets_recycles ?? 0 ?>
                            <span class="material-symbols-outlined arrow-up">arrow_upward</span>
                        </div>
                        <p class="card-text">
                            18 de plus que le mois dernier
                        </p>
                    </div>

                    <div class="card stats">
                        <h4 class="card-title">Nouveaux objets enregistrés ce mois-ci</h4>
                        <div class="number">
                            <?= $nouveaux_objets ?? 0 ?>
                            <span class="material-symbols-outlined arrow-down">arrow_downward</span>
                        </div>
                        <p class="card-text">
                            9 de moins que le mois dernier
                        </p>
                    </div>

                    <div class="card most-active-composante">
                        <h4 style="color: var(--dark);">Composante la plus active</h4>
                        <div class="composante-container">
                            <span class="composante c2"></span>
                        </div>
                        <p class="card-text">
                            <?= $objets_recycles_composante ?? 0 ?> objets recyclés ce mois ci
                            <span class="material-symbols-outlined arrow-up arrow-icon-small">arrow_upward</span>
                        </p>
                    </div>

                    <div class="card graph-box pie-chart-container">
                        <div>
                            <h3 style="color: var(--dark); margin-bottom: 15px;">Répartition des recyclages par composante
                                de l'université</h3>
                            <div style="width: 250px; height: 250px;">
                                <canvas id="pieChart"></canvas>
                            </div>
                        </div>

                        <div class="legend-box">
                            <h4 class="legend-title">Légende</h4>
                            <div class="legend-items">
                                <div class="legend-item"><span class="legend-item-dot"
                                        style="background-color: #f7b760;"></span> IUT Le Mans</div>
                                <div class="legend-item"><span class="legend-item-dot"
                                        style="background-color: #9d3363;"></span> IUT Laval</div>
                                <div class="legend-item"><span class="legend-item-dot"
                                        style="background-color: #457b9d;"></span> ENSIM</div>
                                <div class="legend-item"><span class="legend-item-dot"
                                        style="background-color: #546b8b;"></span> F. Lettres, Langues & SH</div>
                                <div class="legend-item"><span class="legend-item-dot"
                                        style="background-color: #e63946;"></span> F. Droit, Sc. Éco & Gestion</div>
                                <div class="legend-item"><span class="legend-item-dot"
                                        style="background-color: #4cc9f0;"></span> F. Sciences & Techniques</div>
                            </div>
                        </div>
                    </div>

                    <div class="card graph-box line-graph-container">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
                <script src="assets/js/chart.js"></script>

            <?php elseif ($currentPage === 'inventaire'): ?>
                <!-- Inventaire View -->
                <div class="card inventory-resume">
                    <h2>Demandes de publications</h2>
                    <table>
                        <thead>
                            <tr>
                                <th class="col-name">Nom</th>
                                <th class="col-qty">Quantité</th>
                                <th class="col-comp">Composante</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($demandes)) {
                                foreach ($demandes as $demande):
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
                                endforeach;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif ($currentPage === 'communiques'): ?>
                <!-- Communiques View -->
                <h2>Publier un communiqué</h2>
                <div class="input-group">
                    <label class="label-text" for="identifiant">Titre *</label>
                    <!-- Input would go here, preserved from original which cut off -->
                </div>

            <?php endif; ?>
        </main>
    </div>
</body>

</html>