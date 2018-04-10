<?php
// check if value was posted
if($_POST){

	// include classes
	include_once '../config/database.php';
	include_once '../objects/product.php';
	include_once '../objects/product_image.php';
	include_once '../objects/product_pdf.php';

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	// initialize objects
	$product = new Product($db);
	$productImage = new ProductImage($db);
	$productPdf = new ProductPdf($db);
	
	// set product id to be deleted
	$product_id=$_POST['object_id'];
	
	// delete the product
	$product->id = $product_id;
	if($product->delete()){

		// delete all related images in database & directory
		$productImage->product_id = $product_id;
		$productImage->deleteAll();
		
		// delete all related pdf in database & directory
		$productPdf->product_id = $product_id;
		$productPdf->deleteAll();
		
		echo "Object was deleted.";
	}
	
	// if unable to delete the product
	else{
		echo "Unable to delete object.";
	}
}
?>