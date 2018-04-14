<?php
// include core configuration
include_once "../config/core.php";

// params
$product_id=isset($_GET['product_id']) ? $_GET['product_id'] : "Product ID not found.";

// include classes
include_once '../config/database.php';
include_once "../objects/category.php";
include_once "../objects/variation.php";
include_once "../objects/product.php";
include_once "../objects/order.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize variation object
$category = new Category($db);
$variation = new Variation($db);
$product = new Product($db);
$order_obj = new Order($db);

// count pending orders
$pending_orders_count=$order_obj->countPending();

// set ID property of product
$product->id = $product_id;

// read the details of product
$product->readOne();

// set page title
$page_title = "<small>Create Variation of </small><br />{$product->name}";

// import page header HTML
include_once "layout_head.php";

// read products button
echo "<div class='row'>";
	echo "<div class='col-md-12 pull-right m-b-20px'>";
		echo "<a href='variations.php?product_id={$product_id}' class='btn btn-primary pull-right'>";
			echo "<span class='glyphicon glyphicon-list'></span> Read Variations";
		echo "</a>";
	echo "</div>";
echo "</div>";

// if the form was submitted
if($_POST){
	echo "<div class='row'>";
		echo "<div class='col-md-12'>";

		// set variation property values
		$variation->product_id=$product_id;
		$variation->name=$_POST['name'];

	    $variation->price=$_POST['price'];
	    $variation->stock=$_POST['stock'];

		// create the variation
		if($variation->create()){

			// tell the user new variation was created
			echo "<div class='alert alert-success'>";
				echo "Variation was created.";
			echo "</div>";
		}

		// if unable to create the variation, tell the user
		else{
			echo "<div class='alert alert-danger'>";
				echo "Unable to create variation.";
			echo "</div>";
		}
		echo "</div>";
	echo "</div>";
}

echo "<div class='row'>";
	echo "<div class='col-md-12'>";
	?>

	<!-- HTML form for creating a variation -->
	<form action='create_variation.php?product_id=<?php echo $product_id; ?>' method='post'>

		<table class='table table-hover table-responsive'>

			<tr>
				<td class='w-30-pct'>Name</td>
				<td><input type='text' name='name' class='form-control' required /></td>
			</tr>

	        <tr>
				<td>Price</td>
				<td><input type='text' name='price' class='form-control' required /></td>
			</tr>

	        <tr>
	            <td>Stock</td>
	            <td><input type='number' name='stock' class='form-control' required /></td>
	        </tr>

			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary">
						<span class='glyphicon glyphicon-plus'></span> Create
					</button>
				</td>
			</tr>

		</table>
	</form>

	<?php
	echo "</div>";
echo "</div>";

// include page footer HTML
include_once "layout_foot.php";
?>
