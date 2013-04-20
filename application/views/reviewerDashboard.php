<!DOCTYPE html>
<html>
<head>
	<title>SCCS :: COLLOQUY</title>
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css">
</head>
<body data-page="reviewerDashboard">

	<div id="slider">
		<div class="container">
			
			<div class="clear"></div>

			<div id="header">
				<h1>SCCS</h1>
				<p id="poweredby">powered by Colloquy </p>
				<p id="down"> <a href="#"> <img src="images/dropdown.jpg" width="23" height="23" alt=""> </a></p>
				<p>You are logged in as <?php echo $reviewerName; ?> | <a href="#" id="account_link">My Account</a> | <a href="logout">Logout </a> </p>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	
	<!-- Abstract Modal -->
	
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  style="display: none;">
		<div class="modal-header">
		  <a class="close" data-dismiss="modal" aria-hidden="true" href="#">&times;</a>
		  <h3 id="abstractModalLabel"></h3>
		  <div id="abstractBy"></div>
		</div>
		<div class="modal-body">
			<div id="hidden_abstractID"></div>
			<input type="hidden" id="hidden_reviewerID" value="<?php echo $this->session->userdata('id'); ?>"/>
		  <div id="abstractContent"></div>
		</div>
		<div class="modal-footer">
		  <button class="btn btn-primary" id="reviewer_abstract_submit">Save changes</button>
		</div>
	</div>
	
	<!-- End Abstract Modal -->
	
	
	<!-- Account Modal -->
	
	<div id="accountModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="accountModalLabel" aria-hidden="true"  style="display: none;">
		<div class="modal-header">
		  <a class="close" data-dismiss="modal" aria-hidden="true" href="#">&times;</a>
		  <h3 id="accountModalLabel">My Account</h3>
		  <div id="accountBy"></div>
		</div>
		<div class="modal-body">
			<input type="hidden" id="hidden_reviewerID" value="<?php echo $this->session->userdata('id'); ?>"/>
		  <div id="accountContent"></div>
		</div>
		<div class="modal-footer">
		  <button class="btn btn-primary" id="reviewer_account_submit">Save changes</button>
		</div>
	</div>
	
	<!-- End Account Modal -->
	
	
	
	<div class="container">
		<div id="ajaxer">
		</div>
	</div>


	<div id="explain">
		<img class="explain" src="images/talk.png" alt="talk"> : has been voted as a speaker for a talk |
		<img class="explain" src="images/poster.png" alt="poster"> : has been voted as a poster presentation
	</div>
	<div id="footer">
		<p>Colloquy</p>
	</div>
	<script src="<?php echo base_url().'js/jquery.js'; ?>"></script>
	<script src="<?php echo base_url().'js/vendor.js'; ?>"></script>
	<script src="<?php echo base_url().'js/jquery.dataTables.min.js'; ?>"></script>
	<script>
		jQuery.ajaxSetup({
			data: {
				 <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
			}
		});
	</script>
	<script src="<?php echo base_url().'js/reviewer.js'; ?>"></script>
</body>
</html>
