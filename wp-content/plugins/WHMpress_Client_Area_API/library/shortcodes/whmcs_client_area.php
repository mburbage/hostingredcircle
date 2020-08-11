<?php
$_SESSION['atts'] = $atts;
add_thickbox();
if (! whcom_helper_test()) {
	echo '<div class="wcap_page_container whcom_main">';
	echo 'WHMPress Helper is not active, kindly install and activate WHMPress helper in WHCMS addon modules.<br>';
	echo '<a href="http://docs.whmpress.com/wcap/getting-started-whmcs-client-area/" class="button">' . esc_html__('Guidelines', "whcom" ) . '</a>';
	echo '</div>';
}elseif (! whcom_is_client_logged_in()) {
	echo '<div class="wcap_page_container whcom_main">';
	echo '<div id="wcap_main_div">';
	echo '<div class="wcap">';
	echo '</div>';
	echo '</div>';
	echo '</div>';
} else {
	echo '<div class="wcap_page_container whcom_main">';

	if (get_option( "wcapfield_hide_whmcs_menu" ) != '1') {
		echo '<div id="wcap_menu_div">';
		include_once $this->Path . "/views/top_links.php";
		echo '</div>';
	}
	echo '<div id="wcap_main_div">';
	echo '<div class="wcap">';
	echo '</div>';

	echo '</div>';
	echo '</div>';
}