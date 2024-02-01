<?php
session_set_cookie_params(0, "/fg_packaging_debug");
session_name("fg-pkg-debug");
session_start();

if (!isset($_SESSION['username'])) {
  header('location:../../admin/');
  exit;
}

require('../db/conn.php');
require('../lib/main.php');

switch (true) {
    case !isset($_GET['store_out_date_from']):
    case !isset($_GET['store_out_date_to']):
    case !isset($_GET['line_no']):
    case !isset($_GET['item_no']):
    case !isset($_GET['item_name']):
    case !isset($_GET['section']):
    case !isset($_GET['with_remarks']):
        echo 'Query Parameters Not Set';
        exit;
        break;
}

$store_out_date_from = $_GET['store_out_date_from'];
$store_out_date_from = date_create($store_out_date_from);
$store_out_date_from = date_format($store_out_date_from,"Y-m-d H:i:s");
$store_out_date_to = $_GET['store_out_date_to'];
$store_out_date_to = date_create($store_out_date_to);
$store_out_date_to = date_format($store_out_date_to,"Y-m-d H:i:s");
$line_no = $_GET['line_no'];
$item_no = $_GET['item_no'];
$item_name = $_GET['item_name'];
$section = $_GET['section'];
$with_remarks = $_GET['with_remarks']; 

$sql = "SELECT `request_id`, `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `line_no`, `quantity`, `storage_area`, `section`, `requestor_name`, `requestor`, `route_no`, `truck_no`, `scan_date_time`, `request_date_time`, `store_out_date_time` FROM kanban_history";
if ($section == 'All') {
    $sql = $sql . " WHERE line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND (store_out_date_time >= '$store_out_date_from' AND store_out_date_time <= '$store_out_date_to') ORDER BY id DESC";
} else {
    $sql = $sql . " WHERE section = '$section' AND line_no LIKE '$line_no%' AND item_no LIKE '$item_no%' AND item_name LIKE '$item_name%' AND (store_out_date_time >= '$store_out_date_from' AND store_out_date_time <= '$store_out_date_to') ORDER BY id DESC";
}
$stmt = $conn -> prepare($sql);
$stmt -> execute();
if ($stmt -> rowCount() > 0) {
	$delimiter = ","; 
    $datenow = date('Y-m-d');
    $filename = "FG-Pkg_StoreOutReqHistory-".$datenow.".csv";
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 

    // UTF-8 BOM for special character compatibility
    fputs($f, "\xEF\xBB\xBF");

    if ($with_remarks == 1) {
        // Set column headers 
        $fields = array('Request ID', 'Line No.', 'Storage Area', 'Item No.', 'Item Name', 'Kanban No.', 'Quantity', 'Section', 'Requestor Name', 'Requestor', 'Route No.', 'Truck No.', 'Requestor Remarks', 'Remarks Date & Time', 'Scan Date & Time', 'Request Date & Time', 'Store Out Date & Time'); 
        fputcsv($f, $fields, $delimiter); 
         
        // Output each row of the data, format line as csv and write to file pointer 
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
            $item_no = "=\"".$row['item_no']."\"";
            $requestor_remarks = '';
            $requestor_date_time = '';
            $requestor_remarks_arr = get_requestor_remarks($row['request_id'], $row['kanban'], $row['serial_no'], $conn);
            if (array_key_exists('requestor_remarks',$requestor_remarks_arr)) {
                $requestor_remarks = $requestor_remarks_arr['requestor_remarks'];
            }
            if (array_key_exists('requestor_date_time',$requestor_remarks_arr)) {
                $requestor_date_time = $requestor_remarks_arr['requestor_date_time'];
            }
            $scan_date_time = date("Y-m-d h:iA", strtotime($row['scan_date_time']));
            $request_date_time = date("Y-m-d h:iA", strtotime($row['request_date_time']));
            $store_out_date_time = date("Y-m-d h:iA", strtotime($row['store_out_date_time']));
            $lineData = array($row['request_id'], $row['line_no'], $row['storage_area'], $item_no, $row['item_name'], $row['kanban_no'], $row['quantity'], $row['section'], $row['requestor_name'], $row['requestor'], $row['route_no'], $row['truck_no'], $requestor_remarks, $requestor_date_time, $scan_date_time, $request_date_time, $store_out_date_time); 
            fputcsv($f, $lineData, $delimiter); 
        } 
    } else {
        // Set column headers 
        $fields = array('Request ID', 'Line No.', 'Storage Area', 'Item No.', 'Item Name', 'Kanban No.', 'Quantity', 'Section', 'Requestor Name', 'Requestor', 'Route No.', 'Truck No.', 'Scan Date & Time', 'Request Date & Time', 'Store Out Date & Time'); 
        fputcsv($f, $fields, $delimiter); 
         
        // Output each row of the data, format line as csv and write to file pointer 
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
            $item_no = "=\"".$row['item_no']."\"";
            $scan_date_time = date("Y-m-d h:iA", strtotime($row['scan_date_time']));
            $request_date_time = date("Y-m-d h:iA", strtotime($row['request_date_time']));
            $store_out_date_time = date("Y-m-d h:iA", strtotime($row['store_out_date_time']));
            $lineData = array($row['request_id'], $row['line_no'], $row['storage_area'], $item_no, $row['item_name'], $row['kanban_no'], $row['quantity'], $row['section'], $row['requestor_name'], $row['requestor'], $row['route_no'], $row['truck_no'], $scan_date_time, $request_date_time, $store_out_date_time); 
            fputcsv($f, $lineData, $delimiter); 
        } 
    }
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
}

$conn = null;
?>