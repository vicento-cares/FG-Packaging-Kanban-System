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
$date_updated = date('Y-m-d H:i:s');

// Check section of Requestor
function check_section_requestor($id_no, $section, $ip, $conn) {
	$sql = "SELECT `id` FROM `section` WHERE section = ? AND ip = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($section, $ip);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		$sql = "SELECT `id_no` FROM `requestor_account` WHERE id_no = ? AND section = ?";
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

function check_existing_id_no($id_no, $conn) {
	$sql = "SELECT `id_no` FROM `requestor_account` WHERE id_no = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($id_no);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return true;
	} else {
		return false;
	}
}

function change_id_no($id, $id_no, $date_updated, $conn) {
	$sql = "SELECT `id_no` FROM `requestor_account` WHERE id_no = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($id_no);
	$stmt -> execute($params);
	if ($stmt -> rowCount() <= 0) {
		$sql = "UPDATE `requestor_account` SET `id_no`= ?, `date_updated`= ? WHERE `id`= ?";
		$stmt = $conn -> prepare($sql);
		$params = array($id_no, $date_updated, $id);
		$stmt -> execute($params);
		return true;
	} else {
		return false;
	}
}

// Count
if ($method == 'count_data') {
	$search = $_POST['search'];
	$sql = "SELECT count(id) AS total FROM `requestor_account`";
	if (!empty($search)) {
		$sql = $sql . " WHERE id_no LIKE '$search%' OR name LIKE '$search%' OR section LIKE '$search%' OR car_model LIKE '$search%' OR line_no LIKE '$search%' OR requestor LIKE '$search%'";
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
	$sql = "SELECT `id`, `id_no`, `name`, `section`, `car_model`, `line_no`, `factory_area`, `requestor`, `date_updated` FROM `requestor_account`";

	if (!empty($id) && empty($search)) {
		$sql = $sql . " WHERE id > '$id'";
	} else if (empty($id) && !empty($search)) {
		$sql = $sql . " WHERE id_no LIKE '$search%' OR name LIKE '$search%' OR section LIKE '$search%' OR car_model LIKE '$search%' OR line_no LIKE '$search%' OR requestor LIKE '$search%'";
	} else if (!empty($id) && !empty($search)) {
		$sql = $sql . " WHERE id > '$id' AND (id_no LIKE '$search%' OR name LIKE '$search%' OR section LIKE '$search%' OR car_model LIKE '$search%' OR line_no LIKE '$search%' OR requestor LIKE '$search%')";
	}
	$sql = $sql . " ORDER BY id ASC LIMIT 10";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr style="cursor:pointer;" class="modal-trigger" id="'.$row['id'].'" data-toggle="modal" data-target="#RAccountInfoModal" data-id="'.$row['id'].'" data-id_no="'.htmlspecialchars($row['id_no']).'" data-name="'.htmlspecialchars($row['name']).'" data-section="'.htmlspecialchars($row['section']).'" data-car_model="'.htmlspecialchars(addslashes($row['car_model'])).'" data-line_no="'.htmlspecialchars($row['line_no']).'" data-factory_area="'.htmlspecialchars($row['factory_area']).'" data-requestor="'.htmlspecialchars($row['requestor']).'" data-date_updated="'.$row['date_updated'].'" onclick="get_details(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.htmlspecialchars($row['id_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['name']).'</td>';
			echo '<td>'.htmlspecialchars($row['section']).'</td>';
			echo '<td>'.htmlspecialchars($row['car_model']).'</td>';
			echo '<td>'.htmlspecialchars($row['line_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['requestor']).'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['date_updated'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Create / Insert
if ($method == 'save_data') {
	$id_no = strtoupper(custom_trim($_POST['id_no']));
	$name = custom_trim($_POST['name']);
	$section = $_POST['section'];
	$car_model = custom_trim($_POST['car_model']);
	$line_no = strtoupper(preg_replace("/\s+/", "", $_POST['line_no']));
	$factory_area = $_POST['factory_area'];
	$requestor = strtoupper(custom_trim($_POST['requestor']));

	$is_valid = false;
	$is_valid_id_no = validate_id_no($id_no);
	$is_valid_name = validate_name($name);
	$is_valid_line_no = validate_line_no($line_no);
	$is_valid_requestor = validate_requestor($requestor);

	if ($is_valid_id_no == true) {
		if ($is_valid_name == true) {
			if ($is_valid_line_no == true) {
				if ($is_valid_requestor == true) {
					$line_exists = check_line_no($line_no, $conn);
					if ($line_exists == true) {
						$is_valid = true;
					} else {
						echo 'Line No. Doesn\'t Exists';
					}
				} else {
					echo 'Invalid Requestor';
				}
			} else {
				echo 'Invalid Line No.';
			}
		} else {
			echo 'Invalid Name';
		}
	} else {
		echo 'Invalid ID No.';
	}

	if ($is_valid == true) {
		$is_existing = check_existing_id_no($id_no, $conn);
		if ($is_existing == false) {
			$sql = "INSERT INTO `requestor_account` (`id_no`, `name`, `section`, `car_model`, `line_no`, `factory_area`, `requestor`, `date_updated`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			$stmt = $conn -> prepare($sql);
			$params = array($id_no, $name, $section, $car_model, $line_no, $factory_area, $requestor, $date_updated);
			$stmt -> execute($params);
			echo 'success';
		} else {
			echo 'ID No. Exists';
		}
	}
}

// Update / Edit
if ($method == 'update_id_no') {
	$id = $_POST['id'];
	$id_no = strtoupper(custom_trim($_POST['id_no']));

	$is_valid_id_no = validate_id_no($id_no);

	if ($is_valid_id_no == true) {
		$is_changed = change_id_no($id, $id_no, $date_updated, $conn);
		if ($is_changed == true) {
			echo 'success';
		} else {
			echo 'ID No. Exists';
		}
	} else {
		echo 'Invalid ID No.';
	}
}

// Update / Edit
if ($method == 'update_data') {
	$id = $_POST['id'];
	$name = custom_trim($_POST['name']);
	$section = $_POST['section'];
	$car_model = custom_trim($_POST['car_model']);
	$line_no = strtoupper(preg_replace("/\s+/", "", $_POST['line_no']));
	$factory_area = $_POST['factory_area'];
	$requestor = strtoupper(custom_trim($_POST['requestor']));

	$is_valid = false;
	$is_valid_name = validate_name($name);
	$is_valid_line_no = validate_line_no($line_no);
	$is_valid_requestor = validate_requestor($requestor);

	if ($is_valid_name == true) {
		if ($is_valid_line_no == true) {
			if ($is_valid_requestor == true) {
				$line_exists = check_line_no($line_no, $conn);
				if ($line_exists == true) {
					$is_valid = true;
				} else {
					echo 'Line No. Doesn\'t Exists';
				}
			} else {
				echo 'Invalid Requestor';
			}
		} else {
			echo 'Invalid Line No.';
		}
	} else {
		echo 'Invalid Name';
	}

	if ($is_valid == true) {
		$sql = "UPDATE `requestor_account` SET `name`= ?, `section`= ?, `car_model`= ?, `line_no`= ?, `factory_area`= ?, `requestor`= ?, `date_updated`= ? WHERE `id`= ?";
		$stmt = $conn -> prepare($sql);
		$params = array($name, $section, $car_model, $line_no, $factory_area, $requestor, $date_updated, $id);
		$stmt -> execute($params);
		echo 'success';
	}
}

// Delete
if ($method == 'delete_data') {
	$id = $_POST['id'];

	$sql = "DELETE FROM `requestor_account` WHERE id = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($id);
	$stmt -> execute($params);
	echo 'success';
}

$conn = null;
?>