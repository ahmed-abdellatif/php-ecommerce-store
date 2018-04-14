	</div>
	<!-- /container -->

<!-- jQuery library -->
<script src="<?php echo $home_url; ?>libs/js/jquery.js"></script>

<!-- bootbox library -->
<script src="<?php echo $home_url; ?>libs/js/bootbox.min.js"></script>

<!-- our custom JavaScript -->
<script src="<?php echo $home_url; ?>libs/js/custom-script.js"></script>

<!-- jQuery UI JavaScript -->
<script src="<?php echo $home_url; ?>libs/js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="<?php echo $home_url; ?>libs/js/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo $home_url; ?>libs/js/bootstrap/docs-assets/js/holder.js"></script>

<!-- tinymce library -->
<script src="<?php echo $home_url; ?>libs/js/tinymce_4.4.3/js/tinymce/tinymce.min.js"></script>

<script>
// initialize tinymce
tinymce.init({
	selector:'.activate-tinymce',
	height: 350,
	setup : function(ed){
		ed.on('init', function(){
			this.getDoc().body.style.fontSize = '14px';
		});
	},
	plugins: [
		"advlist autolink link image lists charmap print preview hr anchor pagebreak",
		"searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
		"table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
	],
	toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
	toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor fontsizeselect | print preview code ",
	image_advtab: true,
	filemanager_title:"Files",
	external_filemanager_path:"/php-shopping-cart-module/libs/js/responsive_filemanager/filemanager/",
	external_plugins: { "filemanager" : "/php-shopping-cart-module/libs/js/responsive_filemanager/filemanager/plugin.min.js"},
});

// jQuery codes
$(document).ready(function(){

	// date picker
	$( "#active-until" ).datepicker({ dateFormat: 'yy-mm-dd' });

	// change order status
	$('input[type=radio][name=status]').change(function() {
		// get the transaction id
		var transaction_id=$(this).attr('transaction-id');

		// post the change status request to change_order_status.php file
		// post variable include transaction_id and status
		$.post("change_order_status.php", {
			transaction_id: transaction_id,
			status: this.value
		}, function(data){

			// view the response in the log
			console.log(data);

			// tell the user order status was changed
			bootbox.alert("Order status was changed.");

		}).fail(function() {

			// in case posting the request failed, tell the user
			bootbox.alert("Unable to change order status.");

		});
	});

	// click listener for all delete buttons
	$(document).on('click', '.delete-object', function(){

		// current button
		var current_element=$(this);

		// id of record to be deleted
		var id = $(this).attr('delete-id');

		// php file used for deletion
		var delete_file = $(this).attr('delete-file');

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

					console.log(delete_file);

					// post the request to specified delete file
					$.post(delete_file, {
						object_id: id
					}, function(data){

						// show the response to the console
						console.log(data);

						// if deleting product image or pdf
						if(delete_file=='delete_image.php' || delete_file=='delete_pdf.php'){
							current_element.parent().hide();
						}

						// if deleting product, category, user, etc.
						else{
							document.location.href = document.URL;
						}

					}).fail(function() {
						alert('Unable to delete.');
					});

				}
			}
		});

		return false;
	});

	// for browsing and uploading multiple images
	$('.new-btn').bind("click" , function () {
		$('#html-btn').click();
	});

	// register and edit profile submit form catch, used to tell user if password is strong enough or not
	$('#create-user, #change-password').submit(function(){


		if($('#passwordInput').val()!=""){
			var password_strenght=$('#passwordStrength').text();
			if(password_strenght!='Good Password!'){
				alert('Password not strong enough');
				return false
			}
		}
		return true;
	});

});


</script>

<!-- end the HTML page -->
</body>
</html>
