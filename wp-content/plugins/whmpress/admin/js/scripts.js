/**
 * Created by Abdul Waheed on 3/8/2017.
 */
(function ($)
{
	$(document).on('ready', function ()
	{
		$('.whmp_dropdown_toggle').on('click', function (e) {
			e.preventDefault()
			$(this).parent('.whmp_dropdown_outer').toggleClass('active');
		});
	});
}(jQuery));
