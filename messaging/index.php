<?php
include(dirname(__FILE__, 2) . '/assets/src/files_header.php');
include(dirname(__FILE__, 2) . '/assets/src/conn.php');

if (isset($_GET['id']) && $_GET['id'] != null) {
    if (isset($_GET['action']) && $_GET['action'] != null) {
            $stmt = $pdo->prepare("SELECT * FROM NOTIFICATION WHERE id_recepteur = :u AND id_notification = :n");
            $stmt->bindParam(':u', $_SESSION["user_id"]);
            $stmt->bindParam(':n', $_GET['id']);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!empty($results)) {
                switch ($_GET['action']) {
                    case "refuse": // Effacer la notif
                        $stmt = $pdo->prepare("DELETE FROM notification WHERE id_notification = :n");
                        $stmt->bindParam(':n', $_GET['id']);
                        $stmt->execute();
                        break;
                    case "accept": // Effacer la notif puis envoyer un (faux) mail
                        $stmt = $pdo->prepare("DELETE FROM notification WHERE id_notification = :n");
                        $stmt->bindParam(':n', $_GET['id']);
                        $stmt->execute();
                        break;
                    default:
                    // Erreur peut-être?
                }
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM - Messagerie</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" fetchpriority="high" as="image" href="/assets/img/lmu-logo-for-titles.png" type="image/png">
    <?php include(dirname(__FILE__, 2) . '/assets/src/assets.php') ?>
    <link rel="stylesheet" href="/assets/css/messaging.css">
    <link rel="stylesheet" href="/assets/css/search.css">
</head>

<body>
    <?php include(dirname(__FILE__, 2) . '/assets/view/header.php') ?>

        <div class="main">
            <?php
            $stmt = $pdo->prepare("SELECT id_notification, titre_notification, date_envoi, id_emetteur, u1.nom_utilisateur as 'nom_emetteur', u1.prenom_utilisateur as 'prenom_emetteur', id_recepteur, u2.nom_utilisateur as 'nom_recepteur', u2.prenom_utilisateur as 'prenom_recepteur' FROM notification JOIN utilisateur u1 ON notification.id_emetteur = u1.id_utilisateur JOIN utilisateur u2 ON notification.id_recepteur = u2.id_utilisateur WHERE id_recepteur = :u;");
            $stmt->bindParam(':u', $_SESSION["user_id"]);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($results)) {
                foreach ($results as $result): ?>
                <div class="msg-container">
                    <div class="top-content">
                        <div class="publisher">
                            <p><?= htmlspecialchars($result["titre_notification"])?></p>
                        </div>
                        <div class="timedate">
                            <span><?= htmlspecialchars($result["nom_emetteur"]) . " " . htmlspecialchars($result["prenom_emetteur"]) ?></span>
                            <span>&#x2022</span>
                            <span><?= htmlspecialchars(date_format(date_create($result["date_envoi"]), "d/m/Y")) ?></span>
                        </div>
                    </div>
                    <div class="messageButtons">
                        <a class="button blue" href="/messaging/?id=<?php echo $result["id_notification"] ?>&action=accept">Accepter</a>
                        <a class="button orange secondary" href="/messaging/?id=<?php echo $result["id_notification"] ?>&action=refuse">Refuser</a>
                    </div>
                </div>
            <?php endforeach; } else { ?>
                <p>Aucun message trouvé.</p>
            <?php } ?>
        </div>
    <?php include(dirname(__FILE__, 2) . '/assets/view/footer.php') ?>
</body>

</html>