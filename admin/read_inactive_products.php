<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// include classes
include_once "../config/database.php";
include_once "../objects/product.php";
include_once "../objects/category.php";
include_once "../objects/product_image.php";
include_once "../objects/product_pdf.php";
include_once "../objects/variation.php";
include_once "../objects/order.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$category = new Category($db);
$product_image = new ProductImage($db);
$product_pdf = new ProductPdf($db);
$variation = new Variation($db);
$order_obj = new Order($db);

// count pending orders
$pending_orders_count=$order_obj->countPending();

// set page title
$page_title="Inactive Products";

// include page header HTML
include 'layout_head.php';

// read all inactive products  from the database
$stmt=$product->readAll_Inactive($from_record_num, $records_per_page);

// count retrieved inactive products
$num = $stmt->rowCount();

// to identify page for paging
$page_url="read_inactive_products.php?";

// include products table HTML template
include_once "read_products_template.php";

// include page footer HTML
include_once "layout_foot.php";
?>
