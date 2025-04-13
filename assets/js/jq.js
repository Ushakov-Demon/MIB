jQuery(document).ready(function ($) {
	
	let body = $('body');

	body.addClass('ready');

	$('input[name="phone"]').inputmask('+38(999)999-99-99');

	$(document).on('click', '.menu-toggle', function() {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			body.removeClass('nav-active');
			body.removeClass('nav-active-after');
		} else {
			body.addClass('nav-active');
			$(this).addClass('active');
			setTimeout(function() {
				body.addClass('nav-active-after');
			}, 500);
		}
	});

	$(document).on('focus', 'input', function () {
		$(this).parent().addClass('focus');
	});

	$(document).on('blur', 'input', function () {
		$(this).parent().removeClass('focus');
	});	  

	$(document).on('click', '.close-menu', function(e) {
		e.preventDefault();
		$('.menu-toggle').removeClass('active');
		body.removeClass('nav-active');
		body.removeClass('nav-active-after');
	});
	
	$(document).on('click', function(event) {
		if (!$(event.target).closest('.menu-wrapper').length && !$(event.target).closest('.menu-toggle').length && !$(event.target).closest('#MagiCSS-bookmarklet').length) {
			$('.menu-toggle').removeClass('active');
			body.removeClass('nav-active');
			body.removeClass('nav-active-after');
		}
	});

	$(document).on('click', 'header .menu .current-menu-item a[aria-current="page"], .logo-link[href="#"]', function(e) {
		e.preventDefault();
		e.stopPropagation();
	});

	// To top
	let $toTop = $('.to-top'),
        offset = 300;

    $(window).scroll(function() {
        if ($(this).scrollTop() < offset) {
            $toTop.css('transform', 'translateY(150px)');
        } else {
            $toTop.css('transform', 'translateY(0)');
        }
    });

	$('.to-top').click(function () {
		$('html, body').animate({
			scrollTop: 0
		}, 500);
	});

	// Accordion
	$('.accordion-header').click(function () {
		let item = $(this).closest('.accordion-item');
		let text = item.find('.accordion-content');
	
		if (item.hasClass('active')) {
			item.removeClass('active');
			text.slideUp(300);
		} else {
			$('.accordion-item').removeClass('active');
			$('.accordion-content').slideUp(300);
			item.addClass('active');
			text.slideToggle(300);
		}
	});

	// Show more
	$('.show-more').each(function() {
		const $container = $(this);
		const buttonText = $container.data('button-text');
		const rowCount = parseInt($container.data('row'));
		
		$container.parent().addClass('has-show-more');
		
		const $allElements = $container.children();
		
		if ($allElements.length > rowCount) {
			const $hiddenContainer = $('<div class="hidden-content" style="display:none;"></div>');
			
			$allElements.slice(rowCount).detach().appendTo($hiddenContainer);
			$container.append($hiddenContainer);
			const $showMoreBtn = $('<div class="show-more-button"><a href="javascript:void(0);">' + buttonText + '</a></div>');

			$container.after($showMoreBtn);
			
			$showMoreBtn.on('click', function(e) {
				e.preventDefault();
				$hiddenContainer.show();
				$container.parent().removeClass('has-show-more');
				$(this).remove();
			});
		}
	});
});