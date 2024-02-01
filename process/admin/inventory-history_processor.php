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

// Count
if ($method == 'count_store_in') {
	$store_in_date_from = $_POST['store_in_date_from'];
	$store_in_date_from = date_create($store_in_date_from);
	$store_in_date_from = date_format($store_in_date_from,"Y-m-d H:i:s");
	$store_in_date_to = $_POST['store_in_date_to'];
	$store_in_date_to = date_create($store_in_date_to);
	$store_in_date_to = date_format($store_in_date_to,"Y-m-d H:i:s");
	$storage_area = $_POST['storage_area'];
	$item_no = $_POST['item_no'];
	$item_name = addslashes($_POST['item_name']);
	$sql = "SELECT count(id) AS total FROM `store_in_history`";
	if ($storage_area == 'All') {
		$sql = $sql . " WHERE item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' AND (store_in_date_time >= '$store_in_date_from' AND store_in_date_time <= '$store_in_date_to')";
	} else {
		$sql = $sql . " WHERE item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' AND storage_area = '$storage_area' AND (store_in_date_time >= '$store_in_date_from' AND store_in_date_time <= '$store_in_date_to')";
	}
	$total = count_history($sql, $conn);
	echo $total;
}

// Count
if ($method == 'count_store_out') {
	$store_out_date_from = $_POST['store_out_date_from'];
	$store_out_date_from = date_create($store_out_date_from);
	$store_out_date_from = date_format($store_out_date_from,"Y-m-d H:i:s");
	$store_out_date_to = $_POST['store_out_date_to'];
	$store_out_date_to = date_create($store_out_date_to);
	$store_out_date_to = date_format($store_out_date_to,"Y-m-d H:i:s");
	$storage_area = $_POST['storage_area'];
	$remarks = $_POST['remarks'];
	$item_no = $_POST['item_no'];
	$item_name = addslashes($_POST['item_name']);
	$sql = "SELECT count(id) AS total FROM `store_out_history` WHERE item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' ";
	if ($storage_area != 'All') {
		$sql = $sql . "AND storage_area = '$storage_area' ";
	}
	if ($remarks == 'Without Remarks') {
		$sql = $sql . "AND remarks = '' ";
	} else if ($remarks == 'With Remarks') {
		$sql = $sql . "AND remarks != '' ";
	}
	$sql = $sql . "AND (store_out_date_time >= '$store_out_date_from' AND store_out_date_time <= '$store_out_date_to')";
	$total = count_history($sql, $conn);
	echo $total;
}

// Search
if ($method == 'get_si_inventory_history') {
	$store_in_date_from = $_POST['store_in_date_from'];
	$store_in_date_from = date_create($store_in_date_from);
	$store_in_date_from = date_format($store_in_date_from,"Y-m-d H:i:s");
	$store_in_date_to = $_POST['store_in_date_to'];
	$store_in_date_to = date_create($store_in_date_to);
	$store_in_date_to = date_format($store_in_date_to,"Y-m-d H:i:s");
	$id = $_POST['id'];
	$storage_area = $_POST['storage_area'];
	$item_no = $_POST['item_no'];
	$item_name = addslashes($_POST['item_name']);
	$c = $_POST['c'];
	$row_class_arr = array('modal-trigger', 'modal-trigger table-warning');
	$row_class = $row_class_arr[0];
	$sql = "SELECT * FROM `store_in_history`";
	if (empty($id)) {
		if ($storage_area == 'All') {
			$sql = $sql . " WHERE item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' AND (store_in_date_time >= '$store_in_date_from' AND store_in_date_time <= '$store_in_date_to') ORDER BY id DESC LIMIT 25";
		} else {
			$sql = $sql . " WHERE item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' AND storage_area = '$storage_area' AND (store_in_date_time >= '$store_in_date_from' AND store_in_date_time <= '$store_in_date_to') ORDER BY id DESC LIMIT 25";
		}
	} else if ($storage_area == 'All') {
		$sql = $sql . " WHERE id < '$id' AND (item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' AND (store_in_date_time >= '$store_in_date_from' AND store_in_date_time <= '$store_in_date_to')) ORDER BY id DESC LIMIT 25";
	} else {
		$sql = $sql . " WHERE id < '$id' AND (item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' AND storage_area = '$storage_area' AND (store_in_date_time >= '$store_in_date_from' AND store_in_date_time <= '$store_in_date_to')) ORDER BY id DESC LIMIT 25";
	}
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if ($row['reason'] != 'N/A') {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr class="'.$row_class.'" id="'.$row['id'].'">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['store_in_date_time'])).'</td>';
			echo '<td>'.$row['item_no'].'</td>';
			echo '<td>'.htmlspecialchars($row['item_name']).'</td>';
			echo '<td>'.$row['inv_received'].'</td>';
			echo '<td>'.$row['rir_id'].'</td>';
			echo '<td>'.htmlspecialchars($row['invoice_no']).'</td>';
			if ($row['reason'] != 'N/A') {
				echo '<td style="cursor:pointer;" data-dismiss="modal" data-toggle="modal" data-target="#StoreInPoNoDetailsModal" data-id="'.$row['id'].'" data-po_no="'.htmlspecialchars($row['po_no']).'" onclick="po_no_details(this)">'.htmlspecialchars($row['po_no']).'</td>';
			} else {
				echo '<td>'.$row['po_no'].'</td>';
			}
			echo '<td>'.htmlspecialchars($row['dr_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['supplier_name']).'</td>';
			echo '<td>'.htmlspecialchars($row['storage_area']).'</td>';
			echo '<td>'.$row['reason'].'</td>';
			echo '<td>'.$row['delivery_date_time'].'</td>';
			echo '<td>'.$row['inv_on_hand'].'</td>';
			echo '<td>'.$row['inv_after'].'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="15" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Search
if ($method == 'get_so_inventory_history') {
	$store_out_date_from = $_POST['store_out_date_from'];
	$store_out_date_from = date_create($store_out_date_from);
	$store_out_date_from = date_format($store_out_date_from,"Y-m-d H:i:s");
	$store_out_date_to = $_POST['store_out_date_to'];
	$store_out_date_to = date_create($store_out_date_to);
	$store_out_date_to = date_format($store_out_date_to,"Y-m-d H:i:s");
	$id = $_POST['id'];
	$storage_area = $_POST['storage_area'];
	$remarks = $_POST['remarks'];
	$item_no = $_POST['item_no'];
	$item_name = addslashes($_POST['item_name']);
	$c = $_POST['c'];
	$row_class_arr = array('modal-trigger', 'modal-trigger table-warning');
	$row_class = $row_class_arr[0];
	$sql = "SELECT `id`, `request_id`, `item_no`, `item_name`, `storage_area`, `remarks`, `inv_out`, `inv_on_hand`, `inv_after`, `store_out_date_time` FROM `store_out_history`";
	if (empty($id)) {
		$sql = $sql . " WHERE item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' ";
	} else {
		$sql = $sql . " WHERE id < '$id' AND (item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' ";
	}
	if ($storage_area != 'All') {
		$sql = $sql . "AND storage_area = '$storage_area' ";
	}
	if ($remarks == 'Without Remarks') {
		$sql = $sql . "AND remarks = '' ";
	} else if ($remarks == 'With Remarks') {
		$sql = $sql . "AND remarks != '' ";
	}
	if (empty($id)) {
		$sql = $sql . "AND (store_out_date_time >= '$store_out_date_from' AND store_out_date_time <= '$store_out_date_to') ORDER BY id DESC LIMIT 25";
	} else {
		$sql = $sql . "AND (store_out_date_time >= '$store_out_date_from' AND store_out_date_time <= '$store_out_date_to')) ORDER BY id DESC LIMIT 25";
	}
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if ($row['request_id'] == 'N/A' && $row['remarks'] == 'Transfer') {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr class="'.$row_class.'" id="'.$row['id'].'">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['store_out_date_time'])).'</td>';
			echo '<td>'.$row['item_no'].'</td>';
			echo '<td>'.htmlspecialchars($row['item_name']).'</td>';
			echo '<td>'.$row['inv_out'].'</td>';
			echo '<td>'.$row['request_id'].'</td>';
			echo '<td>'.htmlspecialchars($row['storage_area']).'</td>';
			echo '<td>'.htmlspecialchars($row['remarks']).'</td>';
			echo '<td>'.$row['inv_on_hand'].'</td>';
			echo '<td>'.$row['inv_after'].'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="10" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

if ($method == 'update_po_no') {
	$id = $_POST['id'];
	$po_no = $_POST['po_no'];

	if (empty($po_no)) {
		$po_no = 'N/A';
	}

	$sql = "UPDATE `store_in_history` SET `po_no`= ? WHERE `id`= ?";
	$stmt = $conn -> prepare($sql);
	$params = array($po_no, $id);
	$stmt -> execute($params);
	echo 'success';
}

$conn = null;
?>