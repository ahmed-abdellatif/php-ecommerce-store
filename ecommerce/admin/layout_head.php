<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo isset($page_title) ? strip_tags($page_title) : "Store Admin"; ?></title>

    <!-- Bootstrap CSS -->
 	<link href="<?php echo $home_url; ?>libs/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet" media="screen">

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<!-- jQuery UI CSS -->
	<link rel="stylesheet" href="<?php echo $home_url; ?>libs/js/jquery-ui-1.11.4.custom/jquery-ui.min.css" />

	<!-- custom CSS -->
	<link rel="stylesheet" href="<?php echo $home_url; ?>libs/css/admin.css" />

</head>
<body>

	<?php
	// include top navigation bar
	include_once "navigation.php";
	?>

    <!-- container -->
    <div class="container">

		<!-- display page title -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1><?php echo isset($page_title) ? $page_title : "The Code of a Ninja"; ?></h1>
                </div>
            </div>
        </div>
