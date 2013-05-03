<div id="content">
<?php
if ($singlepage['pageType'] == 3) {
	echo '<div class="plenary yellowback">';
	echo "W O R K S H O P S";
	echo '</div>';
} elseif ($singlepage['pageType'] == 2) {
	echo '<div class="plenary yellowback">';
	echo "P L E N A R Y";
	echo '</div>';
}
?>



<h1><?php echo $singlepage['pageTitle']; ?></h1>
<?php
	if (array_key_exists('images', $imagepath)){ ?>
		<div class="full" style="background-image: url('<?php echo base_url(); ?>/uploads/<?php print_r($imagepath["image"]); ?>');"></div>
<?php	} else {
		
	}
?>

<div class="pageview">
<?php echo $singlepage['pageContent']; ?>

<?php 

// print_r($singlepage);

// print_r($imagepath['image']);

?>
</div>

</div>
