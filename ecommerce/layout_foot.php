</div>
</div>
    <!-- /row -->
    </div>
</div>

    <!-- /container -->

<br>
<br>
<br>

   <!-- ***** Footer Area Start ***** -->
    <footer class="footer_area section_padding_100">
        <div class="container">
            <div class="row">
                <!-- Single Footer Area Start -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single_footer_area">
                        <div class="footer_heading mb-30">
                            <h6>About us</h6>
                        </div>
                        <div class="footer_content">
                            <p>Almandine is international web &amp; accessories online shop..</p>
                            <p>Phone: +880 123 777 444</p>
                            <p>Email: almandinedesign@outlook.com</p>
                        </div>
                        <div class="footer_social_area mt-15">
                            <a href="https://www.facebook.com/ameabdellatif17"><i class="fab fa-facebook"></i></a>
                            <a href="https://www.instagram.com/ame_abdellatif/"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Single Footer Area Start -->
                <div class="col-12 col-md-6 col-lg">
                    <div class="single_footer_area">
                        <div class="footer_heading mb-30">
                            <h6>Account Information</h6>
                        </div>
                        <ul class="footer_widget_menu">
                            <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Your Account</a></li>
                            <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Free Shipping Policy</a></li>
                            <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Your Cart</a></li>
                            <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Return Policy</a></li>
                            <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Delivery Info</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Single Footer Area Start -->
                <div class="col-12 col-md-6 col-lg">
                    <div class="single_footer_area">
                        <div class="footer_heading mb-30">
                            <h6>Support</h6>
                        </div>
                        <ul class="footer_widget_menu">
                            <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Help</a></li>
                            <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Product Support</a></li>
                            <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Terms &amp; Conditions</a></li>
                            <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Privacy Policy</a></li>
                            <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Payment Method</a></li>
                            <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Affiliate Proggram</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Single Footer Area Start -->
                <div class="col-12 col-md-6 col-lg">
                    <div class="single_footer_area">
                        <div class="footer_heading mb-30">
                            <h6>Join our mailing list</h6>
                        </div>
                        <div class="subscribtion_form">
                            <form action="#" method="post">
                                <input type="email" name="mail" class="mail" placeholder="Your E-mail Addrees">
                                <button type="submit" class="submit"><i class="ti-check" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="single_footer_area mt-30">
                        <div class="footer_heading mb-15">
                            <h6>Download our Mobile Apps</h6>
                        </div>
                        <div class="apps_download">
                            <a href="#"><img src="img/core-img/play-store.png" alt="Play Store"></a>
                            <a href="#"><img src="img/core-img/app-store.png" alt="Apple Store"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Bottom Area Start -->
        <div class="footer_bottom_area">
            <div class="container">
                <div class="row">
                    <!-- Copywrite Content -->
                    <div class="col-12 col-md">
                        <div class="copywrite_text text-left d-flex align-items-center">
                            <p> <i class="fas fa-gem" aria-hidden="true"></i> An Almandine Design <a href="#"></a></p>
                        </div>
                    </div>
                    <!-- Payment Method -->
                    <div class="col-12 col-md">
                        <div class="payment_method text-right">
                            <img src="img/payment-method/paypal.png" alt="">
                            <img src="img/payment-method/maestro.png" alt="">
                            <img src="img/payment-method/western-union.png" alt="">
                            <img src="img/payment-method/discover.png" alt="">
                            <img src="img/payment-method/american-express.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ***** Footer Area End ***** -->


<!-- jQuery library -->
<script src="<?php echo $home_url; ?>libs/js/jquery/jquery-2.2.4.min.js"></script>

<!-- bootbox library -->
<script src="<?php echo $home_url; ?>libs/js/popper.min.js"></script>

<!-- our custom JavaScript -->
<script src="<?php echo $home_url; ?>libs/js/bootstrap.min.js"></script>

<!-- bootstrap JavaScript -->
<script src="<?php echo $home_url; ?>libs/js/plugins.js"></script>
<script src="<?php echo $home_url; ?>libs/js/active.js"></script>

<script src="<?php echo $home_url; ?>libs/js/Bootstrap-Image-Gallery-3.1.1/js/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo $home_url; ?>libs/js/Bootstrap-Image-Gallery-3.1.1/js/bootstrap-image-gallery.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
<script>
// jQuery codes
$(document).ready(function(){

    // lightbox settings
    $('#blueimp-gallery').data('useBootstrapModal', false);
    $('#blueimp-gallery').toggleClass('blueimp-gallery-controls', true);

    // if variation field exists
    if($(".variation").length){
        loadVariation();
    }

    $(document).on('change', '.variation', function(){
        loadVariation();
    });

    $(document).on('click', '#empty-cart', function(){
        bootbox.confirm({
            message: "<h4>Are you sure?</h4>",
            buttons: {
                confirm: {
                    label: '<span class="glyphicon glyphicon-ok"></span> Yes',
                    className: 'btn-danger'
                },
                cancel: {
                    label: '<span class="glyphicon glyphicon-remove"></span> No',
                    className: 'btn-primary'
                }
            },
            callback: function (result) {

                if(result==true){
                    window.location.href = "<?php echo $home_url; ?>empty_cart.php";
                }
            }
        });

    });

    $(document).on('mouseenter', '.product-img-thumb', function(){
        var data_img_id = $(this).attr('data-img-id');
        $('.product-img').hide();
        $('#product-img-'+data_img_id).show();
    });

    // add to cart button listener
    $('.add-to-cart-form').on('submit', function(){

        // info is in the table / single product layout
        var id = $(this).find('.product-id').text();
        var quantity = $(this).find('.cart-quantity').val();
        var variation_id=$('.variation').find(':selected').val();

        // redirect to add_to_cart.php, with parameter values to process the request
        window.location.href = "<?php echo $home_url; ?>add_to_cart.php?id=" + id + "&quantity=" + quantity + "&variation_id=" + variation_id;
        return false;
    });

    // update quantity button listener
    $('.update-quantity-form').on('submit', function(){

        // get basic information for updating the cart
        var id = $(this).find('.product-id').text();
        var quantity = $(this).find('.cart-quantity').val();

        // redirect to update_quantity.php, with parameter values to process the request
        window.location.href = "<?php echo $home_url; ?>update_quantity.php?id=" + id + "&quantity=" + quantity;
        return false;
    });

    // catch the submit form, used to tell the user if password is good enough
    $('#register, #change-password').submit(function(){

        var password_strenght=$('#passwordStrength').text();

        if(password_strenght!='Good Password!'){
            alert('Password not strong enough');
            return false
        }

        return true;
    });

});

function loadVariation(){

    // get variable values
    var variation_id=$('.variation').find(':selected').val();
    var product_id=$('.product-id').text();
    var home_url = $('#home_url').text();

    $('.quantity-container').html("Loading...");

    // load price and quantity select box
    $.post( home_url+"load_variation.php", { variation_id: variation_id, product_id: product_id })
        .done(function( data ) {
            $('.quantity-container').html(data);

            // change price
            var new_price=$('.price').text();
            new_price=parseFloat(new_price).toFixed(2);
            $('.price-description').html('&#36;'+new_price);
        });
}
</script>

<!-- end HTML page -->
</body>
</html>
