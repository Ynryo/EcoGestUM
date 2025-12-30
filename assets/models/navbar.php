<?php
function isActive($onglet)
{
    $admin_pages = ["", "server", "inventory", "communications", "settings", "odds", "history"];
    $current_page = str_replace("/", "", str_replace("/panel", "", $_SERVER["REQUEST_URI"]));

    if (in_array($onglet, $admin_pages) && $onglet === $current_page) {
        return ' active';
    }
}
