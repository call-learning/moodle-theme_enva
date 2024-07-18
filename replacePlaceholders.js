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
const fs = require('fs');
const path = require('path');

// Define the replacement function
function replacePlaceholders(content) {
    const placeholderPattern = /\[\[font:core\|([^\]]+)\]\]/g;
    return content.replace(placeholderPattern, (match, p1) => {
        // Construct the replacement path
        const replacementPath = `/compet/lib/fonts/${p1}`;
        return replacementPath;
    });
}

// Read the CSS file
const cssFilePath = path.join(__dirname, 'styles/dev.css');
let cssContent = fs.readFileSync(cssFilePath, 'utf8');

// Replace placeholders with actual paths
cssContent = replacePlaceholders(cssContent);

// Write the updated CSS content back to the file
fs.writeFileSync(cssFilePath, cssContent, 'utf8');
