<?php
    // Include config.php.
    require(__DIR__ . '/../../config.php');

    // Globals.
    //global $CFG, $PAGE, $OUTPUT;

    // Include adminlib.php.
    require_once($CFG->libdir.'/adminlib.php');

    // Set up external admin page.
    admin_externalpage_setup('local_news_list');

    // Prepare page.
    $title = get_string('newslist', 'local_news');
    $PAGE->set_title($title);
    $PAGE->set_heading($title);

    echo $OUTPUT->header();
    echo $OUTPUT->heading($title);
    echo $OUTPUT->footer();
?>
