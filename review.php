<?php
// start session
session_start();

// connect to database
include_once "config/core.php";


// include classes
include_once "config/database.php";
include_once "objects/product.php";
include_once "objects/category.php";
include_once "objects/user.php";
include_once 'objects/cart_item.php';
// set page title
$page_title="Review";

// include page header html
include 'layout_head.php';

$action = isset($_GET['action']) ? $_GET['action'] : "";
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : "";

if($action=='removed'){
	echo "<div class='alert alert-info'>";
		echo "<strong>{$name}</strong> was removed from your cart!";
	echo "</div>";
}

else if($action=='quantity_updated'){
	echo "<div class='alert alert-info'>";
		echo "<strong>{$name}</strong> quantity was updated!";
	echo "</div>";
}

if(count($_SESSION['cart'])>0){

	// get the product ids
	$ids = "";
	foreach($_SESSION['cart'] as $id=>$value){
		$ids = $ids . $id . ",";
	}
	
	// remove the last comma
	$ids = rtrim($ids, ',');
	
	//start table
	echo "<table class='table table-hover table-responsive table-bordered' style='margin:1em 0 0 0;'>";
    
        // our table heading
        echo "<tr>";
            echo "<th class='textAlignLeft'>Product Name</th>";
            echo "<th>Price (USD)</th>";
			echo "<th style='width:15em;'>Quantity</th>";
			echo "<th>Sub Total</th>";
        echo "</tr>";
		
		$query = "SELECT id, name, price FROM products WHERE id IN ({$ids}) ORDER BY name";
		
		$stmt = $con->prepare( $query );
		$stmt->execute();
		
		$items=array();

		$total_price=0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
		
			$quantity=$_SESSION['cart'][$id]['quantity'];
			$sub_total=$price*$quantity;
			
			echo "<tr>";
				echo "<td>";
					echo "<div class='product-id' style='display:none;'>{$id}</div>";
					echo "<div class='product-name'>{$name}</div>";
				echo "</td>";
				echo "<td>&#36;" . number_format($price, 2, '.', ',') . "</td>";
				echo "<td>";
					echo $quantity;
				echo "</td>";
				echo "<td>&#36;" . number_format($sub_total, 2, '.', ',') . "</td>";
            echo "</tr>";
			
			$total_price+=$sub_total;
			
			// items for paypal checkout
			$item=array(
				"name" => $name,
				"price" => $price,
				"quantity" => $quantity
			);
			
			array_push($items,$item);
		}
		
		echo "<tr>";
			echo "<td><b>Total</b></td>";
			echo "<td></td>";
			echo "<td>&#36;" . number_format($total_price, 2, '.', ',') . "</td>";
			echo "<td>";
				// custom paypal class
				include_once "libs/php/paypal.php";

				$pp = new paypalcheckout(); 
				$pp->addMultipleItems($items);

				echo $pp->getCheckoutForm();
				
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";

}

else{
	echo "<div class='alert alert-danger'>";
		echo "<strong>No products found</strong> in your cart!";
	echo "</div>";
}

include 'layout_foot.php';
?>