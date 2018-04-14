<?php
// core configuration
include_once "config/core.php";

// set page title
$page_title = "Order Details";

// include login checker
include_once "login_checker.php";


// get database connection
include_once 'config/database.php';
include_once 'objects/user.php';
include_once "objects/category.php";
include_once "objects/order.php";
include_once "objects/order_item.php";
include_once 'objects/cart_item.php';

$database = new Database();
$db = $database->getConnection();

// prepare user object
$user = new User($db);
$category = new Category($db);
$order = new Order($db);
$order_item = new OrderItem($db);
$cart_item = new CartItem($db);

// include page header HTML
include_once "layout_head.php";

echo "<div class='col-md-12'>";

	// read user record base on given id
	$transaction_id=isset($_GET['transaction_id']) ? $_GET['transaction_id'] : "";
	$order->transaction_id=$transaction_id;
	$order->readOneByTransactionId();

	// check if record exists
	if($order->created){

	// read order details
	?>

	<!-- button to view orders list -->
	<div class='right-button-margin' style='overflow:hidden;'>
		<a href='orders.php' class='btn btn-default pull-right'>Back to Orders</a>
	</div>

	<!-- display order summary / details -->
	<h4>Order Summary</h4>

	<table class='table table-hover table-responsive table-bordered'>

		<tr>
			<td>Transaction ID</td>
			<td><?php echo $transaction_id; ?></td>
		</tr>
		<tr>
			<td>Transaction Date</td>
			<td><?php echo $order->created; ?></td>
		</tr>
		<tr>
			<td>Total Cost</td>
			<td>&#36;<?php echo number_format($order->total_cost, 2, '.', ','); ?></td>
		</tr>
		<tr>
			<td>Payment Method</td>
			<td><?php echo $order->from_paypal=="1" ? "PayPal" : "Cash On Delivery"; ?></td>
		</tr>
		<tr>
			<td>Status</td>
			<td><?php echo $order->status; ?></td>
		</tr>
	</table>

	<h4>Order Items</h4>
	<?php

	// retrieve order items
	$order_item->transaction_id=$transaction_id;
	$stmt=$order_item->readAll();

	echo "<table class='table table-hover table-responsive table-bordered'>";

		// our table heading
		echo "<tr>";
			echo "<td class='textAlignLeft'>Product Name</td>";
			echo "<td>Price (USD)</td>";
			echo "<td>Quantity</td>";
			echo "<td>Subtotal</td>";
		echo "</tr>";

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);

			// read product details

			//creating new table row per record
			echo "<tr>";
				echo "<td>{$product_name} ({$variation_name})</td>";
				echo "<td>&#36;" . number_format($price, 2, '.', ',') . "</td>";
				echo "<td>{$quantity}</td>";
				echo "<td>&#36;";
					echo number_format($price*$quantity, 2, '.', ',');
				echo "</td>";
			echo "</tr>";

		}

		// display total cost
		echo "<tr>";
			echo "<td><b>Total Cost</b></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td>&#36;" . number_format($order->total_cost, 2, '.', ',') . "</td>";
		echo "</tr>";

	echo "</table>";

	}

	// tell the user order does not exist
	else{
		echo "<div class='alert alert-danger'>";
			echo "<strong>Order does not exist.</strong>";
		echo "</div>";
	}

echo "</div>";

// include page footer HTML
include_once "layout_foot.php";
?>
