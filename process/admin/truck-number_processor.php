<?php 
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
	echo 'method not set';
	exit;
}
$method = $_POST['method'];
$date_updated = date('Y-m-d H:i:s');

// Count
if ($method == 'count_data') {
	$search = $_POST['search'];
	$sql = "SELECT count(id) AS total FROM `truck_no`";
	if (!empty($search)) {
		$sql = $sql . " WHERE truck_no LIKE '$search%' OR time_from LIKE '$search%' OR time_to LIKE '$search%'";
	}
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	}
}

// Read / Load
if ($method == 'fetch_data') {
	$id = $_POST['id'];
	$search = $_POST['search'];
	$c = $_POST['c'];
	$sql = "SELECT `id`, `truck_no`, `time_from`, `time_to`, `date_updated` FROM `truck_no`";

	if (!empty($id) && empty($search)) {
		$sql = $sql . " WHERE id > '$id'";
	} else if (empty($id) && !empty($search)) {
		$sql = $sql . " WHERE truck_no LIKE '$search%' OR time_from LIKE '$search%' OR time_to LIKE '$search%'";
	} else if (!empty($id) && !empty($search)) {
		$sql = $sql . " WHERE id > '$id' AND (truck_no LIKE '$search%' OR time_from LIKE '$search%' OR time_to LIKE '$search%')";
	}
	$sql = $sql . " ORDER BY id ASC LIMIT 10";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr style="cursor:pointer;" class="modal-trigger" id="'.$row['id'].'" data-toggle="modal" data-target="#TruckInfoModal" data-id="'.$row['id'].'" data-truck_no="'.$row['truck_no'].'" data-time_from="'.$row['time_from'].'" data-time_to="'.$row['time_to'].'" data-date_updated="'.$row['date_updated'].'" onclick="get_details(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['truck_no'].'</td>';
			echo '<td>'.$row['time_from'].'</td>';
			echo '<td>'.$row['time_to'].'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['date_updated'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="5" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Create / Insert
if ($method == 'save_data') {
	$truck_no = $_POST['truck_no'];
	$time_from = $_POST['time_from'];
	$time_to = $_POST['time_to'];

	$sql = "INSERT INTO `truck_no` (`truck_no`, `time_from`, `time_to`, `date_updated`) VALUES (?, ?, ?, ?)";
	$stmt = $conn -> prepare($sql);
	$params = array($truck_no, $time_from, $time_to, $date_updated);
	$stmt -> execute($params);
	echo 'success';
}

// Update / Edit
if ($method == 'update_data') {
	$id = $_POST['id'];
	$truck_no = $_POST['truck_no'];
	$time_from = $_POST['time_from'];
	$time_to = $_POST['time_to'];

	$sql = "UPDATE `truck_no` SET `truck_no`= ?, `time_from`= ?, `time_to`= ?, `date_updated`= ? WHERE `id`= ?";
	$stmt = $conn -> prepare($sql);
	$params = array($truck_no, $time_from, $time_to, $date_updated, $id);
	$stmt -> execute($params);
	echo 'success';
}

// Delete
if ($method == 'delete_data') {
	$id = $_POST['id'];

	$sql = "DELETE FROM `truck_no` WHERE id = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($id);
	$stmt -> execute($params);
	echo 'success';
}

$conn = null;
?>