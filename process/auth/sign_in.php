<?php
session_set_cookie_params(0, "/fg_packaging_debug");
session_name("fg-pkg-debug");
session_start();

require('../db/conn.php');

if (!isset($_POST['username']) && !isset($_POST['password'])) {
	echo 'not set';
} else if (empty($_POST['username']) || empty($_POST['password'])) {
	echo 'empty';
} else {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql = "SELECT username, name, role FROM account WHERE username = BINARY convert(? using utf8mb4) collate utf8mb4_bin AND password = BINARY convert(? using utf8mb4) collate utf8mb4_bin";
	$stmt = $conn -> prepare($sql);
	$params = array($username, $password);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$_SESSION['username'] = $row['username'];
			$_SESSION['name'] = $row['name'];
			$_SESSION['role'] = $row['role'];
		}
		setcookie('name', $_SESSION['name'], 0, "/fg_packaging_debug");
		setcookie('role', $_SESSION['role'], 0, "/fg_packaging_debug");
		echo 'success';
	} else {
		echo 'failed';
	}
}

$conn = null;
?>