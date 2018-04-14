<?php
$cookie_name="user_id";
setcookie($cookie_name, "", time() - 3600); // set the expiration date to one hour ago
echo "Cookie '{$cookie_name}' is deleted.";
echo "<br />";

$cookie_name="test_cookie";
setcookie($cookie_name, "", time() - 3600);
echo "Cookie '{$cookie_name}' is deleted.";
echo "<br />";

$cookie_name="cookie_is_enabled";
setcookie($cookie_name, "", time() - 3600);
echo "Cookie '{$cookie_name}' is deleted.";
?>