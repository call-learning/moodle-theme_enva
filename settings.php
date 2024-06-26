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
 * Theme enva settings file.
 *
 * @package    theme_enva
 * @copyright  2024 Bas Brands
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

require_once(__DIR__ . "/simple_theme_settings.class.php");

if ($ADMIN->fulltree) {

    $settings = new theme_boost_admin_settingspage_tabs('themesettingenva', get_string('configtitle', 'theme_boost'));
    $page = new admin_settingpage('theme_enva_general', get_string('generalsettings', 'theme_boost'));

    $ss = new enva_simple_theme_settings($page, 'theme_enva');

    $ss->add_file('loginbackground');

    $ss->add_textarea('scss');

    $settings->add($ss->settingspage);

}
