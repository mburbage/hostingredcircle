<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

?>

<div class="wcop_sp_section_heading whcom_bg_primary whcom_text_white">
    <i class="whcom_icon_cog"></i>
    <?php if ( !empty( $atts['addon_section_title'] ) ) { ?>
        <span><?php echo $atts['addon_section_title'] ?></span>
    <?php } else { ?>
        <span class="whcom_serives_heading_first"><?php esc_html_e( "Additional Services / ", "whcom" ) ?> </span>
        <span><?php esc_html_e( "Order Configuration", "whcom" ) ?> </span>
    <?php } ?>
    <span class="whcom_icon_spinner-1 whcom_animate_spin wcop_sp_product_options_spinner" style="display: none"></span>
</div>
<div class="wcop_collapse_content_parent">
<div class="wcop_sp_section_content">
    <div class="whcom_text_center">
	    <?php esc_html_e('This section will lists configuration options for the selected product.', 'whcom')?>
    </div>
</div>
    <div class="whcom_collapse_button_3">
        <button type="button" class="next whom_button_one" onclick="GotonextTab('3',this)">Next</button>
    </div>
</div>