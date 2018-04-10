<?php
// connect to database
include_once 'config/database.php';
include_once 'config/core.php';

// classes
include_once "libs/php/utils.php";
include_once 'objects/product.php';
include_once 'objects/category.php';
include_once 'objects/cart_item.php';
include_once 'objects/variation.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize utility class
$utils = new Utils();

// initialize objects
$product = new Product($db);
$category = new Category($db);
$cart_item = new CartItem($db);
$variation = new Variation($db);

// page headers
$page_title="Cart";

include_once 'layout_head.php';

echo "<div class='row'>";
	echo "<div class='col-md-12'>";

	// parameters
	$action = isset($_GET['action']) ? $_GET['action'] : "";

	// display a message
	// if a product was added to cart
	if($action=='added'){
		echo "<div class='alert alert-info'>";
			echo "Product was added to your cart!";
		echo "</div>";
	}

	// unable to add product to cart
	else if($action=='failed_add'){
		echo "<div class='alert alert-danger'>";
			echo "Product was not added to cart.";
		echo "</div>";
	}

	// product remove from cart
	else if($action=='removed'){
		echo "<div class='alert alert-info'>";
			echo "Product was removed from your cart!";
		echo "</div>";
	}

	else if($action=='quantity_updated'){
		echo "<div class='alert alert-success'>";
			echo "Product quantity was updated!";
		echo "</div>";
	}

	else if($action=='failed'){
	    echo "<div class='alert alert-danger'>";
			echo "Failed to update product quantity. Please contact us.";
		echo "</div>";
	}

	else if($action=='empty_success'){
	    echo "<div class='alert alert-info'>";
			echo "<strong>Cart was emptied!</strong>";
		echo "</div>";
	}

	else if($action=='empty_failed'){
	    echo "<div class='alert alert-danger'>";
			echo "<strong>Unable to empty cart.</strong>";
		echo "</div>";
	}

	echo "</div>"; // end <div class='col-md-12'>
echo "</div>"; // end row


$stmt = $cart_item->readAll_WithoutPaging();

// count number of rows returned
$num=$stmt->rowCount();

if($num>0){

	// remove all cart contents
	echo "<div class='row'>";
		echo "<div class='col-md-12'>";
			echo "<div class='right-button-margin' style='overflow:hidden;'>";
				echo "<button id='empty-cart' class='btn btn-default pull-right'>Empty Cart</button>";
			echo "</div>";
		echo "</div>";
	echo "</div>";

	// display cart items
    $total=0;
	$item_count=0;
    while( $row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

		echo "<div class='cart-row'>";
			echo "<div class='col-md-8'>";

				echo "<div class='product-name m-b-10px'>";
					echo "<h4>";
						echo "<a href='{$home_url}product/" . $utils->slugify($name) . "/{$id}/'>";
							echo "{$name}";
						echo "</a> ";
						echo "({$variation_name})";
					echo "</h4>";
				echo "</div>";

				// read variation
				$variation->id=$variation_id;
				$variation->readOne();


				echo "<div class='stock-text m-b-10px'>";
					echo "Only {$variation->stock} left in stock.";
				echo "</div>";

				// update quantity
				echo "<form class='update-quantity-form w-200-px'>";
					echo "<div class='product-id' style='display:none;'>{$id}</div>";


					echo "<select name='quantity' class='form-control cart-quantity m-b-10px cart-quantity-dropdown'>";
						for($x=1; $x<=$variation->stock; $x++){
							if($x==$quantity){
								echo "<option selected>{$x}</option>";
							}

							else{
								echo "<option>{$x}</option>";
							}
						}
					echo "</select>";
					echo "<button class='btn btn-default update-quantity' type='submit'>Update</button>";

				echo "</form>";

				// delete from cart
				echo "<a href='remove_from_cart.php?id={$id}&name={$name}' class='btn btn-default'>";
					echo "Delete";
				echo "</a>";
			echo "</div>";

			echo "<div class='col-md-4'>";
				echo "<h4>&#36;" . number_format($price, 2, '.', ',') . "</h4>";
			echo "</div>";
		echo "</div>";

		$item_count += $quantity;
		$total += $subtotal;
    }

	echo "<div class='col-md-8'></div>";
	echo "<div class='col-md-4'>";
		echo "<div class='cart-row'>";
			echo "<h4 class='m-b-10px'>Total ({$item_count} items)</h4>";
			echo "<h4>&#36;" . number_format($total, 2, '.', ',') . "</h4>";
	        echo "<a href='{$home_url}checkout' class='btn btn-success m-b-10px'>";
	        	echo "<span class='glyphicon glyphicon-shopping-cart'></span>Proceed to Checkout";
	        echo "</a>";
		echo "</div>";
	echo "</div>";

}else{
	echo "<div class='row'>";
		echo "<div class='col-md-12'>";
		    echo "<div class='alert alert-danger'>";
		    	echo "<strong>No products found</strong> in your cart!";
		    echo "</div>";
		echo "</div>";
	echo "</div>";
}


include 'layout_foot.php';
?>
