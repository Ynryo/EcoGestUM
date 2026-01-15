<?php
include_once(dirname(__FILE__, 2) . '/assets/models/access_controller.php');
include_once(dirname(__FILE__, 2) . '/assets/models/conn.php');
include_once(dirname(__FILE__, 2) . '/assets/models/mMessaging.php');

// Traitement des actions sur les notifications
if (isset($_GET['id']) && $_GET['id'] != null && isset($_GET['action']) && $_GET['action'] != null) {
    handleNotificationAction($pdo, $_SESSION["user_id"], $_GET['id'], $_GET['action']);
}

$results = getUserNotifications($pdo, $_SESSION["user_id"]);
?>
<?php include(dirname(__FILE__, 2) . '/assets/models/assets.php') ?>
<title>EcoGestUM - Messagerie</title>
<link rel="preload" fetchpriority="high" as="image" href="/assets/img/lmu-logo-for-titles.png" type="image/png">
<link rel="stylesheet" href="/assets/css/messaging.css">
<link rel="stylesheet" href="/assets/css/search.css">
</head>

<body>
    <?php include(dirname(__FILE__, 2) . '/assets/view/header.php') ?>
    <div class="main">
        <div class="ariane-link">
            <a href="/" class="link">Accueil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            <a href="/profile/" class="link">Profil</a>
            <span class="material-symbols-outlined">arrow_forward_ios</span>
            Messagerie
        </div>
        <div class="messaging-container">
            <?php if (!empty($results)) {
                foreach ($results as $result): ?>
                    <div class="msg-container">
                        <div class="top-content">
                            <div class="publisher">
                                <p><?= htmlspecialchars($result["titre_notification"]) ?></p>
                            </div>
                            <div class="timedate">
                                <span><?= htmlspecialchars($result["nom_emetteur"]) . " " . htmlspecialchars($result["prenom_emetteur"]) ?></span>
                                <span>&#x2022</span>
                                <span><?= htmlspecialchars(date_format(date_create($result["date_envoi"]), "d/m/Y")) ?></span>
                            </div>
                        </div>
                        <div class="messageButtons">
                            <a class="button blue"
                                href="/messaging/?id=<?php echo $result["id_notification"] ?>&action=accept">Accepter</a>
                            <a class="button orange secondary"
                                href="/messaging/?id=<?php echo $result["id_notification"] ?>&action=refuse">Refuser</a>
                        </div>
                    </div>
                <?php endforeach;
            } else { ?>
                <p>Aucun message trouvé.</p>
            <?php } ?>
        </div>
    </div>
    <?php include(dirname(__FILE__, 2) . '/assets/view/footer.php') ?>
</body>

</html>