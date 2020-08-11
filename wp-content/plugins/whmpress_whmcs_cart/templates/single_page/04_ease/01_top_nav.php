<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );?>
<?php if ( strtolower( $atts['hide_navigation'] ) != 'yes' ) { ?>
    <div class="wcop_sp_nav whcom_nav_container whcom_sticky_item"
         data-nav-top-gap="<?php echo get_option( 'wcop_sp_nav_offset', 80 ); ?>">
        <ul>
			<?php if ( strtolower( $atts['hide_domain'] ) != 'yes' ) { ?>
                <li class="active">
                    <a href="#wcop_sp_choose_a_domain" class="whcom_smooth_scroll"
                       data-scroll-top-gap="<?php echo get_option( 'wcop_sp_scroll_offset', 140 ); ?>">
                        <span class="wcop_sp_nav_text"><?php esc_html_e( "Domain", "whcom" ) ?></span>
                    </a>
                    <span class="wcop_sp_nav_divider"></span>
                </li>
			<?php }
			else {
				$domain_products = 'no';
			} ?>
			<?php if ( strtolower( $atts['hide_product'] ) != 'yes' ) { ?>
                <li>
                    <a href="#wcop_choose_a_hosting" class="whcom_smooth_scroll"
                       data-scroll-top-gap="<?php echo get_option( 'wcop_sp_scroll_offset', 140 ); ?>">
                        <span class="wcop_sp_nav_text"><?php esc_html_e( "Hosting Plan", "whcom" ) ?></span>
                    </a>
                    <span class="wcop_sp_nav_divider"></span>
                </li>
			<?php } ?>
			<?php if ( strtolower( $atts['hide_additional_services'] ) != 'yes' ) { ?>
                <li>
                    <a href="#wcop_additional_services" class="whcom_smooth_scroll"
                       data-scroll-top-gap="<?php echo get_option( 'wcop_sp_scroll_offset', 140 ); ?>">
                        <span class="wcop_sp_nav_text"><?php esc_html_e( "Services", "whcom" ) ?></span>
                    </a>
                    <span class="wcop_sp_nav_divider"></span>
                </li>
			<?php } ?>
            <li>
                <a href="#wcop_billing_info" class="whcom_smooth_scroll"
                   data-scroll-top-gap="<?php echo get_option( 'wcop_sp_scroll_offset', 140 ); ?>">
                    <span class="wcop_sp_nav_text"><?php esc_html_e( "Billing Info", "whcom" ) ?></span>
                </a>
                <span class="wcop_sp_nav_divider"></span>
            </li>
            <li>
                <a href="#wcop_review_checkout" class="whcom_smooth_scroll"
                   data-scroll-top-gap="<?php echo get_option( 'wcop_sp_scroll_offset', 140 ); ?>">
                    <span class="wcop_sp_nav_text"><?php esc_html_e( "Checkout", "whcom" ) ?></span>
                </a>
                <span class="wcop_sp_nav_divider"></span>
            </li>
        </ul>
    </div>
<?php } ?>