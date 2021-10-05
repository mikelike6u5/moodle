<?php
    // Include config.php.
    require(__DIR__ . '/../../config.php');

    // Globals.
    global $DB;

    // Include adminlib.php.
    require_once($CFG->libdir.'/adminlib.php');
    // Set up external admin page.
    admin_externalpage_setup('local_news_list');

    // Prepare data
    $news = $DB->get_records('local_news');

    foreach ($news as &$article) {
      $link_edit = new moodle_url('/local/news/form.php', array('id'=>$article->id, 'action'=>'edit'));
      $link_delete = new moodle_url('/local/news/form.php', array('id'=>$article->id, 'action'=>'delete'));
      $article->link_edit = str_replace("&amp;", "&", $link_edit->__toString());
      $article->link_delete = str_replace("&amp;", "&", $link_delete->__toString());
    }

    $templatecontext = (object)[
        'news' => array_values($news),
    ];

    // Prepare page.
    $title = get_string('newslist', 'local_news');
    $PAGE->set_title($title);
    $PAGE->set_heading($title);

    echo $OUTPUT->header();
    echo $OUTPUT->heading($title);
    echo $OUTPUT->render_from_template('local_news/list', $templatecontext);
    echo $OUTPUT->footer();
?>
