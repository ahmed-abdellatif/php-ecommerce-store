<?php
session_start();
// initialize if session cart is empty
if(!isset($_SESSION['cart'])){
    $_SESSION['cart']=array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo isset($page_title) ? strip_tags($page_title) : "Store Front"; ?></title>
    <!--meta name="viewport" content="width=device-width, initial-scale=1"-->
      <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <meta http-equiv="pragma" content="no-cache" />
    <!-- set the page title, for seo purposes too -->



    <!-- Favicon  -->
<link rel="shortcut icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
<link href="<?php echo $home_url; ?>libs/style.css" rel="stylesheet" media="screen">
<link href="<?php echo $home_url; ?>libs/css/core-style.css" rel="stylesheet" media="screen">
    <!-- Responsive CSS -->
<link href="<?php echo $home_url; ?>libs/css/responsive.css" rel="stylesheet" media="screen">

<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<link rel="stylesheet" href="<?php echo $home_url; ?>libs/js/bootstrap/dist/css/bootstrap.css" media="screen">
<link rel="stylesheet" href="<?php echo $home_url; ?>libs/js/Bootstrap-Image-Gallery-3.1.1/css/blueimp-gallery.min.css">
<link rel="stylesheet" href="<?php echo $home_url; ?>libs/js/Bootstrap-Image-Gallery-3.1.1/css/blueimp-gallery.min.css">
<link rel="stylesheet" href="<?php echo $home_url; ?>libs/js/Bootstrap-Image-Gallery-3.1.1/css/bootstrap-image-gallery.min.css">
<link rel="stylesheet" href="<?php echo $home_url; ?>libs/css/user.css" />
<link href="<?php echo $home_url; ?>libs/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="<?php echo $home_url; ?>libs/js/Bootstrap-Image-Gallery-3.1.1/css/bootstrap-image-gallery.min.css">
<link rel="stylesheet" href="<?php echo $home_url; ?>libs/css/user.css" />
</head>
<body>
    <header class="header_area">
        <div class="top_header_area">
            <div class="container h-100">
                <div class="row d-md-flex h-100 align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="top_single_area d-sm-flex align-items-center">
                            <!-- Top Mail Area Start -->
                            <div class="top_mail mr-5">
                                <a class="align-middle" href="mailto:almandinedesign@design.com"><i class="fas fa-envelope"></i> almandinedesign@design.com</a>
                            </div>

                            <div class="top_social">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.facebook.com/ameabdellatif17"><i class="fab fa-facebook"></i></a>
                                <a href="https://www.instagram.com/ame_abdellatif/"><i class="fab fa-instagram"></i></a>

                            </div>
                        </div>
                    </div>


                    <div class="col-12 col-md-6">
                        <div class="top_single_area d-sm-flex align-items-center justify-content-end">
                            <!-- Login Area Start -->
                            <div class="login_area">
                                <p>
                                  <!-- it would make more sense to assign local variables to session names, it would clean the code and make for shorter if statements-->
                                  <?php
                                    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true && $_SESSION['access_level']=='Customer'){
                                  ?>
                             <?php echo $page_title=="Edit Profile" || $page_title=="Orders" || $page_title=="Order Details" ? "class='active'" : ""; ?> |
                                   <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;<?php echo $_SESSION['firstname']; ?>&nbsp;&nbsp;


                              <?php echo $page_title=="Edit Profile" ? "class='active'" : ""; ?>|
                                    <a href="<?php echo $home_url; ?>edit_profile.php">Edit Profile</a>


                              <?php echo $page_title=="Change Password" ? "class='active'" : ""; ?>|
                                     <a href="<?php echo $home_url; ?>change_password.php">Change Password</a>


                               <?php echo $page_title=="Orders" || $page_title=="Order Details" ? "class='active'" : ""; ?> |
                                    <a href="<?php echo $home_url; ?>orders.php">Orders</a>

                                    <a href="<?php echo $home_url; ?>logout.php">Logout</a>
                           </ul>
                        </li>
                        <?php }
                           else{
                        ?>
                                 <li style="list-style: none;" <?php echo $page_title=="Login" ? "class=''" : ""; ?>>
                                   <a href="<?php echo $home_url; ?>login"><i class="far fa-user-circle"></i> Log In</a>
                                 </li>


                        <?php }
                        ?>
                        </p>
                     </div>
                 </div>
             </div>
        </div>
     </div>

        <div class="bottom-header-area" id="stickyHeader">
            <div class="main_header_area">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <!-- Logo Area Start -->
                  <a href="index.php"><div class="col-6 col-md-3">
                            <div class="">

                                     <img src="images/logo.png" style="max-width: 75%; padding:10px;position:relative;top:-1px;" /></a>
                            </div>
                        </div>
                        <!-- Search Area Start -->
                        <div class="col-12 col-md-6">
                            <div class="hero_search_area">
                              <form action="search.php" method="get" role="search" action="<?php echo $home_url; ?>search.php">
                                <input type="search" class="form-control" id="search" aria-describedby="search" placeholder="Search for products, brands or catagory" name="s" />
                               <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                             </form>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="hero_meta_area d-flex text-right align-items-center justify-content-end">


                                <div class="wishlist">
                                    <a href="index.php"><i class="far fa-gem"></i></a>
                                </div>

                                <!-- Cart Area -->
                                <div class="cart" <?php echo $page_title=="cart" ? "class='active'" : ""; ?>>
                                  <a id="header-cart-btn" href="<?php echo $home_url; ?>cart"> <?php
                                      $cart_item->user_id=$_SESSION['user_id'];
                                      $cart_count=$cart_item->countAll();
                                   ?> <i class="fas fa-shopping-bag"></i><span class="cart_quantity" id="comparison-count"><?php echo $cart_count; ?></span></a>
                                </div>
                                <!-- User Area -->
                                <div class="user_thumb cart">
                                    <a href="#" id="header-user-btn">
                                      <i class="far fa-smile" style='margin:0 auto;position:relative;vertical-align:middle;left:-.5em;'></i></a>
                                    <!-- User Meta Dropdown Area Start -->
                                    <ul class="user-meta-dropdown">

                                      <?php
                                        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true && $_SESSION['access_level']=='Customer'){
                                      ?>

                                      <?php echo $page_title=="Edit Profile" || $page_title=="Orders" || $page_title=="Order Details" ? "class='active'" : ""; ?>
                                       <a class ='user-title' href="#" class="" data-toggle="" role="button" aria-expanded="false">&nbsp;&nbsp; Hello
                                         <?php echo $_SESSION['firstname']; ?>&nbsp;&nbsp;!
                                       </a>

                                        <?php echo $page_title=="Edit Profile" ? "class='active'" : ""; ?>
                                        <a href="<?php echo $home_url; ?>edit_profile.php">Edit Profile</a>


                                     <?php echo $page_title=="Change Password" ? "class='active'" : ""; ?>
                                         <a href="<?php echo $home_url; ?>change_password.php">Change Password</a>


                                     <?php echo $page_title=="Orders" || $page_title=="Order Details" ? "class='active'" : ""; ?>
                                        <a href="<?php echo $home_url; ?>orders.php">Orders</a>


                                     <a href="<?php echo $home_url; ?>logout.php">Logout</a>
                               </ul>
                            </li>
                            <?php }
                               else{
                            ?>
                                     <li style="list-style: none;" <?php echo $page_title=="Login" ? "class=''" : ""; ?>>
                                       <a href="<?php echo $home_url; ?>login"> Log In </a>
                                     </li>


                            <?php }
                            ?>

                                    </ul>
                                </div>
                          </div>
                    </div>
                </div>
            </div>

            <!-- Top Header Area End -->

       <!-- Bottom Header Area Start -->
            <div class="bottom-header-area" id="stickyHeader">
            <div class="mainmenu_area">
              <div class="container">
                <nav id="bigshop-nav" class="navigation">
                <!-- Logo Area Start -->
                <div class="nav-header">
                <div class="nav-toggle"></div>
              </div>

            <div class="nav-menus-wrapper">
              <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>

               <li><a href="products.php">Business Websites</a>
                     <ul class="nav-dropdown" role="menu">
                    <?php
                      // read all product categories
                      // small functions created to read all category pages
                      $stmt=$category->readAll_WithoutPaging();
                      $num = $stmt->rowCount();
                       if($num>0){
                         //PDO iteration through database rows
                          while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                          // highlight if the currenct $category_name is the same as the current category name in the loop
                          if(strpos($page_title, "Real Estate") == true && isset($category_name) && $category_name==$row['name']){
                            echo "<li class='active'><a href='{$home_url}category.php?id={$row['id']}'>{$row['name']}</a></li>";
                          }
                          // no highlight
                          else{
                            echo "<li><a href='{$home_url}category.php?id={$row['id']}'>{$row['name']}</a></li>";
                          }
                        }
                      }
                        ?>
                         </ul>
                     </li>



                     <li><a href="contact.php">Contact</a></li>

                                <li><a href="#">Account</a>
                                    <ul class="nav-dropdown">
                                      <?php
                                        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true && $_SESSION['access_level']=='Customer'){
                                      ?>
                                    <li <?php echo $page_title=="Edit Profile" || $page_title=="Orders" || $page_title=="Order Details" ? "class='active'" : ""; ?>>
                                       <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">&nbsp;&nbsp;<?php echo $_SESSION['firstname']; ?>&nbsp;&nbsp;<span class="caret"></span>
                                       </a>
                                    <ul class="dropdown-menu" role="menu">

                                    <li <?php echo $page_title=="Edit Profile" ? "class='active'" : ""; ?>>
                                        <a href="<?php echo $home_url; ?>edit_profile.php">Edit Profile</a>
                                    </li>

                                    <li <?php echo $page_title=="Change Password" ? "class='active'" : ""; ?>>
                                         <a href="<?php echo $home_url; ?>change_password.php">Change Password</a>
                                    </li>

                                    <li <?php echo $page_title=="Orders" || $page_title=="Order Details" ? "class='active'" : ""; ?>>
                                        <a href="<?php echo $home_url; ?>orders.php">Orders</a>
                                    </li>

                                     <li><a href="<?php echo $home_url; ?>logout.php">Logout</a></li>
                               </ul>
                            </li>
                            <?php }
                               else{
                            ?>
                                     <li <?php echo $page_title=="Login" ? "class='active'" : ""; ?>>
                                       <a href="<?php echo $home_url; ?>login"> Log In </a>
                                     </li>


                            <?php }
                            ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
  </header>
</div>
<br>
<br>

<br><br>

                                     <!-- Cart Area -->
                                <div class="cart" <?php echo $page_title=="Cart" ? "class='active'" : ""; ?> > <a id="header-cart-btn" href="<?php echo $home_url; ?>Cart"> <?php
                                             $cart_item->user_id=$_SESSION['user_id'];
                                             $cart_count=$cart_item->countAll();
                                             ?> <i class="fas fa-shopping-bag"></i><span class="cart_quantity" id="comparison-count"><?php echo $cart_count; ?></span></a>
                                </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>


    <section class="shop_list_area ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shop_list_product_area">

                        <div class="shop_top_sidebar_area mb-30 clearfix">
                            <!-- Grid/List View -->
                            <div class="view_area d-inline-block">
                            </div>



                        </div>
                    </div>
                </div>
            </div>



        <?php
        // values for javascript access
        echo "<div id='home_url' style='display:none;'>{$home_url}</div>";

        // if given page title is 'Login', do not display the title
        if($page_title!="Login"){
        ?>
        <div class='col-md-12'>
            <div class="page-header">
                <h1><?php echo isset($page_title) ? $page_title : "Almandine Design Store"; ?></h1>
            </div>
        </div>
        <?php
        }
        ?>

<br>
<br>
