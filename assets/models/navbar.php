<?php
function isActive($currentPage)
{
    $pages = [
    "accueil" => "/panel/",
    'statistiques' => '/panel/statistics',
    'serveur' => '/panel/server',
    'inventaire' => '/panel/inventory',
    'communiques' => '/panel/communications',
    'parametres' => '/panel/settings',
    'odd' => '/panel/odds',
    'historique' => '/panel/history',
];

    if ($pages[$currentPage] === $_SERVER["REQUEST_URI"]) {
        return ' active';
    }
}