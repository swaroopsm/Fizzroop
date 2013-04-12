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
			$type = "P L E N A R Y";
		} elseif ($page['pageType'] == 3) {
			$type = "W O R K S H O P";
		} elseif ($page['pageType'] == 4) {
			$type = "S P E C I A L &nbsp S E S S I O N";
		} else {

		}
	?>

	<div class="item" style="background-image: url('<?php echo base_url(); ?>uploads/<?php echo $page["imagepath"]; ?>');">
	<br><br><br>
	<h1><a href="<?php echo base_url(); ?>viewpage/<?php echo $page['pageID']; ?>"><?php echo $page['pageTitle'] ?></a></h1>
	<br>
	<div class="plenary yellowback"><?php echo $type; ?> &rarr;</div><div class="speaker blueback"><?php echo $page['pageSubHeading'] ?></div>
	<br>
	<div class="plenary greenback">DATE: T.B.A. &nbsp; Max Participation : 30 students</div>
	</div>

	<?php
	}
}
?>

</div>