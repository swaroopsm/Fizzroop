<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_title; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/bootstrap.css'; ?>">
		<style type="text/css">
			 body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }
		</style>
	</head>
	<body>
		 <div class="container">
      <?php echo form_open("attendee/create", array("class" => "form-signin", "id" => "signupForm")); ?>
        <h2 class="form-signin-heading">Signup</h2>
        <hr>
        <div id="js-messages"></div>
        <?php 
        	echo form_label("Firstname:", "inputFirstName", array("style" => "display: none;"));
        	echo form_input(array("name" => "inputFirstName", "class" => "input-block-level", "placeholder" => "Your Firstname"));
        	echo form_label("Lastname:", "inputLastName", array("style" => "display: none;"));
         echo form_input(array("name" => "inputLastName", "class" => "input-block-level", "placeholder" => "Your Lastname")); 
         echo form_label("Email:", "inputEmail", array("style" => "display: none;"));
         echo form_input(array("name" => "inputEmail", "class" => "input-block-level", "placeholder" => "Your Email"));
         echo form_label("Password:", "inputPassword", array("style" => "display: none;"));
         echo form_password(array("name" => "inputPassword", "class" => "input-block-level", "placeholder" => "Your Password"));
         echo form_submit(array("class" => "btn btn-large btn-primary", "value" => "Signup"));
        ?>
      <?php echo form_close(); ?>
    </div>
    <script src="<?php echo base_url().'js/jquery.js'; ?>"></script>
    <script>

	base_url = "<?php echo base_url(); ?>";
	token =['<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>']


		jQuery.ajaxSetup({
			data: {
				 <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
			}
		});
	</script>
		<script src="<?php echo base_url().'js/vendor.js'; ?>"></script>
		<script src="<?php echo base_url().'js/app.js'; ?>"></script>
    <script>
    	$(document).ready(function(){
    		$("form#signupForm").submit(function(){
    			var stat=$(this).validateFormEmpty();
    			if(stat.success){
    				
    				return true;
    			}
    			else{
    				$("#js-messages").html("<span class='span3 alert alert-danger'><a class='close' data-dismiss='alert' href='#'>&times;</a>"+stat.errorMsg+"</span>").hide().fadeIn(500);
    			}
    			return false;
    		});
    	});
    </script> 
	</body>
</html>
