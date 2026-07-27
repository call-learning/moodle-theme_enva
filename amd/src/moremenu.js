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
 * TODO describe module moremenu
 *
 * @module     theme_enva/moremenu
 * @copyright  2024 Bas Brands <bas@sonsbeekmedia.nl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import menuNavigation from "core/menu_navigation";
/**
 * Moremenu selectors.
 */
const Selectors = {
    regions: {
        moredropdown: '[data-region="moredropdown"]',
        morebutton: '[data-region="morebutton"]'
    },
    classes: {
        dropdownitem: 'dropdown-item',
        dropdownmoremenu: 'dropdownmoremenu-enva',
        hidden: 'd-none',
        active: 'active',
        nav: 'nav',
        navlink: 'nav-link',
        observed: 'observed',
    },
    attributes: {
        menu: '[role="menu"]',
        menuitem: '[role="menuitem"]',
        dropdowntoggle: '[data-bs-toggle="dropdown"]'
    }
};

let isTabListMenu = false;

/**
 * Auto Collapse navigation items that wrap into a dropdown menu.
 *
 * @param {HTMLElement} menu The navbar container.
 */
const autoCollapse = menu => {

    const maxHeight = menu.parentNode.offsetHeight + 1;

    const moreDropdown = menu.querySelector(Selectors.regions.moredropdown);
    const moreButton = menu.querySelector(Selectors.regions.morebutton);

    // If the menu items wrap and the menu height is larger than the height of the
    // parent then start pushing navlinks into the moreDropdown.
    if (menu.offsetHeight > maxHeight) {
        moreButton.classList.remove(Selectors.classes.hidden);

        let menuHeight = 0;
        const menuNodes = Array.from(menu.children).reverse();
        menuNodes.forEach(item => {
            if (!item.classList.contains(Selectors.classes.dropdownmoremenu)) {
                // After moving the menu items into the moreDropdown check again
                // if the menu height is still larger then the height of the parent.
                if (menu.offsetHeight > maxHeight) {
                    // Move this node into the more dropdown menu.
                    moveIntoMoreDropdown(menu, item, true);
                } else if (menuHeight > maxHeight) {
                    moveIntoMoreDropdown(menu, item, true);
                    menuHeight = 0;
                }
            } else if (menu.offsetHeight > maxHeight) {
                // Assign menu height to be used to check with menu parent.
                menuHeight = menu.offsetHeight;
            }
        });
    } else {
        // If the menu height is smaller than the height of the parent, then try returning navlinks to the menu.
        if ('children' in moreDropdown) {
            // Iterate through the nodes within the more dropdown menu.
            Array.from(moreDropdown.children).forEach(item => {
                // Don't move the node to the more menu if it is explicitly defined that
                // this node should be displayed in the more dropdown menu at all times.
                if (menu.offsetHeight < maxHeight && item.dataset.forceintomoremenu !== 'true') {
                    const lastNode = moreDropdown.removeChild(item);
                    // Move this node from the more dropdown menu into the main section of the menu.
                    moveOutOfMoreDropdown(menu, lastNode);
                }
            });
            // If there are no more nodes in the more dropdown menu we can hide the moreButton.
            if (Array.from(moreDropdown.children).length === 0) {
                moreButton.classList.add(Selectors.classes.hidden);
            }
        }

        if (menu.offsetHeight > maxHeight) {
            autoCollapse(menu);
        }
    }
    menu.parentNode.classList.add(Selectors.classes.observed);
};

/**
 * Move a node into the "more" dropdown menu.
 *
 * This method forces a given navigation node to be added and displayed within the "more" dropdown menu.
 *
 * @param {HTMLElement} menu The navbar moremenu.
 * @param {HTMLElement} navNode The navigation node.
 * @param {boolean} prepend Whether to prepend or append the node to the content in the more dropdown menu.
 */
const moveIntoMoreDropdown = (menu, navNode, prepend = false) => {
    const moreDropdown = menu.querySelector(Selectors.regions.moredropdown);
    const dropdownToggle = menu.querySelector(Selectors.attributes.dropdowntoggle);

    const navLink = navNode.querySelector('.' + Selectors.classes.navlink);
    // If there are navLinks that contain an active link in the moreDropdown
    // make the dropdownToggle in the moreButton active.
    if (navLink.classList.contains(Selectors.classes.active)) {
        dropdownToggle.classList.add(Selectors.classes.active);
        dropdownToggle.setAttribute('tabindex', '0');
        navLink.setAttribute('tabindex', '-1'); // So that we don't have a single tabbable menu item.
        // Remove aria-selected if the more menu is rendered as a tab list.
        if (isTabListMenu) {
            navLink.removeAttribute('aria-selected');
        }
        navLink.setAttribute('aria-current', 'true');
    }

    // This will become a menu item instead of a tab.
    navLink.setAttribute('role', 'menuitem');

    // Change the styling of the navLink to a dropdownitem and push it into
    // the moreDropdown.
    navLink.classList.remove(Selectors.classes.navlink);
    navLink.classList.add(Selectors.classes.dropdownitem);
    if (prepend) {
        moreDropdown.prepend(navNode);
    } else {
        moreDropdown.append(navNode);
    }
};

/**
 * Move a node out of the "more" dropdown menu.
 *
 * This method forces a given node from the "more" dropdown menu to be displayed in the main section of the menu.
 *
 * @param {HTMLElement} menu The navbar moremenu.
 * @param {HTMLElement} navNode The navigation node.
 */
const moveOutOfMoreDropdown = (menu, navNode) => {
    const moreButton = menu.querySelector(Selectors.regions.morebutton);
    const dropdownToggle = menu.querySelector(Selectors.attributes.dropdowntoggle);
    const navLink = navNode.querySelector('.' + Selectors.classes.dropdownitem);

    // If the more menu is rendered as a tab list,
    // this will become a tab instead of a menuitem when moved out of the more menu dropdown.
    if (isTabListMenu) {
        navLink.setAttribute('role', 'tab');
    }

    // Stop displaying the active state on the dropdownToggle if
    // the active navlink is removed.
    if (navLink.classList.contains(Selectors.classes.active)) {
        dropdownToggle.classList.remove(Selectors.classes.active);
        dropdownToggle.setAttribute('tabindex', '-1');
        navLink.setAttribute('tabindex', '0');
        if (isTabListMenu) {
            // Replace aria selection state when necessary.
            navLink.removeAttribute('aria-current');
            navLink.setAttribute('aria-selected', 'true');
        }
    }
    navLink.classList.remove(Selectors.classes.dropdownitem);
    navLink.classList.add(Selectors.classes.navlink);
    menu.insertBefore(navNode, moreButton);
};

/**
 * Determine whether a menu item is a submenu toggle rendered inside a dropdown menu.
 *
 * @param {HTMLElement} item The menu item anchor.
 * @return {boolean} True if the item opens a nested submenu.
 */
const isNestedSubmenuToggle = item => {
    return item.classList.contains(Selectors.classes.dropdownitem) &&
        item.matches(Selectors.attributes.dropdowntoggle);
};

/**
 * Get the submenu (dropdown menu) controlled by a given submenu toggle.
 *
 * @param {HTMLElement} toggle The submenu toggle anchor.
 * @return {HTMLElement|null} The submenu element, or null if there isn't one.
 */
const getChildSubmenu = toggle => {
    return toggle.parentElement ? toggle.parentElement.querySelector(':scope > ' + Selectors.attributes.menu) : null;
};

/**
 * Move focus to the next or previous menu item at the same submenu level.
 *
 * Only visible items that live directly within the same list are considered, so focus never
 * jumps into a (possibly open) nested submenu. Navigation wraps around at both ends.
 *
 * @param {HTMLElement} currentItem The currently focused menu item anchor.
 * @param {number} direction 1 to move to the next item, -1 to move to the previous item.
 */
const focusLevelSibling = (currentItem, direction) => {
    // The <ul> that holds the sibling <li> items (anchor -> li -> ul).
    const list = currentItem.parentElement.parentElement;
    const items = Array.from(list.children)
        .map(child => child.querySelector(':scope > ' + Selectors.attributes.menuitem))
        .filter(item => item !== null && item.offsetParent !== null);
    const currentIndex = items.indexOf(currentItem);
    if (currentIndex === -1 || items.length === 0) {
        return;
    }
    const nextIndex = (currentIndex + direction + items.length) % items.length;
    items[nextIndex].focus();
};

/**
 * Initialise the more menus.
 *
 * @param {HTMLElement} menu The navbar moremenu.
 */
export default menu => {
    isTabListMenu = menu.getAttribute('role') === 'tablist';

    // Select the first menu item if there's nothing initially selected.
    const hash = window.location.hash;
    if (!hash) {
        const itemRole = isTabListMenu ? 'tab' : 'menuitem';
        const menuListItem = menu.firstElementChild;
        const roleSelector = `[role=${itemRole}]`;
        const menuItem = menuListItem.querySelector(roleSelector);
        const ariaAttribute = isTabListMenu ? 'aria-selected' : 'aria-current';
        if (!menu.querySelector(`[${ariaAttribute}='true']`)) {
            menuItem.setAttribute(ariaAttribute, 'true');
            menuItem.setAttribute('tabindex', '0');
        }
    }

    // Change the classname from .nav-link to .dropdown-item if the node is inside a dropdown-menu.
    const dropdownItems = menu.querySelectorAll('.dropdown-menu .nav-link');
    dropdownItems.forEach((item) => {
        item.classList.remove('nav-link');
        item.classList.add('dropdown-item');
    });

    // Pre-populate the "more" dropdown menu with navigation nodes which are set to be displayed in this menu
    // by default at all times.
    if ('children' in menu) {
        const moreButton = menu.querySelector(Selectors.regions.morebutton);
        const menuNodes = Array.from(menu.children);
        menuNodes.forEach((item) => {
            if (!item.classList.contains(Selectors.classes.dropdownmoremenu) &&
                    item.dataset.forceintomoremenu === 'true') {
                // Append this node into the more dropdown menu.
                moveIntoMoreDropdown(menu, item, false);
                // After adding the node into the more dropdown menu, make sure that the more dropdown menu button
                // is displayed.
                if (moreButton.classList.contains(Selectors.classes.hidden)) {
                    moreButton.classList.remove(Selectors.classes.hidden);
                }
            }
        });
    }
    // Populate the more dropdown menu with additional nodes if necessary, depending on the current screen size.
    autoCollapse(menu);
    menuNavigation(menu);

    // When the screen size changes make sure the menu still fits.
    window.addEventListener('resize', () => {
        autoCollapse(menu);
        menuNavigation(menu);
    });

    // Allow multi-level dropdowns inside the More menu to stay open when clicking
    // on nested toggles. Bootstrap 5 closes dropdowns on any click by default;
    // "outside" means only clicks outside the dropdown close it.
    menu.querySelectorAll(Selectors.attributes.dropdowntoggle).forEach((toggle) => {
        toggle.setAttribute('data-bs-auto-close', 'outside');
    });

    // Ensure only the currently opening dropdown toggle has aria-current="true".
    // Also reposition the submenu if it would overflow the right edge of the viewport.
    menu.addEventListener('show.bs.dropdown', (e) => {
        const toggle = e.target;

        menu.querySelectorAll(`${Selectors.attributes.dropdowntoggle}[aria-current="true"]`).forEach((t) => {
            if (t !== toggle) {
                t.removeAttribute('aria-current');
            }
        });

        // Find the submenu about to open (sibling of the toggle).
        const innerMenu = toggle.parentNode ? toggle.parentNode.querySelector(Selectors.attributes.menu) : null;
        if (innerMenu) {
            const right = window.innerWidth - toggle.getBoundingClientRect().right;
            if (right < toggle.offsetWidth) {
                innerMenu.style.left = `calc(${right}px - 20px)`;
            } else {
                innerMenu.style.left = '';
            }
        }
    });

    // Fix keyboard navigation within nested submenus.
    //
    // Moodle attaches Bootstrap's dropdown keyboard handler on the document during the *capture* phase
    // (see theme_boost/loader::realocateBootstrapEvents). For ArrowUp/ArrowDown that handler opens the
    // (sub)menu and calls event.stopPropagation(), so the event is consumed before it can reach a
    // bubble-phase listener on this menu. That is why arrow up/down never reaches a listener here, while
    // left/right (which Bootstrap ignores) does.
    //
    // To take over arrow navigation we therefore listen on `window` in the capture phase, which runs
    // *before* the document-level Bootstrap handler, and stop the event there. Inside a dropdown menu the
    // arrow keys should move between items at the same level; a submenu should only open on Enter/Space,
    // which then moves focus into it.
    const view = menu.ownerDocument.defaultView || window;
    view.addEventListener('keydown', (e) => {
        const src = e.target;

        // Only handle items that live inside this menu's dropdowns.
        if (!(src instanceof HTMLElement) || !menu.contains(src) ||
                !src.classList.contains(Selectors.classes.dropdownitem)) {
            return;
        }

        if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
            // Run before (and instead of) Bootstrap: navigate the current level, don't open a submenu.
            e.preventDefault();
            e.stopImmediatePropagation();
            focusLevelSibling(src, e.key === 'ArrowDown' ? 1 : -1);
            return;
        }

        if ((e.key === 'Enter' || e.key === ' ') && isNestedSubmenuToggle(src)) {
            // Open the submenu (if it isn't already) and move focus to its first item.
            e.preventDefault();
            e.stopImmediatePropagation();
            const submenu = getChildSubmenu(src);
            if (submenu && !submenu.classList.contains('show')) {
                src.click();
            }
            view.requestAnimationFrame(() => {
                const firstItem = submenu ? submenu.querySelector(Selectors.attributes.menuitem) : null;
                if (firstItem) {
                    firstItem.focus();
                }
            });
        }
    }, true);
};
