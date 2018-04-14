<?php
// force refresh cart
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

// start php session
session_start();

// ===== SET USER ID =====
// used to check if cookie is enabled
setcookie("test_cookie", "test", time() + 3600, '/');

// if cookies are enabled, we save user_id in a cookie
if(count($_COOKIE)>0){

    // if user IS LOGGED IN, we save session user_id to cookie user_id
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){

        // we save session user_id to user_id variable
        $user_id=$_SESSION['user_id'];
    }

    // if user IS NOT LOGGED IN
    else{

        // if user already have a cookie user_id token
        if(isset($_COOKIE['user_id'])){
            // we save cookie user_id to user_id variable
            $user_id=$_COOKIE['user_id'];
        }

        // if cookie user_id IS NOT set (visitor never used the cart before)
        else{
            // we get new token as $user_id
            $user_id = bin2hex(openssl_random_pseudo_bytes(16));
        }

    }

    // either way (logged in or NOT logged in)
    // we set cookie user_id and session user_id with the final $user_id variable value.
    // this will help resurrect the cart data with the same $user_id from mysql database
    setcookie("user_id", $user_id, time() + (86400 * 30), '/'); // 86400 = 1 day
    $_SESSION['user_id']=$user_id;

}

// if cookies are disabled, we simply save user token in php session
else{

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){
        // if user is logged in, we maintain current session's user_id
    }

    // if user is not logged in, get new token
    else{
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $_SESSION['user_id']=$token;
    }
}
// ===== /END SET USER ID =====

// show error reporting
error_reporting(E_ALL);

// set your default time-zone
date_default_timezone_set('America/New_York');

// home page url
$home_url="http://localhost:8888/";
//$home_url="https://almandinedesign.com/";


// ===== PAGINATION =====
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 6;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
// ===== /END PAGINATION =====
?>
