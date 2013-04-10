<div id="content">

	<div id="gals">

		<div id="gallery">
			<div class="galwrap1">
				
				<?php foreach ($plenaries as $plen) { ?>
					

				<div class="slide" style="background-image: url('<?php echo base_url(); ?>uploads/<?php echo $plen["imagepath"]; ?>')">
					<div class="slide_overlay plen"></div>
					<div class="slide_content">
						<div class="plenary greenback">P L E N A R Y &rarr;</div>
						<div class="speaker orangeback"><?php echo $plen['pageSubHeading']; ?></div>
						<br>
						<div class="plenary_title">
							<?php echo $plen['pageTitle']; ?>
						</div>
					</div>
				</div>
				
				<?php } ?>

				<div class="clear"></div>
			</div>
		</div> <!-- Gallery ends -->

		<div id="wshopgall">
			
			<div class="galwrap2">
				<?php foreach ($workshops as $plen) { ?>
				<div class="workslide" style="background-image: url('<?php echo base_url(); ?>uploads/<?php echo $plen["imagepath"]; ?>')">
					<div class="slide_overlay work"></div>
					<div class="slide_content">
						<div class="plenary yellowback">W O R K S H O P &rarr;</div>
						<div class="speaker blueback"><?php echo $plen['pageSubHeading']; ?></div>
						<br>
						<div class="plenary_title">
							<?php echo $plen['pageTitle']; ?>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>

	<div class="clear"></div>
	</div> <!-- #gals ends -->


	<div class="wrap">
		<?php // print_r($plenaries); ?>
	</div>
</div>

<div class="clear"></div>