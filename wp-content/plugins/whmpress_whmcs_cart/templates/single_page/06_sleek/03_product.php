<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$product_id    = $atts['pid'];
$billing_cycle = ( isset( $_REQUEST['billingcycle'] ) && is_string( $_REQUEST['billingcycle'] ) ) ? $_REQUEST['billingcycle'] : '';


?>


<div class="wcop_sp_section_heading">
    <i class="whcom_icon_ok-circled"></i>
    <?php if (!empty($atts['hosting_section_title'])){?>
        <span><?php echo $atts['hosting_section_title'] ?></span>
    <?php }else { ?>
    <span><?php echo esc_html_x( "Choose a Hosting Plan (Optional)", "whcom" ) ?></span>
    <?php } ?>
</div>
<div class="wcop_sp_section_content">
    <div class="whcom_form_field">
<!--        --><?php //esc_html_e( "Select Product /Service", "whcom" ) ?>
        <div class="open" style="float:right;">
            Expand <i class="whcom_icon_plus"></i>
        </div>
        <div class="whcom_prod_collapse" style="float:right; display: none">
            Collapse <i class="whcom_icon_minus"></i>
        </div>
		<?php echo wcop_sp_render_products_radio( $product_id, $pids, $gids, $domain_products ); ?>
    </div>
    <div class="wcop_sp_prod_billingcycle">

    </div>
</div>