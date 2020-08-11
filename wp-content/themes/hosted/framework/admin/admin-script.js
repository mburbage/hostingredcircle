jQuery( document ).ready( function($) {
	// Show/hide settings for post format when choose post format
	var $format = $( '#post-formats-select' ).find( 'input.post-format' ),
		$formatBox = $( '#format_detail' );

	$format.on( 'change', function() {
		var	type = $format.filter( ':checked' ).val();

		$formatBox.hide();
		if( $formatBox.find( '.rwmb-field' ).hasClass( type ) ) {
			$formatBox.show();
		}

		$formatBox.find( '.rwmb-field' ).slideUp();
		$formatBox.find( '.' + type ).slideDown();
	} );
	$format.filter( ':checked' ).trigger( 'change' );

	// Show/hide settings for custom layout settings
	$( '#custom_layout' ).on( 'change', function() {
		if( $( this ).is( ':checked' ) ) {
			$( '.custom-layout' ).slideDown();
		}
		else {
			$( '.custom-layout' ).slideUp();
		}
	} ).trigger( 'change' );

	// Hide team info
	$( '#team-member-info' ).find( '.team-member-address' ).hide();
	$( '#team-member-info' ).find( '.team-member-phone' ).hide();
	$( '#team-member-info' ).find( '.team-member-email' ).hide();
	$( '#team-member-info' ).find( '.team-member-url' ).hide();
} );
