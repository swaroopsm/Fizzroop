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
				<h2>Current Conference</h2>
				<p>400 Registered | 10 Reviewers | 12 JUN - 15 JUN | 2012</p>
				<p><a href="#">Manage this conference</a></p>

				<h2>FRONTEND PAGES</h2>
				<p>Manage the pages and content accross the public site</p>
				<p><a href="#">Manage Pages</a></p>

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
				<p><a href="#" id="manageAttendees">Manage Attendees</a> | <a href="#">Add Attendee</a></p>
			</div>

			<div class="col">
				<h2>Archived Conferences</h2>
				<p>3 archived Conferences</p>
				<p>Manage:<a href="#">2012</a> | <a href="#">2011</a> | <a href="#">2010</a></p>

				<h2>Create New Conference</h2>
				<p><a href="#">Create new conference</a></p>
				<p>This will wipe certain records in the database. <br>Proceed with caution.</p>
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
	<script src="<?php echo base_url().'js/app.js'; ?>"></script>
	<script src="<?php echo base_url().'js/jquery.dataTables.min.js'; ?>"></script>
</body>
</html>
