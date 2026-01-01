<?php
function isActive($onglet)
{
    $admin_pages = ["", "statistics", "server", "inventory", "communications", "settings", "odds", "history", "add-user"];
    $current_page = str_replace("/", "", str_replace("/panel", "", $_SERVER["REQUEST_URI"]));

    if (in_array($onglet, $admin_pages) && $onglet === $current_page) {
        return ' active';
    }
}

function hasPermission($onglet)
{
    $user_role = $_SESSION["id_role"];
    $permissions = [
        1 => ["inventory", "communications", "odds", "history", "add-user"],
        2 => ["inventory", "communications", "history"],
        3 => ["inventory", "communications", "history"],
        4 => ["inventory", "communications", "history"],
        5 => ["server", "inventory", "communications", "settings", "add-user"]
    ];

    return in_array($onglet, $permissions[$user_role] ?? []);
}