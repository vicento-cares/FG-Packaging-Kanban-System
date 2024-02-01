<?php 
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');
require('../lib/validate.php');
require('../lib/main.php');

if (!isset($_POST['method'])) {
	echo 'method not set';
	exit;
}
$method = $_POST['method'];

function get_request_date_time($request_id, $conn) {
	$sql = "SELECT `request_date_time` FROM `scanned_kanban` WHERE request_id = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id);
	$stmt -> execute($params);
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		return $row['request_date_time'];
	}
}

if ($method == 'get_requestor_remarks') {
	$request_id = $_POST['request_id'];
	$kanban = $_POST['kanban'];
	$serial_no = $_POST['serial_no'];
	$id = '';
	$requestor_remarks = '';
	$requestor_date_time = 'N/A';
	
	$sql = "SELECT `id`, `requestor_remarks`, `requestor_date_time` FROM `requestor_remarks` WHERE request_id = ? AND kanban = ? AND serial_no = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id, $kanban, $serial_no);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$id = $row['id'];
			$requestor_remarks = $row['requestor_remarks'];
			$requestor_date_time = date("Y-m-d h:iA", strtotime($row['requestor_date_time']));
		}
	}
	$message = 'success';

	$response_arr = array(
		'requestor_remarks_id' => $id,
        'requestor_remarks' => $requestor_remarks,
        'requestor_date_time' => $requestor_date_time,
        'message' => $message
    );

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

if ($method == 'save_requestor_remarks') {
	$request_id = $_POST['request_id'];
	$kanban = $_POST['kanban'];
	$kanban_no = $_POST['kanban_no'];
	$serial_no = $_POST['serial_no'];
	$section = $_POST['section'];
	$scan_date_time = $_POST['scan_date_time'];
	$request_date_time = null;
	$requestor_remarks = custom_trim($_POST['requestor_remarks']);
	$requestor_date_time = date('Y-m-d H:i:s');
	$data_target = $_POST['data_target'];
	$requestor_status = '';
	
	if (!empty($requestor_remarks) && $requestor_remarks != ' ') {
		if ($data_target == '#RequestModal') {
			$requestor_status = 'Scanned';
			$request_date_time = null;
		} else if ($data_target == '#PendingRequestDetailsSectionModal') {
			$requestor_status = 'Requested';
			$request_date_time = get_request_date_time($request_id, $conn);
		}
		$sql = "INSERT INTO `requestor_remarks` (`request_id`, `kanban`, `kanban_no`, `serial_no`, `section`, `scan_date_time`, `request_date_time`, `requestor_remarks`, `requestor_date_time`, `requestor_status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $conn -> prepare($sql);
		$params = array($request_id, $kanban, $kanban_no, $serial_no, $section, $scan_date_time, $request_date_time, $requestor_remarks, $requestor_date_time, $requestor_status);
		$stmt -> execute($params);
		echo 'success';
	} else {
		echo 'Empty';
	}
}

if ($method == 'update_requestor_remarks') {
	$id = $_POST['id'];
	$requestor_remarks = custom_trim($_POST['requestor_remarks']);
	$requestor_date_time = date('Y-m-d H:i:s');

	if (!empty($requestor_remarks) && $requestor_remarks != ' ') {
		$sql = "UPDATE `requestor_remarks` SET requestor_remarks = ?, requestor_date_time = ? WHERE id = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($requestor_remarks, $requestor_date_time, $id);
		$stmt -> execute($params);
		echo 'success';
	} else {
		echo 'Empty';
	}
}

$conn = null;
?>