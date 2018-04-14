<?php
// check if value was posted
if($_POST){

	// include classes
	include_once '../config/database.php';
	include_once '../objects/product_image.php';

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	// prepare product image object
	$product_image = new ProductImage($db);
	
	// set product image id to be deleted
	$image_id=$_POST['object_id'];
	
	// delete the product image
	$product_image->id = $image_id;
	if($product_image->delete()){
		echo "Object was deleted.";
	}
	
	// if unable to delete the product
	else{
		echo "Unable to delete object.";
	}
}
?>