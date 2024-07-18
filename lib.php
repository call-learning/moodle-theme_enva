<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Callbacks
 *
 * @package     theme_enva
 * @copyright   2024 Bas Brands <bas@sonsbeekmedia.nl>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


function theme_enva_page_init(moodle_page $page) {
    $page->requires->jquery();
	if ($page->pagelayout === 'frontpage') {
        $page->requires->jquery_plugin('jquery.easing.min.1.4', 'theme_enva');
        $page->requires->jquery_plugin('slideshow', 'theme_enva');
        $page->requires->jquery_plugin('carousel', 'theme_enva');
    }
}

/**
 * Implementation of $THEME->scss
 *
 * @param theme_config $theme
 * @return string
 */
function theme_enva_get_main_scss_content($theme) {
    global $CFG;
    // if (isset($CFG->debugdeveloper)) {
    //     return '';
    // }
    $scss = '';
     // Sets the login background image.
    $loginbackgroundurl = $theme->setting_file_url('loginbackground', 'loginbackground');
    if (!empty($loginbackgroundurl)) {
        $scss .= 'body#page-login-index #page, body#page-login-signup #page { ';
        $scss .= "background-image: url('$loginbackgroundurl');";
        $scss .= ' }';
    }

    $scss .= file_get_contents($CFG->dirroot . '/theme/enva/scss/default.scss');
    return $scss;
}

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_enva_get_extra_scss($theme) {
    return !empty($theme->settings->scss) ? $theme->settings->scss : '';
}


/**
 * Get files related to the enva theme.
 *
 * @param mixed $course
 * @param mixed $cm
 * @param mixed $context
 * @param mixed $filearea
 * @param mixed $args
 * @param mixed $forcedownload
 * @param array $options
 *
 * @return string file url.
 */
function theme_enva_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        $theme = theme_config::load('enva');
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        if ($filearea === 'loginbackground') {
            return $theme->setting_file_serve('loginbackground', $args, $forcedownload, $options);
        }
        if ($filearea === 'carousel') {
            $itemid = array_shift($args);

            $fs = get_file_storage();
            $files = $fs->get_area_files($context->id, 'theme_enva', 'carousel', $itemid, 'itemid', false);
            send_stored_file(reset($files), 'default', 0, $forcedownload, $options);
        }
    } else {
        send_file_not_found();
    }
}

/**
 * Get compiled css.
 *
 * @return string compiled css
 */
function theme_enva_get_precompiled_css() {
    global $CFG;
    return file_get_contents($CFG->dirroot . '/theme/enva/style/moodle.css');
}

