<div id="content">

<?php $timerJSON = json_decode($timers,true);
//  print_r($timerJSON);


function daysto($when){
	$now = time(); // or your date as well
    $your_date = strtotime($when);
    $datediff = $your_date - $now;
    return floor($datediff/(60*60*24));
}

?>

<div class="timer">
	<p><?php echo $timerJSON['timerTitle1']; ?></p>
	<?php 
		$date1 = strtotime($timerJSON['timerDate1']);
	?>
	<div class="timermonth"><?php echo date('M',$date1); ?></div>
	<div class="timerdate"><?php echo date('d',$date1); ?><br>
		<div class="timeryear">2013</div></div>
	<p><?php echo daysto($timerJSON['timerDate1']); ?> days to go.</p>
</div>
<div class="timer">
	<p><?php echo $timerJSON['timerTitle2']; ?></p>
	<?php 
		$date2 = strtotime($timerJSON['timerDate2']);
	?>
	<div class="timermonth"><?php echo date('M',$date2); ?></div>
	<div class="timerdate"><?php echo date('d',$date2); ?><br>
		<div class="timeryear">2013</div></div>
	<p><?php echo daysto($timerJSON['timerDate2']); ?> days to go.</p>

</div>
<div class="timer">
	<p><?php echo $timerJSON['timerTitle3']; ?></p>
	<?php 
		$date3 = strtotime($timerJSON['timerDate3']);
	?>
	<div class="timermonth"><?php echo date('M',$date3); ?></div>
	<div class="timerdate"><?php echo date('d',$date3); ?><br>
		<div class="timeryear">2013</div></div>
	<p><?php echo daysto($timerJSON['timerDate3']); ?> days to go.</p>

</div>
<div class="timer">
	<p><?php echo $timerJSON['timerTitle4']; ?></p>
	<?php 
		$date4 = strtotime($timerJSON['timerDate4']);
	?>
	<div class="timermonth"><?php echo date('M',$date4); ?></div>
	<div class="timerdate"><?php echo date('d',$date4); ?><br>
		<div class="timeryear">2013</div></div>
	<p><?php echo daysto($timerJSON['timerDate4']); ?> days to go.</p>

</div>




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

	<div id="sponsorsandpartners">


		<!-- <div id="sponsors">
			<h2>Sponsors</h2>
			<p>Sponsor logos here</p>
		</div> -->

		<div id="organisingcomittee">
			<h2>Organising Institutions</h2>
			<div class="s"><img src="<?php echo base_url(); ?>images/sponsors/iisc.jpg" alt=""></div>
			<div class="s"><img src="<?php echo base_url(); ?>images/sponsors/mcbt.jpg" alt=""></div>
			<div class="s"><img src="<?php echo base_url(); ?>images/sponsors/ncbs.jpg" alt=""></div>
			<div class="l"><img src="<?php echo base_url(); ?>images/sponsors/ncf.jpg" alt=""></div>
			<div class="s"><img src="<?php echo base_url(); ?>images/sponsors/sacon.jpg" alt=""></div>

		</div>
	</div>