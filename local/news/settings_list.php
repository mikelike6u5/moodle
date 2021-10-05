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

// Include config.php.
require(__DIR__ . '/../../config.php');

// Globals.
global $DB;

// Include datatables.

// Include adminlib.php.
require_once($CFG->libdir.'/adminlib.php');
// Set up external admin page.
admin_externalpage_setup('local_news_list');

$PAGE->requires->css('/local/news/css/datatables.min.css');
$PAGE->requires->css('/local/news/css/custom.css');
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/local/news/js/page.js'));

// Prepare the data.
$news = $DB->get_records('local_news');

foreach ($news as &$article) {
    $linkedit = new moodle_url('/local/news/form.php', array('id' => $article->id, 'action' => 'edit'));
    $linkdelete = new moodle_url('/local/news/form.php', array('id' => $article->id, 'action' => 'delete'));
    $article->linkedit = str_replace("&amp;", "&", $linkedit->__toString());
    $article->linkdelete = str_replace("&amp;", "&", $linkdelete->__toString());
    $article->timemodified = date('m/d/Y', $article->timemodified);
}

$linkadd = new moodle_url('/local/news/form.php');
$templatecontext = (object)[
    'news' => array_values($news),
    'formlink' => $linkadd->__toString(),
];

// Prepare the page.
$title = get_string('newslist', 'local_news');
$PAGE->set_title($title);
$PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();
echo $OUTPUT->heading($title);
echo $OUTPUT->render_from_template('local_news/list', $templatecontext);
echo $OUTPUT->footer();
