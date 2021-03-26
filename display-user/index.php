<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * List content in content bank.
 *
 * @package    core_contentbank
 * @copyright  2020 Amaia Anabitarte <amaia@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../config.php');

require_login();
$context = get_context_instance (CONTEXT_SYSTEM);
$roles = get_user_roles($context, $USER->id, false);
$role = key($roles);
$roleid = $roles[$role]->roleid;
if(!$roleid){
    echo "error";
}
require_once("$CFG->libdir/formslib.php");

class fileBlock extends moodleform {
    //Add elements to form
    function definition() {
        global $CFG,$USER;
        $mform = $this->_form;
        $grade = 22;
        $loss = 88;
        $servername = "127.0.0.1";
        $username = "mrfbi";
        $password = "@810Chuongtran123";
        $dbname = "moodle";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $username = '';
        $fullname = '';
        $rawgrademax = '';
        $rawgrade = '';
        $name = '';        
        $progress_sql = "
SELECT DISTINCT c.fullname, COUNT(DISTINCT c.fullname) as total
FROM mdl_course c, mdl_enrol e, mdl_user_enrolments ue, mdl_user u,
mdl_grade_grades gg, mdl_grade_items gi, mdl_quiz q, mdl_quiz_grades qg
WHERE c.id = e.courseid
AND e.id = ue.enrolid
AND ue.userid = u.id
AND u.auth = e.enrol
AND u.id = $USER->id
AND gg.itemid = gi.id
AND gi.courseid = c.id
AND q.course = c.id
AND qg.quiz = q.id
AND qg.userid = u.id
AND gg.usermodified = u.id";
        $result = $conn->query($progress_sql);
        if($result->num_rows>0)
        {        
            while($row=$result->fetch_assoc()){
                $fullname = $row['fullname'];
                $count = $row['total'];
                echo $fullname."<br>";
                echo $count."<br>";
            }
            
    } 
    else{
        echo "Person has not enrolled a course yet.<br>";
    }
    }
}
$PAGE->set_title('Tracking student grade');
$PAGE->set_heading('Tracking student grade');
// Get all contents managed by active plugins where the user has permission to render them.
echo $OUTPUT->header();
$mform = new fileBlock();
if ($mform->is_cancelled()) {
} else if ($fromform = $mform->get_data()) {
} else {
    $mform->set_data($toform);
    $mform->display();
}
echo $OUTPUT->footer();
