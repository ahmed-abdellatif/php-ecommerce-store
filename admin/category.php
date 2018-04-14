<?php
// include core configuration
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

// get parameter value
$category_id=isset($_GET['id']) ? $_GET['id'] : die('no category id found');

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

// get category name
$category->id=$category_id;
$category->readOne();
$category_name=$category->name;

// count products under the category
$product->category_id=$category_id;
$products_count=$product->countAll_ByCategory();

// set page title
$page_title=$category_name . " <small>{$products_count} Products</small>";

// include page header HTML
include_once "layout_head.php";

// read all categories from the database
$product->category_id=$category_id;
$stmt=$product->readAllByCategory($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// to identify page for paging
$page_url="category.php?id={$category_id}&";

// include products table HTML template
include_once "read_products_template.php";

// include page footer HTML
include_once "layout_foot.php";
?>
