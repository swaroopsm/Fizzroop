<div id="content">
<div class="plenary yellowback">
<?php
if ($singlepage['pageType'] == 3) {
	echo "W O R K S H O P S";
} elseif ($singlepage['pageType'] == 2) {
	echo "P L E N A R Y";
}
?>
</div>

<h1><?php echo $singlepage['pageTitle']; ?></h1>
<div class="full" style="background-image: url('<?php echo base_url(); ?>/uploads/<?php print_r($imagepath["image"]); ?>');"></div>

<?php echo $singlepage['pageContent']; ?>

<?php 

// print_r($singlepage);

// print_r($imagepath['image']);

?>


</div>