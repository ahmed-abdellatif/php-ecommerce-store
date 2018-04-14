<?php
// core configuration
include_once "config/core.php";

// make it work in PHP 5.4
include_once "libs/php/pw-hashing/passwordLib.php";

// set page title
$page_title = "Change Password";

// include login checker
include_once "login_checker.php";

// get database connection
include_once 'config/database.php';
include_once 'objects/user.php';
include_once "objects/category.php";
include_once "objects/order.php";
include_once 'objects/cart_item.php';

$database = new Database();
$db = $database->getConnection();

// prepare user object
$user = new User($db);
$category = new Category($db);
$order = new Order($db);
$cart_item = new CartItem($db);

// include page header HTML
include_once "layout_head.php";

echo "<div class='col-md-12'>";

	// if HTML form was posted / submitted
	if($_POST){

		// read user details to get current password
		// read user record based on session user id value
		$user->id=$_SESSION['user_id'];
		$user->readOne();

		// check if submitted current_password is correct
		if(password_verify($_POST['current_password'], $user->password)){

			// new password
			$user->password=$_POST['password'];

			// get user id from session
			$user->id=$_SESSION['user_id'];

			// update user information
			if($user->changePassword()){

				// tell the user it was updated
				echo "<div class='alert alert-success'>Password was changed.</div>";
			}

			// tell the user update was failed
			else{
				echo "<div class='alert alert-danger'>Unable to change password.</div>";
			}
		}

		// if submitted current password is wrong
		else{
			echo "<div class='alert alert-danger'>Current password is incorrect.</div>";
		}
	}

	?>

	<!-- HTML form to update user -->
	<form action='change_password.php' method='post' id='change-password'>

		<table class='table table-hover table-responsive'>

            <tr>
				<td style='width:30%;'>Current Password</td>
				<td><input type='password' name='current_password' class='form-control' required /></td>
			</tr>

			<tr>
				<td>New Password</td>
				<td><input type='password' name='password' class='form-control' required id='passwordInput' /></td>
			</tr>

			<tr>
				<td>Re-type New Password</td>
				<td>
					<input type='password' name='confirm_password' class='form-control' required id='confirmPasswordInput' />
					<p>
						<div class="" id="passwordStrength"></div>
					</p>
				</td>
			</tr>

			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-edit"></span> Change Password
					</button>
				</td>
			</tr>

		</table>
	</form>

<?php
echo "</div>";

// include page footer HTML
include_once "layout_foot.php";
?>
