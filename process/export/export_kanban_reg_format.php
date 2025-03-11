<?php
session_set_cookie_params(0, "/fg_packaging_debug");
session_name("fg-pkg-debug");
session_start();

if (!isset($_SESSION['username'])) {
  header('location:../../admin/');
  exit;
}

require('../db/conn.php');

$storage_area = '';
$sql = "SELECT storage_area FROM storage_area ORDER BY storage_area ASC";

$stmt = $conn -> prepare($sql);
$stmt -> execute();
if ($stmt -> rowCount() > 0) {
	$delimiter = ","; 
    $datenow = date('Y-m-d');
    $filename = "FG-Pkg_KanbanRegFormat.csv";
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 

    // UTF-8 BOM for special character compatibility
    fputs($f, "\xEF\xBB\xBF");
     
    // Set column headers 
    $fields = array('Line No', 'Storage Area', 'Item No', 'Item Name', 'Dimension', 'Size', 'Color', 'Quantity', 'Request Limit'); 
    fputcsv($f, $fields, $delimiter); 

    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $storage_area = $row['storage_area'];
        $sql1 = "SELECT item_no, item_name, dimension, size, color, pcs_bundle FROM items ORDER BY item_no ASC";
        $stmt1 = $conn -> prepare($sql1);
        $stmt1 -> execute();

        // Output each row of the data, format line as csv and write to file pointer 
        while($row1 = $stmt1 -> fetch(PDO::FETCH_ASSOC)) { 
            $item_no = "=\"".$row1['item_no']."\"";
            $quantity = intval($row1['pcs_bundle']);
            $lineData = array('', $storage_area, $item_no, $row1['item_name'], $row1['dimension'], $row1['size'], $row1['color'], $quantity, $quantity); 
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