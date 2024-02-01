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
    case !isset($_GET['item_no']):
    case !isset($_GET['item_name']):
    case !isset($_GET['storage_area']):
        echo 'Query Parameters Not Set';
        exit;
        break;
}

$item_no = $_GET['item_no'];
$item_name = $_GET['item_name'];
$storage_area = $_GET['storage_area'];

$sql = "SELECT `item_no`, `item_name`, `storage_area`, `quantity`, `safety_stock` FROM inventory";
if ($storage_area == 'All') {
    $sql = $sql . " WHERE item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' ORDER BY id ASC";
} else {
    $sql = $sql . " WHERE item_no LIKE '%$item_no%' AND item_name LIKE '$item_name%' AND storage_area LIKE '$storage_area%' ORDER BY id ASC";
}
$stmt = $conn -> prepare($sql);
$stmt -> execute();
if ($stmt -> rowCount() > 0) {
	$delimiter = ","; 
    $datenow = date('Y-m-d');
    $filename = "FG-Pkg_Inventory-".$datenow.".csv";
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 

    // UTF-8 BOM for special character compatibility
    fputs($f, "\xEF\xBB\xBF");
     
    // Set column headers 
    $fields = array('Item No.', 'Item Name', 'Quantity', 'Safety Stock', 'Storage Area'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
        $item_no = "=\"".$row['item_no']."\"";
        $lineData = array($item_no, $row['item_name'], $row['quantity'], $row['safety_stock'], $row['storage_area']); 
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