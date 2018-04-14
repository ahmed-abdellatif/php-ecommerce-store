<?php
// core configuration
include_once "config/core.php";

// include classes
include_once "libs/php/utils.php";
include_once "config/database.php";
include_once "objects/product.php";
include_once "objects/product_image.php";
include_once "objects/category.php";
include_once 'objects/cart_item.php';
include_once 'objects/variation.php';

// initialize utility class
$utils = new Utils();

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
$category = new Category($db);
$cart_item = new CartItem($db);
$variation = new Variation($db);

// search keywords
$search_term=isset($_GET['s']) ? $_GET['s'] : "";

// to prevent xss
$search_term=htmlspecialchars($search_term, ENT_QUOTES, 'UTF-8');

// set page title
$page_title="Product Search Results";

// include page header HTML
include_once 'layout_head.php';

// searc the database
$stmt = $product->search($search_term, $from_record_num, $records_per_page);

// count number of products received
$num = $stmt->rowCount();

// if count was greater than zero
if($num>0){
	// display the retrieved records
	include_once "read_products_template.php";
}

// tell the user if there's no products in the database
else{
	echo "<div class='col-md-12'>";
    	echo "<div class='alert alert-info'>No products found.</div>";
	echo "</div>";
}

// include page footer HTML
include_once 'layout_foot.php';
?>
