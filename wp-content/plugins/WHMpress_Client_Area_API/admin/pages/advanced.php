<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$page        = ( isset( $_GET['wcap-page'] ) ) ? $_GET['wcap-page'] : 'sync';
$sync_active = $urls_active = '';

switch ( $page ) {
	case 'sync' :
		{
			$sync_active = ' nav-tab-active';
			break;
		}
	case 'order-urls' :
		{
			$urls_active = ' nav-tab-active';
			break;
		}
	default :
		{

		}
}


?>

<div class="wrap wrap-about wcap_admin_wrapper">
    <h2></h2>
    <h1><?php echo esc_html_x( "Advanced Settings", "admin", "whcom" ) ?> - Client Area - WCAP</h1>
    <h2 class="nav-tab-wrapper">
        <a class="nav-tab <?php echo $sync_active ?>"
           href="?page=wcap-advanced-settings"><?php echo esc_html_x( 'SSO Settings', 'admin', "whcom" ) ?></a>
        <a class="nav-tab <?php echo $urls_active ?>"
           href="?page=wcap-advanced-settings&wcap-page=order-urls"><?php echo esc_html_x( 'Order URLs', 'admin', "whcom" ) ?></a>
        <a class="nav-tab"
           href="?page=whcom-advanced-settings&whcom-page=domain-fields"><?php echo esc_html_x( 'Domains Config', 'admin', "whcom" ) ?></a>
    </h2>

	<?php if ( $page == 'order-urls' ) {
		require_once($this->Path . "/admin/pages/products.php");
    }
	else {
		require_once($this->Path . "/admin/pages/sync.php");
    } ?>
</div>