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
 * Plugin administration pages are defined here.
 *
 * @package     local_news
 * @category    admin
 * @copyright   likemike834@gmail.com
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
$capabilityrequiredforconfig = 'moodle/site:config';

if ($hassiteconfig) {
    // Create new administration category for news plugin.
    $ADMIN->add('root', new admin_category('local_news', 'News'));

    // Create new external news list page.
    $page = new admin_externalpage('local_news_list',
            get_string('newslist', 'local_news'),
            new moodle_url('/local/news/settings_list.php'),
            $capabilityrequiredforconfig);

    // Add pagelist page to navigation category.
    $ADMIN->add('local_news', $page);
}
