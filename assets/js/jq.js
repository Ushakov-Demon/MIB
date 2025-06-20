jQuery(document).ready(function ($) {
	
	let body = $('body'),
		languageCotainer = '.language',
		timeout,
		sliderSpeed = 2500,
		header = $('.site-header'),
		nextPrevButton = '<i class="icon-arrow"></i>';

	body.addClass('ready');

	$('input[name="phone"], input[name="your-phone"]').inputmask('+99(999)999-99-99');

	function headerFixed() {
		let scrollTop = $(window).scrollTop();

		if (scrollTop >= 100) {
			header.addClass('fixed');
			body.addClass('header-fixed');
		} else {
			header.removeClass('fixed');
			body.removeClass('header-fixed');
		}
	}

	headerFixed();

	function programTabsFixed() {
		let programTabs = $('.program-tabs'),
			scrollTop = $(window).scrollTop();
		
		if (programTabs.length === 0) return;
		
		let programTabsTop,
			headerHeight = header.outerHeight(),
			tabsHeight = programTabs.outerHeight(),
			placeholder = $('.tabs-placeholder');
		
		if (programTabs.hasClass('fixed')) {
			programTabs.removeClass('fixed');
			programTabsTop = programTabs.offset().top;
			programTabs.addClass('fixed');
		} else {
			programTabsTop = programTabs.offset().top;
		}
		
		if (scrollTop >= (programTabsTop - headerHeight)) {
			programTabs.addClass('fixed');
			
			if (placeholder.length === 0) {
				programTabs.after('<div class="tabs-placeholder"></div>');
				placeholder = $('.tabs-placeholder');
			}
			
			placeholder.height(tabsHeight);
			
		} else {
			programTabs.removeClass('fixed');
			
			if (placeholder.length > 0) {
				placeholder.remove();
			}
		}
	}

	programTabsFixed();

	$(window).on('scroll', function() {
		headerFixed();
		programTabsFixed(); 
	});

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
			}, 1000);
		}
	});

	$(document).on('click', '.search-toggle', function() {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			body.removeClass('search-active');
			body.removeClass('search-active-after');
		} else {
			body.addClass('search-active');
			$(this).addClass('active');
			setTimeout(function() {
				body.addClass('search-active-after');
				$('.search-field').focus();
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

	$(document).on('click', '.close-search', function(e) {
		e.preventDefault();
		$('.search-toggle').removeClass('active');
		body.removeClass('search-active');
		body.removeClass('search-active-after');
	});
	
	$(document).on('click', function(event) {
		if (!$(event.target).closest('.menu-wrapper').length 
		&& !$(event.target).closest('.menu-toggle').length 
		&& !$(event.target).closest('#MagiCSS-bookmarklet').length 
		&& !$(event.target).closest('.chromeperfectpixel-overlay-container').length 
		&& !$(event.target).closest('.dropdown-mobile-menus').length) {
			$('.menu-toggle').removeClass('active');
			body.removeClass('nav-active');
			body.removeClass('nav-active-after');
		}

		if (!$(event.target).closest('.search').length 
		&& !$(event.target).closest('.search-toggle').length 
		&& !$(event.target).closest('#MagiCSS-bookmarklet').length) {
			$('.search-toggle').removeClass('active');
			body.removeClass('search-active');
			body.removeClass('search-active-after');
		}
	});

	$(document).on('click', 'header .menu .current-menu-item a[aria-current="page"], .logo-link[href="#"], .language .active > a', function(e) {
		e.preventDefault();
		e.stopPropagation();
	});

	$(languageCotainer).hover(
		function () {
			clearTimeout(timeout);
			$(this).find('ul').addClass('open');
			$(languageCotainer).addClass('active');
		},
		function () {
			let submenu = $(this).find('ul');
			timeout = setTimeout(function () {
				submenu.removeClass('open');
				$(languageCotainer).removeClass('active');
			}, 300);
		}
	);

	$(window).on('scroll', function () {
		$('body.home').css('--scroll', $(window).scrollTop() / ($(document).height() - $(window).height()));
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

	function animateCount() {
		$('.count-value').each(function () {
			let $this = $(this);

			if ($this.hasClass('counted')) return;

			if (isElementInViewport(this)) {
				$this.addClass('counted');

				let target = parseInt($this.data('count') || $this.text(), 10);
				let duration = $this.data('duration') || 2000;

				if (!$this.data('count')) {
					$this.data('count', target);
				}

				$this.text('0');

				$({ Counter: 0 }).animate({
					Counter: target
				}, {
					duration: duration,
					easing: 'swing',
					step: function () {
						$this.text(Math.ceil(this.Counter));
					},
					complete: function () {
						$this.text(target);
					}
				});
			}
		});
	}

	animateCount();

	let carouselHistory = $('#history-timeline-items'),
		carouselHistoryNav = $('#history-timeline-nav');

	carouselHistory.owlCarousel({
		items: 1,
		navSpeed: 1000,
		margin: 0,
		nav: false,
		dots: false,
		loop: true,
		navText: [nextPrevButton, nextPrevButton],
		mouseDrag: true,
		touchDrag: true,
		dragEndSpeed: 1000,
		dotsSpeed: 1000,
		autoHeight: true,
		autoplay: false,
		autoplaySpeed: 1000,
		autoplayTimeout: 2500,
		autoplayHoverPause: true,
		responsive: {
			0: {
				items: 1,
				stagePadding: 50,
			},
			768: {
				items: 2,
				stagePadding: 0,
			},
			1024: {
				items: 2,
				stagePadding: 0,
			},
			1200: {
				items: 2,
				stagePadding: 0,
			},
			1700: {
				items: 3,
				stagePadding: 0,
			}
		}
	});

	carouselHistoryNav.find('.owl-prev').click(function() {
		if (!$(this).hasClass('disabled')) {
			carouselHistory.trigger('prev.owl.carousel', 1000);
		}
	});

	carouselHistoryNav.find('.owl-next').click(function() {
		if (!$(this).hasClass('disabled')) {
			carouselHistory.trigger('next.owl.carousel', 1000);
		}
	});

	let carouselWpBlockGalleries = $('.wp-block-gallery');

	carouselWpBlockGalleries.each(function() {
		$(this).owlCarousel({
			items: 1,
			navSpeed: 1000,
			margin: 0,
			nav: true,
			dots: true,
			loop: true,
			navText: [nextPrevButton, nextPrevButton],
			mouseDrag: true,
			touchDrag: true,
			dragEndSpeed: 1000,
			dotsSpeed: 1000,
			autoHeight: true,
			autoplay: false,
			autoplaySpeed: 1000,
			autoplayTimeout: 2500,
			autoplayHoverPause: true,
			lazyLoad: true,
		});
	});

	let carouselStudentsItems = $('#students-items');

	carouselStudentsItems.owlCarousel({
		items: 1,
		navSpeed: 1000,
		margin: 0,
		nav: true,
		dots: true,
		loop: true,
		navText: [nextPrevButton, nextPrevButton],
		mouseDrag: true,
		touchDrag: true,
		dragEndSpeed: 1000,
		dotsSpeed: 1000,
		autoHeight: true,
		autoplay: false,
		autoplaySpeed: 1000,
		autoplayTimeout: 2500,
		autoplayHoverPause: true,
	});

	let carouselTeachersItems = $('#teachers-items');

	carouselTeachersItems.owlCarousel({
		items: 1,
		navSpeed: 1000,
		margin: 0,
		nav: true,
		dots: true,
		loop: true,
		navText: [nextPrevButton, nextPrevButton],
		mouseDrag: true,
		touchDrag: true,
		dragEndSpeed: 1000,
		dotsSpeed: 1000,
		autoHeight: true,
		autoplay: false,
		autoplaySpeed: 1000,
		autoplayTimeout: 2500,
		autoplayHoverPause: true,
	});

	let carouselCompanyLogos = $('#company-logos-items');

	carouselCompanyLogos.owlCarousel({
		items: 2,
		navSpeed: sliderSpeed,
		margin: 0,
		nav: false,
		dots: false,
		loop: true,
		navText: [nextPrevButton, nextPrevButton],
		mouseDrag: true,
		touchDrag: true,
		dragEndSpeed: sliderSpeed,
		dotsSpeed: sliderSpeed,
		autoHeight: true,
		autoplay: true,
		autoplaySpeed: sliderSpeed,
		autoplayTimeout: 2500,
		autoplayHoverPause: true,
		responsive: {
			0: {
				items: 2,
				loop: true,
			},
			768: {
				items: 4,
				margin: 0,
				loop: true,
			},
			1024: {
				items: 5,
				loop: true,
				stagePadding: 120,
			},
			1200: {
				items: 7,
				margin: 30,
				stagePadding: 140,
			}
		}
	});

	function ajaxResponsePosts(element) {
		section 	= element.closest('.section-news');
		filterTaget = section.data('type');
		pageId 		= section.data('page_id');
		perPage 	= section.data('per-page');
		maxPages 	= section.data('max-pages');
		pageNum 	= section.data('current-page_num');
		nextPageNum = parseInt( pageNum )+1;
		isPaginavi 	= section.hasClass('pagination');
		filterCats  = {
				'term' : section.data('q-terms'),
				'operator' : section.data('q-operator'),
			};
		
		const isLoadMore = element.closest('.more-posts').length > 0;
		
		section.addClass('loading');
	
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: dataObj['ajaxUrl'],
			data: {
				action: 'custom_post_type_filter',
				filterTaget: filterTaget,
				pageId: pageId,
				perPage: perPage,
				pageNum: nextPageNum,
				maxPages: maxPages,
				isPaginavi: isPaginavi,
				isLoadMore: isLoadMore,
				filterCats: filterCats,
			},
			success: function(response) {
				if (isLoadMore) {
					section.find('.more-posts').before(response);

					let newItems = section.find('.more-posts').prev();
                
					if (newItems.length) {
						let tempId = 'temp-scroll-target-' + Math.floor(Math.random() * 10000);
						newItems.attr('id', tempId);
						
						if ($.mPageScroll2id && typeof $.mPageScroll2id === 'function') {
							$.mPageScroll2id('scrollTo', '#' + tempId, {
								offset: 100,
								speed: 1500,
								easing: 'easeOutQuint'
							});
						} else {
							$('html, body').animate({
								scrollTop: newItems.offset().top - 100
							}, 1500);
						}
						
						setTimeout(function() {
							newItems.removeAttr('id');
						}, 2000);
					}
					
					if (pageNum >= maxPages - 1) {
						section.find('.more-posts').hide();
					} else {
						section.find('.more-posts').show();
					}
				} else {
					section.find('.sort-items').html(response);
					
					section.data('current-page_num', 1);
					
					if (maxPages > 1) {
						section.find('.more-posts').show();
					} else {
						section.find('.more-posts').hide();
					}
				}
				section.data('current-page_num', nextPageNum);
				section.removeClass('loading');
			},
			error: function() {
				section.removeClass('loading');
			}
		});
	
		return true;
	}
	
	$(document).on('click', '#filter-news .item', function(e) {
		e.preventDefault();
	
		if ($(this).hasClass('active')) return;
	
		$(this).parent().find('.active').removeClass('active');
		$(this).addClass('active');

		$(this).closest('.section-news').data('current-page_num', 1);
	
		ajaxResponsePosts($(this));
	});
	
	$(document).on('click', '.more-posts .view-more-link', function(e) {
		e.preventDefault();
	
		let currentPageNum = $(this).closest('.section-news').data('current-page_num');
		
		$(this).closest('.section-news').data('current-page_num', parseInt(currentPageNum) + 1);
		
		ajaxResponsePosts($(this));
	});

	$('.copy-link-btn').click(function(e) {
		e.preventDefault();
	
		let $button = $(this);
		let url = $button.data('url');
		let copiedText = $button.data('copied-text');
		let originalText = $button.html();
	
		if (navigator.clipboard && navigator.clipboard.writeText) {
			navigator.clipboard.writeText(url)
				.then(function() {
					$button.html(copiedText);
					setTimeout(function() {
						$button.html(originalText);
					}, 2000);
				})
				.catch(function(err) {
					console.error('Copy failed:', err);
				});
		} else {
			console.warn('Clipboard API not supported or not allowed.');
		}
	});

	$('[data-title]').initializeTooltip();

	function isElementInViewport(el) {
		let rect = el.getBoundingClientRect();
		return (
			rect.top >= 0 &&
			rect.left >= 0 &&
			rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
			rect.right <= (window.innerWidth || document.documentElement.clientWidth)
		);
	}

	function animateCount() {
		$('.count-value').each(function () {
			let $this = $(this);

			if ($this.hasClass('counted')) return;

			if (isElementInViewport(this)) {
				$this.addClass('counted');

				let target = parseInt($this.data('count') || $this.text(), 10);
				let duration = $this.data('duration') || 2000;

				if (!$this.data('count')) {
					$this.data('count', target);
				}

				$this.text('0');

				$({ Counter: 0 }).animate({
					Counter: target
				}, {
					duration: duration,
					easing: 'swing',
					step: function () {
						$this.text(Math.ceil(this.Counter));
					},
					complete: function () {
						$this.text(target);
					}
				});
			}
		});
	}

	animateCount();

	$('.accordion-header').click(function () {
		let item = $(this).closest('.accordion-item');
		let text = item.find('.accordion-content');

		if (!item.hasClass('active')) {
			$('.accordion-item.active')
				.removeClass('active')
				.find('.accordion-content')
				.slideUp(300);

			item.addClass('active');
			text.slideDown(300);
		} else {
			item.removeClass('active');
			text.slideUp(300);
		}
	});

	function initTabs() {
		$('.tabs li a, .program-content-all a').on('click', function(e) {
			e.preventDefault();
			
			let tabId = $(this).attr('href').replace('#', '');
			activateTab(tabId, true);
		});
		
		checkHashOnLoad();
		
		$(window).on('hashchange', function() {
			let hash = window.location.hash.replace('#', '');
			if (hash) {
				triggerTabClick(hash);
			}
		});
		
		function activateTab(tabId, updateUrl = false) {
			let tabLink = $('.tabs li a[href="#' + tabId + '"]');
			
			if (tabLink.length) {
				$('.tabs li').removeClass('active');
				tabLink.parent('li').addClass('active');
				
				$('.tab-content').removeClass('active');
				$('#' + tabId).addClass('active');
				
				if (updateUrl) {
					window.history.pushState(null, null, '#' + tabId);
				}
			}
		}
		
		function triggerTabClick(tabId) {
			let tabLink = $('.tabs li a[href="#' + tabId + '"]');
			if (tabLink.length) {
				tabLink.trigger('click');
			}
		}
    
    function checkHashOnLoad() {
        let hash = window.location.hash.replace('#', '');
        if (hash) {
            triggerTabClick(hash);
        }
    }
}

initTabs();

	let filterSection = '.wpc-filters-section',
		filterHeader  = '.wpc-filter-header';

	$(document).on('click', filterHeader, function(event) {
		$(filterSection).removeClass('active');
        $(this).closest(filterSection).addClass('active');
        event.stopPropagation();
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest(filterSection).length) {
            $(filterSection).removeClass('active');
        }
    });

	let data_categgory = '[data-category]';

	$('.section-filter .filter:not(#filter-news) .item .filter-link').on('click', function(e) {
		e.preventDefault();
	
		let target = $(this).parent().data('target');
		
		$('.section-filter .filter .item').removeClass('active');
		$(this).parent().addClass('active');
		
		if (target === 'all') {
			$(data_categgory).show();
		} else {
			$(data_categgory).hide();
			
			$(data_categgory).filter(function() {
				const categories = $(this).attr('data-category');
				if (!categories) return false;
				return categories.split(' ').includes(target);
			}).show();
		}
	});

	if ($('.wp-block-file a').length) {
        $('.wp-block-file a').attr({
            'target': '_blank',
            'rel': 'noopener'
        });
    }

});