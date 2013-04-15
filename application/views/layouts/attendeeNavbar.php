<div class="message">
  <p>Hi <?php echo $attendeeFirstName." ".$attendeeLastName; ?>!</p>
        <p>This page is where you can <a href="#" class="absubmit"> submit your abstract</a> and sign up for <a href="#" class="workshops">workshops</a> for SCCS-2013. Make sure you <a href="#" class="absguide">read the abstract submission guidelines</a> before you submit. Once submitted, you cannot change your abstract."</p>
      </div>
      <div class="submitabstractform">
        <h2>Submit Abstract</h2>
        <p>Be sure you <a href="#" class="absguide">read the abstract submission guidelines</a> first!</p>
        <?php
          echo form_open("abstract/create", array("class" => "form form-horizontal", "id" => "new_abstract", "style" => "margin-left: 0px;"));
          echo form_label("Abstract Title:", "inputAbstractTitle", array("class" => "control-label")); 
          echo form_input(array("name" => "inputAbstractTitle", "id" => "inputAbstractTitle", "class" => "", "placeholder" => "Your Abstract's Title goes here"));
          echo "<div class='counters' id='chartitle'></div>";
        ?>
        
        <?php

          echo form_label("What conservation problem or question does your talk/poster address?", "inputAbstractAim", array("class" => "control-label")); 
          echo form_textarea(array("name" => "inputAbstractAim", "id" => "inputAbstractAim", "class" => "", "placeholder" => "What conservation problem or question does your talk/poster address?"));
          echo "<div class='counters' id='charaim'></div>";

          echo form_label("What were the main research methods you used?", "inputAbstractMethods", array("class" => "control-label")); 
          echo form_textarea(array("name" => "inputAbstractMethods", "id" => "inputAbstractMethods", "class" => "", "placeholder" => "What were the main research methods you used?"));
          echo "<div class='counters' id='charmeth'></div>";
          
          echo form_label("What are your most important results?", "inputAbstractResults", array("class" => "control-label")); 
          echo form_textarea(array("name" => "inputAbstractResults", "id" => "inputAbstractResults", "class" => "", "placeholder" => "What are your most important results?"));
          echo "<div class='counters' id='charres'></div>";

          echo form_label("What is the relevance of your results to conservation?", "inputAbstractConservation", array("class" => "control-label")); 
          echo form_textarea(array("name" => "inputAbstractConservation", "id" => "inputAbstractConservation", "class" => "", "placeholder" => "What is the relevance of your results to conservation?"));
          echo "<div class='counters' id='charcons'></div>";
          
        ?>
        
        <p>Upload your graphical abstract. <em>Your image must be of this specified size and this thing.</em></p>
        <?php
          echo form_upload(array("name" => "inputAbstractImage", "onchange"=>"readURL(this);"));
        ?>
        <p>Choose your preference.</p>
        <?php echo form_radio(array('name'=>'pref', 'id'=>'talk', 'value'=>'1', 'class'=>'radio')); ?>Talk
        <?php echo form_radio(array('name'=>'pref', 'id'=>'poster', 'value'=>'2','class'=>'radio')); ?>Poster
        <?php echo form_radio(array('name'=>'pref', 'id'=>'noPref', 'value'=>'3','class'=>'radio')); ?>No Preference
        <br>
        <p>Need Bursary?</p>
        <?php echo form_radio(array('name'=>'bursary_pref', 'id' => 'bursary_yes', 'value'=>'1', 'class'=>'radio')); ?>Yes
        <?php echo form_radio(array('name'=>'bursary_pref', 'id' => 'bursary_no', 'value'=>'0','class'=>'radio')); ?>No
        <br>
        <div class="bursaries" id="bursaries">
        	<?php // echo form_input(array("id" => "inputBursary_For", "name" => "inputBursary_For", "placeholder" => "bursary for")) ?>
          <p>If yes, please us the space below to provide a justification for why you should receive a bursary</p>
        	<?php echo form_input(array("id" => "inputBursary_Why", "name" => "inputBursary_Why", "placeholder" => "Why do you want a bursary?")) ?>
          <p>Would you like SCCS-2013 to arrange accommodation for you during the conference (September 24th-29th)?</p>
          <?php echo form_radio(array('name'=>'inputBursary_For', 'id'=>'full', 'value'=>'Travel+Accommodation','class'=>'radio')); ?>Yes
          <?php echo form_radio(array('name'=>'inputBursary_For', 'id'=>'travel', 'value'=>'Travel', 'class'=>'radio')); ?>No
				</div>
        <input class="subButton" type="submit" value="Submit Abstract"/> <div class="preview">PREVIEW ABSTRACT</div>
        <?php echo form_close(); ?>
      </div>

      <div class="previewspace">
        <div class="title">You are previewing: </div>
        <div class="close">x</div>
        <img id="img_prev" src="#" alt="your image" />
      </div>
