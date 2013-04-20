<script>var absid = <?php  print_r($a[0]['abstractID']); ?></script>

<div class="message"><p>Hi <?php echo $attendeeFirstName." ".$attendeeLastName; ?>!</p>
<p>You have successfully submitted your abstract to SCCS-2013. This page is where you can <a href="#" class="abview">view your submitted abstract</a> and sign up for <a href="#" class="workshops">workshops</a> for SCCS.</p>
</div>


<!-- @TODO: Need to toggle this view -->
<div class="account">
	<h2>My Account</h2>
	<?php
					echo form_open(base_url()."attendee/reset", array("class" => "form form-horizontal", "id" => "attendee_reset", "style" => "margin-left: 0px;"));
          echo form_label("Old Password:", "inputConfPassword", array("class" => "control-label")); 
          echo form_password(array("name" => "inputConfPassword", "id" => "inputConfPassword", "class" => "", "placeholder" => ""));

           echo form_label("New Password", "inputNewPassword", array("class" => "control-label")); 
           echo form_password(array("name" => "inputNewPassword", "id" => "inputNewPassword", "class" => "", "placeholder" => ""));
        ?>
        
        <?php

          echo form_label("Confirm Password", "inputConfNewPwd", array("class" => "control-label")); 
          echo form_password(array("name" => "inputConfNewPwd", "id" => "inputConfNewPwd", "class" => "", "placeholder" => ""));
          
          echo form_submit("save_account", "Save Changes");
          echo form_close();
          
        ?>
</div>
