<?php
// check if value was posted
if($_POST){

	// include classes
	include_once '../config/database.php';
	include_once '../objects/variation.php';

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	// prepare variation object
	$variation = new Variation($db);

	// set variation id to be deleted
	$variation_id=$_POST['object_id'];

	// delete the variation
	$variation->id = $variation_id;
	if($variation->delete()){
		echo "Object was deleted.";
	}

	// if unable to delete the product, tell the user
	else{
		echo "Unable to delete object.";
	}
}
?>
