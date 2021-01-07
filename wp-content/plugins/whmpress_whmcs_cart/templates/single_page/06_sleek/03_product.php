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
<div class="wcop_sp_section_navi">
    <div class="my-button-item">
        <div class="wcop_sp_button">
            <button type="button" name="prev" class="prev whcom_button_secondary" onclick="Gotoprevious('.sleek_product_section')" style="float: left;"><i class="whcom_icon_angle-circled-left"></i> Previous</button>

            <button type="button" name="next" class="next"  value="continue" onclick="Gotonext('.sleek_product_section')" style="float:right;">Next <i class="whcom_icon_angle-circled-right"></i></button>
        </div>
    </div>
</div>