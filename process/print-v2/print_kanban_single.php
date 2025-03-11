<?php
set_time_limit(0);
session_set_cookie_params(0, "/fg_packaging_debug");
session_name("fg-pkg-debug");
session_start();

if (!isset($_SESSION['username'])) {
    header('location:../../admin/');
    exit();
}

require('../db/conn.php');
require('../lib/main.php');

if (!isset($_GET['id'])) {
    echo 'Query Parameters Not Set';
    exit();
}

$id = $_GET['id'];
$kanban = "";
$kanban_no = 0;
$serial_no = "";
$item_no = "";
$item_name = "";
$section = "";
$line_no = "";
$dimension = "";
$size = "";
$color = "";
$quantity = 0;
$storage_area = "";
$order_date_time = "";
$delivery_date_time = "";
$route_no = "";
$truck_no = "";

$sql = "SELECT kanban, kanban_no, serial_no, item_no, item_name, section, line_no, route_no, dimension, size, color, quantity, storage_area, date_updated FROM kanban_masterlist WHERE id = ?";
$stmt = $conn->prepare($sql);
$params = array($id);
$stmt->execute($params);
if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchAll() as $row) {
        $kanban = $row['kanban'];
        $kanban_no = $row['kanban_no'];
        $serial_no = $row['serial_no'];
        $item_no = $row['item_no'];
        $item_name = $row['item_name'];
        $section = $row['section'];
        $line_no = $row['line_no'];
        $route_no = $row['route_no'];
        $dimension = $row['dimension'];
        $size = $row['size'];
        $color = $row['color'];
        $quantity = $row['quantity'];
        $storage_area = $row['storage_area'];
        $order_date_time = $row['date_updated'];
    }
    $delivery_date_time = date('Y-m-d H:i:s', strtotime('+4 hour', strtotime($order_date_time)));
    $store_out_time = date("H:i", strtotime($delivery_date_time));
    $truck_no = get_truck_number($section, $line_no, $store_out_time, $conn);
}
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="FG Packaging System" />
    <meta name="keywords" content="FG, Packaging, Kanban, Request" />
    <title>FG Packaging | Print Single Kanban</title>

    <!-- Bootstrap -->
    <link rel="preload" href="../../plugins/bootstrap/css/bootstrap.min.css" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">
    <style>
        @media print {
            @page {
                size: portrait;
            }
        }

        table,
        tr,
        td,
        th {
            color: black;
            border: 1px solid black;
            border-width: medium;
            border-collapse: collapse;
        }
    </style>

    <noscript>
        <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">
    </noscript>

    <link rel="icon" type="image/x-icon" href="../../dist/img/fg-pkg-logo.png">
</head>

<body>
    <noscript>
        <br>
        <span>We are facing <strong>Script</strong> issues. Kindly enable <strong>JavaScript</strong>!!!</span>
        <br>
        <span>Call IT Personnel Immediately!!! They will fix it right away.</span>
    </noscript>
    <div class="row ml-1 mb-1">
        <table class="mx-1 my-1" style="width:80%;">
            <tbody>
                <tr>
                    <td colspan="3" style="background-color: black; color: white;">
                        <center>
                            <span class="font-weight-bold" style="font-size:20px;">FG PACKAGING</span>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td class="w-75" colspan="2">
                        <span class="font-weight-bold" style="font-size:14px;">Item Name: </span>
                        <span class="font-weight-bold" style="font-size:24px;"><?= htmlspecialchars($item_name); ?></span>
                    </td>
                    <td rowspan="5" class="pt-2 px-3">
                        <center><label id="kanban"></label></center>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="font-weight-bold" style="font-size:14px;">Item No: </span>
                        <span class="font-weight-bold" style="font-size:24px;"><?= htmlspecialchars($item_no); ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="font-weight-bold" style="font-size:14px;">Dimension: </span>
                        <span class="font-weight-bold" style="font-size:20px;"><?= htmlspecialchars($dimension); ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="font-weight-bold" style="font-size:14px;">Size: </span>
                        <span class="font-weight-bold" style="font-size:20px;"><?= htmlspecialchars($size); ?></span>
                    </td>
                    <td>
                        <span class="font-weight-bold" style="font-size:14px;">Color: </span>
                        <span class="font-weight-bold" style="font-size:20px;"><?= htmlspecialchars($color); ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="font-weight-bold" style="font-size:14px;">Quantity: </span>
                        <span class="font-weight-bold" style="font-size:24px;"><?= htmlspecialchars($quantity); ?></span>
                    </td>
                    <td>
                        <span class="font-weight-bold" style="font-size:14px;">Storage Area: </span>
                        <span class="font-weight-bold"
                            style="font-size:24px;"><?= htmlspecialchars($storage_area); ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="font-weight-bold" style="font-size:14px;">Section: </span>
                        <span class="font-weight-bold" style="font-size:30px;"><?= htmlspecialchars($section); ?></span>
                    </td>
                    <td>
                        <span class="font-weight-bold" style="font-size:14px;">Line No: </span>
                        <span class="font-weight-bold" style="font-size:30px;"><?= htmlspecialchars($line_no); ?></span>
                    </td>
                    <td>
                        <span class="font-weight-bold" style="font-size:14px;">Route No: </span>
                        <span class="font-weight-bold" style="font-size:24px;"><?= htmlspecialchars($route_no); ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="font-weight-bold" style="font-size:14px;">Order: </span>
                        <span class="font-weight-bold"
                            style="font-size:18px;"><?= htmlspecialchars($order_date_time); ?></span>
                    </td>
                    <td>
                        <span class="font-weight-bold" style="font-size:14px;">Delivery: </span>
                        <span class="font-weight-bold"
                            style="font-size:18px;"><?= htmlspecialchars($delivery_date_time); ?></span>
                    </td>
                    <td>
                        <span class="font-weight-bold" style="font-size:14px;">Truck No: </span>
                        <span class="font-weight-bold" style="font-size:18px;"><?= htmlspecialchars($truck_no); ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="px-1 py-2">
                        <center>
                            <img id="serial" alt="serial" style="width:398px; height:50px;">
                            <br>
                            <span class="font-weight-bold" style="font-size:18px;" id="serial_no"></span>
                        </center>
                    </td>
                    <td>
                        <span class="font-weight-bold" style="font-size:14px;">Kanban No: </span>
                        <span class="font-weight-bold" style="font-size:18px;"><?= htmlspecialchars($kanban_no); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/jqueryqrcode/jquery.qrcode.min.js"></script>
    <script src="../../plugins/jsbarcode/dist/barcodes/JsBarcode.code128.min.js"></script>

    <script>
        $('#kanban').qrcode({
            text: "<?= addslashes($row['kanban']); ?>",
            width: 125,
            height: 125
        });
        JsBarcode("#serial", "<?= $serial_no; ?>", { format: "CODE128", displayValue: false });
        document.querySelector("#serial_no").innerHTML = "<?= $serial_no; ?>";
        setTimeout(print_data, 2000);
        function print_data() {
            window.print();
        }
    </script>
</body>

</html>