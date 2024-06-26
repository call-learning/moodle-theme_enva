<?php
// This file is part of the enva theme for Moodle
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
 * A wrapper round Moodle's settings API.
 *
 * Assumes all strings are in the theme lang file, assumes the title
 * langstring is the same as the name, and that the description langstring
 * is the same as the title with 'desc' added to the end.
 *
 * @package    theme_enva
 * @copyright  2024 Bas Brands, www.basbrands.nl
 * @author     Bas Brands, David Scotson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Simple theme settings class.
 *
 * @package    theme_enva
 * @copyright  2024 Bas Brands, www.basbrands.nl
 * @author     Bas Brands, David Scotson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class enva_simple_theme_settings {
    /**
     * @var string themename.
     */
    private $themename;


    /**
     * @var object settingspage.
     */
    public $settingspage;

    /**
     * Initialise this class.
     *
     * @param object $settingspage
     * @param object $themename
     */
    public function __construct($settingspage, $themename) {
        $this->themename = $themename;
        $this->settingspage = $settingspage;
    }

    /**
     * Name for settings.
     *
     * @param string $setting
     * @param string $suffix
     *
     * @return string settingsname.
     */
    private function name_for($setting, $suffix='') {
        return $this->themename.'/'.$setting.$suffix;
    }

    /**
     * Get string for this setting.
     *
     * @param string $setting
     * @param string $additional
     *
     * @return string string
     */
    private function title_for($setting, $additional = null) {
        return get_string($setting, $this->themename, $additional);
    }

    /**
     * Get description string for this setting.
     *
     * @param string $setting
     *
     * @return string description string.
     */
    private function description_for($setting) {
        return get_string($setting.'desc', $this->themename);
    }

    /**
     * Add a checkbox.
     *
     * @param mixed $setting
     * @param mixed $default
     * @param mixed $checked
     * @param mixed $unchecked
     *
     */
    public function add_checkbox($setting, $default='0', $checked='1', $unchecked='0') {
        $checkbox = new admin_setting_configcheckbox(
            $this->name_for($setting),
            $this->title_for($setting),
            $this->description_for($setting),
            $default,
            $checked,
            $unchecked
        );
        $checkbox->set_updatedcallback('theme_reset_all_caches');
        $this->settingspage->add($checkbox);
    }

    /**
     * Add multi checkboxes.
     *
     * @param mixed $setting
     * @param mixed $instance
     * @param mixed $default
     * @param mixed $checked
     * @param mixed $unchecked
     */
    public function add_checkboxes($setting, $instance, $default='0', $checked='1', $unchecked='0') {
        $checkbox = new admin_setting_configcheckbox(
            $this->name_for($setting . $instance),
            $this->title_for($setting, $instance),
            $this->description_for($setting),
            $default,
            $checked,
            $unchecked
        );
        $checkbox->set_updatedcallback('theme_reset_all_caches');
        $this->settingspage->add($checkbox);
    }

    /**
     * Add text.
     *
     * @param mixed $setting
     * @param mixed $default
     */
    public function add_text($setting, $default='') {
        $text = new admin_setting_configtext(
            $this->name_for($setting),
            $this->title_for($setting),
            $this->description_for($setting),
            $default
        );
        $text->set_updatedcallback('theme_reset_all_caches');
        $this->settingspage->add($text);
    }

    /**
     * Add texts.
     *
     * @param mixed $setting
     * @param mixed $instance
     * @param mixed $default
     */
    public function add_texts($setting, $instance, $default='') {
        $text = new admin_setting_configtext(
            $this->name_for($setting . $instance),
            $this->title_for($setting, $instance),
            $this->description_for($setting),
            $default
        );
        $text->set_updatedcallback('theme_reset_all_caches');
        $this->settingspage->add($text);
    }

    /**
     * Add a heading.
     *
     * @param mixed $setting
     * @param string $information The additional info to show below the header.
     */
    public function add_heading($setting, $information) {
        $heading = new admin_setting_heading(
            $this->name_for($setting),
            $this->title_for($setting),
            $information
        );
        $this->settingspage->add($heading);
    }

    /**
     * Add multiple headings.
     *
     * @param mixed $setting
     * @param mixed $instance
     */
    public function add_headings($setting, $instance) {
        $heading = new admin_setting_heading(
            $this->name_for($setting . $instance),
            $this->title_for($setting, $instance),
            $this->description_for($setting)
        );
        $this->settingspage->add($heading);
    }

    /**
     * Add multiple files.
     *
     * @param mixed $setting
     * @param mixed $instance
     */
    public function add_files($setting, $instance) {
        $file = new admin_setting_configstoredfile(
            $this->name_for($setting . $instance),
            $this->title_for($setting, $instance),
            $this->description_for($setting),
            $setting . $instance
        );
        $file->set_updatedcallback('theme_reset_all_caches');
        $this->settingspage->add($file);
    }

    /**
     * Add a select.
     *
     * @param mixed $setting
     * @param mixed $default
     * @param mixed $options
     */
    public function add_select($setting, $default, $options) {
        $select = new admin_setting_configselect(
            $this->name_for($setting),
            $this->title_for($setting),
            $this->description_for($setting),
            $default,
            $options
        );
        $select->set_updatedcallback('theme_reset_all_caches');
        $this->settingspage->add($select);
    }

    /**
     * Add a text area.
     *
     * @param mixed $setting
     * @param mixed $default
     */
    public function add_textarea($setting, $default='') {
        $textarea = new admin_setting_configtextarea(
            $this->name_for($setting),
            $this->title_for($setting),
            $this->description_for($setting),
            $default
        );
        $textarea->set_updatedcallback('theme_reset_all_caches');
        $this->settingspage->add($textarea);
    }

    /**
     * Add mulitple textareas.
     *
     * @param mixed $setting
     * @param mixed $instance
     * @param mixed $default
     */
    public function add_textareas($setting, $instance, $default='') {
        $textarea = new admin_setting_configtextarea(
            $this->name_for($setting . $instance),
            $this->title_for($setting, $instance),
            $this->description_for($setting),
            $default
        );
        $textarea->set_updatedcallback('theme_reset_all_caches');
        $this->settingspage->add($textarea);
    }

    /**
     * Add a HTML editor.
     *
     * @param mixed $setting
     * @param mixed $default
     */
    public function add_htmleditor($setting, $default='') {
        $htmleditor = new admin_setting_confightmleditor(
            $this->name_for($setting),
            $this->title_for($setting),
            $this->description_for($setting),
            $default
        );
        $htmleditor->set_updatedcallback('theme_reset_all_caches');
        $this->settingspage->add($htmleditor);
    }

    /**
     * Add a colourpicker.
     *
     * @param mixed $setting
     * @param mixed $default
     */
    public function add_colourpicker($setting, $default='#666') {
        $colorpicker = new admin_setting_configcolourpicker(
            $this->name_for($setting),
            $this->title_for($setting),
            $this->description_for($setting),
            $default,
            null // Don't hook up any javascript preview of color change.
        );
        $colorpicker->set_updatedcallback('theme_reset_all_caches');
        $this->settingspage->add($colorpicker);
    }

    /**
     * Add multiple colour pickers.
     *
     * @param mixed $setting
     * @param mixed $instance
     * @param mixed $default
     */
    public function add_colourpickers($setting, $instance, $default='#666') {
        $colorpicker = new admin_setting_configcolourpicker(
            $this->name_for($setting . $instance),
            $this->title_for($setting, $instance),
            $this->description_for($setting),
            $default,
            null // Don't hook up any javascript preview of color change.
        );
        $colorpicker->set_updatedcallback('theme_reset_all_caches');
        return $colorpicker;
    }

    /**
     * Add a file.
     *
     * @param mixed $setting
     */
    public function add_file($setting) {
        $file = new admin_setting_configstoredfile(
            $this->name_for($setting),
            $this->title_for($setting),
            $this->description_for($setting),
            $setting
        );
        $file->set_updatedcallback('theme_reset_all_caches');
        $this->settingspage->add($file);
    }

    /**
     * Add numbered textareas.
     *
     * @param mixed $setting
     * @param mixed $count
     * @param mixed $default
     */
    public function add_numbered_textareas($setting, $count, $default='') {
        for ($i = 1; $i <= $count; $i++) {
            $textarea = new admin_setting_configtextarea(
                $this->name_for($setting, $i),
                $this->title_for($setting, $i),
                $this->description_for($setting),
                $default
            );
            $textarea->set_updatedcallback('theme_reset_all_caches');
            $this->settingspage->add($textarea);
        }
    }
}
