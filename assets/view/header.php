<header>
    <a class="menu-button" id="menu-button">
        <span class="material-symbols-outlined">
            menu
        </span>
    </a>
    <a href="/">
        <img src="/assets/img/ecogestum-logo.png" alt="Logo de Le Mans Université">
    </a>
    <?php if (isset($_SESSION['user_id'])):
        if (!str_contains($_SERVER["REQUEST_URI"], "/panel")): ?>
            <form action="/search/" method="get" class="search-container">
                <button type="submit" class="icon">
                    <span class="material-symbols-outlined">
                        search
                    </span>
                </button>
                <input type="text" name="q" id="search" class="poppins" placeholder="Rechercher">
            </form>
            <img src="/assets/img/profile_pictures/default_profile_icon.jpg" alt="" style="border-radius: 50%"
                id="profile-button">
            <div class="modal" id="profile-modal" style="display: none">
                <a href="/profile/" class="link">Profil</a>
                <a href="/profile/loved/" class="link">Coups de coeur</a>
                <a href="/reservations/" class="link">Réservations</a>
                <a href="/event/" class="link">Événements</a>
                <a href="/press-releases/" class="link">Communiqués de presse</a>
                <a href="/messaging/" class="link">Messages</a>
                <?php if (in_array($_SESSION["id_role"], array(1, 2, 3, 4, 5))): ?>
                    <a href="/panel/" class="link">Panneau de configuration</a>
                <?php endif; ?>
                <?php if ($_SESSION["id_role"] == 6): ?>
                    <a href="/inventory/" class="link">Inventaire</a>
                <?php endif; ?>
                <a href="/logout/" class="link">Se déconnecter</a>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="nav-header">
            <a href="/event/" class="link">Événements</a>
            <a href="/press-releases/" class="link">Communiqués de presse</a>
            <a href="/login/" class="button">Se connecter</a>
        </div>
    <?php endif; ?>

    <script src="/assets/js/profile-modal.js"></script>
    <script src="/assets/js/menu-display.js"></script>
</header>