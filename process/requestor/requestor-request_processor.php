<?php 
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');
require('../lib/main.php');

if (!isset($_POST['method'])) {
	echo 'method not set';
	exit;
}
$method = $_POST['method'];

// Generate Request ID
function generate_request_id($request_id) {
	if ($request_id == "") {
		$request_id = date("ymdh");
		$rand = substr(md5(microtime()),rand(0,26),5);
		$request_id = 'REQ:'.$request_id;
		$request_id = $request_id.''.$rand;
	}
	return $request_id;
}

// Check Scanned Kanban
function check_scanned($scanned) {
	$scanned_len = strlen($scanned);
	if ($scanned_len > 20 && $scanned_len < 256) {
		return 'Kanban';
	} else if ($scanned_len > 0 && $scanned_len <= 20) {
		return 'Serial No.';
    } else if ($scanned_len == 0) {
    	return 'Empty';
    } else {
    	return 'Invalid Kanban';
    }
}

// Check Duplicated Scanned Kanban
function check_duplicated_scan($scanned, $request_id, $conn) {
	$sql = "SELECT `id` FROM `scanned_kanban`";
	if (check_scanned($scanned) == "Serial No.") {
		$sql = $sql . " WHERE serial_no = ? AND request_id = ? AND status = 'Scanned' LIMIT 1";
	} else {
		$sql = $sql . " WHERE kanban = ? AND request_id = ? AND status = 'Scanned' LIMIT 1";
	}
	$stmt = $conn -> prepare($sql);
	$params = array($scanned, $request_id);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return 'Duplicated Entry';
	} else {
		return 'success';
	}
}

// Check Already Requested Kanban
function check_already_scan($scanned, $request_id, $conn) {
	$sql = "SELECT `id` FROM `scanned_kanban`";
	if (check_scanned($scanned) == "Serial No.") {
		$sql = $sql . " WHERE serial_no = ? AND request_id != ? AND status != 'Scanned' LIMIT 1";
	} else {
		$sql = $sql . " WHERE kanban = ? AND request_id != ? AND status != 'Scanned' LIMIT 1";
	}
	$stmt = $conn -> prepare($sql);
	$params = array($scanned, $request_id);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return 'Already Requested';
	} else {
		return 'success';
	}
}

// Check Registered Kanban
function check_registered_scan($scanned, $conn) {
	$sql = "SELECT `id` FROM `kanban_masterlist`";
	if (check_scanned($scanned) == "Serial No.") {
		$sql = $sql . " WHERE serial_no = ?";
	} else {
		$sql = $sql . " WHERE kanban = ?";
	}
	$stmt = $conn -> prepare($sql);
	$params = array($scanned);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return 'success';
	} else {
		return 'Unregistered';
	}
}

// Check Section of Kanban
function check_section_scan($scanned, $section, $conn) {
	$sql = "SELECT `id` FROM `kanban_masterlist`";
	if (check_scanned($scanned) == "Serial No.") {
		$sql = $sql . " WHERE serial_no = ? AND section = ?";
	} else {
		$sql = $sql . " WHERE kanban = ? AND section = ?";
	}
	$stmt = $conn -> prepare($sql);
	$params = array($scanned, $section);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return 'success';
	} else {
		return 'Wrong Section';
	}
}

// Check Line No of Kanban
function check_line_scan($scanned, $section, $conn) {
	$sql = "SELECT `line_no` FROM `kanban_masterlist`";
	if (check_scanned($scanned) == "Serial No.") {
		$sql = $sql . " WHERE serial_no = ? AND section = ?";
	} else {
		$sql = $sql . " WHERE kanban = ? AND section = ?";
	}
	$stmt = $conn -> prepare($sql);
	$params = array($scanned, $section);
	$stmt -> execute($params);
	foreach($stmt -> fetchAll() as $row) {
		$line_no = $row['line_no'];
	}

	$sql = "SELECT `id` FROM `scanned_kanban` WHERE status = 'Scanned'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		$sql = "SELECT `id` FROM `scanned_kanban` WHERE section = ? AND line_no = ? AND status = 'Scanned'";
		$stmt = $conn -> prepare($sql);
		$params = array($section, $line_no);
		$stmt -> execute($params);
		if ($stmt -> rowCount() > 0) {
			return 'success';
		} else {
			return 'Multiple Line No.';
		}
	} else {
		return 'success';
	}
}

// Check Single Item Scan Per Request of Kanban
function check_single_item_scan($scanned, $section, $conn) {
	$item_no = '';
	$line_no = '';
	$sql = "SELECT `item_no`, `line_no` FROM `kanban_masterlist`";

	if (check_scanned($scanned) == "Serial No.") {
		$sql = $sql . " WHERE serial_no = ?";
	} else {
		$sql = $sql . " WHERE kanban = ?";
	}
	$stmt = $conn -> prepare($sql);
	$params = array($scanned);
	$stmt -> execute($params);
	foreach($stmt -> fetchAll() as $row) {
		$item_no = $row['item_no'];
		$line_no = $row['line_no'];
	}

	$sql = "SELECT `id` FROM `scanned_kanban` WHERE section = ? AND item_no = ? AND line_no = ? AND status = 'Scanned'";
	$stmt = $conn -> prepare($sql);
	$params = array($section, $item_no, $line_no);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return 'Multiple Same Item';
	} else {
		return 'success';
	}
}

// Check Request Limit Quantity of Kanban
function check_request_limit_scan($scanned, $conn) {
	$req_limit = 0;
	$req_limit_qty = 0;
	$req_limit_time = '';
	$req_limit_date = '';
	$sql = "SELECT `quantity`, `req_limit_qty`, `req_limit_time`, `req_limit_date` FROM `kanban_masterlist`";
	if (check_scanned($scanned) == "Serial No.") {
		$sql = $sql . " WHERE serial_no = ?";
	} else {
		$sql = $sql . " WHERE kanban = ?";
	}
	$stmt = $conn -> prepare($sql);
	$params = array($scanned);
	$stmt -> execute($params);
	foreach($stmt -> fetchAll() as $row) {
		$quantity = intval($row['quantity']);
		$req_limit_qty = intval($row['req_limit_qty']);
		$req_limit_time = $row['req_limit_time'];
		$req_limit_date = $row['req_limit_date'];
	}

	$req_limit_date_time = date('Y-m-d H:i:s', strtotime("$req_limit_date $req_limit_time"));
	$date_time_today = date('Y-m-d H:i:s');
	$date_today = date('Y-m-d');
	$req_limit_day = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req_limit_date_time)));
	if ($date_time_today < $req_limit_day) {
		if ($req_limit_qty < 1) {
			return 'Limit Reached';
		} else {
			return 'success';
		}
	} else {
		return 'success';
	}
}

// Insert Scanned Kanban
function insert_scanned($scanned, $request_id, $requestor_arr, $conn) {
	$scan_date_time = date('Y-m-d H:i:s');
	$request_arr = array();
	$sql = "SELECT `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `line_no`, `section`, `route_no`, `quantity`, `storage_area` FROM `kanban_masterlist`";
	if (check_scanned($scanned) == "Serial No.") {
		$sql = $sql . " WHERE serial_no = ?";
	} else {
		$sql = $sql . " WHERE kanban = ?";
	}
	$stmt = $conn -> prepare($sql);
	$params = array($scanned);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$kanban_no = intval($row['kanban_no']) + 1;
			$request_arr = array($request_id, $row['kanban'], $kanban_no, $row['serial_no'], $row['item_no'], $row['item_name'], $row['line_no'], $row['quantity'], $row['storage_area'], $row['section'], $row['route_no'], $requestor_arr['requestor_id_no'], $requestor_arr['requestor_name'], $requestor_arr['requestor'], $scan_date_time);
		}
	}
	
	$sql = "INSERT INTO `scanned_kanban`(`request_id`, `kanban`, `kanban_no`, `serial_no`,  `item_no`, `item_name`, `line_no`, `quantity`, `storage_area`, `section`, `route_no`, `requestor_id_no`, `requestor_name`, `requestor`, `scan_date_time`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Scanned')";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute($request_arr);
	return 'success';
}

// Display Scanned Kanban
function display_scanned($request_id, $conn) {
	$c = 0;
	$data = '';
	$message = '';
	$row_class_arr = array('modal-trigger', 'modal-trigger table-primary', 'modal-trigger table-warning', 'modal-trigger table-success', 'modal-trigger table-danger');
	$row_class = $row_class_arr[0];
	$is_history = false;
	$sql = "SELECT `id`, `request_id`, `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `line_no`, `quantity`, `section`, `requestor_name`, `scan_date_time` FROM `scanned_kanban` WHERE request_id = ? ORDER BY id DESC";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			$kanban = $row['kanban'];
			$serial_no = $row['serial_no'];
			$quantity = intval($row['quantity']);
			$has_requestor_remarks = check_requestor_remarks($request_id, $kanban, $serial_no, $conn);
			$sql1 = "SELECT `quantity`, `req_limit_qty`, `req_limit_time`, `req_limit_date` FROM `kanban_masterlist` WHERE kanban = ? AND serial_no = ?";
			$stmt1 = $conn -> prepare($sql1);
			$params1 = array($kanban, $serial_no);
			$stmt1 -> execute($params1);
			foreach($stmt1 -> fetchAll() as $row1) {
				$fixed_quantity = intval($row1['quantity']);
				$req_limit_qty = intval($row1['req_limit_qty']);
				$req_limit_time = $row1['req_limit_time'];
				$req_limit_date = $row1['req_limit_date'];
				$req_limit_date_time = date('Y-m-d H:i:s', strtotime("$req_limit_date $req_limit_time"));
				$date_time_today = date('Y-m-d H:i:s');
				$req_limit_day = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req_limit_date_time)));
				if ($date_time_today < $req_limit_day) {
					if ($quantity > $req_limit_qty) {
						$row_class = $row_class_arr[4];
					} else if ($quantity != $fixed_quantity) {
						if ($has_requestor_remarks == false) {
							$row_class = $row_class_arr[2];
						} else {
							$row_class = $row_class_arr[3];
						}
					} else if ($has_requestor_remarks == true) {
						$row_class = $row_class_arr[1];
					} else {
						$row_class = $row_class_arr[0];
					}
				} else {
					if ($quantity != $fixed_quantity) {
						if ($has_requestor_remarks == false) {
							$row_class = $row_class_arr[2];
						} else {
							$row_class = $row_class_arr[3];
						}
					} else if ($has_requestor_remarks == true) {
						$row_class = $row_class_arr[1];
					} else {
						$row_class = $row_class_arr[0];
					}
				}
			}
			$data_target = '#RequestModal';
			$data = $data . '<tr class="'.$row_class.'" id="scanned_'.$row['id'].'"><td>'.$c.'</td><td>'.htmlspecialchars($row['line_no']).'</td><td>'.$row['item_no'].'</td><td>'.htmlspecialchars($row['item_name']).'</td><td style="cursor:pointer;" data-dismiss="modal" data-toggle="modal" data-target="#RequestQtyDetailsSectionModal" data-request_id="'.$row['request_id'].'" data-id="'.$row['id'].'" data-quantity="'.$quantity.'" data-fixed_quantity="'.$fixed_quantity.'" onclick="quantity_details_section(this);">'.$row['quantity'].'</td><td><center><i class="fas fa-pencil-alt" style="cursor:pointer;" data-dismiss="modal" data-toggle="modal" data-target="#RequestRemarksDetailsSectionModal" data-id="'.$row['id'].'" data-request_id="'.$row['request_id'].'" data-kanban="'.htmlspecialchars($row['kanban']).'" data-kanban_no="'.$row['kanban_no'].'" data-serial_no="'.$row['serial_no'].'" data-requestor_name="'.htmlspecialchars($row['requestor_name']).'" data-scan_date_time="'.$row['scan_date_time'].'" data-has_requestor_remarks="'.$has_requestor_remarks.'" data-is_history="'.$is_history.'" data-data_target="'.$data_target.'" onclick="remarks_details_section(this)"></i></center></td><td><center><i class="fas fa-trash" style="cursor:pointer;" data-request_id="'.$row['request_id'].'" data-id="'.$row['id'].'" onclick="delete_single_scanned(this);"></i></center></td></tr>';
		}
	}
	$message = 'success';

	$display_scanned_arr = array(
        'request_id' => $request_id,
        'message' => $message,
        'data' => $data
    );

    return $display_scanned_arr;
}

if ($method == 'load_recent_scanned') {
	$section = $_POST['section'];
	$id_no = $_POST['requestor_id_no'];
	echo load_recent_scanned($section, $id_no, $conn);
}

// Scanned Action
if ($method == 'scanned_action') {
	$request_id = generate_request_id($_POST['request_id']);
	$scanned = addslashes($_POST['kanban']);
	$requestor_id_no = $_POST['requestor_id_no'];
	$requestor_name = $_POST['requestor_name'];
	$requestor = $_POST['requestor'];
	$section = $_POST['section'];
	$message = '';

	// Check Scanned Kanban
	if (check_scanned($scanned) == 'Empty') {
		echo 'Please Scan Kanban';
	} else if (check_scanned($scanned) == 'Invalid Kanban') {
		echo 'Invalid Kanban';
	} else {
		$message = check_duplicated_scan($scanned, $request_id, $conn);
	}

	// Check Duplicated Scanned Kanban
	if ($message == 'Duplicated Entry') {
		echo 'Duplicated Entry';
	} else if ($message == 'success') {
		$message = check_already_scan($scanned, $request_id, $conn);
	}

	// Check Already Requested Kanban
	if ($message == 'Already Requested') {
		echo 'Already Requested';
	} else if ($message == 'success') {
		$message = check_registered_scan($scanned, $conn);
	}

	// Check Registered Kanban
	if ($message == 'Unregistered') {
		echo 'Unregistered';
	} else if ($message == 'success') {
		$message = check_section_scan($scanned, $section, $conn);
	}

	// Check section of Kanban
	if ($message == 'Wrong Section') {
		echo 'Wrong Section';
	} else if ($message == 'success') {
		$message = check_single_item_scan($scanned, $section, $conn);
		//$message = check_line_scan($scanned, $section, $conn);
	}

	// Check Line No of Kanban
	/*if ($message == 'Multiple Line No.') {
		echo 'Multiple Line No.';
	} else if ($message == 'success') {
		$message = check_single_item_scan($scanned, $section, $conn);
	}*/
	
	// Check Single Item Scan Per Request of Kanban
	if ($message == 'Multiple Same Item') {
		echo 'Multiple Same Item';
	} else if ($message == 'success') {
		$message = check_request_limit_scan($scanned, $conn);
	}

	// Check Request Limit Quantity of Kanban
	if ($message == 'Limit Reached') {
		echo 'Request Limit Reached';
	} else if ($message == 'success') {
		$requestor_arr = array(
			'requestor_id_no' => $requestor_id_no, 
			'requestor_name' => $requestor_name, 
			'requestor' => $requestor
		);
		$message = insert_scanned($scanned, $request_id, $requestor_arr, $conn);
	}

	// Insert Scanned Kanban
	if ($message == 'success') {
		$response_arr = array(
	        'request_id' => $request_id,
	        'message' => $message
	    );
		echo json_encode($response_arr, JSON_FORCE_OBJECT);
	}
}

// Display Scanned Kanban
if ($method == 'display_scanned') {
	$request_id = generate_request_id($_POST['request_id']);
	$display_scanned_arr = display_scanned($request_id, $conn);
	// Display Scanned Kanban
	echo json_encode($display_scanned_arr, JSON_FORCE_OBJECT);
}

if ($method == 'quantity_details_section') {
	$id = $_POST['id'];
	$request_id = $_POST['request_id'];
	$kanban = '';
	$serial_no = '';
	$quantity = 0;
	$req_limit_qty = 0;
	$req_limit_time = '';
	$req_limit_date = '';
	$sql = "SELECT `kanban`, `serial_no` FROM `scanned_kanban` WHERE request_id = ? AND id = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id, $id);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$kanban = $row['kanban'];
			$serial_no = $row['serial_no'];
		}
	}

	$sql = "SELECT `quantity`, `req_limit_qty`, `req_limit_time`, `req_limit_date` FROM `kanban_masterlist` WHERE kanban = ? AND serial_no = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($kanban, $serial_no);
	$stmt -> execute($params);
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		$quantity = intval($row['quantity']);
		$req_limit_qty = intval($row['req_limit_qty']);
		$req_limit_time = $row['req_limit_time'];
		$req_limit_date = $row['req_limit_date'];
	}
	
	$req_limit_date_time = date('Y-m-d H:i:s', strtotime("$req_limit_date $req_limit_time"));
	$date_time_today = date('Y-m-d H:i:s');
	$req_limit_day = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req_limit_date_time)));

	if ($date_time_today < $req_limit_day) {
		if ($req_limit_qty < $quantity) {
			echo $req_limit_qty;
		}
	}
}

if ($method == 'update_request_quantity') {
	$id = $_POST['id'];
	$request_id = $_POST['request_id'];
	$quantity = intval($_POST['quantity']);
	$kanban = '';
	$serial_no = '';
	$old_quantity = 0;
	if ($quantity != '' && $quantity > 0) {
		$sql = "SELECT `kanban`, `serial_no` FROM `scanned_kanban` WHERE request_id = ? AND id = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($request_id, $id);
		$stmt -> execute($params);
		if ($stmt -> rowCount() > 0) {
			while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
				$kanban = $row['kanban'];
				$serial_no = $row['serial_no'];
			}
		}

		$sql = "SELECT `quantity` FROM `kanban_masterlist` WHERE kanban = ? AND serial_no = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($kanban, $serial_no);
		$stmt -> execute($params);
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$old_quantity = $row['quantity'];
		}

		if ($quantity <= $old_quantity) {
			$sql = "UPDATE `scanned_kanban` SET quantity = ? WHERE request_id = ? AND id = ?";
			$stmt = $conn -> prepare($sql);
			$params = array($quantity, $request_id, $id);
			$stmt -> execute($params);
			echo 'success';
		} else {
			echo 'Over Quantity';
		}
	} else {
		echo 'Zero Quantity';
	}
}

// Delete Single Scanned Kanban
if ($method == 'delete_single_scanned') {
	$id = $_POST['id'];
	$request_id = $_POST['request_id'];
	$kanban = '';
	$kanban_no = 0;
	$serial_no = '';
	$section = '';
	$scan_date_time = '';
	$sql = "SELECT `kanban`, `kanban_no`, `serial_no`, `section`, `scan_date_time` FROM `scanned_kanban` WHERE request_id = ? AND id = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id, $id);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$kanban = $row['kanban'];
			$kanban_no = $row['kanban_no'];
			$serial_no = $row['serial_no'];
			$section = $row['section'];
			$scan_date_time = $row['scan_date_time'];
		}
	}

	$sql = "DELETE FROM `scanned_kanban` WHERE request_id = ? AND id = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id, $id);
	$stmt -> execute($params);

	$sql = "DELETE FROM `requestor_remarks` WHERE request_id = ? AND kanban = ? AND kanban_no = ? AND serial_no = ? AND section = ? AND scan_date_time = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id, $kanban, $kanban_no, $serial_no, $section, $scan_date_time);
	$stmt -> execute($params);
	echo 'success';
}

// Update Scanned to Pending (Requested)
if ($method == 'update_scanned') {
	$request_date_time = date('Y-m-d H:i:s');
	$request_id = $_POST['request_id'];
	$requestor_id_no = $_POST['requestor_id_no'];
	$requestor_name = $_POST['requestor_name'];
	$requestor = $_POST['requestor'];
	$has_remarks = true;
	$req_limit_reached = false;

	$item_no = '';
	$line_no = '';
	$fixed_quantity = 0;
	$req_limit = 0;
	$req_limit_qty = 0;
	$req_limit_time = '';
	$req_limit_date = '';

	$sql = "SELECT `kanban`, `serial_no`, `quantity` FROM `scanned_kanban` WHERE request_id = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id);
	$stmt -> execute($params);
	foreach($stmt -> fetchAll() as $row) {
		$kanban = $row['kanban'];
		$serial_no = $row['serial_no'];
		$quantity = intval($row['quantity']);
		$has_requestor_remarks = check_requestor_remarks($request_id, $kanban, $serial_no, $conn);

		$sql1 = "SELECT `item_no`, `line_no`, `quantity`, `req_limit`, `req_limit_qty`, `req_limit_time`, `req_limit_date` FROM `kanban_masterlist` WHERE kanban = ? AND serial_no = ?";
		$stmt1 = $conn -> prepare($sql1);
		$params = array($kanban, $serial_no);
		$stmt1 -> execute($params);
		foreach($stmt1 -> fetchAll() as $row1) {
			$item_no = $row1['item_no'];
			$line_no = $row1['line_no'];
			$fixed_quantity = intval($row1['quantity']);
			$req_limit = intval($row1['req_limit']);
			$req_limit_qty = intval($row1['req_limit_qty']);
			$req_limit_time = $row1['req_limit_time'];
			$req_limit_date = $row1['req_limit_date'];
		}

		$req_limit_date_time = date('Y-m-d H:i:s', strtotime("$req_limit_date $req_limit_time"));
		$date_time_today = date('Y-m-d H:i:s');
		$req_limit_day = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req_limit_date_time)));

		if ($quantity > $req_limit_qty) {
			if (!($date_time_today >= $req_limit_day)) {
				$req_limit_reached = true;
				break;
			}
		}

		if ($quantity != $fixed_quantity && $has_requestor_remarks == false) {
			$has_remarks = false;
		}
	}

	if ($req_limit_reached == true) {
		echo 'Limit Reached';
	} else if ($has_remarks == false) {
		echo 'No Remarks';
	} else {
		$sql = "SELECT `kanban`, `serial_no`, `quantity` FROM `scanned_kanban` WHERE request_id = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($request_id);
		$stmt -> execute($params);
		foreach($stmt -> fetchAll() as $row) {
			$kanban = $row['kanban'];
			$serial_no = $row['serial_no'];
			$quantity = intval($row['quantity']);

			$item_no = '';
			$line_no = '';
			$req_limit = 0;
			$req_limit_qty = 0;
			$req_limit_time = '';
			$req_limit_date = '';

			$sql1 = "SELECT `item_no`, `line_no`, `req_limit`, `req_limit_qty`, `req_limit_time`, `req_limit_date` FROM `kanban_masterlist` WHERE kanban = ? AND serial_no = ?";
			$stmt1 = $conn -> prepare($sql1);
			$params = array($kanban, $serial_no);
			$stmt1 -> execute($params);
			foreach($stmt1 -> fetchAll() as $row1) {
				$item_no = $row1['item_no'];
				$line_no = $row1['line_no'];
				$req_limit = intval($row1['req_limit']);
				$req_limit_qty = intval($row1['req_limit_qty']);
				$req_limit_time = $row1['req_limit_time'];
				$req_limit_date = $row1['req_limit_date'];
			}

			$req_limit_date_time = date('Y-m-d H:i:s', strtotime("$req_limit_date $req_limit_time"));
			$date_time_today = date('Y-m-d H:i:s');
			$date_today = date('Y-m-d');
			$req_limit_day = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req_limit_date_time)));

			if ($date_time_today >= $req_limit_day) {
				$req_limit_qty = $req_limit;
				$req_limit_date = date_create($req_limit_date);
				$req_limit_date = date_format($req_limit_date, "Y-m-d");
				$req_limit_date = $date_today;
			}

			$req_limit_qty = $req_limit_qty - $quantity;

			$sql1 = "UPDATE `kanban_masterlist` SET req_limit_qty = ?, req_limit_date = ? WHERE item_no = ? AND line_no = ?";
			$stmt1 = $conn -> prepare($sql1);
			$params = array($req_limit_qty, $req_limit_date, $item_no, $line_no);
			$stmt1 -> execute($params);
		}
		
		$sql = "UPDATE `scanned_kanban` SET requestor_id_no = ?, requestor_name = ?, requestor = ?, request_date_time = ?, status = 'Pending' WHERE request_id = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($requestor_id_no, $requestor_name, $requestor, $request_date_time, $request_id);
		$stmt -> execute($params);

		$sql = "UPDATE `requestor_remarks` SET request_date_time = ?, requestor_status = 'Requested' WHERE request_id = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($request_date_time, $request_id);
		$stmt -> execute($params);

		$sql = "UPDATE `notification_count` SET pending = pending + 1 WHERE interface = 'ADMIN-FG'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		echo 'success';
	}
}

$conn = null;
?>