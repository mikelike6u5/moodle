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
require_once($CFG->dirroot . '/local/news/classes/form/news_form.php');

global $DB;

// Set the url of a form
$PAGE->set_url(new moodle_url('/local/news/form.php'));
$PAGE->set_context(\context_system::instance());

// Check is it the new news article
$isNew = true;
// Show the corresponding title
$title = $isNew ? get_string('newscreateform', 'local_news')
                : get_string('newseditform', 'local_news');

// Set the form title
$PAGE->set_title($title);
$PAGE->set_heading($title);

$newsForm = new news_form();

echo $OUTPUT->header();
//echo $OUTPUT->heading($title);

//Form processing and displaying is done here
if ($newsForm->is_cancelled()) {
    redirect($CFG->wwwroot.'/local/news/settings_list.php', 'You canceled news form!');
} else if ($fromform = $newsForm->get_data()) {

    $id = optional_param('id', null, PARAM_INT);
    if (!is_null($id)) {
        $fromform->id = $id;
        // Check if the record exists
        $exists = $DB->record_exists('local_news', array('id'=>$id));
        if ($exists) {
            // Update the record
            $DB->update_record('local_news', $fromform);
            $message = 'You updated an article.';
        }
        $message = 'The record not exist.';
    } else {
        if (!isset($fromform->is_enabled)) {
            $fromform->is_enabled = 0;
        }

        $new_record = new stdClass();
        $new_record->title     = $fromform->title;
        $new_record->content   = $fromform->content;
        /*if (isset($fromform->is_enabled)) {
          $new_record->is_enabled = $fromform->is_enabled;
        } else {
          $fromform->is_enabled = 0;
        }*/
        $DB->insert_record('local_news', $new_record);
        $message = 'You created a new article.';
    }

    redirect($CFG->wwwroot.'/local/news/settings_list.php', 'You created a new article!');
} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.
    //displays the form
    $id = optional_param('id', null, PARAM_INT);
    if (!is_null($id)) {
        //Set default data
        $toform = $DB->get_record('local_news',array('id'=>$id));
        $newsForm->set_data($toform);
    }
    $newsForm->display();
}

echo $OUTPUT->footer();
