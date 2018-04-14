<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// include classes
include_once '../config/database.php';
include_once '../objects/category.php';
include_once '../objects/order.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$order = new Order($db);
$category = new Category($db);

// get search term
$search_term=isset($_GET['s']) ? $_GET['s'] : '';

// set page title
$page_title = "Order Search Results";

// include page header HTML
include_once "layout_head.php";

// search order based on search term
$stmt = $order->search($search_term, $from_record_num, $records_per_page);

// count number of products returned
$num = $stmt->rowCount();

// include orders table HTML template
include_once "read_orders_template.php";

// include page footer HTML
include_once "layout_foot.php";
?>