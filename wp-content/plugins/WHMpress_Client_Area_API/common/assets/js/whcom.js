var whcom_spinner_icon_only = '<i class="whcom_icon_spinner-1 whcom_animate_spin"></i>';
var whcom_spinner_icon = '<i class="whcom_icon_spinner-1 whcom_animate_spin"></i> ' + whcom_ajax.whcom_working_text;
var whcom_spinner_block = '<div class="whcom_text_center_xs"><i class="whcom_icon_spinner-1 whcom_animate_spin"></i> ' + whcom_ajax.whcom_loading_text + '</div>';




// Sticky Function
(function () {
	var $, win;

	$ = window.jQuery;

	win = $( window );

	$.fn.whcom_sticky = function ( opts ) {
		var doc, elm, enable_bottoming, fn, i, inner_scrolling, len, manual_spacer, offset_top, outer_width,
		    parent_selector, recalc_every, sticky_class;
		if ( opts == null ) {
			opts = {};
		}
		sticky_class = opts.sticky_class, inner_scrolling = opts.inner_scrolling, recalc_every = opts.recalc_every, parent_selector = opts.parent, offset_top = opts.offset_top, manual_spacer = opts.spacer, enable_bottoming = opts.bottoming;
		if ( offset_top == null ) {
			offset_top = 0;
		}
		if ( parent_selector == null ) {
			parent_selector = void 0;
		}
		if ( inner_scrolling == null ) {
			inner_scrolling = true;
		}
		if ( sticky_class == null ) {
			sticky_class = "is_stuck";
		}
		doc = $( document );
		if ( enable_bottoming == null ) {
			enable_bottoming = true;
		}
		outer_width = function ( el ) {
			var _el, computed, w;
			if ( window.getComputedStyle ) {
				_el = el[0];
				computed = window.getComputedStyle( el[0] );
				w = parseFloat( computed.getPropertyValue( "width" ) ) + parseFloat( computed.getPropertyValue( "margin-left" ) ) + parseFloat( computed.getPropertyValue( "margin-right" ) );
				if ( computed.getPropertyValue( "box-sizing" ) !== "border-box" ) {
					w += parseFloat( computed.getPropertyValue( "border-left-width" ) ) + parseFloat( computed.getPropertyValue( "border-right-width" ) ) + parseFloat( computed.getPropertyValue( "padding-left" ) ) + parseFloat( computed.getPropertyValue( "padding-right" ) );
				}
				return w;
			}
			else {
				return el.outerWidth( true );
			}
		};
		fn = function ( elm, padding_bottom, parent_top, parent_height, top, height, el_float, detached ) {
			var bottomed, detach, fixed, last_pos, last_scroll_height, offset, parent, recalc, recalc_and_tick,
			    recalc_counter, spacer, tick;
			if ( elm.data( "sticky_kit" ) ) {
				return;
			}
			elm.data( "sticky_kit", true );
			last_scroll_height = doc.height();
			parent = elm.parent();
			if ( parent_selector != null ) {
				parent = parent.closest( parent_selector );
			}
			if ( ! parent.length ) {
				throw "failed to find stick parent";
			}
			fixed = false;
			bottomed = false;
			spacer = manual_spacer != null ? manual_spacer && elm.closest( manual_spacer ) : $( "<div />" );
			if ( spacer ) {
				spacer.css( 'position', elm.css( 'position' ) );
			}
			recalc = function () {
				var border_top, padding_top, restore;
				if ( detached ) {
					return;
				}
				last_scroll_height = doc.height();
				border_top = parseInt( parent.css( "border-top-width" ), 10 );
				padding_top = parseInt( parent.css( "padding-top" ), 10 );
				padding_bottom = parseInt( parent.css( "padding-bottom" ), 10 );
				parent_top = parent.offset().top + border_top + padding_top;
				parent_height = parent.height();
				if ( fixed ) {
					fixed = false;
					bottomed = false;
					if ( manual_spacer == null ) {
						elm.insertAfter( spacer );
						spacer.detach();
					}
					elm.css( {
						position: "",
						top: "",
						width: "",
						bottom: ""
					} ).removeClass( sticky_class );
					restore = true;
				}
				top = elm.offset().top - (
					parseInt( elm.css( "margin-top" ), 10 ) || 0
				) - offset_top;
				height = elm.outerHeight( true );
				el_float = elm.css( "float" );
				if ( spacer ) {
					spacer.css( {
						width: outer_width( elm ),
						height: height,
						display: elm.css( "display" ),
						"vertical-align": elm.css( "vertical-align" ),
						"float": el_float
					} );
				}
				if ( restore ) {
					return tick();
				}
			};
			recalc();
			if ( height === parent_height ) {
				return;
			}
			last_pos = void 0;
			offset = offset_top;
			recalc_counter = recalc_every;
			tick = function () {
				var css, delta, recalced, scroll, will_bottom, win_height;
				if ( detached ) {
					return;
				}
				recalced = false;
				if ( recalc_counter != null ) {
					recalc_counter -= 1;
					if ( recalc_counter <= 0 ) {
						recalc_counter = recalc_every;
						recalc();
						recalced = true;
					}
				}
				if ( ! recalced && doc.height() !== last_scroll_height ) {
					recalc();
					recalced = true;
				}
				scroll = win.scrollTop();
				if ( last_pos != null ) {
					delta = scroll - last_pos;
				}
				last_pos = scroll;
				if ( fixed ) {
					if ( enable_bottoming ) {
						will_bottom = scroll + height + offset > parent_height + parent_top;
						if ( bottomed && ! will_bottom ) {
							bottomed = false;
							elm.css( {
								position: "fixed",
								bottom: "",
								top: offset
							} ).trigger( "sticky_kit:unbottom" );
						}
					}
					if ( scroll < top ) {
						fixed = false;
						offset = offset_top;
						if ( manual_spacer == null ) {
							if ( el_float === "left" || el_float === "right" ) {
								elm.insertAfter( spacer );
							}
							spacer.detach();
						}
						css = {
							position: "",
							width: "",
							top: ""
						};
						elm.css( css ).removeClass( sticky_class ).trigger( "sticky_kit:unstick" );
					}
					if ( inner_scrolling ) {
						win_height = win.height();
						if ( height + offset_top > win_height ) {
							if ( ! bottomed ) {
								offset -= delta;
								offset = Math.max( win_height - height, offset );
								offset = Math.min( offset_top, offset );
								if ( fixed ) {
									elm.css( {
										top: offset + "px"
									} );
								}
							}
						}
					}
				}
				else {
					if ( scroll > top ) {
						fixed = true;
						css = {
							position: "fixed",
							top: offset
						};
						css.width = elm.css( "box-sizing" ) === "border-box" ? elm.outerWidth() + "px" : elm.width() + "px";
						elm.css( css ).addClass( sticky_class );
						if ( manual_spacer == null ) {
							elm.after( spacer );
							if ( el_float === "left" || el_float === "right" ) {
								spacer.append( elm );
							}
						}
						elm.trigger( "sticky_kit:stick" );
					}
				}
				if ( fixed && enable_bottoming ) {
					if ( will_bottom == null ) {
						will_bottom = scroll + height + offset > parent_height + parent_top;
					}
					if ( ! bottomed && will_bottom ) {
						bottomed = true;
						if ( parent.css( "position" ) === "static" ) {
							parent.css( {
								position: "relative"
							} );
						}
						return elm.css( {
							position: "absolute",
							bottom: padding_bottom,
							top: "auto"
						} ).trigger( "sticky_kit:bottom" );
					}
				}
			};
			recalc_and_tick = function () {
				recalc();
				return tick();
			};
			detach = function () {
				detached = true;
				win.off( "touchmove", tick );
				win.off( "scroll", tick );
				win.off( "resize", recalc_and_tick );
				$( document.body ).off( "sticky_kit:recalc", recalc_and_tick );
				elm.off( "sticky_kit:detach", detach );
				elm.removeData( "sticky_kit" );
				elm.css( {
					position: "",
					bottom: "",
					top: "",
					width: ""
				} );
				parent.position( "position", "" );
				if ( fixed ) {
					if ( manual_spacer == null ) {
						if ( el_float === "left" || el_float === "right" ) {
							elm.insertAfter( spacer );
						}
						spacer.remove();
					}
					return elm.removeClass( sticky_class );
				}
			};
			win.on( "touchmove", tick );
			win.on( "scroll", tick );
			win.on( "resize", recalc_and_tick );
			$( document.body ).on( "sticky_kit:recalc", recalc_and_tick );
			elm.on( "sticky_kit:detach", detach );
			return setTimeout( tick, 0 );
		};
		for ( i = 0, len = this.length; i < len; i ++ ) {
			elm = this[i];
			fn( $( elm ) );
		}
		return this;
	};

}).call( this );
(function ( $ ) {

	window.renderWhcomTabs = function () {
		$( '.whcom_tabs_container' ).each( function () {
			var $tabs_container = $( this );
			$tabs_container.find( '.whcom_tab_link' ).on( 'click', function ( e ) {
				e.stopPropagation();
				var tabID = $( this ).data( 'tab' );
				$( this ).siblings( '.whcom_tab_link' ).removeClass( 'active' );
				$( this ).addClass( 'active' );
				$( this ).closest( '.whcom_tabs_container' ).find( '.whcom_tabs_content' ).removeClass( 'active' );
				$( this ).closest( '.whcom_tabs_container' ).find( '#' + tabID ).addClass( 'active' );
				$( this ).trigger( 'whcomTabChanged' );
			} );
		} );
	};

	window.renderWhcomModal = function () {
		$( document ).on( 'click', '.whcom_modal_opener', function ( e ) {
			e.preventDefault();
			var modalBoxID = $( this ).data( 'modal-id' );
			var modalBox = $( "#" + modalBoxID );
			var overlay = ('<div class=" whcom_modal_overlay " id="overlay_" + modalBoxID + ""></div>');
			var overlayDiv = $( "#overlay_" + modalBoxID );

			modalBox.after( overlay );
			modalBox.slideDown( 500 );
			overlayDiv.fadeTo( 500, 0.7 );

			$( document ).on( 'click', '.whcom_modal_overlay, .whcom_modal_close', function ( c ) {
				c.preventDefault();
				$( ".whcom_modal_box, .whcom_modal_overlay" ).fadeOut( 500, function () {
					$( ".whcom_modal_overlay" ).remove();
				} );
			} );


			$( window ).resize( function () {
				modalBox.css( {
					left: (
						      $( window ).width() - modalBox.outerWidth()
					      ) / 2
				} );
			} );
			$( window ).resize();
		} );
	};

	window.renderWhcomDropdown = function () {
//			$( '.whcom_dropdown' ).each( function () {
//				var container = $( this );
//				container.on( 'click', function ( e ) {
//					e.stopPropagation();
//				} );
//				container.find( '.whcom_dropdown_toggle' ).on( 'click', function ( e ) {
//					e.preventDefault();
//					container.toggleClass( 'active' );
//				} );
//				$( document ).on( 'click', function () {
//					container.removeClass( 'active' );
//				} );
//			} );
	};


	$( document ).on( 'click', '.whcom_dropdown_toggle', function ( e ) {
		e.preventDefault();
		var container = $( this ).closest( '.whcom_dropdown' );
		container.on( 'click', function ( e ) {
			//e.stopPropagation();
		} );
		container.toggleClass( 'active' );

		$( document ).on( 'click', function () {
			//container.removeClass( 'active' );
		} );
	} );

	window.renderWhcomCollapse = function () {
		$( '.whcom_collapse' ).each( function () {
			var container = $( this );
			var content = container.find( '.whcom_collapse_content' );
			container.on( 'click', function ( e ) {
				e.stopPropagation();
			} );
			container.find( '.whcom_collapse_toggle' ).on( 'click', function ( e ) {
				e.preventDefault();
				var isActive = container.hasClass( 'active' );
				if ( isActive ) {
					content.slideUp( 500, function () {
						container.removeClass( 'active' );
					} );
				}
				else {
					content.slideDown( 500, function () {
						container.addClass( 'active' );
					} );
				}
			} );
		} );
	};

	window.renderWhcomAccordion = function () {
		$( '.whcom_accordion' ).each( function () {
			var $tabs_container = $( this );
			$tabs_container.find( '.whcom_accordion_toggle' ).on( 'click', function ( e ) {
				e.stopPropagation();
				var accordionID = $( this ).data( 'accordion' );
				$( this ).siblings( '.whcom_accordion_toggle' ).removeClass( 'active' );
				$( this ).addClass( 'active' );
				$( this ).closest( '.whcom_accordion' ).children( '.whcom_accordion_content:not(#' + accordionID + ')' ).slideUp( 500 ).removeClass( 'active' );

				var activeAccordion = $( this ).closest( '.whcom_accordion' ).find( '#' + accordionID );
				if ( activeAccordion.hasClass( 'active' ) ) {
					$( this ).removeClass( 'active' );
					activeAccordion.slideUp( 500, function () {
						activeAccordion.removeClass( 'active' )
					} );
				}
				else {
					activeAccordion.slideDown( 500, function () {
						activeAccordion.addClass( 'active' );
					} );
				}
			} );
		} );
	};

	window.whcom_show_notification = function ( text = undefined, message_type = 'success_message' ) {
		console.log( 'show notification running' );
		if ( text ) {
			let animation_container = $( '.whcom_notification' );
			let new_class = message_type + ' whcom_notification_active';
			animation_container.html( text ).addClass( new_class );
			setTimeout( function () {
				animation_container.removeClass( new_class );
			}, 3000 );
		}
	};

	window.initWhcom = function () {
		window.renderWhcomTabs();
		window.renderWhcomModal();
		window.renderWhcomDropdown();
		window.renderWhcomCollapse();
		window.renderWhcomAccordion();
	};


	"use strict";
	$( document ).on( 'ready', function () {
		window.initWhcom();
		window.whcomChangeState();
		$(document).on('change', '[name="country"]', function () {
			whcomChangeState();
		});
		$( ".whcom_sticky_item" ).each( function () {
			var offsetTop = $( this ).data( 'nav-top-gap' ) || 20;
			$( this ).whcom_sticky( {
				'parent': '.whcom_main',
				'offset_top': offsetTop,
				'recalc_every': 1
			} );
		} );
	} );

	// WHCOM plus minus
	$( document ).on( 'click', '.whcom_plus', function ( e ) {
		e.preventDefault();
		var num_input = $( this ).siblings( 'input[type=number]' );
		var num_val = parseInt( num_input.val() );
		var max_val = parseInt( num_input.prop( 'max' ) ) || 999999;
		var min_val = parseInt( num_input.prop( 'min' ) ) || 0;
		var new_val = num_val + 1;
		if ( (
			     min_val <= new_val
		     ) && (
			     new_val <= max_val
		     ) ) {
			num_input.val( new_val ).trigger( 'change' );
		}
	} );
	$( document ).on( 'click', '.whcom_minus', function ( e ) {
		e.preventDefault();
		var num_input = $( this ).siblings( 'input[type=number]' );
		var num_val = parseInt( num_input.val() );
		var max_val = parseInt( num_input.prop( 'max' ) ) || 999999;
		var min_val = parseInt( num_input.prop( 'min' ) ) || 0;
		var new_val = num_val - 1;
		if ( (
			     min_val <= new_val
		     ) && (
			     new_val <= max_val
		     ) ) {
			num_input.val( new_val ).trigger( 'change' );
		}
	} );

	$( document ).on( 'keyup input', '#whcom_tld_fields_live_search', function () {
		var tld = $( this ).val();
		$( '#whcom_tld_fields_live_search_div' ).find( '.whcom_collapse' ).each( function () {
			var tld_tag = $( this ).data( 'tld-name' );
			if ( tld_tag.indexOf( tld ) !== - 1 ) {
				$( this ).show();
			}
			else {
				$( this ).hide();
			}
		} );
	} );

	$( document ).on( 'change', '.whcom_radio input', function () {
		var item = $( this );
		var itemName = item.prop( 'name' );
		$( 'input[type="radio"][name="' + itemName + '"]' ).each( function () {
			var label = $( this ).closest( 'label' );
			if ( $( this ).is( ':checked' ) ) {
				label.addClass( 'whcom_checked' );
			}
			else {
				label.removeClass( 'whcom_checked' );
			}
		} );
	} );
	$( document ).on( 'change', '.whcom_checkbox input', function () {
		var item = $( this );
		var label = item.closest( 'label' );
		if ( item.prop( 'checked' ) ) {
			label.addClass( 'whcom_checked' );
		}
		else {
			label.removeClass( 'whcom_checked' );
		}
	} );
	$( document ).on( 'focusin', '.whcom_form_field select', function () {
		var item = $( this );
		item.parent('div').addClass('whcom_select_focused');
	} );
	$( document ).on( 'focusout', '.whcom_form_field select', function () {
		var item = $( this );
		item.parent('div').removeClass('whcom_select_focused');
	} );

	// Smooth_scroll {
	$( document ).on( 'click', 'a.whcom_smooth_scroll', function ( event ) {
		event.preventDefault();
		if ( this.hash !== "" ) {
			event.preventDefault();
			var offset = $( this ).data( 'scroll-top-gap' ) || 20;
			var speed = 1000;
			var target = $( this.hash );
			var hash = this.hash;

			$( 'html, body' ).animate( {
				scrollTop: target.offset().top - offset
			}, speed );
		}
		$( this ).closest( 'li' ).trigger( 'click' );
		return false;
	} );

	// General AJAX form processor
	$( document ).on( 'submit', '.whcom_ajax_form', function ( e ) {
		e.preventDefault();
		var form = $( this );

		var submit = form.find( 'button[type="submit"]' );
		var submit_val = submit.html();

		var response_text = form.find( '.whcom_op_df_response_text' );

		var whcom_main = form.parents( 'whcom_main' );

		var data = form.serializeArray();

		submit.html( whcom_spinner_icon );

		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				submit.html( submit_val );
				if ( res.status === "OK" ) {
					result.html( res.response_form ).show();
				}
				else {
					result.html( res.message ).show();
				}
			}
		} );
	} );

	// WHCOM Client Registration Form
	$( document ).on( 'submit', '.whcom_register_client_form', function ( e ) {
		e.preventDefault();
		var form = $( this );

		var submit = form.find( 'button[type="submit"]' );
		var submit_val = submit.html();

		var response_text = form.find( '.whcom_op_df_response_text' );

		var whcom_main = form.parents( 'whcom_main' );

		var data = form.serializeArray();

		submit.html( whcom_spinner_icon );

		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				submit.html( submit_val );
				if ( res.status === "OK" ) {
					result.html( res.response_form ).show();
				}
				else {
					result.html( res.message ).show();
				}
			}
		} );
	} );

	// WHCOM Add/update Item to cart form
	$( document ).on( 'submit', '.whcom_add_update_cart_item_form', function ( e ) {
		e.preventDefault();
		var form = $( this );

		var submit = form.find( 'button[type="submit"]' );
		var submit_val = submit.html();

		var response_text = form.find( '.whcom_op_df_response_text' );

		var whcom_main = form.parents( 'whcom_main' );

		var data = form.serializeArray();

		submit.html( whcom_spinner_icon );

		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				submit.html( submit_val );
				if ( res.status === "OK" ) {
					result.html( res.response_form ).show();
				}
				else {
					result.html( res.message ).show();
				}
			}
		} );
	} );

	// WHCOM Delete Item from cart
	$( document ).on( 'submit', '.whcom_delete_cart_item_form', function ( e ) {
		e.preventDefault();
		var form = $( this );

		var submit = form.find( 'button[type="submit"]' );
		var submit_val = submit.html();

		var response_text = form.find( '.whcom_op_df_response_text' );

		var whcom_main = form.parents( 'whcom_main' );

		var data = form.serializeArray();

		submit.html( whcom_spinner_icon );

		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				submit.html( submit_val );
				if ( res.status === "OK" ) {
					result.html( res.response_form ).show();
				}
				else {
					result.html( res.message ).show();
				}
			}
		} );
	} );

	// WHCOM Update current currency
	$( document ).on( 'click', '.whcom_currency_updater_item', function ( e ) {
		e.preventDefault();

		var button = $( this );
		var button_html = button.html();
		var data = {};
		data.action = "whcom_currency_updater_item";
		data.currency_id = button.data( 'currency-id' );

		button.html( whcom_spinner_icon );
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				button.html( button_html );
				if ( res.status === "OK" ) {
					window.location.reload();
				}
			}
		} );
	} );


}( jQuery ));
// Order Process functions
(function ( $ ) {

	// Main Repopulating Handler for Product and Domain Configuration pages
	$( document ).on( 'change', '.whcom_op_main input, .whcom_op_main select', function () {
		var input = $( this );
		if ( input.hasClass( 'whcom_op_input' ) ) {
			whcom_op_update_product_summary();
		}
		if ( input.hasClass( 'whcom_op_update_product_options' ) ) {
			whcom_op_update_product_options();
		}
		if ( input.hasClass( 'whcom_op_update_cart_summaries' ) ) {
			whcom_op_update_cart_summaries();
		}
	} );
	$( document ).on( 'change', '.whcom_addon_input', function () {
		var input = $( this );
		if ( input.prop( 'checked' ) ) {
			input.parents( '.whcom_op_addon_container' ).find( '.whcom_addon_add_button' ).hide();
			input.parents( '.whcom_op_addon_container' ).find( '.whcom_addon_remove_button' ).show();
		}
		else {
			input.parents( '.whcom_op_addon_container' ).find( '.whcom_addon_add_button' ).show();
			input.parents( '.whcom_op_addon_container' ).find( '.whcom_addon_remove_button' ).hide();
		}
	} );


	// Document Ready functions
	$( document ).on( 'ready', function () {
		$( '.whcom_op_submit_on_load' ).submit().removeClass( 'whcom_op_submit_on_load' );
		$( '.whcom_addon_input' ).first().trigger( 'change' );
		whcom_op_update_cart_summaries();
		whcom_op_update_product_summary();
	} );


	// WHMPress: domain search ajax related functionality
	$( document ).on( 'click', 'button.whcom_op_add_domain_whmp, a.whcom_op_remove_domain_whmp', function ( e ) {
		e.preventDefault();
		var button = $( this );
		var button_text = button.html();
		var domain_container = button.closest( '.whcom_op_whmp_domain_container' );
		var add_button = domain_container.find( '.whcom_op_add_domain_whmp' );
		var added_button = domain_container.find( '.whcom_op_added_domain_whmp' );
		var remove_button = domain_container.find( '.whcom_op_remove_domain_whmp' );
		var cart_index = domain_container.find( 'input[name=cart_index]' );
		var domain = domain_container.find( 'input[name=domain]' );
		var regperiod = domain_container.find( '[name=regperiod]' );
		var domaintype = domain_container.find( 'input[name=domaintype]' );
		var domain_action = 'add_domain';
		if ( button.hasClass( 'whcom_op_remove_domain_whmp' ) ) {
			domain_action = 'remove_domain';
		}

		var data = {};
		data.action = "whcom_op";
		data.whcom_op_what = 'add_remove_domain_whmp';
		data.cart_index = cart_index.val();
		data.domain_action = domain_action;
		data.domain = domain.val();
		data.domaintype = domaintype.val();
		data.regperiod = regperiod.val();

		button.html( whcom_spinner_icon_only );
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				console.log( res );
				if ( res.status === "OK" ) {
					button.html( button_text );
					if ( domain_action === 'add_domain' ) {
						add_button.hide();
						added_button.show();
						remove_button.show();
						cart_index.val( res.cart_index );
					}
					else {
						add_button.show();
						added_button.hide();
						remove_button.hide();
					}
				}
				else {
				}
			}
		} );
	} );
	$( document ).on( 'click', '.whmpress_domain_search_ajax_extended_continue_button', function (e) {
		var parent_form = $('.whmpress_domain_search_ajax_extended_container');
		var added_tlds = parent_form.find('.whcom_op_remove_domain_whmp:visible').length;
		if (added_tlds < 1) {
			e.preventDefault();
			alert(whcom_ajax.whcom_no_domain_added_text);
		}
	} );


	// Domain only related functions
	// Check Domain
	$( document ).on( 'submit', '.whcom_op_check_domain', function ( e ) {
		e.preventDefault();
		var form = $( this );
		var submit = form.find( 'button[type="submit"]' );
		var submit_html = submit.html();
		var response_text = $( '.whcom_op_domain_action_response_text' );
		var response_form = $( '.whcom_op_domain_action_response_form' );

		var data = $( this ).serializeArray();

		submit.html( whcom_spinner_icon );
		response_text.empty().hide();
		response_form.empty().hide();

		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				submit.html( submit_html );
				response_text.html( res.message ).slideDown( 500 );
				if ( res.status === "OK" ) {
					response_form.html( res.response_form ).slideDown( 500 );
				}
			}
		} );
	} );
	// Add Domain to local cart Form
	$( document ).on( 'submit', '.whcom_op_add_domain_to_cart', function ( e ) {
		e.preventDefault();
		var $form = $( this );
		var response_field = $form.find( '.whcom_op_domain_config_response_text' );


		var data = $( this ).serializeArray();
		response_field.show();
		response_field.html( whcom_spinner_icon );
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				response_field.text( res.message );
				if ( res.status === "OK" ) {
					window.location.href = res.redirect_url;
				}
				response_field.removeClass( 'alert-info' );
			}
		} );
	} );


	// Product related functions
	// Select Product Domain Option
	$( document ).on( 'change', 'input[name="whcom_op_product_domain_option_selector"]', function () {
		$( '.whcom_op_product_domain_option_form' ).hide();
		$( '#' + $( this ).val() ).show();
	} );
	// Check Product Domain
	$( document ).on( 'submit', '.whcom_op_check_product_domain', function ( e ) {
		e.preventDefault();
		var form = $( this );
		var response_container = $( '.whcom_op_domain_response' );
		var submit = form.find( 'button[type="submit"]' );
		var submit_val = submit.html();

		var data = $( this ).serializeArray();

		if ( form.hasClass( 'domain_already_in_cart' ) ) {
			var tld = form.find( 'select[name="domain"] :selected' ).data( 'domain-tld' );
			var domain_type = form.find( 'select[name="domain"] :selected' ).data( 'domain-type' );
			var cart_index = form.find( 'select[name="domain"] :selected' ).data( 'cart-index' );
			data.push( {'name': 'ext', 'value': tld} );
			data.push( {'name': 'cart_index', 'value': cart_index} );
			data.push( {'name': 'domaintype', 'value': domain_type} );
		}
		submit.html( whcom_spinner_icon );
		response_container.html( whcom_spinner_block );
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				submit.html( submit_val );
				if ( res.status === "OK" ) {
					response_container.html( res.domain_attachment_form );
					if ( res.type === 'existing' ) {
						$( '.whcom_op_attach_product_domain' ).submit();
					}
					if ( form.hasClass( 'domain_already_in_cart' ) ) {
						$( '.whcom_op_attach_product_domain' ).submit();
					}
				}
				else {
					response_container.html( res.message );
				}
			}
		} );
	} );
	// Attach Product Domain
	$( document ).on( 'submit', '.whcom_op_attach_product_domain', function ( e ) {
		e.preventDefault();
		var form = $( this );
		var product_container = $( '.whcom_op_product_container' );
		var product_domain_container = $( '.whcom_op_product_domain_container' );
		var domain_options_container = $( '.whcom_op_product_domain_config_container' );
		var domain_free_tlds_info = $( '.whcom_op_free_tlds' );
		var submit = form.find( 'button[type="submit"]' );
		var submit_val = submit.html();

		var data = $( this ).serializeArray();
		submit.html( whcom_spinner_icon );
		domain_options_container.slideUp( 300 ).html( '' );
		domain_free_tlds_info.hide();
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				submit.html( submit_val );
				if ( res.status === "OK" ) {
					domain_options_container.html( res.domain_config_form ).show();
					product_container.slideDown( 500 );
					domain_free_tlds_info.show();
					product_domain_container.html( res.message ).fadeOut( 2000 );
					$( document ).trigger( 'scroll' );
					console.log( 'Okay' );
					whcom_op_update_product_summary();
				}
				else {
					form.html( res.message );
					window.location.reload();
				}
			}
		} );
	} );
	// Add Product to local cart Form
	$( document ).on( 'submit', '.whcom_op_add_product', function ( e ) {
		e.preventDefault();
		var $form = $( this );
		var response_field = $form.find( '.whcom_op_response' );
		var submit_field = $form.find( '.whcom_op_product_submit' );


		var data = $( this ).serializeArray();
		response_field.show();
		response_field.html( whcom_spinner_icon );
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				response_field.text( res.message );
				if ( res.status === "OK" ) {
					submit_field.find( 'button' ).text( whcom_ajax.whcom_redirecting_text );
					if ( res.redirect_url !== undefined ) {
						window.location.href = res.redirect_url;
					}
				}
				else {

				}
				response_field.removeClass( 'alert-info' );
			}
		} );
	} );
	// Add Product to local cart Form
	$( document ).on( 'submit', '.whcom_op_domains_config_form', function ( e ) {
		e.preventDefault();
		var $form = $( this );
		var response_field = $form.find( '.whcom_op_response' );
		var submit_field = $form.find( '.whcom_op_domains_submit' );


		var data = $( this ).serializeArray();
		response_field.show();
		response_field.html( whcom_spinner_icon );
		submit_field.html( whcom_spinner_icon );
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				response_field.text( res.message );
				if ( res.status === "OK" ) {
					submit_field.text( whcom_ajax.whcom_redirecting_text );
					if ( res.redirect_url !== undefined ) {
						window.location.href = res.redirect_url;
					}
				}
				else {

				}
				response_field.removeClass( 'alert-info' );
			}
		} );
	} );


	// Cart related functions

	// Register/Login toggle,
	$( document ).on( 'click', '#whcom_op_register_link', function ( e ) {
		$( '#whcom_op_register_link' ).fadeOut( '', function () {
			$( '#whcom_op_login_link' ).fadeIn( '', function () {
				$( '#whcom_op_login_container' ).slideUp( '', function () {
					$( '#whcom_op_register_container' ).slideDown( '', function () {
						$( '#whcom_op_client_type' ).val( 'register' );
					} );
				} );
			} );
		} );
	} );
	$( document ).on( 'click', '#whcom_op_login_link', function ( e ) {
		$( '#whcom_op_login_link' ).fadeOut( '', function () {
			$( '#whcom_op_register_link' ).fadeIn( '', function () {
				$( '#whcom_op_register_container' ).slideUp( '', function () {
					$( '#whcom_op_login_container' ).slideDown( '', function () {
						$( '#whcom_op_client_type' ).val( 'login' );
					} );
				} );
			} );
		} );
	} );

	// Delete cart item
	$( document ).on( 'click', '.whcom_op_delete_cart_item', function ( e ) {
		e.preventDefault();

		var confirm_delete = confirm( whcom_ajax.whcom_delete_cart_item_text );

		if ( ! confirm_delete ) {
			return;
		}

		var button = $( this );


		var data = {};
		data.action = "whcom_op";
		data.whcom_op_what = "delete_cart_item";
		data.cart_index = button.data( 'cart-index' );

		button.html( whcom_spinner_icon );

		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				if ( res.status === "OK" ) {
					whcom_op_update_cart_summaries();
					if ( $( '.whcom_main' ).hasClass( 'wcop_main' ) ) {
						wcop_update_cart_summaries();
					}
				}
				else {
					alert( res.message );
					//window.location.reload();
				}
			}
		} );
	} );
	// Empty Cart
	$( document ).on( 'submit', '.whcom_op_reset_cart_form', function ( e ) {
		e.preventDefault();
		var $form = $( this );
		var response_field = $form.find( '.whcom_op_response' );
		var confirm_string = $form.find( 'input[name="confirm_string"]' ).val();
		var confirm = window.confirm( confirm_string );
		if ( confirm === true ) {
			var data = $( this ).serializeArray();
			response_field.show();
			response_field.html( whcom_spinner_icon );
			response_field.addClass( 'alert-info' );
			jQuery.ajax( {
				url: whcom_ajax.ajax_url,
				type: 'post',
				data: data,
				success: function ( response ) {
					var res = JSON.parse( response );
					response_field.text( res.message );
					if ( res.status === "OK" ) {
						window.location.reload();
					}
				}
			} );
		}
	} );
	// Review and Continue to Checkout page.
	$( document ).on( 'submit', '.whcom_op_review_form', function ( e ) {
		e.preventDefault();
		var $form = $( this );
		var response_field = $form.find( '.whcom_op_response' );
		var submit_field = $form.find( '.whcom_universal_checkout_button' );


		var data = $( this ).serializeArray();
		response_field.show();
		response_field.html( whcom_spinner_icon );
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				response_field.text( res.message );
				if ( res.status === "OK" ) {
					submit_field.find( 'button' ).text( whcom_ajax.whcom_redirecting_text );
					if ( res.redirect_url !== undefined ) {
						window.location.href = res.redirect_url;
					}
				}
				else {

				}
				response_field.removeClass( 'alert-info' );
			}
		} );
	} );
	// Submit Order
	$( document ).on( 'submit', '.whcom_op_checkout_form', function ( e ) {
		e.preventDefault();
		var form = $( this );
		var response_text = form.find( '.whcom_op_response' );
		var response_form = $( '.whcom_op_checkout_form' );
		var submit_container = form.find( '.whcom_op_submit_container' );
		var submit = submit_container.find( 'button' );
		var submit_val = submit.html();


		var data = $( this ).serializeArray();
		submit.html( whcom_spinner_icon );
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				window.scrollTo(0,0);
				var res = JSON.parse( response );
				console.log( res );
				submit.html( submit_val );
				response_text.show();
				if ( res.status === "OK" ) {
					if ( res.show_cc === 'yes' ) {
						response_form.html( res.response_form );
					}
					else {
						$( '.whcom_page_heading' ).empty().removeClass( 'whcom_page_heading' ).addClass( 'whcom_margin_bottom_45' );
						$( '.whcom_page_sub_heading' ).hide();
						response_form.html( res.response_html ).addClass( 'whcom_text_center whcom_form_field' );
						$( '.whcom_op_view_invoice_button' ).trigger( 'click' );
					}
				}
				else {
					response_text.html( res.message );
				}
			}
		} );
	} );
	// Apply/Remove Promo Code
	$( document ).on( 'submit', '.whcom_op_promo_code_form', function ( e ) {
		e.preventDefault();
		var $form = $( this );
		var response_div = $( '.whcom_op_promo_response' );
		var data = $form.serializeArray();
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				if ( res.status === "OK" ) {
					window.location.reload();
				}
				else {
					alert( res.message );
				}
			}
		} );
	} );
	
	// Estimate taxes
	$( document ).on( 'submit', '.whcom_op_estimate_taxes_form', function ( e ) {
		e.preventDefault();
		var $form = $( this );
		var data = $form.serializeArray();
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				if ( res.status === "OK" ) {
					window.location.reload();
				}
				else {
					alert( res.message );
				}
			}
		} );
	} );

	// Addons related functionality
	$( document ).on( 'submit', '.whcom_op_order_addon', function ( e ) {
		e.preventDefault();
		var $form = $( this );
		var response_field = $form.find( '.whcom_op_response' );


		var data = $( this ).serializeArray();
		response_field.show();
		response_field.html( whcom_spinner_icon );
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				response_field.text( res.message );
				if ( res.status === "OK" ) {
					window.location.href = res.redirect_url;
				}
				response_field.removeClass( 'alert-info' );
			}
		} );
	} );
	// Domain Renewals
	$( document ).on( 'submit', '.whcom_op_domain_renewals', function ( e ) {
		e.preventDefault();
		var $form = $( this );
		var response_field = $form.find( '.whcom_op_response' );


		var data = $( this ).serializeArray();
		response_field.show();
		response_field.html( whcom_spinner_icon );
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				response_field.text( res.message );
				if ( res.status === "OK" ) {
					window.location.href = res.redirect_url;
				}
				response_field.removeClass( 'alert-info' );
			}
		} );
	} );


	// Client related functionality
	$( document ).on( 'click', '.whcom_client_logout', function ( e ) {
		e.preventDefault();
		var $link = $( this );
		var redirect_url = $link.prop( 'href' );
		var data = {
			'action': 'whcom_process_logout',
		};

		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				if ( res.status === "OK" ) {
					if ( redirect_url ) {
						window.location.href = redirect_url;
					}
					else {
						window.location.reload();
					}
				}
				else {
					alert( res.message );
				}
			}
		} );
	} );


	window.whcom_op_update_cart_summaries = function () {
		var side_summaries = [];
		var short_summaries = [];
		var buttons_summaries = [];
		var detailed_summaries = [];
		$( '.whcom_op_universal_cart_summary_side' ).each( function () {
			$( this ).html( whcom_spinner_block );
			side_summaries.push( $( this ) );
		} );
		$( '.whcom_op_universal_cart_summary_short' ).each( function () {
			$( this ).html( whcom_spinner_block );
			short_summaries.push( $( this ) );
		} );
		$( '.whcom_op_universal_cart_summary_button' ).each( function () {
			$( this ).html( whcom_spinner_icon_only );
			buttons_summaries.push( $( this ) );
		} );
		$( '.whcom_op_universal_cart_summary_detailed' ).each( function () {
			$( this ).html( whcom_spinner_block );
			detailed_summaries.push( $( this ) );
		} );
		if ( (buttons_summaries.length + short_summaries.length + detailed_summaries.length) > 0 ) {
			var data = {};
			data.action = "whcom_op";
			data.whcom_op_what = "cart_summaries";
			data.cart_index = $( 'input[name="cart_index"]' ).val();
			data.product_id = $( 'input[name="pid"]' ).val();
			data.billingcycle = $( '[name="billingcycle"]' ).val();
			$( '.whcom_op_promo_response' ).html( '' );
			$.ajax( {
				url: whcom_ajax.ajax_url,
				type: 'post',
				data: data,
				success: function ( response ) {
					var res = JSON.parse( response );
					if ( res.status === "OK" ) {
						if ( side_summaries.length ) {
							$( side_summaries ).each( function () {
								$( this ).html( res.side );
							} );
						}
						if ( short_summaries.length ) {
							$( short_summaries ).each( function () {
								$( this ).html( res.short )
							} );
						}
						if ( buttons_summaries.length ) {
							$( buttons_summaries ).each( function () {
								$( this ).html( res.button )
							} );
						}
						if ( detailed_summaries.length ) {
							$( detailed_summaries ).each( function () {
								$( this ).html( res.detailed )
							} );
						}
						if ( res.total_items > 0 ) {
							$( '.whcom_universal_checkout_button' ).prop( 'disabled', false );
						}
						else {
							$( '.whcom_universal_checkout_button' ).prop( 'disabled', true );
						}
						$( '.whcom_summary_sidebar' ).whcom_sticky( {
							'parent': '.whcom_main',
							'offset_top': 80,
							'recalc_every': 1
						} );
						$( '.whcom_op_promo_response' ).html( res.discount_message );
					}
					else {
					}
				}
			} );
		}
	};

	window.whcom_op_update_product_options = function () {
		var options_container = $( '.whcom_op_product_options_container' );
		if ( options_container[0] ) {
			var data = {};
			data.action = "whcom_op";
			data.whcom_op_what = "change_billingcycle";
			data.cart_index = $( 'input[name="cart_index"]:last' ).val();
			data.pid = $( 'input[name="pid"]' ).val();
			data.billingcycle = $( '[name="billingcycle"]' ).val();
			options_container.html( whcom_spinner_block );
			$.ajax( {
				url: whcom_ajax.ajax_url,
				type: 'post',
				data: data,
				success: function ( response ) {
					var res = JSON.parse( response );
					if ( res.status === "OK" ) {
						options_container.html( res.options_html );
					}
					else {
					}
				}
			} );
		}
	};

	window.whcom_op_update_product_summary = function () {
		var prd_form = $( 'form.whcom_op_add_product' );
		if ( prd_form[0] ) {
			var prd_summary = $( '.whcom_op_summary_sidebar' );
			var prd_summary_spinner = $( '.whcom_op_product_summary .whcom_icon_spinner-1' );
			var prd_submit = $( '.whcom_op_product_submit button' );
			prd_submit.prop( 'disabled', true );
			prd_summary_spinner.show();
			if ( prd_form ) {
				var data = prd_form.serializeArray();
				data.push( {'name': 'action', 'value': 'whcom_op'} );
				data.push( {'name': 'whcom_op_what', 'value': 'product_summary'} );
				$.ajax( {
					url: whcom_ajax.ajax_url,
					type: 'post',
					data: data,
					success: function ( response ) {
						var res = JSON.parse( response );
						if ( res.status === "OK" ) {
							prd_submit.prop( 'disabled', false );
							prd_summary_spinner.fadeOut( 500 );
							prd_summary.html( res.summary_html.side );
						}
						else {
							prd_summary.html( res.message );
						}
					}
				} );
			}
		}
	};

}( jQuery ));
// General AJAX functions
(function ( $ ) {


	// WHCOM AJAX Client Log In Functionality.
	$( document ).on( 'submit', '.whcom_login_form', function ( e ) {
		e.preventDefault();
		var $form = $( this );
		var response_field = $form.find( '.whcom_ajax_response' );
		var submit_field = $form.find( '.button' );

		var data = $( this ).serializeArray();
		response_field.show();
		response_field.html( whcom_spinner_icon );
		jQuery.ajax( {
			url: whcom_ajax.ajax_url,
			type: 'post',
			data: data,
			success: function ( response ) {
				var res = JSON.parse( response );
				console.log(res);
				response_field.text( res.message );
				if ( res.status === "OK" ) {
					submit_field.find( 'button' ).text( whcom_ajax.whcom_redirecting_text );
					if ( res.redirect_url !== undefined ) {
						window.location.href = res.redirect_url;
					}
				}
				response_field.removeClass( 'alert-info' );
			}
		} );
	} );
}( jQuery ));


// State change function
window.whcomChangeState = function () {
	var whcom_states = {
		AU: [
			"Australian Capital Territory",
			"New South Wales",
			"Northern Territory",
			"Queensland",
			"South Australia",
			"Tasmania",
			"Victoria",
			"Western Australia"
		],
		BR: [
			"AC",
			"AL",
			"AP",
			"AM",
			"BA",
			"CE",
			"DF",
			"ES",
			"GO",
			"MA",
			"MT",
			"MS",
			"MG",
			"PA",
			"PB",
			"PR",
			"PE",
			"PI",
			"RJ",
			"RN",
			"RS",
			"RO",
			"RR",
			"SC",
			"SP",
			"SE",
			"TO"
		],
		CA: [
			"Alberta",
			"British Columbia",
			"Manitoba",
			"New Brunswick",
			"Newfoundland",
			"Northwest Territories",
			"Nova Scotia",
			"Nunavut",
			"Ontario",
			"Prince Edward Island",
			"Quebec",
			"Saskatchewan",
			"Yukon Territory"
		],
		FR: [
			"Ain",
			"Aisne",
			"Allier",
			"Alpes-de-Haute-Provence",
			"Hautes-Alpes",
			"Alpes-Maritimes",
			"ArdÃ¨che",
			"Ardennes",
			"AriÃ¨ge",
			"Aube",
			"Aude",
			"Aveyron",
			"Bouches-du-RhÃ´ne",
			"Calvados",
			"Cantal",
			"Charente",
			"Charente-Maritime",
			"Cher",
			"CorrÃ¨ze",
			"Corse-du-Sud",
			"Haute-Corse",
			"CÃ´te-d'Or",
			"CÃ´tes-d'Armor",
			"Creuse",
			"Dordogne",
			"Doubs",
			"DrÃ´me",
			"Eure",
			"Eure-et-Loir",
			"FinistÃ¨re",
			"Gard",
			"Haute-Garonne",
			"Gers",
			"Gironde",
			"HÃ©rault",
			"Ille-et-Vilaine",
			"Indre",
			"Indre-et-Loire",
			"IsÃ¨re",
			"Jura",
			"Landes",
			"Loir-et-Cher",
			"Loire",
			"Haute-Loire",
			"Loire-Atlantique",
			"Loiret",
			"Lot",
			"Lot-et-Garonne",
			"LozÃ¨re",
			"Maine-et-Loire",
			"Manche",
			"Marne",
			"Haute-Marne",
			"Mayenne",
			"Meurthe-et-Moselle",
			"Meuse",
			"Morbihan",
			"Moselle",
			"NiÃ¨vre",
			"Nord",
			"Oise",
			"Orne",
			"Pas-de-Calais",
			"Puy-de-DÃ´me",
			"PyrÃ©nÃ©es-Atlantiques",
			"Hautes-PyrÃ©nÃ©es",
			"PyrÃ©nÃ©es-Orientales",
			"Bas-Rhin",
			"Haut-Rhin",
			"RhÃ´ne",
			"Haute-SaÃ´ne",
			"SaÃ´ne-et-Loire",
			"Sarthe",
			"Savoie",
			"Haute-Savoie",
			"Paris",
			"Seine-Maritime",
			"Seine-et-Marne",
			"Yvelines",
			"Deux-SÃ¨vres",
			"Somme",
			"Tarn",
			"Tarn-et-Garonne",
			"Var",
			"Vaucluse",
			"VendÃ©e",
			"Vienne",
			"Haute-Vienne",
			"Vosges",
			"Yonne",
			"Territoire de Belfort",
			"Essonne",
			"Hauts-de-Seine",
			"Seine-Saint-Denis",
			"Val-de-Marne",
			"Val-d'Oise",
			"Guadeloupe",
			"Martinique",
			"Guyane",
			"La RÃ©union",
			"Mayotte"
		],
		DE: [
			"Baden-Wuerttemberg",
			"Bayern",
			"Berlin",
			"Brandenburg",
			"Bremen",
			"Hamburg",
			"Hessen",
			"Mecklenburg-Vorpommern",
			"Niedersachsen",
			"Nordrhein-Westfalen",
			"Rheinland-Pfalz",
			"Saarland",
			"Sachsen",
			"Sachsen-Anhalt",
			"Schleswig-Holstein",
			"Thueringen"
		],
		ES: [
			"ARABA",
			"ALBACETE",
			"ALICANTE",
			"ALMERIA",
			"AVILA",
			"BADAJOZ",
			"ILLES BALEARS",
			"BARCELONA",
			"BURGOS",
			"CACERES",
			"CADIZ",
			"CASTELLON",
			"CIUDAD REAL",
			"CORDOBA",
			"CORUÃ‘A, A",
			"CUENCA",
			"GIRONA",
			"GRANADA",
			"GUADALAJARA",
			"GIPUZKOA",
			"HUELVA",
			"HUESCA",
			"JAEN",
			"LEON",
			"LLEIDA",
			"RIOJA, LA",
			"LUGO",
			"MADRID",
			"MALAGA",
			"MURCIA",
			"NAVARRA",
			"OURENSE",
			"ASTURIAS",
			"PALENCIA",
			"PALMAS, LAS",
			"PONTEVEDRA",
			"SALAMANCA",
			"SANTA CRUZ DE TENERIFE",
			"CANTABRIA",
			"SEGOVIA",
			"SEVILLA",
			"SORIA",
			"TARRAGONA",
			"TERUEL",
			"TOLEDO",
			"VALENCIA",
			"VALLADOLID",
			"BIZKAIA",
			"ZAMORA",
			"ZARAGOZA",
			"CEUTA",
			"MELILLA"
		],
		IN: [
			"Andaman and Nicobar Islands",
			"Andhra Pradesh",
			"Arunachal Pradesh",
			"Assam",
			"Bihar",
			"Chandigarh",
			"Chattisgarh",
			"Dadra and Nagar Haveli",
			"Daman and Diu",
			"Delhi",
			"Goa",
			"Gujarat",
			"Haryana",
			"Himachal Pradesh",
			"Jammu and Kashmir",
			"Jharkhand",
			"Karnataka",
			"Kerala",
			"Lakshadweep",
			"Madhya Pradesh",
			"Maharashtra",
			"Manipur",
			"Meghalaya",
			"Mizoram",
			"Nagaland",
			"Orissa",
			"Puducherry",
			"Punjab",
			"Rajasthan",
			"Sikkim",
			"Tamil Nadu",
			"Telangana",
			"Tripura",
			"Uttaranchal",
			"Uttar Pradesh",
			"West Bengal"
		],
		IT: [
			"AG",
			"AL",
			"AN",
			"AO",
			"AR",
			"AP",
			"AQ",
			"AT",
			"AV",
			"BA",
			"BT",
			"BL",
			"BN",
			"BG",
			"BI",
			"BO",
			"BZ",
			"BS",
			"BR",
			"CA",
			"CL",
			"CB",
			"CI",
			"CE",
			"CT",
			"CZ",
			"CH",
			"CO",
			"CS",
			"CR",
			"KR",
			"CN",
			"EN",
			"FM",
			"FE",
			"FI",
			"FG",
			"FC",
			"FR",
			"GE",
			"GO",
			"GR",
			"IM",
			"IS",
			"SP",
			"LT",
			"LE",
			"LC",
			"LI",
			"LO",
			"LU",
			"MB",
			"MC",
			"MN",
			"MS",
			"MT",
			"ME",
			"MI",
			"MO",
			"NA",
			"NO",
			"NU",
			"OT",
			"OR",
			"PD",
			"PA",
			"PR",
			"PV",
			"PG",
			"PU",
			"PE",
			"PC",
			"PI",
			"PT",
			"PN",
			"PZ",
			"PO",
			"RG",
			"RA",
			"RC",
			"RE",
			"RI",
			"RN",
			"RM",
			"RO",
			"SA",
			"VS",
			"SS",
			"SV",
			"SI",
			"SR",
			"SO",
			"TA",
			"TE",
			"TR",
			"TO",
			"OG",
			"TP",
			"TN",
			"TV",
			"TS",
			"UD",
			"VA",
			"VE",
			"VB",
			"VC",
			"VR",
			"VS",
			"VV",
			"VI",
			"VT"
		],
		NL: [
			"Drenthe",
			"Flevoland",
			"Friesland",
			"Gelderland",
			"Groningen",
			"Limburg",
			"Noord-Brabant",
			"Noord-Holland",
			"Overijssel",
			"Utrecht",
			"Zeeland",
			"Zuid-Holland"
		],
		NZ: [
			"Northland",
			"Auckland",
			"Waikato",
			"Bay of Plenty",
			"Gisborne",
			"Hawkes Bay",
			"Taranaki",
			"Manawatu-Wanganui",
			"Wellington",
			"Tasman",
			"Nelson",
			"Marlborough",
			"West Coast",
			"Canterbury",
			"Otago",
			"Southland"
		],
		GB: [
			"Avon",
			"Aberdeenshire",
			"Angus",
			"Argyll and Bute",
			"Barking and Dagenham",
			"Barnet",
			"Barnsley",
			"Bath and North East Somerset",
			"Bedfordshire",
			"Berkshire",
			"Bexley",
			"Birmingham",
			"Blackburn with Darwen",
			"Blackpool",
			"Blaenau Gwent",
			"Bolton",
			"Bournemouth",
			"Bracknell Forest",
			"Bradford",
			"Brent",
			"Bridgend",
			"Brighton and Hove",
			"Bromley",
			"Buckinghamshire",
			"Bury",
			"Caerphilly",
			"Calderdale",
			"Cambridgeshire",
			"Camden",
			"Cardiff",
			"Carmarthenshire",
			"Ceredigion",
			"Cheshire",
			"Cleveland",
			"City of Bristol",
			"City of Edinburgh",
			"City of Kingston upon Hull",
			"City of London",
			"Clackmannanshire",
			"Conwy",
			"Cornwall",
			"Coventry",
			"Croydon",
			"Cumbria",
			"Darlington",
			"Denbighshire",
			"Derby",
			"Derbyshire",
			"Devon",
			"Doncaster",
			"Dorset",
			"Dudley",
			"Dumfries and Galloway",
			"Dundee City",
			"Durham",
			"Ealing",
			"East Ayrshire",
			"East Dunbartonshire",
			"East Lothian",
			"East Renfrewshire",
			"East Riding of Yorkshire",
			"East Sussex",
			"Eilean Siar (Western Isles)",
			"Enfield",
			"Essex",
			"Falkirk",
			"Fife",
			"Flintshire",
			"Gateshead",
			"Glasgow City",
			"Gloucestershire",
			"Greenwich",
			"Gwynedd",
			"Hackney",
			"Halton",
			"Hammersmith and Fulham",
			"Hampshire",
			"Haringey",
			"Harrow",
			"Hartlepool",
			"Havering",
			"Herefordshire",
			"Hertfordshire",
			"Highland",
			"Hillingdon",
			"Hounslow",
			"Inverclyde",
			"Isle of Anglesey",
			"Isle of Wight",
			"Islington",
			"Kensington and Chelsea",
			"Kent",
			"Kingston upon Thames",
			"Kirklees",
			"Knowsley",
			"Lambeth",
			"Lancashire",
			"Leeds",
			"Leicester",
			"Leicestershire",
			"Lewisham",
			"Lincolnshire",
			"Liverpool",
			"London",
			"Luton",
			"Manchester",
			"Medway",
			"Merthyr Tydfil",
			"Merton",
			"Merseyside",
			"Middlesbrough",
			"Middlesex",
			"Midlothian",
			"Milton Keynes",
			"Monmouthshire",
			"Moray",
			"Neath Port Talbot",
			"Newcastle upon Tyne",
			"Newham",
			"Newport",
			"Norfolk",
			"North Ayrshire",
			"North East Lincolnshire",
			"North Lanarkshire",
			"North Lincolnshire",
			"North Somerset",
			"North Tyneside",
			"North Yorkshire",
			"Northamptonshire",
			"Northumberland",
			"North Humberside",
			"Nottingham",
			"Nottinghamshire",
			"Oldham",
			"Orkney Islands",
			"Oxfordshire",
			"Pembrokeshire",
			"Perth and Kinross",
			"Peterborough",
			"Plymouth",
			"Poole",
			"Portsmouth",
			"Powys",
			"Reading",
			"Redbridge",
			"Renfrewshire",
			"Rhondda Cynon Taff",
			"Richmond upon Thames",
			"Rochdale",
			"Rotherham",
			"Rutland",
			"Salford",
			"Sandwell",
			"Sefton",
			"Sheffield",
			"Shetland Islands",
			"Shropshire",
			"Slough",
			"Solihull",
			"Somerset",
			"South Ayrshire",
			"South Humberside",
			"South Gloucestershire",
			"South Lanarkshire",
			"South Tyneside",
			"Southampton",
			"Southend-on-Sea",
			"Southwark",
			"South Yorkshire",
			"St. Helens",
			"Staffordshire",
			"Stirling",
			"Stockport",
			"Stockton-on-Tees",
			"Stoke-on-Trent",
			"Suffolk",
			"Sunderland",
			"Surrey",
			"Sutton",
			"Swansea",
			"Swindon",
			"Tameside",
			"Telford and Wrekin",
			"The Scottish Borders",
			"The Vale of Glamorgan",
			"Thurrock",
			"Torbay",
			"Torfaen",
			"Tower Hamlets",
			"Trafford",
			"Tyne and Wear",
			"Wakefield",
			"Walsall",
			"Waltham Forest",
			"Wandsworth",
			"Warrington",
			"Warwickshire",
			"West Midlands",
			"West Dunbartonshire",
			"West Lothian",
			"West Sussex",
			"West Yorkshire",
			"Westminster",
			"Wigan",
			"Wiltshire",
			"Windsor and Maidenhead",
			"Wirral",
			"Wokingham",
			"Wolverhampton",
			"Worcestershire",
			"Wrexham",
			"York",
			"Co. Antrim",
			"Co. Armagh",
			"Co. Down",
			"Co. Fermanagh",
			"Co. Londonderry",
			"Co. Tyrone"
		],
		US: [
			"Alabama",
			"Alaska",
			"Arizona",
			"Arkansas",
			"California",
			"Colorado",
			"Connecticut",
			"Delaware",
			"District of Columbia",
			"Florida",
			"Georgia",
			"Hawaii",
			"Idaho",
			"Illinois",
			"Indiana",
			"Iowa",
			"Kansas",
			"Kentucky",
			"Louisiana",
			"Maine",
			"Maryland",
			"Massachusetts",
			"Michigan",
			"Minnesota",
			"Mississippi",
			"Missouri",
			"Montana",
			"Nebraska",
			"Nevada",
			"New Hampshire",
			"New Jersey",
			"New Mexico",
			"New York",
			"North Carolina",
			"North Dakota",
			"Ohio",
			"Oklahoma",
			"Oregon",
			"Pennsylvania",
			"Rhode Island",
			"South Carolina",
			"South Dakota",
			"Tennessee",
			"Texas",
			"Utah",
			"Vermont",
			"Virginia",
			"Washington",
			"West Virginia",
			"Wisconsin",
			"Wyoming"
		]
	};
	jQuery(document).find('.whcom_country_state_container').each(function () {
		var mainContainer = jQuery(this);
		var countrySelect = mainContainer.find('.whcom_country_select');
		var stateSelect = mainContainer.find('.whcom_state_select');
		var stateInput = mainContainer.find('.whcom_state_input');
		var selectedCountry = countrySelect.val();
		var required = stateInput.prop('required') || stateSelect.prop('required');
		var state_name = mainContainer.data('state_name') || 'state';
		var state_name_dummy = mainContainer.data('state_name_dummy') || 'state_dummy';
		if (selectedCountry in whcom_states) {
			var statesHtml = '<option value="">—</option>';
			console.log(whcom_states[selectedCountry]);
			jQuery(whcom_states[selectedCountry]).each(function (i, v) {
				statesHtml += '<option value="'+v+'">'+v+'</option>';
			});
			stateSelect.show().prop('name', state_name).prop('required', required).html(statesHtml);
			stateInput.hide().prop('name', state_name_dummy).prop('required', false);
		}
		else {
			stateSelect.hide().prop('name', state_name_dummy).prop('required', false);
			stateInput.show().prop('name', state_name).prop('required', required);
		}
	});
};
