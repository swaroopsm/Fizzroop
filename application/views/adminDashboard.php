<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_title; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/style.css'; ?>">
	</head>
	<body>
		<?php $this->load->view("adminNavbar"); ?>
		
		<script src="<?php echo base_url().'js/jquery.js'; ?>"></script>
		<script src="<?php echo base_url().'js/vendor.js'; ?>"></script>
	</body>
</html>
