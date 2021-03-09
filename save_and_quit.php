public function save_and_quit($question, $form) {
        global $USER, $DB;
        // The actual update/insert done with multiple DB access, so we do it in a transaction.
        $transaction = $DB->start_delegated_transaction ();
        
        list($question->category) = explode(',', $form->category);
        $context = $this->get_context_by_category_id($question->category);
        
        // This default implementation is suitable for most
        // question types.
        
        // First, save the basic question itself.
        $question->name = trim($form->name);
        $question->parent = isset($form->parent) ? $form->parent : 0;
        $question->length = $this->actual_number_of_questions($question);
        $question->penalty = isset($form->penalty) ? $form->penalty : 0;
        
        // The trim call below has the effect of casting any strange values received,
        // like null or false, to an appropriate string, so we only need to test for
        // missing values. Be careful not to break the value '0' here.
        if (!isset($form->questiontext['text'])) {
            $question->questiontext = '';
        } else {
            $question->questiontext = trim($form->questiontext['text']);
        }
        $question->questiontextformat = !empty($form->questiontext['format']) ?
        $form->questiontext['format'] : 0;
        
        if (empty($form->generalfeedback['text'])) {
            $question->generalfeedback = '';
        } else {
            $question->generalfeedback = trim($form->generalfeedback['text']);
        }
        $question->generalfeedbackformat = !empty($form->generalfeedback['format']) ?
        $form->generalfeedback['format'] : 0;
        
        if ($question->name === '') {
            $question->name = shorten_text(strip_tags($form->questiontext['text']), 15);
            if ($question->name === '') {
                $question->name = '-';
            }
        }
        
        if ($question->penalty > 1 or $question->penalty < 0) {
            $question->errors['penalty'] = get_string('invalidpenalty', 'question');
        }
        
        if (isset($form->defaultmark)) {
            $question->defaultmark = $form->defaultmark;
        }
        
        if (isset($form->idnumber)) {
            if ((string) $form->idnumber === '') {
                $question->idnumber = null;
            } else {
                // While this check already exists in the form validation,
                // this is a backstop preventing unnecessary errors.
                // Only set the idnumber if it has changed and will not cause a unique index violation.
                if (strpos($form->category, ',') !== false) {
                    list($category, $categorycontextid) = explode(',', $form->category);
                } else {
                    $category = $form->category;
                }
                if (!$DB->record_exists('question',
                    ['idnumber' => $form->idnumber, 'category' => $category])) {
                        $question->idnumber = $form->idnumber;
                    }
            }
        }
        
        // If the question is new, create it.
        $newquestion = false;
        if (empty($question->id)) {
            // Set the unique code.
            $question->stamp = make_unique_id_code();
            $question->createdby = $USER->id;
            $question->timecreated = time();
            $question->id = $DB->insert_record('question', $question);
            $newquestion = true;
        }
        
        // Now, whether we are updating a existing question, or creating a new
        // one, we have to do the files processing and update the record.
        // Question already exists, update.
        $question->modifiedby = $USER->id;
        $question->timemodified = time();
        
        if (!empty($question->questiontext) && !empty($form->questiontext['itemid'])) {
            $question->questiontext = file_save_draft_area_files($form->questiontext['itemid'],
                $context->id, 'question', 'questiontext', (int)$question->id,
                $this->fileoptions, $question->questiontext);
        }
        if (!empty($question->generalfeedback) && !empty($form->generalfeedback['itemid'])) {
            $question->generalfeedback = file_save_draft_area_files(
                $form->generalfeedback['itemid'], $context->id,
                'question', 'generalfeedback', (int)$question->id,
                $this->fileoptions, $question->generalfeedback);
        }
        $DB->update_record('question', $question);
        
        // Now to save all the answers and type-specific options.
        $form->id = $question->id;
        $form->qtype = $question->qtype;
        $form->category = $question->category;
        $form->questiontext = $question->questiontext;
        $form->questiontextformat = $question->questiontextformat;
        // Current context.
        $form->context = $context;
        
        $result = $this->save_question_options($form);
        
        if (!empty($result->error)) {
            print_error($result->error);
        }
        
        if (!empty($result->notice)) {
            notice($result->notice, "question.php?id={$question->id}");
        }
        
        if (!empty($result->noticeyesno)) {
            throw new coding_exception(
                '$result->noticeyesno no longer supported in save_question.');
        }
        
        // Give the question a unique version stamp determined by question_hash().
        $DB->set_field('question', 'version', question_hash($question),
            array('id' => $question->id));
        
        if ($newquestion) {
            // Log the creation of this question.
            $event = \core\event\question_created::create_from_question_instance($question, $context);
            $event->trigger();
        } else {
            // Log the update of this question.
            $event = \core\event\question_updated::create_from_question_instance($question, $context);
            $event->trigger();
        }
        
        $transaction->allow_commit();
        
        return $question;
    }
    
    
