(function($) {
    
    $.fn.formSelect = function(options) {
        // Default settings
        const settings = $.extend({
            wrapperClass: 'booking-select-wrapper',
            activeClass: 'active',
            multiSelectClass: 'multi-select',
            onChange: null
        }, options);
        
        return this.each(function() {
            const $select = $(this);
            
            // Skip if already initialized
            if ($select.data('custom-select-initialized')) {
                return;
            }
            
            // Create ID for uniqueness if it doesn't exist
            const selectId = $select.attr('id') || `custom-select-${Math.random().toString(36).substr(2, 9)}`;
            $select.attr('id', selectId);
            
            // Save disabled and readonly states and check if it's a multiple select
            const isDisabled = $select.prop('disabled');
            const isReadonly = $select.attr('readonly') !== undefined;
            const isMultiple = $select.prop('multiple');
            
            // Main structure
            const $ulWrapper = $('<div>', { 
                class: `${settings.wrapperClass} ${isMultiple ? settings.multiSelectClass : ''} ${isDisabled ? 'disabled' : ''} ${isReadonly ? 'readonly' : ''}`,
                'data-for': selectId
            });

            // Add disabled or readonly class
            if (isDisabled) {
                $ulWrapper.addClass('disabled');
            } else if (isReadonly) {
                $ulWrapper.addClass('readonly');
            }
            
            const $selectedItem = $('<a>', { 
                class: 'selected',
                tabindex: (isDisabled || isReadonly) ? -1 : 0, // Accessibility for keyboard navigation
                role: 'button',
                'aria-haspopup': 'listbox',
                'aria-expanded': 'false'
            });
            
            // For multiselect, we'll use a token-like display
            const $selectedTokens = $('<div>', {
                class: 'selected-tokens',
                style: isMultiple ? '' : 'display: none;',
                tabindex: (isDisabled || isReadonly) ? -1 : 0,
                role: 'button',
                'aria-haspopup': 'listbox',
                'aria-expanded': 'false'
            });
            
            const $ulDropdown = $('<ul>', { 
                class: 'select-list',
                role: 'listbox',
                'aria-labelledby': selectId,
                'aria-multiselectable': isMultiple ? 'true' : 'false'
            });

            // Add focus and blur event listeners to wrapper for active state
            $selectedItem.add($selectedTokens).on('focus', function() {
                if (!isDisabled && !isReadonly) {
                    $ulWrapper.addClass(settings.activeClass);
                }
            }).on('blur', function() {
                $ulWrapper.removeClass(settings.activeClass);
            });
            
            // Add options from original select
            const options = $select.find('option');
            
            // For single select, set selected item text
            if (!isMultiple) {
                const selectedOption = $select.find('option:selected');
                $selectedItem.text(selectedOption.text() || $select.attr('placeholder') || 'Select an option');
            } else {
                $selectedItem.text($select.attr('placeholder') || 'Select options');
                // Update tokens for multiselect
                updateSelectedTokens();
            }
            
            // Add options to dropdown list
            options.each(function(index) {
                const $option = $(this);
                const value = $option.val();
                const text = $option.text();

                if (!value && value !== 0) {
                    return;
                }
                
                const $li = $('<li>', { 
                    'data-value': value,
                    text: text,
                    role: 'option',
                    'aria-selected': $option.is(':selected') ? 'true' : 'false',
                    tabindex: -1
                });
                
                if ($option.is(':selected')) {
                    $li.addClass(settings.activeClass);
                }
                
                if ($option.prop('disabled')) {
                    $li.addClass('disabled');
                }
                
                // For multiselect, add checkbox
                if (isMultiple) {
                    const $checkbox = $('<span>', {
                        class: 'checkbox-indicator',
                        html: '<svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>'
                    });
                    $li.prepend($checkbox);
                }
                
                $ulDropdown.append($li);
            });
            
            // Build structure
            if (isMultiple) {
                $ulWrapper.append($selectedItem).append($selectedTokens).append($ulDropdown);
            } else {
                $ulWrapper.append($selectedItem).append($ulDropdown);
            }
            
            // Hide original select and add our markup
            $select.addClass('booking-hidden-select').after($ulWrapper);
            
            // Function to update tokens display for multiselect
            function updateSelectedTokens() {
                if (!isMultiple) return;
    
                $selectedTokens.empty();
                
                const selectedOptions = $select.find('option:selected');
                
                if (selectedOptions.length === 0) {
                    // Use the text of the first empty option if available
                    const firstEmptyOption = $select.find('option:not([value]), option[value=""]').first();
                    $selectedItem.text(firstEmptyOption.length ? firstEmptyOption.text() : 
                                    $select.attr('placeholder') || reservation_calendar_i18n.selectOptions);
                    $selectedItem.show();
                    $selectedTokens.hide();
                    return;
                }
                
                // Hide the selected element completely when options are selected
                $selectedItem.hide();
                $selectedTokens.show();
                
                // Copy ARIA expanded state from selected to tokens
                $selectedTokens.attr('aria-expanded', $selectedItem.attr('aria-expanded'));
                
                selectedOptions.each(function() {
                    const $option = $(this);
                    const value = $option.val();
                    const text = $option.text();
                    
                    const $token = $('<span>', {
                        class: 'token',
                        'data-value': value,
                        text: text
                    });
                    
                    const $removeBtn = $('<span>', {
                        class: 'remove',
                        html: '&times;',
                        title: reservation_calendar_i18n.remove
                    });
                    
                    $removeBtn.on('click', function(e) {
                        // Prevent interaction for readonly or disabled selects
                        if (isDisabled || isReadonly) {
                            e.stopPropagation();
                            return;
                        }
                        
                        e.stopPropagation();
                        
                        // Update original select
                        $select.find(`option[value="${value}"]`).prop('selected', false);
                        
                        // Update list item
                        $ulDropdown.find(`li[data-value="${value}"]`).removeClass(settings.activeClass).attr('aria-selected', 'false');
                        
                        // Update display
                        $token.remove();
                        
                        // If no tokens left, restore placeholder and show selected element
                        if ($select.find('option:selected').length === 0) {
                            const firstEmptyOption = $select.find('option:not([value]), option[value=""]').first();
                            $selectedItem.text(firstEmptyOption.length ? firstEmptyOption.text() : 
                                              $select.attr('placeholder') || 'Select options');
                            $selectedItem.show();
                            $selectedTokens.hide();
                        }
                        
                        // Trigger change event
                        $select.trigger('change');
                        
                        // Call callback if specified
                        if (typeof settings.onChange === 'function') {
                            settings.onChange.call($select[0], $select.val(), null);
                        }
                    });
                    
                    $token.append($removeBtn);
                    $selectedTokens.append($token);
                });
            }
            
            // Event handlers - attach to both selected and selected-tokens for multiselect
            $selectedItem.add($selectedTokens).on('click keydown', function(event) {
                // Check if element is disabled or readonly
                if ($ulWrapper.hasClass('disabled') || $ulWrapper.hasClass('readonly')) return;
                
                // Keyboard navigation
                if (event.type === 'keydown') {
                    if (event.key !== 'Enter' && event.key !== ' ') return;
                }
                
                event.preventDefault();
                event.stopPropagation();
                
                // Close other open lists
                $(`.${settings.wrapperClass} .select-list.${settings.activeClass}`).not($ulDropdown).removeClass(settings.activeClass);
                $(`.${settings.wrapperClass} .selected`).not($selectedItem).attr('aria-expanded', 'false');
                
                // Toggle current list
                $ulDropdown.toggleClass(settings.activeClass);
                
                // Update ARIA attributes
                const isExpanded = $ulDropdown.hasClass(settings.activeClass);
                $selectedItem.attr('aria-expanded', isExpanded.toString());
                $selectedTokens.attr('aria-expanded', isExpanded.toString());
                
                // Focus first item when opening
                if (isExpanded) {
                    const $firstActive = $ulDropdown.find(`li.${settings.activeClass}`);
                    if ($firstActive.length) {
                        $firstActive.first().focus();
                    } else {
                        $ulDropdown.find('li:not(.disabled)').first().focus();
                    }
                }
            });
            
            // Handle option click
            $ulDropdown.on('click keydown', 'li:not(.disabled)', function(event) {
                // Prevent interaction for readonly or disabled selects
                if (isDisabled || isReadonly) {
                    event.preventDefault();
                    event.stopPropagation();
                    return;
                }
                
                // Keyboard navigation
                if (event.type === 'keydown') {
                    if (event.key !== 'Enter' && event.key !== ' ') {
                        // Arrow navigation
                        if (event.key === 'ArrowDown') {
                            event.preventDefault();
                            let $next = $(this).next('li:not(.disabled)');
                            if ($next.length) $next.focus();
                            return;
                        }
                        if (event.key === 'ArrowUp') {
                            event.preventDefault();
                            let $prev = $(this).prev('li:not(.disabled)');
                            if ($prev.length) $prev.focus();
                            return;
                        }
                        if (event.key === 'Escape') {
                            event.preventDefault();
                            $ulDropdown.removeClass(settings.activeClass);
                            $selectedItem.attr('aria-expanded', 'false').focus();
                            return;
                        }
                        return;
                    }
                    event.preventDefault();
                }
                
                const $li = $(this);
                const value = $li.data('value');
                const text = $li.text();
                
                if (!isMultiple) {
                    // Single select behavior
                    
                    // Do nothing if option is already selected
                    if ($li.hasClass(settings.activeClass)) {
                        $ulDropdown.removeClass(settings.activeClass);
                        $selectedItem.attr('aria-expanded', 'false').focus();
                        return;
                    }
                    
                    // Update original select
                    $select.val(value);
                    
                    // Update selected item
                    $selectedItem.text(text);
                    
                    // Update active classes
                    $ulDropdown.find('li').removeClass(settings.activeClass).attr('aria-selected', 'false');
                    $li.addClass(settings.activeClass).attr('aria-selected', 'true');
                    
                    // Close dropdown
                    $ulDropdown.removeClass(settings.activeClass);
                    $selectedItem.attr('aria-expanded', 'false').focus();
                } else {
                    // Multiple select behavior
                    const isSelected = $li.hasClass(settings.activeClass);
                    
                    // Toggle selection
                    $li.toggleClass(settings.activeClass);
                    
                    // Update aria-selected
                    $li.attr('aria-selected', (!isSelected).toString());
                    
                    // Update original select
                    $select.find(`option[value="${value}"]`).prop('selected', !isSelected);
                    
                    // Update tokens display
                    updateSelectedTokens();
                    
                    // Leave dropdown open for multiple selections
                    // Don't close the dropdown
                }
                
                // Trigger change event on original select
                $select.trigger('change');
                
                // Call callback if specified
                if (typeof settings.onChange === 'function') {
                    settings.onChange.call($select[0], $select.val(), text);
                }
            });
            
            // Click outside dropdown - close it
            $(document).on('click', function(event) {
                if (!$(event.target).closest(`.${settings.wrapperClass}`).length) {
                    $ulDropdown.removeClass(settings.activeClass);
                    $selectedItem.attr('aria-expanded', 'false');
                }
            });
            
            // Update when original select changes
            $select.on('change', function(e, skipCustomUpdate) {
                if (skipCustomUpdate) return;
                
                if (!isMultiple) {
                    // Single select update
                    const value = $(this).val();
                    const $selectedOption = $(this).find(`option[value="${value}"]`);
                    
                    if ($selectedOption.length) {
                        $selectedItem.text($selectedOption.text());
                        $ulDropdown.find('li').removeClass(settings.activeClass).attr('aria-selected', 'false');
                        $ulDropdown.find(`li[data-value="${value}"]`).addClass(settings.activeClass).attr('aria-selected', 'true');
                    } else {
                        const firstEmptyOption = $(this).find('option:not([value]), option[value=""]').first();
                        $selectedItem.text(firstEmptyOption.length ? firstEmptyOption.text() : 
                                        $(this).attr('placeholder') || 'Select an option');
                    }
                } else {
                    // Multiple select update
                    const selectedValues = $(this).val() || [];
                    
                    // Reset all options
                    $ulDropdown.find('li').removeClass(settings.activeClass).attr('aria-selected', 'false');
                    
                    // Mark selected options
                    if (Array.isArray(selectedValues) && selectedValues.length > 0) {
                        selectedValues.forEach(function(value) {
                            $ulDropdown.find(`li[data-value="${value}"]`).addClass(settings.activeClass).attr('aria-selected', 'true');
                        });
                        
                        // Hide selected item text and show tokens
                        $selectedItem.hide();
                        $selectedTokens.show();
                    } else {
                        // Show selected item text with first empty option text and hide tokens
                        const firstEmptyOption = $(this).find('option:not([value]), option[value=""]').first();
                        $selectedItem.text(firstEmptyOption.length ? firstEmptyOption.text() : 
                                        $(this).attr('placeholder') || 'Select options');
                        $selectedItem.show();
                        $selectedTokens.hide();
                    }
                    
                    // Update tokens
                    updateSelectedTokens();
                }
            });
            
            // Mark as initialized
            $select.data('custom-select-initialized', true);
        });
    };
    
})(jQuery);