<?php

//This function processes the login form
//If login is successful, the user is redirected


// This is the login page for the site.
require('includes/config.inc.php');
$page_title = 'Login';
include('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require(MYSQL);

	// Validate the email address:
	if (!empty($_POST['email'])) {
		$e = mysqli_real_escape_string($dbc, $_POST['email']);
	} else {
		$e = FALSE;
		echo '<p class="error">No email address?</p>';
	}

	// Validate the password:
	if (!empty($_POST['pass'])) {
		$p = trim($_POST['pass']);
	} else {
		$p = FALSE;
		echo '<p class="error">You forgot to enter your password!</p>';
	}

	if ($e && $p) { // If everything's OK.

		// Query the database:
		$q = "SELECT user_id, first_name, user_level, pass FROM users WHERE email='$e' AND active IS NULL";
		$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));

		if (@mysqli_num_rows($r) == 1) { // A match was made.

			// Fetch the values:
			list($user_id, $first_name, $user_level, $pass) = mysqli_fetch_array($r, MYSQLI_NUM);
			mysqli_free_result($r);

			// Check the password:
			if (password_verify($p, $pass)) {

				// Store the info in the session:
				$_SESSION['user_id'] = $user_id;
				$_SESSION['first_name'] = $first_name;
				$_SESSION['user_level'] = $user_level;
				mysqli_close($dbc);

				// Redirect the user:
				$url = BASE_URL . 'index.php'; // Define the URL.
				ob_end_clean(); // Delete the buffer.
				header("Location: $url");
				exit(); // Quit the script.

			} else {

				echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
			}

		} else { // No match was made.
			echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
		}

	} else { // If everything wasn't OK.
		echo '<p class="error">Please try again.</p>';
	}

	mysqli_close($dbc);

}
?>


<!-- Off-Canvas Wrapper-->
    <div class="offcanvas-wrapper">
      <!-- Page Title-->
      <div class="page-title">
        <div class="container">
          <div class="column">
            <h1>Login / Register Account</h1>
          </div>
          <div class="column">
            <ul class="breadcrumbs">
              <li><a href="index.html">Home</a>
              </li>
              <li class="separator">&nbsp;</li>
              <li><a href="account-orders.html">Account</a>
              </li>
              <li class="separator">&nbsp;</li>
              <li>Login / Register</li>
            </ul>
          </div>
        </div>
      </div>




      <!-- Page Content-->
      <div class="container padding-bottom-3x mb-2">
        <div class="row">
          <div class="col-md-6" style="margin: 0 auto;">
          	<!--

          		FORM BEGIN

          	-->
            <form action="login.php" class="login-box" method="post"><div class="row margin-bottom-1x"><h1 style="color: gray; text-align: center; margin:0 auto;">Login</h1>
              </div>
              <h4 class="margin-bottom-1x">Or using form below</h4>

              	<!--

          		EMAIL BEGIN

          	     -->
              <div class="form-group input-group">
                <input class="form-control" type="email" name="email" size="20" maxlength="60" placeholder="Email" required><span class="input-group-addon"><i class="icon-mail"></i></span>
              </div>


            	<!--

          		PASSWORD BEGIN

          	      -->
              <div class="form-group input-group">
                <input class="form-control" type="password" name="pass" placeholder="Password" size="20" required><span class="input-group-addon"><i class="icon-lock"></i></span>
              </div>


              	<!--

          		REMEMBER ME? BEGIN? Ahmed

          	-->
              <div class="d-flex flex-wrap justify-content-between padding-bottom-1x">
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="checkbox" id="remember_me" checked>
                  <label class="custom-control-label" for="remember_me">Remember me</label>
                </div>

	       <!--

          		FORGOT PASS BEGIN

          	-->
                <a class="navi-link" href="account-password-recovery.html">Forgot password?</a>
              </div>


              	<!--

          		BREAK

          	-->
              <div class="text-center text-sm-right">
                <button class="btn btn-primary margin-bottom-none" name="submit" type="submit" value="Login">Login</button>
              </div>
            </form>

<?php include('includes/footer.html'); ?>
<?php
/*
********************************************************************************************************
* This function processes the login form
* If login is successful, the user is redirected
* Author: Ahmed Abdellatif
**************************************************** ****************************************************
*/

// This is the login page for the site.
require('includes/config.inc.php');
$page_title = 'Login';
include('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require(MYSQL);

	// Validate the email address:
	if (!empty($_POST['email'])) {
		$e = mysqli_real_escape_string($dbc, $_POST['email']);
	} else {
		$e = FALSE;
		echo '<p class="error">Please enter an email address</p>';
	}

	// Validate the password:
	if (!empty($_POST['pass'])) {
		$p = trim($_POST['pass']);
	} else {
		$p = FALSE;
		echo '<p class="error">You forgot to enter your password!</p>';
	}

/*
********************************************************************************************************
* If login goes well, we can now begin inserting users into our database.
********************************************************************************************************
*/

	if ($e && $p) {

		// Query the database:
		$q = "SELECT user_id, first_name, user_level, pass FROM users WHERE email='$e' AND active IS NULL";
		$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));

		if (@mysqli_num_rows($r) == 1) { // A match was made.

			// Fetch the values:
			list($user_id, $first_name, $user_level, $pass) = mysqli_fetch_array($r, MYSQLI_NUM);
			mysqli_free_result($r);

			// Check the password:
			if (password_verify($p, $pass)) {

				// Store the info in the session:
				$_SESSION['user_id'] = $user_id;
				$_SESSION['first_name'] = $first_name;
				$_SESSION['user_level'] = $user_level;
				mysqli_close($dbc);

				// Redirect the user:
				$url = BASE_URL . 'index.php'; // Define the URL.
				ob_end_clean(); // Delete the buffer.
				header("Location: $url");
				exit(); // Quit the script.

			} else {

				echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
			}

		} else { // No match was made.
			echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
		}

	} else { // If everything wasn't OK.
		echo '<p class="error">Please try again.</p>';
	}

	mysqli_close($dbc);

}

/*
********************************************************************************************************
* Now we will begin writing the user login form
********************************************************************************************************
*/

?>
<br>
<br>
<!-- Login Page Content-->
<div class="container padding-bottom-3x mb-2">
	<div class="row">
		<div class="col-md-6" style="margin: 0 auto;">
			<!-- BEGIN FORM-->
			<form action="login.php" method="post" class="login-box">
				<!-- Begin 'fieldset' Input Fields-->
				<fieldset>
					<div class="row margin-bottom-1x">
						<h1 style="color: gray; text-align: center; margin:0 auto;">Login</h1>
					</div>
					<div class="form-group input-group">
						<input class="form-control" type="email" name="email" size="20" maxlength="60">
						<span class="input-group-addon">
									<i class="icon-mail"></i>
								</span>
					</div>
					<div class="form-group input-group">
						<input class="form-control" type="password" name="pass" size="20">
						<span class="input-group-addon">
									<i class="icon-lock"></i>
								</span>
					</div>
					<div class="text-center text-sm-right">
						<input type="submit" name="submit" value="Login" class="btn btn-primary margin-bottom-none">
					</div>
				</fieldset>
				<!-- END 'fieldset' END Input Fields-->
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>

<?php include('includes/footer.html'); ?>
