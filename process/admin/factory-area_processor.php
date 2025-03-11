<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];

// Get Factory Area Dropdown
if ($method == 'fetch_factory_area_dropdown') {
    $sql = "SELECT factory_area FROM factory_area ORDER BY factory_area ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option disabled selected value="">Select Factory Area</option>';
        foreach ($stmt->fetchAll() as $row) {
            if ($row['factory_area'] == 'Annex') {
                echo '<option value="' . htmlspecialchars($row['factory_area']) . '">Factory 2 - (' . htmlspecialchars($row['factory_area']) . ')</option>';
            } else {
                echo '<option value="' . htmlspecialchars($row['factory_area']) . '">Factory 1 - (' . htmlspecialchars($row['factory_area']) . ')</option>';
            }
        }
    } else {
        echo '<option disabled selected value="">Select Factory Area</option>';
    }
}

$conn = null;
