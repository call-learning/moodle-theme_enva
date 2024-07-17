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
 TODO describe module scroller
 *
 * @module     theme_enva/drawerhelper
 * @copyright  2024 Bas Brands <bas@sonsbeekmedia.nl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import Drawers from 'theme_boost/drawers';

export const init = () => {
    const drawerRight = document.querySelector('.drawer-right');
    if (!drawerRight) {
        return;
    }
    drawerRight.addEventListener(Drawers.eventTypes.drawerShow, () => {
        // The drawer which will be shown.
        const container = document.querySelector('[date-region="drawers-container"]');
        container.classList.add('drawer-open');
    });
    drawerRight.addEventListener(Drawers.eventTypes.drawerHide, () => {
        // The drawer which will be hidden.
        const container = document.querySelector('[date-region="drawers-container"]');
        container.classList.remove('drawer-open');
    });
};