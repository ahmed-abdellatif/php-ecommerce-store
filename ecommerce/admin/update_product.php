<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// get ID of the product to be edited
$product_id = isset($_GET['id']) ? $_GET['id'] : die('Missing product ID.');

// include classes
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../objects/product_image.php';
include_once '../objects/product_pdf.php';
include_once "../objects/category.php";
include_once "../objects/order.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
$product_pdf = new ProductPdf($db);
$category = new Category($db);
$order_obj = new Order($db);

// count pending orders
$pending_orders_count=$order_obj->countPending();

// set page title
$page_title = "Update Product";

// include page header HTML
include_once "layout_head.php";

// read products button
echo "<div class='row'>";
	echo "<div class='col-md-12 pull-right m-b-20px'>";
		echo "<a href='read_products.php' class='btn btn-primary pull-right'>";
			echo "<span class='glyphicon glyphicon-list'></span> Read Products";
		echo "</a>";
	echo "</div>";
echo "</div>";

// set ID property of product to be edited
$product->id = $product_id;

// read the details of product to be edited
$product->readOne();

// if the form was submitted
if($_POST){
	echo "<div class='row'>";
		echo "<div class='col-md-12'>";

		// set product property values
		$product->name = $_POST['name'];
		$product->description = $_POST['description'];
		$product->category_id = $_POST['category_id'];
		$product->active_until = $_POST['active_until'];

		// update the product
		if($product->update()){

			// save the images
			$product_image->product_id = $product_id;
			$product_image->upload();

			// save the pdf files
			$product_pdf->product_id = $product_id;
			$product_pdf->upload();

			echo "<div class='alert alert-success'>";
				echo "Product was updated.";
			echo "</div>";
		}

		// if unable to update the product, tell the user
		else{
			echo "<div class='alert alert-danger'>";
				echo "Unable to update product.";
			echo "</div>";
		}

		echo "</div>";
	echo "</div>";
}

echo "<div class='row'>";
	echo "<div class='col-md-12'>";
	?>

	<!-- HTML form for updating a product -->
	<form action='update_product.php?id=<?php echo $product_id; ?>' method='post' enctype="multipart/form-data">

		<table class='table table-hover table-responsive table-bordered'>

			<tr>
				<td class='w-30-pct'>Name</td>
				<td><input type='text' name='name' value="<?php echo htmlentities($product->name); ?>" class='form-control' required /></td>
			</tr>

			<tr>
				<td>Description</td>
				<td><textarea name='description' class='form-control activate-tinymce'><?php echo htmlspecialchars_decode($product->description); ?></textarea></td>
			</tr>

			<tr>
				<td>Category</td>
				<td>
					<?php
					// read the product categories from the database
					include_once '../objects/category.php';

					$category = new Category($db);
					$stmt = $category->readAll_WithoutPaging();

					// put them in a select drop-down
					echo "<select class='form-control' name='category_id'>";

						echo "<option>Please select...</option>";
						while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
							extract($row_category);

							// current category of the product must be selected
							if($product->category_id==$id){
								echo "<option value='$id' selected>";
							}else{
								echo "<option value='$id'>";
							}

							echo "$name</option>";
						}
					echo "</select>";
					?>
				</td>
			</tr>

			<tr>
				<td>Active Until:</td>
				<td>
					<!-- we are using jQuery UI as data picker -->
					<input type="text" name='active_until' id="active-until" value='<?php echo htmlentities(substr($product->active_until, 0, 10)); ?>' class='form-control' placeholder="Click to pick date" />
				</td>
			</tr>

			<tr>
				<td>Image(s):</td>
				<td>
					<?php
					// set product id
					$product_image->product_id=$product_id;

					// read all images under the product id
					$stmt_product_image = $product_image->readAll();

					// count number of images under a product id
					$num_product_image = $stmt_product_image->rowCount();

					// if retrieved images greater was than 0
					if($num_product_image>0){

						// loop through the retrieved product images
						while ($row = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){

							// product image id and name
							$product_image_id = $row['id'];
							$product_image_name = $row['name'];

							// image source
							$image_source="{$home_url}uploads/images/{$product_image_name}";

							// display the image(s)
							echo "<a href='{$image_source}' target='_blank'>";
								echo "<div class='thumb-image' style='background: url({$image_source}) 50% 50% no-repeat; '>";
									echo "<span class='delete-image delete-object' delete-id='{$product_image_id}' delete-file='delete_image.php'>";
										echo "<img src='{$home_url}images/delete.png' title='Delete image?' />";
									echo "</span>";
								echo "</div>";
							echo "</a>";
						}
					}

					// fake / customized button to browse image to upload
					echo "<div class='thumb-wrapper new-btn' title='Add Pictures'>";
						echo "<img src='{$home_url}images/add.png' />";
					echo "</div>";

					?>
					<!-- real field to browse image to upload -->
					<input type="file" name="files[]" id="html-btn" class='form-control' multiple>
				</td>
			</tr>
			<tr>
				<td>PDF(s):</td>
				<td>
					<?php
					// set product id
					$product_pdf->product_id=$product_id;

					// read all pdf records under the product id
					$stmt_product_pdf = $product_pdf->readAll();

					// count number of pdf records under a product id
					$num_product_pdf = $stmt_product_pdf->rowCount();

					// if retrieved pdf records was greater than 0
					if($num_product_pdf>0){

						// loop through the retrieved product pdf records
						while ($row = $stmt_product_pdf->fetch(PDO::FETCH_ASSOC)){

							// pdf record id and name
							$product_pdf_id = $row['id'];
							$product_pdf_name = $row['name'];

							// display pdf list
							echo "<div class='pdf-item'>";
								echo "<a href='{$home_url}uploads/pdfs/{$product_pdf_name}' target='_blank'>";
									echo "{$product_pdf_name}";
								echo "</a>";

								echo "<span class='delete-pdf delete-object' delete-id='{$product_pdf_id}' delete-file='delete_pdf.php' >";
									echo "<img src='{$home_url}images/delete.png' title='Delete PDF?' />";
								echo "</span>";
							echo "</div>";
						}
					}
					?>

					<!-- field to browse multiple pdf records -->
					<input type="file" name="pdf_file[]" class='form-control' multiple>

				</td>
			</tr>

			<tr>
				<td></td>
				<td>
					<div class='m-b-10px'>Need to set variation, price and stock?</div>
					<div>
						<a href="<?php echo "{$home_url}admin/variations.php?product_id={$product_id}"; ?>" class='btn btn-info'>Click Here</a>
					</div>
				</td>
			</tr>

			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary">
						<span class='glyphicon glyphicon-edit'></span> Update
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
