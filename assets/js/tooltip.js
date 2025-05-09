(function($) {
    /**
     * Initialize custom tooltips for selected elements
     * @param {Object} options - Configuration options for tooltips
     * @returns {jQuery} - jQuery object for method chaining
     */
    $.fn.initializeTooltip = function(options) {
        // Default settings with ability to override
        const settings = $.extend({
            tooltipClass: 'baza-tooltip',
            titleClass: 'tooltip-title',
            contentClass: 'tooltip-content',
            onShow: function() {},
            onHide: function() {}
        }, options);

        // Create tooltip element and append to body
        const tooltip = $('<div>', { class: settings.tooltipClass })
            .append(`<div class="${settings.titleClass}"></div>`)
            .appendTo('body')
            .hide();

        // Process each selected element
        this.each(function() {
            const element = $(this);
            const title = element.data('title');

            // Skip elements without title
            if (!title) return;

            // Show tooltip on mouse enter
            element.on('mouseenter', function() {
                tooltip.find(`.${settings.titleClass}`).html(title);
                tooltip.stop(true, true).fadeIn(200);

                // Call show callback
                settings.onShow.call(this);
            });

            // Move tooltip with mouse
            element.on('mousemove', function(e) {
                const mouseX = e.pageX;
                const mouseY = e.pageY;

                tooltip.css({
                    position: 'absolute',
                    left: mouseX + 10 + 'px',
                    top: mouseY + 10 + 'px'
                });
            });

            // Hide tooltip on mouse leave
            element.on('mouseleave', function() {
                tooltip.stop(true, true).fadeOut(200);

                // Call hide callback
                settings.onHide.call(this);
            });

        });

        // Allow method chaining
        return this;
    };
})(jQuery);