<?php
// This is the main page for the site.

// configuration file: calls DB/SQL Connection
require('includes/config.inc.php');

// Page title and include the HTML header:
$page_title = 'Welcome to this StudentQi!';
include('includes/header.html');

// Welcome the user (by name if they are logged in):
echo '<h1>Welcome';
if (isset($_SESSION['first_name'])) {
	echo ", {$_SESSION['first_name']}";
}
echo '!</h1>';
?>
<p>Success</p>

<?php include('includes/footer.html'); ?>
