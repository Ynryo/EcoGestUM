<div class="nav-panel">
    <a href="/panel/" class="nav-item<?= isActive('accueil'); ?>">
        <span class="material-symbols-outlined">home</span>
        Accueil
    </a>

    <a href="/panel/statistics" class="nav-item<?= isActive('statistiques'); ?>">
        <span class="material-symbols-outlined">query_stats</span>
        Statistiques
    </a>

    <a href="/panel/server" class="nav-item<?= isActive('serveur'); ?>">
        <span class="material-symbols-outlined">dns</span>
        Serveur
    </a>

    <a href="/panel/inventory" class="nav-item<?= isActive('inventaire'); ?>">
        <span class="material-symbols-outlined">inventory</span>
        Inventaire
    </a>

    <a href="/panel/communications" class="nav-item<?= isActive('communiques'); ?>">
        <span class="material-symbols-outlined">campaign</span>
        Communiqués
    </a>

    <a href="/panel/settings" class="nav-item<?= isActive('parametres'); ?>">
        <span class="material-symbols-outlined">settings</span>
        Paramètres
    </a>

    <a href="/panel/odds" class="nav-item<?= isActive('odd'); ?>">
        <span class="material-symbols-outlined">lightbulb</span>
        17 ODD
    </a>

    <a href="/panel/history" class="nav-item<?= isActive('historique'); ?>">
        <span class="material-symbols-outlined">history</span>
        Historique
    </a>

    <a href="/logout/">
        <span class="material-symbols-outlined">logout</span>
        Se déconnecter
    </a>
</div>