<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

?>

<div class="wcop_sp_section_heading">
    <i class="whcom_icon_cog"></i>
    <?php if ( !empty( $atts['addon_section_title'] ) ) { ?>
        <span><?php echo $atts['addon_section_title'] ?></span>
    <?php } else { ?>
    <span class="whcom_serives_heading_first"><?php esc_html_e( "ADDITIONAL SERVICES / ", "whcom" ) ?> </span>
        <span><?php esc_html_e( "ORDER CONFIGURATION", "whcom" ) ?> </span>
    <?php } ?>
    <span class="whcom_icon_spinner-1 whcom_animate_spin wcop_sp_product_options_spinner" style="display: none"></span>
</div>
<div class="wcop_sp_section_content">

</div>