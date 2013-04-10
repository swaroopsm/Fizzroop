<div class="message">
  <p>Hi <?php echo $attendeeFirstName." ".$attendeeLastName; ?>!</p>
        <p>This page is where you can <a href="#" class="absubmit"> submit your abstract</a> and sign up for <a href="#" class="workshops">workshops</a> for SCCS. Make sure you <a href="#" class="absguide">read the abstract submission guidelines</a> before you submit. Once submitted, you cannot change your abstract, so please be sure of it.</p></div>
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
          echo form_label("Methods:", "inputAbstractMethods", array("class" => "control-label")); 
          echo form_textarea(array("name" => "inputAbstractMethods", "id" => "inputAbstractMethods", "class" => "", "placeholder" => "What methods did you use for your abstract?"));
          echo "<div class='counters' id='charmeth'></div>";
          echo form_label("Aim:", "inputAbstractAim", array("class" => "control-label")); 
          echo form_textarea(array("name" => "inputAbstractAim", "id" => "inputAbstractAim", "class" => "", "placeholder" => "What aims have you set up?"));
          echo "<div class='counters' id='charaim'></div>";
          echo form_label("Conservation:", "inputAbstractConservation", array("class" => "control-label")); 
          echo form_textarea(array("name" => "inputAbstractConservation", "id" => "inputAbstractConservation", "class" => "", "placeholder" => "What methods did you use for your abstract?"));
          echo "<div class='counters' id='charcons'></div>";
          echo form_label("Results:", "inputAbstractResults", array("class" => "control-label")); 
          echo form_textarea(array("name" => "inputAbstractResults", "id" => "inputAbstractResults", "class" => "", "placeholder" => "What aims have you set up?"));
          echo "<div class='counters' id='charres'></div>";
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
        <br>
        <input class="subButton" type="submit" value="Submit Abstract"/> <div class="preview">PREVIEW ABSTRACT</div>
        <?php echo form_close(); ?>
      </div>

      <div class="previewspace">
        <div class="title">You are previewing: </div>
        <div class="close">x</div>
        <img id="img_prev" src="#" alt="your image" />
      </div>