(function ($) {

	"use strict";

	var high = $('.title-alt').height();
	$('.title-features').height(high);

	//Preloader
	$(window).on('load', function () {
		$('.images-preloader').fadeOut();
	});

	// --------------------------------------------------
	// tabs
	// --------------------------------------------------

	$('.ot-tabs .vc_tta-tab').on('click', 'a', function (e) {

		$('.ot-tabs .vc_tta-tabs-list').find('.vc_tta-tab').removeClass('vc_active');
		$(this).parent().addClass('vc_active');
		var id = $(this).attr('href').replace('#', '');
		$('.ot-tabs .vc_tta-panels').find('.vc_tta-panel').removeClass('vc_active').hide();
		$('.ot-tabs .vc_tta-panels').find('#' + id).addClass('vc_active').show();

		return false;
	});

	/* --------------------------------------------------
	 * counting number
	 * --------------------------------------------------*/
	var v_count = '0';
	function de_counter () {
		$('.timer').each(function () {
			var imagePos = $(this).offset().top;
			var topOfWindow = $(window).scrollTop();
			if (imagePos < topOfWindow + $(window).height() && v_count == '0') {
				$(function ($) {
					// start all the timers
					$('.timer').each(count);

					function count (options) {
						v_count = '1';
						var $this = $(this);
						options = $.extend({}, options || {}, $this.data('countToOptions') || {});
						$this.countTo(options);
					}
				});
			}
		});
	}

	/* --------------------------------------------------
	 * mobile menu
	 * --------------------------------------------------*/
	function menu_mobile () {
		$(".mobile-menu a").on("click", function () {
			$('.main-nav').toggle();
			return false;
		});
	}

	function menu_arrow () {
		// mainmenu create span
		$('#mainmenu li a').each(function () {
			if ($(this).next("ul").length > 0) {
				$("<span></span>").insertAfter($(this));
			}
		});
		// mainmenu arrow click
		$("#mainmenu li span").on("click", function () {
			var iteration = $(this).data('iteration') || 1;
			switch (iteration) {
				case 1:
					$(this).addClass("active");
					$(this).next().show();
					break;
				case 2:
					$(this).removeClass("active");
					$(this).next().hide();
					break;
			}
			iteration++;
			if (iteration > 2) iteration = 1;
			$(this).data('iteration', iteration);
		});
	}

	$(window).on('load', function () {
		menu_mobile();
		menu_arrow();
	});

	$(window).on("scroll", function () {
		de_counter();
	});

	//  ========== owl slider ============

	$(".blog-slide").owlCarousel({
		items: 1,
		singleItem: true,
		navigation: false,
		pagination: false,
		autoPlay: 5000
	});

	$(".testimonial-slider").owlCarousel({
		items: 1,
		singleItem: true,
		navigation: false,
		pagination: false,
		autoPlay: 7000
	});

	$(".testimonial-s2").owlCarousel({
		items: 1,
		singleItem: true,
		navigation: true,
		navigationText: [
			"<i class='fa fa-angle-left'></i>",
			"<i class='fa fa-angle-right'></i>"
		],
		transitionStyle: "fade",
		pagination: false,
		autoPlay: 7000
	});

	$(".datacenter").owlCarousel({
		items: 4,
		itemsDesktop: [1199, 4],
		itemsDesktopSmall: [979, 2],
		itemsTablet: [768, 1],
		itemsMobile: [479, 1],
		navigation: true,
		navigationText: [
			"<i class='fa fa-angle-left'></i>",
			"<i class='fa fa-angle-right'></i>"
		],
		pagination: false,
		margin: 20,
		autoPlay: 7000
	});

	$(".testimonial2").owlCarousel({
		items: 3,
		itemsDesktop: [1199, 3],
		itemsDesktopSmall: [979, 2],
		itemsTablet: [768, 1],
		itemsMobile: [479, 1],
		navigation: false,
		pagination: true,
		autoPlay: 7000
	});


	//  ============================= Magnifiq popup video  =============================

	var videoPopup = $(".video-popup");
	videoPopup.magnificPopup({
		type: 'iframe'

	});

	/* --------------------------------------------------
	 * plugin | isotope
	 * --------------------------------------------------*/

	var $container = $('#faqs-masonry');
	$container.isotope({
		itemSelector: '.item',
		filter: '*'
	});


	var $container = $('#gallery');
	$container.isotope({
		itemSelector: '.item',
		filter: '*'
	});
	$('#filters a').on("click", function () {
		var $this = $(this);
		if ($this.hasClass('selected')) {
			return false;
		}
		var $optionSet = $this.parents();
		$optionSet.find('.selected').removeClass('selected');
		$this.addClass('selected');
		var selector = $(this).attr('data-filter');
		$container.isotope({
			filter: selector
		});
		return false;
	});

	var scrollBtn = $('#scroll-top');
	$(window).on('scroll', function () {
		if ($(this).scrollTop() > 800) {
			scrollBtn.addClass('show');
		} else {
			scrollBtn.removeClass('show');
		}
	});

	scrollBtn.on('click', function () {
		$('html, body').animate({ scrollTop: 0 }, 1000, 'easeInOutExpo');
		return false;
	});

	$(document).on('keypress',function(e) {
		var searchBox = document.querySelector("#search_box").value;
		if(e.which == 13 && searchBox !== "") {
			$('html, body').animate({
				scrollTop: $("#domain-search-results-wrapper").offset().top
			}, 2000);
		}
	});


	$(".search_btn ").click(function (event) {
		var searchBox = document.querySelector("#search_box").value;
		if (searchBox !== "") {
			$('html, body').animate({
				scrollTop: $("#domain-search-results-wrapper").offset().top
			}, 2000);
		}

	});



})(jQuery);

