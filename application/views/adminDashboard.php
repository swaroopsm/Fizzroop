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
	<body>
		<?php $this->load->view("layouts/adminNavbar"); ?>
		<div class="container">
			<div class="span12">
				<div class="span7 well adminFirstDiv">
					<?php echo form_open("conference/new", array("class" => "form form-horizontal", "id" => "newConf", "style" => "margin-left: 0px;")); ?>
							<?php echo form_fieldset("Create Conference"); ?>
							<?php echo form_fieldset_close(); ?>
								<div class="control-group">
									<?php echo form_label("Year: ", "inputYear", array("class" => "control-label")); ?>
									<div class="controls">
										<?php echo form_input(array("name" => "inputYear", "id" => "inputYear", "class" => "span4", "placeholder" => "Which Year?")); ?>
									</div>
								</div>
								<div class="control-group">
									<?php echo form_label("Venue: ", "inputVenue", array("class" => "control-label")); ?>
									<div class="controls">
										<?php echo form_input(array("name" => "inputVenue", "id" => "inputVenue", "class" => "span4", "placeholder" => "Where is it going to be held?")); ?>
									</div>
								</div>
								<div class="control-group">
									<?php echo form_label("Start Date: ", "inputStartDate", array("class" => "control-label")); ?>
									<div class="controls">
										<?php echo form_input(array("name" => "inputStartDate", "id" => "inputStartDate", "class" => "span4", "placeholder" => "DD/MM/YYYY")); ?>
									</div>
								</div>
								<div class="control-group">
									<?php echo form_label("End Date: ", "inputEndDate", array("class" => "control-label")); ?>
									<div class="controls">
										<?php echo form_input(array("name" => "inputEndDate", "id" => "inputEndDate", "class" => "span4", "placeholder" => "DD/MM/YYYY")); ?>
									</div>
								</div>
								<div class="control-group">
									<div class="controls" style="text-align: center;">
										<?php echo form_submit(array("class" => "btn btn-success", "value" => "Create Conference\xBB")); ?>
									</div>
								</div>
					<?php echo form_close(); ?>
				</div>
				<div class="span3 well pull-right adminSecondDiv">
					<legend>History</legend>
				</div>
			</div>
		</div>
		<script src="<?php echo base_url().'js/jquery.js'; ?>"></script>
		<script src="<?php echo base_url().'js/vendor.js'; ?>"></script>
	</body>
</html>
