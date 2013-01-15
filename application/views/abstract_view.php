<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_title; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/style.css'; ?>">
		<style type="text/css">
			body{
				padding-top: 80px;
			}
		</style>
	</head>
	<body>
		<?php $this->load->view("layouts/attendeeNavbar"); ?>
		<div class="container">
			 <?php
		  	 echo form_open_multipart("abstract/create", array("class" => "form form-horizontal", "id" => "new_abstract", "style" => "margin-left: 0px;"));
		  	echo form_label("Title:", "inputAbstractTitle", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputAbstractTitle", "id" => "inputAbstractTitle", "class" => "", "placeholder" => "Abstract Title"));
		  	echo form_label("Methods:", "abstractMethods", array("class" => "control-label")); 
		  	echo form_textarea(array("name" => "abstractMethods", "id" => "abstractMethods", "class" => "", "placeholder" => "Abstract Methods"));
		  	echo form_label("Aim:", "abstractAim", array("class" => "control-label"));
		  	echo form_textarea(array("name" => "abstractAim", "id" => "abstractAim", "class" => "", "placeholder" => "Abstract Aim"));
		  	echo form_label("Results:", "abstractResults", array("class" => "control-label")); 
		  	echo form_textarea(array("name" => "abstractResults", "id" => "abstractResults", "class" => "", "placeholder" => "Abstract Results"));
		  	echo form_label("Conservation:", "abstractConservation", array("class" => "control-label")); 
		  	echo form_textarea(array("name" => "abstractConservation", "id" => "abstractConservation", "class" => "", "placeholder" => "Abstract Conservation"));
		  	echo form_label("Image :", "inputAbstractImage", array("class" => "control-label"));
		  	echo form_upload(array("name" => "inputAbstractImage", "id" => "inputAbstractImage", "class" => "", "placeholder" => "Abstract Image"));
		  	echo form_label("Preference :", "inputAbstractPreference", array("class" => "control-label"));
		  	$options = array(
		  						'' => "--Select--",
                  '1'  => 'Small Shirt',
                  '2'    => 'Medium Shirt',
                );
		  	echo form_dropdown("inputAbstractPreference", $options);
		  	echo form_submit(array("id" => "abstractSubmit", "value" => "Submit"));
		  ?>
		</div>
		<script src="<?php echo base_url().'js/jquery.js'; ?>"></script>
		<script src="<?php echo base_url().'js/vendor.js'; ?>"></script>
		<script src="<?php echo base_url().'js/attendee.js'; ?>"></script>
	</body>
</html>
