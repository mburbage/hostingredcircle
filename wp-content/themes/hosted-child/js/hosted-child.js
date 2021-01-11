jQuery(function ($) {
	document.querySelectorAll('.vc_tta-tab a').forEach(function (el) {
		el.addEventListener('click', function () {
			if (document.querySelector(el.getAttribute('href') + ' .vc_tta-panel-body').innerHTML == '') {
				
				let groupid = el.getAttribute('href').split('-');

				document.querySelector(el.getAttribute('href') + ' .vc_tta-panel-body').insertAdjacentHTML('beforeend', '<div class="loader">Loading...</div><div id="whmpress-tld-wrapper"><div id="loading-domain">Retrieving Plans</div></div>');

				$.ajax({
					url: params.ajaxurl,
					type: 'POST',
					data: {
						'action': 'load_group_table',
						'nonce': params.nonce,
						'groupid': groupid[1]
					},
					success: function (response) {
						document.querySelector(el.getAttribute('href') + ' .vc_tta-panel-body').innerHTML = "";
						document.querySelector(el.getAttribute('href') + ' .vc_tta-panel-body').insertAdjacentHTML('beforeend', response);

					},
					error: function (response) {
						console.log('error');
					}
				});
			}
		});
	});
	document.querySelectorAll('.vc_tta-panel-title a').forEach(function (el) {
		el.addEventListener('click', function () {
			if (document.querySelector(el.getAttribute('href') + ' .vc_tta-panel-body').innerHTML == '') {
				console.log("Tab");
				
				let groupid = el.getAttribute('href').split('-');

				document.querySelector(el.getAttribute('href') + ' .vc_tta-panel-body').insertAdjacentHTML('afterbegin', '<div class="loader">Loading...</div><div id="whmpress-tld-wrapper"><div id="loading-domain">Loading Datacenter Plans</div></div>');

				$.ajax({
					url: params.ajaxurl,
					type: 'POST',
					data: {
						'action': 'load_group_table',
						'nonce': params.nonce,
						'groupid': groupid[1]
					},
					success: function (response) {
						document.querySelector(el.getAttribute('href') + ' .vc_tta-panel-body').innerHTML = "";
						document.querySelector(el.getAttribute('href') + ' .vc_tta-panel-body').insertAdjacentHTML('afterbegin', response);

					},
					error: function (response) {
						console.log('error');
					}
				});
			}
		});
	});
});
