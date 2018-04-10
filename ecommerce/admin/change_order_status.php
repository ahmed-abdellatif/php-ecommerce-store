<?php
// check if value was posted
if($_POST){

	// include classes
	include_once '../config/database.php';
	include_once '../objects/order.php';

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	// initialize order object
	$order = new Order($db);
	
	// set posted values
	$order->transaction_id=isset($_POST['transaction_id']) ? $_POST['transaction_id'] : "";
	$order->status=isset($_POST['status']) ? $_POST['status'] : "";
	
	// change order status
	if($order->changeStatus()){
		echo "Status was changed.";
	}
	
	// if unable to change order status
	else{
		echo "Unable to change status.";
	}
}
?>