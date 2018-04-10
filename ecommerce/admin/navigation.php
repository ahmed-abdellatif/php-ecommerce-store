<!-- navbar -->
<div class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container">

		<div class="navbar-header">
			<!-- to enable navigation dropdown when viewed in mobile device -->
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>

			<!-- Change "Your Site" to your site name -->
			<a class="navbar-brand" href="<?php echo $home_url; ?>admin/read_products.php">
		<img src ="../images/logo.png" style="max-width: 10%;" /></a>
		</div>

		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">

				<!-- highlight if $page_title has 'Products' word. -->
				<li <?php echo strpos($page_title, "Product")!==false ? "class='active dropdown'" : "class='dropdown'"; ?>>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						Products <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">

						<!-- highlight if page title is 'Active Products' -->
						<li <?php echo $page_title=="Active Products" ? "class='active'" : ""; ?>>
							<a href="<?php echo $home_url; ?>admin/read_products.php">Active Products</a>
						</li>

						<!-- highlight if page title is 'Inactive Products' -->
						<li <?php echo $page_title=="Inactive Products" ? "class='active'" : ""; ?>>
							<a href="<?php echo $home_url; ?>admin/read_inactive_products.php">Inactive Products</a>
						</li>
						<?php
						// read all categories
						$stmt=$category->readAll_WithoutPaging();
						$num = $stmt->rowCount();

						// loop through retrieved categories
						if($num>0){
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

								// higlight if current category name was set and is the same with the category on current loop
								if(isset($category_name) && $category_name==$row['name']){
									echo "<li class='active'><a href='{$home_url}admin/category.php?id={$row['id']}'>{$row['name']}</a></li>";
								}

								// show without highlight
								else{
									echo "<li><a href='{$home_url}admin/category.php?id={$row['id']}'>{$row['name']}</a></li>";
								}
							}
						}
						?>
					</ul>
				</li>

				<!-- highlight for order related pages -->
				<li <?php echo $page_title=="Orders"
							|| $page_title=="Order Search Results"
							|| $page_title=="Order History"
							|| $page_title=="Order Details" ? "class='active'" : ""; ?> >
					<a href="<?php echo $home_url; ?>admin/read_orders.php">
						Orders
						<?php
						// count unread messages
						$pending_orders_count = isset($pending_orders_count) ? $pending_orders_count : 0;
						echo "<span class='badge'>{$pending_orders_count}</span>";
						?>
					</a>
				</li>

				<!-- highlight for user related pages -->
				<li <?php
						echo $page_title=="Users"
							|| $page_title=="Create User"
							|| $page_title=="Update User"
							|| $page_title=="User Search Results"
							|| strip_tags($page_title)=="Users / Edit User"
							|| strip_tags($page_title)=="Users / Create User"
							? "class='active'" : ""; ?> >
					<a href="<?php echo $home_url; ?>admin/read_users.php">Users</a>
				</li>

			</ul>

			<!-- options in the upper right corner of the page -->
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						&nbsp;&nbsp;<?php echo $_SESSION['firstname']; ?>
						&nbsp;&nbsp;<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<!-- update currently logged in admin user -->
						<li <?php echo $page_title=="Update User" ? "class='active'" : ""; ?>><a href="<?php echo $home_url; ?>admin/update_user.php?id=1">Edit Profile</a></li>

						<!-- change password of logged in admin -->
						<li <?php echo $page_title=="Change Password" ? "class='active'" : ""; ?>><a href="<?php echo $home_url; ?>admin/change_password.php">Change Password</a></li>

						<!-- log out user -->
						<li><a href="<?php echo $home_url; ?>logout.php">Logout</a></li>
					</ul>
				</li>
			</ul>

		</div><!--/.nav-collapse -->

	</div>
</div>
<!-- /navbar -->
