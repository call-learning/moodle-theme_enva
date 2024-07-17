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

namespace theme_enva\form;

use context;
use context_system;
use context_user;
use core_form\dynamic_form;
use moodle_exception;
use moodle_url;

/**
 * Class gradingform
 *
 * @package    theme_enva
 * @copyright  2024 Bas Brands <bas@sonsbeekmedia.nl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class carouselconfig extends dynamic_form {
    /**
     * Process the form submission
     *
     * @return array
     * @throws moodle_exception
     */
    public function process_dynamic_submission(): array {
        global $USER;
        $this->check_access_for_dynamic_submission();
        $context = $this->get_context_for_dynamic_submission();
        $data = $this->get_data();

        // Get the file and create the content based on it.
        $usercontext = context_user::instance($USER->id);
        $fs = get_file_storage();
        $slides = $this->optional_param('numberofslides', 4, PARAM_INT);

        for ($i = 1; $i <= $slides; $i++) {
            $fileid = $data->{"image{$i}"};
            $files = $fs->get_area_files($usercontext->id, 'user', 'draft', $fileid, 'itemid, filepath,
                filename', false);
            if (!empty($files)) {
                $file = reset($files);
                // First clear out the old file.
                $fs->delete_area_files($context->id, 'theme_enva', 'carousel', $i);
                // Copy the file the the theme images folder.
                $newfile = $fs->create_file_from_storedfile([
                    'contextid' => $context->id,
                    'component' => 'theme_enva',
                    'filearea' => 'carousel',
                    'itemid' => $i,
                    'filepath' => '/',
                    'filename' => $file->get_filename(),
                ], $file);
            }
        }
        // JSON encode the data and save it to the theme settings.
        $data = json_encode($data);
        set_config('carouselconfig', $data, 'theme_enva');
        return [
            'result' => true,
        ];
    }

    /**
     * Get context
     *
     * @return context
     */
    protected function get_context_for_dynamic_submission(): context {
        $context = context_system::instance();
        return $context;
    }

    /**
     * TODO, find a better capability
     *
     * @return void
     * @throws moodle_exception
     */
    protected function check_access_for_dynamic_submission(): void {
        if (!has_capability('moodle/course:manageactivities', $this->get_context_for_dynamic_submission())) {
            throw new moodle_exception('invalidaccess');
        }
    }

    /**
     * Get page URL
     *
     * @return moodle_url
     */
    protected function get_page_url_for_dynamic_submission(): moodle_url {
        $courseid = $this->optional_param('courseid', null, PARAM_INT);
        return new moodle_url('/course/view.php', ['id' => $courseid, 'return' => true]);
    }

    /**
     * Form definition
     *
     * @return void
     */
    protected function definition() {
        $mform =& $this->_form;
        $this->set_display_vertical();
        $imageoptions = array('maxbytes' => 262144, 'accepted_types' => ['optimised_image']);

        $slides = $this->optional_param('numberofslides', 6, PARAM_INT);

        $mform->addElement('checkbox', "carouselenabled", get_string('carouselenabled', 'theme_enva'),
        get_string('carouselslideactive', 'theme_enva'));

        for ($i = 1; $i <= $slides; $i++) {
            $mform->addElement('header', "slide{$i}", get_string('carouselslide', 'theme_enva', $i));
            $mform->addElement('text', "title{$i}", get_string('carouseltitle', 'theme_enva', $i));
            $mform->addElement('checkbox', "active{$i}", get_string('carouselslideactivedesc', 'theme_enva'),
                get_string('carouselslideactive', 'theme_enva'));
            $mform->addElement('editor', "text{$i}", get_string('carouseltext', 'theme_enva', $i));
            $mform->disabledIf("text{$i}", "active{$i}", 'notchecked');
            $mform->addElement('static', "currentimage{$i}", get_string('carouselimage', 'theme_enva', $i), "");
            $mform->addElement('filepicker', "image{$i}", $str, null, $imageoptions);
            $mform->disabledIf("image{$i}", "active{$i}", 'notchecked');
            $str = get_string('carouselimage', 'theme_enva', $i);
            $mform->addElement('text', "link{$i}", get_string('carousellink', 'theme_enva', $i));
            $mform->setType("link{$i}", PARAM_URL);
            $mform->disabledIf("link{$i}", "active{$i}", 'notchecked');
            $mform->setDefault("link{$i}", 'https://www.vet-alfort.fr');
        }
    }

    public function set_data_for_dynamic_submission(): void {
        $data = get_config('theme_enva', 'carouselconfig');
        $data = json_decode($data);
        $context = $this->get_context_for_dynamic_submission();

        $fs = get_file_storage();

        // Do the same for the other images using a loop.
        for ($i = 1; $i <= 6; $i++) {
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
                $data->{"currentimage{$i}"} = \html_writer::img($imageurl->out(), 'My image', ['class' => 'img-responsive']);
            }
        }
        parent::set_data((object) $data);
    }
}
