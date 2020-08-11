(function ( $ ) {
	"use strict";
	$( document ).on( 'ready', function () {
		$( '.multi_durations' ).each( function () {
			var $table = jQuery( this );
			var duration = $table.find( 'input.duration' );
			var durationPlus = $table.find( '.duration_plus' );
			var durationMinus = $table.find( '.duration_minus' );

			$( durationPlus ).on( 'click', function ( e ) {
				e.preventDefault();
				if ( duration.val() < 10 ) {
					duration.val( parseInt( duration.val() ) + 1 );
					duration.trigger( 'change' );
				}
			} );
			$( durationMinus ).on( 'click', function ( e ) {
				e.preventDefault();
				if ( duration.val() > 1 ) {
					duration.val( parseInt( duration.val() ) - 1 );
					duration.trigger( 'change' );
				}
			} );
			duration.on( 'change', function () {
				var currDur = $( this ).val();
				$table.find( '.whmp_price' ).each( function () {
					var currPrice = $( this ).data( 'price' + currDur );
					$( this ).find( '.whmp_actual_price' ).html( currPrice );
				} );
				$table.find( '.whmp_no_years' ).each( function () {
					$( this ).text( ' (' + currDur + ') ' );
				} )
			} );

			$table.find( '.whmp_domain_type_toggle' ).each( function () {
				$( this ).on( 'click', function () {
					var curType = $( this ).data( 'tld-type' );
					$table.find( '.whmp_domain_matrix_row' ).each( function () {
						$( this ).css( 'display', 'none' );
						var curTypes = $( this ).data( 'tld-types' );
						if ( curType === "all" ) {
							$( this ).css( 'display', 'table-row' );
						}
						else if ( curTypes.indexOf( curType ) >= 0 ) {
							$( this ).css( 'display', 'table-row' );
						}

					} );
				} );
			} );

			$table.find( '.whmp_domain_special_toggle' ).each( function () {
				$( this ).on( 'click', function () {
					var curType = $( this ).data( 'tld-special' );
					$table.find( '.whmp_domain_matrix_row' ).each( function () {
						$( this ).css( 'display', 'none' );
						var curTypes = $( this ).data( 'tld-specials' );
						if ( curType === "all" ) {
							$( this ).css( 'display', 'table-row' );
						}
						else if ( curTypes.indexOf( curType ) >= 0 ) {
							$( this ).css( 'display', 'table-row' );
						}

					} );
				} );
			} );
		} );
		$( '.whmp_dropdown_outer' ).each( function () {
			var container = $( this );
			container.on( 'click', function ( e ) {
				e.stopPropagation();
			} );
			container.find( '.whmp_dropdown_toggle' ).on( 'click', function ( e ) {
				e.preventDefault();
				$( this ).parent( '.whmp_dropdown_outer' ).toggleClass( 'active' );
			} );
			$( document ).on( 'click', function () {
				container.removeClass( 'active' );
			} );
		} );
	} );
	$( document ).on( 'submit', '.whmpress_domain_search_ajax_extended_search_form', function ( e ) {

		var $form = $( this );
		if ( ($form.data( 'result_div_id' )) === undefined ) {
			e.preventDefault();
			var parent_container = $form.closest( '.whmpress_domain_search_ajax_extended_container' );
			var results_div = parent_container.find( '.whmpress_domain_search_ajax_extended_search_results' );


			var title_div = parent_container.find( '.whmpress_domain_search_ajax_extended_search_result_title' );
			var title_placeholder = parent_container.find( '.whmpress_domain_search_ajax_extended_search_result_title_placeholder' );
			var load_more_div = parent_container.find( '.whmpress_domain_search_ajax_extended_search_results_load_more' );
			var sld = $form.find( 'input[name="sld"]' ).val();
			var tld = $form.find( 'select[name="tld"]' ).val();

			title_div.empty().hide().removeClass( 'results_loaded' );
			results_div.empty().hide();
			whmpress_added_tlds = [];


			title_placeholder.find( '.sld_placeholder' ).text( sld );
			title_placeholder.find( '.tld_placeholder' ).text( tld );
			title_div.show().html( title_placeholder.html() );


			whmpress_added_tlds.push( tld );
			load_more_div.show().find( 'button.whmpress_domain_search_ajax_extended_search_load_more_button' ).trigger( 'click' );
		}
	} );
	$( document ).on( 'click', '.whmpress_domain_search_ajax_extended_search_load_more_button', function ( e ) {
		e.preventDefault();

		var parent_container = $( this ).closest( '.whmpress_domain_search_ajax_extended_container' );
		var $form = parent_container.find( 'form.whmpress_domain_search_ajax_extended_search_form' );
		var results_div = parent_container.find( '.whmpress_domain_search_ajax_extended_search_results' );
		var placeholders_div = parent_container.find( '.whmpress_domain_search_ajax_extended_search_results_placeholders' );
		var submit_field = $form.find( '[type="submit"]' );
		var submit_val = submit_field.html();
		var data = $form.serializeArray();


		var page_size = $form.find( 'input[name=page_size]' ).val();
		var sld = $form.find( 'input[name="sld"]' ).val();
		page_size = parseInt( page_size ) || 10;
		var counter = 0;

		results_div.show();
		$.each( whmpress_all_tlds, function ( i ) {
			if ( whmpress_added_tlds.indexOf( i ) > - 1 ) {
				return true;
			}
			if ( counter === page_size ) {
				return false;
			}
			placeholders_div.find( '.sld_placeholder' ).text( sld );
			placeholders_div.find( '.tld_placeholder' ).text( i );
			placeholders_div.find( 'input[name=tld]' ).val( i );
			var tempHTML = placeholders_div.html();
			results_div.append( tempHTML );
			whmpress_added_tlds.push( i );
			counter ++;
		} );

		$( parent_container ).find( '.whmpress_domain_search_ajax_extended_search_result_title:not(.results_loaded)' ).each( function () {
			var result_div = $( this );

			jQuery.ajax( {
				url: WHMPAjax.ajaxurl,
				type: 'post',
				data: data,
				success: function ( response ) {
					var res = JSON.parse( response );
					submit_field.html( submit_val );
					if ( res.status === "OK" ) {
						result_div.prop( 'outerHTML', res.response_html ).addClass( 'results_loaded' );
					}
					else {

					}
				}
			} );
		} );
		$( results_div ).find( '.whmpress_domain_search_ajax_extended_search_result:not(.results_loaded)' ).each( function () {
			var result_div = $( this );
			var tld = result_div.find( 'input[name="tld"]' ).val();
			$.each( data, function ( key, data ) {
				if ( this.name === "is_title" ) {
					this.value = '';
				}
				else if ( this.name === "tld" ) {
					this.value = tld;
				}
			} );
			jQuery.ajax( {
				url: WHMPAjax.ajaxurl,
				type: 'post',
				data: data,
				success: function ( response ) {
					var res = JSON.parse( response );
					submit_field.html( submit_val );
					if ( res.status === "OK" ) {
						result_div.prop( 'outerHTML', res.response_html ).addClass( 'results_loaded' );
					}
					else {

					}
				}
			} );


		} );

	} );
	$( document ).on( 'change', '.domain_duration_select', function () {
		var select = $( this );
		var duration = select.val();
		$( this ).closest( '.domain_duration' ).siblings( '.domain_price' ).find( '.domain_price_text' ).hide().siblings( '.duration' + duration ).show();
	} );
	jQuery( document ).ready( function () {
		jQuery( 'input:radio[name="extention_selection"]' ).change( function () {
			if ( jQuery( this ).val() === '0' ) { jQuery( '.extentions' ).css( 'display', 'none' ); }
			else { jQuery( '.extentions' ).css( 'display', 'block' ); }
		} );
	} );

}( jQuery ));