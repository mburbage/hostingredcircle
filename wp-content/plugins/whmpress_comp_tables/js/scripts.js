/**
 * Created by Abdul Waheed on 2/12/2016.
 */

// Function to initiate Slider
function runSlider( slider_id ) {
	var $slider_div = slider_id;
	var descTitles = [];
	var orderURLs = [];
	$slider_div.find( "#JS_Data li" ).each( function () {
		descTitles.push( jQuery( this ).data( "index" ) );
		orderURLs.push( jQuery( this ).data( "order" ) );
	} );
	$slider_div.find( ".wpct_slider_submit_button.no_multi a" ).attr( "href", orderURLs[0] );
	var initialValue = 1, min = 1, max = descTitles.length;
	$slider_div.find( ".wpct_packages_list > .wpct_package_title[data-index='1']" ).addClass( "active" );
	$slider_div.find( "#wpct_slider" ).slider( {
		value: initialValue,
		min: min,
		max: max,
		step: 1,
		range: "min",
		animate: true,
		// create: function (event, ui) {
		// 	var handle = $slider_div.find('.ui-slider-handle');
		// 	handle.append('<span>' + ui.value + '</span>')
		// },
		change: function ( event, ui ) {
			$slider_div.find( ".wpct_slider_content" ).addClass( "wpct_hidden" );
			$slider_div.find( "#description_" + ui.value ).removeClass( "wpct_hidden" );
			$slider_div.find( ".wpct_slider_discount" ).addClass( "wpct_hidden" );
			$slider_div.find( "#discount_" + ui.value ).removeClass( "wpct_hidden" );
			$slider_div.find( ".wpct_slider_head_prices" ).addClass( "wpct_hidden" );
			$slider_div.find( "#head_price_" + ui.value ).removeClass( "wpct_hidden" );

			$slider_div.find( ".wpct_price_sep" ).hide();
			$slider_div.find( "#wpct_price_" + ui.value ).show();
			$slider_div.find( ".wpct_slider_submit_button.no_multi a" ).attr( "href", orderURLs[ui.value - 1] );
			$slider_div.find( ".wpct_packages_list > .wpct_package_title" ).removeClass( "active" );
			$slider_div.find( ".wpct_packages_list > .wpct_package_title[data-index='" + ui.value + "']" ).addClass( "active" );
			$slider_div.find( ".wpct_slider_heading span" ).text( $slider_div.find( '.wpct_package_title li[data-index="' + ui.value + '"]' ).data( 'title' ) );

			//var handle = $slider_div.find('ui-slider-handle');
		},
		slide: function ( event, ui ) {
			$slider_div.find( ".wpct_slider_content" ).addClass( "wpct_hidden" );
			$slider_div.find( "#description_" + ui.value ).removeClass( "wpct_hidden" );
			$slider_div.find( ".wpct_slider_discount" ).addClass( "wpct_hidden" );
			$slider_div.find( "#discount_" + ui.value ).removeClass( "wpct_hidden" );
			$slider_div.find( ".wpct_slider_head_prices" ).addClass( "wpct_hidden" );
			$slider_div.find( "#head_price_" + ui.value ).removeClass( "wpct_hidden" );

			$slider_div.find( ".wpct_price_sep" ).hide();
			$slider_div.find( "#wpct_price_" + ui.value ).show();
			$slider_div.find( ".wpct_slider_submit_button.no_multi a" ).attr( "href", orderURLs[ui.value - 1] );
			$slider_div.find( ".wpct_packages_list > .wpct_package_title" ).removeClass( "active" );
			$slider_div.find( ".wpct_packages_list > .wpct_package_title[data-index='" + ui.value + "']" ).addClass( "active" );
			$slider_div.find( ".wpct_slider_heading span" ).text( $slider_div.find( '.wpct_package_title li[data-index="' + ui.value + '"]' ).data( 'title' ) );
		}
	} );
	$slider_div.find( ".wpct_packages_list li" ).on( "click", function () {
		var sliderValue = jQuery( this ).data( "index" );
		$slider_div.find( "#wpct_slider" ).slider( 'value', sliderValue );
	} );
	for ( var i = 2; i < max + 1; i ++ ) {
		var positionStep = 100 / (max - 1);
		var positionLeft = (i - 1) * positionStep;
		$slider_div.find( ".wpct_packages_list li:nth-child(" + i + ")" ).css( {
			"left": positionLeft + "%"
		} );
		$slider_div.find( ".wpct_slider_pipe:nth-child(" + i + ")" ).css( {
			"left": positionLeft + "%"
		} );
	}


}

// Function to toggle between prices of different durations like, monthly/yearly
function toggleComparisonPriceSlider( $slider ) {
	var $slider_div = $slider;
	$slider_div.find( '.wpct_price_toggle input[type="radio"]' ).on( 'change', function () {
		var duration = jQuery( this ).data( 'duration' );
		//var orderUrl = jQuery( this ).data( 'orderurl' );
		$slider_div.find( '.wpct_price > .wpct_holder' ).hide();
		$slider_div.find( '.wpct_price > .wpct_holder.' + duration ).show();
		$slider_div.find( '.wpct_button > .wpct_holder' ).hide();
		$slider_div.find( '.wpct_button > .wpct_holder.' + duration ).show();
		$slider_div.find( '.wpct_discounts_container > .wpct_holder' ).hide();
		$slider_div.find( '.wpct_discounts_container > .wpct_holder.' + duration ).show();
		jQuery( this ).toggleClass( 'active' );
	} );
}

// Function to toggle between prices of different durations like, monthly/yearly
function toggleComparisonPrice( table_id ) {
	var $table = table_id;
	$table.find( '.wpct_price_toggle input[type="radio"]' ).on( 'change', function () {
		var duration = jQuery( this ).data( 'duration' );
		//var orderUrl = jQuery( this ).data( 'orderurl' );
		$table.find( '.wpct_price > .wpct_holder' ).hide();
		$table.find( '.wpct_price > .wpct_holder.' + duration ).show();
		$table.find( '.wpct_discounts_container > .wpct_holder' ).hide();
		$table.find( '.wpct_discounts_container > .wpct_holder.' + duration ).show();
		$table.find( '.wpct_button > .wpct_holder' ).hide();
		$table.find( '.wpct_button > .wpct_holder.' + duration ).show();
		//$table.find('.wpct_submit.whmpress_order_button').attr('href', orderUrl);
		//$table.find('.wpct_submit-button').attr('href', orderUrl);
		jQuery( this ).toggleClass( 'active' );
	} );
}

// Function to run Carousel on pricing table groups.
function runCarousel( group ) {
	var $group = group;

	function hasDots() {
		return $group.hasClass( 'wpct_have_dots' );
	}


	var showLarge = ($group.data( 'show-1200' )) ? $group.data( 'show-1200' ) : 4;
	var showMedium = ($group.data( 'show-1024' )) ? $group.data( 'show-1024' ) : 3;
	var showSmall = ($group.data( 'show-768' )) ? $group.data( 'show-768' ) : 2;
	var showMobile = ($group.data( 'show-600' )) ? $group.data( 'show-600' ) : 1;

	var numTables = $group.find('.wpct_table_group_col').length;
	if (numTables <= showLarge) {
		showLarge = numTables;
	}
	if (numTables <= showMedium) {
		showMedium = numTables;
	}
	if (numTables <= showSmall) {
		showSmall = numTables;
	}
	if (numTables <= showMobile) {
		showMobile = numTables;
	}

	jQuery( document ).ready( function () {
		$group.find( '.wpct_group_carousel' ).slick( {
			slidesToShow: 3,
			slidesToScroll: 1,
			dots: hasDots(),
			prevArrow: '<button type="button" class="wpct_prev vhost_prev button"><i class="fa fa-angle-left"></i></button>',
			nextArrow: '<button type="button" class="wpct_next vhost_next button"><i class="fa fa-angle-right"></i></button>',
			customPaging: function ( slider, i ) {
				var price = jQuery( slider.$slides[i] ).data( 'plan-price' );
				if ( price ) {
					//return '<a>' + price + '</a><span></span>';
					return '<a>' + i + '</a><span></span>';
				}
				else {
					return '-';
				}
			},
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						slidesToShow: showMedium,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: showSmall,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 600,
					settings: {
						slidesToShow: showMobile,
						slidesToScroll: 1
					}
				}
			]
		} );
		var slickContainer = $group.find( '.slick-slider' );
		var slickDots = $group.find( 'ul.slick-dots' );
		slickContainer.prepend( slickDots );
	} );
}

// Function to initiate tooltip
jQuery( document ).on( 'ready', function () {

	jQuery( '.wpct_discounts_container' ).each( function () {
		var height = jQuery( this ).outerHeight( true );
		jQuery( this ).css( 'min-height', height );
	} );
	jQuery( '.wpct_have_carousel' ).each( function () {
		var groupID = jQuery(this).prop('id');
		runCarousel(jQuery('#' + groupID));
	});
	jQuery( '.wpct_comparison_has_toggle' ).each( function () {
		var groupID = jQuery(this).prop('id');
		toggleComparisonPrice(jQuery('#' + groupID));
	});
	jQuery( '.wpct_hosting_slider' ).each( function () {
		var groupID = jQuery(this).prop('id');
		runSlider(jQuery('#' + groupID));
	});
	jQuery( '.wpct_slider_has_toggle' ).each( function () {
		var groupID = jQuery(this).prop('id');
		toggleComparisonPriceSlider(jQuery('#' + groupID));
	});



	function toggleHideMobile() {
		jQuery( '[data-wpct-hide-mobile]' ).each( function () {
			var hideWidth = jQuery( this ).data( 'wpct-hide-mobile' );
			if ( jQuery( window ).width() < hideWidth ) {
				jQuery( this ).hide();
			}
			else {
				jQuery( this ).show();
			}
		} );
	}
	toggleHideMobile();
	jQuery( window ).on( 'resize', function () {
		toggleHideMobile();
	} );

} );










