<div class="nav-panel">
    <a href="<?= $base_url ?>/index" class="nav-item<?= isActive('accueil', $currentPage); ?>">
        <span class="material-symbols-outlined">home</span>
        Accueil
    </a>

    <a href="<?= $base_url ?>/statistics" class="nav-item<?= isActive('statistiques', $currentPage); ?>">
        <span class="material-symbols-outlined">query_stats</span>
        Statistiques
    </a>

    <a href="<?= $base_url ?>/server" class="nav-item<?= isActive('serveur', $currentPage); ?>">
        <span class="material-symbols-outlined">dns</span>
        Serveur
    </a>

    <a href="<?= $base_url ?>/inventory" class="nav-item<?= isActive('inventaire', $currentPage); ?>">
        <span class="material-symbols-outlined">inventory</span>
        Inventaire
    </a>

    <a href="<?= $base_url ?>/communications" class="nav-item<?= isActive('communiques', $currentPage); ?>">
        <span class="material-symbols-outlined">campaign</span>
        Communiqués
    </a>

    <a href="<?= $base_url ?>/settings" class="nav-item<?= isActive('parametres', $currentPage); ?>">
        <span class="material-symbols-outlined">settings</span>
        Paramètres
    </a>

    <a href="<?= $base_url ?>/odds" class="nav-item<?= isActive('odd', $currentPage); ?>">
        <span class="material-symbols-outlined">lightbulb</span>
        17 ODD
    </a>

    <a href="<?= $base_url ?>/history" class="nav-item<?= isActive('historique', $currentPage); ?>">
        <span class="material-symbols-outlined">history</span>
        Historique
    </a>

    <a href="/logout/">
        <span class="material-symbols-outlined">logout</span>
        Se déconnecter
    </a>
</div>