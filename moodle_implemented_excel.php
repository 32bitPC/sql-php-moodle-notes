<?php
//Nhúng file PHPExcel
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
require "PHPLibrary/PHPExcel/Classes/PHPExcel.php";

//Đường dẫn file
$file = 'excel_questions_1_1.xlsx';
//Tiến hành xác thực file
$objFile = PHPExcel_IOFactory::identify($file);
$objData = PHPExcel_IOFactory::createReader($objFile);

//Chỉ đọc dữ liệu
$objData->setReadDataOnly(true);

// Load dữ liệu sang dạng đối tượng
$objPHPExcel = $objData->load($file);

//Lấy ra số trang sử dụng phương thức getSheetCount();
// Lấy Ra tên trang sử dụng getSheetNames();

//Chọn trang cần truy xuất
$sheet = $objPHPExcel->setActiveSheetIndex(0);

//Lấy ra số dòng cuối cùng
$Totalrow = $sheet->getHighestRow();
//Lấy ra tên cột cuối cùng
$LastColumn = $sheet->getHighestColumn();

//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

//Tạo mảng chứa dữ liệu
$data = [];

//Tiến hành lặp qua từng ô dữ liệu
//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
for ($i = 2; $i <= $Totalrow; $i++) {
    //----Lặp cột
    for ($j = 0; $j < $TotalCol; $j++) {
        // Tiến hành lấy giá trị của từng ô đổ vào mảng
        $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();;
    }
}
//Hiển thị mảng dữ liệu
for($i=0;$i<=$Totalrow-2;$i++){
    $category = $data[$i][0];
    $name = $data[$i][1];
    $questiontext = $data[$i][2];
    $stamp = rand(1,9999999999);
    $version = rand(1,9999999999);
    $timecreated = time();
    $timemodified = time();
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
($category,0,'$name',
'$questiontext',
1,1,'1.0000000',
0.3333333,'multichoice',
1,
'$stamp',
'$version',
0,
'$timecreated',
'$timemodified',
'2','2')
"
;
if ($conn->query($sql) === TRUE) {
    echo "Question ".($i+1)." updated successfully.\n";
} else {
    echo "Error: " . $sql . "\n" . $conn->error;
}
echo "\n";
}

$file = 'excel_answers_1_1.xlsx';
//Tiến hành xác thực file
$objFile = PHPExcel_IOFactory::identify($file);
$objData = PHPExcel_IOFactory::createReader($objFile);

//Chỉ đọc dữ liệu
$objData->setReadDataOnly(true);

// Load dữ liệu sang dạng đối tượng
$objPHPExcel = $objData->load($file);

//Lấy ra số trang sử dụng phương thức getSheetCount();
// Lấy Ra tên trang sử dụng getSheetNames();

//Chọn trang cần truy xuất
$sheet = $objPHPExcel->setActiveSheetIndex(0);

//Lấy ra số dòng cuối cùng
$Totalrow = $sheet->getHighestRow();
//Lấy ra tên cột cuối cùng
$LastColumn = $sheet->getHighestColumn();
echo "Total row is ".$Totalrow."\n";
//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

//Tạo mảng chứa dữ liệu
$data = [];

//Tiến hành lặp qua từng ô dữ liệu
//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
for ($i = 2; $i <= $Totalrow; $i++) {
    //----Lặp cột
    for ($j = 0; $j < $TotalCol; $j++) {
        // Tiến hành lấy giá trị của từng ô đổ vào mảng
        $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();;
    }
}
for($i=0;$i<=$Totalrow-2;$i++){
    echo "Answer ".($i+1)."\n";
    $question = $data[$i][0] + 9;
    $answer = $data[$i][1];
    $fraction = $data[$i][2];
    $sql = "
INSERT INTO mdl_question_answers
(question,answer,answerformat,fraction,feedbackformat)
VALUES
($question,'$answer',1,$fraction,1)
";
    if ($conn->query($sql) === TRUE) {
        echo "Answer ".($i+1)." updated successfully\n";
    } else {
        echo "Error: " . $sql . "\n" . $conn->error;
    }
    echo "\n";
}

$file = 'excel_slots_1_1.xlsx';
//Tiến hành xác thực file
$objFile = PHPExcel_IOFactory::identify($file);
$objData = PHPExcel_IOFactory::createReader($objFile);

//Chỉ đọc dữ liệu
$objData->setReadDataOnly(true);

// Load dữ liệu sang dạng đối tượng
$objPHPExcel = $objData->load($file);

//Lấy ra số trang sử dụng phương thức getSheetCount();
// Lấy Ra tên trang sử dụng getSheetNames();

//Chọn trang cần truy xuất
$sheet = $objPHPExcel->setActiveSheetIndex(0);

//Lấy ra số dòng cuối cùng
$Totalrow = $sheet->getHighestRow();
//Lấy ra tên cột cuối cùng
$LastColumn = $sheet->getHighestColumn();

//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

//Tạo mảng chứa dữ liệu
$data = [];

//Tiến hành lặp qua từng ô dữ liệu
//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
for ($i = 2; $i <= $Totalrow; $i++) {
    //----Lặp cột
    for ($j = 0; $j < $TotalCol; $j++) {
        // Tiến hành lấy giá trị của từng ô đổ vào mảng
        $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();;
    }
}
for($i=0;$i<=$Totalrow-2;$i++){
    echo "Quiz slot ".($i+1)."\n";
    $slot = $data[$i][0];
    $quiz = $data[$i][1];
    $question = $data[$i][2] +13;
    $score = $data[$i][3];
    $sql = "
INSERT INTO mdl_quiz_slots
(slot,quizid,page,requireprevious,questionid,maxmark)
VALUES
($slot,$quiz,1,0,$question,$score)
";
    if ($conn->query($sql) === TRUE) {
        echo "Quiz slot ".($i+1)." updated successfully\n";
    } else {
        echo "Error: " . $sql . "\n" . $conn->error;
    }
    echo "\n";
}

$file = 'excel_qtype_1_1.xlsx';
//Tiến hành xác thực file
$objFile = PHPExcel_IOFactory::identify($file);
$objData = PHPExcel_IOFactory::createReader($objFile);

//Chỉ đọc dữ liệu
$objData->setReadDataOnly(true);

// Load dữ liệu sang dạng đối tượng
$objPHPExcel = $objData->load($file);

//Lấy ra số trang sử dụng phương thức getSheetCount();
// Lấy Ra tên trang sử dụng getSheetNames();

//Chọn trang cần truy xuất
$sheet = $objPHPExcel->setActiveSheetIndex(0);

//Lấy ra số dòng cuối cùng
$Totalrow = $sheet->getHighestRow();
//Lấy ra tên cột cuối cùng
echo "Total row is ".$Totalrow."\n";
$LastColumn = $sheet->getHighestColumn();

//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

//Tạo mảng chứa dữ liệu
$data = [];

//Tiến hành lặp qua từng ô dữ liệu
//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
for ($i = 2; $i <= $Totalrow; $i++) {
    //----Lặp cột
    for ($j = 0; $j < $TotalCol; $j++) {
        // Tiến hành lấy giá trị của từng ô đổ vào mảng
        $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();;
    }
}

for($i=0;$i<=$Totalrow-2;$i++){
    $question = $data[$i][0] +13;
    $sql = "
INSERT INTO mdl_qtype_multichoice_options
(questionid,layout,single,shuffleanswers,correctfeedback,
correctfeedbackformat,partiallycorrectfeedback,
partiallycorrectfeedbackformat,incorrectfeedback,
incorrectfeedbackformat,answernumbering,shownumcorrect,
showstandardinstruction)
VALUES
($question,0,1,1,'Your answer is correct.',1,'Your answer is partially correct.',
1,'Your answer is incorrect.',1,'abc',1,0)
";
    if ($conn->query($sql) === TRUE) {
        echo "Qtype ".($i+1)." updated successfully\n";
    } else {
        echo "Error: " . $sql . "\n" . $conn->error;
    }
    echo "\n";
}

