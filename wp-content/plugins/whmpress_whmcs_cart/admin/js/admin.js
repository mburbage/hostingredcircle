/**
 * Main Script files for wcop plugin
 */
(function ( $ ) {
	$(document).on("change", "#wcop_show_invoice_as", function(  ) {
		if ( $(this).val() === 'minimal') {
			$("#minimal_interface_help").slideDown();
		} else {
			$("#minimal_interface_help").slideUp();
		}
	});

	$( document ).on( 'submit', '.wcop_verify_purchase_form', function ( e ) {
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


}( jQuery ));