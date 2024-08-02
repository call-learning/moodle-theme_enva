<?php
// This file is part of the Local Analytics plugin for Moodle
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
 * Theme Academylite external functions and service definitions.
 *
 * This plugin adds a feedback button to any Moodle page.
 *
 * @package   theme_enva
 * @copyright 2024 Bas Brands
 * @author    Bas Brands
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = array(
    'theme_enva_update_image' => array(
        'classname'     => 'theme_enva\external',
        'methodname'    => 'update_image',
        'description'   => 'Update image',
        'type'          => 'write',
        'loginrequired' => true,
        'ajax'          => true,
    ),
    'theme_enva_delete_image' => array(
        'classname'     => 'theme_enva\external',
        'methodname'    => 'delete_image',
        'description'   => 'Delete image',
        'type'          => 'write',
        'loginrequired' => true,
        'ajax'          => true,
    ),
    'theme_enva_imagealt' => array(
        'classname'     => 'theme_enva\external',
        'methodname'    => 'imagealt',
        'description'   => 'Image alt',
        'type'          => 'write',
        'loginrequired' => true,
        'ajax'          => true,
    ),
);
