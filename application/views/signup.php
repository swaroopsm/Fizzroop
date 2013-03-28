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
      <?php echo form_open("doattend/check_ticket", array("class" => "form-signin", "id" => "signupForm")); ?>
        <h2 class="form-signin-heading">Signup</h2>
        <hr>
        <div id="js-messages"></div>
        <?php 
        	echo form_label("Ticket Number:", "inputTicketNumber", array("style" => "display: none;"));
        	echo form_input(array("name" => "inputTicketNumber", "id" => "inputTicketNumber", "class" => "input-block-level", "placeholder" => "Your DoAttend Ticket Number"));
         echo form_label("Email:", "inputEmail", array("style" => "display: none;"));
         echo form_input(array("name" => "inputEmail", "id" => "inputEmail", "class" => "input-block-level", "placeholder" => "Your Email"));
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
    <script>
    	$(document).ready(function(){
    		$("form#signupForm").submit(function(){
    			$("#js-messages").html("<img src='<?php echo base_url().'images/loader.gif' ?>'></img>");
    			var ticket = $("#inputTicketNumber").val();
    			console.log(ticket)
    			var email = $("#inputEmail").val();
    			$.post("<?php echo base_url().'doattend/verify/"+ticket+"' ?>",
    				{
    					inputEmail: email
    				},
    				function(data){
    					$("#js-messages").html(data);
    				}
    			);
    			return false;
    		});
    	});
    </script> 
	</body>
</html>
