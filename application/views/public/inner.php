<div id="content">
	

<?php


if (empty($listofpages)) {

	print("no pages found");
} else {

	// print_r($listofpages);

	foreach ($listofpages as $page) {
		if ($page['pageType'] == 1) {
			$type = "";
		} elseif ($page['pageType'] == 2) {
			$type = "Plenaries";
			?>
			<div class="item" style="background-image: url('<?php echo base_url(); ?>uploads/<?php echo $page["imagepath"]; ?>');">
			<br>
			<div class="speaker" style="background-color: #F99C1C; font-size: 150%; font-weight:900;"><?php echo $page['pageSubHeading'] ?></div>
			<br><br>
			<h1><a href="<?php echo base_url(); ?>viewpage/<?php echo $page['pageID']; ?>" style="font-size: 80%;"><?php echo $page['pageTitle'] ?></a></h1>
			<br>
			<!-- <div class="plenary yellowback"><?php echo $type; ?> &rarr;</div> -->
			
			<!-- <div class="plenary greenback">DATE: T.B.A. &nbsp; Max Participation : 30 students</div> -->
			</div>
			<?php
		} elseif ($page['pageType'] == 3) {
			$type = "Workshops";
			?>
			<div class="item" style="background-image: url('<?php echo base_url(); ?>uploads/<?php echo $page["imagepath"]; ?>');">
			<br>
			<h1><a href="<?php echo base_url(); ?>viewpage/<?php echo $page['pageID']; ?>"><?php echo $page['pageTitle'] ?></a></h1>
			<br>
			<!-- <div class="plenary yellowback"><?php echo $type; ?> &rarr;</div> -->
			<div class="speaker" style="background-color: #F99C1C; font-size: 120%;"><?php echo $page['pageSubHeading'] ?></div>
			<br>
			<!-- <div class="plenary greenback">DATE: T.B.A. &nbsp; Max Participation : 30 students</div> -->
			</div>
			<?php
		} elseif ($page['pageType'] == 4) {
			$type = "Special Sessions";
		} else {

		}
	?>

	

	<?php
	}
}
?>
<?php if(isset($type)){ ?>
<div class="item yellowback">
	<h1>MORE <?php echo $type; ?> will be announced in the coming weeks.</h1>
</div>
<?php } ?>
<div class="clear"></div>

</div>