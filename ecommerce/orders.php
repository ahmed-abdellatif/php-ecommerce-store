<?php
// core configuration
include_once "config/core.php";

// set page title
$page_title="Orders";

// include login checker
include_once "login_checker.php";

// include classes
include_once "config/database.php";
include_once "objects/product.php";
include_once "objects/category.php";
include_once "objects/user.php";
include_once "objects/order.php";
include_once 'objects/cart_item.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$category = new Category($db);
$user = new User($db);
$order = new Order($db);
$cart_item = new CartItem($db);

// include page header HTML
include 'layout_head.php';

echo "<div class='col-md-12'>";

	// set user id as order object property
	$order->user_id=$_SESSION['user_id'];

	$status=isset($_GET['status']) ? $_GET['status'] : "Pending";
	$order->status=$status;

	// to get orders under that user id
	$stmt=$order->readAll_ByUser($from_record_num, $records_per_page);

	// count number or rows returned
	$num = $stmt->rowCount();

	if($page_title!="Order Search Results"){
		echo "<ul class='nav nav-tabs margin-bottom-1em'>";
			echo $status=="Pending" ? "<li role='presentation' class='active'>" : "<li role='presentation'>";
				echo "<a href='{$home_url}orders.php'>Pending</a>";
			echo "</li>";
			echo $status=="Processing" ? "<li role='presentation' class='active'>" : "<li role='presentation'>";
				echo "<a href='{$home_url}orders.php?status=Processing'>Processing</a>";
			echo "</li>";
			echo $status=="Completed" ? "<li role='presentation' class='active'>" : "<li role='presentation'>";
				echo "<a href='{$home_url}orders.php?status=Completed'>Completed</a>";
			echo "</li>";
		echo "</ul>";
	}

	// if count more than zero
	if($num>0){

		// display orders table
		echo "<table class='table table-hover table-responsive'>";

			// our table heading
			echo "<tr>";
				echo "<th class='textAlignLeft'>Transaction ID</th>";
				echo "<th>Transaction Date</th>";
				echo "<th>Total Cost</th>";
				echo "<th>Status</th>";
				echo "<th>Action</th>";
			echo "</tr>";

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);

				//creating new table row per record
				echo "<tr>";
					echo "<td>{$transaction_id}</td>";
					echo "<td>{$created}</td>";
					echo "<td>&#36;" . number_format($total_cost, 2, '.', ',') . "</td>";
					echo "<td>{$status}</td>";
					echo "<td>";
						echo "<a href='read_one_order.php?transaction_id={$transaction_id}' class='btn btn-primary'>View Details</a>";
					echo "</td>";
				echo "</tr>";
			}

		echo "</table>";
	}

	// tell the user no orders made yet
	else{
		echo "<div class='alert alert-danger'>";
			echo "<strong>No orders found</strong>";
		echo "</div>";
	}

echo "</div>";

// include page footer HTML
include_once 'layout_foot.php';
?>
