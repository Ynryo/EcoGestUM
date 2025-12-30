<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EcoGestUM</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(dirname(__FILE__, 3) . '/assets/models/assets.php') ?>
    <link rel="preload" fetchpriority="high" as="image" href="/assets/img/landing-page-background.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/landing-page.css">
    <link rel="stylesheet" href="/assets/css/press-releases.css">
    <link rel="stylesheet" href="/assets/css/search.css">
    <link rel="stylesheet" href="/assets/css/boxs.css">
</head>

<body>
    <?php include(dirname(__FILE__, 3) . '/assets/view/header.php'); ?>
    <section class="top-container">
        <div class="top-content">
            <div>
                <h3 class="poppins">EcoGestUM</h3>
                <h3 class="poppins">Le service de recyclage <em>made in</em></h3>
                <h1 class="title">Le Mans Université</h1>
                <a href="/login/" class="button">Rejoindre</a>
            </div>
        </div>
    </section>
    <section class="keynums">
        <div class="blue-bg">
            <?php
            include(dirname(__FILE__, 3) . '/assets/models/conn.php');
            $stmt = $pdo->prepare("SELECT sum(nb_recyclages) as 'nb_recyclages' FROM statistique;");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <h1><?php echo $result['nb_recyclages'] ?></h1>
            <p>objets déjà recyclés</p>
        </div>
        <div class="red-bg">
            <?php
            $stmt = $pdo->prepare("SELECT count(id_objet) as 'nb_objet' FROM objet;");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <h1><?php echo $result['nb_objet'] ?></h1>
            <p>objets disponibles actuellement</p>
        </div>
        <div class="green-bg">
            <h1>19.058</h1>
            <p>tonnes équivalent CO2 économisés chaque année</p>
        </div>
    </section>
    <section class="they-speak">
        <h3>Ils parlent de nous</h3>
        <div class="cards-container">
            <!-- A faire en php -->
            <div class="card">
                <img src="/assets/img/portraits/theo.png" alt="Portrait de Théo">
                <div>
                    <h4>Théo M., étudiant à l’ENSIM</h4>
                    <p>Le concept de EcoGestUM est incroyable. Il m'a permis de donner mon ordinateur à une autre
                        personne au lieu de le jeter.</p>
                </div>
            </div>
            <div class="card">
                <img src="/assets/img/portraits/jade.png" alt="Portrait de Jade">
                <div>
                    <h4>Jade, enseignante en Fac de Droit</h4>
                    <p>Grâce à EcoGestUM, j’ai pu récupérer du matériel pédagogique pour mes cours, tout en participant
                        à une démarche écoresponsable.</p>
                </div>
            </div>
            <div class="card">
                <img src="/assets/img/portraits/romain.png" alt="Portrait de Romain">
                <div>
                    <h4>Romain, étudiant en Fac de Sciences</h4>
                    <p>Je trouve l’application très intuitive, et elle facilite vraiment le tri et la réutilisation des
                        objets à l’université.</p>
                </div>
            </div>
            <div class="card">
                <img src="/assets/img/portraits/ines.png" alt="Portrait de Inès">
                <div>
                    <h4>Inès, étudiante à l’IUT de Laval</h4>
                    <p>J'ai été ravi de pouvoir proposer des livres que je n'utilisais plus à d'autres étudiants, le
                        tout via EcoGestUM.</p>
                </div>
            </div>
            <div class="card">
                <img src="/assets/img/portraits/thomas.png" alt="Portrait de Thomas">
                <div>
                    <h4>Thomas, étudiant à l’ENSIM</h4>
                    <p>C'est une belle initiative pour limiter le gaspillage et encourager la mutualisation des
                        ressources sur le campus.</p>
                </div>
            </div>
            <div class="card">
                <img src="/assets/img/portraits/lea.png" alt="Portrait de Léa">
                <div>
                    <h4>Léa, étudiante en Fac de Lettres</h4>
                    <p>EcoGestUM m'a aidé à trouver un équipement sportif en très bon état, tout en faisant un geste
                        pour l’environnement.</p>
                </div>
            </div>
            <div class="card">
                <img src="/assets/img/portraits/maxime.png" alt="Portrait de Maxime">
                <div>
                    <h4>Maxime, enseignant à l’IUT du Mans</h4>
                    <p>J’apprécie le fait qu’EcoGestUM propose une alternative durable pour se débarrasser de ses
                        affaires, tout en favorisant les échanges entre membres de la communauté universitaire.</p>
                </div>
            </div>
        </div>
        <div class="carrousel-controller">
            <a href="#" class="button">
                <span class="material-symbols-outlined">
                    arrow_back
                </span>
            </a>
            <a href="#" class="button">
                <span class="material-symbols-outlined">
                    arrow_forward
                </span>
            </a>
        </div>
    </section>
    <section class="press-releases">
        <h2>Communiqués de la direction de l’Université</h2>
        <?php
        include(dirname(__FILE__, 3) . '/assets/models/conn.php');

        $stmt = $pdo->prepare("SELECT c.titre_communique, c.contenu, c.cat_communique, c.date_publication, u.prenom_utilisateur, u.nom_utilisateur, u.id_role FROM communique c JOIN utilisateur u ON c.id_utilisateur = u.id_utilisateur ORDER BY c.date_publication ASC LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="pr-container alone">
            <div class="top-content">
                <div class="publisher">
                    <h3><?= htmlspecialchars($result["prenom_utilisateur"]) . " " . htmlspecialchars($result["nom_utilisateur"]) ?>
                    </h3>
                    <span class="role r<?= htmlspecialchars($result["id_role"]) ?>"></span>
                </div>
                <div class="timedate">
                    <span><?= htmlspecialchars(date_format(date_create($result["date_publication"]), "d/m/Y")) ?></span>
                    <span>&#x2022</span>
                    <span><?= htmlspecialchars(date_format(date_create($result["date_publication"]), "H:i")) ?></span>
                </div>
            </div>
            <div class="content">
                <?= strip_tags($result["contenu"], "<br>") ?>
            </div>
        </div>
        <a href="/press-releases/" class="button">Voir plus de communiqués</a>
    </section>

    <?php include(dirname(__FILE__, 3) . '/assets/view/footer.php'); ?>
</body>

</html>