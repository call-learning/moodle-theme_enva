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
 * Adding resize option to theme academylite.
 *
 * @module     theme_enva/imageeditable
 * @copyright  2024 Bas Brands
 * @author     Bas Brands
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import {get_string as getString} from 'core/str';
import Notification from 'core/notification';
import imageHandler from 'theme_enva/imagehandler';


/**
 * The init function for the image editable.
 *
 * Editable images are wrapped in a div with region="imageeditable" and a data-contextid attribute.
 * If the user is editing the page, a file upload button is added to the div.
 * On click the user can browse for an image and upload it.
 * The image is then displayed in the div.
 */
export const init = () => {
    const editableImages = document.querySelectorAll('[data-region="imageeditable"]');
    editableImages.forEach((editableImage) => {
        const contextId = editableImage.getAttribute('data-contextid');
        const image = editableImage.querySelector('img');

        const fileInput = document.createElement('input');
        fileInput.setAttribute('type', 'file');
        fileInput.setAttribute('accept', 'image/*');
        fileInput.setAttribute('class', 'hidden');

        const imageUploadButton = document.createElement('button');
        imageUploadButton.setAttribute('type', 'button');
        imageUploadButton.classList.add('btn', 'btn-secondary', 'uploadbutton');

        const imageUploadIcon = document.createElement('i');
        imageUploadIcon.classList.add('fa', 'fa-upload');
        imageUploadButton.appendChild(imageUploadIcon);

        getString('uploadimage', 'theme_enva').then((string) => {
            const imageUploadText = document.createElement('span');
            imageUploadText.classList.add('sr-only');
            imageUploadText.innerHTML = string;
            imageUploadButton.appendChild(imageUploadText);
            return '';
        }).catch(Notification.exception);

        editableImage.appendChild(imageUploadButton);

        imageUploadButton.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.addEventListener('load', () => {
                imageHandler.saveImage(contextId, 'overviewfiles', file, reader.result).then((result) => {
                    if (result.success) {
                        image.setAttribute('src', result.fileurl);
                    }
                    return '';

                }).catch(Notification.exception);
            });
            reader.readAsDataURL(file);
        });
    });
};

