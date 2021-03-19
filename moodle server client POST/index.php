<?php

require('../config.php');
global $CFG, $PAGE;
require_once("$CFG->libdir/formslib.php");

class second_block extends moodleform {
    public function definition(){
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!
        echo '<form autocomplete="off" action="http://localhost:8083/moodle/demo/views.php" method="post" accept-charset="utf-8" id="mform1_Wft3giWsSCwUxFS" class="mform" data-boost-form-errors-enhanced="1">
	<div style="display: none;"><input name="sesskey" type="hidden" value="0YRyA4Bh1c">
<input name="_qf__second_block" type="hidden" value="1">
</div>

<div id="fitem_id_data" class="form-group row  fitem   ">
    <div class="col-md-3 col-form-label d-flex pb-0 pr-md-0">
        
                <label class="d-inline word-break " for="id_data">
                    Data
                </label>
        
        <div class="ml-1 ml-md-auto d-flex align-items-center align-self-start">
            
        </div>
    </div>
    <div class="col-md-9 form-inline align-items-start felement" data-fieldtype="text">
        <input type="text" class="form-control " name="data" id="id_data" value="">
        <div class="form-control-feedback invalid-feedback" id="id_error_data">
            
        </div>
    </div>
</div>
  <input type="submit" value="Upload file" name="submit">
</form>';
    }
}
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title('Upload file');
$PAGE->set_heading('Upload file');
$PAGE->set_url($CFG->wwwroot.'');
echo $OUTPUT->header();
$mform = new second_block();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
    echo "TBA";
  //In this case you process validated data. $mform->get_data() returns data posted in form.
} else {
  // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
  // or on the first display of the form.

  //Set default data (if any)
  $mform->set_data($toform);
  //displays the form
  $mform->display();
}
echo $OUTPUT->footer();
?>
