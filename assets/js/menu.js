jQuery(document).ready(function ($) {
    const mobileMenuContainer = $('.menu-first.menu-js');
    const desktopMenuContainer = $('.menu-primary.menu-js');
    
    if (!mobileMenuContainer.length && !desktopMenuContainer.length) return;

    function isMobileDevice() {
        return window.matchMedia("(max-width: 1023px)").matches;
    }

    if ($('body > .dropdown-mobile-menus').length === 0) {
        $('body').prepend('<div class="dropdown-mobile-menus"></div>');
    }

    const mobileMenusContainer = $('.dropdown-mobile-menus');

    function reorganizeMenuStructure(menuContainer) {
        menuContainer.find('.menu-item-has-children').each(function () {
            const $menuItem = $(this);
            const $oldSubMenu = $menuItem.find('> ul.sub-menu');

            if ($oldSubMenu.length > 0) {
                const $newSubMenuContainer = $('<div class="sub-menu"></div>');
                const $primaryMenu = $('<ul class="menu open" id="menu-0"></ul>');

                const itemMap = new Map();

                $oldSubMenu.children('li').each(function (idx) {
                    const $originalItem = $(this);

                    const itemMarker = 'menu-item-marker-' + idx;
                    $originalItem.attr('data-menu-marker', itemMarker);

                    const $clonedItem = $originalItem.clone();

                    $clonedItem.attr('data-menu-marker', itemMarker);

                    $clonedItem.find('> ul.sub-menu').remove();

                    itemMap.set(itemMarker, $clonedItem);

                    $primaryMenu.append($clonedItem);
                });

                $newSubMenuContainer.append($primaryMenu);
                const $nestedMenusContainer = $('<div class="sub-menu"></div>');

                $oldSubMenu.find('> li.menu-item-has-children').each(function (index) {
                    const $parentItem = $(this);
                    const parentMarker = $parentItem.attr('data-menu-marker');
                    const $nestedMenu = $parentItem.find('> ul.sub-menu');

                    if ($nestedMenu.length > 0 && parentMarker) {
                        const menuId = 'menu-' + (index + 1);
                        const $newNestedMenu = $('<ul class="menu animate__animated" id="' + menuId + '"></ul>');
                        $nestedMenu.children('li').clone().appendTo($newNestedMenu);
                        $nestedMenusContainer.append($newNestedMenu);

                        if (itemMap.has(parentMarker)) {
                            itemMap.get(parentMarker).attr('data-target-menu', menuId);
                        }
                    }
                });

                if ($nestedMenusContainer.children().length > 0) {
                    $newSubMenuContainer.append($nestedMenusContainer);
                }

                $oldSubMenu.replaceWith($newSubMenuContainer);
            }
        });
    }

    if (mobileMenuContainer.length) {
        reorganizeMenuStructure(mobileMenuContainer);
    }
    
    if (desktopMenuContainer.length) {
        reorganizeMenuStructure(desktopMenuContainer);
    }

    const openTimeout = 200;
    const closeTimeout = 300;
    const thirdLevelTimeout = 200;
    let timers = {};
    let activeMenuContainer = null;

    function setActiveMenuWidth($element) {
        const menuWidth = $element.outerWidth();
        desktopMenuContainer.css('--active-menu-width', menuWidth + 'px');
    }

    function activateFirstSubmenu($menuItem) {
        const $subMenu = $menuItem.find('> .sub-menu').first();
        if ($subMenu.length) {
            $subMenu.addClass('open');
            $menuItem.addClass('active');

            activeMenuContainer = $subMenu;

            const $nestedMenusContainer = $subMenu.find('> .sub-menu');
            if ($nestedMenusContainer.length) {
                $nestedMenusContainer.find('> .menu').removeClass('open');
                const $firstNestedMenu = $nestedMenusContainer.find('> .menu').first();
                if ($firstNestedMenu.length) {
                    $firstNestedMenu.addClass('open animate__fadeInRight');

                    const $firstItem = $subMenu.find('li[data-target-menu]').first();
                    if ($firstItem.length) {
                        $firstItem.addClass('active');
                    }

                    const $thirdLevelItem = $firstNestedMenu.find('> li.menu-item-has-children').first();
                    if ($thirdLevelItem.length && $thirdLevelItem.find('> .sub-menu').length) {
                        $thirdLevelItem.addClass('active');

                        setTimeout(function () {
                            $thirdLevelItem.find('> .sub-menu').addClass('open animate__fadeInRight');
                        }, thirdLevelTimeout);
                    }
                }
            }
        }
    }

    // Mobile menu
    if (isMobileDevice()) {
        $('body').addClass('is-mobile-device');
    }

    $(window).on('resize', function() {
        if (isMobileDevice()) {
            $('body').addClass('is-mobile-device');
        } else {
            $('body').removeClass('is-mobile-device');
        }
    });

    function initializeMobileMenus() {
        mobileMenuContainer.find('.sub-menu > .sub-menu > .menu').each(function() {
            const $thirdLevelMenu = $(this);
            const menuId = $thirdLevelMenu.attr('id');
            
            if (menuId) {
                const $parentMenuItem = mobileMenuContainer.find(`li[data-target-menu="${menuId}"]`);
                const parentText = $parentMenuItem.find('> a').text();
                
                const $clonedMenu = $thirdLevelMenu.clone();
                $clonedMenu.addClass('mobile-sub-menu');
                
                const $backLink = $(`
                    <li class="menu-item menu-item-back">
                        <a href="#" class="menu-back-link">${parentText}</a>
                    </li>
                `);
                $clonedMenu.prepend($backLink);
                
                mobileMenusContainer.append($clonedMenu);
                
                $thirdLevelMenu.parent().remove();
            }
        });
        
        mobileMenuContainer.find('li[data-target-menu]').each(function() {
            const $menuItem = $(this);
            const targetMenuId = $menuItem.attr('data-target-menu');
            
            if (targetMenuId) {
                $menuItem.attr('data-has-dropdown', 'true');
            }
        });
    }
    
    if (mobileMenuContainer.length) {
        initializeMobileMenus();
    }

    $(document).on('click', '.menu-item-back .menu-back-link', function(e) {
        e.preventDefault();
        const $thirdLevelMenu = $(this).closest('.mobile-sub-menu');
        
        $thirdLevelMenu.removeClass('open');
        $('body').removeClass('sub-menu-active');
        
        const menuId = $thirdLevelMenu.attr('id');
        const $activeMenuItem = mobileMenuContainer.find(`li[data-target-menu="${menuId}"]`);
        $activeMenuItem.removeClass('active');
    });

    $(document).on('click', '.menu-first.menu-js li[data-target-menu] > a', function(e) {
        if (isMobileDevice()) {
            e.preventDefault();
            e.stopPropagation();
            
            const $menuItem = $(this).parent();
            const targetMenuId = $menuItem.attr('data-target-menu');
            
            if (targetMenuId) {
                const $mobileTargetMenu = mobileMenusContainer.find('#' + targetMenuId);
                
                mobileMenuContainer.find('li[data-target-menu]').removeClass('active');
                mobileMenusContainer.find('.mobile-sub-menu.open').removeClass('open');
                
                $menuItem.addClass('active');
                $mobileTargetMenu.addClass('open');
                $('body').addClass('sub-menu-active');
                
                return false;
            }
        }
    });

    $(document).on('click', function(e) {
        if (isMobileDevice() && 
            !$(e.target).closest('.menu-first.menu-js #menu-0 > li[data-target-menu]').length && 
            !$(e.target).closest('.dropdown-mobile-menus').length) {
            mobileMenuContainer.find('.menu.open').removeClass('open');
            mobileMenusContainer.find('.mobile-sub-menu.open').removeClass('open');
            $('body').removeClass('sub-menu-active');
            mobileMenuContainer.find('li[data-target-menu]').removeClass('active');
        }
    });

    $(document).on('click', '.menu-first.menu-js .menu-item-has-children > a', function(e) {
        if (isMobileDevice() && !$(this).parent().attr('data-target-menu')) {
            e.preventDefault();
            const $menuItem = $(this).parent('.menu-item-has-children');
            const $subMenu = $menuItem.find('> .sub-menu').first();
            
            if ($subMenu.length) {
                if ($menuItem.hasClass('active') && $subMenu.hasClass('open')) {
                    $subMenu.removeClass('open');
                    $menuItem.removeClass('active');
                } else {
                    $menuItem.siblings('.menu-item-has-children.active').each(function() {
                        const $sibling = $(this);
                        const $siblingSubMenu = $sibling.find('> .sub-menu').first();
                        
                        $siblingSubMenu.removeClass('open');
                        $sibling.removeClass('active');
                    });
                    
                    $subMenu.addClass('open');
                    $menuItem.addClass('active');
                }
                
                return false;
            }
        }
    });

    // Desktop menu
    if (desktopMenuContainer.length) {
        desktopMenuContainer.find('.menu-item-has-children').on({
            mouseenter: function () {
                if (isMobileDevice()) return; 
                
                const $menuItem = $(this);
                const isFirstLevel = $menuItem.hasClass('level-0');
                const menuItemId = $menuItem.attr('id') || 'menu-item-' + Math.random().toString(36).substr(2, 9);

                if (!$menuItem.attr('id')) {
                    $menuItem.attr('id', menuItemId);
                }

                if (isFirstLevel) {
                    setActiveMenuWidth($menuItem);
                }

                if (timers[menuItemId]) {
                    clearTimeout(timers[menuItemId]);
                    delete timers[menuItemId];
                }

                if (timers['close_' + menuItemId]) {
                    clearTimeout(timers['close_' + menuItemId]);
                    delete timers['close_' + menuItemId];
                }

                const isInsideSubMenu = $menuItem.closest('.sub-menu').length > 0;

                if (!isInsideSubMenu) {
                    desktopMenuContainer.find('.menu-item-has-children').not($menuItem).each(function () {
                        const $otherItem = $(this);
                        const otherItemId = $otherItem.attr('id');

                        const isOtherInsideSubMenu = $otherItem.closest('.sub-menu').length > 0;

                        if (isOtherInsideSubMenu) {
                            return;
                        }

                        if ($menuItem.closest('#' + otherItemId).length) {
                            return;
                        }

                        if ($otherItem.closest('#' + menuItemId).length) {
                            return;
                        }

                        const $otherSubMenu = $otherItem.find('> .sub-menu').first();
                        if ($otherSubMenu.hasClass('open')) {
                            $otherSubMenu.removeClass('animate__fadeInDown').addClass('animate__fadeOutUp');

                            if (timers[otherItemId]) {
                                clearTimeout(timers[otherItemId]);
                            }

                            timers[otherItemId] = setTimeout(function () {
                                $otherSubMenu.removeClass('animate__fadeOutUp open');
                                $otherItem.removeClass('active');
                                delete timers[otherItemId];
                            }, closeTimeout);
                        }
                    });
                }

                const $subMenu = $menuItem.find('> .sub-menu').first();

                if ($subMenu.length) {
                    if (!$subMenu.hasClass('open')) {
                        timers['open_' + menuItemId] = setTimeout(function () {
                            $subMenu.removeClass('animate__fadeOutUp').addClass('open animate__animated animate__fadeInDown');
                            $menuItem.addClass('active');

                            activateFirstSubmenu($menuItem);

                            delete timers['open_' + menuItemId];
                        }, openTimeout);
                    } else {
                        if (!$menuItem.hasClass('active')) {
                            $menuItem.addClass('active');
                        }

                        if (!$subMenu.hasClass('open')) {
                            $subMenu.addClass('open');
                        }

                        if ($subMenu.find('> .sub-menu > .menu.open').length === 0) {
                            activateFirstSubmenu($menuItem);
                        }
                    }
                }
            },
            mouseleave: function (e) {
                if (isMobileDevice()) return;
                
                const $menuItem = $(this);
                const menuItemId = $menuItem.attr('id');

                if (timers['open_' + menuItemId]) {
                    clearTimeout(timers['open_' + menuItemId]);
                    delete timers['open_' + menuItemId];
                }

                const isNestedMenu = $menuItem.closest('.sub-menu').length > 0;
                if (isNestedMenu) {
                    return;
                }

                const relatedTarget = e.relatedTarget;

                if ($(relatedTarget).closest('.sub-menu').length > 0) {
                    return;
                }

                timers['close_' + menuItemId] = setTimeout(function () {
                    const $subMenu = $menuItem.find('> .sub-menu').first();

                    const isMenuContainerActive = activeMenuContainer &&
                        (activeMenuContainer.is(':hover') ||
                            activeMenuContainer.find(':hover').length);

                    const isHoveringSomewhere = $menuItem.is(':hover') ||
                        $menuItem.find('.sub-menu:hover').length > 0 ||
                        $menuItem.find('.menu:hover').length > 0 ||
                        $subMenu.is(':hover') ||
                        isMenuContainerActive;

                    if (!isHoveringSomewhere) {
                        if ($subMenu.hasClass('open')) {
                            $subMenu.removeClass('animate__fadeInDown').addClass('animate__fadeOutUp');

                            setTimeout(function () {
                                const isStillHoveringSomewhere = $menuItem.is(':hover') ||
                                    $menuItem.find('.sub-menu:hover').length > 0 ||
                                    $menuItem.find('.menu:hover').length > 0 ||
                                    $subMenu.is(':hover');

                                if (!isStillHoveringSomewhere) {
                                    $subMenu.removeClass('animate__fadeOutUp open');
                                    $menuItem.removeClass('active');
                                    activeMenuContainer = null;
                                } else {
                                    $subMenu.removeClass('animate__fadeOutUp').addClass('animate__fadeInDown');
                                }
                            }, closeTimeout);
                        }
                    }

                    delete timers['close_' + menuItemId];
                }, closeTimeout);
            }
        });

        desktopMenuContainer.find('.menu-item[data-target-menu]').hover(
            function (e) {
                if (isMobileDevice()) return;
                
                e.stopPropagation();
                const $menuItem = $(this);
                const targetMenuId = $menuItem.data('target-menu');

                let $currentParent = $menuItem.closest('.menu-item-has-children');
                while ($currentParent.length) {
                    $currentParent.addClass('active');
                    $currentParent.find('> .sub-menu').first().addClass('open');
                    $currentParent = $currentParent.closest('.menu-item-has-children').parent().closest('.menu-item-has-children');
                }

                if (targetMenuId) {
                    const $nestedMenusContainer = $menuItem.closest('.sub-menu').find('> .sub-menu');
                    const $parentMenuItem = $menuItem.closest('.menu-item-has-children');

                    if ($parentMenuItem.length) {
                        $parentMenuItem.addClass('active');
                        $parentMenuItem.find('> .sub-menu').addClass('open');
                    }

                    if (!$menuItem.hasClass('active')) {
                        $nestedMenusContainer.find('> .menu').removeClass('animate__fadeInRight').addClass('animate__fadeOutRight');

                        setTimeout(function () {
                            $nestedMenusContainer.find('> .menu').removeClass('animate__fadeOutRight open');
                            const $targetMenu = $nestedMenusContainer.find('#' + targetMenuId);
                            $targetMenu.addClass('open animate__fadeInRight');

                            const $thirdLevelItem = $targetMenu.find('> li.menu-item-has-children').first();
                            if ($thirdLevelItem.length && $thirdLevelItem.find('> .sub-menu').length) {
                                $thirdLevelItem.addClass('active');

                                setTimeout(function () {
                                    $thirdLevelItem.find('> .sub-menu').addClass('open animate__fadeInRight');
                                }, thirdLevelTimeout);
                            }
                        }, 200);
                    } else {
                        const $currentMenu = $nestedMenusContainer.find('> .menu.open');
                        const currentMenuId = $currentMenu.attr('id');

                        if (currentMenuId !== targetMenuId) {
                            $nestedMenusContainer.find('> .menu').removeClass('animate__fadeInRight').addClass('animate__fadeOutRight');

                            setTimeout(function () {
                                $nestedMenusContainer.find('> .menu').removeClass('animate__fadeOutRight open');
                                const $targetMenu = $nestedMenusContainer.find('#' + targetMenuId);
                                $targetMenu.addClass('open animate__fadeInRight');

                                const $thirdLevelItem = $targetMenu.find('> li.menu-item-has-children').first();
                                if ($thirdLevelItem.length && $thirdLevelItem.find('> .sub-menu').length) {
                                    $thirdLevelItem.addClass('active');

                                    setTimeout(function () {
                                        $thirdLevelItem.find('> .sub-menu').addClass('open animate__fadeInRight');
                                    }, thirdLevelTimeout);
                                }
                            }, 200);
                        }
                    }

                    $menuItem.siblings().removeClass('active');
                    $menuItem.addClass('active');
                }
            }
        );

        $(document).on('click', function(e) {
            if (!isMobileDevice() && !$(e.target).closest(desktopMenuContainer.find('.menu-item-has-children')).length) {
                desktopMenuContainer.find('.menu-item-has-children.active').each(function() {
                    const $activeItem = $(this);
                    const $activeSubMenu = $activeItem.find('> .sub-menu').first();

                    $activeSubMenu.removeClass('animate__fadeInDown').addClass('animate__fadeOutUp');
                    setTimeout(function() {
                        $activeSubMenu.removeClass('animate__fadeOutUp open');
                        $activeItem.removeClass('active');
                    }, closeTimeout);
                });

                activeMenuContainer = null;
            }
        });
    }
});