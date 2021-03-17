class second_block extends moodleform {
    public function definition(){
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('text', 'name', get_string('name')); // Add elements to your form
        $mform->setType('name', PARAM_NOTAGS);
        $mform->addElement('date_selector', 'assesstimefinish', get_string('to'),array(
    'startyear' => 1970,
    'stopyear'  => 2020,
    'timezone'  => 99,
    'step'      => 5,
    'optional' => false,
));
$this->add_action_buttons(true, 'submit');

    }
}
$mform = new second_block();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
    $params['name'] = optional_param('name',null, PARAM_NOTAGS);
    echo "Value is ".$params['name'];
  //In this case you process validated data. $mform->get_data() returns data posted in form.
} else {
  // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
  // or on the first display of the form.

  //Set default data (if any)
  $mform->set_data($toform);
  //displays the form
  $mform->display();
}
