<?php
session_set_cookie_params(0, "/fg_packaging_debug");
session_name("fg-pkg-debug");
session_start();

if (!isset($_SESSION['username'])) {
  header('location:../../admin/');
  exit;
}

error_reporting(0); // comment this line to see errors
date_default_timezone_set("Asia/Manila");
require('../db/conn.php');
require('../lib/validate.php');
require('../lib/main.php');

$start_row = 1;
$insertsql = "INSERT INTO kanban_masterlist (batch_no, kanban, kanban_no, serial_no, line_no, storage_area, item_no, item_name, dimension, size, color, quantity, req_limit, section, req_limit_qty, route_no, date_updated) VALUES ";
$subsql = "";

$date_updated = date('Y-m-d H:i:s');
$date_generated = date("ymdHis");

$batch_no = date("ymdh");
$rand = substr(md5(microtime()),rand(0,26),5);
$batch_no = 'BAT:'.$batch_no;
$batch_no = $batch_no.''.$rand;

function get_items($conn) {
    $data = array();

    $sql = "SELECT item_no, item_name FROM items ORDER BY item_no ASC";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $row['item_no']);
        array_push($data, $row['item_name']);
    }

    return $data;
}

function get_lines($conn) {
    $data = array();

    $sql = "SELECT line_no FROM route_no ORDER BY line_no ASC";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $row['line_no']);
    }
    
    return $data;
}

function get_storage_areas($conn) {
    $data = array();

    $sql = "SELECT storage_area FROM storage_area ORDER BY storage_area ASC";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $row['storage_area']);
    }
    
    return $data;
}

// Get Section
function get_section_by_line_no($line_no, $conn) {
    $sql = "SELECT section FROM route_no WHERE line_no = ?";
    $stmt = $conn -> prepare($sql);
    $params = array($line_no);
    $stmt -> execute($params);
    if ($stmt -> rowCount() > 0) {
        foreach($stmt -> fetchAll() as $row) {
            return $row['section'];
        }
    } else {
        return 'N/A';
    }
}

// Remove UTF-8 BOM
function removeBomUtf8($s){
    if (substr($s,0,3) == chr(hexdec('EF')).chr(hexdec('BB')).chr(hexdec('BF'))) {
        return substr($s,3);
    } else {
        return $s;
    }
}

function count_row ($file) {
    $linecount = -2;
    $handle = fopen($file, "r");
    while(!feof($handle)){
      $line = fgets($handle);
      $linecount++;
    }

    fclose($handle);

    return $linecount;
}

function check_csv ($file, $conn) {
    // READ FILE
    $csvFile = fopen($file,'r');

    // SKIP FIRST LINE
    $first_line = fgets($csvFile);
    // Remove UTF-8 BOM from First Line
    $first_line = removeBomUtf8($first_line);

    $items_arr = get_items($conn);
    $line_no_arr = get_lines($conn);
    $storage_area_arr = get_storage_areas($conn);

    $hasError = 0; $hasBlankError = 0; $isExistsOnDb = 0; $isDuplicateOnCsv = 0;
    $hasBlankErrorArr = array();
    $isExistsOnDbArr = array();
    $isDuplicateOnCsvArr = array();
    $dup_temp_arr = array();

    $row_valid_arr = array(0,0,0,0,0,0,0,0,0);

    $notValidItemNoArr = array();
    $notValidItemNameArr = array();
    $notValidLineNoArr = array();
    $notExistsItemNoArr = array();
    $notExistsItemNameArr = array();
    $notExistsLineNoArr = array();
    $notExistsStorageAreaArr = array();
    $notValidQuantityArr = array();
    $notValidReqLimitArr = array();

    $message = "";
    $check_csv_row = 0;

    // CHECK CSV BASED ON HEADER
    $first_line = preg_replace('/[\t\n\r]+/', '', $first_line);
    $valid_first_line = 'Line No,Storage Area,Item No,Item Name,Dimension,Size,Color,Quantity,Request Limit';
    if ($first_line == $valid_first_line) {
        while (($line = fgetcsv($csvFile)) !== false) {
            // Check if the row is blank or consists only of whitespace
            if (empty(implode('', $line))) {
                continue; // Skip blank lines
            }

            $check_csv_row++;
            
            $line_no = strtoupper(custom_trim($line[0]));
            $storage_area = custom_trim($line[1]);
            $item_no = str_pad(custom_trim($line[2]), 5, '0', STR_PAD_LEFT);
            $item_name = addslashes(custom_trim($line[3]));
            $dimension = addslashes(custom_trim($line[4]));
            $size = addslashes(custom_trim($line[5]));
            $color = addslashes(custom_trim($line[6]));
            $quantity = intval(custom_trim($line[7]));
            $req_limit = custom_trim($line[8]);
            
            $is_valid_item_no = validate_item_no($item_no);
            $is_valid_item_name = validate_item_name($item_name);
            $is_valid_line_no = validate_line_no($line_no);

            $item_name_raw = $line[3];

            if ($line_no == '' || $storage_area == '' || $item_no == '' || $item_name == '' || $quantity == '' || $req_limit == '') {
                // IF BLANK DETECTED ERROR += 1
                $hasBlankError++;
                $hasError = 1;
                array_push($hasBlankErrorArr, $check_csv_row);
            }

            // CHECK ROW VALIDATION
            if ($is_valid_item_no == false) {
                $hasError = 1;
                $row_valid_arr[0] = 1;
                array_push($notValidItemNoArr, $check_csv_row);
            }
            if ($is_valid_item_name == false) {
                $hasError = 1;
                $row_valid_arr[1] = 1;
                array_push($notValidItemNameArr, $check_csv_row);
            }
            if ($is_valid_line_no == false) {
                $hasError = 1;
                $row_valid_arr[2] = 1;
                array_push($notValidLineNoArr, $check_csv_row);
            }
            if (!in_array($item_no, $items_arr)) {
                $hasError = 1;
                $row_valid_arr[3] = 1;
                array_push($notExistsItemNoArr, $check_csv_row);
            }
            if (!in_array($item_name_raw, $items_arr)) {
                $hasError = 1;
                $row_valid_arr[4] = 1;
                array_push($notExistsItemNameArr, $check_csv_row);
            }
            if (!in_array($line_no, $line_no_arr)) {
                $hasError = 1;
                $row_valid_arr[5] = 1;
                array_push($notExistsLineNoArr, $check_csv_row);
            }
            if (!in_array($storage_area, $storage_area_arr)) {
                $hasError = 1;
                $row_valid_arr[6] = 1;
                array_push($notExistsStorageAreaArr, $check_csv_row);
            }
            if ($quantity <= 0) {
                $hasError = 1;
                $row_valid_arr[7] = 1;
                array_push($notValidQuantityArr, $check_csv_row);
            }
            if ($req_limit <= 0) {
                $hasError = 1;
                $row_valid_arr[8] = 1;
                array_push($notValidReqLimitArr, $check_csv_row);
            }

            // Joining all row values for checking duplicated rows
            $whole_line = join(',', $line);

            // CHECK ROWS IF IT HAS DUPLICATE ON CSV
            if (isset($dup_temp_arr[$whole_line])) {
                $isDuplicateOnCsv = 1;
                $hasError = 1;
                array_push($isDuplicateOnCsvArr, $check_csv_row);
            } else {
                $dup_temp_arr[$whole_line] = 1;
            }

            // CHECK ROWS IF EXISTS
            $sql = "SELECT id FROM kanban_masterlist 
            WHERE item_no = '$item_no' AND item_name = '$item_name' AND line_no = '$line_no'
            AND dimension = '$dimension' AND size = '$size' AND color = '$color'
            AND quantity = '$quantity' AND storage_area = '$storage_area'";
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
            if ($stmt -> rowCount() > 0) {
                $isExistsOnDb = 1;
                $hasError = 1;
                array_push($isExistsOnDbArr, $check_csv_row);
            }
        }
    } else {
        $message = $message . 'Invalid CSV Table Header. Maybe an incorrect CSV file or incorrect CSV header ';
    }
    
    fclose($csvFile);

    if ($hasError == 1) {
        if ($row_valid_arr[0] == 1) {
            $message = $message . 'Invalid Item No. on row/s ' . implode(", ", $notValidItemNoArr) . '. ';
        }
        if ($row_valid_arr[1] == 1) {
            $message = $message . 'Invalid Item Name on row/s ' . implode(", ", $notValidItemNameArr) . '. ';
        }
        if ($row_valid_arr[2] == 1) {
            $message = $message . 'Invalid Line No. on row/s ' . implode(", ", $notValidLineNoArr) . '. ';
        }
        if ($row_valid_arr[3] == 1) {
            $message = $message . 'Item No. doesn\'t exists on row/s ' . implode(", ", $notExistsItemNoArr) . '. ';
        }
        if ($row_valid_arr[4] == 1) {
            $message = $message . 'Item Name doesn\'t exists on row/s ' . implode(", ", $notExistsItemNameArr) . '. ';
        }
        if ($row_valid_arr[5] == 1) {
            $message = $message . 'Line No. doesn\'t exists on row/s ' . implode(", ", $notExistsLineNoArr) . '. ';
        }
        if ($row_valid_arr[6] == 1) {
            $message = $message . 'Storage Area doesn\'t exists on row/s ' . implode(", ", $notExistsStorageAreaArr) . '. ';
        }
        if ($row_valid_arr[7] == 1) {
            $message = $message . 'Zero or Negative Quantity on row/s ' . implode(", ", $notValidQuantityArr) . '. ';
        }
        if ($row_valid_arr[8] == 1) {
            $message = $message . 'Zero or Negative Request Limit on row/s ' . implode(", ", $notValidReqLimitArr) . '. ';
        }

        if ($isExistsOnDb == 1) {
            $message = $message . 'Kanban Already Registered on row/s ' . implode(", ", $isExistsOnDbArr) . '. ';
        }
        if ($hasBlankError >= 1) {
            $message = $message . 'Blank Cell Exists on row/s ' . implode(", ", $hasBlankErrorArr) . '. ';
        }
        if ($isDuplicateOnCsv == 1) {
            $message = $message . 'Duplicated Record/s on row/s ' . implode(", ", $isDuplicateOnCsvArr) . '. ';
        }
    }
    return $message;
}

$mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

if (!empty($_FILES['file']['name'])) {

    if (in_array($_FILES['file']['type'],$mimes)) {

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            $row_count = count_row($_FILES['file']['tmp_name']);

            $chkCsvMsg = check_csv($_FILES['file']['tmp_name'], $conn);

            if ($chkCsvMsg == '') {

                if (($csv_file = fopen($_FILES['file']['tmp_name'], "r")) !== false) {

                    $temp_count = 0;
                    fgets($csv_file);  // read one line for nothing (skip header / first row)
                    while (($read_data = fgetcsv($csv_file, 1000, ",")) !== false) {
                        $line_no = strtoupper(custom_trim($read_data[0]));
                        $item_no = str_pad(custom_trim($read_data[2]), 5, '0', STR_PAD_LEFT);
                        $item_name = addslashes(custom_trim($read_data[3]));
                        $item_name_generated = preg_replace('/\s+/', '', $item_name);
                        $section = get_section_by_line_no($line_no, $conn);
                        $section_generated = preg_replace('/\s+/', '', custom_trim($section));
                        $words = preg_split("/[\s,_-]+/", custom_trim($read_data[1]));
                        $acronym = "";
                        foreach ($words as $w) {
                            $acronym .= mb_substr($w, 0, 1);
                        }
                        $kanban = $item_name_generated.'_'.$section_generated.'_'.$line_no.'_'.$acronym.'_'.custom_trim($read_data[7]).'_'.$item_no.'_'.$date_generated;
                        $kanban_no = 0;
                        $rand2 = substr(md5(microtime()),rand(0,26),5);
                        $rand3 = substr(md5(microtime()),rand(0,26),5);
                        $serial_no = 'SN-'.$rand2.''.$item_no.''.$rand3;

                        $route_no = get_route_number($line_no, $conn);

                        $column_count = count($read_data);
                        $subsql = $subsql . " (" . '\'' . $batch_no . '\',' . '\'' . $kanban . '\',' . '\'' . $kanban_no . '\',' . '\'' . $serial_no . '\',';
                        $temp_count++;
                        $start_row++;
                        for ($c = 0; $c < $column_count; $c++) {
                            if ($c == 2) {
                                $subsql = $subsql . '\'' . $item_no . '\',';
                            } else if ($c == 3) {
                                $subsql = $subsql . '\'' . $item_name . '\',';
                            } else if ($c == 4 || $c == 5 || $c == 6) {
                                $item_attr = addslashes(custom_trim($read_data[$c]));
                                if (empty($item_attr)) {
                                    $item_attr = 'N/A';
                                }
                                $subsql = $subsql . '\'' . $item_attr . '\',';
                            } else {
                                $subsql = $subsql . '\'' . addslashes(custom_trim($read_data[$c])) . '\',';
                            }
                        }
                        $subsql = substr($subsql, 0, strlen($subsql) - 2);
                        $subsql = $subsql . '\', \'' . $section . '\', \'' . $read_data[8] . '\', \'' . $route_no . '\', \'' . $date_updated . '\')' . " , ";
                        if ($temp_count % 250 == 0) {
                            $subsql = substr($subsql, 0, strlen($subsql) - 3);
                            $insertsql = $insertsql . $subsql . ";";
                            $insertsql = substr($insertsql, 0, strlen($insertsql));
                            $stmt = $conn -> prepare($insertsql);
                            $stmt -> execute();
                            $insertsql = "INSERT INTO kanban_masterlist (batch_no, kanban, kanban_no, serial_no, line_no, storage_area, item_no, item_name, dimension, size, color, quantity, req_limit, section, req_limit_qty, route_no, date_updated) VALUES ";
                            $subsql = "";
                        } else if ($temp_count == $row_count) {
                            $subsql = substr($subsql, 0, strlen($subsql) - 3);
                            $insertsql2 = $insertsql . $subsql . ";";
                            $insertsql2 = substr($insertsql2, 0, strlen($insertsql2));
                            $stmt = $conn -> prepare($insertsql2);
                            $stmt -> execute();
                        }
                    }
                    
                    fclose($csv_file);

                } else {
                    echo 'Reading CSV file Failed! Try Again or Contact IT Personnel if it fails again';
                }

            } else {
                echo $chkCsvMsg;
            }

        } else {
            echo 'Upload Failed! Try Again or Contact IT Personnel if it fails again';
        }

    } else {
        echo 'Invalid file format';
    }

} else {
    echo 'Please upload a CSV file';
}

$conn = null;
?>