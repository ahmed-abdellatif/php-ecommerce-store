<!-- search product function -->
<div class="row">
	<div class="col-md-3 pull-left m-b-20px">
		<form role="search" action='search_users.php'>
			<div class="input-group">

				<!-- maintain search term in the text box -->
				<input type="text" class="form-control" placeholder="Type user email address..." name="s" id="srch-term" required <?php echo isset($search_term) ? "value='$search_term'" : ""; ?> />
				<div class="input-group-btn">
					<button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
				</div>
			</div>
		</form>
	</div>

	<!-- create user form -->
	<div class='col-md-9 pull-right'>
		<a href='create_user.php' class="btn btn-primary pull-right margin-bottom-1em">
			<span class="glyphicon glyphicon-plus"></span> Create User
		</a>
	</div>
</div>

<?php
// display the table if the number of users retrieved was greater than zero
if($num>0){
	echo "<div class='row'>";
	 	echo "<div class='col-md-12'>";
	    echo "<table class='table table-hover table-responsive table-bordered'>";

			// table headers
	        echo "<tr>";
				echo "<th>Name</th>";
	            echo "<th>Email</th>";
	            echo "<th>Contact Number</th>";
	            echo "<th>Access Level</th>";
				echo "<th>Actions</th>";
	        echo "</tr>";

			// loop through the user records
	        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);

				// display user details
	            echo "<tr>";
					echo "<td>{$firstname} {$lastname}</td>";
	                echo "<td>{$email}</td>";
					echo "<td>{$contact_number}</td>";
					echo "<td>{$access_level}</td>";

	                echo "<td>";

						// edit button
						echo "<a href='{$home_url}admin/update_user.php?id={$id}' class='btn btn-info' style='margin:0 1em 0 0;'>";
							echo "<span class='glyphicon glyphicon-edit'></span> Edit";
						echo "</a>";

						// delete button, user with id # 1 cannot be deleted because it is the first admin
						if($id!=1){
							echo "<a delete-id='{$id}' delete-file='delete_user.php' class='btn btn-danger delete-object margin-left-1em'>";
								echo "<span class='glyphicon glyphicon-remove'></span> Delete";
							echo "</a>";

							echo "<a href='{$home_url}admin/order_history.php?id={$id}' class='btn btn-primary'>";
								echo "Order History";
							echo "</a>";
						}
	                echo "</td>";
	            echo "</tr>";
	        }

	    echo "</table>";
		echo "</div>";
	echo "</div>";

	// the number of rows retrieved on that page
	$total_rows=0;

	// user search results
	if(isset($search_term) && $page_url=="search_users.php?s={$search_term}&"){
		$total_rows = $user->countAll_BySearch($search_term);
	}

	// all users
	else if($page_url=="read_users.php?"){
		$total_rows = $user->countAll();
	}

	// actual paging buttons
	include_once 'paging.php';
}

// tell the user there are no selfies
else{
	echo "<div class='row'>";
		echo "<div class='col-md-12'>";
		    echo "<div class=\"alert alert-danger\" role=\"alert\">";
				echo "<strong>No users found.</strong>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
}
?>
