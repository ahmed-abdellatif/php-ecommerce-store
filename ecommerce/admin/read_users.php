<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// include classes
include_once '../config/database.php';
include_once '../objects/user.php';
include_once "../objects/category.php";
include_once "../objects/order.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$user = new User($db);
$category = new Category($db);
$order_obj = new Order($db);

// count pending orders
$pending_orders_count=$order_obj->countPending();

// set page title
$page_title = "Users";

// include page header HTML
include_once "layout_head.php";

// read all users from the database
$stmt = $user->readAll($from_record_num, $records_per_page);

// count retrieved users
$num = $stmt->rowCount();

// to identify page for paging
$page_url="read_users.php?";

// include products table HTML template
include_once "read_users_template.php";

// include page footer HTML
include_once "layout_foot.php";
?>
