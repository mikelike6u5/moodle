<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class news_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('text', 'title', 'Title'); // Add elements to your form
        $mform->setType('title', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('title', 'Please enter the title.');        //Default value
        $mform->addElement('textarea', 'content', 'Descriprion', 'wrap="virtual" rows="20" cols="50"');
        $mform->setType('content', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('content', 'Please enter the text.');        //Default value
        $mform->addElement('checkbox', 'is_enabled', 'Is enabled');
        $this->add_action_buttons();

    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
