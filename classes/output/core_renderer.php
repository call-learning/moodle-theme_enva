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
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_enva
 * @copyright  2024 Bas Brands <bas@sonsbeekmedia.nl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_enva\output;

use html_writer;
use moodle_url;
use core_course_list_element;
use theme_config;
use context_system;
use stdClass;
use user_picture;

/**
 * Theme renderer
 *
 * @package    theme_enva
 * @copyright  2024 Bas Brands <bas@sonsbeekmedia.nl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_renderer extends \theme_boost\output\core_renderer {

    /**
     * Get the current time, used for cache busting
     * @return int
     */
    public function get_time() {
        return time();
    }

    /**
     * Get the root URL of Moodle
     */
    public function root_url() {
        return new moodle_url('/');
    }

    /**
     * Are we debugging?
     */
    public function debugging() {
        global $CFG;
        return isset($CFG->debugdeveloper);
    }

    /**
     * Show the login form
     */
    public function show_login() {
        if (!isloggedin() or isguestuser()) {
            return true;
        }
        return false;
    }

    /**
     * Get the login token
     */
    public function login_token() {
        return \core\session\manager::get_login_token();
    }

    /**
     * Render the frontpage widgets
     * @return string HTML
     */
    public function frontpage_widgets() {
        $content = '';
        $content .= $this->frontpage_slideshow();
        return $content;
    }

    /**
     * Get slideshow configuration
     * @return array Slides
     */
    private function slideshow_configuration() {
        $data = get_config('theme_enva', 'carouselconfig');
        $context = context_system::instance();

        $fs = get_file_storage();
        $slides = [];
        if ($data = json_decode($data)) {
            if (!isset($data->carouselenabled) || !$data->carouselenabled == 1) {
                return [];
            }
            for ($i = 1; $i <= 6; $i++) {
                if (!isset($data->{"active{$i}"})) {
                    continue;
                }
                $title = $data->{"title{$i}"};
                $link = $data->{"link{$i}"};
                $image = $data->{"image{$i}"};
                $text = $data->{"text{$i}"};
                $imageurl = '';

                $files = $fs->get_area_files($context->id, 'theme_enva', 'carousel', $i, 'itemid, filepath,
                filename', false);
                if (!empty($files)) {
                    $image = reset($files);
                    $imageurl = moodle_url::make_pluginfile_url(
                        $image->get_contextid(),
                        $image->get_component(),
                        $image->get_filearea(),
                        $image->get_itemid(),
                        $image->get_filepath(),
                        $image->get_filename()
                    );
                    $imageurl = $imageurl->out();
                }
                $slides[] = [
                    "title" => $title,
                    "link" => $link,
                    "imageurl" => $imageurl,
                    "text" => format_text($text->text, $text->format),
                ];
            }
        }
        return $slides;
    }

    /**
     * Render the frontpage slideshow
     */
    public function frontpage_slideshow() {
        global $PAGE;
        $configuration = $this->slideshow_configuration();
        $enabled = false;
        if (!empty($configuration)) {
            $enabled = true;
        }
        $templatecontext = [
            "editing" => false,
            "enabled" => $enabled,
            "imagepath" => new moodle_url('/theme/enva/pix/slideshow/'),
            "slides" => $configuration,
        ];
        if ($PAGE->user_is_editing()) {
            $templatecontext["editing"] = true;
        }

        return $this->render_from_template('theme_enva/components/slideshow', $templatecontext);
    }

    /**
     * Override the core user_picture to force using a larger image on the frontpage
     * @param stdClass $user
     * @param array $options
     * @return string
     */
    // public function user_picture(stdClass $user, array $options = null) {
    //     global $PAGE;
    //     if ($PAGE->pagelayout == 'frontpage' ) {
    //         $options['size'] = 100;
    //     }
    //     $userpicture = new user_picture($user);
    //     foreach ((array)$options as $key=>$value) {
    //         if (property_exists($userpicture, $key)) {
    //             $userpicture->$key = $value;
    //         }
    //     }
    //     return $this->render($userpicture);
    // }
}
