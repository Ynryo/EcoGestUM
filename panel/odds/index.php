<?php
include_once(dirname(__FILE__, 3) . "/assets/models/access_controller.php");
include_once(dirname(__FILE__, 3) . "/assets/models/assets.php");
include_once(dirname(__FILE__, 3) . "/assets/models/conn.php");
include_once(dirname(__FILE__, 3) . "/assets/models/mOdds.php");

$odds = getAllOdds($pdo);
?>
<title>EcoGestUM - 17 ODD</title>
<link rel="stylesheet" href="/assets/css/boxs.css">
<link rel="stylesheet" href="/assets/css/navbar.css">
<link rel="stylesheet" href="/assets/css/tables.css">
<link rel="stylesheet" href="/assets/css/odds.css">
</head>

<body>
    <?php include(dirname(__FILE__, 3) . "/assets/view/header.php") ?>
    <section class="main panel">
        <?php
        include(dirname(__FILE__, 3) . "/assets/models/navbar.php");
        include(dirname(__FILE__, 3) . "/assets/view/panel/navbar.php");
        ?>
        <div class="container">
            <h2>17 Objectifs de Développement Durable</h2>

            <div class="odd-table">
                <div class="odd-table-header">
                    <span class="col-num">Numéro de l'ODD</span>
                    <span class="col-name">Nom</span>
                    <span class="col-status">Respect de l'ODD</span>
                    <span class="col-arrow"></span>
                </div>

                <?php foreach ($odds as $odd):
                    $odd_number = extractOddNumber($odd['num_odd']);
                    $odd_image_url = getOddImageUrl($odd_number);
                    ?>
                    <div class="odd-row" onclick="toggleRow(this)">
                        <div class="odd-row-header">
                            <span class="col-num"><?= $odd_number ?></span>
                            <span class="col-name"><?= htmlspecialchars($odd['titre_odd']) ?></span>
                            <span class="col-status">
                                <span class="status non"></span>
                            </span>
                            <span class="col-arrow">
                                <span class="material-symbols-outlined arrow-icon">expand_more</span>
                            </span>
                        </div>
                        <div class="odd-row-content">
                            <div class="odd-detail">
                                <div class="odd-image">
                                    <img src="<?= $odd_image_url ?>" alt="<?= htmlspecialchars($odd['num_odd']) ?>">
                                </div>
                                <div class="odd-info">
                                    <h3><?= htmlspecialchars($odd['titre_odd']) ?></h3>
                                    <p><?= nl2br(htmlspecialchars($odd['desc_odd'])) ?></p>
                                    <a href="<?= htmlspecialchars($odd['link_odd']) ?>" target="_blank"
                                        class="link-voir-plus">
                                        Voir plus <span class="material-symbols-outlined">open_in_new</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include(dirname(__FILE__, 3) . "/assets/view/footer.php") ?>

    <script>
        function toggleRow(row) {
            row.classList.toggle('expanded');
        }
    </script>
</body>

</html>