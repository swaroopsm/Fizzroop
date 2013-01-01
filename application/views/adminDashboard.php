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
				<p><a href="#">Manage Reviewers</a> | <a href="#">Add reviewer</a></p>

				<h2>Attendees</h2>
				<p>400 Registered Attendees</p>
				<p><a href="#">Manage Attendees</a> | <a href="#">Add Attendee</a></p>
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
			
			<div id="ajaxer">
				<div  id="loader" class="loader"><img src="images/loader.gif"></img></div>
			</div>
			
		</div>
	</div>


	
	<script src="<?php echo base_url().'js/jquery.js'; ?>"></script>
	<script src="<?php echo base_url().'js/app.js'; ?>"></script>
	<script src="<?php echo base_url().'js/jquery.dataTables.min.js'; ?>"></script>
</body>
</html>
