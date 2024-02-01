<?php 
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
	echo 'method not set';
	exit;
}
$method = $_POST['method'];

function count_history($sql, $conn) {
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		return $row['total'];
	}
}

if ($method == 'count_store_out_request_history') {
	$store_out_date_from = $_POST['store_out_date_from'];
	$store_out_date_from = date_create($store_out_date_from);
	$store_out_date_from = date_format($store_out_date_from,"Y-m-d H:i:s");
	$store_out_date_to = $_POST['store_out_date_to'];
	$store_out_date_to = date_create($store_out_date_to);
	$store_out_date_to = date_format($store_out_date_to,"Y-m-d H:i:s");
	$line_no = $_POST['line_no'];
	$item_no = $_POST['item_no'];
	$item_name = $_POST['item_name'];
	$section = $_POST['section'];
	$sql = "SELECT count(id) AS total FROM kanban_history";
	if ($section == 'All') {
		$sql = $sql . " WHERE line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND (store_out_date_time >= '$store_out_date_from' AND store_out_date_time <= '$store_out_date_to')";
	} else {
		$sql = $sql . " WHERE section = '$section' AND line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND (store_out_date_time >= '$store_out_date_from' AND store_out_date_time <= '$store_out_date_to')";
	}
	$total = count_history($sql, $conn);
	echo $total;
}

if ($method == 'get_store_out_request_history') {
	$id = $_POST['id'];
	$c = $_POST['c'];
	$store_out_date_from = $_POST['store_out_date_from'];
	$store_out_date_from = date_create($store_out_date_from);
	$store_out_date_from = date_format($store_out_date_from,"Y-m-d H:i:s");
	$store_out_date_to = $_POST['store_out_date_to'];
	$store_out_date_to = date_create($store_out_date_to);
	$store_out_date_to = date_format($store_out_date_to,"Y-m-d H:i:s");
	$line_no = $_POST['line_no'];
	$item_no = $_POST['item_no'];
	$item_name = $_POST['item_name'];
	$section = $_POST['section'];
	$printing = $_POST['printing'];
	$sql = "SELECT `id`, `request_id`, `kanban_no`, `item_no`, `item_name`, `line_no`, `quantity`, `storage_area`, `section`, `route_no`, `truck_no`, `scan_date_time`, `request_date_time`, `store_out_date_time` FROM kanban_history";
	if (empty($id)) {
		if ($section == 'All') {
			$sql = $sql . " WHERE line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND (store_out_date_time >= '$store_out_date_from' AND store_out_date_time <= '$store_out_date_to') ORDER BY id DESC LIMIT 25";
		} else {
			$sql = $sql . " WHERE section = '$section' AND line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND (store_out_date_time >= '$store_out_date_from' AND store_out_date_time <= '$store_out_date_to') ORDER BY id DESC LIMIT 25";
		}
	} else if ($section == 'All') {
		$sql = $sql . " WHERE id < '$id' AND (line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND (store_out_date_time >= '$store_out_date_from' AND store_out_date_time <= '$store_out_date_to')) ORDER BY id DESC LIMIT 25";
	} else {
		$sql = $sql . " WHERE id < '$id' AND (section = '$section' AND line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND (store_out_date_time >= '$store_out_date_from' AND store_out_date_time <= '$store_out_date_to')) ORDER BY id DESC LIMIT 25";
	}
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if ($printing == 0) {
				echo '<tr id="'.$row['id'].'"><td>'.$c.'</td>';
			} else if ($printing == 1) {
				echo '<tr id="'.$row['id'].'"><td><p class="mb-0"><label class="mb-0"><input type="checkbox" class="singleCheck2" value="'.$row['id'].'" onclick="get_checked_kanban_history()" /><span></span></label></p></td><td style="cursor:pointer;" onclick="print_single_kanban_history('.$row['id'].')">'.$c.'</td>';
			}
			echo '<td>'.$row['request_id'].'</td><td>'.htmlspecialchars($row['line_no']).'</td><td>'.htmlspecialchars($row['storage_area']).'</td><td>'.$row['item_no'].'</td><td>'.htmlspecialchars($row['item_name']).'</td><td>'.$row['kanban_no'].'</td><td>'.$row['quantity'].'</td><td>'.htmlspecialchars($row['section']).'</td><td>'.$row['route_no'].'</td><td>'.$row['truck_no'].'</td><td>'.date("Y-m-d h:iA", strtotime($row['scan_date_time'])).'</td><td>'.date("Y-m-d h:iA", strtotime($row['request_date_time'])).'</td><td>'.date("Y-m-d h:iA", strtotime($row['store_out_date_time'])).'</td></tr>';
		}
	} else if ($printing == 0) {
		echo '<tr><td colspan="14" style="text-align:center; color:red;">No Request Found</td></tr>';
	} else if ($printing == 1) {
		echo '<tr><td colspan="15" style="text-align:center; color:red;">No Request Found</td></tr>';
	}
}

$conn = null;
?>