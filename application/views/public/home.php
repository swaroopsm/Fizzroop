<div id="content">

<?php $timerJSON = json_decode($timers,true);
//  print_r($timerJSON);


function daysto($when){
	$now = time(); // or your date as well
    $your_date = strtotime($when);
    $datediff = $your_date - $now;
    return floor($datediff/(60*60*24));
}



// function GetDays($sStartDate, $sEndDate){
//   // Firstly, format the provided dates.
//   // This function works best with YYYY-MM-DD
//   // but other date formats will work thanks
//   // to strtotime().
//   $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));
//   $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));

//   // Start the variable off with the start date
//   $aDays[] = $sStartDate;

//   // Set a 'temp' variable, sCurrentDate, with
//   // the start date - before beginning the loop
//   $sCurrentDate = $sStartDate;

//   // While the current date is less than the end date
//   while($sCurrentDate < $sEndDate){
//     // Add a day to the current date
//     $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

//     // Add this new day to the aDays array
//     $aDays[] = $sCurrentDate;
//   }

//   // Once the loop has finished, return the
//   // array of days.
//   return $aDays;
// }

// $sStartDate = date("Y-m-d");
?>

<div class="timer">
	<h1><?php echo daysto($timerJSON['timerDate1']); ?></h1>
	<h2><?php echo $timerJSON['timerTitle1']; ?></h2>
</div>
<div class="timer">
	<h1><?php echo daysto($timerJSON['timerDate2']); ?></h1>
	<h2><?php echo $timerJSON['timerTitle2']; ?></h2>
</div>
<div class="timer">
	<h1><?php echo daysto($timerJSON['timerDate3']); ?></h1>
	<h2><?php echo $timerJSON['timerTitle3']; ?></h2>
</div>
<div class="timer">
	<h1><?php echo daysto($timerJSON['timerDate4']); ?></h1>
	<h2><?php echo $timerJSON['timerTitle4']; ?></h2>
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