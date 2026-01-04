<?php
function isActive($button)
{
    $current_page = $_SERVER["REQUEST_URI"];

    // cas spécial pour la page d'accueil
    if ($button === "" && ($current_page === "/panel/" || $current_page === "/panel")) {
        return ' active';
    }

    if (str_contains($current_page, $button) && $button !== "") {
        return ' active';
    }
}

function hasPermission($button)
{
    $user_role = $_SESSION["id_role"];
    $permissions = [
        1 => ["inventory", "communications", "odds", "history", "add-user"],
        2 => ["inventory", "communications", "history"],
        3 => ["inventory", "communications", "history", "takeover"],
        4 => ["inventory", "communications", "history", "takeover"],
        5 => ["server", "inventory", "communications", "settings", "add-user"]
    ];

    return in_array($button, $permissions[$user_role] ?? []);
}