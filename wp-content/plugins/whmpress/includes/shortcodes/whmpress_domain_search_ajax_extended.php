<?php

$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

if ( ! defined( 'WHCOM_VERSION' ) ) {
    ob_start() ?>
    <div class="">
        <p>
            <?php esc_html_e( 'Shortcode whmpress_domain_search_ajax_extended requires at least one of the following plugin.', 'whmpress' ) ?>
        </p>
        <ol>
            <li>
                <a href="https://codecanyon.net/item/whmcs-client-area-whmpress-addon/11218646">
                    <?php esc_html_e( 'WHMCS Client Area with API (WCAP)', 'whmpress' ) ?>
                </a>
            </li>
            <li>
                <a href="https://codecanyon.net/item/whmcs-cart-order-pages/20011354">
                    <?php esc_html_e( 'WHMCS Cart & Order Pages (WCOP)', 'whmpress' ) ?>
                </a>
            </li>
        </ol>
    </div>

    <?php echo ob_get_clean();

    return;
}

$params = shortcode_atts( [
    'text_class'              => '',
    'button_class'            => '',
    'action'                  => '',
    'html_class'              => 'whmpress whmpress_domain_search_ajax_extended',
    'html_id'                 => '',
    'placeholder'             => whmpress_get_option( "dsa_placeholder" ),  // "Search"
    'button_text'             => whmpress_get_option( "dsa_button_text" ), //'Search',
    'register_text'           => whmpress_get_option( "dsa_button_text" ), //'Search',
    'load_more_button_text'   => whmpress_get_option( "load_more_button_text" ),
    'order_button_text'       => whmpress_get_option( "register_domain_button_text" ),
    'www_button_text'         => esc_html__( 'WWW', 'whmpress' ),
    'whois_button_text'       => esc_html__( 'WHOIS', 'whmpress' ),
    'transfer_button_text'    => esc_html__( 'Transfer', 'whmpress' ),
    'added_button_text'       => esc_html__( 'Added', 'whmpress' ),
    'continue_button_text'    => esc_html__( 'Continue', 'whmpress' ),
    "whois_link"              => whmpress_get_option( "dsa_whois_link" ), //"yes",
    "www_link"                => whmpress_get_option( "dsa_www_link" ), //"yes",
    "disable_domain_spinning" => whmpress_get_option( "dsa_disable_domain_spinning" ), //"0",
    "order_landing_page"      => whmpress_get_option( "dsa_order_landing_page" ), //"0",
    "order_link_new_tab"      => whmpress_get_option( "dsa_order_link_new_tab" ), //"0",
    "show_price"              => whmpress_get_option( "dsa_show_price" ),
    "show_years"              => whmpress_get_option( "dsa_show_years" ),
    "search_extensions"       => whmpress_get_option( "dsa_search_extensions" ),
    "enable_transfer_link"    => whmpress_get_option( "dsa_transfer_link" ),
    "page_size"               => get_option( 'no_of_domains_to_show', '10' ),
    "style"                   => "default",
    "append_url"              => '',
    "filter_tlds"             => '',
], $atts );

$params = ( empty( $params ) ) ? [] : $params;
$style  = (string) $params['style'];
$file   = WHMP_PLUGIN_PATH . '/includes/shortcodes/domain_search_ajax_extended_parts/forms/' . $style . '.php';


// echo JSON tlds


$all_tlds = whmp_get_whmcs_tlds();
wp_add_inline_script( 'whmpress_scripts', 'var whmpress_all_tlds = ' . json_encode( $all_tlds, JSON_FORCE_OBJECT ) );
wp_add_inline_script( 'whmpress_scripts', 'var whmpress_added_tlds = ' . json_encode( [] ) );

if ( is_file( $file ) ) {
    include $file;
}
else {

    //todo: to be replaced with actual message

    ?>

<?php } ?>
