<header>
    <a class="menu-button" id="menu-button">
        <span class="material-symbols-outlined">
            menu
        </span>
    </a>
    <a href="/">
        <img src="/assets/img/ecogestum-logo.png" alt="Logo de Le Mans Université">
    </a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="/search/" method="get" class="search-container">
            <button type="submit" class="icon">
                <span class="material-symbols-outlined">
                    search
                </span>
            </button>
            <input type="text" name="q" id="search" class="poppins" placeholder="Rechercher">
        </form>
        <img src="/assets/img/profile_pictures/1.jpg" alt="" style="border-radius: 50%" id="profile-button">
        <div class="modal" id="profile-modal" style="display: none">
            <a href="/profile/" class="link">Profil</a>
            <a href="/event/" class="link">Événements</a>
            <a href="/press-releases/" class="link">Communiqués de presse</a>
            <!-- <a href="/messages/" class="link">Messages</a> -->
            <?php if (str_contains(json_encode([1, 2, 3, 4, 5, 6]), $_SESSION["id_role"])): ?>
                <a href="/panel/" class="link">Panel de gestion</a>
            <?php endif; ?>
            <a href="/profile/loved/" class="link">Coups de coeur</a>
            <a href="/logout/" class="link">Se déconnecter</a>
        </div>
    <?php else: ?>
        <div class="nav-header">
            <a href="/event/" class="link">Événements</a>
            <a href="/press-releases/" class="link">Communiqués de presse</a>
            <a href="/login/" class="button">Se connecter</a>
        </div>
    <?php endif; ?>




    <!-- téléphone -->
    <!-- <div class="side-menu" id="side-menu">
        <a class="close-button" id="close-button">
            <span class="material-symbols-outlined">
                close
            </span>
        </a>
        <a href="/">
            <img src="/assets/img/ecogestum-logo.png" alt="Logo de Le Mans Université">
        </a>

        <?php if (isset($_SESSION['user'])): ?>
            <a href="/logout/" class="button">Se déconnecter</a>
        <?php else: ?>
            <a href="/login/" class="button">Se connecter</a>
        <?php endif; ?>
    </div> -->

    <script src="/assets/js/profile-modal.js"></script>
    <script src="/assets/js/menu-display.js"></script>
</header>