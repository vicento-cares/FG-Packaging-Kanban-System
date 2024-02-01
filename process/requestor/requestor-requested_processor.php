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

function count_request($section, $status, $conn) {
	$sql = "SELECT count(id) AS total FROM scanned_kanban WHERE status = ?";
	$params = array($status);
	if ($section != 'All') {
		$sql = $sql . " AND section = ?";
		$params[] = $section;
	}
	$stmt = $conn -> prepare($sql);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			return $row['total'];
		}
	} else {
		return 0;
	}
}

function count_request_group($section, $status, $conn) {
	$sql = "SELECT count(id) AS total FROM scanned_kanban WHERE status = ?";
	$params = array($status);
	if ($section != 'All') {
		$sql = $sql . " AND section = ?";
		$params[] = $section;
	}
	$sql = $sql . " GROUP BY request_id";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return $stmt -> rowCount();
	} else {
		return 0;
	}
}

// Get Section Dropdown (Requested Packaging Materials)
function fetch_section_dropdown_fg($section, $status, $conn) {
	$section_selected = $section;
	$dropdown = '';
	$sql = "SELECT COUNT(request_id) AS `request_id` FROM `scanned_kanban` WHERE status = ? GROUP BY request_id";
	$stmt = $conn -> prepare($sql);
	$params = array($status);
	$stmt -> execute($params);
	if ($section_selected == 'All') {
		$dropdown = $dropdown . '<option selected value="All">All Sections &#160;&#160;&#160;---&#160;&#160;&#160; (&#160;'.$stmt -> rowCount().'&#160;)</option>';
	} else {
		$dropdown = $dropdown . '<option value="All">All Sections &#160;&#160;&#160;---&#160;&#160;&#160; (&#160;'.$stmt -> rowCount().'&#160;)</option>';
	}

	$sql = "SELECT `section` FROM `section` GROUP BY section ORDER BY section ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	foreach($stmt -> fetchAll() as $row) {
		$section = $row['section'];
		$sql1 = "SELECT COUNT(request_id) AS `request_id`, `section` FROM `scanned_kanban` WHERE section = ? AND status = ? GROUP BY request_id ORDER BY section ASC";
		$stmt1 = $conn -> prepare($sql1);
		$params = array($section, $status);
		$stmt1 -> execute($params);
		if ($stmt1 -> rowCount() > 0) {
			if ($section_selected == $section) {
				$dropdown = $dropdown . '<option selected value="'.htmlspecialchars($section).'">'.htmlspecialchars($section).' &#160;&#160;&#160;---&#160;&#160;&#160; (&#160;'.$stmt1 -> rowCount().'&#160;)</option>';
			} else {
				$dropdown = $dropdown . '<option value="'.htmlspecialchars($section).'">'.htmlspecialchars($section).' &#160;&#160;&#160;---&#160;&#160;&#160; (&#160;'.$stmt1 -> rowCount().'&#160;)</option>';
			}
		}
	}

	return $dropdown;
}

function request_mark_as_read($request_id, $status, $user, $section, $conn) {
	$update_notif = true;
	$sql = "";
	if ($status == 'Stored Out') {
		$sql = "UPDATE `kanban_history` SET is_read = 1";
	} else if ($user == 'requestor') {
		$sql = "UPDATE `scanned_kanban` SET is_read = 1";
		if ($status == 'Pending') {
			$update_notif = false;
		}
	} else if ($user == 'fg') {
		$sql = "UPDATE `scanned_kanban` SET is_read_fg = 1";
		if ($status == 'Ongoing') {
			$update_notif = false;
		}
	}
	$sql = $sql . " WHERE request_id = ? AND status = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id, $status);
	$stmt -> execute($params);

	if ($update_notif == true) {
		$sql = "UPDATE `notification_count`";
		if (empty($section)) {
			$section = 'ADMIN-FG';
			$sql = $sql . " SET `pending` = CASE WHEN pending > 0 THEN pending - 1 END";
		} else if ($status == 'Stored Out') {
			$sql = $sql . " SET `store_out` = CASE WHEN store_out > 0 THEN store_out - 1 END";
		} else {
			$sql = $sql . " SET `ongoing` = CASE WHEN ongoing > 0 THEN ongoing - 1 END";
		}
		$sql = $sql . " WHERE interface = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($section);
		$stmt -> execute($params);
	}
}

// Check Inventory Quantity on Pending
function check_inventory_pending($quantity, $item_no, $storage_area, $conn) {
	$sql = "SELECT `quantity`, `safety_stock` FROM `inventory` WHERE item_no = ? AND storage_area = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($item_no, $storage_area);
	$stmt -> execute($params);
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		$quantity_left = $row['quantity'] - $quantity;
		if ($row['quantity'] <= $row['safety_stock']) {
			return 'Inventory Limit Reached';
		} else if ($quantity_left < $row['safety_stock']) {
			return 'Inventory Limit Reached';
		} else {
			return 'success';
		}
	}
}

// Check Inventory Quantity before Ongoing
function check_inventory_ongoing($requested_arr, $conn) {
	$item_no = '';
	$quantity = 0;
	$inv_quantity = 0;
	$safety_stock = 0;
	$storage_area = '';
	$inv_limit_reached = false;
	foreach ($requested_arr as $id) {
		$sql = "SELECT `item_no`, `quantity`, `storage_area` FROM `scanned_kanban` WHERE id = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($id);
		$stmt -> execute($params);
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$item_no = $row['item_no'];
			$quantity = $row['quantity'];
			$storage_area = $row['storage_area'];
		}
		
		$sql = "SELECT `quantity`, `safety_stock` FROM `inventory` WHERE item_no = ? AND storage_area = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($item_no, $storage_area);
		$stmt -> execute($params);
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$inv_quantity = $row['quantity'];
			$safety_stock = $row['safety_stock'];
		}

		$quantity_left = $inv_quantity - $quantity;
		if ($inv_quantity <= $safety_stock) {
			$inv_limit_reached = true;
			break;
		} else if ($quantity_left < $safety_stock) {
			$inv_limit_reached = true;
			break;
		}
	}

	if ($inv_limit_reached == true) {
		return 'Inventory Limit Reached';
	} else {
		return 'success';
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

function update_notif_count($section, $status, $conn) {
	$sql = "UPDATE `notification_count`";
	if ($status == 'Ongoing') {
		$sql = $sql . " SET ongoing = ongoing + 1";
	} else if ($status == 'Stored Out') {
		$sql = $sql . " SET store_out = store_out + 1";
	}
	$sql = $sql . " WHERE interface = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($section);
	$stmt -> execute($params);
}

// Insert request to history and update status to Stored Out
function insert_to_history($ongoing_request_arr, $store_out_person, $conn) {
	$store_out_time = date('H:i');
	$store_out_date_time = date('Y-m-d H:i:s');
	$truck_no = get_truck_number($ongoing_request_arr['section'], $ongoing_request_arr['line_no'], $store_out_time, $conn);
	$sql = "INSERT INTO `kanban_history`(`request_id`, `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `line_no`, `quantity`, `storage_area`, `section`, `route_no`, `truck_no`, `requestor_id_no`, `requestor_name`, `requestor`, `scan_date_time`, `request_date_time`, `store_out_date_time`, `store_out_person`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Stored Out')";
	$stmt = $conn -> prepare($sql);
	$params = array($ongoing_request_arr['request_id'], $ongoing_request_arr['kanban'], $ongoing_request_arr['kanban_no'], $ongoing_request_arr['serial_no'], $ongoing_request_arr['item_no'], $ongoing_request_arr['item_name'], $ongoing_request_arr['line_no'], $ongoing_request_arr['quantity'], $ongoing_request_arr['storage_area'], $ongoing_request_arr['section'], $ongoing_request_arr['route_no'], $truck_no, $ongoing_request_arr['requestor_id_no'], $ongoing_request_arr['requestor_name'], $ongoing_request_arr['requestor'], $ongoing_request_arr['scan_date_time'], $ongoing_request_arr['request_date_time'], $store_out_date_time, $store_out_person);
	$stmt -> execute($params);

	$remarks_arr = get_requestor_remarks($ongoing_request_arr['request_id'], $ongoing_request_arr['kanban'], $ongoing_request_arr['serial_no'], $conn);
	$remarks = $remarks_arr['requestor_remarks'];

	$inv_out = $ongoing_request_arr['quantity'];
	$inv_after = get_inventory_quantity($ongoing_request_arr['item_no'], $ongoing_request_arr['storage_area'], $conn);
	$inv_on_hand = $inv_after + $inv_out;

	$sql = "INSERT INTO `store_out_history`(`request_id`, `item_no`, `item_name`, `quantity`, `storage_area`, `to_storage_area`, `remarks`, `inv_out`, `inv_on_hand`, `inv_after`, `store_out_date_time`) VALUES (?, ?, ?, ?, ?, 'N/A', ?, ?, ?, ?, ?)";
	$stmt = $conn -> prepare($sql);
	$params = array($ongoing_request_arr['request_id'], $ongoing_request_arr['item_no'], $ongoing_request_arr['item_name'], $ongoing_request_arr['quantity'], $ongoing_request_arr['storage_area'], $remarks, $inv_out, $inv_on_hand, $inv_after, $store_out_date_time);
	$stmt -> execute($params);
}

function update_kanban_no($kanban, $serial_no, $conn) {
	$sql = "UPDATE kanban_masterlist SET kanban_no = kanban_no + 1 WHERE kanban = ? AND serial_no = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($kanban, $serial_no);
	$stmt -> execute($params);
}

// Get Kanban History ID for printing
function get_kanban_history_id($request_id, $kanban, $serial_no, $conn) {
	$sql = "SELECT `id` FROM kanban_history WHERE request_id = ? AND kanban = ? AND serial_no = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id, $kanban, $serial_no);
	$stmt -> execute($params);
	foreach($stmt -> fetchAll() as $row) {
		return $row['id'];
	}
}

// Delete ongoing request
function delete_ongoing($id, $conn) {
	$sql = "DELETE FROM `scanned_kanban` WHERE id = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($id);
	$stmt -> execute($params);
}

function set_requestor_remarks_to_history($request_id, $kanban, $serial_no, $conn) {
	$sql = "UPDATE `requestor_remarks` SET requestor_status = 'History' WHERE request_id = ? AND kanban = ? AND serial_no = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id, $kanban, $serial_no);
	$stmt -> execute($params);
}

// Read / Load
if ($method == 'display_pending_on_section') {
	$c = $_POST['c'];
	$section = $_POST['section'];
	$status = 'Pending';
	$row_class_arr = array('modal-trigger', 'modal-trigger table-primary');
	$row_class = $row_class_arr[0];
	$data = '';
	$sql = "SELECT `request_id`, COUNT(kanban) AS `kanban`, `section`, `requestor_name`, `request_date_time`, `status`, `is_read` FROM `scanned_kanban` WHERE section = ? AND status = 'Pending' GROUP BY(request_id) ORDER BY id DESC";
	$stmt = $conn -> prepare($sql);
	$params = array($section);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if (intval($row['is_read']) == 0) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			$data = $data . '<tr style="cursor:pointer;" class="'.$row_class.'" id="P_'.$row['request_id'].'" data-toggle="modal" data-target="#PendingRequestDetailsSectionModal" data-request_id="'.$row['request_id'].'" onclick="view_pending_request_details(&quot;'.$row['request_id'].'&quot;)"><td>'.$c.'</td><td>'.$row['request_id'].'</td><td>'.date("Y-m-d h:iA", strtotime($row['request_date_time'])).'</td><td>'.$row['kanban'].'</td><td>'.htmlspecialchars($row['requestor_name']).'</td></tr>';
		}
	} else {
		$data = $data . '<tr><td colspan="6" style="text-align:center; color:red;">No Request Found</td></tr>';
	}

	$total = intval(count_request($section, $status, $conn));
	$total_req = intval(count_request_group($section, $status, $conn));

	$response_arr = array(
        'total' => $total,
        'total_req' => $total_req,
        'data' => $data
    );

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

// Read / Load
if ($method == 'display_ongoing_on_section') {
	$c = $_POST['c'];
	$section = $_POST['section'];
	$status = 'Ongoing';
	$row_class_arr = array('modal-trigger', 'modal-trigger table-warning');
	$row_class = $row_class_arr[0];
	$data = '';
	$sql = "SELECT `request_id`, COUNT(kanban) AS `kanban`, `section`, `requestor_name`, `request_date_time`, `status`, `is_read` FROM `scanned_kanban` WHERE section = ? AND status = 'Ongoing' GROUP BY(request_id) ORDER BY is_read ASC, id DESC";
	$stmt = $conn -> prepare($sql);
	$params = array($section);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if (intval($row['is_read']) == 0) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			$data = $data . '<tr style="cursor:pointer;" class="'.$row_class.'" id="O_'.$row['request_id'].'" data-toggle="modal" data-target="#OngoingRequestDetailsSectionModal" data-request_id="'.$row['request_id'].'" onclick="view_ongoing_request_details(this)"><td>'.$c.'</td><td>'.$row['request_id'].'</td><td>'.date("Y-m-d h:iA", strtotime($row['request_date_time'])).'</td><td>'.$row['kanban'].'</td><td>'.htmlspecialchars($row['requestor_name']).'</td></tr>';
		}
	} else {
		$data = $data . '<tr><td colspan="5" style="text-align:center; color:red;">No Request Found</td></tr>';
	}

	$total = intval(count_request($section, $status, $conn));
	$total_req = intval(count_request_group($section, $status, $conn));

	$response_arr = array(
        'total' => $total,
        'total_req' => $total_req,
        'data' => $data
    );

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

// Read / Load
if ($method == 'display_so_on_section') {
	$c = $_POST['c'];
	$section = $_POST['section'];
	$row_class_arr = array('modal-trigger', 'modal-trigger table-success');
	$row_class = $row_class_arr[0];
	$sql = "SELECT `request_id`, COUNT(kanban) AS `kanban`, `section`, `requestor_name`, `request_date_time`, `status`, `is_read` FROM `kanban_history` WHERE section = ? AND status = 'Stored Out' GROUP BY(request_id) ORDER BY is_read ASC, id DESC LIMIT 50";
	$stmt = $conn -> prepare($sql);
	$params = array($section);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if (intval($row['is_read']) == 0) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="S_'.$row['request_id'].'" data-toggle="modal" data-target="#SoRequestDetailsSectionModal" data-request_id="'.$row['request_id'].'" onclick="view_so_request_details(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['request_id'].'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['request_date_time'])).'</td>';
			echo '<td>'.$row['kanban'].'</td>';
			echo '<td>'.htmlspecialchars($row['requestor_name']).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="5" style="text-align:center; color:red;">No Request Found</td>';
		echo '</tr>';
	}
}

// Read / Load
if ($method == 'display_pending_on_fg') {
	$c = $_POST['c'];
	$section = $_POST['section'];
	$status = 'Pending';
	$row_class_arr = array('modal-trigger', 'modal-trigger table-primary');
	$row_class = $row_class_arr[0];
	$data = '';
	$sql = "SELECT `request_id`, COUNT(kanban) AS `kanban`, `section`, `requestor_name`, `request_date_time`, `status`, `is_read_fg` FROM `scanned_kanban` WHERE status = ?";
	$params = array($status);
	if ($section != 'All') {
		$sql = $sql . " AND section = ?";
		$params[] = $section;
	}
	$sql = $sql . " GROUP BY(request_id) ORDER BY id DESC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if (intval($row['is_read_fg']) == 0) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			$data = $data . '<tr style="cursor:pointer;" class="'.$row_class.'" id="P_'.$row['request_id'].'" data-toggle="modal" data-target="#PendingRequestDetailsFgModal" data-request_id="'.$row['request_id'].'" onclick="view_pending_requested_details(this)"><td>'.$c.'</td><td>'.$row['request_id'].'</td><td>'.htmlspecialchars($row['section']).'</td><td>'.date("Y-m-d h:iA", strtotime($row['request_date_time'])).'</td><td>'.$row['kanban'].'</td><td>'.htmlspecialchars($row['requestor_name']).'</td></tr>';
		}
	} else {
		$data = $data . '<tr><td colspan="6" style="text-align:center; color:red;">No Request Found</td></tr>';
	}

	$dropdown = fetch_section_dropdown_fg($section, $status, $conn);
	$total = intval(count_request($section, $status, $conn));
	$total_req = intval(count_request_group($section, $status, $conn));

	$response_arr = array(
        'total' => $total,
        'total_req' => $total_req,
        'dropdown' => $dropdown,
        'data' => $data
    );

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

// Read / Load
if ($method == 'display_ongoing_on_fg') {
	$c = $_POST['c'];
	$section = $_POST['section'];
	$status = 'Ongoing';
	$row_class_arr = array('modal-trigger', 'modal-trigger table-warning');
	$row_class = $row_class_arr[0];
	$data = '';
	$sql = "SELECT `request_id`, COUNT(kanban) AS `kanban`, `section`, `requestor_name`, `request_date_time`, `status`, `is_read_fg` FROM `scanned_kanban` WHERE status = ?";
	$params = array($status);
	if ($section != 'All') {
		$sql = $sql . " AND section = ?";
		$params[] = $section;
	}
	$sql = $sql . " GROUP BY(request_id) ORDER BY is_read_fg ASC, id DESC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if (intval($row['is_read_fg']) == 0) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			$data = $data . '<tr style="cursor:pointer;" class="'.$row_class.'" id="O_'.$row['request_id'].'" data-toggle="modal" data-target="#OngoingRequestDetailsFgModal" data-request_id="'.$row['request_id'].'" onclick="view_ongoing_requested_details(this)"><td>'.$c.'</td><td>'.$row['request_id'].'</td><td>'.htmlspecialchars($row['section']).'</td><td>'.date("Y-m-d h:iA", strtotime($row['request_date_time'])).'</td><td>'.$row['kanban'].'</td><td>'.htmlspecialchars($row['requestor_name']).'</td></tr>';
		}
	} else {
		$data = $data . '<tr><td colspan="6" style="text-align:center; color:red;">No Request Found</td></tr>';
	}

	$dropdown = fetch_section_dropdown_fg($section, $status, $conn);
	$total = intval(count_request($section, $status, $conn));
	$total_req = intval(count_request_group($section, $status, $conn));

	$response_arr = array(
        'total' => $total,
        'total_req' => $total_req,
        'dropdown' => $dropdown,
        'data' => $data
    );

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

if ($method == 'view_pending_request_details') {
	$data = '';
	$section = '';
	$requestor_name = '';
	$request_id = $_POST['request_id'];
	$is_history = false;
	$is_read = 1;
	$status = 'Pending';
	$sql = "SELECT `id`, `request_id`, `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `line_no`, `quantity`, `storage_area`, `section`, `requestor_name`, `scan_date_time`, `request_date_time`, `status`, `is_read` FROM `scanned_kanban` WHERE request_id = ? AND status = 'Pending' ORDER BY id ASC";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$section = $row['section'];
			$requestor_name = $row['requestor_name'];
			$has_requestor_remarks = check_requestor_remarks($row['request_id'], $row['kanban'], $row['serial_no'], $conn);
			$requestor_remarks = '';
	        $requestor_remarks_arr = get_requestor_remarks($row['request_id'], $row['kanban'], $row['serial_no'], $conn);
	        if (array_key_exists('requestor_remarks',$requestor_remarks_arr)) {
	            $requestor_remarks = $requestor_remarks_arr['requestor_remarks'];
	            if (strlen($requestor_remarks) > 12) {
					$requestor_remarks = substr($requestor_remarks, 0, 12) . "...";
				}
	        }
	        $data_target = '#PendingRequestDetailsSectionModal';
			$data = $data . '<tr id="'.$row['id'].'"><td>'.htmlspecialchars($row['line_no']).'</td><td>'.htmlspecialchars($row['storage_area']).'</td><td>'.$row['item_no'].'</td><td>'.htmlspecialchars($row['item_name']).'</td><td>'.$row['kanban_no'].'</td><td>'.$row['quantity'].'</td><td style="cursor:pointer;" data-dismiss="modal" data-toggle="modal" data-target="#RequestRemarksDetailsSectionModal" data-id="'.$row['id'].'" data-request_id="'.$row['request_id'].'" data-kanban="'.htmlspecialchars($row['kanban']).'" data-kanban_no="'.$row['kanban_no'].'" data-serial_no="'.$row['serial_no'].'" data-requestor_name="'.htmlspecialchars($row['requestor_name']).'" data-scan_date_time="'.$row['scan_date_time'].'" data-has_requestor_remarks="'.$has_requestor_remarks.'" data-is_history="'.$is_history.'" data-data_target="'.$data_target.'" onclick="remarks_details_section(this)">'.htmlspecialchars($requestor_remarks).'</td><td>'.date("Y-m-d h:iA", strtotime($row['scan_date_time'])).'</td><td>'.date("Y-m-d h:iA", strtotime($row['request_date_time'])).'</td></tr>';
			if (intval($row['is_read']) == 0) {
				$is_read = 0;
			}
		}
		if ($is_read == 0) {
			request_mark_as_read($request_id, $status, 'requestor', $section, $conn);
		}
	} else {
		$data = $data . '<tr><td colspan="9" style="text-align:center; color:red;">No Request Found</td></tr>';
	}

	$response_arr = array(
        'requestor_name' => $requestor_name,
        'data' => $data
    );

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

if ($method == 'view_ongoing_request_details') {
	$data = '';
	$section = '';
	$requestor_name = '';
	$request_id = $_POST['request_id'];
	$is_history = true;
	$is_read = 1;
	$status = 'Ongoing';
	$sql = "SELECT `id`, `request_id`, `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `line_no`, `quantity`, `storage_area`, `section`, `requestor_name`, `scan_date_time`, `request_date_time`, `status`, `is_read` FROM `scanned_kanban` WHERE request_id = ? AND status = 'Ongoing' ORDER BY id ASC";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$section = $row['section'];
			$requestor_name = $row['requestor_name'];
			$has_requestor_remarks = check_requestor_remarks($row['request_id'], $row['kanban'], $row['serial_no'], $conn);
			$requestor_remarks = '';
	        $requestor_remarks_arr = get_requestor_remarks($row['request_id'], $row['kanban'], $row['serial_no'], $conn);
	        if (array_key_exists('requestor_remarks',$requestor_remarks_arr)) {
	            $requestor_remarks = $requestor_remarks_arr['requestor_remarks'];
	            if (strlen($requestor_remarks) > 12) {
					$requestor_remarks = substr($requestor_remarks, 0, 12) . "...";
				}
	        }
	        $data_target = '#OngoingRequestDetailsSectionModal';
			$data = $data . '<tr id="'.$row['id'].'"><td>'.htmlspecialchars($row['line_no']).'</td><td>'.htmlspecialchars($row['storage_area']).'</td><td>'.$row['item_no'].'</td><td>'.htmlspecialchars($row['item_name']).'</td><td>'.$row['kanban_no'].'</td><td>'.$row['quantity'].'</td><td style="cursor:pointer;" data-dismiss="modal" data-toggle="modal" data-target="#RequestRemarksDetailsSectionModal" data-id="'.$row['id'].'" data-request_id="'.$row['request_id'].'" data-kanban="'.htmlspecialchars($row['kanban']).'" data-kanban_no="'.$row['kanban_no'].'" data-serial_no="'.$row['serial_no'].'" data-requestor_name="'.htmlspecialchars($row['requestor_name']).'" data-scan_date_time="'.$row['scan_date_time'].'" data-has_requestor_remarks="'.$has_requestor_remarks.'" data-is_history="'.$is_history.'" data-data_target="'.$data_target.'" onclick="remarks_details_section(this)">'.htmlspecialchars($requestor_remarks).'</td><td>'.date("Y-m-d h:iA", strtotime($row['scan_date_time'])).'</td><td>'.date("Y-m-d h:iA", strtotime($row['request_date_time'])).'</td></tr>';
			if (intval($row['is_read']) == 0) {
				$is_read = 0;
			}
		}
		if ($is_read == 0) {
			request_mark_as_read($request_id, $status, 'requestor', $section, $conn);
		}
	} else {
		$data = $data . '<tr><td colspan="9" style="text-align:center; color:red;">No Request Found</td></tr>';
	}

	$response_arr = array(
        'requestor_name' => $requestor_name,
        'data' => $data
    );

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

if ($method == 'view_so_request_details') {
	$data = '';
	$section = '';
	$requestor_name = '';
	$request_id = $_POST['request_id'];
	$is_history = true;
	$is_read = 1;
	$status = 'Stored Out';
	$sql = "SELECT `id`, `request_id`, `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `line_no`, `quantity`, `storage_area`, `section`, `route_no`, `truck_no`, `requestor_name`, `scan_date_time`, `request_date_time`, `store_out_date_time`, `status`, `is_read` FROM `kanban_history` WHERE request_id = ? AND status = 'Stored Out' ORDER BY id ASC";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$section = $row['section'];
			$requestor_name = $row['requestor_name'];
			$has_requestor_remarks = check_requestor_remarks($row['request_id'], $row['kanban'], $row['serial_no'], $conn);
			$requestor_remarks = '';
	        $requestor_remarks_arr = get_requestor_remarks($row['request_id'], $row['kanban'], $row['serial_no'], $conn);
	        if (array_key_exists('requestor_remarks',$requestor_remarks_arr)) {
	            $requestor_remarks = $requestor_remarks_arr['requestor_remarks'];
	            if (strlen($requestor_remarks) > 12) {
					$requestor_remarks = substr($requestor_remarks, 0, 12) . "...";
				}
	        }
	        $data_target = '#SoRequestDetailsSectionModal';
			$data = $data . '<tr id="'.$row['id'].'"><td>'.htmlspecialchars($row['line_no']).'</td><td>'.htmlspecialchars($row['storage_area']).'</td><td>'.$row['item_no'].'</td><td>'.htmlspecialchars($row['item_name']).'</td><td>'.$row['kanban_no'].'</td><td>'.$row['quantity'].'</td><td>'.$row['route_no'].'</td><td>'.$row['truck_no'].'</td><td style="cursor:pointer;" data-dismiss="modal" data-toggle="modal" data-target="#RequestRemarksDetailsSectionModal" data-id="'.$row['id'].'" data-request_id="'.$row['request_id'].'" data-kanban="'.htmlspecialchars($row['kanban']).'" data-kanban_no="'.$row['kanban_no'].'" data-serial_no="'.$row['serial_no'].'" data-requestor_name="'.htmlspecialchars($row['requestor_name']).'" data-scan_date_time="'.$row['scan_date_time'].'" data-has_requestor_remarks="'.$has_requestor_remarks.'" data-is_history="'.$is_history.'" data-data_target="'.$data_target.'" onclick="remarks_details_section(this)">'.htmlspecialchars($requestor_remarks).'</td><td>'.date("Y-m-d h:iA", strtotime($row['scan_date_time'])).'</td><td>'.date("Y-m-d h:iA", strtotime($row['request_date_time'])).'</td><td>'.date("Y-m-d h:iA", strtotime($row['store_out_date_time'])).'</td></tr>';
			if (intval($row['is_read']) == 0) {
				$is_read = 0;
			}
		}
		if ($is_read == 0) {
			request_mark_as_read($request_id, $status, 'requestor', $section, $conn);
		}
	} else {
		$data = $data . '<tr><td colspan="11" style="text-align:center; color:red;">No Request Found</td></tr>';
	}

	$response_arr = array(
        'requestor_name' => $requestor_name,
        'data' => $data
    );

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

if ($method == 'view_pending_requested_details') {
	$data = '';
	$requestor_name = '';
	$request_id = $_POST['request_id'];
	$is_history = false;
	$is_read_fg = 1;
	$status = 'Pending';
	$row_class_arr = array('', 'table-danger');
	$row_class = $row_class_arr[0];
	$sql = "SELECT `id`, `request_id`, `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `line_no`, `quantity`, `storage_area`, `requestor_name`, `scan_date_time`, `request_date_time`, `status`, `is_read_fg` FROM `scanned_kanban` WHERE request_id = ? AND status = 'Pending' ORDER BY id ASC";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$requestor_name = $row['requestor_name'];
			$has_requestor_remarks = check_requestor_remarks($row['request_id'], $row['kanban'], $row['serial_no'], $conn);
			$requestor_remarks = '';
	        $requestor_remarks_arr = get_requestor_remarks($row['request_id'], $row['kanban'], $row['serial_no'], $conn);
	        if (array_key_exists('requestor_remarks',$requestor_remarks_arr)) {
	            $requestor_remarks = $requestor_remarks_arr['requestor_remarks'];
	            if (strlen($requestor_remarks) > 12) {
					$requestor_remarks = substr($requestor_remarks, 0, 12) . "...";
				}
	        }
	        $check_inventory_pending = check_inventory_pending($row['quantity'], $row['item_no'], $row['storage_area'], $conn);
	        if ($check_inventory_pending != 'success') {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			$data_target = '#PendingRequestDetailsFgModal';
			$data = $data . '<tr class="'.$row_class.'" id="'.$row['id'].'"><td><p class="mb-0"><label class="mb-0"><input type="checkbox" class="singleCheck" value="'.$row['id'].'" onclick="get_checked_pending()" /><span></span></label></p></td><td>'.htmlspecialchars($row['line_no']).'</td><td>'.htmlspecialchars($row['storage_area']).'</td><td>'.$row['item_no'].'</td><td>'.htmlspecialchars($row['item_name']).'</td><td>'.$row['kanban_no'].'</td><td>'.$row['quantity'].'</td><td style="cursor:pointer;" data-dismiss="modal" data-toggle="modal" data-target="#ViewRemarksDetailsFgModal" data-id="'.$row['id'].'" data-request_id="'.$row['request_id'].'" data-kanban="'.htmlspecialchars($row['kanban']).'" data-kanban_no="'.$row['kanban_no'].'" data-serial_no="'.$row['serial_no'].'" data-requestor_name="'.htmlspecialchars($row['requestor_name']).'" data-scan_date_time="'.$row['scan_date_time'].'" data-has_requestor_remarks="'.$has_requestor_remarks.'" data-is_history="'.$is_history.'" data-data_target="'.$data_target.'" onclick="remarks_details_fg_view(this)">'.htmlspecialchars($requestor_remarks).'</td><td>'.date("Y-m-d h:iA", strtotime($row['scan_date_time'])).'</td><td>'.date("Y-m-d h:iA", strtotime($row['request_date_time'])).'</td></tr>';
			if (intval($row['is_read_fg']) == 0) {
				$is_read_fg = 0;
			}
		}
		if ($is_read_fg == 0) {
			request_mark_as_read($request_id, $status, 'fg', '', $conn);
		}
	} else {
		$data = $data . '<tr><td colspan="9" style="text-align:center; color:red;">No Request Found</td></tr>';
	}

	$response_arr = array(
        'requestor_name' => $requestor_name,
        'data' => $data
    );

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

if ($method == 'view_ongoing_requested_details') {
	$data = '';
	$requestor_name = '';
	$request_id = $_POST['request_id'];
	$is_history = false;
	$is_read_fg = 1;
	$status = 'Ongoing';
	$sql = "SELECT `id`, `request_id`, `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `line_no`, `quantity`, `storage_area`, `requestor_name`, `scan_date_time`, `request_date_time`, `status`, `is_read_fg` FROM `scanned_kanban` WHERE request_id = ? AND status = 'Ongoing' ORDER BY id ASC";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$requestor_name = $row['requestor_name'];
			$has_requestor_remarks = check_requestor_remarks($row['request_id'], $row['kanban'], $row['serial_no'], $conn);
			$requestor_remarks = '';
	        $requestor_remarks_arr = get_requestor_remarks($row['request_id'], $row['kanban'], $row['serial_no'], $conn);
	        if (array_key_exists('requestor_remarks',$requestor_remarks_arr)) {
	            $requestor_remarks = $requestor_remarks_arr['requestor_remarks'];
	            if (strlen($requestor_remarks) > 12) {
					$requestor_remarks = substr($requestor_remarks, 0, 12) . "...";
				}
	        }
	        $data_target = '#OngoingRequestDetailsFgModal';
			$data = $data . '<tr id="'.$row['id'].'"><td><p class="mb-0"><label class="mb-0"><input type="checkbox" class="singleCheck2" value="'.$row['id'].'" onclick="get_checked_ongoing()" /><span></span></label></p></td><td>'.htmlspecialchars($row['line_no']).'</td><td>'.htmlspecialchars($row['storage_area']).'</td><td>'.$row['item_no'].'</td><td>'.htmlspecialchars($row['item_name']).'</td><td>'.$row['kanban_no'].'</td><td>'.$row['quantity'].'</td><td style="cursor:pointer;" data-dismiss="modal" data-toggle="modal" data-target="#ViewRemarksDetailsFgModal" data-id="'.$row['id'].'" data-request_id="'.$row['request_id'].'" data-kanban="'.htmlspecialchars($row['kanban']).'" data-kanban_no="'.$row['kanban_no'].'" data-serial_no="'.$row['serial_no'].'" data-requestor_name="'.htmlspecialchars($row['requestor_name']).'" data-scan_date_time="'.$row['scan_date_time'].'" data-has_requestor_remarks="'.$has_requestor_remarks.'" data-is_history="'.$is_history.'" data-data_target="'.$data_target.'" onclick="remarks_details_fg_view(this)">'.htmlspecialchars($requestor_remarks).'</td><td>'.date("Y-m-d h:iA", strtotime($row['scan_date_time'])).'</td><td>'.date("Y-m-d h:iA", strtotime($row['request_date_time'])).'</td></tr>';
			if (intval($row['is_read_fg']) == 0) {
				$is_read_fg = 0;
			}
		}
		if ($is_read_fg == 0) {
			request_mark_as_read($request_id, $status, 'fg', '', $conn);
		}
	} else {
		$data = $data . '<tr><td colspan="9" style="text-align:center; color:red;">No Request Found</td></tr>';
	}

	$response_arr = array(
        'requestor_name' => $requestor_name,
        'data' => $data
    );

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

// Mark As Ongoing Request Arr
if ($method == 'mark_as_ongoing_request_arr') {
	$requested_arr = [];
	$requested_arr = $_POST['requested_arr'];
	$request_id = $_POST['request_id'];
	$section = '';
	$status = 'Ongoing';
	$quantity = 0;
	$item_no = '';
	$item_name = '';
	$storage_area = '';
	$scanned_kanban_id_arr = array();
	$message = '';

	$check_inventory_ongoing = check_inventory_ongoing($requested_arr, $conn);

	if ($check_inventory_ongoing == 'success') {

		$sql = "SELECT `id` FROM `scanned_kanban` WHERE request_id = ? AND status = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($request_id, $status);
		$stmt -> execute($params);
		$ongoing_count = $stmt -> rowCount();

		foreach ($requested_arr as $id) {
			$sql = "SELECT `item_no`, `item_name`, `quantity`, `storage_area`, `section` FROM `scanned_kanban` WHERE id = ?";
			$stmt = $conn -> prepare($sql);
			$params = array($id);
			$stmt -> execute($params);
			while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
				$item_no = $row['item_no'];
				$item_name = $row['item_name'];
				$quantity = $row['quantity'];
				$storage_area = $row['storage_area'];
				$section = $row['section'];
			}

			$sql = "UPDATE `scanned_kanban` SET status = ?, is_read = 0, is_read_fg = 0 WHERE id = ?";
			$stmt = $conn -> prepare($sql);
			$params = array($status, $id);
			$stmt -> execute($params);

			$sql = "UPDATE `inventory` SET quantity = quantity - ? WHERE item_no = ? AND item_name = ? AND storage_area = ?";
			$stmt = $conn -> prepare($sql);
			$params = array($quantity, $item_no, $item_name, $storage_area);
			$stmt -> execute($params);
			array_push($scanned_kanban_id_arr, $id);
		}

		if ($ongoing_count < 1) {
			update_notif_count($section, $status, $conn);
		} else {
			$sql = "SELECT `id` FROM `scanned_kanban` WHERE request_id = ? AND status = ? AND is_read = 1";
			$stmt = $conn -> prepare($sql);
			$params = array($request_id, $status);
			$stmt -> execute($params);
			$is_read_row_count = $stmt -> rowCount();

			$sql = "UPDATE `scanned_kanban` SET is_read = 0, is_read_fg = 0 WHERE request_id = ? AND status = ?";
			$stmt = $conn -> prepare($sql);
			$params = array($request_id, $status);
			$stmt -> execute($params);

			if ($is_read_row_count > 0) {
				update_notif_count($section, $status, $conn);
			}
		}

		$message = 'success';
	} else if ($check_inventory_ongoing == 'Inventory Limit Reached') {
		$message = 'Inventory Limit Reached';
	}

	$response_arr = array(
		'scanned_kanban_id_arr' => $scanned_kanban_id_arr,
		'message' => $message
	);

	echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

// Store Out Requested Arr
if ($method == 'store_out_requested_arr') {
	$requested_arr = [];
	$requested_arr = $_POST['requested_arr'];
	$request_id = $_POST['request_id'];
	$store_out_person = $_POST['store_out_person'];
	$status = 'Stored Out';
	$ongoing_request_arr = array();
	$kanban_history_id_arr = array();
	$response_arr = array();
	$message = '';
	$error = 0;

	$sql = "SELECT `id` FROM `kanban_history` WHERE request_id = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($request_id);
	$stmt -> execute($params);
	$stored_out_count = $stmt -> rowCount();

	foreach ($requested_arr as $id) {
		$sql = "SELECT `request_id`, `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `line_no`, `quantity`, `storage_area`, `section`, `route_no`, `requestor_id_no`, `requestor_name`, `requestor`, `scan_date_time`, `request_date_time`, `status` FROM `scanned_kanban` WHERE id = ? ORDER BY id ASC";
		$stmt = $conn -> prepare($sql);
		$params = array($id);
		$stmt -> execute($params);
		foreach($stmt -> fetchAll() as $row) {
			$quantity = intval($row['quantity']);
			$ongoing_request_arr = array(
				'request_id' => $row['request_id'],
				'kanban' => $row['kanban'],
				'kanban_no' => $row['kanban_no'],
				'serial_no' => $row['serial_no'],
				'item_no' => $row['item_no'],
				'item_name' => $row['item_name'],
				'line_no' => $row['line_no'],
				'quantity' => $quantity,
				'storage_area' => $row['storage_area'],
				'section' => $row['section'],
				'route_no' => $row['route_no'],
				'requestor_id_no' => $row['requestor_id_no'],
				'requestor_name' => $row['requestor_name'],
				'requestor' => $row['requestor'],
				'scan_date_time' => $row['scan_date_time'],
				'request_date_time' => $row['request_date_time'],
			);
			$insert_to_history = '';
			$delete_ongoing = '';
			$set_dist_remarks = '';

			insert_to_history($ongoing_request_arr, $store_out_person, $conn);
			update_kanban_no($row['kanban'], $row['serial_no'], $conn);
			$kanban_history_id = get_kanban_history_id($row['request_id'], $row['kanban'], $row['serial_no'], $conn);
			array_push($kanban_history_id_arr, $kanban_history_id);
			delete_ongoing($id, $conn);

			set_requestor_remarks_to_history($ongoing_request_arr['request_id'], $ongoing_request_arr['kanban'], $ongoing_request_arr['serial_no'], $conn);
		}
	}

	if ($stored_out_count < 1) {
		update_notif_count($ongoing_request_arr['section'], $status, $conn);
	} else {
		$sql = "SELECT `id` FROM `kanban_history` WHERE request_id = ? AND is_read = 1";
		$stmt = $conn -> prepare($sql);
		$params = array($request_id);
		$stmt -> execute($params);
		$is_read_row_count = $stmt -> rowCount();

		$sql = "UPDATE `kanban_history` SET is_read = 0 WHERE request_id = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($request_id);
		$stmt -> execute($params);

		if ($is_read_row_count > 0) {
			update_notif_count($ongoing_request_arr['section'], $status, $conn);
		}
	}
	
	$message = 'success';

	$response_arr = array(
		'kanban_history_id_arr' => $kanban_history_id_arr,
		'message' => $message
	);

	echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

if ($method == 'count_request_searched') {
	$request_date_from = $_POST['request_date_from'];
	$request_date_from = date_create($request_date_from);
	$request_date_from = date_format($request_date_from,"Y-m-d H:i:s");
	$request_date_to = $_POST['request_date_to'];
	$request_date_to = date_create($request_date_to);
	$request_date_to = date_format($request_date_to,"Y-m-d H:i:s");
	$line_no = $_POST['line_no'];
	$item_no = $_POST['item_no'];
	$item_name = $_POST['item_name'];
	$section = $_POST['section'];
	$status = $_POST['status'];
	$sql = "SELECT count(id) AS total FROM scanned_kanban";
	if ($section == 'All') {
		$sql = $sql . " WHERE line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND status = '$status' AND (request_date_time >= '$request_date_from' AND request_date_time <= '$request_date_to')";
	} else {
		$sql = $sql . " WHERE section = '$section' AND line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND status = '$status' AND (request_date_time >= '$request_date_from' AND request_date_time <= '$request_date_to')";
	}
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	}
}

if ($method == 'get_request_searched') {
	$id = $_POST['id'];
	$c = $_POST['c'];
	$request_date_from = $_POST['request_date_from'];
	$request_date_from = date_create($request_date_from);
	$request_date_from = date_format($request_date_from,"Y-m-d H:i:s");
	$request_date_to = $_POST['request_date_to'];
	$request_date_to = date_create($request_date_to);
	$request_date_to = date_format($request_date_to,"Y-m-d H:i:s");
	$line_no = $_POST['line_no'];
	$item_no = $_POST['item_no'];
	$item_name = $_POST['item_name'];
	$section = $_POST['section'];
	$status = $_POST['status'];
	$sql = "SELECT `id`, `request_id`, `kanban_no`, `item_no`, `item_name`, `line_no`, `quantity`, `storage_area`, `section`, `scan_date_time`, `request_date_time` FROM scanned_kanban";
	if (empty($id)) {
		if ($section == 'All') {
			$sql = $sql . " WHERE line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND status = '$status' AND (request_date_time >= '$request_date_from' AND request_date_time <= '$request_date_to') ORDER BY id DESC LIMIT 25";
		} else {
			$sql = $sql . " WHERE section = '$section' AND line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND status = '$status' AND (request_date_time >= '$request_date_from' AND request_date_time <= '$request_date_to') ORDER BY id DESC LIMIT 25";
		}
	} else if ($section == 'All') {
		$sql = $sql . " WHERE id < '$id' AND (line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND status = '$status' AND (request_date_time >= '$request_date_from' AND request_date_time <= '$request_date_to')) ORDER BY id DESC LIMIT 25";
	} else {
		$sql = $sql . " WHERE id < '$id' AND (section = '$section' AND line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND status = '$status' AND (request_date_time >= '$request_date_from' AND request_date_time <= '$request_date_to')) ORDER BY id DESC LIMIT 25";
	}
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr id="'.$row['id'].'"><td>'.$c.'</td><td>'.$row['request_id'].'</td><td>'.htmlspecialchars($row['line_no']).'</td><td>'.htmlspecialchars($row['storage_area']).'</td><td>'.$row['item_no'].'</td><td>'.htmlspecialchars($row['item_name']).'</td><td>'.$row['kanban_no'].'</td><td>'.$row['quantity'].'</td><td>'.htmlspecialchars($row['section']).'</td><td>'.date("Y-m-d h:iA", strtotime($row['scan_date_time'])).'</td><td>'.date("Y-m-d h:iA", strtotime($row['request_date_time'])).'</td></tr>';
		}
	} else {
		echo '<tr><td colspan="11" style="text-align:center; color:red;">No Request Found</td></tr>';
	}
}

$conn = null;
?>