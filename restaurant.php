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

// count all products
$products_count=$product->countAll();

// set page title
$page_title="Restaurant <small>{$products_count}</small>";

// include page header HTML
include_once 'layout_head.php';

// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";

// used when somethign was added to cart
$id = isset($_GET['id']) ? $_GET['id'] : "";

echo "<div class='col-md-12'>";

	// if login was successful
	if($action=='login_success'){
		echo "<div class='alert alert-info'>";
			echo "<strong>Hi " . $_SESSION['firstname'] . ", welcome back!</strong>";
		echo "</div>";
	}

	// if user was not admin
	else if($action=='not_admin'){
		echo "<div class=\"alert alert-danger margin-top-40\" role=\"alert\">You cannot access that page.</div>";
	}

	// if login was successful
	else if($action=='already_logged_in'){
		echo "<div class='alert alert-info'>";
			echo "<strong>You are already logged in.</strong>";
		echo "</div>";
	}

	// if product is inactive
	else if($action=='product_inactive'){
		echo "<div class='alert alert-info'>";
			echo "<strong>The product you are trying to view is inactive.</strong>";
		echo "</div>";
	}

echo "</div>";

// read all active products in the database
$stmt=$product->readAll($from_record_num, $records_per_page);

// count number of retrieved products
$num = $stmt->rowCount();

// if products retrieved were more than zero
if($num>0){

	// display the list of products
	include_once "read_products_template.php";
}

// tell the user if there's no products in the database
else{
	echo "<div class='col-md-12'>";
    	echo "<div class='alert alert-danger'>No products found.</div>";
	echo "</div>";
}

// footer HTML and JavaScript codes
include 'layout_foot.php';
?>
