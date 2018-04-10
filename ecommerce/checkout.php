<?php
// core configuration
include_once "config/core.php";
include_once "libs/php/paypal.php";


// include classes
include_once "config/database.php";
include_once "objects/product.php";
include_once "objects/category.php";
include_once "objects/user.php";
include_once 'objects/cart_item.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$category = new Category($db);
$user = new User($db);
$cart_item = new CartItem($db);

// set page title
$page_title="Checkout";

// include page header HTML
include_once 'layout_head.php';

	$stmt = $cart_item->readAll_WithoutPaging();

	// count number of rows returned
	$num=$stmt->rowCount();


  /*
    if there are products that exist then our cart is not empty
    and it will be populated with products
  */
	if($num>0){

		// display cart items
	    $total=0;
		$item_count=0;

		// used for paypal checkout
		$items=array();

	    while( $row = $stmt->fetch(PDO::FETCH_ASSOC)){
	        extract($row);

			echo "<div class='cart-row'>";
				echo "<div class='col-md-8'>";
					echo "<div class='product-name m-b-10px'><h4>{$name} ({$variation_name})</h4></div>";
					$quantity_str=$quantity>1 ? "items" : "item";
					echo "<div>{$quantity} {$quantity_str}</div>";
				echo "</div>";

				echo "<div class='col-md-4'>";
					echo "<h4>&#36;" . number_format($price, 2, '.', ',') . "</h4>";
				echo "</div>";
			echo "</div>";

			$item_count += $quantity;
			$total += $subtotal;

			// items for paypal checkout
			$item=array(
				"name" => "{$name} ({$variation_name})",
				"price" => $price,
				"quantity" => $quantity
			);
			array_push($items,$item);
	    }

		echo "<div class='col-md-8'></div>";
		echo "<div class='col-md-4'>";
			echo "<div class='cart-row'>";
				echo "<h4 class='m-b-10px'>Total ({$item_count} items)</h4>";
				echo "<h4>&#36;" . number_format($total, 2, '.', ',') . "</h4>";
			echo "</div>";
		echo "</div>";

		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){

			echo "<div class='col-md-12'>";
				// read user information / details
				$user->id=$_SESSION['user_id'];
				$user->readOne();

				// use the information as billing information
				echo "<h4>Billing Information</h4>";

				// table for billing information
				echo "<table class='table table-hover table-responsive' style='margin:0 0 3em 0;'>";
					echo "<tr>";
						echo "<td style='width:50%;'>Name:</td>";
						echo "<td>{$user->firstname} {$user->lastname}</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>Address:</td>";
						echo "<td>{$user->address}</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>Contact Number:</td>";
						echo "<td>{$user->contact_number}</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td colspan='2' class='text-align-center'>";

							// give user the ability to update billing information
							echo "<a href='edit_profile.php' class='btn btn-default'>";
								echo "Edit Billing Information";
							echo "</a>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";

				// payment information
				echo "<h4>Payment Method</h4>";

				/*echo "<table class='table table-hover table-responsive'>";
					echo "<tr>";
						echo "<td style='width:50%;' class='text-align-center'>";
							echo "<div class='btn-group' data-toggle='buttons'>";
								echo "<label class='btn btn-default active'>";
									echo "<input type='radio' name='payment_method' value='0' checked> Cash on Delivery";
								echo "</label>";
							echo "</div>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";*/

				
				// custom paypal class

				include_once "libs/php/paypal.php";

				$pp = new paypalcheckout(); 
				$pp->addMultipleItems($items);

				echo $pp->getCheckoutForm();

				// button to place order
				echo "<div class='text-align-center' style='margin:1em 0;'>";

					// cash on delivery button
					echo "<a href='place_order.php' class='btn btn-lg btn-success btn-cash-on-delivery'>";
						echo "<span class='glyphicon glyphicon-shopping-cart'></span> Place Order";
					echo "</a>";

				echo "</div>";
			echo "</div>";
		}

		// if the user was not logged in yet, tell him he cannot checkout without logging in
		else{
			echo "<div class='col-md-12'>";
				echo "<div class='alert alert-danger'>";
					echo "<strong>Please log in to place order.</strong><br />";
					echo "Already have an account? <a href='{$home_url}login'>Log In</a><br />";
				echo "</div>";
			echo "</div>";
		}
	}

	// tell the user there are no products in the cart
	else{
		echo "<div class='col-md-12'>";
			echo "<div class='alert alert-danger'>";
				echo "<strong>No products found</strong> in your cart!";
			echo "</div>";
		echo "</div>";
	}


// include page footer HTML
include_once 'layout_foot.php';
?>
