<?php
include_once(dirname(__FILE__, 3) . '/assets/models/access_controller.php');
include_once(dirname(__FILE__, 3) . '/assets/models/conn.php');
?>
<?php include(dirname(__FILE__, 3) . '/assets/models/assets.php') ?>
<title>EcoGestUM - Inventaire</title>
<link rel="stylesheet" href="/assets/css/search.css">
<link rel="stylesheet" href="/assets/css/boxs.css">
<link rel="stylesheet" href="/assets/css/navbar.css">
</head>

<body>
    <?php include(dirname(__FILE__, 3) . '/assets/view/header.php') ?>
    <section class="main panel">
        <?php
        include(dirname(__FILE__, 3) . '/assets/models/navbar.php');
        include(dirname(__FILE__, 3) . '/assets/view/panel/navbar.php');
        ?>
        <div class="container">
            <h2>Bonjour <?= htmlspecialchars($_SESSION["user_name"]) ?> !</h2>
            <p>Bienvenue sur votre espace de gestion</p>
        </div>
    </section>

    <?php include(dirname(__FILE__, 3) . '/assets/view/footer.php') ?>
</body>

</html>