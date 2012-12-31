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
      <?php echo form_open("admin/login", array("class" => "form-signin")); ?>
        <h2 class="form-signin-heading">Login</h2>
        <hr>
        <?php if($this->session->flashdata('message')) ?>
						<?php echo $this->session->flashdata('message'); ?>
        <input type="text" class="input-block-level" placeholder="Your Email" name="inputLoginEmail">
        <input type="password" class="input-block-level" placeholder="Your Password" name="inputLoginPwd">
        <label class="checkbox">
          <input type="checkbox" value="remember-me" name="inputLoginRemember"> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit">Login</button>
      <?php echo form_close(); ?>
    </div> 
	</body>
</html>
