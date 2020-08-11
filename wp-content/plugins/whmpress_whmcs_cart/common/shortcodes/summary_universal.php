<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$atts = isset($atts) && is_array($atts) ? $atts : [];
$atts = shortcode_atts( [
	'type'     => 'button',
], $atts );

switch ($atts['type']) {
	case 'button' : {
		?>
        <div class="whcom_main whcom_op_summary_container">
            <a class="whcom_button" href="<?php echo whcom_get_cart_url(); ?>">
                <i class="whcom_icon_basket"></i>
                <span class="whcom_op_universal_cart_summary_button">

                </span>
            </a>
        </div>
		<?php
	}
	case 'dropdown' : {
		?>
        <div class="whcom_main whcom_op_summary_container">
            <div class="whcom_dropdown whcom_dropdown_full">
                <span class="whcom_dropdown_toggle">
                    <i class="whcom_icon_basket"></i>
                    <span class="whcom_op_universal_cart_summary_button"></span>
                </span>
                <div class="whcom_dropdown_content whcom_has_list">
                    <ul class="whcom_op_universal_cart_summary_short whcom_list_padded whcom_list_bordered">
                        
                    </ul>
                    <div class="whcom_row">
                        <div class="whcom_col_6">
                            <a class="whcom_button whcom_button_block" href="<?php echo whcom_get_cart_url(); ?>">
						        <?php esc_html_e('View Cart', 'whcom')?>
                            </a>
                        </div>
                        <div class="whcom_col_6">
                            <a class="whcom_button whcom_button_block" href="<?php echo whcom_get_checkout_url(); ?>">
						        <?php esc_html_e('Checkout', 'whcom')?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}
	default : {
		
	}
}
