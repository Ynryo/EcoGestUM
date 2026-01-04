<?php
session_start();

//for block access to non authenticated users (they only can access to /, /login, /register and /logout)
if (!isset($_SESSION["user_id"]) && $_SERVER["REQUEST_URI"] !== "/" && $_SERVER["REQUEST_URI"] !== "/login/" && $_SERVER["REQUEST_URI"] !== "/register/" && $_SERVER["REQUEST_URI"] !== "/logout/" && $_SERVER["REQUEST_URI"] !== "/press-releases/" && $_SERVER["REQUEST_URI"] !== "/event/") { //si pas de session et URL != /, redirect to /
    header("Location: /");
}

//for block access to non admin users to admin pages
$admin_pages = ["", "statistics", "server", "inventory", "communications", "settings", "odds", "history", "add-user", "takeover"];
$current_page = str_replace("/", "", str_replace("/panel", "", $_SERVER["REQUEST_URI"]));

if (isset($_SESSION["id_role"]) && in_array($current_page, $admin_pages) && str_contains($_SERVER["REQUEST_URI"], "/panel")) {
    if (!in_array($_SESSION["id_role"], array(1, 2, 3, 4, 5))) {
        header("Location: /");
    }
}