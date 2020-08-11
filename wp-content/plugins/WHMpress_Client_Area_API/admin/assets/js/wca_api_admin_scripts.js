(function ($)
{
	"use strict";

	$(document).on("change", "#wcapfield_enable_sync", function(  ) {
		if ( $(this).is(":checked") ) {
			$("label[for=wcapfield_enable_sso]").removeClass("disable");
			$("#wcapfield_enable_sso").prop("disabled", false);
		} else {
			$("label[for=wcapfield_enable_sso]").addClass("disable");
			$("#wcapfield_enable_sso").prop("disabled", true);
		}
	});

	$(document).on("click", "#wcap_one_time_sync_button", function( e ) {
		e.preventDefault();
		var form = $(this).parents('form');
		$('input[name="wcapfield_perform_one_time_sync"]').val('Yes');
		form.submit();
	});


	$(document).on("change", "#wcapfield_show_invoice_as", function(  ) {
		if ( $(this).val() === 'minimal') {
			$("#minimal_interface_help").slideDown();
		} else {
			$("#minimal_interface_help").slideUp();
		}
	});




	$( document ).on( 'submit', '.wcap_verify_purchase_form', function ( e ) {
		e.preventDefault();
		var $form = $( this );
		var submit = $form.find('button');
		var submit_val = submit.html();
		var verify_action = $form.find('input[name=verify_action]').val();
		var confirm_string = $form.find( 'input[name="confirm_string"]' ).val();
		var confirm = false;
		if (verify_action === 'verify') {
			confirm = true
		}
		else {
			confirm = window.confirm( confirm_string )
		}
		if ( confirm === true ) {
			var data = $form.serializeArray();
			submit.html( whcom_spinner_icon );
			jQuery.ajax( {
				url: ajaxurl,
				type: 'post',
				data: data,
				success: function ( response ) {
					submit.text( submit_val );
					if ( response === "OK" ) {
						window.location.reload();
					}
					else {
						alert(response);
					}
				}
			} );
		}
	} );


}(jQuery));