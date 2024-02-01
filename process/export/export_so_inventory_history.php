<?php
session_set_cookie_params(0, "/fg_packaging_debug");
session_name("fg-pkg-debug");
session_start();

if (!isset($_SESSION['username'])) {
  header('location:../../admin/');
  exit;
}

require('../db/conn.php');

switch (true) {
    case !isset($_GET['store_out_date_from']):
    case !isset($_GET['store_out_date_to']):
    case !isset($_GET['item_no']):
    case !isset($_GET['item_name']):
    case !isset($_GET['remarks']):
    case !isset($_GET['storage_area']):
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
$item_no = $_GET['item_no'];
$item_name = $_GET['item_name'];
$remarks = $_GET['remarks'];
$storage_area = $_GET['storage_area'];

$sql = "SELECT * FROM `store_out_history` WHERE item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' ";
if ($storage_area != 'All') {
    $sql = $sql . "AND storage_area = '$storage_area' ";
}
if ($remarks == 'Without Remarks') {
    $sql = $sql . "AND remarks = '' ";
} else if ($remarks == 'With Remarks') {
    $sql = $sql . "AND remarks != '' ";
}
$sql = $sql . "AND (store_out_date_time >= '$store_out_date_from' AND store_out_date_time <= '$store_out_date_to') ORDER BY id DESC";
$stmt = $conn -> prepare($sql);
$stmt -> execute();
if ($stmt -> rowCount() > 0) {
	$delimiter = ","; 
    $datenow = date('Y-m-d');
    $filename = "FG-Pkg_StoreOutInventoryHistory-".$datenow.".csv";
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 

    // UTF-8 BOM for special character compatibility
    fputs($f, "\xEF\xBB\xBF");
     
    // Set column headers 
    $fields = array('Store Out Date & Time', 'Item No.', 'Item Name', 'Inventory Out', 'Request ID', 'Storage Area', 'Remarks'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
        $item_no = "=\"".$row['item_no']."\"";
        $store_out_date_time = date("Y-m-d h:iA", strtotime($row['store_out_date_time']));
        $lineData = array($store_out_date_time, $item_no, $row['item_name'], $row['inv_out'], $row['request_id'], $row['storage_area'], $row['remarks']); 
        fputcsv($f, $lineData, $delimiter); 
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