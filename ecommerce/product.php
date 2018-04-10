<?php
// core configuration
include_once "config/core.php";

// include classes
include_once "config/database.php";
include_once "libs/php/utils.php";
include_once "objects/product.php";
include_once "objects/category.php";
include_once "objects/product_image.php";
include_once 'objects/cart_item.php';
include_once 'objects/variation.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize utility class
$utils = new Utils();

// initialize objects
$product = new Product($db);
$category = new Category($db);
$product_image = new ProductImage($db);
$cart_item = new CartItem($db);
$variation = new Variation($db);

// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// set the id as product id property
$product->id = $id;

// check if product is active
if(!$product->isActive()){
	// redirect
	header("Location: {$home_url}products.php?action=product_inactive");
}

// to read single record product
$row = $product->readOne();

// set page title
$page_title = $product->name;

// include page header HTML
include_once 'layout_head.php';

// set product id
$product_image->product_id=$id;

// read all related product image
$stmt_product_image = $product_image->readAll();

// count all relatd product image
$num_product_image = $stmt_product_image->rowCount();

echo "<div class='col-md-1'>";
	// if count is more than zero
	if($num_product_image>0){
		// loop through all product images
		while ($row = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
			// image name and source url
			$product_image_name = $row['name'];
			$source="{$home_url}uploads/images/{$product_image_name}";
			echo "<img src='{$source}' class='product-img-thumb' data-img-id='{$row['id']}' />";
		}
	}else{ echo "No images."; }
echo "</div>";

echo "<div class='col-md-4' id='product-img'>";

	// read all related product image
	$stmt_product_image = $product_image->readAll();
	$num_product_image = $stmt_product_image->rowCount();

	// if count is more than zero
	if($num_product_image>0){
		// loop through all product images
		$x=0;
		while ($row = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
			// image name and source url
			$product_image_name = $row['name'];
			$source="{$home_url}uploads/images/{$product_image_name}";
			$show_product_img=$x==0 ? "display-block" : "display-none";
			echo "<a href='{$source}' id='product-img-{$row['id']}' class='product-img {$show_product_img}' data-gallery>";
				echo "<img src='{$source}' style='width:100%;' />";
			echo "</a>";
			$x++;
		}
	}else{ echo "No images."; }
echo "</div>";

echo "<div class='col-md-5'>";

	$variation->product_id=$id;
	$variation->readFirstByProductId();

	echo "<div class='product-detail'>Price:</div>";
	echo "<h4 class='m-b-10px price-description'>&#36;" . number_format($variation->price, 2, '.', ',') . "</h4>";

	echo "<div class='product-detail'>Product description:</div>";
	echo "<div class='m-b-10px'>";
		// make html
		$page_description = htmlspecialchars_decode(htmlspecialchars_decode($product->description));

		// to show images
		$page_description = str_replace("../libs/js/", "{$home_url}libs/js/", $page_description);

		// for internal links
		$page_description = str_replace("../", "{$home_url}", $page_description);

		// show to user
		echo $page_description;
	echo "</div>";

	echo "<div class='product-detail'>Product category:</div>";
	echo "<div class='m-b-10px'>{$product->category_name}</div>";

echo "</div>";

echo "<div class='col-md-2'>";
	// if product was already added in the cart
	$cart_item->user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "";
	$cart_item->product_id=$id;

	// if product was already added in the cart
	if($cart_item->checkIfExists()){
		echo "<div class='m-b-10px'>This product is already in your cart.</div>";
		echo "<a href='{$home_url}cart' class='btn btn-primary w-100-pct'>";
			echo "Go to cart";
		echo "</a>";

	}

	// if product was not added to the cart yet
	else{

		echo "<form class='add-to-cart-form'>";
			// product id
			echo "<div class='product-id display-none'>{$id}</div>";

			// list variations
			$variation->product_id=$id;
			$stmt_variation=$variation->readByProductId();

			// count number of products returned
			$num_variation = $stmt_variation->rowCount();

			// if number of products returned is more than 0
			if($num_variation>0){
				echo "<div class='w-100-pct m-b-10px'>Select Size</div>";
				echo "<select name='variation' class='form-control variation m-b-10px'>";
				while ($row_variation = $stmt_variation->fetch(PDO::FETCH_ASSOC)){
					echo "<option value={$row_variation['id']}>";
						echo $row_variation['name'];
					echo "</option>";
				}
				echo "</select>";

				// select quantity
				echo "<div class='quantity-container m-b-10px'></div>";

			}else{
				echo "<div class='stock-text m-b-10px'>";
					echo "Stock not set.";
				echo "</div>";
				echo "<div>";
					echo "<a href='{$home_url}contact'>Contact Us</a>";
				echo "</div>";
			}

		echo "</form>";
	}

echo "</div>";
?>

	<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
	<div id="blueimp-gallery" class="blueimp-gallery">
		<!-- The container for the modal slides -->
		<div class="slides"></div>
		<!-- Controls for the borderless lightbox -->
		<h3 class="title"></h3>
		<a class="prev">&#9668;</a>
		<a class="next">&#9658;</a>
		<a class="close">X</a>
		<a class="play-pause"></a>
		<ol class="indicator"></ol>
		<!-- The modal dialog, which will be used to wrap the lightbox content -->
		<div class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" aria-hidden="true">&times;</button>
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body next"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left prev">
							<i class="glyphicon glyphicon-chevron-left"></i>
							Previous
						</button>
						<button type="button" class="btn btn-primary next">
							Next
							<i class="glyphicon glyphicon-chevron-right"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
echo "</div>";

// include page footer HTML
include_once 'layout_foot.php';
?>
