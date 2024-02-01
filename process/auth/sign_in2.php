<?php
session_set_cookie_params(0, "/fg_packaging_debug");
session_name("fg-pkg-debug");
session_start();

require('../db/conn.php');
require('../lib/main.php');

// Check Section of Requestor
function check_section_requestor($id_no, $ip, $conn) {
	$section = check_ip_section($ip, $conn);
	if (!empty($section)) {
		$sql = "SELECT `id` FROM `requestor_account` WHERE id_no = ? AND section = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($id_no, $section);
		$stmt -> execute($params);
		if ($stmt -> rowCount() > 0) {
			return 'success';
		} else {
			return 'Wrong Section';
		}
	} else {
		return 'Not Section';
	}
}

if (!isset($_POST['id_no']) && !isset($_POST['ip'])) {
	echo 'not set';
} else if (empty($_POST['id_no']) || empty($_POST['ip'])) {
	echo 'empty';
} else {
	$id_no = $_POST['id_no'];
	$ip = $_POST['ip'];
	$requestor_name = '';
	$requestor = '';
	$check_section_requestor = '';

	$sql = "SELECT `id_no`, `name`, `requestor` FROM `requestor_account` WHERE id_no = BINARY convert(? using utf8mb4) collate utf8mb4_bin";
	$stmt = $conn -> prepare($sql);
	$params = array($id_no);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$requestor_name = $row['name'];
			$requestor = $row['requestor'];
		}
		// Check Section of Requestor
		$check_section_requestor = check_section_requestor($id_no, $ip, $conn);
		if ($check_section_requestor == 'Wrong Section') {
			echo 'Wrong Section';
		} else if ($check_section_requestor == 'Not Section') {
			echo 'Not Section';
		} else if ($check_section_requestor == 'success') {
			$_SESSION['id_no'] = $id_no;
			$_SESSION['requestor_name'] = $requestor_name;
			$_SESSION['requestor'] = $requestor;
			setcookie('id_no', $id_no, 0, "/fg_packaging_debug");
			setcookie('requestor_name', $requestor_name, 0, "/fg_packaging_debug");
			setcookie('requestor', $requestor, 0, "/fg_packaging_debug");
			echo 'success';
		} else {
			echo $check_section_requestor;
		}
	} else {
		echo 'failed';
	}
}

$conn = null;
?>