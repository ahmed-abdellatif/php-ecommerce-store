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
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";

// validate quantity
$quantity=$quantity>0 ? $quantity : 1;

$cart_item->product_id=$id;
$cart_item->user_id=$_SESSION['user_id'];
$cart_item->quantity=$quantity;

if($cart_item->update()){
	// redirect to product list and tell the user it was added to cart
	header("Location: {$home_url}cart.php?action=quantity_updated&id={$id}");
}

else{
	header("Location: {$home_url}cart.php?action=quantity_update_failed&id={$id}");
}
?>
