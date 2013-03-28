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
      
       <div id="ajaxer"></div>
       
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
    					var obj = $.parseJSON(data);
    					console.log(obj);
    					if(obj.success){
    						if(obj.flag == 1){
    							$("#js-messages").html("You are already registered. Please Login!");
    						}
    						if(obj.flag == 2){
    							$("#signupForm").hide();
    							if($.trim(obj.attendee.attendeeNationality).toLowerCase() != "indian"){
    								var passport_req="<p><input type='text' id='inputPassport' name='inputPassport' placeholder='Your Passport ID'></p>";
    							}
    							else{
    								var passport_req="";
    							}
    							$("#ajaxer").html(
    								"<form class='form-signin' id='step2_reg_form'>"
    								+"<h2 class='form-signin-heading'>You are almost there!</h2>"
					        	+"<hr>"
        						+"<div id='js-messages'></div>"
        						+"<p>Hey, "+obj.attendee.attendeeFirstName
        						+" "+obj.attendee.attendeeLastName+"</p>"
        						+passport_req
        						+"<p><input type='password' id='inputPassword' name='inputPassword' placeholder='Your Password'></p>"
        						+"<input type='hidden' name='inputAttendeeID' id='inputAttendeeID' value='"+obj.attendee.attendeeID+"'>"
        						+"<input type='hidden' name='"+token[0]+"' id='"+token[0]+"' value='"+token[1]+"'>"
        						+"<p><button class='btn btn-primary btn-large' type='submit'>Update</button></p>"
    								+"</form>"
    							);
    						}
    					}
    					else{
    						$("#js-messages").html("Your Ticket or Email does not match our records!");
    					}
    				}
    			);
    			return false;
    		});
    		
    		
    		/**
    			*	Step 2 form submit. 
    		**/
    		
    		$("#step2_reg_form").live("submit", function(){
    			$.ajax({
    				url: base_url+"attendee/register",
    				type: "POST",
    				data: $(this).serialize(),
    				success: function(data){
    					console.log(data);
    					var obj = $.parseJSON(data);
    					if(obj.success){
    						$("#ajaxer").html("<div style='background: #fff;padding: 20px;text-align: center;'><h2>Congratulations you are registered.. <br> <a href='"+base_url+"login'>Login here</a></h2></div>")
    					}
    				}
    			});
    			return false;
    		});
    		
    	});
    </script> 
	</body>
</html>
