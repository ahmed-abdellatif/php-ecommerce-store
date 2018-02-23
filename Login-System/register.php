<?php
/*
********************************************************************************************************
* This function processes the user Registration form
* If registration is successful, an email confirmation should
* be sent to the user and requiring the user to confirm his/her
* newly created account
* Author: Ahmed Abdellatif
********************************************************************************************************
*/


require('includes/config.inc.php');

$page_title = 'Register';
include('includes/header.html');

/**
** This is a conditional that checks for the form submission and then calls the database connection
**/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//this is our constant defined in config.inc.php
	require(MYSQL);
	$trimmed = array_map('trim', $_POST);
	$fn = $ln = $e = $p = FALSE;

  // Checks registration form for 'first name' input
	if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['first_name'])) {
		$fn = mysqli_real_escape_string($dbc, $trimmed['first_name']);
	} else {
		echo '<p class="error">You forgot to enter your first name!</p>';
	}

  // Checks registration form for 'last name' input
	if (preg_match('/^[A-Z \'.-]{2,40}$/i', $trimmed['last_name'])) {
		$ln = mysqli_real_escape_string($dbc, $trimmed['last_name']);
	} else {
		echo '<p class="error">You forgot to enter your last name!</p>';
	}

  // Checks registration form for 'email' input
	if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
		$e = mysqli_real_escape_string($dbc, $trimmed['email']);
	} else {
		echo '<p class="error">Please enter a valid email address!</p>';
	}

  // This conditional checks the 'password input' and 'confirm password'
	// input to ensure that the inputs are the same
	if (strlen($trimmed['password1']) >= 10) {
		if ($trimmed['password1'] == $trimmed['password2']) {
			$p = password_hash($trimmed['password1'], PASSWORD_DEFAULT);
		} else {
			echo '<p class="error">Your password did not match the confirmed password!</p>';
		}
	} else {
		echo '<p class="error">Please enter a valid password!</p>';
	}

	if ($fn && $ln && $e && $p) {

		// Make sure the email address is available:
		$q = "SELECT user_id FROM users WHERE email='$e'";

		$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));

		if (mysqli_num_rows($r) == 0) {

			// Create a hash key and store in database, unique to each newly created user
			$a = md5(uniqid(rand(), true));

			// Add the user to the database:
			$q = "INSERT INTO users (email, pass, first_name, last_name, active, registration_date) VALUES ('$e', '$p', '$fn', '$ln', '$a', NOW() )";
			$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) {

				// Send the email:
				$body = "Thank you for registering at <whatever site>. To activate your account, please click on this link:\n\n";
				$body .= BASE_URL . 'activate.php?x=' . urlencode($e) . "&y=$a";
				mail($trimmed['email'], 'Registration Confirmation', $body, 'From: admin@sitename.com');
        echo '<h3>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</h3>';
				include('includes/footer.html');
				exit();

			} else {
				echo '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
			}

		} else {
			echo '<p class="error">That email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.</p>';
		}

	} else {
		echo '<p class="error">Please try again.</p>';
	}
	mysqli_close($dbc);

}
/*
********************************************************************************************************
* Now we will begin writing the user registration form
********************************************************************************************************
*/

?>
<br>
<br>
<!-- Registration Page Content-->
<div class="container padding-bottom-3x mb-2">
	<div class="row">
		<div class="col-md-6" style="margin:0 auto;">

			<!-- BEGIN FORM-->
			<form action="register.php" method="post" class="login-box">
				<!-- Begin 'fieldset' Input Fields-->
				<fieldset>
					<div class="row margin-bottom-1x">
						<h1 style="color: gray; text-align: center; margin:0 auto;">User Registration</h1>
					</div>
					<div class="form-group input-group">
						<label for="reg-fn">First Name</label>
						<input type="text" name="first_name" size="20" maxlength="20" class="form-control" value="<?php if (isset($trimmed['first_name'])) echo $trimmed['first_name']; ?>">
					</div>


					<div class="form-group input-group">
						<label for="reg-ln">Last Name</label>
						<input type="text" name="last_name" size="20" maxlength="40" class="form-control" value="<?php if (isset($trimmed['last_name'])) echo $trimmed['last_name']; ?>">
					</div>



					<div class="form-group input-group">

						<label for="reg-email">E-mail Address</label><input type="email" name="email" size="30" maxlength="60" class="form-control" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>">

					</div>

					<div class="form-group input-group">

						<label for="reg-pass">Password</label>
						<input type="password" name="password1" size="20" class="form-control" value="<?php if (isset($trimmed['password1'])) echo $trimmed['password1']; ?>">
						<small>At least 10 characters long.</small>

					</div>


					<div class="form-group input-group">

						<label for="reg-pass-confirm">Confirm Password</label>
						<input type="password" name="password2" size="20" class="form-control" value="<?php if (isset($trimmed['password2'])) echo $trimmed['password2']; ?>">
					</div>



					<div class="text-center text-sm-right">
						<input type="submit" name="submit" value="Register" class="btn btn-primary margin-bottom-none">
					</div>
				</fieldset>
				<!-- END 'fieldset' END Input Fields-->

			</form>
			<!-- END FORM-->

		</div>
	</div>
</div>

<?php include('includes/footer.html'); ?>
