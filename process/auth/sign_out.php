<?php
session_set_cookie_params(0, "/fg_packaging_debug");
session_name("fg-pkg-debug");
session_start();

unset($_SESSION['username']);
unset($_SESSION['name']);
unset($_SESSION['role']);

if (!isset($_SESSION['id_no'])) {
    session_unset();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
}

if (isset($_COOKIE['name'])) {
    $name = null;
    setcookie('name', $name, 0, "/fg_packaging_debug");
}
if (isset($_COOKIE['role'])) {
    $role = null;
    setcookie('role', $role, 0, "/fg_packaging_debug");
}

header('location:../../admin/');
