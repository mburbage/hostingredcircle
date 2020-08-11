<?php


$WCAP_Menu = $this->get_menu_array();

if ( ! isset( $_GET['wcap'] ) ) {
	$_GET['wcap'] = "dashboard";
}

$menu_settings = (get_option("wcapfield_hide_whmcs_menu_sections") == '') ? [] :
get_option("wcapfield_hide_whmcs_menu_sections");
?>

<?php // $hide_sub_menues = get_option( 'hide_sub_menu', [] ) ?>
<!--<script>
	//var WCAP_SESSION = <?php /*//echo json_encode( $_SESSION ) */ ?>;
</script>-->

<div id="wcap_loading"><?php esc_html_e( "Loading...", "whcom" ) ?></div>


<nav id="primary_nav_wrap">
    <ul class="wcap_navbar_left">
        <?php
        wcap_print_menu($menu_settings, $WCAP_Menu, "left");
        ?>
    </ul>


    <ul class="wcap_navbar_right">
        <?php
        wcap_print_menu($menu_settings, $WCAP_Menu, "right");
        ?>
    </ul>

</nav>
<div style="clear:both"></div>


