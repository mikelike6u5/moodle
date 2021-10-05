<?php
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
      $link_edit = new moodle_url('/local/news/form.php', array('id'=>$article->id, 'action'=>'edit'));
      $link_delete = new moodle_url('/local/news/form.php', array('id'=>$article->id, 'action'=>'delete'));
      $article->link_edit = str_replace("&amp;", "&", $link_edit->__toString());
      $article->link_delete = str_replace("&amp;", "&", $link_delete->__toString());
      $article->timemodified = date('m/d/Y', $article->timemodified);
    }

    $link_add = new moodle_url('/local/news/form.php');
    $templatecontext = (object)[
        'news' => array_values($news),
        'form_link' => $link_add->__toString(),
    ];

    // Prepare the page.
    $title = get_string('newslist', 'local_news');
    $PAGE->set_title($title);
    $PAGE->set_heading('Text');

    echo $OUTPUT->header();
    echo $OUTPUT->heading($title);
    echo $OUTPUT->render_from_template('local_news/list', $templatecontext);
    echo $OUTPUT->footer();
?>
