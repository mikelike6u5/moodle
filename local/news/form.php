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

/**
 * Plugin administration form is defined here.
 *
 * @package     local_news
 * @category    admin
 * @copyright   likemike834@gmail.com
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Include config.php.
require(__DIR__ . '/../../config.php');
// Include form class.
require_once($CFG->dirroot . '/local/news/classes/form/newsform.php');

global $DB;

$PAGE->requires->css('/local/news/css/form.css');

$id = optional_param('id', null, PARAM_INT);
$action = optional_param('action', null, PARAM_NOTAGS);

if (!is_null($id) && $action == 'delete') {
    $DB->delete_records('local_news', ['id' => $id]);
    redirect($CFG->wwwroot.'/local/news/settings_list.php', 'The article was deleted!');
}

// Set the url of a form.
$PAGE->set_url(new moodle_url('/local/news/form.php'));
$PAGE->set_context(\context_system::instance());

// Check is it the new news article.
$isnew = true;
// Show the corresponding title.
$title = $isnew ? get_string('newscreateform', 'local_news')
                : get_string('newseditform', 'local_news');

// Set the form title.
$PAGE->set_title($title);
$PAGE->navbar->add('Table view', new moodle_url('/local/news/settings_list.php'));
$PAGE->set_heading($SITE->shortname);

$newsform = new newsform();

echo $OUTPUT->header();
echo $OUTPUT->heading('New Form');
// Form processing and displaying is done here.
if ($newsform->is_cancelled()) {
    redirect($CFG->wwwroot.'/local/news/settings_list.php', 'You canceled news form!');
} else if ($fromform = $newsform->get_data()) {
    if (!is_null($id)) {
        $fromform->id = $id;
        // Check if the record exists.
        $exists = $DB->record_exists('local_news', array('id' => $id));
        if ($exists) {
            // Update the record.
            $modified = time();
            $fromform->timemodified = $modified;
            $DB->update_record('local_news', $fromform);
            $message = 'The changes have been saved.';
        }
        $message = 'The record not exist.';
    } else {
        if (!isset($fromform->is_enabled)) {
            $fromform->is_enabled = 0;
        }

        $newrecord = new stdClass();
        $newrecord->title      = $fromform->title;
        $newrecord->content    = $fromform->content;
        $newrecord->is_enabled = $fromform->is_enabled;
        $modified = time();
        $newrecord->timemodified = $modified;
        $DB->insert_record('local_news', $newrecord);
        $message = 'The changes have been saved';
    }

    redirect($CFG->wwwroot.'/local/news/settings_list.php', 'You created a new article!');
} else {
    // This branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.
    // Displays the form.
    $id = optional_param('id', null, PARAM_INT);
    if (!is_null($id)) {
        // Set default data.
        $toform = $DB->get_record('local_news', array('id' => $id));
        $newsform->set_data($toform);
    }
    $newsform->display();
}

echo $OUTPUT->footer();
