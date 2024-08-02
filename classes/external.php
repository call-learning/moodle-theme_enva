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
 * External API.
 *
 * @package   theme_enva
 * @copyright 2024 Bas Brands
 * @author    Bas Brands
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_enva;

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/externallib.php");

use \core_external\external_api;
use \core_external\external_function_parameters;
use \core_external\external_value;
use \core_external\external_single_structure;
use \theme_enva\imagehandler;
use \core\context;

/**
 * External API class.
 *
 * @package    theme_enva
 * @copyright  2024 Bas Brands
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external extends external_api {

    /**
     * Description of the parameters suitable for the `update_image` function.
     *
     * @return external_function_parameters
     */
    public static function update_image_parameters(): external_function_parameters {
        $parameters = [
            'params' => new external_single_structure([
                'imagedata' => new external_value(PARAM_TEXT, 'Image data', VALUE_REQUIRED),
                'imagefilename' => new external_value(PARAM_TEXT, 'Image filename', VALUE_REQUIRED),
                'filearea' => new external_value(PARAM_AREA, 'File area', VALUE_REQUIRED),
                'contextid' => new external_value(PARAM_INT, 'Contextid', VALUE_REQUIRED),
            ], 'Params wrapper - just here to accommodate optional values', VALUE_REQUIRED)
        ];
        return new external_function_parameters($parameters);
    }

    /**
     * Save the image and return any warnings and the new image url
     *
     * @param   string $params parameters for saving the image
     * @return  array the save image return values
     */
    public static function update_image($params): array {
        $params = self::validate_parameters(self::update_image_parameters(), ['params' => $params])['params'];

        $filearea = $params['filearea'];
        $contextid = $params['contextid'];
        $filename = $params['imagefilename'];

        $context = context::instance_by_id($contextid);
        self::validate_context($context);
        $binary = base64_decode($params['imagedata']);

        $success = false;
        $fileurl = false;
        $warning = false;

        $warning = \theme_enva\imagehandler::store($contextid, $filearea, $filename, $binary);
        $fileurl = \theme_enva\imagehandler::get_image_url($contextid, $filearea);

        if (!empty($fileurl)) {
            $success = true;
        }

        return ['success' => $success, 'fileurl' => $fileurl, 'warning' => $warning];
    }

    /**
     * Description of the return value for the `update_image` function.
     *
     * @return external_single_structure
     */
    public static function update_image_returns(): external_single_structure {
        $keys = [
            'success' => new external_value(PARAM_BOOL, 'Was the image successfully changed', VALUE_REQUIRED),
            'warning' => new external_value(PARAM_TEXT, 'Warning', VALUE_OPTIONAL),
            'fileurl' => new external_value(PARAM_URL, 'New file url', VALUE_REQUIRED)
        ];

        return new external_single_structure($keys, 'coverimage');
    }

    /**
     * Description of the parameters suitable for the `delete_image` function.
     *
     * @return external_function_parameters
     */
    public static function delete_image_parameters(): external_function_parameters {
        $parameters = [
            'params' => new external_single_structure([
                'contextid' => new external_value(PARAM_INT, 'Contextid', VALUE_REQUIRED),
                'filearea' => new external_value(PARAM_AREA, 'File area', VALUE_REQUIRED),
            ], 'Params wrapper - just here to accommodate optional values', VALUE_REQUIRED)
        ];
        return new external_function_parameters($parameters);
    }

    /**
     * Save the image and return any warnings and the new image url
     *
     * @param   string $params parameters for saving the image
     * @return  array the save image return values
     */
    public static function delete_image($params): array {
        global $USER;

        $params = self::validate_parameters(self::delete_image_parameters(), ['params' => $params])['params'];

        $contextid = $params['contextid'];
        $draftitemid = $params['draftitemid'];
        $filearea = $params['filearea'];

        $context = context::instance_by_id($contextid);
        self::validate_context($context);

        $success = false;
        $warning = false;

        $warning = imagehandler::delete($contextid, $filearea);

        return ['success' => $success, 'warning' => $warning];
    }

    /**
     * Description of the return value for the `update_image` function.
     *
     * @return external_single_structure
     */
    public static function delete_image_returns(): external_single_structure {
        $keys = [
            'success' => new external_value(PARAM_BOOL, 'Was the image successfully deleted', VALUE_REQUIRED),
        ];

        return new external_single_structure($keys, 'coverimage');
    }

    /**
     * Description of the parameters suitable for the `imagealt` function.
     *
     * @return external_function_parameters
     */
    public static function imagealt_parameters(): external_function_parameters {
        $parameters = [
            'params' => new external_single_structure([
                'contextid' => new external_value(PARAM_INT, 'Contextid', VALUE_REQUIRED),
                'alt' => new external_value(PARAM_TEXT, 'Alt text', VALUE_REQUIRED),
            ], 'Params wrapper - just here to accommodate optional values', VALUE_REQUIRED)
        ];
        return new external_function_parameters($parameters);
    }

    /**
     * Save the image alt text and return any warnings.
     *
     * @param   string $params parameters for saving the image
     * @return  array the save image return values
     */
    public static function imagealt(): array {
        global $USER;

        $params = self::validate_parameters(self::imagealt_parameters(), ['params' => $params])['params'];

        $contextid = $params['contextid'];
        $alt = $params['alt'];

        $context = context::instance_by_id($contextid);
        self::validate_context($context);

        $success = false;
        $warning = false;

        $warning = imagehandler::alt($contextid, $alt);
        if (empty($warning)) {
            $success = true;
        }

        return ['success' => $success, 'warning' => $warning];
    }

    /**
     * Description of the return value for the `update_image` function.
     *
     * @return external_single_structure
     */
    public static function imagealt_returns(): external_single_structure {
        $keys = [
            'success' => new external_value(PARAM_BOOL, 'Was the image alt text successfully changed', VALUE_REQUIRED),
            'warning' => new external_value(PARAM_TEXT, 'Warning', VALUE_OPTIONAL),
        ];

        return new external_single_structure($keys, 'imagealt');
    }
}
