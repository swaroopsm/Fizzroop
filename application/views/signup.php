<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_title; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/style.css'; ?>">
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
      <?php echo form_open("attendee/create", array("class" => "form-signin")); ?>
        <h2 class="form-signin-heading">Signup</h2>
        <?php 
        
        	echo form_input(array("name" => "inputFirstName", "class" => "input-block-level", "placeholder" => "Your Firstname")); 
         echo form_input(array("name" => "inputLastName", "class" => "input-block-level", "placeholder" => "Your Lastname")); 
         echo form_input(array("name" => "inputEmail", "class" => "input-block-level", "placeholder" => "Your Email"));
         echo form_password(array("name" => "inputPassword", "class" => "input-block-level", "placeholder" => "Your Password"));
         echo form_submit(array("class" => "btn btn-large btn-primary", "value" => "Signup"));
        ?>
      <?php echo form_close(); ?>
    </div> 
	</body>
</html>
