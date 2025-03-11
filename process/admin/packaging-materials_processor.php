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

function get_last_item_no($conn)
{
    $sql = "SELECT item_no FROM inventory ORDER BY item_no DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return intval($row['item_no']);
    }
}

function insert_item_on_inventory($item_no, $item_name, $conn)
{
    $quantity = 0;
    $safety_stock = 0;
    $sql1 = "INSERT INTO inventory(item_no, item_name, storage_area, quantity, safety_stock) VALUES ";
    $subsql1 = "";
    $temp_count = 0;
    $sql = "SELECT storage_area FROM storage_area";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row_count = $stmt->rowCount();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $subsql1 = $subsql1 . " (" . '\'' . $item_no . '\',' . '\'' . addslashes($item_name) . '\',' . '\'' . $row['storage_area'] . '\',' . '\'' . $quantity . '\',' . '\'' . $safety_stock . '\',';
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

function check_existing_item_name($item_name, $conn)
{
    $sql = "SELECT id FROM items WHERE item_name = ?";
    $stmt = $conn->prepare($sql);
    $params = array($item_name);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function change_item_name($id, $item_name, $item_no, $conn)
{
    $sql = "SELECT item_name FROM items WHERE item_name = ?";
    $stmt = $conn->prepare($sql);
    $params = array($item_name);
    $stmt->execute($params);
    if ($stmt->rowCount() <= 0) {
        $sql = "UPDATE items SET item_name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $params = array($item_name, $id);
        $stmt->execute($params);

        $sql = "UPDATE inventory SET item_name = ? WHERE item_no = ?";
        $stmt = $conn->prepare($sql);
        $params = array($item_name, $item_no);
        $stmt->execute($params);

        $sql = "UPDATE kanban_masterlist SET item_name = ? WHERE item_no = ?";
        $stmt = $conn->prepare($sql);
        $params = array($item_name, $item_no);
        $stmt->execute($params);
    }
}

function check_existing_item_name_update($id, $item_name, $conn)
{
    $sql = "SELECT id FROM items WHERE id != ? AND item_name = ?";
    $stmt = $conn->prepare($sql);
    $params = array($id, $item_name);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function check_inventory_item_delete($item_no, $conn)
{
    $sql = "SELECT quantity FROM inventory WHERE item_no = ?";
    $message = false;
    $stmt = $conn->prepare($sql);
    $params = array($item_no);
    $stmt->execute($params);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['quantity'] != 0) {
            $message = true;
        }
    }
    return $message;
}

function check_kanban_item_delete($item_no, $conn)
{
    $sql = "SELECT id FROM kanban_masterlist WHERE item_no = ?";
    $stmt = $conn->prepare($sql);
    $params = array($item_no);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

// Get Items Dropdown
if ($method == 'fetch_items_dropdown') {
    $sql = "SELECT item_no, item_name FROM items GROUP BY(item_name) ORDER BY item_name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option disabled selected value="">Select Item Name</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . $row['item_no'] . '">' . htmlspecialchars($row['item_name']) . '</option>';
        }
    } else {
        echo '<option disabled selected value="">Select Item Name</option>';
    }
}

if ($method == 'fetch_items_datalist') {
    $sql = "SELECT item_name FROM items GROUP BY(item_name) ORDER BY item_name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . htmlspecialchars($row['item_name']) . '">';
        }
    }
}

if ($method == 'get_item_details') {
    $item_no = $_POST['item_no'];
    $dimension = 'N/A';
    $size = 'N/A';
    $color = 'N/A';
    $quantity = 0;

    if (!empty($item_no)) {
        $sql = "SELECT dimension, size, color, pcs_bundle FROM items WHERE item_no = ?";
        $stmt = $conn->prepare($sql);
        $params = array($item_no);
        $stmt->execute($params);
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $row) {
                $dimension = $row['dimension'];
                $size = $row['size'];
                $color = $row['color'];
                $quantity = intval($row['pcs_bundle']);
            }

            $response_arr = array(
                'dimension' => $dimension,
                'size' => $size,
                'color' => $color,
                'quantity' => $quantity
            );

            echo json_encode($response_arr, JSON_FORCE_OBJECT);
        }
    }
}

// Count
if ($method == 'count_data') {
    $search = $_POST['search'];
    $sql = "SELECT count(id) AS total FROM items";
    if (!empty($search)) {
        $sql = $sql . " WHERE item_no LIKE '%$search%' OR item_name LIKE '$search%'";
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
    $sql = "SELECT id, item_no, item_name, dimension, size, color, pcs_bundle, req_quantity, date_updated FROM items";

    if (!empty($id) && empty($search)) {
        $sql = $sql . " WHERE id > '$id'";
    } else if (empty($id) && !empty($search)) {
        $sql = $sql . " WHERE item_no LIKE '%$search%' OR item_name LIKE '$search%'";
    } else if (!empty($id) && !empty($search)) {
        $sql = $sql . " WHERE id > '$id' AND (item_no LIKE '%$search%' OR item_name LIKE '$search%')";
    }
    $sql = $sql . " ORDER BY id ASC LIMIT 10";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            echo '<tr style="cursor:pointer;" class="modal-trigger" id="' . $row['id'] . '" data-toggle="modal" data-target="#PackagingMaterialsInfoModal" data-id="' . $row['id'] . '" data-item_no="' . $row['item_no'] . '" data-item_name="' . htmlspecialchars($row['item_name']) . '" data-dimension="' . htmlspecialchars($row['dimension']) . '" data-size="' . htmlspecialchars($row['size']) . '" data-color="' . htmlspecialchars($row['color']) . '" data-pcs_bundle="' . htmlspecialchars($row['pcs_bundle']) . '" data-req_quantity="' . $row['req_quantity'] . '" data-date_updated="' . $row['date_updated'] . '" onclick="get_details(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['item_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['item_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['pcs_bundle']) . '</td>';
            echo '<td>' . $row['req_quantity'] . '</td>';
            echo '<td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td>';
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
    $item_no = str_pad($_POST['item_no'], 5, '0', STR_PAD_LEFT);
    $item_name = custom_trim($_POST['item_name']);
    $dimension = custom_trim($_POST['dimension']);
    $size = custom_trim($_POST['size']);
    $color = custom_trim($_POST['color']);
    $pcs_bundle = custom_trim($_POST['pcs_bundle']);
    $req_quantity = $_POST['req_quantity'];

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
    $is_valid_item_no = validate_item_no($item_no);
    $is_valid_item_name = validate_item_name($item_name);
    $is_valid_pcs_bundle = validate_pcs_bundle($pcs_bundle);

    if ($is_valid_item_no == true) {
        if ($is_valid_item_name == true) {
            if ($is_valid_pcs_bundle == true) {
                if ($req_quantity != '') {
                    $is_valid = true;
                } else {
                    echo 'Req Qty Not Set';
                }
            } else {
                echo 'Invalid Pcs Bundle' . $item_no;
            }
        } else {
            echo 'Invalid Item Name';
        }
    } else {
        echo 'Invalid Item No.';
    }

    if ($is_valid == true) {
        $is_existing = check_existing_item_name($item_name, $conn);
        if ($is_existing == false) {
            // Increment Item No
            if ($item_no == '00000') {
                $last_item_no = get_last_item_no($conn);
                $item_no = $last_item_no + 1;
                $item_no = str_pad($item_no, 5, '0', STR_PAD_LEFT);
            }

            $sql = "INSERT INTO items (item_no, item_name, dimension, size, color, pcs_bundle, req_quantity, date_updated) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $params = array($item_no, $item_name, $dimension, $size, $color, $pcs_bundle, $req_quantity, $date_updated);
            $stmt->execute($params);
            insert_item_on_inventory($item_no, $item_name, $conn);
            echo 'success';
        } else {
            echo 'Already Exists';
        }
    }
}

// Update / Edit
if ($method == 'update_data') {
    $id = $_POST['id'];
    $item_no = $_POST['item_no'];
    $item_name = custom_trim($_POST['item_name']);
    $dimension = custom_trim($_POST['dimension']);
    $size = custom_trim($_POST['size']);
    $color = custom_trim($_POST['color']);
    $pcs_bundle = custom_trim($_POST['pcs_bundle']);
    $req_quantity = $_POST['req_quantity'];

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
    $is_valid_item_name = validate_item_name($item_name);
    $is_valid_pcs_bundle = validate_pcs_bundle($pcs_bundle);

    if ($is_valid_item_name == true) {
        if ($is_valid_pcs_bundle == true) {
            if ($req_quantity != '') {
                $is_valid = true;
            } else {
                echo 'Req Qty Not Set';
            }
        } else {
            echo 'Invalid Pcs Bundle';
        }
    } else {
        echo 'Invalid Item Name';
    }

    if ($is_valid == true) {
        $is_existing = check_existing_item_name_update($id, $item_name, $conn);
        if ($is_existing == false) {
            change_item_name($id, $item_name, $item_no, $conn);

            $sql = "UPDATE items SET dimension = ?, size = ?, color = ?, pcs_bundle = ?, req_quantity = ?, date_updated = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $params = array($dimension, $size, $color, $pcs_bundle, $req_quantity, $date_updated, $id);
            $stmt->execute($params);
            echo 'success';
        } else {
            echo 'Already Exists';
        }
    }
}

// Delete
if ($method == 'delete_data') {
    $id = $_POST['id'];
    $item_no = $_POST['item_no'];

    $has_inventory = check_inventory_item_delete($item_no, $conn);
    $has_kanban = check_kanban_item_delete($item_no, $conn);

    if ($has_inventory == false) {
        if ($has_kanban == false) {
            $sql = "DELETE FROM inventory WHERE item_no = ?";
            $stmt = $conn->prepare($sql);
            $params = array($item_no);
            $stmt->execute($params);

            $sql = "DELETE FROM items WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $params = array($id);
            $stmt->execute($params);
            echo 'success';
        } else {
            echo 'Kanban Exists';
        }
    } else {
        echo 'Not Empty';
    }
}

$conn = null;
