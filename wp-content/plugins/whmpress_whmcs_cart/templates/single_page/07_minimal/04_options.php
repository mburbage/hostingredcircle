<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

?>

<div class="wcop_sp_section_heading">
    <i class="whcom_icon_cog"></i>
    <?php if ( !empty( $atts['addon_section_title'] ) ) { ?>
        <span><?php echo $atts['addon_section_title'] ?></span>
    <?php } else { ?>
    <span><?php esc_html_e( "Add Additional Services and Order Configuration", "whcom" ) ?></span>
    <?php } ?>
    <span class="whcom_icon_spinner-1 whcom_animate_spin wcop_sp_product_options_spinner" style="display: none"></span>
</div>
<div class="wcop_sp_section_content">

</div>