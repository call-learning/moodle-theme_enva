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
 * Course index cm component.
 *
 * This component is used to control specific course modules interactions like drag and drop.
 *
 * There is an issue with scrollIntoView method in the original file, so we need to override it.
 *
 * @module     core_courseformat/local/courseindex/cm
 * @class      core_courseformat/local/courseindex/cm
 * @copyright  2021 Ferran Recio <ferran@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import Cm from 'core_courseformat/local/courseindex/cm';

export default class Component extends Cm {
    /**
     * Handle a page item update.
     *
     * @param {Object} details the update details
     * @param {Object} details.element the course state data.
     */
    _refreshPageItem({element}) {
        if (!element.pageItem) {
            return;
        }
        const isPageId = (element.pageItem.type == 'cm' && element.pageItem.id == this.id);
        this.element.classList.toggle(this.classes.PAGEITEM, isPageId);
    }
}
