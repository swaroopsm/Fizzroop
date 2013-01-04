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
				<p>300 submitted | 0 approved | 10 reviewers | 140 have comments</p>
				<p><a href="#" id="manageAbstracts">Manage Abstracts</a></p>

				<h2>Reviewers</h2>
				<p>10 reviewers | 140 reviews commented | 160 recommended</p>
				<p><a href="#" id="manageReviewers">Manage Reviewers</a> | <a href="#">Add reviewer</a></p>

				<h2>Attendees</h2>
				<p>400 Registered Attendees</p>
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
		</div>
		<div class="modal-body" id="abstractData">
		  <p>One fine body…</p>
		</div>
		<div class="modal-footer">
		  <button class="btn btn-primary">Save changes</button>
		</div>
	</div>
	
	<!-- End Abstract Modal -->
	
	<!-- Reviewer Modal -->
	
	<div id="reviewersModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="reviewersModalLabel" aria-hidden="true"  style="display: none;">
		<div class="modal-header">
		  <a class="close" data-dismiss="modal" aria-hidden="true" href="#">&times;</a>
		  <h3 id="reviewersModalLabel"></h3>
		</div>
		<div class="modal-body" id="reviewersData">
		  <p></p>
		</div>
		<div class="modal-footer">
		  <button class="btn btn-primary">Save changes</button>
		</div>
	</div>
	
	<!-- End Reviewer Modal -->

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
