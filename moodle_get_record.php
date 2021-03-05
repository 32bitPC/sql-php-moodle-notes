<?php
// This file is part of Moodle - http://moodle.org/
/**
 * Page to edit the question bank
 *
 * @package    moodlecore
 * @subpackage questionbank
 * @copyright  1999 onwards Martin Dougiamas {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../config.php');
function db_conn() {
    global $DB;
    $record = $DB->get_records('user', array(),'username');
    foreach($record as $result){
        echo "\n<br>";
        echo $result->username;
        
    }
    // You can access the database via the $DB method calls here.
}
db_conn();
