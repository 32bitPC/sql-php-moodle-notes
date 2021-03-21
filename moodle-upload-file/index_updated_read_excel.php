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
require_once("$CFG->libdir/formslib.php");

class fileBlock extends moodleform {
    //Add elements to form
    function definition() {
        global $CFG;
        
        $mform = $this->_form; // Don't forget the underscore!
        $mform = $this->_form;
        
        $mform->addElement('filepicker', 'myfile', 'My File');
        
        $mform->addElement('submit', 'mysubmit', 'Upload'); 
    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
$PAGE->set_title('Upload file');
$PAGE->set_heading('Upload file');
// Get all contents managed by active plugins where the user has permission to render them.
echo $OUTPUT->header();
$mform = new fileBlock();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
    $filename = $mform->get_new_filename('myfile');
    echo "File uploaded successfully!";
    $mform->save_file('myfile', $CFG->dataroot . '/filePersonal/' . $filename);
    $fs = get_file_storage();
    $files = $fs->get_area_files($contextid, $component, $filearea, $itemid, 'filename', false);
    
    foreach ($files as $file) {
        $file->copy_content_to($destdir.'/'.$file->get_filename());
    }
    
    require_once 'Classes/PHPExcel.php';
    
    //Đường dẫn file
    $file = $CFG->dataroot . '/filePersonal/data.xlsx';
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
    print_r($data);
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
