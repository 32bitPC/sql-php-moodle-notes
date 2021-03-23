$servername = "127.0.0.1";
    $username = "####";
    $password = "####";
    $dbname = "moodle";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $filename = $mform->get_new_filename('myfile');
    $mform->save_file('myfile', $CFG->dataroot . '/fileData/' . $filename);  
    require_once 'PHPLibrary/PHPExcel/Classes/PHPExcel.php';
    $file = $CFG->dataroot . '/fileData/'.$filename;
    $objFile = PHPExcel_IOFactory::identify($file);
    $objData = PHPExcel_IOFactory::createReader($objFile);
    $objData->setReadDataOnly(true);
    $objPHPExcel = $objData->load($file);    
    $sheet = $objPHPExcel->setActiveSheetIndex(0);   
    $Totalrow = $sheet->getHighestRow();
    $LastColumn = $sheet->getHighestColumn();$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn); //Táº¡o máº£ng chá»©a dá»¯ liá»‡u
    $data = [];for ($i = 2; $i <= $Totalrow; $i++) {
        for ($j = 0; $j < $TotalCol; $j++) {
            $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();;
        }
    }
    $Totalrow = $Totalrow - 2;
    global $DB;
    
    //update user table
    for ($i = 0; $i <= $Totalrow; $i++) {
        echo "<br>";
        $latest_user = 0;
        $case = 0;
        $username = $data[$i][0];
        $sql_user = "SELECT id from mdl_user where username =
        '$username'";
        $result = $conn->query($sql_user);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $latest_user = $row['id'];        
            }
        }
        else{
            $case = 1;
            echo "(".$case.") User not exist. Creating a new user. <br>";
            $write_user->username = $data[$i][0];
        $username_petition_del = $data[$i][0];
        $pieces = explode(" ",$data[$i][0]);   
        $write_user->firstname = $pieces[0];
        $write_user->lastname = $pieces[1];
        $write_user->auth = "manual";
        $write_user->confirmed = 1;
        $write_user->mnethostid = 1;
        $write_user->country = "VN";
        $write_user->timezone = "Asia/Ho_Chi_Minh";
        $write_user->firstaccess = time();
        $write_user->lastaccess = time();
        $write_user->lastlogin = time();
        $write_user->currentlogin = time();
        $write_user->timemodified = time();
        $write_user->id = $DB->insert_record('user',$write_user);
        $sql_user = "SELECT id from mdl_user where username =
        '$username'";
        $result = $conn->query($sql_user);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $latest_user = $row['id'];
            }
        }
        }
        
        $latest_cohort = 0;
        $cohort = $data[$i][14];
        $sql_cohort = 
        "SELECT id,name FROM mdl_cohort where name='$cohort'";
        echo "SQL cohort is ".$sql_cohort."<br>";
        $result = $conn->query($sql_cohort);
        if($result->num_rows>0){
            echo "Cohort ID is extracted. <br>";
            while($row=$result->fetch_assoc()){
                $latest_cohort = $row['id'];
                $latest_cohort_name = $row['name'];
            }
        }
        else{
            echo "No cohort was found. Creating a new one. <br>";
            $write_cohort->name = $data[$i][14];
            $write_cohort->contextid = 37;
            $write_cohort->descriptionformat	 = 1;
            $write_cohort->visible = 1;
            $write_cohort->timecreated = 1616465363;
            $write_cohort->timemodified = 1616465363;
            $write_cohort->id = $DB->insert_record('cohort',$write_cohort);
            $result = $conn->query($sql_cohort);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    $latest_cohort = $row['id'];
                    $latest_cohort_name = $row['name'];
                    
                }
            }
        }
        $queried_course = 0;
        $write_cohort_members->cohortid = $latest_cohort;
        $write_cohort_members->userid = $latest_user;
        $write_cohort_members->timeadd = time();
        $write_cohort_members->id = $DB->insert_record('cohort_members',$write_cohort_members);
        $course_name = $data[$i][15];
        $sql_course = "
        SELECT id from mdl_course where fullname = '$course_name'";
        $result= $conn->query($sql_course);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $queried_course = $row['id'];
            }
        }
        else{
            if($case=1){
            echo "Course not found. Create one in moodle first! User ".$username_petition_del." will be deleted! <br>";
            $sql_delete_user = "DELETE from mdl_user where username ='$username_petition_del'";
            $result = $conn->query($sql_delete_user);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    echo "Latest user has been deleted. <br>";
                }
            }}
            else{
                echo "Course not found. Create one in moodle first!<br";
            }
        }
        $queried_enrol = 0;
        $sql_enrol = "
        SELECT id from mdl_enrol where courseid = '$queried_course'";
        $result = $conn->query($sql_enrol);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $queried_enrol = $row['id'];
            }
        }
        $write_enrolment->status = 0;
        $write_enrolment->enrolid = $queried_enrol;
        $write_enrolment->userid = $latest_user;
        $write_enrolment->timestart = time();
        $write_enrolment->timeend = 0;
        $write_enrolment->modifierid = 2;
        $write_enrolment->timecreated = time();
        $write_enrolment->timemodified = time();
        $write_enrolment->id = $DB->insert_record('user_enrolments',$write_enrolment);
        echo "User ".$latest_user." has been enrolled with enrolment ID ".$queried_enrol."<br>";
        echo "<br>";
        
    }
