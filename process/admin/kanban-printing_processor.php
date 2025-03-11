<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit;
}
$method = $_POST['method'];

function get_batch_no_latest($conn)
{
    $sql = "SELECT id, batch_no FROM kanban_masterlist GROUP BY batch_no ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['batch_no'];
        }
    }
}

// Get Batch Dropdown
if ($method == 'fetch_batch_dropdown') {
    $sql = "SELECT batch_no FROM kanban_masterlist GROUP BY(batch_no) ORDER BY id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option selected value="All">All Batch</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . $row['batch_no'] . '">' . $row['batch_no'] . '</option>';
        }
    } else {
        echo '<option disabled selected value="">Select Batch</option>';
    }
}

// Get Batch Dropdown
if ($method == 'fetch_line_dropdown') {
    $sql = "SELECT line_no FROM kanban_masterlist GROUP BY(line_no) ORDER BY id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option selected value="All">All Line</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . htmlspecialchars($row['line_no']) . '">' . htmlspecialchars($row['line_no']) . '</option>';
        }
    } else {
        echo '<option disabled selected value="">Select Line</option>';
    }
}

// Read / Load Kanban By Batch
if ($method == 'fetch_kanban') {
    $id = $_POST['id'];
    $batch_no = $_POST['batch_no'];
    $line_no = $_POST['line_no'];
    $section = $_POST['section'];
    $c = $_POST['c'];
    $sql = "SELECT id, item_no, item_name, section, line_no, quantity, storage_area, date_updated FROM kanban_masterlist";
    if (!empty($id)) {
        $sql = $sql . " WHERE id > '$id'";
        if (!empty($batch_no) && empty($line_no)) {
            if ($section != 'All' && $batch_no != 'All') {
                $sql = $sql . " AND batch_no = '$batch_no' AND section = '$section'";
            } else if ($section == 'All' && $batch_no != 'All') {
                $sql = $sql . " AND batch_no = '$batch_no'";
            } else if ($section != 'All' && $batch_no == 'All') {
                $sql = $sql . " AND section = '$section'";
            }
        } else if (empty($batch_no) && !empty($line_no)) {
            if ($section != 'All' && $line_no != 'All') {
                $sql = $sql . " AND line_no = '$line_no' AND section = '$section'";
            } else if ($section == 'All' && $line_no != 'All') {
                $sql = $sql . " AND line_no = '$line_no'";
            } else if ($section != 'All' && $line_no == 'All') {
                $sql = $sql . " AND section = '$section'";
            }
        } else if (empty($batch_no) && empty($line_no)) {
            $batch_no = get_batch_no_latest($conn);
            if ($section == 'All') {
                $sql = $sql . " AND batch_no = '$batch_no'";
            } else {
                $sql = $sql . " AND batch_no = '$batch_no' AND section = '$section'";
            }
        }
    } else if (!empty($batch_no) && empty($line_no)) {
        if ($section != 'All' && $batch_no != 'All') {
            $sql = $sql . " WHERE batch_no = '$batch_no' AND section = '$section'";
        } else if ($section == 'All' && $batch_no != 'All') {
            $sql = $sql . " WHERE batch_no = '$batch_no'";
        } else if ($section != 'All' && $batch_no == 'All') {
            $sql = $sql . " WHERE section = '$section'";
        }
    } else if (empty($batch_no) && !empty($line_no)) {
        if ($section != 'All' && $line_no != 'All') {
            $sql = $sql . " WHERE line_no = '$line_no' AND section = '$section'";
        } else if ($section == 'All' && $line_no != 'All') {
            $sql = $sql . " WHERE line_no = '$line_no'";
        } else if ($section != 'All' && $line_no == 'All') {
            $sql = $sql . " WHERE section = '$section'";
        }
    } else if (empty($batch_no) && empty($line_no)) {
        $batch_no = get_batch_no_latest($conn);
        if ($section == 'All') {
            $sql = $sql . " WHERE batch_no = '$batch_no'";
        } else {
            $sql = $sql . " WHERE batch_no = '$batch_no' AND section = '$section'";
        }
    }
    $sql = $sql . " ORDER BY id ASC LIMIT 25";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            echo '<tr class="modal-trigger" id="' . $row['id'] . '"><td><p class="mb-0"><label class="mb-0"><input type="checkbox" class="singleCheck" value="' . $row['id'] . '" onclick="get_checked_kanban()" /><span></span></label></p></td><td style="cursor:pointer;" onclick="print_single_kanban(' . $row['id'] . ')">' . $c . '</td><td>' . htmlspecialchars($row['line_no']) . '</td><td>' . htmlspecialchars($row['storage_area']) . '</td><td>' . htmlspecialchars($row['item_name']) . '</td><td>' . $row['quantity'] . '</td><td>' . htmlspecialchars($row['section']) . '</td><td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td></tr>';
        }
    } else {
        echo '<tr><td colspan="8" style="text-align:center; color:red;">No Results Found</td></tr>';
    }
}

// Count Kanban
if ($method == 'count_kanban') {
    $batch_no = $_POST['batch_no'];
    $line_no = $_POST['line_no'];
    $section = $_POST['section'];
    $sql = "SELECT count(id) AS total FROM kanban_masterlist";
    if (!empty($batch_no) && empty($line_no)) {
        if ($section != 'All' && $batch_no != 'All') {
            $sql = $sql . " WHERE batch_no = '$batch_no' AND section = '$section'";
        } else if ($section == 'All' && $batch_no != 'All') {
            $sql = $sql . " WHERE batch_no = '$batch_no'";
        } else if ($section != 'All' && $batch_no == 'All') {
            $sql = $sql . " WHERE section = '$section'";
        }
    } else if (empty($batch_no) && !empty($line_no)) {
        if ($section != 'All' && $line_no != 'All') {
            $sql = $sql . " WHERE line_no = '$line_no' AND section = '$section'";
        } else if ($section == 'All' && $line_no != 'All') {
            $sql = $sql . " WHERE line_no = '$line_no'";
        } else if ($section != 'All' && $line_no == 'All') {
            $sql = $sql . " WHERE section = '$section'";
        }
    } else if (empty($batch_no) && empty($line_no)) {
        $batch_no = get_batch_no_latest($conn);
        if ($section == 'All') {
            $sql = $sql . " WHERE batch_no = '$batch_no'";
        } else {
            $sql = $sql . " WHERE batch_no = '$batch_no' AND section = '$section'";
        }
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['total'];
        }
    }
}

$conn = null;
