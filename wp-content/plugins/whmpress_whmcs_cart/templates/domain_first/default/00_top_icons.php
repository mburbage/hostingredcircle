<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

$page = (isset($page)) ? $page : 'domain';
$domain_active = $product_active = $config_active = $checkout_active = '';
switch ($page) {
	case 'domain' : {
		$domain_active = ' whcom_pill_success';
		break;
	}
	case 'product' : {
		$product_active = ' whcom_pill_success';
		break;
	}
	case 'config' : {
		$config_active = ' whcom_pill_success';
		break;
	}
	case 'checkout' : {
		$checkout_active = ' whcom_pill_success';
		break;
	}
	default : {

	}
}
?>


<ul class="wcop_df_steps">
	<li class="whcom_pill whcom_border_success <?php echo $domain_active?>">
		<div class="wcop_df_step_inner">
			<i class="whcom_icon_www"></i>
			<span><?php esc_html_e('Domain', 'whcom')?></span>
		</div>
	</li>
	<li class="whcom_pill whcom_border_success <?php echo $product_active?>">
		<div class="wcop_df_step_inner">
			<i class="whcom_icon_mail"></i>
			<span><?php esc_html_e('Product', 'whcom')?></span>
		</div>
	</li>
	<li class="whcom_pill whcom_border_success <?php echo $config_active?>">
		<div class="wcop_df_step_inner">
			<i class="whcom_icon_wrench"></i>
			<span><?php esc_html_e('Configure', 'whcom')?></span>
		</div>
	</li>
	<li class="whcom_pill whcom_border_success <?php echo $checkout_active?>">
		<div class="wcop_df_step_inner">
			<i class="whcom_icon_card"></i>
			<span><?php esc_html_e('Checkout', 'whcom')?></span>
		</div>
	</li>
</ul>
