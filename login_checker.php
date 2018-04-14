<?php
// login checker for 'customer' access level

// if access level was not 'Admin', redirect him to login page
if(isset($_SESSION['access_level']) && $_SESSION['access_level']=="Admin"){
	header("Location: {$home_url}admin/read_products.php?action=logged_in_as_admin");
}

// if it is the 'edit profile' or 'orders' or 'place order' page, require a login
else if(isset($page_title) && ($page_title=="Edit Profile" || $page_title=="Orders" || $page_title=="Place Order")){
	
	// if user not yet logged in, redirect to login page
	if(!isset($_SESSION['access_level'])){
		header("Location: {$home_url}login.php?action=please_login");
	}
}

// if it was the 'login' or 'register' page but the customer was already logged in
else if(isset($page_title) && ($page_title=="Login" || $page_title=="Sign Up")){
	// if user not yet logged in, redirect to login page
	if(isset($_SESSION['access_level']) && $_SESSION['access_level']=="Customer"){
		header("Location: {$home_url}products.php?action=already_logged_in");
	}
}

else{
	// no problem, stay on current page
}
?>