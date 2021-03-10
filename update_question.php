<?php
$servername = "127.0.0.1";
$username = "mrfbi";
$password = "@810Chuongtran123";
$dbname = "moodle";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// see this, stop rolling back

$sql= "SELECT slot FROM mdl_quiz_slots
ORDER BY id DESC
LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $latest_slot = $row['slot'];
        
    }
} else {
    echo "Cannot retrieve slot";
}
echo "Latest slot is : ".$latest_slot;
echo "\n";
$sql= "SELECT id FROM mdl_quiz
ORDER BY id DESC
LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $latest_quiz_id = $row['id'];
        
    }
} else {
    echo "Cannot retrieve quiz id";
}
echo "Latest quiz id is : ".$latest_quiz_id;
echo "\n";

$line_1 = "int x = 1;\n";
$line_2 = "float y = 1.1f\n";
$line_3 = "short z = 1\n";
$line_4 = "Console WriteLine((float) x + y * z - (x += (short) y))\n";
$sql = "
INSERT INTO mdl_question
(category,parent,name,questiontext,questiontextformat,
generalfeedbackformat,defaultmark,penalty,qtype,
length,
stamp,
version,
hidden,
timecreated,
timemodified,
createdby,modifiedby)
VALUES
(49,0,'5.',
'What will be the output of the following code snippet when it is executed?',
1,1,'1.0000000',
0.3333333,'multichoice',
1,
'localhost:8083+210310065340+yMaZRk',
'localhost:8083+210310065340+mwJymV',
0,
'1615359220',
'1615359220',
'2','2')
"
;
if ($conn->query($sql) === TRUE) {
    echo "questions updated successfully\n";
} else {
    echo "Error: " . $sql . "\n" . $conn->error;
}
$sql= "SELECT id FROM mdl_question
ORDER BY id DESC
LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $latest_id = $row['id'];
        
    }
} else {
    echo "Cannot retrieve question id";
}
echo "Latest question id is : ".$latest_id;
echo "\n";
$sql = "
INSERT INTO mdl_question_answers
(question,answer,answerformat,fraction,feedbackformat)
VALUES
($latest_id,'0.1',1,'1.0000000',1),
($latest_id,'1.0',1,'0.0000000',1),
($latest_id,'1.1',1,'0.0000000',1),
($latest_id,'11',1,'0.0000000',1)
";
if ($conn->query($sql) === TRUE) {
    echo "question answers updated successfully\n";
} else {
    echo "Error: " . $sql . "\n" . $conn->error;
}
echo "\n";
$sql = "
INSERT INTO mdl_quiz_slots
(slot,quizid,page,requireprevious,questionid,questioncategoryid,
includingsubcategories,maxmark)
VALUES
($latest_slot+1,$latest_quiz_id,1,0,$latest_id,'NULL','NULL','1.0000000')
";
if ($conn->query($sql) === TRUE) {
    echo "quiz slot updated successfully\n";
} else {
    echo "Error: " . $sql . "\n" . $conn->error;
}
echo "\n";
$sql = "
INSERT INTO mdl_qtype_multichoice_options
(questionid,layout,single,shuffleanswers,correctfeedback,
correctfeedbackformat,partiallycorrectfeedback,
partiallycorrectfeedbackformat,incorrectfeedback,
incorrectfeedbackformat,answernumbering,shownumcorrect,
showstandardinstruction)
VALUES
($latest_id,0,1,1,'Your answer is correct.',1,'Your answer is partially correct.',
1,'Your answer is incorrect.',1,'abc',1,0)
";
if ($conn->query($sql) === TRUE) {
    echo "quiz type option updated successfully\n";
} else {
    echo "Error: " . $sql . "\n" . $conn->error;
}
echo "\n";


$conn->close();
?>
