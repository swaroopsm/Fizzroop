<!DOCTYPE html>
<html>
<head>
	<title>SCCS :: COLLOQUY</title>
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>

	<div id="slider">
		<div class="container">
			<div class="col">
				<h2>Conference</h2>
				<p>400 Registered | 10 Reviewers | 12 JUN - 15 JUN | 2012</p>
				<p><a href="#" id="manageCurConf">Manage this conference</a></p>

				<h2>FRONTEND PAGES</h2>
				<p>Manage the pages and content accross the public site</p>
				<p><a href="#" id="createPage">Create Page</a> | <a href="#" id="managePages">Manage Pages</a></p>

				<h2>CONFERENCE ARCHIVE PAGES</h2>
				<p>Manage the conference archive accross the public site</p>
				<p><a href="#">Manage Pages</a></p>
			</div>
			
			<div class="col mid">
				<h2>Abstracts</h2>
				<p><?php echo $total_abstracts; ?> submitted | <?php echo $approved_abstracts; ?> approved | <?php echo $total_reviewers; ?> reviewers | <?php echo $abstract_comments_count; ?> have comments</p>
				<p><a href="#" id="manageAbstracts">Manage Abstracts</a></p>

				<h2>Reviewers</h2>
				<p><?php echo $total_reviewers; ?> reviewers | <?php echo $recommendations; ?> recommended</p>
				<p><a href="#" id="manageReviewers">Manage Reviewers</a> | <a href="#" id="add_reviewer">Add reviewer</a></p>

				<h2>Attendees</h2>
				<p><?php echo $registered_attendees; ?> Registered Attendees</p>
				<p><a href="#" id="manageAttendees">Manage Attendees</a> | <a href="#" id="newAttendee">Add Attendee</a></p>
			</div>

			<div class="col">
				<h2>Conferences</h2>
				<p>3 archived Conferences</p>
				<p><?php echo $archived_conferences; ?> | <a href="<?php echo base_url().'admin/conference/'.$current_conf; ?>">Current Conference</a></p>
				<!-- <h2>Create New Conference</h2>
				<p><a href="#">Create new conference</a></p>
				<p>This will wipe certain records in the database. <br>Proceed with caution.</p> -->
			</div>
			<div class="clear"></div>

			<div id="header">
				<h1>SCCS</h1>
				<p id="poweredby">powered by Colloquy </p>
				<p id="down"> <a href="#"> <img src="images/dropdown.jpg" width="23" height="23" alt=""> </a></p>
				<p>You are logged in as an Administrator <a href="logout">Logout </a> </p>
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
		  <div id="abstractContent"></div>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary" id="abstract_approve_btn">Approve Abstract</button>
		  <button class="btn btn-primary" id="abstract_edit_submit">Save changes</button>
		</div>
	</div>
	
	<!-- End Abstract Modal -->
	
	<!-- Reviewer Modal -->
	
	<div id="reviewersModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="reviewersModalLabel" aria-hidden="true"  style="display: none;">
		<div class="modal-header">
		  <a class="close" data-dismiss="modal" aria-hidden="true" href="#">&times;</a>
		  <h3 id="reviewersModalLabel"></h3>
		</div>
		<div id="hidden_reviewerID"></div>
		<div class="modal-body" id="reviewersData">
		  <p></p>
		</div>
		<div class="modal-footer">
		  <button class="btn btn-primary" id="reviewer_edit_submit">Save changes</button>
		</div>
	</div>
	
	<!-- End Reviewer Modal -->
	
	<!-- Attendee Modal -->
	
	<div id="attendeeModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="attendeesModalLabel" aria-hidden="true"  style="display: none;">
		<div class="modal-header">
		  <a class="close" data-dismiss="modal" aria-hidden="true" href="#">&times;</a>
		  <h3 id="attendeesModalLabel"></h3>
		</div>
		<div id="hidden_attendeeID"></div>
		<div class="modal-body" id="attendeesData">
		  <p></p>
		</div>
		<div class="modal-footer">
		  <button class="btn btn-primary" id="attendee_edit_submit">Save changes</button>
		</div>
	</div>
	
	<!-- End Attendee Modal -->
	
	
	<!-- Add Reviewer Modal -->
	
	<div id="addReviewerModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true"  style="display: none;">
		<div class="modal-header">
		  <a class="close" data-dismiss="modal" aria-hidden="true" href="#">&times;</a>
		  <h3>Add Reviewer</h3>
		</div>
		<div class="modal-body">
			<div id="js-messages"></div>
		  <?php
		  	 echo form_open("reviewer/create", array("class" => "form form-horizontal", "id" => "new_reviewer", "style" => "margin-left: 0px;"));
		  	echo form_label("Firstname:", "inputFirstName", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputFirstName", "id" => "inputFirstName", "class" => "", "placeholder" => "Reviewer's Firstname"));
		  	echo form_label("Lastname:", "inputLastName", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputLastName", "id" => "inputLastName", "class" => "", "placeholder" => "Reviewer's Lastname"));
		  	echo form_label("Email:", "inputEmail", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputEmail", "id" => "inputEmail", "class" => "", "placeholder" => "Reviewer's Email"));
		  	echo form_label("Password:", "inputPassword", array("class" => "control-label")); 
		  	echo form_password(array("name" => "inputPassword", "id" => "inputPassword", "class" => "", "placeholder" => "Reviewer' Password"));
		  ?>
		</div>
		<div class="modal-footer">
		  <input type="submit" value="Add Reviewer"/>
		  <?php echo form_close(); ?>
		</div>
	</div>
	
	<!-- End Add Reviewer Modal -->
	
	
	<!-- List of Reviewers Modal -->
	
	<div id="reviewersListModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="reviewersListModalLabel" aria-hidden="true"  style="display: none;">
		<div class="modal-header">
		  <a class="close" data-dismiss="modal" aria-hidden="true" href="#">&times;</a>
		  <h3 id="reviewersListModalLabel">Reviewers List</h3>
		</div>
		<div class="modal-body" id="reviewersListData">
		  <p></p>
		</div>
		<div class="modal-footer">
		  
		</div>
	</div>
	
	<!-- End List of Reviewers Modal -->
	
	
	<!-- Add Attendee Modal -->
	
	<div id="addAttendeeModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="AttendeeModalLabel" aria-hidden="true"  style="display: none;">
		<div class="modal-header">
		  <a class="close" data-dismiss="modal" aria-hidden="true" href="#">&times;</a>
		  <h3>Add Attendee</h3>
		</div>
		<div class="modal-body">
			 <div id="js-messages2"></div>
		   <?php
		  	 echo form_open("attendee/create", array("class" => "form form-horizontal", "id" => "new_attendee", "style" => "margin-left: 0px;", "action" => "attendee/create"));
		  	echo form_label("Firstname:", "inputFirstName", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputFirstName", "id" => "inputFirstName", "class" => "", "placeholder" => "Attendee's Firstname"));
		  	echo form_label("Lastname:", "inputLastName", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputLastName", "id" => "inputLastName", "class" => "", "placeholder" => "Attendee's Lastname"));
		  	echo form_label("Email:", "inputEmail", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputEmail", "id" => "inputEmail", "class" => "", "placeholder" => "Attendee's Email"));
		  	echo form_label("Password:", "inputPassword", array("class" => "control-label")); 
		  	echo form_password(array("name" => "inputPassword", "id" => "inputPassword", "class" => "", "placeholder" => "Attendee' Password"));
		  	echo form_label("Gender:", "inputGender", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputGender", "id" => "inputGender", "class" => "", "placeholder" => "Attendee's Gender"));
		  	echo form_label("Date of Birth:", "inputDOB", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputDOB", "id" => "inputDOB", "class" => "", "placeholder" => "Attendee's Date of Birth"));
		  	echo form_label("Academic Status:", "inputAcademic", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputAcademic", "id" => "inputAcademic", "class" => "", "placeholder" => "Academic Status"));
		  	echo form_label("Institution Affiliation:", "inputInstAffiliation", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputInstAffiliation", "id" => "inputInstAffiliation", "class" => "", "placeholder" => "Institution Affiliation"));
		  	echo "<br>";
		  	echo form_label("Address:", "inputAddress", array("class" => "control-label")); 
		  	echo form_textarea(array("name" => "inputAddress", "id" => "inputAddress", "class" => "", "placeholder" => "Attendee's Address"));
		  	echo "<br>";
		  	echo form_label("Phone:", "inputPhone", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputPhone", "id" => "inputPhone", "class" => "", "placeholder" => "Attendee's Phone"));
		  	echo form_label("Nationality:", "inputNationality", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputNationality", "id" => "inputNationality", "class" => "", "placeholder" => "Attendee's Nationality"));
		  	echo form_label("Passport:", "inputPassport", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputPassport", "id" => "inputPassport", "class" => "", "placeholder" => "Attendee's Passport"));
		  ?>
		</div>
		<div class="modal-footer">
		  <input type="submit" value="Add Attendee"/>
		  <?php echo form_close(); ?>
		</div>
	</div>
	
	<!-- End Add Attendee Modal -->

	
	<!-- Single Page Modal -->
	
	<div id="pageModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="pageModalLabel" aria-hidden="true"  style="display: none;">
		<div class="modal-header">
		  <a class="close" data-dismiss="modal" aria-hidden="true" href="#">&times;</a>
		  <h3 id="pageModalLabel"></h3>
		</div>
		<div class="modal-body" id="pageData">
		  <p></p>
		</div>
		<div class="modal-footer">
		  <button id="save_page">Save Changes</button>
		   <button id="delete_page">Delete Page</button>
		</div>
	</div>
	
	<!-- End Single Page Modal -->
	
	
	<!-- Create Page Modal -->
	
	<div id="createPageModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="createPageModalLabel" aria-hidden="true"  style="display: none;">
		<div class="modal-header">
		  <a class="close" data-dismiss="modal" aria-hidden="true" href="#">&times;</a>
		  <h3 id="createPageModalLabel">Create Page</h3>
		</div>
		<div class="modal-body">
			<div id="js-messages3"></div>
		  <?php
		  	 echo form_open("page/create", array("class" => "form form-horizontal", "id" => "new_page", "style" => "margin-left: 0px;", "action" => "page/create"));
		  	echo form_label("Title:", "inputPageTitle", array("class" => "control-label")); 
		  	echo form_input(array("name" => "inputPageTitle", "id" => "inputPageTitle", "class" => "", "placeholder" => "Page Title"));
		  ?>
		  <br>
		  <label>Content: </label><br>
		  <div id="inputPageContent" name="inputPageContent" contenteditable="true" class="pageContent"></div>
		  <?php
		  	echo form_label("Type:", "inputPageType", array("class" => "control-label"));
		  	$options = array(
		  		 ''	=> "--Select--",
           '1'  => 'Normal Page',
           '2'    => 'Plenary',
           '3' => 'Workshop',
           '4' => 'Special Talks'
           );
        echo form_dropdown("inputPageType", $options);
		  ?>
		</div>
		<div class="modal-footer">
		  <?php
		  	echo form_submit(array("id" => "pageSubmit", "value" => "Submit"));
		  	echo form_close();
		  ?>
		</div>
	</div>
	
	<!-- End Create Page Modal -->
	
	
	<!-- Publish Abstracts Modal -->
	
	
	<div id="publishAbstractsModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="publishAbstractsModalLabel" aria-hidden="true"  style="display: none;">
		<div class="modal-header">
		  <a class="close" data-dismiss="modal" aria-hidden="true" href="#">&times;</a>
		  <h3 id="publishAbstractsModalLabel">Publish Approved Abstracts</h3>
		</div>
		<div class="modal-body" id="publishAbstractsData">
		  <p>This will publish all the Abstracts that are being approved.</p>
		</div>
		<div class="modal-footer">
		  <button id="publish_abstracts_btn">Publish All</button>
		</div>
	</div>
	
	
	<!-- End Publish Abstracts Modal -->
	
	
	<!-- Send Email to Attendees whose Abstracts have been approved Modal -->
	
	
	<div id="emailSelAttModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="emailSelAttModalLabel" aria-hidden="true"  style="display: none;">
		<div class="modal-header">
		  <a class="close" data-dismiss="modal" aria-hidden="true" href="#">&times;</a>
		  <h3 id="emailSelAttModalLabel">Alert Attendees</h3>
		</div>
		<div class="modal-body" id="emailSelAttData">
		  <p>This will alert all attendees whose abstracts have been selected.</p>
		  <p>
		  	<?php
		  		echo form_label("Subject:", "inputEmailSubject", array("class" => "control-label")); 
			  	echo form_input(array("name" => "inputEmailSubject", "id" => "inputEmailSubject", "class" => "", "placeholder" => "Email Subject"));
			  	echo form_label("Message:", "inputEmailMessage", array("class" => "control-label"));
		  		echo form_textarea(array("name" => "inputEmailMessage", "id" => "inputEmailMessage", "class" => "", "placeholder" => "Email Body"));
		  	?>
		  	
		  </p>
		</div>
		<div class="modal-footer">
		  <button id="send_sel_att_btn">Send Email</button>
		</div>
	</div>
	
	
	<!-- End Send Email to Attendees whose Abstracts have been approved Modal -->
	
	
	<!-- Send Email to Attendees whose Abstracts have been rejected Modal -->
	
	
	<div id="emailRejAttModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="emailRejAttModalLabel" aria-hidden="true"  style="display: none;">
		<div class="modal-header">
		  <a class="close" data-dismiss="modal" aria-hidden="true" href="#">&times;</a>
		  <h3 id="emailRejAttModalLabel">Alert Attendees</h3>
		</div>
		<div class="modal-body" id="emailRejAttModalData">
		  <p>This will alert all attendees whose abstracts have been rejected.</p>
		  <p>
		  	<?php
		  		echo form_label("Subject:", "inputEmailRejSubject", array("class" => "control-label")); 
			  	echo form_input(array("name" => "inputEmailRejSubject", "id" => "inputEmailRejSubject", "class" => "", "placeholder" => "Email Subject"));
			  	echo form_label("Message:", "inputEmailRejMessage", array("class" => "control-label"));
		  		echo form_textarea(array("name" => "inputEmailRejMessage", "id" => "inputEmailRejMessage", "class" => "", "placeholder" => "Email Body"));
		  	?>
		  	
		  </p>
		</div>
		<div class="modal-footer">
		  <button id="send_rej_att_btn">Send Email</button>
		</div>
	</div>
	
	
	<!-- End Send Email to Attendees whose Abstracts have been rejected Modal -->
	
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
	<script>

	base_url = "<?php echo base_url(); ?>";


		jQuery.ajaxSetup({
			data: {
				 <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
			}
		});
	</script>
	<script src="<?php echo base_url().'js/app.js'; ?>"></script>
	<script src="<?php echo base_url().'js/jquery.dataTables.min.js'; ?>"></script>
</body>
</html>
