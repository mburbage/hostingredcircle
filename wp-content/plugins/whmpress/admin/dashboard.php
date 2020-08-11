<?php
/**
 * @package Admin
 * @todo    Dashboard page for WHMpress admin panel
 */

if ( ! defined( 'WHMP_VERSION' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit();
}
global $wpdb;
$WHMPress = new WHMpress();

if ( isset( $_GET["removeSettings"] ) ) {
    // Removing all tables and data.
    #echo __("Removing cached data","whmpress")." ...<br />";
    global $Tables;
    global $wpdb;
    foreach ( $Tables as $table ) {
        $table_name = $wpdb->prefix . 'whmpress_' . $table;
        $Q          = "DROP TABLE `" . $table_name . "`";
        $wpdb->query( $Q );
    }

    echo "<div class='updated'>";
    echo "<h3>" . esc_html_x( 'Done','admin', 'whmpress' ) . "</h3>";
    echo "<p>" . esc_html_x( 'WHMpress cached data removed ....','admin', 'whmpress' ) . "</p></div>";

    // Removing settings data.
    // Coming soon.
}


ob_start();

$rand = rand(11111, 99999);
?>

<form onsubmit="return Verify(this)"  method="post">
    <div class="whmp_admin_form_field" style="font-weight: bold; color: #9B2124">
        <?php esc_html_x( "WHMPress is not verfified",'admin', "whmpress" ) ?>
    </div>
    <div class="whmp_admin_form_field">
        <label for="email_<?php echo $rand ?>"><?php echo esc_html_x('Email address','admin', 'whmpress')?></label>
        <input required="required" type="email" name="email"
               id="email_<?php echo $rand ?>"
               placeholder="<?php echo esc_html_x( "Email address",'admin', "whmpress" ) ?>"
               value="<?php echo get_option( "admin_email" ) ?>"/>
    </div>
    <div class="whmp_admin_form_field">
        <label for="purchase_code_<?php echo $rand ?>"><?php echo esc_html_x('Purchase Code','admin', 'whmpress')?></label>
        <input required="required" type="text" name="purchase_code" id="purchase_code_<?php echo $rand ?>"
               placeholder="<?php echo esc_html_x( "Purchase Code",'admin', "whmpress" ) ?>"/>
    </div>
<!--    <div style="color: #CC0000; font-size: 14px;margin-bottom: 8px;">-->
<!--        --><?php //if ($WHMPress->is_nexum_active()){
//            echo esc_html_x( "This version of WHMPress comes bundled with the neXum theme. Please use nexum purchase code to verify your purchase.",'admin', "whmpress" );
//        }else{
//            echo " ";
//        }?>
<!--    </div>-->
    <div class="whmp_admin_form_field" style="text-align: center">
        <button class="button button-primary" style="height: 40px; padding: 4px 24px; font-size: 16px;"><?php echo esc_html_x( "Verify WHMPress",'admin', "whmpress" ) ?></button>
    </div>
</form>

<?php
$verification_form = ob_get_clean();

## If styles are generic/default and (active_theme/whmpress exists or whmpress_folder/themes/active_theme folder exists)
if ( ( is_dir( get_template_directory() . "/whmpress/" ) || is_dir( WHMP_PLUGIN_PATH . "themes/" . basename( get_template_directory() ) ) ) && get_option( 'load_sytle_orders' ) == '' ) {
    ?>
    <div class="notice notice-success is-dismissible">
        <h3>WHMPress</h3>
        <p><?php echo esc_html_x( 'Matching Templates found for your active theme ','admin', 'whmpress' ). '<b>'. basename( get_template_directory() ) . '</b>' . esc_html_x( ' You can enable ','admin', 'whmpress' ) . '<b>' . basename( get_template_directory() ) . '</b>' . esc_html_x( ' support by selecting Template Source from ','admin', 'whmpress' ) . '<a href="admin.php?page=whmp-settings#styles">Settings > Styles</a>';?></p>
    </div>
    <?php
}
?>
<div class="full_page_loader">
    <div class="whmp_loader"><?php echo esc_html_x( "Loading",'admin', "whmpress" ) ?>...</div>
</div>
<div class="wrap about-wrap whmp_wrap">
    <h2></h2>
    <h1><?php echo esc_html_x( 'WHMPress', "admin", 'whmpress' ) ?></h1>

    <div class="about-text">
        <?php echo esc_html_x( 'It is used to display WHMCS products in a fancy way, without effort. Links will still point to WHMCS. Can be further extended using Addon, WHMCS Sliders & Comparison Tables (WPCT). WPCT is intended for users who need Sliders & Comparison tables.', 'admin', 'whmpress' ) ?>
    </div>
    <div id="whmp_admin_logo" class="wp-badge">
        Version <?php echo WHMP_VERSION; ?>
    </div>


    <h2 class="nav-tab-wrapper">
        <a class="nav-tab nav-tab-active" href="<?php echo admin_url() ?>admin.php?page=whmp-dashboard"><?php echo esc_html_x('Dashboard','admin','whmpress') ?></a>
        <a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-services"><?php echo esc_html_x('Products/Services','admin','whmpress') ?></a>
        <a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-settings"><?php echo esc_html_x('Settings','admin','whmpress') ?></a>
        <a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-pricing-tables"><?php echo esc_html_x('Pricing Tables','admin', 'whmpress')?></a>
        <a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-sync"><?php echo esc_html_x('Sync WHMCS','admin','whmpress') ?></a>
        <a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-debug"><?php echo esc_html_x('Debug info','admin', 'whmpress')?></a>
        <!--<a class="nav-tab" href="<?php /*echo admin_url() */ ?>admin.php?page=whmp-extensions">Addons</a>-->
    </h2>

    <!--<div class="whmp-main-title"><span class="whmp-title">WHMpress</span> <?php /*_e("Dashboard", "whmpress") */ ?></div>-->
    <div>
        <div class="whmpress_panel whmpress_50">
            <?php if ( $WHMPress->verified_purchase() ): ?>
                <div id="div3">
                    <h3><?php esc_html_x( "Registered WHMpress",'admin', "whmpress" ) ?></h3>
                    <div class="whmp_admin_panel_body">
                        <p style="color:#1B6B34;font-weight:bold"><?php echo esc_html_x( "Congratulation! WHMPress is verified", 'admin', "whmpress" ) ?>
                        <div style="clear: both;"></div>
                        <button type="button" class="button button-red"
                                onclick="UnVerify();"><?php echo esc_html_x( "Un-Verify WHMpress", 'admin', "whmpress" ) ?></button>
                    </div>
                </div>
                <div id="div4" style="display: none;">
                    <h3><?php echo esc_html_x( "Verify your purchase",'admin', "whmpress" ) ?></h3>
                    <div class="whmp_admin_panel_body">
                        <?php echo $verification_form ?>
                    </div>
                </div>
            <?php else: ?>
                <div style="display: none;" id="div1">
                    <h3><?php echo esc_html_x( "Verified Product",'admin', "whmpress" ) ?></h3>
                    <p style="color:#1B6B34;font-weight:bold"><?php echo esc_html_x( "Congratulation! WHMPress is verified",'admin', "whmpress" ) ?>

                        <button type="button" class="button button-red"
                                onclick="UnVerify();"><?php echo esc_html_x( "Un-Verify WHMpress",'admin', "whmpress" ) ?></button>
                </div>
                <div id="div2">
                    <h3><?php echo esc_html_x( "Verify your purchase",'admin', "whmpress" ) ?></h3>
                    <div class="whmp_admin_panel_body">
                        <?php echo $verification_form ?>
                    </div>
                </div>
            <?php endif; ?>
            <div>
                <h3><?php echo esc_html_x( "Reset WHMpress",'admin', "whmpress" ) ?></h3>
                <div class="whmp_admin_panel_body" style="height: 120px">
                    <p style="color: #CC0000;"><?php echo esc_html_x( "If you want to reset all WHMpress as it was newly installed, press this button",'admin', "whmpress" ) ?></p>
                    <p>
                        <button <?php if ( ! $WHMPress->WHMpress_synced() )
                            echo 'disabled="disabled"' ?> onclick="Reset()"
                                                          class="button button-red"><?php echo esc_html_x( "Reset WHMpress",'admin', "whmpress" ) ?></button>
                    </p>
                </div>
            </div>
        </div>
        <div class="whmpress_panel whmpress_50">
            <?php if ( ! $WHMPress->WHMpress_synced() ): ?>
                <div>
                    <h3><?php echo esc_html_x( "System Info",'admin', "whmpress" ) ?></h3>
                    <div class="whmp_admin_panel_body">

                        <p><?php echo esc_html_x( "No system info available",'admin', "whmpress" ) ?>, <a
                                    href="admin.php?page=whmp-sync"><?php echo esc_html_x( "Please Sync WHMCS",'admin', "whmpress" ) ?></a>
                        </p>
                    </div>
                </div>
            <?php else: ?>
                <div>
                    <h3><?php echo esc_html_x( "System Info",'admin', "whmpress" ) ?></h3>
                    <div class="whmp_admin_panel_body">
                        <p><strong>WHMpress <?php echo esc_html_x( "Version",'admin', "whmpress" ) ?></strong>: <?php echo WHMP_VERSION ?>
                            <br/>
                            <strong>WHMCS <?php echo esc_html_x( "Version",'admin', "whmpress" ) ?></strong>: <?php echo $wpdb->get_var( "SELECT `value` FROM `" . whmp_get_configuration_table_name() . "` WHERE `setting`='Version'" ); ?>
                            <br/>
                            <strong><?php echo esc_html_x( "Company Name",'admin', "whmpress" ) ?></strong>: <?php echo $wpdb->get_var( "SELECT `value` FROM `" . whmp_get_configuration_table_name() . "` WHERE `setting`='CompanyName'" ); ?>
                            <br/>
                            <strong><?php echo esc_html_x( "Language",'admin', "whmpress" ) ?></strong>: <?php echo $wpdb->get_var( "SELECT `value` FROM `" . whmp_get_configuration_table_name() . "` WHERE `setting`='Language'" ); ?>
                            <br/>
                            <strong><?php echo esc_html_x( "Email",'admin', "whmpress" ) ?></strong>: <?php echo $wpdb->get_var( "SELECT `value` FROM `" . whmp_get_configuration_table_name() . "` WHERE `setting`='email'" ); ?>
                            <br/>
                            <strong><?php echo esc_html_x( "Last Synced",'admin', "whmpress" ) ?></strong>: <span
                                    style="color: #CC0000;"><?php echo get_option( 'sync_time' ) ?></span>
                        </p>
                        <p>
                            <strong><?php echo esc_html_x( "Domains",'admin', "whmpress" ) ?></strong>: <?php echo $wpdb->get_var( "SELECT COUNT(*) FROM `" . whmp_get_domain_pricing_table_name() . "`" ); ?>
                            <br/>
                            <strong><?php echo esc_html_x( "Products",'admin', "whmpress" ) ?></strong>: <?php echo $wpdb->get_var( "SELECT COUNT(*) FROM `" . whmp_get_products_table_name() . "`" ); ?>
                            <br/>
                            <strong><?php echo esc_html_x( "Product Groups",'admin', "whmpress" ) ?></strong>: <?php echo $wpdb->get_var( "SELECT COUNT(*) FROM `" . whmp_get_product_group_table_name() . "`" ); ?>
                            <br/>
                            <strong><?php echo esc_html_x( "Currencies",'admin', "whmpress" ) ?></strong>: <?php echo $wpdb->get_var( "SELECT COUNT(*) FROM `" . whmp_get_currencies_table_name() . "`" ); ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <div>
                <h3><?php echo esc_html_x( "General",'admin', "whmpress" ) ?></h3>
                <div class="whmp_admin_panel_body" style="height: 120px">
                    <p><?php echo esc_html_x( "Watch this video to quickly learn about the use of WHMpress",'admin', "whmpress" ) ?></p>
                    <p><a href="https://whmpress.com/documentation/#document-4" target="_blank"
                          class="button button-primary"><?php echo esc_html_x( "Introduction Tour",'admin', "whmpress" ) ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function Reset() {
        if ( ! confirm( "<?php echo esc_html_x( "Warning! All cached data and all settings of WHMpress will removed",'admin', "whmpress" ) ?>.\n\n\n<?php _e( "Are you sure", "whmpress" ) ?>" ) ) {
            return false;
        }
        window.location.href = "admin.php?page=whmp-dashboard&removeSettings";
    }

    function UnVerify() {
        if ( ! confirm( "Are you sure you want to un-verify your purchase?" ) ) {
            return;
        }
        jQuery( ".full_page_loader" ).show();
        jQuery.post( ajaxurl, {'action': 'whmp_unverify'}, function ( response ) {
            if ( response === "OK" ) {
                window.location.reload();
            }
            else {
                alert( response );
            }
            jQuery( ".full_page_loader" ).hide();
        } );
    }

    function Verify( form ) {
        jQuery( ".full_page_loader" ).show();
        var data = jQuery( form ).serialize();
        data += "&action=whmp_verify";
        jQuery.post( ajaxurl, data, function ( response ) {
            if ( response === "OK" ) {
                window.location.reload();
            }
            else {
                alert( response );
            }
            jQuery( ".full_page_loader" ).hide();
        } );
    }
</script>