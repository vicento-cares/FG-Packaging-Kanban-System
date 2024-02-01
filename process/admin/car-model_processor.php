<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
	echo 'method not set';
	exit;
}
$method = $_POST['method'];

// Get Factory Area Dropdown
if ($method == 'fetch_car_model_dropdown') {
	$sql = "SELECT `car_model` FROM `car_model` ORDER BY car_model ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option disabled selected value="">Select Car Model</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['car_model']).'">'.htmlspecialchars($row['car_model']).'</option>';
		}
	} else {
		echo '<option disabled selected value="">Select Car Model</option>';
	}
}

$conn = null;