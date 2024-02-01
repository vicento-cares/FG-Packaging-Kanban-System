<?php 
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');
require('../lib/validate.php');

if (!isset($_POST['method'])) {
	echo 'method not set';
	exit;
}
$method = $_POST['method'];

function get_last_rir_id($conn) {
	$sql = "SELECT `rir_id` FROM `store_in_history` ORDER BY rir_id + 0 DESC LIMIT 1";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			return intval($row['rir_id']);
		}
	} else {
		return 0;
	}
}

function check_existing_store_in($is_exists_arr, $conn) {
	$sql = "SELECT `id` FROM `store_in_history` WHERE invoice_no = ? AND po_no = ? AND dr_no = ? AND storage_area = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($is_exists_arr['invoice_no'], $is_exists_arr['po_no'], $is_exists_arr['dr_no'], $is_exists_arr['storage_area']);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return true;
	} else {
		return false;
	}
}

function get_inventory_quantity($item_no, $storage_area, $conn) {
	$sql = "SELECT `quantity` FROM `inventory` WHERE item_no = ? AND storage_area = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($item_no, $storage_area);
	$stmt -> execute($params);
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		return intval($row['quantity']);
	}
}

function check_inventory_quantity($item_no, $storage_area, $quantity, $conn) {
	$sql = "SELECT `quantity` FROM `inventory` WHERE item_no = ? AND storage_area = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($item_no, $storage_area);
	$stmt -> execute($params);
	foreach($stmt -> fetchAll() as $row) {
		$recent_quantity = intval($row['quantity']);
		if ($quantity > $recent_quantity) {
			return false;
		} else {
			return true;
		}
	}
}

function update_inventory_transfer($item_no, $to_storage_area, $quantity, $conn) {
	$sql = "UPDATE `inventory` SET quantity = quantity + ? WHERE item_no = ? AND storage_area = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($quantity, $item_no, $to_storage_area);
	$stmt -> execute($params);
}

// Count
if ($method == 'count_inventory') {
	$storage_area = $_POST['storage_area'];
	$item_no = $_POST['item_no'];
	$item_name = addslashes($_POST['item_name']);
	$sql = "SELECT count(id) AS total FROM `inventory`";
	if ($storage_area == 'All') {
		$sql = $sql . " WHERE item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%'";
	} else {
		$sql = $sql . " WHERE item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' AND storage_area = '$storage_area'";
	}
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	}
}

// Search
if ($method == 'get_inventory') {
	$id = $_POST['id'];
	$storage_area = $_POST['storage_area'];
	$item_no = $_POST['item_no'];
	$item_name = addslashes($_POST['item_name']);
	$c = $_POST['c'];
	$row_class = '';
	$row_class_arr = array('modal-trigger', 'modal-trigger table-warning', 'modal-trigger table-danger');
	$sql = "SELECT `id`, `item_no`, `item_name`, `storage_area`, `quantity`, `safety_stock` FROM `inventory`";

	if (empty($id)) {
		if ($storage_area == 'All') {
			$sql = $sql . " WHERE item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' ORDER BY id ASC LIMIT 50";
		} else {
			$sql = $sql . " WHERE item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' AND storage_area = '$storage_area' ORDER BY id ASC LIMIT 50";
		}
	} else if ($storage_area == 'All') {
		$sql = $sql . " WHERE id > '$id' AND (item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%') ORDER BY id ASC LIMIT 50";
	} else {
		$sql = $sql . " WHERE id > '$id' AND (item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' AND storage_area = '$storage_area') ORDER BY id ASC LIMIT 50";
	}

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			$quantity = intval($row['quantity']);
			$safety_stock = intval($row['safety_stock']);
			$quantity_left = $quantity - $safety_stock;
			if ($quantity == 0) {
				$row_class = $row_class_arr[2];
			} else if ($quantity <= $safety_stock) {
				$row_class = $row_class_arr[1];
			} else if ($quantity_left < $safety_stock) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="'.$row['id'].'" data-toggle="modal" data-target="#FgPkgInvInfoModal" data-id="'.$row['id'].'" data-item_no="'.$row['item_no'].'" data-item_name="'.htmlspecialchars($row['item_name']).'" data-storage_area="'.htmlspecialchars($row['storage_area']).'" data-quantity="'.$row['quantity'].'" data-safety_stock="'.$row['safety_stock'].'" onclick="get_details(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['item_no'].'</td>';
			echo '<td>'.htmlspecialchars($row['item_name']).'</td>';
			echo '<td>'.$row['quantity'].'</td>';
			echo '<td>'.$row['safety_stock'].'</td>';
			echo '<td>'.htmlspecialchars($row['storage_area']).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="6" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Create / Insert
if ($method == 'store_in') {
	$store_in_date_time = date('Y-m-d H:i:s');
	$item_no = $_POST['item_no'];
	$item_name = $_POST['item_name'];
	$supplier_name = $_POST['supplier_name'];
	$invoice_no = custom_trim($_POST['invoice_no']);
	$po_no = custom_trim($_POST['po_no']);
	$dr_no = custom_trim($_POST['dr_no']);
	$quantity = intval($_POST['quantity']);
	$storage_area = $_POST['storage_area'];
	$reason = $_POST['reason'];
	if (empty($reason)) {
		$reason = 'N/A';
	}
	$delivery_date_time = $_POST['delivery_date_time'];
	if (empty($delivery_date_time)) {
		$delivery_date_time = null;
	} else {
		$delivery_date_time = date_create($delivery_date_time);
		$delivery_date_time = date_format($delivery_date_time,"Y-m-d H:i:s");
	}

	$last_rir_id = get_last_rir_id($conn);
	$rir_id = $last_rir_id + 1;

	$inv_received = $quantity;
	$inv_on_hand = get_inventory_quantity($item_no, $storage_area, $conn);
	$inv_after = $inv_on_hand + $inv_received;

	$is_valid = false;
	if ($item_no != '') {
		if ($supplier_name != '') {
			if ($storage_area != '') {
				if ($quantity != '' && $quantity > 0) {
					if (empty($invoice_no)) {
						echo 'Invoice No. Empty';
					} else if ($reason != 'Urgent' && empty($po_no)) {
						echo 'PO No. Empty';
					} else if (empty($dr_no)) {
						echo 'DR No. Empty';
					} else {
						$is_valid = true;
					}
				} else {
					echo 'Zero Quantity';
				}
			} else {
				echo 'Area Not Set';
			}
		} else {
			echo 'Supplier Not Set';
		}
	} else {
		echo 'Item Name Not Set';
	}

	if ($is_valid == true) {
		if (empty($po_no)) {
			$po_no = 'N/A';
		}

		/*$is_exists_arr = array(
			'invoice_no' => $invoice_no,
			'po_no' => $po_no,
			'dr_no' => $dr_no,
			'storage_area' => $storage_area
		);
		$is_exists = check_existing_store_in($is_exists_arr, $conn);
		if ($is_exists == false) {
			// code here
			echo 'success';
		} else {
			echo 'Exists';
		}*/

		$sql = "INSERT INTO `store_in_history` (`rir_id`, `invoice_no`, `po_no`, `dr_no`, `item_no`, `item_name`, `supplier_name`, `quantity`, `storage_area`, `reason`, `inv_received`, `inv_on_hand`, `inv_after`, `store_in_date_time`,  `delivery_date_time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $conn -> prepare($sql);
		$params = array($rir_id, $invoice_no, $po_no, $dr_no, $item_no, $item_name, $supplier_name, $quantity, $storage_area, $reason, $inv_received, $inv_on_hand, $inv_after, $store_in_date_time, $delivery_date_time);
		$stmt -> execute($params);

		$sql = "UPDATE `inventory` SET quantity = quantity + ? WHERE item_no = ? AND storage_area = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($quantity, $item_no, $storage_area);
		$stmt -> execute($params);
		echo 'success';
	}
}

// Create / Insert
if ($method == 'transfer') {
	$store_out_date_time = date('Y-m-d H:i:s');
	$item_no = $_POST['item_no'];
	$item_name = $_POST['item_name'];
	$quantity = intval($_POST['quantity']);
	$storage_area = $_POST['storage_area'];
	$to_storage_area = $_POST['to_storage_area'];
	$remarks = 'Transfer';

	$inv_out = $quantity;
	$inv_on_hand = get_inventory_quantity($item_no, $storage_area, $conn);
	$inv_after = $inv_on_hand - $inv_out;

	$is_valid = false;
	if ($item_no != '') {
		if ($storage_area != '') {
			if ($quantity != '' && $quantity > 0) {
				if ($remarks == 'Transfer' && $to_storage_area == '') {
					echo 'To Area Not Set';
				} else {
					$is_valid = true;
				}
			} else {
				echo 'Zero Quantity';
			}
		} else {
			echo 'Area Not Set';
		}
	} else {
		echo 'Item Name Not Set';
	}

	if ($is_valid == true) {
		$can_store_out = check_inventory_quantity($item_no, $storage_area, $quantity, $conn);

		if ($can_store_out == 1) {
			$sql = "INSERT INTO `store_out_history` (`request_id`, `item_no`, `item_name`, `quantity`, `storage_area`, `to_storage_area`, `remarks`, `inv_out`, `inv_on_hand`, `inv_after`, `store_out_date_time`) VALUES ('N/A', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$stmt = $conn -> prepare($sql);
			$params = array($item_no, $item_name, $quantity, $storage_area, $to_storage_area, $remarks, $inv_out, $inv_on_hand, $inv_after, $store_out_date_time);
			$stmt -> execute($params);

			$sql = "UPDATE `inventory` SET quantity = quantity - ? WHERE item_no = ? AND storage_area = ?";
			$stmt = $conn -> prepare($sql);
			$params = array($quantity, $item_no, $storage_area);
			$stmt -> execute($params);

			update_inventory_transfer($item_no, $to_storage_area, $quantity, $conn);
			echo 'success';
		} else {
			echo 'Insufficient Stock';
		}
	}
}

// Update / Edit
if ($method == 'update_safety_stock') {
	$id = $_POST['id'];
	$safety_stock = intval($_POST['safety_stock']);

	if ($safety_stock != '' && $safety_stock > -1) {
		$sql = "UPDATE `inventory` SET `safety_stock`= ? WHERE `id`= ?";
		$stmt = $conn -> prepare($sql);
		$params = array($safety_stock, $id);
		$stmt -> execute($params);
		echo 'success';
	} else {
		echo 'Zero Quantity';
	}
}

$conn = null;
?>