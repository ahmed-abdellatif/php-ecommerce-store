<!-- search product function -->
<div class="row">
	<div class="col-md-3 pull-left m-b-20px">
		<form role="search" action='search_products.php'>
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Type product name..." name="s" id="srch-term" required <?php echo isset($search_term) ? "value='$search_term'" : ""; ?> />
				<div class="input-group-btn">
					<button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
				</div>
			</div>
		</form>
	</div>

	<!-- create product button -->
	<div class='col-md-9 pull-right'>
		<a href='create_product.php' class="btn btn-primary pull-right margin-bottom-1em">
			<span class="glyphicon glyphicon-plus"></span> Create Product
		</a>
	</div>
</div>

<?php
// if number of products returned is more than 0
if($num>0){
	echo "<div class='row'>";
		echo "<div class='col-md-12'>";

		// order opposite of the current order
		$reverse_order=isset($order) && $order=="asc" ? "desc" : "asc";

		// field name
		$field=isset($field) ? $field : "";

		// field sorting arrow
		$field_sort_html="";

		if(isset($field_sort) && $field_sort==true){
			$field_sort_html.="<span class='badge'>";
				$field_sort_html.=$order=="asc"
						? "<span class='glyphicon glyphicon-arrow-up'></span>"
						: "<span class='glyphicon glyphicon-arrow-down'></span>";
			$field_sort_html.="</span>";
		}

		// show list of products to user
		echo "<table class='table table-hover table-responsive table-bordered'>";

			// product table header
			echo "<tr>";
				echo "<th class='w-20-pct'>";
					echo "<a href='read_products_sorted_by_fields.php?field=name&order={$reverse_order}'>";
						echo "Name ";
						echo $field=="name" ? $field_sort_html : "";
					echo "</a>";
				echo "</th>";
				echo "<th class='w-15-pct'>";
					echo "<a href='read_products_sorted_by_fields.php?field=category_name&order={$reverse_order}'>";
						echo "Category ";
						echo $field=="category_name" ? $field_sort_html : "";
					echo "</a>";
				echo "</th>";
				echo "<th class='w-10-pct'>";
					echo "<a href='read_products_sorted_by_fields.php?field=active_until&order={$reverse_order}'>";
						echo "Days Left ";
						echo $field=="active_until" ? $field_sort_html : "";
					echo "</a>";
				echo "</th>";
				echo "<th class='w-10-pct'>Stock</th>";
				echo "<th class='w-10-pct'>Image(s)</th>";
				echo "<th class='w-15-pct'>Actions</th>";
			echo "</tr>";

			// list products from the database
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

				extract($row);

				echo "<tr>";

					// product details
					echo "<td>{$name}</td>";
					echo "<td>{$category_name}</td>";

					// until when a product is active
					echo "<td>";
						if($active_until!="0000-00-00 00:00:00"){
							$date1 = new DateTime($active_until);
							$date2 = new DateTime(date('Y-m-d'));
							$interval = $date1->diff($date2);

							if($date1<$date2){
								echo "Inactive " . $interval->days . " days ago";
							}

							else{
								echo $interval->days . " days ";
							}

						}else{
							echo "Not set.";
						}

					echo "</td>";

					echo "<td>";
						// list variations
						$variation->product_id=$id;
						$stmt_stock=$variation->readByProductId();

						// count number of products returned
						$num_stock = $stmt_stock->rowCount();

						// if number of products returned is more than 0
						if($num_stock>0){
							while ($row_stock = $stmt_stock->fetch(PDO::FETCH_ASSOC)){
								echo "<div>";
					                echo "{$row_stock['name']} - ";
									echo "{$row_stock['stock']} items";
								echo "</div>";
							}
						}else{
							echo "<div>Stock not set.</div>";
						}

						echo "<div><a href='{$home_url}admin/variations.php?product_id={$id}'>Update Here</a></div>";
					echo "</td>";

					echo "<td>";
						// related image files to a product
						$product_image->product_id=$id;
						$stmt_product_image = $product_image->readAll();
						$num_product_image = $stmt_product_image->rowCount();

						if($num_product_image>0){
							$x=1;
							while ($row = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
								$product_image_name = $row['name'];
								echo "<a href='../uploads/images/{$product_image_name}' target='_blank'>Image {$x}</a><br />";
								$x++;
							}
						}else{
							echo "No images.";
						}
					echo "</td>";

					echo "<td>";

						// edit product button
						echo "<a href='update_product.php?id={$id}' class='btn btn-info m-b-10px w-100-pct'>";
							echo "<span class='glyphicon glyphicon-edit'></span> Edit";
						echo "</a>";

						// add variation
						echo "<a href='variations.php?product_id={$id}' class='btn btn-primary m-b-10px w-100-pct'>";
							echo "<span class='glyphicon glyphicon-list-alt'></span> Variations";
						echo "</a>";

						// delete product button
						echo "<a delete-id='{$id}' delete-file='delete_product.php' class='btn btn-danger delete-object m-b-10px w-100-pct'>";
							echo "<span class='glyphicon glyphicon-remove'></span> Delete";
						echo "</a>";
					echo "</td>";

				echo "</tr>";

			}

		echo "</table>";
		echo "</div>";
	echo "</div>";

	// the number of rows retrieved on that page
	$total_rows=0;

	// product search results
	if(isset($search_term) && $page_url="search_products.php?s={$search_term}&"){
		$total_rows = $product->countAll_BySearch($search_term);
	}

	// all inactive products
	else if($page_url=="read_inactive_products.php?"){
		$total_rows = $product->countAll_Inactive();
	}

	// all active products
	else if($page_url=="read_products.php?"){
		$total_rows = $product->countAll();
	}

	else if(isset($field) && isset($order) && $page_url=="read_products_sorted_by_fields.php?field={$field}&order={$order}&"){
		$total_rows=$product->countAll();
	}

	// it's a product category
	else if(isset($category_id) && $page_url=="category.php?id={$category_id}&"){
		$product->category_id=$category_id;
		$total_rows = $product->countAll_ByCategory();
	}

	// actual paging buttons
	include_once 'paging.php';

}

// tell the user if there's no products in the database
else{
	echo "<div class='row'>";
		echo "<div class='col-md-12'>";
			echo "<div class='alert alert-danger'>";
				echo "<strong>No products found.</strong>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
}


?>
