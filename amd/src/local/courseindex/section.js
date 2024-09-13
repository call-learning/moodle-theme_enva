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
 * Course index section component.
 *
 * This component is used to control specific course section interactions like drag and drop.
 * There is an issue with scrollIntoView method in the original file, so we need to override it.
 *
 * @module     core_courseformat/local/courseindex/section
 * @class      core_courseformat/local/courseindex/section
 * @copyright  2021 Ferran Recio <ferran@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import Section from 'core_courseformat/local/courseindex/section';

export default class Component extends Section {
    /**
     * Handle a page item update.
     *
     * @param {Object} details the update details
     * @param {Object} details.state the state data.
     * @param {Object} details.element the course state data.
     */
    _refreshPageItem({element, state}) {
        if (!element.pageItem) {
            return;
        }
        if (element.pageItem.sectionId !== this.id && this.isPageItem || element.pageItem.type !== 'section') {
            this.pageItem = false;
            this.getElement(this.selectors.SECTION_ITEM).classList.remove(this.classes.PAGEITEM);
            return;
        }
        const section = state.section.get(this.id);
        if (section.indexcollapsed && !element.pageItem?.isStatic) {
            this.pageItem = (element.pageItem?.sectionId == this.id);
        } else {
            this.pageItem = (element.pageItem.type == 'section' && element.pageItem.id == this.id);
        }
        const sectionItem = this.getElement(this.selectors.SECTION_ITEM);
        sectionItem.classList.toggle(this.classes.PAGEITEM, this.pageItem ?? false);
    }
}
