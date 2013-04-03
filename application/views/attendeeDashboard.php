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
	</body>
</html>
