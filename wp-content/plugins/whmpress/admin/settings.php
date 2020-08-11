<?php
/**
 * @package Admin
 *
 */

if (!defined('WHMP_VERSION')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}


global $WHMPress;
$lang = $WHMPress->get_current_language();
$extend = empty($lang) ? "" : "_" . $lang;

global $wpdb;
$countries = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}whmpress_countries` ORDER BY `country_name`");
$WHMP = new WHMPress;
$currencies = $WHMP->get_currencies();

$settings_file = str_replace("\\", "/", get_stylesheet_directory()) . "/whmpress/settings.ini";
if (!is_file($settings_file)) {
    $settings_file = str_replace("\\", "/", WHMP_PLUGIN_DIR) . "/themes/" . basename(get_stylesheet_directory()) . "/settings.ini";
}

$newTR = "<tr>";
$newTR .= '<td><select name="whmp_countries_currencies[country][]">';
$newTR .= '<option value="">-- Select Country --</option>';
foreach ($countries as $country):
    $newTR .= '<option value="' . $country->country_code . '">' . $country->country_name . '</option>';
endforeach;
$newTR .= '</select>';
$newTR .= '</td>';
$newTR .= '<td>';
$newTR .= '<select name="whmp_countries_currencies[currency][]">';
$newTR .= '<option value="">-- Currency --</option>';
foreach ($currencies as $currency) {
    $newTR .= '<option value="' . $currency["id"] . '">' . $currency["code"] . '</option>';
}
$newTR .= '</select> ';
$newTR .= '[<a title="Remove this country" href="javascript:;" onclick="Remove(this)">X</a>]';
$newTR .= '</td>';
$newTR .= '</tr>';
$newTR = str_replace('"', "'", $newTR);

if ((is_dir(get_template_directory() . "/whmpress/") || is_dir(WHMP_PLUGIN_PATH . "themes/" . basename(get_template_directory()))) && get_option('load_sytle_orders') == '') {
    ?>
    <div class="notice notice-success is-dismissible">
        <h3>WHMPress</h3>
        <p><?php echo esc_html_x( 'Matching Templates found for your active theme ','admin', 'whmpress' ). '<b>'. basename( get_template_directory() ) . '</b>' . esc_html_x( ' You can enable ','admin', 'whmpress' ) . '<b>' . basename( get_template_directory() ) . '</b>' . esc_html_x( ' support by selecting Template Source from ','admin', 'whmpress' ) . '<a href="admin.php?page=whmp-settings#styles">Settings > Styles</a>';?></p>
    </div>
    <?php
}

global $wpdb; ?>
<div class="full_page_loader">
    <div class="whmp_loader"><?php echo esc_html_x("Loading", 'admin', "whmpress") ?>...</div>
</div>
<div class="wrap whmp_wrap">
    <h2></h2>
    <?php
    if (is_file($settings_file)) {
        $Data = parse_ini_file($settings_file, true);
        $theme = wp_get_theme();
        ?>
        <div class="updated">
            <form method="post" action="<?php echo WHMP_PLUGIN_URL; ?>/includes/apply_settings.php" name="whmp_form">
                <input type="hidden" name="import_settings">
                <input type="hidden" name="file" value="<?php echo $settings_file ?>">
                <p>
                    <?php
                    $current_theme = "(<b>" . $theme->Name . "</b>)";
                    printf(esc_html_x('This plugin comes pre-configured for your current theme %1s.
            The look and feel of WHMCS client area have been adjusted to match %2s.', 'admin', 'whmpress'), $current_theme, $current_theme);
                    echo "<br>";
                    printf(esc_html_x('To further adjust the settings click the button(s) below.', 'admin', 'whmpress'));
                    ?>
                    <br><br>
                    <button class="button" onclick="ImportSettings('')">
                        <i><?php echo esc_html_x('Adjust All Settings', 'admin', 'whmpress'); ?></i></button>
                    <?php if (is_array($Data)) {
                        foreach ($Data as $k => $v): ?>
                            <button class="button button-primary"
                                    onclick='ImportSettings("<?php echo $k ?>")'><?php echo $k ?></button>
                        <?php endforeach;
                    } ?>
                </p>
            </form>
        </div>
        <script>
            function ImportSettings(Section) {
                jQuery("input[name=import_settings]").val(Section);
                document.whmp_form.submit();
            }
        </script><?php
    } ?>


    <!--<div class="whmp-main-title"><span class="whmp-title">WHMpress</span> <?php /*_e("Settings", "whmpress") */ ?></div>-->
    <h2 class="nav-tab-wrapper">
        <a class="nav-tab"
           href="<?php echo admin_url() ?>admin.php?page=whmp-dashboard"><?php echo esc_html_x('Dashboard', 'admin', 'whmpress') ?></a>
        <a class="nav-tab"
           href="<?php echo admin_url() ?>admin.php?page=whmp-services"><?php echo esc_html_x('Products/Services', 'admin', 'whmpress') ?></a>
        <a class="nav-tab nav-tab-active"
           href="<?php echo admin_url() ?>admin.php?page=whmp-settings"><?php echo esc_html_x('Settings', 'admin', 'whmpress') ?></a>
        <a class="nav-tab"
           href="<?php echo admin_url() ?>admin.php?page=whmp-pricing-tables"><?php echo esc_html_x('Pricing Tables', 'admin', 'whmpress') ?></a>
        <a class="nav-tab"
           href="<?php echo admin_url() ?>admin.php?page=whmp-sync"><?php echo esc_html_x('Sync WHMCS', 'admin', 'whmpress') ?></a>
        <a class="nav-tab"
           href="<?php echo admin_url() ?>admin.php?page=whmp-debug"><?php echo esc_html_x('Debug info', 'admin', 'whmpress') ?></a>
    </h2>

    <?php if (!$WHMPress->WHMpress_synced()): ?>

        <div class="whmp_admin_notice whmp_admin_notice_error">
            <h3><?php echo esc_html_x("Settings", 'admin', "whmpress") ?>:</h3>
            <p><strong><?php echo esc_html_x("WHMCS is not Synced", 'admin', "whmpress") ?></strong>
                <?php echo esc_html_x('You will not be able to modify any settings until you sync WHMCS', 'admin', 'whmpress') ?>
            </p>
            <a class="button button-primary"
               href="admin.php?page=whmp-sync"><?php echo esc_html_x("Please Sync WHMCS", 'admin', "whmpress") ?></a>
        </div>

    <?php else: ?>

        <?php if (isset($_GET["settings-updated"]) && $_GET["settings-updated"] == "true") {
            echo "<div class='updated'><p><b>Success</b><br />Settings saved.</p></div>";
        } ?>

        <div id="whmp-tabs" class="tab-container">
            <ul class='etabs'>
                <li class='tab'><a href='#general'><?php echo esc_html_x("General", 'admin', "whmpress") ?></a></li>
                <li class='tab'><a href="#styles"><?php echo esc_html_x("Styles", 'admin', "whmpress") ?></a></li>
                <?php if (function_exists('whmpress_domain_search_ajax_function')): ?>
                    <li class='tab'><a
                                href="#ajax_domain_search"><?php echo esc_html_x("Domain Search", 'admin', "whmpress") ?></a>
                    </li>
                <?php endif; ?>
                <li class='tab'><a href="#defaults"><?php echo esc_html_x("Default Values", 'admin', "whmpress") ?></a>
                </li>
                <li class='tab'><a href="#3rdparty"><?php echo esc_html_x("3rd Party", 'admin', "whmpress") ?></a></li>
                <li class='tab'><a href="#advanced"><?php echo esc_html_x("Advanced", 'admin', "whmpress") ?></a></li>
                <li class='tab'><a
                            href="#registration"><?php echo esc_html_x("Registration", 'admin', "whmpress") ?></a></li>
            </ul>
            <form method="post" action="options.php">
                <?php settings_fields('whmp_settings');
                do_settings_sections('whmp_settings'); ?>

                <div id="general">
                    <table class="form-table">
                        <?php if (is_active_cap()) { ?>
                            <tr>
                                <td colspan="2">
                                    <p style="border-left:4px solid #CC0000;background-color:#fff;padding:10px;">
                                        <?php echo esc_html_x("If you have SSL URL configured in WHMCS Admin Area > Setup > General Settings then you must select HTTPS from here, Or you will endup with redirect loop.", 'admin', "whmpress"); ?>
                                    </p>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("WHMCS URL", 'admin', "whmpress") ?></td>
                            <td>
                                <?php
                                $Q = "SELECT `value` FROM `" . whmp_get_configuration_table_name() . "` WHERE `setting`='SystemURL' OR `setting`='SystemSSLURL' ORDER BY `setting` DESC";
                                $Us = $wpdb->get_results($Q, ARRAY_A); ?>
                                <select style="width:100%;" name="whmcs_url">
                                    <?php foreach ($Us as $U):
                                        if (whmp_get_installation_url() == $U["value"]) {
                                            $S = "selected=selected";
                                        } else {
                                            $S = "";
                                        } ?>
                                        <option <?php echo $S ?>><?php echo $U["value"] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <h3 class="whmp-sub-head">
                        <?php echo esc_html_x('Price Styling options', 'admin', 'whmpress') ?>
                    </h3>
                    <p>
                        <?php echo esc_html_x('These settings will be applied to prices shown through out the plugin, except price shortcode it self.', 'admin', 'whmpress') ?>
                    </p>
                    <table class="form-table">
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("Show trailing zeros in price", 'admin', "whmpress") ?></td>
                            <td>
                                <?php $dz = esc_attr(get_option('show_trailing_zeros', "no")); ?>
                                <select style="width:100%;" name="show_trailing_zeros">
                                    <option value="no"><?php echo esc_html_x("No", 'admin', "whmpress") ?></option>
                                    <option
                                            value="yes" <?php echo $dz == "yes" ? "selected=selected" : ""; ?>><?php echo esc_html_x("Yes", 'admin', "whmpress") ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("Show symbol with price", 'admin', "whmpress") ?></td>
                            <td>
                                <?php $symb = esc_attr(get_option('default_currency_symbol', "prefix")); ?>
                                <select style="width:100%;" name="default_currency_symbol">
                                    <option value="prefix"><?php echo esc_html_x("Prefix", 'admin', "whmpress") ?></option>
                                    <option
                                            value="suffix" <?php echo $symb == "suffix" ? "selected=selected" : ""; ?>><?php echo esc_html_x("Suffix", 'admin', "whmpress") ?></option>
                                    <option
                                            value="code" <?php echo $symb == "code" ? "selected=selected" : ""; ?>><?php echo esc_html_x("Code", 'admin', "whmpress") ?></option>
                                    <option
                                            value="both" <?php echo $symb == "both" ? "selected=selected" : ""; ?>><?php echo esc_html_x("Both", 'admin', "whmpress") ?></option>
                                    <option
                                            value="none" <?php echo $symb == "none" ? "selected=selected" : ""; ?>><?php echo esc_html_x("None", 'admin', "whmpress") ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("Duration Style", 'admin', "whmpress") ?></td>
                            <td>
                                <?php $duration_style = esc_attr(get_option('default_currency_duration_style', "duration")); ?>
                                <select style="width:100%;" name="default_currency_duration_style">
                                    <option
                                            value="duration" <?php echo $duration_style == "duration" ? "selected=selected" : ""; ?>><?php echo esc_html_x("Default", 'admin', "whmpress") ?></option>
                                    <option
                                            value="long" <?php echo $duration_style == "long" ? "selected=selected" : ""; ?>><?php echo esc_html_x("Long (year)", 'admin', "whmpress") ?></option>
                                    <option
                                            value="short" <?php echo $duration_style == "short" ? "selected=selected" : ""; ?>><?php echo esc_html_x("Short (yr)", 'admin', "whmpress") ?></option>
                                    <option
                                            value="monthly" <?php echo $duration_style == "monthly" ? "selected=selected" : ""; ?>><?php echo esc_html_x("Convert to Months (12 month)", 'admin', "whmpress") ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("Duration Connector", 'admin', "whmpress") ?></td>
                            <td>
                                <?php $duration_connector = esc_attr(get_option('default_currency_duration_connector', "/")); ?>
                                <input style="width: 100%;" type="text" value="<?php echo $duration_connector; ?>"
                                       name="default_currency_duration_connector">
                            </td>
                        </tr>
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("Decimals", 'admin', "whmpress") ?></td>
                            <td>
                                <?php $default_decimal_places = intval(esc_attr(get_option('default_decimal_places', "2"))); ?>
                                <input style="width: 100%;" type="text" value="<?php echo $default_decimal_places; ?>"
                                       name="default_decimal_places">
                            </td>
                        </tr>
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("String to show if price not configured", 'admin', "whmpress") ?></td>
                            <td>
                                <?php $not_configured_override = esc_attr(get_option('not_configured_override' . $extend, "N/A")); ?>
                                <input style="width: 100%;" type="text" value="<?php echo $not_configured_override; ?>"
                                       name="not_configured_override<?php echo $extend ?>">
                            </td>
                        </tr>
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("String to show if price is zero", 'admin', "whmpress") ?></td>
                            <td>
                                <?php $zero_override = esc_attr(get_option('zero_override' . $extend, "Free")); ?>
                                <input style="width: 100%;" type="text" value="<?php echo $zero_override; ?>"
                                       name="zero_override<?php echo $extend ?>">
                            </td>
                        </tr>
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("Override string if billing cycle is \"One Time\"", 'admin', "whmpress") ?></td>
                            <td>
                                <?php $zero_override = esc_attr(get_option('onetime_override' . $extend, "One Time")); ?>
                                <input style="width: 100%;" type="text" value="<?php echo $zero_override; ?>"
                                       name="onetime_override<?php echo $extend ?>">
                            </td>
                        </tr>
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("Calculate Configurable Options", 'admin', "whmpress") ?></td>
                            <td>
                                <?php $calculate_configurable_price = esc_attr(get_option('calculate_configurable_price', "no")); ?>
                                <select style="width:100%;" name="calculate_configurable_price">
                                    <option value="no"><?php echo esc_html_x("No", 'admin', "whmpress") ?></option>
                                    <option
                                            value="yes" <?php echo $calculate_configurable_price == "yes" ? "selected=selected" : ""; ?>><?php echo esc_html_x("Yes", 'admin', "whmpress") ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("Include Setup Price", 'admin', "whmpress") ?></td>
                            <td>
                                <?php $include_setup_price = esc_attr(get_option('include_setup_price', "no")); ?>
                                <select style="width:100%;" name="include_setup_price">
                                    <option value="no"><?php echo esc_html_x("No", 'admin', "whmpress") ?></option>
                                    <option
                                            value="yes" <?php echo $include_setup_price == "yes" ? "selected=selected" : ""; ?>><?php echo esc_html_x("Yes", 'admin', "whmpress") ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("Calculate Tax", 'admin', "whmpress") ?></td>
                            <td>
                                <?php $include_setup_price = esc_attr(get_option('calculate_tax', "no")); ?>
                                <select style="width:100%;" name="calculate_tax">
                                    <option value="no"><?php echo esc_html_x("No", 'admin', "whmpress") ?></option>
                                    <option
                                            value="yes" <?php echo $include_setup_price == "yes" ? "selected=selected" : ""; ?>><?php echo esc_html_x("Yes", 'admin', "whmpress") ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("Back button URL for Price Table Extended", 'admin', "whmpress") ?></td>
                            <td>
                                <?php $back_button_url = esc_attr(get_option('back_button_url')); ?>
                                <input style="width: 100%;" type="text" value="<?php echo $back_button_url; ?>"
                                       name="back_button_url">
                            </td>
                        </tr>
                        <tr>

							<td>&nbsp;</td>
                            <td><?php submit_button(); ?></td>
                        </tr>


                    </table>
                </div>
                <div id="styles">
                    <table class="form-table">
                        <!--<tr scope="row">
							<td style="width:30%;"><?php // echo esc_html_x( "Select style",'admin', "whmpress" ) ?></td>
							<td>
								<select name="whmp_custom_css">
									<?php // $theme_files = glob( WHMP_PLUGIN_DIR . "/styles/*.css" );
                        //if ( is_array( $theme_files ) ) {
                        //foreach ( $theme_files as $theme_file ):
                        //$S = whmpress_get_option( "whmp_custom_css" ) == basename( $theme_file ) ? "selected=selected" : ""; ?>
											<option <?php // echo $S ?>><?php // echo basename( $theme_file ) ?></option>
										<?php // endforeach;
                        //} ?>
								</select>
								<br>
								<span style="color: #CC0000;">
                            <b>Note:</b> <?php echo esc_html_x("These styles are used if you do not select any templates while inserting WHMpress shortcodes.", 'admin', "whmpress"); ?>
                            </span>
							</td>
						</tr>-->
                        <?php
                        $theme_whmpress_folder = get_stylesheet_directory() . "/whmpress/";
                        $disable1 = false;
                        if (!is_dir($theme_whmpress_folder)) {
                            $disable1 = true;
                        } else {
                            if (count_folders($theme_whmpress_folder) == 0) {
                                $disable1 = true;
                            }
                        }
                        $path = basename(get_template_directory());
                        $path = WHMP_PLUGIN_PATH . "themes/" . $path;
                        $disable2 = false;
                        if (!is_dir($path)) {
                            $disable2 = true;
                        }

                        $message1 = basename(get_template_directory()) . esc_html_x(' - Custom Templates', 'admin', 'whmpress');
                        if ($disable1) {
                            $message1 .= " " . esc_html_x("(Not found)", 'admin', "whmpress");
                        }

                        $message2 = basename(get_template_directory()) . esc_html_x(' Templates by WHMpress', 'admin', 'whmpress');
                        if ($disable2) {
                            $message2 .= " " . esc_html_x("(Not found)", 'admin', "whmpress");
                        }
                        ?>
                        <tr valign="top">
                            <td scope="row"
                                style="width:30%;"><?php echo esc_html_x("Templates to Use", 'admin', "whmpress") ?></td>
                            <td>
                                <select name="load_sytle_orders">
                                    <option
                                            value=""><?php echo esc_html_x('Default (Works with any theme)', 'admin', 'whmpress'); ?></option>
                                    <option <?php echo $disable1 ? 'disabled="disabled"' : ''; ?> <?php echo get_option("load_sytle_orders") == "author" ? "selected=selected" : "" ?>
                                            value="author"><?php echo $message1; ?></option>
                                    <option <?php echo $disable2 ? 'disabled="disabled"' : ''; ?> <?php echo get_option("load_sytle_orders") == "whmpress" ? "selected=selected" : "" ?>
                                            value="whmpress"><?php echo $message2; ?></option>
                                </select>
                                <br>
                                <span style="color: #CC0000;">
                                <b>Note:</b> <?php echo esc_html_x("Matching Pricing Tables and other templates for your active theme are available. To use them select appropriate option", 'admin', "whmpress"); ?>
                            </span>
                            </td>
                        </tr>


                        <tr scope="row">
                            <td valign="top"
                                style="width:30%;"><?php echo esc_html_x("Custom CSS codes", 'admin', "whmpress") ?></td>
                            <td>
                                <textarea style="width: 100%; height:100px"
                                          name="whmp_custom_css_codes"><?php echo esc_attr(whmpress_get_option("whmp_custom_css_codes")); ?></textarea>
                            </td>
                        </tr>
                    </table>

                    <?php if (true) { ?>
                        <h3 class="whmp-sub-head">Optimization</h3>
                        <table class="form-table">
                            <tr scope="row">

                                <td valign="top"
                                    style="width:30%;"><?php echo esc_html_x("Include font awesome", 'admin', "whmpress") ?></td>
                                <td>
                                    <select name="include_fontawesome">
                                        <option value="0"><?php echo esc_html_x("No", 'admin', "whmpress") ?></option>
                                        <option
                                                value="1" <?php echo get_option('include_fontawesome') == "1" ? "selected=selected" : "" ?>><?php echo esc_html_x("Yes", 'admin', "whmpress") ?></option>
                                    </select><br/>
                                    <span style="color: #CC0000;">
                                    <?php
                                    esc_html_e('Note: FontAwesome is font icons library, which is used by our "Pricing Table Groups". If your theme do not include FontAwesome then you can use FontAwesome.', 'whmpress');

                                    ?>
                    </span>
                                </td>
                            </tr>

                            <!-- My code -->

                            <!-- domain matrix related option options -->
                            <tr scope="row">
                                <td valign="top"
                                    style="width:30%;"><?php echo esc_html_x("Include data table", 'admin', "whmpress") ?></td>
                                <td>
                                    <select name="include_datatable">
                                        <option value="0"><?php echo esc_html_x("No", 'admin', "whmpress") ?></option>
                                        <option
                                                value="1" <?php echo get_option('include_datatable') == "1" ? "selected=selected" : "" ?>><?php echo esc_html_x("Yes", 'admin', "whmpress") ?></option>
                                    </select><br/>
                                    <span style="color: #CC0000;">
                    <?php
                    esc_html_e('Note: DataTables is a library, which is used by  "Domain Matrix Shortcode". If you do not plan to use data tables feature, you should select No', 'whmpress');


                    ?>
                    </span>
                                </td>
                            </tr>

                            <tr scope="row">
                                <td valign="top"
                                    style="width:30%;"><?php echo esc_html_x("Include quick search in domain matrix", 'admin', "whmpress") ?></td>
                                <td>
                                    <select name="include_jquery_quicksearch">
                                        <option value="0"><?php echo esc_html_x("No", 'admin', "whmpress") ?></option>
                                        <option
                                                value="1" <?php echo get_option('include_jquery_quicksearch') == "1" ? "selected=selected" : "" ?>><?php echo esc_html_x("Yes", 'admin', "whmpress") ?></option>
                                    </select><br/>
                                    <span style="color: #CC0000;">
                                    <?php
                                    esc_html_e('Note: QuickSearch</a> is a library, which is used by our "Domain Matrix Shortcode". If you do not plan to use quick search in Domain  Matrix, select No', 'whmpress');
                                    ?>

                    </span>
                                </td>
                            </tr>

                            <tr scope="row">
                                <td valign="top"
                                    style="width:30%;"><?php echo esc_html_x("Include slick slider", 'admin', "whmpress") ?></td>
                                <td>
                                    <select name="include_slickslider">
                                        <option value="0"><?php echo esc_html_x("No", 'admin', "whmpress") ?></option>
                                        <option
                                                value="1" <?php echo get_option('include_slickslider') == "1" ? "selected=selected" : "" ?>><?php echo esc_html_x("Yes", 'admin', "whmpress") ?></option>
                                    </select><br/>
                                    <span style="color: #CC0000;">
                                    <?php
                                    esc_html_e('Note: SlickSlider is a library, which is used by our "Pricing Tables". If you are not using the WSAC Addon, you should select No', 'whmpress');
                                    ?>
                    </span>
                                </td>
                            </tr>
                            <!-- My code ends -->

                        </table>

                    <?php } ?>

                    <table class="form-table">
                        <tr>
                            <td></td>
                            <td><?php submit_button(); ?></td>
                        </tr>
                    </table>


                </div>
                <?php if (function_exists('whmpress_domain_search_ajax_function')): ?>
                    <div id="ajax_domain_search">
                        <?php include_once(dirname(__FILE__) . "/settings-tabs/domain_search.php"); ?>
                    </div>
                <?php endif; ?>
                <div id="defaults" class="level-2-tabs-container">
                    <?php include_once(dirname(__FILE__) . "/settings-tabs/defaults.php"); ?>
                </div>
                <div id="3rdparty">
                    <h3 class="whmp-sub-head"><?php echo esc_html_x("URL override for compatibility with third party tools (WHMCS Bridge)", 'admin', "whmpress") ?></h3>

                    <?php if (is_active_cap()) {
                        $disabled = "disabled=disabled"; ?>
                        <div style="border: 2px solid #FCBD28;padding:10px;background:#FFFFFF;font-weight:bold">
                            <?php echo esc_html_x("WHMCS Client Area Addon is Active. If you want to use a third party plugin for this purpose (WHMCS-bridge) please deactivate the WHMCS Client Area Addon by WHMpress", 'admin', "whmpress") ?></div>
                    <?php } else {
                        $disabled = "";
                    } ?>

                    <table class="form-table">
                        <tr valign="top">
                            <td style="width:30%;"
                                scope="row"><?php echo esc_html_x("Client Area URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;" name="client_area_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('client_area_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("Announcements URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;" name="announcements_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('announcements_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("Submit Ticket URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;" name="submit_ticket_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('submit_ticket_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("Downloads page URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;" name="downloads_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('downloads_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("Support Tickets URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;" name="support_tickets_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('support_tickets_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("Knowledgebase URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;" name="knowledgebase_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('knowledgebase_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("Affiliates URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;" name="affiliates_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('affiliates_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("Order URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;" name="order_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('order_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("Pre-sales Contact URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;"
                                                               name="pre_sales_contact_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('pre_sales_contact_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("Domain Checker URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;" name="domain_checker_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('domain_checker_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("Server Status URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;" name="server_status_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('server_status_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("Network Issues URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;" name="network_issues_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('network_issues_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("WHMCS Login URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;" name="whmcs_login_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('whmcs_login_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("WHMCS Register URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;" name="whmcs_register_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('whmcs_register_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td scope="row"><?php echo esc_html_x("WHMCS Forget Password URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input <?php echo $disabled ?> type="url" style="width:100%;"
                                                               name="whmcs_forget_password_url"
                                                               value="<?php echo esc_attr(whmpress_get_option('whmcs_forget_password_url')); ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <?php if ($disabled == ""): ?>
                                <td colspan="3"><?php submit_button(); ?></td>
                            <?php else: ?>
                                <td colspan="3"><input disabled="disabled" type="button" name="submit" id="submit"
                                                       class="button button-primary"
                                                       value="<?php echo esc_html_x("Save Changes", 'admin', "whmpress") ?>">
                                </td>
                            <?php endif; ?>
                        </tr>
                    </table>
                </div>
                <div id="advanced">
                    <table class="form-table">
                        <tr valign="top">
                            <td style="width:30%;"
                                scope="row"><?php echo esc_html_x("Override WHMCS URL", 'admin', "whmpress") ?></td>
                            <td>
                                <input type="url" style="width:100%;" name="overwrite_whmcs_url"
                                       value="<?php echo esc_attr(whmpress_get_option('overwrite_whmcs_url')); ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td style="width:30%;"
                                scope="row"><?php echo esc_html_x("Use UTF encode/decode", 'admin', "whmpress") ?></td>
                            <td>
                                <select name="whmpress_utf_encode_decode">
                                    <option value="">== Nothing ==</option>
                                    <option <?php echo whmpress_get_option('whmpress_utf_encode_decode') == "utf_encode" ? "selected=selected" : ""; ?>
                                            value="utf_encode">UTF Encode
                                    </option>
                                    <option <?php echo whmpress_get_option('whmpress_utf_encode_decode') == "utf_decode" ? "selected=selected" : ""; ?>
                                            value="utf_decode">UTF Decode
                                    </option>
                                </select>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td style="width:30%;"
                                scope="row"><?php echo esc_html_x("Package Details from WHMpress", 'admin', "whmpress") ?></td>
                            <td>
                                <select name="whmpress_use_package_details_from_whmpress">
                                    <option value="No">No</option>
                                    <option <?php echo whmpress_get_option('whmpress_use_package_details_from_whmpress') == "Yes" ? "selected=selected" : ""; ?>
                                            value="Yes">Yes
                                    </option>
                                </select>
                            </td>
                        </tr>


                        <tr valign="top">
                            <td style="width:30%;"
                                scope="row"><?php echo esc_html_x("Auto change currency according to country ", 'admin', "whmpress") ?></td>
                            <td>
                                <select name="whmpress_auto_change_currency_according_to_country">
                                    <option value="No">No</option>
                                    <option <?php echo whmpress_get_option('whmpress_auto_change_currency_according_to_country') == "Yes" ? "selected=selected" : ""; ?>
                                            value="Yes">Yes
                                    </option>
                                </select>
                                <a href="admin.php?page=whmp-country-settings"><?php echo esc_html_x("Set Country Specific Currency Options.", 'admin', 'whmpress'); ?></a><br>
                                <?php echo esc_html_x("This feature uses IP2Country database from ip2location.com. Database is not not included in package to keep the package light. You will need to download Lite version of IPV4 in CSV format and import in table", 'admin', 'whmpress'); ?>


                                <?php echo whmp_get_ip2country_table_name() ?>

                            </td>
                        </tr>


                        <tr valign="top">
                            <td style="width:30%;"
                                scope="row"><?php echo esc_html_x("WHMCS Sync Frequency", 'admin', "whmpress") ?></td>
                            <td>
                                <select name="whmpress_cron_recurrance">
                                    <option value="">Disabled</option>
                                    <option <?php echo get_option("whmpress_cron_recurrance") == "hourly" ? "selected=selected" : ""; ?>
                                            value="hourly">Hourly
                                    </option>
                                    <option <?php echo get_option("whmpress_cron_recurrance") == "twicedaily" ? "selected=selected" : ""; ?>
                                            value="twicedaily">Twice Daily
                                    </option>
                                    <option <?php echo get_option("whmpress_cron_recurrance") == "daily" ? "selected=selected" : ""; ?>
                                            value="daily">Daily
                                    </option>
                                </select>
                                &nbsp;
                                Use <code><?php echo get_home_url(); ?>/wp-cron.php?doing_wp_cron</code> for your
                                cron.<br>
                                <?php echo esc_html_x("You must of have (Save Password) enabled on Sync WHMCS page.", 'admin', 'whmpress'); ?>
                            </td>
                        </tr>

                        <tr valign="top">
                            <td style="width:30%;"
                                scope="row"><?php echo esc_html_x("Session Cache Limiter Value", 'admin', "whmpress") ?></td>
                            <td>
                                <select name="whmpress_session_cache_limiter_value">
                                    <option <?php echo whmpress_get_option('whmpress_session_cache_limiter_value') == "" ? "selected=selected" : ""; ?>
                                            value=''>empty
                                    </option>
                                    <option <?php echo whmpress_get_option('whmpress_session_cache_limiter_value') == "public" ? "selected=selected" : ""; ?>
                                            value='public'>public
                                    </option>
                                    <option <?php echo whmpress_get_option('whmpress_session_cache_limiter_value') == "private_no_expire" ? "selected=selected" : ""; ?>
                                            value='private_no_expire'>private_no_expire
                                    </option>
                                    <option <?php echo whmpress_get_option('whmpress_session_cache_limiter_value') == "private" ? "selected=selected" : ""; ?>
                                            value='private'>private
                                    </option>
                                    <option <?php echo whmpress_get_option('whmpress_session_cache_limiter_value') == "nocache" ? "selected=selected" : ""; ?>
                                            value='nocache'>nocache
                                    </option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td colspan="3"><?php submit_button(); ?></td>
                        </tr>
                    </table>
                </div>
            </form>
            <div id="registration">
                <?php if ($WHMPress->verified_purchase()): ?>
                    <table class="form-table">
                        <tr>
                            <td><?php echo esc_html_x("Your purchase of WHMpress is registered", 'admin', 'whmpress') ?></td>
                            <td style="text-align: right;">
                                <button type="button" class="button button-red"
                                        onclick="UnVerify();"><?php echo esc_html_x("Un-Register WHMpress", 'admin', "whmpress") ?></button>
                            </td>
                        </tr>
                    </table>
                <?php else: ?>
                    <form onsubmit="return Verify();" name="verify_form" id="verify_form" method="post">
                        <table style="width:100%">
                            <tr>
                                <td colspan="3"><?php echo esc_html_x("Email required for providing support for this product", 'admin', "whmpress") ?></td>
                            </tr>
                            <tr>
                                <td><input required="required" style="width:100%;" type="email" id="femail" name="email"
                                           placeholder="<?php echo esc_html_x("Email address", 'admin', "whmpress") ?>"
                                           value="<?php echo get_option("admin_email") ?>"/></td>
                                <td><input required="required" style="width:100%;" type="text" id="fpurchase_code"
                                           name="purchase_code"
                                           placeholder="<?php echo esc_html_x("Purchase Code", 'admin', "whmpress") ?>"/>
                                </td>
                                <td>
                                    <button type="button" onclick="Verify();" style="width:100%;"
                                            class="button button-primary"><?php echo esc_html_x("Verify", 'admin', "whmpress") ?></button>
                                </td>
                            </tr>
                        </table>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <span id="settingsloaded"></span>
    <?php endif; ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#whmp-tabs').easytabs();
        jQuery('#whmp-default-tabs').easytabs();
        jQuery('#whmp-dsearch-tabs').easytabs();
        /*jQuery('ul.tabs').each(function(){
         // For each set of tabs, we want to keep track of
         // which tab is active and it's associated content
         var $active, $content, $links = jQuery(this).find('a');

         // If the location.hash matches one of the links, use that as the active tab.
         // If no match is found, use the first link as the initial active tab.
         $active = jQuery($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
         $active.addClass('active');

         $content = jQuery($active[0].hash);

         // Hide the remaining content
         $links.not($active).each(function () {
         jQuery(this.hash).hide();
         });

         // Bind the click event handler
         jQuery(this).on('click', 'a', function(e){
         // Make the old tab inactive.
         $active.removeClass('active');

         $content.hide();

         // Update the variables with the new link and content
         $active = jQuery(this);
         $content = jQuery(this.hash);

         // Make the tab active.
         $active.addClass('active');
         $content.show();

         // Prevent the anchor's default click action
         e.preventDefault();
         });
         });*/
    });
    function UnVerify() {
        if (!confirm("Are you sure you want to unverify your purchase?")) return;
        jQuery(".full_page_loader").show();
        jQuery.post(ajaxurl, {'action': 'whmp_unverify'}, function (response) {
            if (response == "OK") {
                window.location.reload();
            }
            else {
                alert(response);
            }
            jQuery(".full_page_loader").hide();
        });
        return false;
    }
    function Verify() {
        jQuery(".full_page_loader").show();
        var data = "purchase_code=" + jQuery("#fpurchase_code").val() + "&email=" + jQuery("#femail").val();
        data += "&action=whmp_verify";
        jQuery.post(ajaxurl, data, function (response) {
            if (response == "OK") {
                window.location.reload();
            }
            else {
                jQuery(".full_page_loader").hide();
                alert(response);
            }
        });
        return false;
    }
    function AddTR() {
        jQuery("#country_table tbody").append("<?php echo $newTR ?>");
    }
    function Remove(tthis) {
        jQuery(tthis).parent().parent().remove();
    }
    function SendInfo() {
        if (!confirm("Are you sure you want to send this information to Author for support?")) return;
        jQuery(".full_page_loader").show();
        jQuery.post(ajaxurl, {'action': 'send_info_to_author'}, function (response) {
            jQuery(".full_page_loader").hide();
            if (response == "OK") {
                alert("Thank you, your debug information has been sent to Author");
            }
            else {
                alert(response);
            }
        });
        return false;
    }
</script>