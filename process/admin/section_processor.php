<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');
require('../lib/validate.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];
$date_updated = date('Y-m-d H:i:s');

function check_duplicate_section($section, $ip, $conn)
{
    $sql = "SELECT id FROM section WHERE section = ? AND ip = ?";
    $stmt = $conn->prepare($sql);
    $params = array($section, $ip);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function check_existing_section_ip($id, $ip, $conn)
{
    $sql = "SELECT id FROM section WHERE id != ? AND ip = ?";
    $stmt = $conn->prepare($sql);
    $params = array($id, $ip);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function insert_section_on_notif($section, $conn)
{
    $sql = "SELECT id FROM notification_count WHERE interface = ?";
    $stmt = $conn->prepare($sql);
    $params = array($section);
    $stmt->execute($params);
    if ($stmt->rowCount() <= 0) {
        $sql = "INSERT INTO notification_count (interface, pending, ongoing, store_out) VALUES (?, 0, 0, 0)";
        $stmt = $conn->prepare($sql);
        $params = array($section);
        $stmt->execute($params);
    }
}

function get_section($id, $conn)
{
    $sql = "SELECT section FROM section WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $params = array($id);
    $stmt->execute($params);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row['section'];
    }
}

function update_section_on_kanban($section, $old_section, $conn)
{
    $sql = "UPDATE kanban_masterlist SET section = ? WHERE section = ?";
    $stmt = $conn->prepare($sql);
    $params = array($section, $old_section);
    $stmt->execute($params);
}

function update_section_on_notif($section, $old_section, $conn)
{
    $sql = "UPDATE notification_count SET interface = ? WHERE interface = ?";
    $stmt = $conn->prepare($sql);
    $params = array($section, $old_section);
    $stmt->execute($params);
}

// Get Section Dropdown
if ($method == 'fetch_section_dropdown') {
    $sql = "SELECT section FROM section GROUP BY(section) ORDER BY section ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option disabled selected value="">Select Section</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . htmlspecialchars($row['section']) . '">' . htmlspecialchars($row['section']) . '</option>';
        }
    } else {
        echo '<option disabled selected value="">Select Section</option>';
    }
}

// Get Section Dropdown (Kanban History, Kanban Printing, Request Search)
if ($method == 'fetch_section_dropdown_fg') {
    $sql = "SELECT section FROM section GROUP BY(section) ORDER BY section ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option selected value="All">All Sections</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . htmlspecialchars($row['section']) . '">' . htmlspecialchars($row['section']) . '</option>';
        }
    } else {
        echo '<option disabled selected value="">Select Section</option>';
    }
}

// Count
if ($method == 'count_data') {
    $search = $_POST['search'];
    $sql = "SELECT count(id) AS total FROM section";
    if (!empty($search)) {
        $sql = $sql . " WHERE section LIKE '$search%' OR ip LIKE '$search%'";
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
    $sql = "SELECT id, section, ip, date_updated FROM section";

    if (!empty($id) && empty($search)) {
        $sql = $sql . " WHERE id > '$id'";
    } else if (empty($id) && !empty($search)) {
        $sql = $sql . " WHERE section LIKE '$search%' OR ip LIKE '$search%'";
    } else if (!empty($id) && !empty($search)) {
        $sql = $sql . " WHERE id > '$id' AND (section LIKE '$search%' OR ip LIKE '$search%')";
    }
    $sql = $sql . " ORDER BY id ASC LIMIT 10";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            echo '<tr style="cursor:pointer;" class="modal-trigger" id="' . $row['id'] . '" data-toggle="modal" data-target="#SectionInfoModal" data-id="' . $row['id'] . '" data-section="' . htmlspecialchars($row['section']) . '" data-ip="' . $row['ip'] . '" data-date_updated="' . $row['date_updated'] . '" onclick="get_details(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . htmlspecialchars($row['section']) . '</td>';
            echo '<td>' . $row['ip'] . '</td>';
            echo '<td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="4" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

// Create / Insert
if ($method == 'save_data') {
    $section = custom_trim($_POST['section']);
    $ip = custom_trim($_POST['ip']);

    $is_valid = false;
    $is_valid_section = validate_section($section);
    $is_valid_ip = validate_ip($ip);

    if ($is_valid_section == true) {
        if ($is_valid_ip == true) {
            $is_valid = true;
        } else {
            echo 'Invalid IP';
        }
    } else {
        echo 'Invalid Section';
    }

    if ($is_valid == true) {
        $is_duplicate = check_duplicate_section($section, $ip, $conn);
        if ($is_duplicate == false) {
            $sql = "INSERT INTO section (section, ip, date_updated) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $params = array($section, $ip, $date_updated);
            $stmt->execute($params);
            insert_section_on_notif($section, $conn);
            echo 'success';
        } else {
            echo 'Duplicate';
        }
    }
}

// Update / Edit
if ($method == 'update_data') {
    $id = $_POST['id'];
    $section = custom_trim($_POST['section']);
    $ip = custom_trim($_POST['ip']);

    $is_valid = false;
    $is_valid_section = validate_section($section);
    $is_valid_ip = validate_ip($ip);

    if ($is_valid_section == true) {
        if ($is_valid_ip == true) {
            $is_valid = true;
        } else {
            echo 'Invalid IP';
        }
    } else {
        echo 'Invalid Section';
    }

    if ($is_valid == true) {
        $old_section = get_section($id, $conn);
        $is_existing = check_existing_section_ip($id, $ip, $conn);
        if ($is_existing == false) {
            $sql = "UPDATE section SET section = ?, ip = ?, date_updated = ? WHERE section = ?";
            $stmt = $conn->prepare($sql);
            $params = array($section, $ip, $date_updated, $old_section);
            $stmt->execute($params);
            update_section_on_kanban($section, $old_section, $conn);
            update_section_on_notif($section, $old_section, $conn);
            echo 'success';
        } else {
            echo 'Already Exists';
        }
    }
}

// Delete
if ($method == 'delete_data') {
    $id = $_POST['id'];

    $sql = "DELETE FROM section WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $params = array($id);
    $stmt->execute($params);
    echo 'success';
}

$conn = null;
