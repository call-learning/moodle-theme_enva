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

namespace theme_enva;

use moodle_url;
use \core\context as context;
use \core\context_course as context_course;

/**
 * Class mod_teachingtools/imagehandler for the image_editable output component.
 *
 * @package    theme_enva
 * @copyright  2024 Bas Brands <bas@sonsbeekmedia.nl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class imagehandler {

    /**
     * Check permissions for storing the image.
     *
     * @param int $contextid The contextid.
     */
    private static function check_permissions(int $contextid): void {
        $context = context::instance_by_id($contextid);
        require_capability('moodle/course:update', $context);
    }

    /**
     * Process the image and return the new image URL.
     *
     * @param int $contextid The course context id.
     * @param string $filearea The filearea where this image should be stored.
     * @param string $filename The image file name.
     * @param string $binary The image binary data.
     */
    public static function store(int $contextid, string $filearea, string $filename, string $binary): void {

        $context = context::instance_by_id($contextid);
        self::check_permissions($contextid);

        $fs = get_file_storage();

        self::delete($contextid, $filearea);
        $newimage = [
            'contextid' => $context->id,
            'component' => 'course',
            'filearea' => $filearea,
            'itemid' => 0,
            'filepath' => '/',
            'filename' => $filename
        ];
        $fs->create_file_from_string($newimage, $binary);
    }

    /**
     * Get the image URL.
     */
    public static function get_image_url(int $contextid, string $filearea): string {
        $fs = get_file_storage();
        $files = $fs->get_area_files($contextid, 'course', $filearea);
        foreach ($files as $file) {
            if ($file->is_valid_image()) {
                return moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(),
                    $file->get_filearea(), null, $file->get_filepath(), $file->get_filename());
            }
        }
        return '';
    }

    /**
     * Delete the image
     *
     * @param int $contextid The course context id.
     * @param string $filearea The filearea for this file.
     */
    public static function delete(int $contextid, string $filearea): void {

        self::check_permissions($contextid);
        $fs = get_file_storage();

        foreach ($fs->get_area_files($contextid, 'course', $filearea) as $deletefile) {
            if ($deletefile->is_valid_image()) {
                $deletefile->delete();
            }
        }
    }

    /**
     * Set the image alt text.
     * This sets the image alt text for the image using the subtitle field in table mld_customfield_data.
     * @param int $courseid The course id.
     * @param string $alt The alt text.
     * @return string The result of the operation.
     */
    public static function alt(int $courseid, string $alt): string {
        global $DB;

        $context = context_course::instance($courseid);
        self::check_permissions($context->id);

        $field = $DB->get_record('customfield_field', ['shortname' => 'subtitle']);
        if (!$field) {
            return 'Field not found';
        }

        $customdata = $DB->get_record('customfield_data', ['contextid' => $context->id, 'fieldid' => $field->id]);
        if ($customdata) {
            $customdata->charvalue = $alt;
            $customdata->value = $alt;
            $customdata->timemodified = time();
            $DB->update_record('customfield_data', $customdata);
        } else {
            $customdata = new \stdClass();
            $customdata->contextid = $context->id;
            $customdata->instanceid = $context->instanceid;
            $customdata->fieldid = $field->id;
            $customdata->charvalue = $alt;
            $customdata->value = $alt;
            $customdata->valueformat = 0;
            $customdata->timecreated = time();
            $customdata->timemodified = time();
            $DB->insert_record('customfield_data', $customdata);
        }
        return 'OK';
    }
}
