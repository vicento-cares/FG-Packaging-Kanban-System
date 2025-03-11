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

// Count
if ($method == 'count_data') {
    $line_no = $_POST['line_no'];
    $item_no = $_POST['item_no'];
    $item_name = addslashes($_POST['item_name']);
    $sql = "SELECT count(id) AS total FROM kanban_masterlist";
    if (!empty($line_no) || !empty($item_no) || !empty($item_name)) {
        $sql = $sql . " WHERE line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%'";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['total'];
        }
    }
}

// Read / Load
if ($method == 'fetch_data') {
    $id = $_POST['id'];
    $line_no = $_POST['line_no'];
    $item_no = $_POST['item_no'];
    $item_name = addslashes($_POST['item_name']);
    $c = $_POST['c'];
    $sql = "SELECT id, batch_no, kanban, kanban_no, serial_no, item_no, item_name, section, line_no, dimension, size, color, quantity, storage_area, req_limit, req_limit_qty, req_limit_time, date_updated FROM kanban_masterlist";

    if (empty($id)) {
        if (!empty($line_no) || !empty($item_no) || !empty($item_name)) {
            $sql = $sql . " WHERE line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%'";
        }
    } else if (empty($line_no) && empty($item_no) && empty($item_name)) {
        $sql = $sql . " WHERE id > '$id'";
    } else {
        $sql = $sql . " WHERE id > '$id' AND (line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%')";
    }
    $sql = $sql . " ORDER BY id ASC LIMIT 25";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            echo '<tr style="cursor:pointer;" class="modal-trigger" id="' . $row['id'] . '" data-toggle="modal" data-target="#KanbanInfoModal" data-id="' . $row['id'] . '" data-batch_no="' . $row['batch_no'] . '" data-kanban="' . htmlspecialchars($row['kanban']) . '" data-kanban_no="' . $row['kanban_no'] . '" data-serial_no="' . $row['serial_no'] . '" data-item_no="' . $row['item_no'] . '" data-item_name="' . htmlspecialchars($row['item_name']) . '" data-section="' . htmlspecialchars($row['section']) . '" data-line_no="' . htmlspecialchars($row['line_no']) . '" data-dimension="' . htmlspecialchars($row['dimension']) . '" data-size="' . htmlspecialchars($row['size']) . '" data-color="' . htmlspecialchars($row['color']) . '" data-quantity="' . $row['quantity'] . '" data-storage_area="' . htmlspecialchars($row['storage_area']) . '" data-req_limit="' . $row['req_limit'] . '" data-req_limit_qty="' . $row['req_limit_qty'] . '" data-req_limit_time="' . $row['req_limit_time'] . '" data-date_updated="' . $row['date_updated'] . '" onclick="get_details(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . htmlspecialchars($row['line_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['storage_area']) . '</td>';
            echo '<td>' . htmlspecialchars($row['item_name']) . '</td>';
            echo '<td>' . $row['quantity'] . '</td>';
            echo '<td>' . htmlspecialchars($row['section']) . '</td>';
            echo '<td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="7" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

// Create / Insert
if ($method == 'save_data') {
    $date_generated = date("ymdHis");
    $item_no = str_pad($_POST['item_no'], 5, '0', STR_PAD_LEFT);
    $section = $_POST['section'];
    $item_name = custom_trim($_POST['item_name']);
    $line_no = strtoupper(preg_replace("/\s+/", "", $_POST['line_no']));
    $dimension = custom_trim($_POST['dimension']);
    $size = custom_trim($_POST['size']);
    $color = custom_trim($_POST['color']);
    $quantity = intval($_POST['quantity']);
    $storage_area = $_POST['storage_area'];
    $req_limit = intval($_POST['req_limit']);

    if (empty($dimension)) {
        $dimension = 'N/A';
    }
    if (empty($size)) {
        $size = 'N/A';
    }
    if (empty($color)) {
        $color = 'N/A';
    }

    $is_valid = false;
    $is_valid_line_no = validate_line_no($line_no);

    if ($item_no != '00000') {
        if ($is_valid_line_no == true) {
            if ($storage_area != '') {
                $line_exists = check_line_no($line_no, $conn);
                if ($line_exists == true) {
                    $is_valid = true;
                } else {
                    echo 'Line No. Doesn\'t Exists';
                }
            } else {
                echo 'Area Not Set';
            }
        } else {
            echo 'Invalid Line No.';
        }
    } else {
        echo 'Item Name Not Set';
    }

    if ($is_valid == true) {
        if ($quantity != '' && $quantity > 0) {
            $route_no = get_route_number($line_no, $conn);
            $item_name_generated = preg_replace('/\s+/', '', $item_name);
            $section_generated = preg_replace('/\s+/', '', $section);
            $words = preg_split("/[\s,_-]+/", $storage_area);
            $acronym = "";
            foreach ($words as $w) {
                $acronym .= mb_substr($w, 0, 1);
            }
            $kanban = $item_name_generated . '_' . $section_generated . '_' . $line_no . '_' . $acronym . '_' . $quantity . '_' . $item_no . '_' . $date_generated;

            $kanban_no = 0;

            $rand2 = substr(md5(microtime()), rand(0, 26), 5);
            $rand3 = substr(md5(microtime()), rand(0, 26), 5);
            $serial_no = 'SN-' . $rand2 . '' . $item_no . '' . $rand3;

            $batch_no = date("ymdh");
            $rand = substr(md5(microtime()), rand(0, 26), 5);
            $batch_no = 'BAT:' . $batch_no;
            $batch_no = $batch_no . '' . $rand;

            $sql = "INSERT INTO kanban_masterlist (batch_no, kanban, kanban_no, serial_no, item_no, item_name, section, line_no, route_no, dimension, size, color, quantity, storage_area, req_limit, req_limit_qty, date_updated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $params = array($batch_no, $kanban, $kanban_no, $serial_no, $item_no, $item_name, $section, $line_no, $route_no, $dimension, $size, $color, $quantity, $storage_area, $req_limit, $req_limit, $date_updated);
            $stmt->execute($params);
            echo 'success';
        } else {
            echo 'Zero Quantity';
        }
    }
}

// Update / Edit
if ($method == 'update_data') {
    $id = $_POST['id'];
    $item_no = str_pad($_POST['item_no'], 5, '0', STR_PAD_LEFT);
    $item_name = custom_trim($_POST['item_name']);
    $section = $_POST['section'];
    $line_no = strtoupper(preg_replace("/\s+/", "", $_POST['line_no']));
    $size = custom_trim($_POST['size']);
    $dimension = custom_trim($_POST['dimension']);
    $color = custom_trim($_POST['color']);
    $quantity = intval($_POST['quantity']);
    $storage_area = $_POST['storage_area'];
    $req_limit = intval($_POST['req_limit']);
    $req_limit_time = $_POST['req_limit_time'];
    $req_limit_time = date('H:i:s', strtotime("$req_limit_time"));

    if (empty($dimension)) {
        $dimension = 'N/A';
    }
    if (empty($size)) {
        $size = 'N/A';
    }
    if (empty($color)) {
        $color = 'N/A';
    }

    $is_valid = false;
    $is_valid_line_no = validate_line_no($line_no);

    if ($item_no != '00000') {
        if ($is_valid_line_no == true) {
            if ($storage_area != '') {
                if ($req_limit != '' && $req_limit > 0) {
                    if ($quantity != '' && $quantity > 0) {
                        $line_exists = check_line_no($line_no, $conn);
                        if ($line_exists == true) {
                            $is_valid = true;
                        } else {
                            echo 'Line No. Doesn\'t Exists';
                        }
                    } else {
                        echo 'Zero Quantity';
                    }
                } else {
                    echo 'Zero Limit';
                }
            } else {
                echo 'Area Not Set';
            }
        } else {
            echo 'Invalid Line No.';
        }
    } else {
        echo 'Item Name Not Set';
    }

    if ($is_valid == true) {
        $route_no = get_route_number($line_no, $conn);
        $sql = "UPDATE kanban_masterlist SET item_no = ?, item_name = ?, section = ?, line_no = ?, route_no = ?, dimension = ?, size = ?, color = ?, quantity = ?, storage_area = ?, date_updated = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $params = array($item_no, $item_name, $section, $line_no, $route_no, $dimension, $size, $color, $quantity, $storage_area, $date_updated, $id);
        $stmt->execute($params);

        $sql = "SELECT id FROM kanban_masterlist WHERE item_no = ? AND line_no = ? AND req_limit = ? AND req_limit_time = ?";
        $stmt = $conn->prepare($sql);
        $params = array($item_no, $line_no, $req_limit, $req_limit_time);
        $stmt->execute($params);
        if ($stmt->rowCount() <= 0) {
            $sql = "UPDATE kanban_masterlist SET req_limit = ?, req_limit_time = ?, date_updated = ? WHERE item_no = ? AND line_no = ?";
            $stmt = $conn->prepare($sql);
            $params = array($req_limit, $req_limit_time, $date_updated, $item_no, $line_no);
            $stmt->execute($params);
        }
        echo 'success';
    }
}

// Delete
if ($method == 'delete_data') {
    $id = $_POST['id'];

    $sql = "DELETE FROM kanban_masterlist WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $params = array($id);
    $stmt->execute($params);
    echo 'success';
}

$conn = null;
