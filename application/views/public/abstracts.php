<div id="content">
	

<?php

if (empty($allabstracts)) {

	print("no abstracts have been approved yet.");

} else {

	// print_r($listofpages);

	// foreach ($listofpages as $page) {
	// 	if ($page['pageType'] == 1) {
	// 		$type = "";
	// 	} elseif ($page['pageType'] == 2) {
	// 		$type = "P L E N A R Y";
	// 	} elseif ($page['pageType'] == 3) {
	// 		$type = "W O R K S H O P";
	// 	} elseif ($page['pageType'] == 4) {
	// 		$type = "S P E C I A L &nbsp S E S S I O N";
	// 	} else {

	// 	}
	?>

	<?php
	print_r($allabstracts);
	?>

	<?php
	}

?>

</div>