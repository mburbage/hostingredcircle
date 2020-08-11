<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$page        = ( isset( $_GET['whcom-page'] ) ) ? $_GET['whcom-page'] : 'miscellaneous';
$miscellaneous = $domains_active = '';

switch ( $page ) {
	case 'miscellaneous' :
		{
			$miscellaneous = ' nav-tab-active';
			break;
		}
	case 'domain-fields' :
		{
			$domains_active = ' nav-tab-active';
			break;
		}
	default :
		{

		}
}


?>

<div class="wrap whcom_main">
    <h2></h2>
    <h1><?php echo esc_html_x( "Advanced Settings", "admin", "whcom" ) ?></h1>
    <h2 class="nav-tab-wrapper whcom_margin_bottom_15">
        <a class="nav-tab <?php echo $miscellaneous ?>"
           href="?page=whcom-advanced-settings"><?php echo esc_html_x( 'Miscellaneous', 'admin', "whcom" ) ?></a>
        <a class="nav-tab <?php echo $domains_active ?>"
           href="?page=whcom-advanced-settings&whcom-page=domain-fields"><?php echo esc_html_x( 'Domains Config', 'admin', "whcom" ) ?></a>
    </h2>

	<?php if ( $page == 'domain-fields' ) {
		require_once(WHCOM_PATH . "/admin/pages/domain-fields.php");
	}
	else {
		require_once(WHCOM_PATH . "/admin/pages/miscellaneous.php");
	} ?>

</div>

