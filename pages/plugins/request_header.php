<?php
session_set_cookie_params(0, "/fg_packaging_debug");
session_name("fg-pkg-debug");
session_start();
require('../process/db/conn.php');
require('../process/lib/main.php');

// Delete Recent Scanned Kanban -- In case of browser refresh
function delete_recent_scanned($section, $conn) {
  $sql = "DELETE FROM scanned_kanban WHERE section = ? AND status = 'Scanned'";
  $stmt = $conn -> prepare($sql);
  $params = array($section);
  $stmt -> execute($params);
}

// Delete Recent Requestor Remarks on Scanned Kanban -- In case of browser refresh
function delete_recent_remarks_scanned($section, $conn) {
  $sql = "DELETE FROM requestor_remarks WHERE section = ? AND requestor_status = 'Scanned'";
  $stmt = $conn -> prepare($sql);
  $params = array($section);
  $stmt -> execute($params);
}

if (!isset($_SESSION['id_no'])) {
  header('location:../');
  exit();
} else {
  $ip = $_SERVER['REMOTE_ADDR']; // Uncomment when deployed to production
  //$ip = '172.25.112.131'; // Section 1
  $section = check_ip_section($ip, $conn);
  if ($section == '') {
    // redirect to the restricted page
    header("location:error/no-access.html");
    exit();
  } else {
    // Load Recent Scanned Kanban -- Page Load
    $request_id = load_recent_scanned($section, $_SESSION['id_no'], $conn);
    setcookie('request_id', $request_id, 0, "/fg_packaging_debug");
    // Delete Recent Scanned Kanban -- In case of browser refresh
    //delete_recent_scanned($section, $conn);
    // Delete Recent Requestor Remarks on Scanned Kanban -- In case of browser refresh
    //delete_recent_remarks_scanned($section, $conn);
    $_SESSION['section'] = $section;
  }
  
  if(!isset($_COOKIE['section'])) {
    setcookie('section', $section, 0, "/fg_packaging_debug");
  }
  if(!isset($_COOKIE['ip'])) {
    setcookie('ip', $ip, 0, "/fg_packaging_debug");
  }
  if(!isset($_COOKIE['id_no'])) {
    $id_no = $_SESSION['id_no'];
    setcookie('id_no', $id_no, 0, "/fg_packaging_debug");
  }
  if(!isset($_COOKIE['requestor_name'])) {
    $requestor_name = $_SESSION['requestor_name'];
    setcookie('requestor_name', $requestor_name, 0, "/fg_packaging_debug");
  }
  if(!isset($_COOKIE['requestor'])) {
    $requestor = $_SESSION['requestor'];
    setcookie('requestor', $requestor, 0, "/fg_packaging_debug");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">