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
	<body style="background-image: url('images/bigback.jpg');">
		<div class="menu-top">
				<div class="attlinks"><img src="images/logo.png" height="60" width="60" alt=""></div>
				<div class="attlinks">Hi <?php echo $attendeeFirstName." ".$attendeeLastName; ?>!
				<?php if ($submitted == 1) { ?>
						<a href="#" class="abview">View Abstract</a>
				<?php } else { ?>
						<a href="#" class="absubmit">Submit Abstract</a>
				<?php } ?>

				 
				<a href="#" class="absguide">Abstract Submission Guidelines</a> 
				<a href="#" class="workshops">Workshops</a> 
				<a href="#" class="burse">Bursaries</a> 
				<a href="<?php echo base_url().'logout' ?>">Log out</a></div>
				<div class="clear"></div>
		</div>
		<div class="attcontainer">
			<?php 
				if ($submitted == 1) {
					$this->load->view("submitted");
				} else {
					$this->load->view("layouts/attendeeNavbar");
				}
			?>
		</div>

		<div class="guidelines">
			<h2>Graphical Abstract Guidelines</h2>
			<p>This year, we require participants to include a graphical abstract in addition to the conventional textual abstract.  A graphical abstract is a SINGLE illustration that captures the main findings of a study. This could be either in the form of a graph or a table illustrating the main result,  a visual that depicts a summary of the study, or a flow diagram outlining a conservation problem and the science-based conservation intervention and outcome, based on which the abstract is being submitted. The graphical abstract should be self-explanatory with all the relevant information including appropriate data labels, axis titles, as well as a figure legend which should include the title of the presentation and the author's name.  Please see the examples provided to help you make your own graphical abstract.</p>
			<p>Graphical abstracts need to be uploaded as a SINGLE image file (formats allowed include jpeg, tiff, and pdf) in addition to the textual abstract during the submission process. The easiest way to make your graphical abstract is to compose it on a single MS Powerpoint slide (as done in the examples)  and then save that slide as an image file (formats allowed include jpeg, tiff, and pdf) to submit. Participants are however free to use any method/software to make their graphical abstract as long as the final submitted file is one of the formats prescribed.  Before submitting, make sure that the graphical abstract is of adequate resolution to be easily readable.</p>
			<p>Please remember that the purpose of the graphical abstract is to highlight the data that you plan to present and  clearly convey your main findings. Therefore graphical abstracts will only be judged according to the clarity of the message conveyed and not by their visual appeal.</p>
			<p>SUBMISSION OF BOTH GRAPHICAL AND TEXT ABSTRACTS IS COMPULSORY.  The graphical and textual abstracts, in combination, should clearly communicate the following to the reviewers i. the time period over which the study was conducted; ii. types of data that were collected and iii. the sample size (N). The reviewers will be using these as key parameters while evaluating the abstracts for selection for a talk or a poster to be presented in SCCS-Bangalore 2013.</p>
		</div>

		<div class="workshop">
			<h2>Workshops</h2>
			<p>No workshops have been finalised yet. Come back later and check it out.</p>
		</div>


		<br><br><br><br><br><br><br><br><br>
		<script src="<?php echo base_url().'js/jquery.js'; ?>"></script>
		<script src="<?php echo base_url().'js/jquery.form.js'; ?>"></script>
		<script>
		var name = '<?php echo $attendeeFirstName." ".$attendeeLastName; ?>';
		base_url = "<?php echo base_url(); ?>";
		token =['<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>']


			jQuery.ajaxSetup({
				data: {
					 <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				}
			});
		</script>
		<script src="<?php echo base_url().'js/vendor.js'; ?>"></script>
		<script src="<?php echo base_url().'js/attendee.js'; ?>"></script>
	</body>
</html>
