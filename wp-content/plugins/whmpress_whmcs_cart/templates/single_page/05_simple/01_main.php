<style>
    .whcom_form_field > input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]), .whcom_form_field select, .whcom_form_field textarea{
        border-radius: 3px;
    }
    .wcop_billing_info_predecessor_text {
        height: 5em;
        padding-top: 0.3125em;
        font-size: 17px;
        font-weight: 400;
    }

    .wcop_billing_info_content.wcop_sp_section_content.whcom_row {
        border: 1px solid #cccccc;
        padding: 10px 10px 0 10px !important;
        max-width: 940px !important;
    }
</style>
<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
?>
<?php
$show_prod_desc              = $atts['show_summary_product_description'];
$promocode                   = $atts['promocode'];
$hide_group_name             = $atts['hide_group_name_summary'];
$hide_domain_transfer        = $atts['hide_domain_transfer'];
$_SESSION['hide_domain_transfer_section'] = $hide_domain_transfer;
$_SESSION['hide_group_name'] = $hide_group_name;
$_SESSION['prod_desc']       = $show_prod_desc;
?>



<div class="whcom_main wcop_main wcop_sp_main wcop_sp_simple_1 whcom_bordered_sides" id="wcop_sp_main">
	<?php include wcop_get_template_directory() . '/templates/single_page/01_default/01_top_nav.php'?>
	<?php include wcop_get_template_directory() . '/templates/single_page/01_default/02_product_dropdowns.php'?>
	<?php if ( strtolower( $atts['hide_domain'] ) != 'yes' ) { ?>
        <div id="wcop_sp_choose_a_domain" class="wcop_sp_section wcop_sp_section_domain whcom_margin_bottom_0 whcom_bg_white whcom_padding_bottom_30">
			<?php include_once( wcop_get_template_directory() . '/templates/single_page/05_simple/02_domain.php' ); ?>
        </div>
	<?php } ?>
    <div class="wcop_sp_add_product_form">
        <form class="wcop_sp_add_product" method="post">
            <input type="hidden" name="action" value="wcop_sp_process">
            <input type="hidden" name="wcop_sp_what" value="add_order">
            <input type="hidden" name="wcop_sp_template" value="05_simple">
            <input type="hidden" name="cart_index" value="-1">
	        <input type="hidden" name="default_billingcycle" value="<?php echo $atts['billingcycle'];?>">
			<?php if ( strtolower( $atts['hide_domain'] ) != 'yes' ) { ?>
                <div id="wcop_sp_domain_config" class="wcop_sp_section wcop_sp_section_domain" style="display: none">
                    <div class="wcop_sp_section_heading whcom_bg_primary whcom_text_white">
                        <i class="whcom_icon_www"></i>
                        <span><?php esc_html_e( "Domain Configuration", "whcom" ) ?></span>
                        <span id="edit_domain" style="float: right; cursor: pointer"><?php esc_html_e( "Edit Domain", "whcom" ) ?></span>
                    </div>
                    <div class="wcop_sp_section_content">
                    </div>
                </div>
			<?php } ?>
			<?php if ( strtolower( $atts['hide_product'] ) != 'yes' ) { ?>
                <div id="wcop_choose_a_hosting"
                     class="wcop_sp_section <?php echo (!empty($atts['hide_selected_product']) && strtolower($atts['hide_selected_product']) == 'yes' && !empty($atts['pid'])) ? 'hidden' : '' ?>">
					<?php include_once( wcop_get_template_directory() . '/templates/single_page/05_simple/03_product.php' ); ?>
                </div>
			<?php } ?>
			<?php if ( strtolower( $atts['hide_additional_services'] ) != 'yes' ) { ?>
                <div id="wcop_additional_services" class="wcop_sp_section">
					<?php include_once( wcop_get_template_directory() . '/templates/single_page/05_simple/04_options.php' ); ?>
                </div>
			<?php } ?>

            <?php if ($atts['post_load_login_form'] == 'yes') { ?>
                <!-- Billing info Predecessor -->
                <?php wcop_sp_billing_info_predecessor() ?>

            <?php } ?>

            <div id="wcop_billing_info" class="wcop_sp_section" style="<?php echo  $atts['post_load_login_form'] == 'yes' ? 'display:none' : 'display:block' ?>">
				<?php include_once( wcop_get_template_directory() . '/templates/single_page/05_simple/05_client.php' ); ?>
            </div>
            <div id="wcop_review_checkout" class="wcop_sp_section">
				<?php include_once( wcop_get_template_directory() . '/templates/single_page/05_simple/07_checkout.php' ); ?>
            </div>
        </form>
    </div>
</div>















