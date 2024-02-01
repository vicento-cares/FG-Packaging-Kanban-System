<?php
session_set_cookie_params(0, "/fg_packaging_debug");
session_name("fg-pkg-debug");
session_start();

unset($_SESSION['id_no']);
unset($_SESSION['requestor_name']);
unset($_SESSION['requestor']);
unset($_SESSION['section']);

if (!isset($_SESSION['username'])) {
	session_unset();
	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000,
	        $params["path"], $params["domain"],
	        $params["secure"], $params["httponly"]
	    );
	}
	session_destroy();
}

if(isset($_COOKIE['id_no'])) {
	$id_no = null;
	setcookie('id_no', $id_no, 0, "/fg_packaging_debug");
}
if(isset($_COOKIE['requestor_name'])) {
	$requestor_name = null;
	setcookie('requestor_name', $requestor_name, 0, "/fg_packaging_debug");
}
if(isset($_COOKIE['requestor'])) {
	$requestor = null;
	setcookie('requestor', $requestor, 0, "/fg_packaging_debug");
}
if(isset($_COOKIE['request_id'])) {
	$request_id = null;
	setcookie('request_id', $request_id, 0, "/fg_packaging_debug");
}

header('location:../../');
?>