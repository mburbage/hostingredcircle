<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$page        = ( isset( $_GET['wcop-page'] ) ) ? $_GET['wcop-page'] : 'template-settings';
$templates_active = $urls_active = '';

switch ( $page ) {
	case 'template-settings' :
		{
			$templates_active = ' nav-tab-active';
			break;
		}
	case 'order-urls' :
		{
			$urls_active = ' nav-tab-active';
			break;
		}
    case 'miscellaneous' :
        {
            $miscellaneous_active = ' nav-tab-active';
            break;
        }
	default :
		{

		}
}


?>

<div class="wrap whcom_admin_page">

    <h2></h2>
    <h1><?php echo esc_html_x( "Advanced Settings", "admin", "whcom" ) ?></h1>
    <h2 class="nav-tab-wrapper whcom_margin_bottom_15">
        <a class="nav-tab <?php echo $templates_active ?>"
           href="?page=wcop-advanced-settings"><?php echo esc_html_x( 'Templates Settings', 'admin', "whcom" ) ?></a>
        <a class="nav-tab <?php echo $urls_active ?>"
           href="?page=wcop-advanced-settings&wcop-page=order-urls"><?php echo esc_html_x( 'Order URLs', 'admin', "whcom" ) ?></a>
        <a class="nav-tab <?php echo $miscellaneous_active ?>"
           href="?page=wcop-advanced-settings&wcop-page=miscellaneous"><?php echo esc_html_x( 'Misc', 'admin', "whcom" ) ?></a>
        <a class="nav-tab"
           href="?page=whcom-advanced-settings&whcom-page=domain-fields"><?php echo esc_html_x( 'Domains Config', 'admin', "whcom" ) ?></a>
    </h2>

	<?php if ( $page == 'order-urls' ) {
		require_once(WCOP_PATH . "/admin/admin-pages/products.php");
	}
	elseif ($page == 'miscellaneous'){
        require_once(WCOP_PATH . "/admin/admin-pages/wcop_miscellaneous.php");
    }
	else {
		require_once(WCOP_PATH . "/admin/admin-pages/templates.php");
	} ?>
</div>






