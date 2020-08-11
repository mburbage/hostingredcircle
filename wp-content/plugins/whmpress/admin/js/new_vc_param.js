!function ($)
{
	$('.whmpress_select_window i').on('click', function (e)
	{
		$('.whmp_icon_preview').html("<i class='" + $(this).attr("class") + "'></i>");
		$("#" + $(this).attr("data-id")).val($(this).attr("class"));
	});
}(window.jQuery);