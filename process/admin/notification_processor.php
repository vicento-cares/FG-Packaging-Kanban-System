<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];

if ($method == 'count_notif_fg') {
    $sql = "SELECT pending FROM notification_count WHERE interface = 'ADMIN-FG'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo intval($row['pending']);
        }
    }
}

if ($method == 'count_notif_section') {
    $section = $_POST['section'];
    $ongoing = 0;
    $store_out = 0;
    $total = 0;
    $sql = "SELECT ongoing, store_out FROM notification_count WHERE interface = ?";
    $stmt = $conn->prepare($sql);
    $params = array($section);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ongoing = intval($row['ongoing']);
            $store_out = intval($row['store_out']);
        }
    }
    $total = $ongoing + $store_out;

    $response_arr = array(
        'ongoing' => $ongoing,
        'store_out' => $store_out,
        'total' => $total
    );

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

if ($method == 'update_notif_fg') {
    $sql = "UPDATE notification_count SET pending = 0 WHERE interface = 'ADMIN-FG'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

if ($method == 'update_notif_section') {
    $section = $_POST['section'];
    $sql = "UPDATE notification_count SET ongoing = 0, store_out = 0 WHERE interface = ?";
    $stmt = $conn->prepare($sql);
    $params = array($section);
    $stmt->execute($params);
}

$conn = null;
