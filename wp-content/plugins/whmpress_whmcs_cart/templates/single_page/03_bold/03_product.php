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
        <label for="wcop_sp_product_select"><?php esc_html_e( "Select Product /Service", "whcom" ) ?></label>
		<?php echo wcop_sp_render_products_dropdown( $product_id, $pids, $gids, $domain_products ); ?>
    </div>
    <div class="wcop_sp_prod_billingcycle">

    </div>
</div>
<div class="wcop_sp_button">
    <button type="button" name="gotoprev" id="gotoprev" class="prev whcom_button_secondary" value="Previous"
            onclick="Gotoprev('.bold_product_section')">
        ❮ Previous
    </button>
    <button type="button" name="next" class="next" value="continue"
            onclick="Gotonext1('.bold_product_section')">NEXT
        ❯
    </button>
</div>