$mform->addElement('text', 'name', get_string('name')); // Add elements to your form
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name','');
        $mform->addElement('filepicker', 'userfile', get_string('file'), null,
                   array('maxbytes' => $maxbytes, 'accepted_types' => '*'));
    $mform->addElement('text', 'age', get_string('age'));
    $mform->setType('age', PARAM_NOTAGS);
    $mform->setDefault('age','');
$this->add_action_buttons(true, 'submit');
echo $param['name'] = optional_param('name',null, PARAM_NOTAGS);
    echo "\n";
    echo $param['filemanager'] = optional_param('filemanager',null,PARAM_NOTAGS);
    echo "\n";
    $content = $mform->get_file_content('userfile');
    echo "File content is ".$content;
    echo "\n";
    $name = $mform->get_new_filename('userfile');
    echo "Name of file is ".$name;
    echo "\n";
    $fullpath = "/demo_file";
    $success = $mform->save_file('userfile', $fullpath, $override);
    echo "File status is ".$success;
    echo "\n";
    $storedfile = $mform->save_stored_file('userfile', 'D:\xampp\htdocs\moodle\demo\demo_file');
    file_save_draft_area_files($data->attachments, $context->id, 'mod_glossary', 'attachment',
                   $entry->id, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 50));
