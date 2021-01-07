jQuery(function ($) {
	// Handler for .ready() called.
	jQuery.ajax({
		url: plugin_data.ajaxurl,
		type: 'POST',
		data: {
			'action': 'whmpress_price_table_domain_preloader_function',
			'episodenonce': plugin_data.preloadernonce
		},
		success: function (response) {

			document.querySelector('.loader').style.display = 'none';
			document.querySelector('#loading-domain').style.display = 'none';
			document.querySelector('#whmpress-tld-wrapper').insertAdjacentHTML('afterbegin', response);

			jQuery('#tld_domains table').DataTable({
                "iDisplayLength": 10
            });


		},
		error: function (response) {
			console.log(response);
		}
	});

	
});
