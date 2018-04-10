<?php
if($_POST){

    // core configuration
    include_once "config/core.php";

    $variation_id=isset($_POST['variation_id']) ? $_POST['variation_id'] : die('ERROR: Variation ID not found.');
    $product_id=isset($_POST['product_id']) ? $_POST['product_id'] : die('ERROR: Product ID not found.');

    // include classes
    include_once "config/database.php";
    include_once 'objects/variation.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // initialize objects
    $variation = new Variation($db);

    // read variation
    $variation->id=$variation_id;
    $variation->readOne();

    // price
    echo "<div class='price display-none'>{$variation->price}</div>";

    // display stock count
    if($variation->stock>0){

        // display quantity selection
        echo "<div class='w-100-pct m-b-10px'>Select Quantity</div>";
        echo "<select name='quantity' class='form-control cart-quantity m-b-10px'>";
            for($x=1; $x<=$variation->stock; $x++){
                echo "<option>{$x}</option>";
            }
        echo "</select>";

    	echo "<div class='stock-text m-b-10px'>";
    		echo "Only {$variation->stock} left in stock.";
    	echo "</div>";

        // enable add to cart button
        echo "<button style='width:100%;' type='submit' class='btn btn-primary add-to-cart m-b-10px'>";
            echo "<span class='glyphicon glyphicon-shopping-cart'></span> Add to cart";
        echo "</button>";
        
    }else if($variation->stock==0){
    	echo "<div class='stock-text m-b-10px'>";
    		echo "Out of stock.";
    	echo "</div>";
    	echo "<div class='f-w-b m-b-10px'>";
    		echo "<a href='{$home_url}contact'>Contact Us</a>";
    	echo "</div>";
    }else{
    	echo "<div class='stock-text m-b-10px'>";
    		echo "Unable to identify stock.";
    	echo "</div>";
    }
}
?>
