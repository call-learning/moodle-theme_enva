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
 * TODO describe module button_injector
 *
 * @module     theme_enva/carouselconfig
 * @copyright  2024 Bas Brands <bas@sonsbeekmedia.nl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import ModalForm from 'core_form/modalform';
import {get_string as getString} from 'core/str';

export const init = async() => {
    const editButton = document.querySelector('[data-action="editcarousel"]');
    if (!editButton) {
        return;
    }
    const onSubmitHandler = () => {
        window.location.reload();
    };
    editButton.addEventListener('click', async() => {
        const modalForm = new ModalForm({
            modalConfig: {
                title: getString('carouselconfig', 'theme_enva'),
                classes: 'carousel-modal',
                classlist: ['carousel-modal'],
            },
            formClass: 'theme_enva\\form\\carouselconfig',
            args: {
                courseid: editButton.dataset.courseid,
            },
            saveButtonText: getString('save'),
        });
        modalForm.addEventListener(modalForm.events.FORM_SUBMITTED, onSubmitHandler);

        await modalForm.show();
    });
};
