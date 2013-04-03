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
				<!-- <a href="<?php echo base_url().'attendee'; ?>">Dashboard</a> |  --><a href="#" class="absubmit">Submit Abstract</a> <a href="#" class="absguide">Abstract Submission Guidelines</a> <a href="#" class="workshops">Workshops</a> <a href="#" class="burse">Bursaries</a> <a href="<?php echo base_url().'logout' ?>">Log out</a></div>
				<div class="clear"></div>
		</div>
		<div class="attcontainer">
			<div class="message"><p>Hi <?php echo $attendeeFirstName." ".$attendeeLastName; ?>!</p>
				<p>This page is where you can <a href="#" class="absubmit"> submit your abstract</a> and sign up for <a href="#" class="workshops">workshops</a> for SCCS. Make sure you <a href="#" class="absguide">read the abstract submission guidelines</a> before you submit. Once submitted, you cannot change your abstract, so please be sure of it.</p></div>
			<div class="submitabstractform">
				<h2>Submit Abstract</h2>
				<p>Be sure you <a href="#" class="absguide">read the abstract submission guidelines</a> first!</p>
				<?php
					echo form_open("reviewer/create", array("class" => "form form-horizontal", "id" => "new_reviewer", "style" => "margin-left: 0px;"));
					echo form_label("Abstract Title:", "abstractTitle", array("class" => "control-label")); 
					echo form_input(array("name" => "abstractTitle", "id" => "abstractTitle", "class" => "", "placeholder" => "Your Abstract's Title goes here"));
				?>
				
				<?php
					echo form_label("Methods:", "abstractMethods", array("class" => "control-label")); 
					echo form_textarea(array("name" => "abstractMethods", "id" => "abstractMethods", "class" => "", "placeholder" => "What methods did you use for your abstract?"));
					echo form_label("Aim:", "abstractAim", array("class" => "control-label")); 
					echo form_textarea(array("name" => "abstractAim", "id" => "abstractAim", "class" => "", "placeholder" => "What aims have you set up?"));
					echo form_label("Conservation:", "abstractConservation", array("class" => "control-label")); 
					echo form_textarea(array("name" => "abstractConservation", "id" => "abstractConservation", "class" => "", "placeholder" => "What methods did you use for your abstract?"));
					echo form_label("Results:", "abstractResults", array("class" => "control-label")); 
					echo form_textarea(array("name" => "abstractResults", "id" => "abstractResults", "class" => "", "placeholder" => "What aims have you set up?"));
				?>
				
				<p>Upload your graphical abstract. <em>Your image must be of this specified size and this thing.</em></p>
				<?php
					echo form_upload('uploadGraphic');
				?>
				<p>Choose your preference.</p>
				<?php echo form_radio(array('name'=>'pref', 'id'=>'talk', 'value'=>'1', 'class'=>'radio')); ?>Talk
				<?php echo form_radio(array('name'=>'pref', 'id'=>'poster', 'value'=>'2','class'=>'radio')); ?>Poster
				<?php echo form_radio(array('name'=>'pref', 'id'=>'noPref', 'value'=>'3','class'=>'radio')); ?>No Preference
				<input class="subButton" type="submit" value="Submit Abstract"/>
				<?php echo form_close(); ?>
			</div>
		</div>

		<div class="guidelines">
			<h2>Graphical Abstract Guidelines</h2>
			<p>This year, we require participants to include a graphical abstract in addition to the conventional textual abstract.  A graphical abstract is a SINGLE illustration that captures the main findings of a study. This could be either in the form of a graph or a table illustrating the main result,  a visual that depicts a summary of the study, or a flow diagram outlining a conservation problem and the science-based conservation intervention and outcome, based on which the abstract is being submitted. The graphical abstract should be self-explanatory with all the relevant information including appropriate data labels, axis titles, as well as a figure legend which should include the title of the presentation and the author's name.  Please see the examples provided to help you make your own graphical abstract.</p>
			<p>Graphical abstracts need to be uploaded as a SINGLE image file (formats allowed include jpeg, tiff, and pdf) in addition to the textual abstract during the submission process. The easiest way to make your graphical abstract is to compose it on a single MS Powerpoint slide (as done in the examples)  and then save that slide as an image file (formats allowed include jpeg, tiff, and pdf) to submit. Participants are however free to use any method/software to make their graphical abstract as long as the final submitted file is one of the formats prescribed.  Before submitting, make sure that the graphical abstract is of adequate resolution to be easily readable.</p>
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
		<script src="<?php echo base_url().'js/att.js'; ?>"></script>
	</body>
</html>
