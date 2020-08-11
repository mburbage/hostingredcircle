<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$product_id    = $atts['pid'];
$billing_cycle = ( isset( $_REQUEST['billingcycle'] ) && is_string( $_REQUEST['billingcycle'] ) ) ? $_REQUEST['billingcycle'] : '';


?>


<div class="wcop_sp_section_heading whcom_bg_primary whcom_text_white">
    <i class="whcom_icon_ok-circled"></i>
    <?php if (!empty($atts['hosting_section_title'])){?>
        <span><?php echo $atts['hosting_section_title'] ?></span>
    <?php }else { ?>
    <span><?php esc_html_e( "Choose a Hosting Plan", "whcom" ) ?></span>
    <?php } ?>
</div>
<div class="wcop_sp_section_content">
    <div class="whcom_form_field">
        <label for="wcop_sp_product_select"><?php esc_html_e( "Select Product /Service", "whcom" ) ?></label>
		<?php echo wcop_sp_render_products_dropdown( $product_id, $pids, $gids, $domain_products ); ?>
    </div>
    <div class="wcop_sp_prod_billingcycle">

    </div>
</div>