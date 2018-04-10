<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// get database connection
include_once '../config/database.php';
include_once "../objects/category.php";
include_once "../objects/product.php";
include_once "../objects/variation.php";
include_once "../objects/order.php";

include_once '../libs/php/utils.php';

// get databae connection
$database = new Database();
$db = $database->getConnection();

// instantiate page object
$category = new Category($db);
$product = new Product($db);
$variation = new Variation($db);
$order_obj = new Order($db);

// count pending orders
$pending_orders_count=$order_obj->countPending();

// utilities
$utils = new Utils();

// get ID of the product
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : die('ERROR: missing product ID.');

// set ID property of product
$product->id = $product_id;

// read the details of product
$product->readOne();

// set page headers
$page_title = "<small>Variations of </small><br />{$product->name}";
include_once "layout_head.php";

// create product button
echo "<div class='row'>";
    echo "<div class='col-md-12 pull-right m-b-20px'>";
        echo "<a href='read_products.php' class='btn btn-primary pull-right'>";
            echo "<span class='glyphicon glyphicon-list'></span> Back to Products";
        echo "</a>";

        echo "<a href='create_variation.php?product_id={$product_id}' class='btn btn-primary pull-right m-r-15px'>";
    		echo "<span class='glyphicon glyphicon-plus'></span> Create Variation";
    	echo "</a>";
    echo "</div>";
echo "</div>";

// list variations
$variation->product_id=$product_id;
$stmt=$variation->readByProductId();

// count number of products returned
$num = $stmt->rowCount();

// if number of products returned is more than 0
if($num>0){
    echo "<div class='row'>";
    	echo "<div class='col-md-12'>";
            echo "<table class='table table-responsive'>";

            echo "<tr>";
                echo "<th class='w-25-pct'>Name</th>";
                echo "<th class='w-25-pct'>Price</th>";
                echo "<th class='w-25-pct'>Stock</th>";
                echo "<th class='w-25-pct'>Action</th>";
            echo "</tr>";

            // list products from the database
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                extract($row);

                echo "<tr>";
                    echo "<td>{$name}</td>";
                    echo "<td>&#36;" . number_format($price, 2) . "</td>";
                    echo "<td>{$stock}</td>";
                    echo "<td>";
                        // edit variation button
                        echo "<a href='update_variation.php?id={$id}&product_id={$product_id}' class='btn btn-info m-r-15px'>";
                            echo "<span class='glyphicon glyphicon-edit'></span> Edit";
                        echo "</a>";

                        // delete variation button
                        echo "<a delete-id='{$product_id}' delete-file='delete_variation.php' class='btn btn-danger delete-object'>";
                            echo "<span class='glyphicon glyphicon-remove'></span> Delete";
                        echo "</a>";
                    echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        echo "</div>";
    echo "</div>";

}else{
    echo "<div class='row'>";
        echo "<div class='col-md-12'>";
            echo "<div class='alert alert-danger'>No variations found.</div>";
        echo "</div>";
    echo "</div>";
}

include_once "layout_foot.php";
?>
