<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$wcop_df_current_page = ( ! empty( $_REQUEST['a'] ) ) ? $_REQUEST['a'] : 'domain';
$gids    = ( ! empty( $gids ) ) ? $gids : '';
$pids    = ( ! empty( $pids ) ) ? $pids : '';
?>


<div id="wcop_df_container" class="wcop_df_container wcop_df_default wcop_main whcom_main">
	<?php ob_start() ?>
	<?php switch ( $wcop_df_current_page ) {
		case 'domain' :
			{
				include wcop_get_template_directory('domain_first') . '/templates/domain_first/default/01_domain.php';
				break;
			}
		case 'product' :
			{
				include wcop_get_template_directory('domain_first') . '/templates/domain_first/default/02_product.php';
				break;
			}
		case 'config' :
			{
				include wcop_get_template_directory('domain_first') . '/templates/domain_first/default/04_domains_config.php';
				break;
			}
		case 'view' :
			{
				include wcop_get_template_directory('domain_first') . '/templates/domain_first/default/06_summary_main.php';
				break;
			}
		case 'checkout' :
			{
				include wcop_get_template_directory('domain_first') . '/templates/domain_first/default/06_checkout.php';
				break;
			}
		default :
			{
				include wcop_get_template_directory('domain_first') . '/templates/domain_first/default/01_domain.php';
			}
	} ?>
	<?php echo ob_get_clean(); ?>
</div>
