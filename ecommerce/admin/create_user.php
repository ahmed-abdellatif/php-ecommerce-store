<?php
// core configuration
include_once "../config/core.php";

// make it work in PHP 5.4
include_once "../libs/php/pw-hashing/passwordLib.php";

// check if logged in as admin
include_once "login_checker.php";

// include classes
include_once '../config/database.php';
include_once '../objects/user.php';
include_once "../objects/category.php";
include_once "../objects/order.php";

// utility methods
include_once "../libs/php/utils.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare user and category objects
$user = new User($db);
$category = new Category($db);
$order_obj = new Order($db);

// count pending orders
$pending_orders_count=$order_obj->countPending();

// initialize utility class
$utils = new Utils();

// set page title
$page_title = "Create User";

// include page header HTML
include_once "layout_head.php";

// if HTML form was posted
if($_POST){
	echo "<div class='row'>";
		echo "<div class='col-md-12'>";

		// assign values to user object properties
		$user->firstname=$_POST['firstname'];
		$user->lastname=$_POST['lastname'];
		$user->email=$_POST['email'];
		$user->contact_number=$_POST['contact_number'];
		$user->address=$_POST['address'];
		$user->password=$_POST['password'];
		$user->status=1;
		$user->access_level=$_POST['access_level'];

		// access code for email verification
		$access_code=$utils->getToken();
		$user->access_code=$access_code;

		// create the user
		if($user->create()){
			echo "<div class=\"alert alert-success\" role=\"alert\">User was created</div>";
		}

		// tell the user if unable to create the record
		else{
			echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to create user.</div>";
		}
		echo "</div>";
	echo "</div>";
}

echo "<div class='row'>";
	echo "<div class='col-md-12 pull-right m-b-20px'>";
		echo "<a href='{$home_url}admin/read_users.php' class='btn btn-primary pull-right'>";
			echo "<span class='glyphicon glyphicon-list'></span> Read Users";
		echo "</a>";
	echo "</div>";
echo "</div>";

echo "<div class='row'>";
	echo "<div class='col-md-12'>";
	?>

	<!-- HTML form to create the user -->
	<form action='create_user.php' method='post' id='create-user'>

	    <table class='table table-hover table-responsive'>

	        <tr>
	            <td class='width-30-percent'>Firstname</td>
	            <td><input type='text' name='firstname' class='form-control' required></td>
	        </tr>

	        <tr>
	            <td>Lastname</td>
	            <td><input type='text' name='lastname' class='form-control' required></td>
	        </tr>

			<tr>
	            <td>Contact Number</td>
	            <td><input type='text' name='contact_number' class='form-control' required></td>
	        </tr>

			<tr>
	            <td>Address</td>
	            <td><textarea name='address' class='form-control' required></textarea></td>
	        </tr>

			<tr>
	            <td>Access Level</td>
	            <td>
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-default active">
							<input type="radio" name="access_level" value="Customer" checked> Customer
						</label>

						<label class="btn btn-default">
							<input type="radio" name="access_level" value="admin"> Admin
						</label>

					</div>
				</td>
	        </tr>

			<tr>
	            <td>Email</td>
	            <td><input type='email' name='email' class='form-control' required></td>
	        </tr>

			<tr>
	            <td>Password</td>
	            <td><input type='password' name='password' class='form-control' required id='passwordInput'></td>
	        </tr>

			<tr>
	            <td>Confirm Password</td>
	            <td>
					<input type='password' name='confirm_password' class='form-control' required id='confirmPasswordInput'>
					<p>
						<div class="" id="passwordStrength"></div>
					</p>
				</td>
	        </tr>

	        <tr>
	            <td></td>
	            <td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-plus"></span> Create User
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
