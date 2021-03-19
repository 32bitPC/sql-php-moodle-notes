<?php

require('../config.php');
global $CFG, $PAGE;
require_once("$CFG->libdir/formslib.php");

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title('Upload file');
$PAGE->set_heading('Upload file');
$PAGE->set_url($CFG->wwwroot.'');
echo $OUTPUT->header();
echo "Data is ".$_POST["data"]."\n";
echo "TBA\n";
echo $OUTPUT->footer();
?>
