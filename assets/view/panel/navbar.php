<div class="nav-panel">
    <a href="/panel/" class="nav-item<?= isActive(""); ?>">
        <span class="material-symbols-outlined">home</span>
        Accueil
    </a>

    <a href="/panel/statistics" class="nav-item<?= isActive("statistics"); ?>">
        <span class="material-symbols-outlined">query_stats</span>
        Statistiques
    </a>
    
    <?php if (hasPermission("server")): ?>
    <a href="/panel/server" class="nav-item<?= isActive("server"); ?>">
        <span class="material-symbols-outlined">dns</span>
        Serveur
    </a>
    <?php endif; ?>

    <?php if (hasPermission("inventory")): ?>
    <a href="/panel/inventory" class="nav-item<?= isActive("inventory"); ?>">
        <span class="material-symbols-outlined">inventory</span>
        Inventaire
    </a>
    <?php endif; ?>

    <?php if (hasPermission("communications")): ?>
    <a href="/panel/communications" class="nav-item<?= isActive("communications"); ?>">
        <span class="material-symbols-outlined">campaign</span>
        Communiqués
    </a>
    <?php endif; ?>

    <?php if (hasPermission("settings")): ?>
    <a href="/panel/settings" class="nav-item<?= isActive("settings"); ?>">
        <span class="material-symbols-outlined">settings</span>
        Paramètres
    </a>
    <?php endif; ?>

    <?php if (hasPermission("odds")): ?>
    <a href="/panel/odds" class="nav-item<?= isActive("odds"); ?>">
        <span class="material-symbols-outlined">nature</span>
        17 ODD
    </a>
    <?php endif; ?>

    <?php if (hasPermission("add-user")): ?>
    <a href="/panel/add-user" class="nav-item<?= isActive("add-user"); ?>">
        <span class="material-symbols-outlined">person_add</span>
        Ajouter un utilisateur
    </a>
    <?php endif; ?>

    <?php if (hasPermission("history")): ?>
    <a href="/panel/history" class="nav-item<?= isActive("history"); ?>">
        <span class="material-symbols-outlined">history</span>
        Historique
    </a>
    <?php endif; ?>

    <a href="/logout/">
        <span class="material-symbols-outlined">logout</span>
        Se déconnecter
    </a>
</div>