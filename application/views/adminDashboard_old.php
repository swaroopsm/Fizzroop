<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_title; ?></title>
		<?php $this->load->view("layouts/header"); ?>
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
					<?php echo form_open("conference/create", array("class" => "form form-horizontal", "id" => "newConf", "style" => "margin-left: 0px;")); ?>
							<?php echo form_fieldset("Create Conference"); ?>
							<?php echo form_fieldset_close(); ?>
							<div id="js-messages" style="text-align: center;display: none;"></div>
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
										<?php echo form_input(array("name" => "inputStartDate", "id" => "inputStartDate", "class" => "span4", "placeholder" => "YYYY/MM/DD")); ?>
									</div>
								</div>
								<div class="control-group">
									<?php echo form_label("End Date: ", "inputEndDate", array("class" => "control-label")); ?>
									<div class="controls">
										<?php echo form_input(array("name" => "inputEndDate", "id" => "inputEndDate", "class" => "span4", "placeholder" => "YYYY/MM/DD")); ?>
									</div>
								</div>
								<div class="control-group">
									<div class="controls" style="text-align: center;">
										<?php echo form_submit(array("class" => "btn btn-success", "value" => "Create Conference\xBB")); ?>
										&nbsp;<div id="loader"></div>
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
		<script src="<?php echo base_url().'js/app.js'; ?>"></script>
		<script>
			$("form#newConf").submit(function(){
					var stat = $(this).validateFormEmpty();
					if(stat.success){
						$(this).asyncSubmit({
							'target': '#js-messages',
							'loadTarget': '#loader',
							'loader': '<br><img src="<?php echo base_url()."images/loader.gif"; ?>">',
							'successMsg': 'Conference added successfully!',
							'errorMsg': 'There was an error, please try again later!'
						});
					}else{
						$("#js-messages").html("<span class='span6 alert alert-danger'><a class='close' data-dismiss='alert' href='#'>&times;</a>"+stat.errorMsg+"</span>").hide().fadeIn(500);
					}
					return false;
				});
		</script>
	</body>
</html>
