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
include_once "../objects/order.php";
include_once "../objects/variation.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$category = new Category($db);
$product_image = new ProductImage($db);
$product_pdf = new ProductPdf($db);
$order = new Order($db);
$variation = new Variation($db);

// given field and order
$field = isset($_GET['field']) ? $_GET['field'] : "";
$order = isset($_GET['order']) ? $_GET['order'] : "";

// set page title
$page_title="Active Products";

// include page header HTML
include 'layout_head.php';

// read all active products in the database
$stmt = $product->readAll_WithSorting($from_record_num, $records_per_page, $field, $order);

// count number of products returned
$num = $stmt->rowCount();

// tell the template it is field sort
$field_sort=true;

// to identify page for paging
$page_url="read_products_sorted_by_fields.php?field={$field}&order={$order}&";

// include products table HTML template
include_once "read_products_template.php";

// include page footer HTML
include_once 'layout_foot.php';
?>
