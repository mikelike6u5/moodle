<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

// Moodleform is defined in formslib.php.
require_once($CFG->libdir . "/formslib.php");

class newsform extends moodleform {
    // Add elements to form.
    public function definition() {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore!
        $mform->id = 'mform_id';
        $id = optional_param('id', null, PARAM_INT);
        if (!is_null($id)) {
            $mform->addElement('hidden', 'id', $id);
            $mform->setType('id', PARAM_INT);
        }
        $mform->addElement('text', 'title', 'Title'); // Add elements to your form.
        $mform->setType('title', PARAM_NOTAGS); // Set type of element.
        $mform->setDefault('title', 'Please enter the title.'); // Default value.
        $mform->addElement('textarea', 'content', 'Descriprion', 'wrap="virtual" rows="5" cols="50"');
        $mform->setType('content', PARAM_NOTAGS); // Set type of element.
        $mform->setDefault('content', 'Please enter the text.'); // Default value.
        $mform->addElement('checkbox', 'is_enabled', 'Is enabled');
        $this->add_action_buttons();
    }
}
