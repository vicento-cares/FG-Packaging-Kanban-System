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

function check_duplicate_route_no($route_no, $section, $car_model, $line_no, $factory_area, $conn) {
	$sql = "SELECT `id` FROM `route_no` WHERE route_no = ? AND section = ? AND car_model = ? AND line_no = ? AND factory_area = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($route_no, $section, $car_model, $line_no, $factory_area);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return true;
	} else {
		return false;
	}
}

function check_existing_route_no($line_no, $conn) {
	$sql = "SELECT `id` FROM `route_no` WHERE line_no = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($line_no);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return true;
	} else {
		return false;
	}
}

function check_existing_route_no_update($id, $line_no, $conn) {
	$sql = "SELECT `id` FROM `route_no` WHERE id != ? AND line_no = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($id, $line_no);
	$stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return true;
	} else {
		return false;
	}
}

// Get Line Datalist
if ($method == 'fetch_line_datalist') {
	$sql = "SELECT `line_no` FROM `route_no` ORDER BY line_no ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['line_no']).'">';
		}
	}
}

if ($method == 'get_route_details') {
	$line_no = $_POST['line_no'];
	$section = '';
	$car_model = '';
	$factory_area = '';

	if (!empty($line_no)) {
		$sql = "SELECT `line_no`, `section`, `car_model`, `factory_area` FROM `route_no` WHERE line_no = ?";
		$stmt = $conn -> prepare($sql);
		$params = array($line_no);
		$stmt -> execute($params);
		if ($stmt -> rowCount() > 0) {
			while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
				$line_no = $row['line_no'];
				$section = $row['section'];
				$car_model = $row['car_model'];
				$factory_area = $row['factory_area'];
			}
		}
	}

	$response_arr = array(
		'line_no' => htmlspecialchars($line_no),
		'section' => htmlspecialchars($section),
		'car_model' => htmlspecialchars($car_model),
		'factory_area' => htmlspecialchars($factory_area)
	);

	echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

// Count
if ($method == 'count_data') {
	$search = $_POST['search'];
	$sql = "SELECT count(id) AS total FROM `route_no`";
	if (!empty($search)) {
		$sql = $sql . " WHERE route_no LIKE '$search%' OR section LIKE '$search%' OR car_model LIKE '$search%' OR line_no LIKE '$search%'";
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
	$sql = "SELECT `id`, `route_no`, `section`, `car_model`, `line_no`, `factory_area`, `date_updated` FROM `route_no`";

	if (!empty($id) && empty($search)) {
		$sql = $sql . " WHERE id > '$id'";
	} else if (empty($id) && !empty($search)) {
		$sql = $sql . " WHERE route_no LIKE '$search%' OR section LIKE '$search%' OR car_model LIKE '$search%' OR line_no LIKE '$search%'";
	} else if (!empty($id) && !empty($search)) {
		$sql = $sql . " WHERE id > '$id' AND (route_no LIKE '$search%' OR section LIKE '$search%' OR car_model LIKE '$search%' OR line_no LIKE '$search%')";
	}
	$sql = $sql . " ORDER BY id ASC LIMIT 10";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr style="cursor:pointer;" class="modal-trigger" id="'.$row['id'].'" data-toggle="modal" data-target="#RouteInfoModal" data-id="'.$row['id'].'" data-route_no="'.$row['route_no'].'" data-section="'.htmlspecialchars($row['section']).'" data-car_model="'.htmlspecialchars($row['car_model']).'" data-line_no="'.htmlspecialchars($row['line_no']).'" data-factory_area="'.htmlspecialchars($row['factory_area']).'" data-date_updated="'.$row['date_updated'].'" onclick="get_details(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['route_no'].'</td>';
			echo '<td>'.htmlspecialchars($row['section']).'</td>';
			echo '<td>'.htmlspecialchars($row['car_model']).'</td>';
			echo '<td>'.htmlspecialchars($row['line_no']).'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['date_updated'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="6" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Create / Insert
if ($method == 'save_data') {
	$route_no = custom_trim($_POST['route_no']);
	$section = $_POST['section'];
	$car_model = custom_trim($_POST['car_model']);
	$line_no = strtoupper(preg_replace("/\s+/", "", $_POST['line_no']));
	$factory_area = $_POST['factory_area'];

	$is_valid = false;
	$is_valid_route_no = validate_route_no($route_no);
	$is_valid_line_no = validate_line_no($line_no);

	if (!empty($route_no) && $is_valid_route_no == true) {
		if ($section != '') {
			if (!empty($car_model) && $car_model != ' ') {
				if ($is_valid_line_no == true) {
					if ($factory_area != '') {
						$is_valid = true;
					} else {
						echo 'Factory Area Not Set';
					}
				} else {
					echo 'Invalid Line No.';
				}
			} else {
				echo 'Car Model Not Set';
			}
		} else {
			echo 'Section Not Set';
		}
	} else {
		echo 'Invalid Route No.';
	}

	if ($is_valid == true) {
		$is_duplicate = check_duplicate_route_no($route_no, $section, $car_model, $line_no, $factory_area, $conn);
		$is_existing = check_existing_route_no($line_no, $conn);
		if ($is_duplicate == false) {
			if ($is_existing == false) {
				$sql = "INSERT INTO `route_no` (`route_no`, `section`, `car_model`, `line_no`, `factory_area`, `date_updated`) VALUES (?, ?, ?, ?, ?, ?)";
				$stmt = $conn -> prepare($sql);
				$params = array($route_no, $section, $car_model, $line_no, $factory_area, $date_updated);
				$stmt -> execute($params);
				echo 'success';
			} else {
				echo 'Already Exists';
			}
		} else {
			echo 'Duplicate';
		}
	}
}

// Update / Edit
if ($method == 'update_data') {
	$id = $_POST['id'];
	$route_no = custom_trim($_POST['route_no']);
	$section = $_POST['section'];
	$car_model = custom_trim($_POST['car_model']);
	$line_no = strtoupper(preg_replace("/\s+/", "", $_POST['line_no']));
	$factory_area = $_POST['factory_area'];

	$is_valid = false;
	$is_valid_route_no = validate_route_no($route_no);
	$is_valid_line_no = validate_line_no($line_no);

	if (!empty($route_no) && $is_valid_route_no == true) {
		if ($section != '') {
			if (!empty($car_model) && $car_model != ' ') {
				if ($is_valid_line_no == true) {
					if ($factory_area != '') {
						$is_valid = true;
					} else {
						echo 'Factory Area Not Set';
					}
				} else {
					echo 'Invalid Line No.';
				}
			} else {
				echo 'Car Model Not Set';
			}
		} else {
			echo 'Section Not Set';
		}
	} else {
		echo 'Invalid Route No.';
	}

	if ($is_valid == true) {
		$is_existing = check_existing_route_no_update($id, $line_no, $conn);
		if ($is_existing == false) {
			$sql = "UPDATE `route_no` SET `route_no`= ?, `section`= ?, `car_model`= ?, `line_no`= ?, `factory_area`= ?, `date_updated`= ? WHERE `id`= ?";
			$stmt = $conn -> prepare($sql);
			$params = array($route_no, $section, $car_model, $line_no, $factory_area, $date_updated, $id);
			$stmt -> execute($params);
			echo 'success';
		} else {
			echo 'Already Exists';
		}
	}
}

// Delete
if ($method == 'delete_data') {
	$id = $_POST['id'];

	$sql = "DELETE FROM `route_no` WHERE id = ?";
	$stmt = $conn -> prepare($sql);
	$params = array($id);
	$stmt -> execute($params);
	echo 'success';
}

$conn = null;
?>