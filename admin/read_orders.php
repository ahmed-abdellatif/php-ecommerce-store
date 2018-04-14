<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// include classes
include_once '../config/database.php';
include_once '../objects/order.php';
include_once "../objects/category.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$order = new Order($db);
$category = new Category($db);

// count pending orders
$pending_orders_count=$order->countPending();

// set page title
$page_title = "Orders";

// include page header HTML
include_once "layout_head.php";

// read all orders
$status=isset($_GET['status']) ? $_GET['status'] : "Pending";
$order->status=$status;
$stmt = $order->readAll($from_record_num, $records_per_page);

// count number of retrieved orders
$num = $stmt->rowCount();

$page_url="read_orders.php?status={$status}&";

// include orders table HTML template
include_once "read_orders_template.php";

// include page footer HTML
include_once "layout_foot.php";
?>
