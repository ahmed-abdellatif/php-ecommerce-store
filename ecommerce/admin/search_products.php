<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// include classes
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../objects/product_image.php';
include_once '../objects/product_pdf.php';
include_once '../objects/category.php';
include_once "../objects/variation.php";
include_once "../objects/order.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
$product_pdf = new ProductPdf($db);
$category = new Category($db);
$variation = new Variation($db);
$order_obj = new Order($db);

// count pending orders
$pending_orders_count=$order_obj->countPending();

// get search term
$search_term=isset($_GET['s']) ? $_GET['s'] : '';

// set page title
$page_title = "Product Search Results";

// include page header HTML
include_once "layout_head.php";

// search products
$stmt = $product->search($search_term, $from_record_num, $records_per_page);

// count retrieved products
$num = $stmt->rowCount();

// include products table HTML template
include_once "read_products_template.php";

// include page footer HTML
include_once "layout_foot.php";
?>
