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
	<body style="background-image: url('images/bigback.jpg');">
		<div class="menu-top">
				<div class="attlinks"><img src="images/logo.png" height="60" width="60" alt=""></div>
				<div class="attlinks">Hi <?php echo $attendeeFirstName." ".$attendeeLastName; ?>!
				<?php if ($submitted == 1) { ?>
						<a href="#" class="abview">View Abstract</a>
				<?php } else { ?>
						<a href="#" class="absubmit">Submit Abstract</a>
				<?php } ?>

				 
				<a href="#" class="absguide">Abstract Submission Guidelines</a> 
				<a href="#" class="workshops">Register for Workshops</a> 
				<a href="<?php echo base_url().'logout' ?>">Log out</a></div>
				<div class="clear"></div>
		</div>
		<div class="attcontainer">
			<?php
				if(count($a) > 0){
			?>
				<input id="inputAbstractID" value="<?php echo $a[0]['abstractID']; ?>" type="hidden">
			<?php
				}
				else{
					echo "<input type='hidden' value=''>";
				}
			?>
			
			<!-- This is the bursary section. Put this code wherever necessary. Assigned to @gonecase -->
			
			<!-- -->
			
			<?php 
				if ($submitted == 1) {
					$this->load->view("submitted");
				} else {
					$this->load->view("layouts/attendeeNavbar");
				}
			?>
		</div>

		<div class="guidelines">
			<h1>Abstract Guidelines</h1>
			<p><strong>Your abstract should be organized in the following four sections, each with its own sub-heading:</strong><br>
			<ol>
				<li>What conservation problem or question does your talk address?</li>
				<li>What were the main research methods you used?</li>
				<li>What are your most important results?</li>
				<li>What is the relevance of your results to conservation?</li>
			</ol>
			</p>
			<h2>What is expected in each of these sections?</h2>
			<p>This is explained below with reference to a fictional abstract.</p>
			<div class="sample">
				<h3>A survey of skink diversity in Mouling National Park, Arunachal Pradesh</h3>
				<p>Abhijit Kumar1, Savitha Gupta1 and Shiva Rajah2. 1Himalaya Univ., Arunachal Pradesh and 2Univ. Cambridge, U.K. Email: sgupta@fakemail.com</p>
				<p><strong>What conservation problem or question does your talk address?</strong></p>
				<p>The herpetological diversity of India is poorly studied, particularly in the far north-east. In this study we surveyed, for the first time, the diversity of ground-dwelling skink species in the forests of Mouling National Park in the north-eastern state of Arunachal Pradesh.</p>
				<p><strong>What were the main research methods you used?</strong></p>
				<p>Using quadrats and pit-fall traps, we surveyed the number of skink species in the three altitudinal ranges of the park (low: 750 m-1500 m; mid: 1501 m-2250 m; high: 2251 m-3000 m), over a two-month period (June-July) at the peak of the summer season. The number of quadrats and traps used in each area was double that indicated as sufficient by a species accumulation curve developed during a pilot study.</p>
				<p><strong>What are your most important results?</strong></p>
				<p>The numbers of species found in the three zones were: low-altitude: 3; mid-altitude: 8; high-altitude: 5. Interestingly, while the high-altitude zone had lower diversity, the phylogenetic spread of its species was the highest, and included a new species, tentatively named <em>Eurylepis ngarba</em>.</p>
				<p><strong>What is the relevance of your results to conservation?</strong></p>
				<p>We consider that our results accurately estimate the true skink diversity of Mouling National Park because (1) the survey was thorough with respect to areas sampled; (2) more intensive surveys in two nearby (and similar) parks have shown that (a) all skink species in those parks are highly active at the peak of the summer season and (b) all skink species in those parks are non-cryptic. In this study, the number of species at low altitude was unexpectedly low, a likely result of increased human disturbance in this park, compared to nearby parks. We recommend a local education program to reduce the impact of shifting cultivation on skinks and other threatened species of the lower slopes of this valuable park.</p>
			</div>
			<h2>Guidelines for writing each section of abstract</h2>
			<p><strong>What conservation problem or question does your talk address?</strong></p>
			<p>In this section you are expected to provide the general conservation context for your study, and to indicate your research question.  In the sample abstract above, the context is provided by the first sentence: "The herpetological diversity of India is poorly studied, particularly in the far north-east." We might consider this the study’s "Big Question", and like most such questions, it is interesting but rather intractable. Your Research Question will be more specific and must be, largely, tractable. In the sample abstract, the Research Question is suggested, rather than stated directly: "What is the diversity of ground-dwelling skink species in the forests of Mouling National Park, Arunachal Pradesh?"  The Research Question is the pivotal question of any research report. If you are in doubt as to which of the questions addressed in your study is the Research Question, the clarification is simple: the Research Question is the question that the title of the paper answers (or promises to answer). The specific objectives you addressed to answer the research question should be presented in the next section. </p>
			<p><strong>What were the main research methods you used?</strong></p>
			<p>The Methodology describes the specific things you have done to acquire and analyse your data. In this section do not over-elaborate on the Methods that you have employed. The focus should be on the objectives – the Methods are a means to an end. Note how, in the sample abstract, the objectives still remain the main focus in this sentence: "Using quadrats and pit-fall traps, we surveyed the number of skink species in the three altitudinal ranges of the park (low: 750m-1500m; mid:1501m-2250; high: 2251m-3000m), over a two-month period (June-July) at the peak of the rainy season.". If you have multiple objectives, the methods used for each should be clearly mentioned.   .</p>
			<p><strong>What are your most important results?</strong></p>
			<p>The Results provide the answers to the questions represented by the Objectives. Few scientists have trouble understanding the nature of their results. However, many fill their abstracts with unimportant details, at the expense of what is much more important: discussing the most significant results. In the sample abstract, the main answers are, with respect to species caught in June-July: "low-altitude zone: 3 skink species; mid-altitude zone: 8 skink species; high-altitude zone: 5 skink species".</p>
			<p><strong>What is the relevance of your results to conservation?</strong></p>
			<p>The discussion component must firstly, and compulsorily, tell the readers the answer/s to the Research Question (not the objectives). In the sample abstract, the discussion starts with an extensive argument that the answers to the main Research Question can be obtained directly from the Results, i.e. the answers to the Objectives and the Research Question are, in this particular case, the same or similar. After having discussed the believability of your proposed answers to the Research Question, you should then discuss the implications of your findings for conservation. For example, in the sample abstract: "In this study, the number of species at low altitude was unexpectedly low, a likely result of increased human disturbance in this park, compared to nearby parks. We recommend a local education program to reduce the impact of shifting cultivation on skinks and other threatened species of the lower slopes of this valuable park."</p>
			


			<h2>Graphical Abstract Guidelines</h2>
			<p><strong>Examples of graphical abstracts:</strong>
				<a href="<?php echo base_url(); ?>/images/graph1.jpg" target="_blank">Example 1</a>
				<a href="<?php echo base_url(); ?>/images/graph2.jpg" target="_blank">Example 2</a>
				<a href="<?php echo base_url(); ?>/images/graph3.jpg" target="_blank">Example 3</a>
				<a href="<?php echo base_url(); ?>/images/graph4.jpg" target="_blank">Example 4</a>
				<a href="<?php echo base_url(); ?>/images/graph5.jpg" target="_blank">Example 5</a>
				<a href="<?php echo base_url(); ?>/images/graph6.jpg" target="_blank">Example 6</a>
			</p>
			<p>In addition to the textual abstract described above, participants also need to submit a graphical abstract.  A graphical abstract is a single illustration that captures the main findings of a study. This could be either in the form of a graph or a table illustrating the main result,  a visual that depicts a summary of the study, or a flow diagram outlining a conservation problem and the science-based conservation intervention and outcome, based on which the abstract is being submitted. The graphical abstract should be self-explanatory with all the relevant information including appropriate data labels, axis titles, as well as a figure legend which should include the title of the presentation and the author's name.  Please see the examples provided to help you make your own graphical abstract.</p>
			<p>Graphical abstracts need to be uploaded as a single image file (formats allowed include jpeg, tiff, and pdf) in addition to the textual abstract during the submission process. The easiest way to make your graphical abstract is to compose it on a single MS Powerpoint slide (as done in the examples)  and then save that slide as an image file (formats allowed include jpeg, tiff, and pdf) to submit. Participants are however free to use any method/software to make their graphical abstract as long as the final submitted file is one of the formats prescribed.  Before submitting, make sure that the graphical abstract is of adequate resolution to be easily readable.</p>
			<p>Please remember that the purpose of the graphical abstract is to highlight the data that you plan to present and clearly convey your main findings. Therefore graphical abstracts will only be judged according to the clarity of the message conveyed and not by their visual appeal.</p>
			<p>Submission of both graphical and text abstracts is compulsory.  The graphical and textual abstracts, in combination, should clearly communicate the following to the reviewers i. the time period over which the study was conducted; ii. types of data that were collected and iii. the sample size (N). The reviewers will be using these as key parameters while evaluating the abstracts for selection for a talk or a poster to be presented in SCCS-Bangalore 2013."</p>
			
			<p><em>The content on this page is a slightly modified version of guidelines prepared by Dr. Geoff Hyde, with assistance from Nandini Velho.</em></p>

		</div>

		<div class="workshop">
			<h2>Workshops</h2>
			<p>No workshops have been finalised yet. Come back later and check it out.</p>
		</div>

		<br><br><br><br><br><br><br><br><br>
		<script src="<?php echo base_url().'js/jquery.js'; ?>"></script>
		<script src="<?php echo base_url().'js/jquery.form.js'; ?>"></script>
		<script>
		var name = '<?php echo $attendeeFirstName." ".$attendeeLastName; ?>';
		base_url = "<?php echo base_url(); ?>";
		token =['<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>']


			jQuery.ajaxSetup({
				data: {
					 <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				}
			});

		(function($) {
    $.fn.extend( {
        limiter: function(limit, elem) {
            $(this).on("keyup focus", function() {
                setCount(this, elem);
            });
            function setCount(src, elem) {
                var chars = src.value.length;
                if (chars > limit) {
                    src.value = src.value.substr(0, limit);
                    chars = limit;
                }
                elem.html(limit - chars );
            }
            setCount($(this)[0], elem);
        }
    });
})(jQuery);

		var elem1 = $("#chartitle");
		var elem2 = $("#charmeth");
		var elem3 = $("#charaim");
		var elem4 = $("#charcons");
		var elem5 = $("#charres");
		$("#inputAbstractTitle").limiter(120, elem1);
		$("#inputAbstractMethods").limiter(400, elem2);
		$("#inputAbstractAim").limiter(400, elem3);
		$("#inputAbstractConservation").limiter(400, elem4);
		$("#inputAbstractResults").limiter(400, elem5);
		</script>
		<script src="<?php echo base_url().'js/vendor.js'; ?>"></script>
		<script src="<?php echo base_url().'js/attendee.js'; ?>"></script>
	</body>
</html>
