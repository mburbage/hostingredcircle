<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$whcom_groups = whcom_get_all_products();
$whcom_groups = ( empty( $whcom_groups['groups'] ) ) ? [] : $whcom_groups['groups'];

?>

    <div class="whcom_collapse whcom_margin_bottom_30" data-tld-name="<?php echo $tld; ?>">
        <div class="whcom_collapse_toggle">
            <i class="whcom_icon_down-open"></i>
            <strong><?php esc_html_e('Domains', 'whcom')?></strong>
        </div>
        <div class="whcom_collapse_content">
            <?php
            $order_url   = get_option( 'configure_product' . whcom_get_current_language(), '' );
            $order_url   = ( empty( $order_url ) ) ? home_url( '/' ) . 'client-area' : $order_url;
            $product_url = $order_url . '?a=add&domain=';
            ?>
            <div class="whcom_form_field whcom_form_field_horizontal">
                <label for="wcop_domain_transfer_link"><?php esc_html_e('Register', 'whcom')?></label>
                <input type="text" id="wcop_domain_transfer_link" value="<?php echo $product_url; ?>register" readonly>
            </div>
            <div class="whcom_form_field whcom_form_field_horizontal">
                <label for="wcop_domain_transfer_link"><?php esc_html_e('Transfer', 'whcom')?></label>
                <input type="text" id="wcop_domain_transfer_link" value="<?php echo $product_url; ?>transfer" readonly>
            </div>
        </div>
    </div>
<?php if ( ! empty( $whcom_groups ) ) { ?>
	<?php foreach ( $whcom_groups as $group_id => $group ) { ?>
		<?php if ( ! empty( $group['products'] ) ) { ?>
            <div class="whcom_collapse whcom_margin_bottom_30" data-tld-name="<?php echo $tld; ?>">
                <div class="whcom_collapse_toggle">
                    <i class="whcom_icon_down-open"></i>
                    <strong><?php echo $group['name'] ?></strong>
                </div>
                <div class="whcom_collapse_content">
					<?php foreach ( $group['products'] as $product_id => $product ) {
						$random      = 'product_' . $product_id;
						$order_url   = get_option( 'configure_product' . whcom_get_current_language(), '' );
						$order_url   = ( empty( $order_url ) ) ? home_url( '/' ) . 'client-area' : $order_url;
						$product_url = $order_url . '?pid=' . $product_id . '&order_type=order_product';
						?>
                        <div class="whcom_form_field whcom_form_field_horizontal">
                            <label for="<?php echo $random; ?>"><?php echo $product['name'] ?></label>
                            <input type="text" id="<?php echo $random; ?>" value="<?php echo $product_url; ?>"
                                   disabled="disabled">
                        </div>
					<?php } ?>
                </div>
            </div>
		<?php } ?>
	<?php } ?>
<?php } ?>