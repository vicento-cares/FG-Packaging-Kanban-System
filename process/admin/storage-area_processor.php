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

function check_existing_storage_area($storage_area, $conn)
{
    $sql = "SELECT storage_area FROM storage_area WHERE storage_area = ?";
    $stmt = $conn->prepare($sql);
    $params = array($storage_area);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function insert_item_on_inventory($storage_area, $conn)
{
    $quantity = 0;
    $safety_stock = 0;
    $sql1 = "INSERT INTO inventory(item_no, item_name, storage_area, quantity, safety_stock) VALUES ";
    $subsql1 = "";
    $temp_count = 0;
    $sql = "SELECT item_no, item_name FROM items";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row_count = $stmt->rowCount();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $item_name = addslashes($row['item_name']);
        $subsql1 = $subsql1 . " (" . '\'' . $row['item_no'] . '\',' . '\'' . $item_name . '\',' . '\'' . $storage_area . '\',' . '\'' . $quantity . '\',' . '\'' . $safety_stock . '\',';
        $subsql1 = substr($subsql1, 0, strlen($subsql1) - 2);
        $subsql1 = $subsql1 . '\')' . " , ";
        if ($temp_count % 250 == 0) {
            $subsql1 = substr($subsql1, 0, strlen($subsql1) - 3);
            $sql1 = $sql1 . $subsql1 . ";";
            $sql1 = substr($sql1, 0, strlen($sql1));
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute();
            $sql1 = "INSERT INTO inventory(item_no, item_name, storage_area, quantity, safety_stock) VALUES ";
            $subsql1 = "";
        } else if ($temp_count == $row_count) {
            $subsql1 = substr($subsql1, 0, strlen($subsql1) - 3);
            $sql2 = $sql1 . $subsql1 . ";";
            $sql2 = substr($sql2, 0, strlen($sql2));
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute();
        }
    }
}

function get_storage_area($id, $conn)
{
    $sql = "SELECT storage_area FROM storage_area WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $params = array($id);
    $stmt->execute($params);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row['storage_area'];
    }
}

function update_storage_area_on_kanban($storage_area, $old_storage_area, $conn)
{
    $sql = "UPDATE kanban_masterlist SET storage_area = ? WHERE storage_area = ?";
    $stmt = $conn->prepare($sql);
    $params = array($storage_area, $old_storage_area);
    $stmt->execute($params);
}

function update_item_on_inventory($storage_area, $old_storage_area, $conn)
{
    $sql = "SELECT item_no, item_name FROM items";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $item_no = $row['item_no'];
        $item_name = addslashes($row['item_name']);
        $sql1 = "UPDATE inventory SET storage_area = ? WHERE item_no = ? AND item_name = ? AND storage_area = ?";
        $stmt1 = $conn->prepare($sql1);
        $params = array($storage_area, $item_no, $item_name, $old_storage_area);
        $stmt1->execute($params);
    }
}

function check_item_on_inventory($storage_area, $conn)
{
    $total_items = 0;
    $total_items_zero = 0;
    $sql = "SELECT count(id) AS total FROM inventory WHERE storage_area = ?";
    $stmt = $conn->prepare($sql);
    $params = array($storage_area);
    $stmt->execute($params);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $total_items = $row['total'];
    }

    $sql = "SELECT count(id) AS total FROM inventory WHERE storage_area = ? AND quantity = 0";
    $stmt = $conn->prepare($sql);
    $params = array($storage_area);
    $stmt->execute($params);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $total_items_zero = $row['total'];
    }

    if ($total_items == $total_items_zero) {
        return true;
    } else {
        return false;
    }
}

// Get Area Dropdown
if ($method == 'fetch_area_dropdown') {
    $sql = "SELECT storage_area FROM storage_area GROUP BY(storage_area) ORDER BY storage_area ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option disabled selected value="">Select Area</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . htmlspecialchars($row['storage_area']) . '">' . htmlspecialchars($row['storage_area']) . '</option>';
        }
    } else {
        echo '<option disabled selected value="">Select Area</option>';
    }
}

// Get Area Dropdown
if ($method == 'fetch_area_dropdown_fg') {
    $sql = "SELECT storage_area FROM storage_area GROUP BY(storage_area) ORDER BY storage_area ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option selected value="All">All Areas</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . htmlspecialchars($row['storage_area']) . '">' . htmlspecialchars($row['storage_area']) . '</option>';
        }
    } else {
        echo '<option disabled selected value="">Select Area</option>';
    }
}

// Count
if ($method == 'count_data') {
    $search = $_POST['search'];
    $sql = "SELECT count(id) AS total FROM storage_area";
    if (!empty($search)) {
        $sql = $sql . " WHERE storage_area LIKE '$search%'";
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
    $search = $_POST['search'];
    $c = $_POST['c'];
    $sql = "SELECT id, storage_area, date_updated FROM storage_area";

    if (!empty($id) && empty($search)) {
        $sql = $sql . " WHERE id > '$id'";
    } else if (empty($id) && !empty($search)) {
        $sql = $sql . " WHERE storage_area LIKE '$search%'";
    } else if (!empty($id) && !empty($search)) {
        $sql = $sql . " WHERE id > '$id' AND (storage_area LIKE '$search%')";
    }
    $sql = $sql . " ORDER BY id ASC LIMIT 10";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            echo '<tr style="cursor:pointer;" class="modal-trigger" id="' . $row['id'] . '" data-toggle="modal" data-target="#AreaInfoModal" data-id="' . $row['id'] . '" data-storage_area="' . htmlspecialchars($row['storage_area']) . '" data-date_updated="' . $row['date_updated'] . '" onclick="get_details(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . htmlspecialchars($row['storage_area']) . '</td>';
            echo '<td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td>';
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
    $storage_area = custom_trim($_POST['storage_area']);

    $is_valid_area = validate_area($storage_area);

    if ($is_valid_area == true) {
        $is_existing = check_existing_storage_area($storage_area, $conn);

        if ($is_existing == false) {
            $sql = "INSERT INTO storage_area (storage_area, date_updated) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $params = array($storage_area, $date_updated);
            $stmt->execute($params);
            insert_item_on_inventory($storage_area, $conn);
            echo 'success';
        } else {
            echo 'Already Exists';
        }
    } else {
        echo 'Invalid Area';
    }
}

// Update / Edit
if ($method == 'update_data') {
    $id = $_POST['id'];
    $storage_area = custom_trim($_POST['storage_area']);

    $is_valid_area = validate_area($storage_area);

    if ($is_valid_area == true) {
        $old_storage_area = get_storage_area($id, $conn);
        $is_existing = check_existing_storage_area($storage_area, $conn);

        if ($is_existing == false) {
            $sql = "UPDATE storage_area SET storage_area = ?, date_updated = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $params = array($storage_area, $date_updated, $id);
            $stmt->execute($params);
            update_item_on_inventory($storage_area, $old_storage_area, $conn);
            update_storage_area_on_kanban($storage_area, $old_storage_area, $conn);
            echo 'success';
        } else {
            echo 'Already Exists';
        }
    } else {
        echo 'Invalid Area';
    }
}

// Delete
if ($method == 'delete_data') {
    $id = $_POST['id'];

    $storage_area = get_storage_area($id, $conn);
    $delete = check_item_on_inventory($storage_area, $conn);

    if ($delete == true) {
        $sql = "DELETE FROM inventory WHERE storage_area = ?";
        $stmt = $conn->prepare($sql);
        $params = array($storage_area);
        $stmt->execute($params);

        $sql = "DELETE FROM storage_area WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $params = array($id);
        $stmt->execute($params);
        echo 'success';
    } else {
        echo 'Not Empty';
    }
}

$conn = null;
