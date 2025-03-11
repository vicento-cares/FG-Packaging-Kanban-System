<?php
// Main (All Reusable Function)

// Get Requestor Remarks
function get_requestor_remarks($request_id, $kanban, $serial_no, $conn)
{
    $id = '';
    $requestor_remarks = '';
    $requestor_date_time = 'N/A';
    $response_arr = array();
    $sql = "SELECT id, requestor_remarks, requestor_date_time FROM requestor_remarks WHERE request_id = ? AND kanban = ? AND serial_no = ?";
    $stmt = $conn->prepare($sql);
    $params = array($request_id, $kanban, $serial_no);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $id = $row['id'];
            $requestor_remarks = $row['requestor_remarks'];
            $requestor_date_time = date("Y-m-d h:iA", strtotime($row['requestor_date_time']));
        }
    }
    $message = 'success';

    $response_arr = array(
        'requestor_remarks_id' => $id,
        'requestor_remarks' => $requestor_remarks,
        'requestor_date_time' => $requestor_date_time,
        'message' => $message
    );

    return $response_arr;
}

// Check Requestor Remarks
function check_requestor_remarks($request_id, $kanban, $serial_no, $conn)
{
    $sql = "SELECT request_id FROM requestor_remarks WHERE request_id = ? AND kanban = ? AND serial_no = ?";
    $stmt = $conn->prepare($sql);
    $params = array($request_id, $kanban, $serial_no);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

// Get Route Number
function get_route_number($line_no, $conn)
{
    $sql = "SELECT route_no FROM route_no WHERE line_no = ?";
    $stmt = $conn->prepare($sql);
    $params = array($line_no);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            return $row['route_no'];
        }
    } else {
        return 'N/A';
    }
}

// Get Truck Number
function get_truck_number($section, $line_no, $store_out_time, $conn)
{
    $factory_area = '';
    $truck_no = '';
    $sql = "SELECT factory_area FROM route_no WHERE section = ? AND line_no = ?";
    $stmt = $conn->prepare($sql);
    $params = array($section, $line_no);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $factory_area = $row['factory_area'];
        }
    }

    if ($factory_area == 'Annex') {
        $sql = "SELECT truck_no FROM truck_no";
        // Static Code for Truck 23 (23:50 - 01:35)
        if ($store_out_time >= '23:50' && $store_out_time < '24:00') {
            $sql = $sql . " WHERE (time_from >= '23:50' AND time_to <= '01:35')";
        } else if ($store_out_time >= '00:00' && $store_out_time < '01:35') {
            $sql = $sql . " WHERE (time_from >= '23:50' AND time_to <= '01:35')";
        } else {
            $sql = $sql . " WHERE (time_from <= '$store_out_time' AND time_to > '$store_out_time')";
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $truck_no = $row['truck_no'];
        }
        return $truck_no;
    } else {
        return 'N/A';
    }
}

// Get Kanban Details
function get_kanban_details($kanban, $serial_no, $conn)
{
    $response_arr = array();
    $sql = "SELECT dimension, size, color FROM kanban_masterlist WHERE kanban = ? AND serial_no = ?";
    $stmt = $conn->prepare($sql);
    $params = array($kanban, $serial_no);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $response_arr = array(
                'dimension' => $row['dimension'],
                'size' => $row['size'],
                'color' => $row['color']
            );
            return $response_arr;
        }
    }
}

// Check Line No.
function check_line_no($line_no, $conn)
{
    $sql = "SELECT id FROM route_no WHERE line_no = ?";
    $stmt = $conn->prepare($sql);
    $params = array($line_no);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

// Check IP of Section
function check_ip_section($ip, $conn)
{
    $sql = "SELECT section FROM section WHERE ip = ?";
    $stmt = $conn->prepare($sql);
    $params = array($ip);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['section'];
        }
    } else {
        return '';
    }
}

// Load Recent Scanned Kanban
function load_recent_scanned($section, $id_no, $conn)
{
    $sql = "SELECT request_id FROM scanned_kanban WHERE section = ? AND requestor_id_no = ? AND status = 'Scanned' ORDER BY scan_date_time DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $params = array($section, $id_no);
    $stmt->execute($params);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row['request_id'];
    }
}
