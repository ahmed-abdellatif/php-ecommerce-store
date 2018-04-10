<?php
// core configuration
include_once 'config/core.php';

// connect to database
include_once 'config/database.php';

// object
include_once 'objects/cart_item.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$cart_item = new CartItem($db);

// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";

$cart_item->user_id=$_SESSION['user_id'];

if($cart_item->deleteAllByUser()){
	// redirect to product list and tell the user it was added to cart
	header("Location: {$home_url}cart.php?action=empty_success&id={$id}&name={$name}");
}

else{
	header("Location: {$home_url}cart.php?action=empty_failed&id={$id}&name={$name}");
}
?>
