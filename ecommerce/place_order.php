<?php
// core configuration
include_once "config/core.php";

// set page title
$page_title="Thank You!";

// include login checker
include_once "login_checker.php";

// include classes
include_once "config/database.php";
include_once "objects/product.php";
include_once "objects/category.php";
include_once "objects/user.php";
include_once "objects/order.php";
include_once "objects/order_item.php";
include_once 'objects/cart_item.php';
include_once 'objects/variation.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$category = new Category($db);
$user = new User($db);
$order = new Order($db);
$order_item = new OrderItem($db);
$cart_item = new CartItem($db);
$variation = new Variation($db);

// params
$from_paypal=isset($_GET['from_paypal']) ? $_GET['from_paypal'] : 0;

// include page header HTML
include_once 'layout_head.php';

echo "<div class='col-md-12'>";

	$stmt = $cart_item->readAll_WithoutPaging();

	// count number of rows returned
	$num=$stmt->rowCount();

	if($num>0){

		// generate unique transaction id
		$transaction_id=strtoupper(uniqid());

		// initialize total price
		$total_price=0;

		// loop through product in the cart
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);

			// get current price

			// set values to order item properties
			$order_item->transaction_id=$transaction_id;
			$order_item->product_id=$id;
			$order_item->variation_id=$variation_id;
			$order_item->variation_name=$variation_name;
			$order_item->price=$price;
			$order_item->quantity=$quantity;

			// create the order item
			$order_item->create();

			// compute subtotal
			$sub_total=$price*$quantity;

			// compute total price
			$total_price+=$sub_total;

			// subtract stock
			// get current stock
			$variation->id=$variation_id;
			$variation->readOne();

			// subtract quantity in current stock
			$new_stock=$variation->stock - $quantity;

			// save new stock
			$variation->stock=$new_stock;
			$variation->updateStock();

		}

		// save order information
		$order->user_id=$_SESSION['user_id'];
		$order->transaction_id=$transaction_id;
		$order->total_cost=$total_price;
		$order->from_paypal=$from_paypal;
		$order->status="Pending";
		$order->created=date("Y-m-d H:i:s");

		// create the order
		$order->create();

		// remove cart items
		$cart_item->user_id=$_SESSION['user_id'];
		$cart_item->deleteAllByUser();

		// tell the user order has been placed
		echo "<div class='alert alert-success'>";
			echo "<strong>Your order has been placed!</strong> Thank you very much!";
		echo "</div>";
	}

	// tell the user no products found in his cart
	else{
		echo "<div class='alert alert-danger'>";
			echo "<strong>No products found</strong> in your cart!";
		echo "</div>";
	}

echo "</div>";

// include page footer HTML
include_once 'layout_foot.php';
?>
