<div class="message">
  <p>Hi <?php echo $attendeeFirstName." ".$attendeeLastName; ?>!</p>
        <p>This page is where you can <a href="#" class="absubmit"> submit your abstract</a> and sign up for <a href="#" class="workshops">workshops</a> for SCCS-2013. Make sure you <a href="#" class="absguide">read the abstract submission guidelines</a> before you submit. Once submitted, you cannot change your abstract.</p>
      </div>
      <div class="submitabstractform">
        <h2>Submit Abstract</h2>
        <p>Be sure you <a href="#" class="absguide">read the abstract submission guidelines</a> first!</p>
        <?php
          echo form_open("abstract/create", array("class" => "form form-horizontal", "id" => "new_abstract", "data-validate"=>"parsley", "style" => "margin-left: 0px;"));
          echo form_label("Abstract Title (max 120 characters):", "inputAbstractTitle", array("class" => "control-label")); 
          echo form_input(array("name" => "inputAbstractTitle", "id" => "inputAbstractTitle", "class" => "", "placeholder" => "Your Abstract's Title goes here","data-required"=>"true", "data-maxlength"=>"120", "data-trigger"=>"change", "data-error-message"=>"The text in this box should not exceed 120 characters and cannot be blank."));
          // echo "<div class='counters' id='chartitle'></div>";

           echo form_label("Authors", "inputAbstractAuthors", array("class" => "control-label")); 
           echo form_input(array("name" => "inputAbstractAuthors", "id" => "inputAbstractAuthors", "class" => "","data-required"=>"true", "placeholder" => "Separate Author Names with commas, eg: Richard Dawkins, E.O. Wilson, Ishan Agarwal."));
        ?>
        
        <?php

          echo form_label("What conservation problem or question does your talk/poster address? (max 400 characters):", "inputAbstractAim", array("class" => "control-label")); 
          echo form_textarea(array("name" => "inputAbstractAim", "id" => "inputAbstractAim", "class" => "", "placeholder" => "","data-required"=>"true", "data-maxlength"=>"400", "data-trigger"=>"change", "data-error-message"=>"The text in this box should not exceed 400 characters and cannot be blank."));
          // echo "<div class='counters' id='charaim'></div>";

          echo form_label("What were the main research methods you used? (max 400 characters)", "inputAbstractMethods", array("class" => "control-label")); 
          echo form_textarea(array("name" => "inputAbstractMethods", "id" => "inputAbstractMethods", "class" => "", "placeholder" => "", "data-required"=>"true", "data-maxlength"=>"400", "data-trigger"=>"change", "data-error-message"=>"The text in this box should not exceed 400 characters and cannot be blank."));
          // echo "<div class='counters' id='charmeth'></div>";
          
          echo form_label("What are your most important results? (max 400 characters)", "inputAbstractResults", array("class" => "control-label")); 
          echo form_textarea(array("name" => "inputAbstractResults", "id" => "inputAbstractResults", "class" => "", "placeholder" => "", "data-required"=>"true", "data-maxlength"=>"400", "data-trigger"=>"change", "data-error-message"=>"The text in this box should not exceed 400 characters and cannot be blank."));
          // echo "<div class='counters' id='charres'></div>";

          echo form_label("What is the relevance of your results to conservation? (max 400 characters)", "inputAbstractConservation", array("class" => "control-label")); 
          echo form_textarea(array("name" => "inputAbstractConservation", "id" => "inputAbstractConservation", "class" => "", "placeholder" => "", "data-required"=>"true", "data-maxlength"=>"400", "data-trigger"=>"change", "data-error-message"=>"The text in this box should not exceed 400 characters and cannot be blank."));
          // echo "<div class='counters' id='charcons'></div>";
          
        ?>
        
        <p>Upload your graphical abstract. <em>Your image must be no larger than 1Mb. Only JPG, PNG and GIF formats are allowed.</em></p>
        <?php
          echo form_upload(array("name" => "inputAbstractImage", "id"=>"gupload", 'data-required'=>'true', "onchange"=>"readURL(this);"));
        ?>
        <div class="prefdiv"><p>Choose your preference.</p>
        <?php echo form_radio(array('name'=>'inputAbstractPreference', 'id'=>'talk', 'value'=>'1', 'class'=>'radio', 'data-group'=>'pref', 'data-required'=>'true')); ?>Talk
        <?php echo form_radio(array('name'=>'inputAbstractPreference', 'id'=>'poster', 'value'=>'2','class'=>'radio', 'data-group'=>'pref')); ?>Poster
        <?php echo form_radio(array('name'=>'inputAbstractPreference', 'id'=>'noPref', 'value'=>'3','class'=>'radio', 'data-group'=>'pref')); ?>Either Talk or Poster
        </div>
        <br>
        <div class="burpref"><p>Do you wish to apply for a Bursary?</p>
        <?php echo form_radio(array('name'=>'bursary_pref', 'id' => 'bursary_yes', 'value'=>'1', 'class'=>'radio', 'data-group'=>'bursary_pref', 'data-required'=>'true')); ?>Yes
        <?php echo form_radio(array('name'=>'bursary_pref', 'id' => 'bursary_no', 'value'=>'0','class'=>'radio', 'data-group'=>'bursary_pref')); ?>No</div>
        <br>
        <div class="bursaries_options" id="bursaries_options">
				</div>
        <div class="accompref">
          <p>Would you like SCCS-2013 to arrange accommodation for you during the conference (September 24th-29th)?</p>
          <?php echo form_radio(array('name'=>'inputAbstractAccommodation', 'id'=>'full', 'value'=>'Yes','class'=>'radio', 'data-group'=>'acco', 'data-required'=>'true')); ?>Yes
          <?php echo form_radio(array('name'=>'inputAbstractAccommodation', 'id'=>'travel', 'value'=>'No', 'class'=>'radio', 'data-group'=>'acco')); ?>No
        </div>
        <p><strong>NOTE: Once you have submitted your abstract you will not be able to make any changes.</strong></p>
        <input class="subButton" type="submit" value="Submit Abstract"/> <div class="preview">PREVIEW ABSTRACT</div>
        <?php echo form_close(); ?>
      </div>

      <div class="previewspace">
        <div class="title">You are previewing: </div>
        <div class="close">x</div>
        <img id="img_prev" src="#" alt="your image" />
      </div>
