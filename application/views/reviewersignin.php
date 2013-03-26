<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_title; ?></title>
    <link href='http://fonts.googleapis.com/css?family=Averia+Serif+Libre:300|Titillium+Web:300,400italic' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/login.css'; ?>">
		<style type="text/css">
			 body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }
		</style>
	</head>
	<body>
    <div class="sccslogo">
        <img src="<?php echo base_url().'images/logo.png' ?>" alt="">
        <h2 class="form-signin-heading">Reviewer Login</h2>
      </div>
		 <div class="container">
      <?php echo form_open("reviewer/login", array("class" => "form-signin")); ?>
        <?php if($this->session->flashdata('message')) ?>
						<?php echo $this->session->flashdata('message'); ?>
        <input type="text" class="input-block-level" placeholder="Your Email" name="inputLoginEmail">
        <input type="password" class="input-block-level" placeholder="Your Password" name="inputLoginPwd">
        <button class="btn btn-large btn-primary" type="submit">Login</button>
      <?php echo form_close(); ?>
    </div> 
	</body>
</html>
