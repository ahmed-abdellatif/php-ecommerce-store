<?php
// check if value was posted
if($_POST){

	// include classes
	include_once '../config/database.php';
	include_once '../objects/product_pdf.php';

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	// prepare product pdf object
	$product_pdf = new ProductPdf($db);
	
	// set product pdf id to be deleted
	$pdf_id=$_POST['object_id'];
	
	// delete the product pdf record
	$product_pdf->id = $pdf_id;
	if($product_pdf->delete()){
		echo "Object was deleted.";
	}
	
	// if unable to delete the product
	else{
		echo "Unable to delete object.";
		
	}
}
?>