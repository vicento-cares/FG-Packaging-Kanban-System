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
$date_updated = date('Y-m-d H:i:s');

function check_existing_supplier($supplier_name, $conn) {
	$sql = "SELECT id FROM suppliers WHERE supplier_name = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($supplier_name);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return true;
	} else {
		return false;
	}
}

function get_supplier_name($id, $conn) {
	$sql = "SELECT supplier_name FROM suppliers WHERE id = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($id);
	$stmt -> execute($params);
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		return $row['supplier_name'];
	}
}

function update_supplier_name_on_kanban($supplier_name, $old_supplier_name, $conn) {
	$sql = "UPDATE kanban_masterlist SET supplier_name = ? WHERE supplier_name = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($supplier_name, $old_supplier_name);
	$stmt -> execute($params);
}

// Get Supplier Dropdown
if ($method == 'fetch_suppliers_dropdown') {
	$sql = "SELECT supplier_name FROM suppliers GROUP BY(supplier_name) ORDER BY id ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option disabled selected value="">Select Supplier</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['supplier_name']).'">'.htmlspecialchars($row['supplier_name']).'</option>';
		}
	} else {
		echo '<option disabled selected value="">Select Supplier</option>';
	}
}

// Get Supplier Dropdown
if ($method == 'fetch_suppliers_dropdown_fg') {
	$sql = "SELECT supplier_name FROM suppliers GROUP BY(supplier_name) ORDER BY id ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option selected value="All">All Suppliers</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['supplier_name']).'">'.htmlspecialchars($row['supplier_name']).'</option>';
		}
	} else {
		echo '<option disabled selected value="">Select Supplier</option>';
	}
}

// Count
if ($method == 'count_data') {
	$search = $_POST['search'];
	$sql = "SELECT count(id) AS total FROM suppliers";
	if (!empty($search)) {
		$sql = $sql . " WHERE supplier_name LIKE '$search%'";
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
	$sql = "SELECT id, supplier_name, date_updated FROM suppliers";

	if (!empty($id) && empty($search)) {
		$sql = $sql . " WHERE id > '$id'";
	} else if (empty($id) && !empty($search)) {
		$sql = $sql . " WHERE supplier_name LIKE '$search%'";
	} else if (!empty($id) && !empty($search)) {
		$sql = $sql . " WHERE id > '$id' AND (supplier_name LIKE '$search%')";
	}
	$sql = $sql . " ORDER BY id ASC LIMIT 10";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr style="cursor:pointer;" class="modal-trigger" id="'.$row['id'].'" data-toggle="modal" data-target="#SuppliersInfoModal" data-id="'.$row['id'].'" data-supplier_name="'.htmlspecialchars($row['supplier_name']).'" data-date_updated="'.$row['date_updated'].'" onclick="get_details(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.htmlspecialchars($row['supplier_name']).'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['date_updated'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="3" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Create / Insert
if ($method == 'save_data') {
	$supplier_name = custom_trim($_POST['supplier_name']);

	$is_valid_supplier = validate_supplier($supplier_name);

	if ($is_valid_supplier == true) {
		$is_duplicate = check_existing_supplier($supplier_name, $conn);
		if ($is_duplicate == false) {
			$sql = "INSERT INTO suppliers (supplier_name, date_updated) VALUES (?, ?)";
			$stmt = $conn -> prepare($sql);
			$params = array($supplier_name, $date_updated);
			$stmt -> execute($params);
			echo 'success';
		} else {
			echo 'Duplicate';
		}
	} else {
		echo 'Invalid Supplier';
	}
}

// Update / Edit
if ($method == 'update_data') {
	$id = $_POST['id'];
	$supplier_name = custom_trim($_POST['supplier_name']);

	$is_valid_supplier = validate_supplier($supplier_name);

	if ($is_valid_supplier == true) {
		$old_supplier_name = get_supplier_name($id, $conn);
		$is_existing = check_existing_supplier($supplier_name, $conn);
		if ($is_existing == false) {
			$sql = "UPDATE suppliers SET supplier_name = ?, date_updated = ? WHERE id = ?";
			$stmt = $conn -> prepare($sql);
			$params = array($supplier_name, $date_updated, $id);
			$stmt -> execute($params);
			update_supplier_name_on_kanban($supplier_name, $old_supplier_name, $conn);
			echo 'success';
		} else {
			echo 'Already Exists';
		}
	} else {
		echo 'Invalid Supplier';
	}
}

// Delete
if ($method == 'delete_data') {
	$id = $_POST['id'];

	$sql = "DELETE FROM suppliers WHERE id = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($id);
	$stmt -> execute($params);
	echo 'success';
}

$conn = null;
?>