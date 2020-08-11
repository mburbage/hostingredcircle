<?php
/**
 * Copyright (c) 2014-2016 by creativeON.
 */

/**
 * Displays a form for getting whois info of multiple line provided domains
 *
 * List of parameters
 * text_class = HTML class for input search text box
 * button_class = HTML class for submit button of form
 * html_class = HTML class for wrapper
 * html_id = HTML id for wrapper
 * placeholder = placeholder text for input search textbox
 * button_text = Search button text
 */


$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

$params = ( shortcode_atts( [
	'html_template' => '',
	'text_class'    => '',
	'button_class'  => '',
	'html_class'    => 'whmpress whmpress_domain_search_bulk',
	'html_id'       => '',
	'placeholder'   => whmpress_get_option( 'dsb_placeholder' ),
	'button_text'   => whmpress_get_option( 'dsb_button_text' ),


	"whois_link"           => whmpress_get_option( "dsa_whois_link" ), //"yes",
	"www_link"             => whmpress_get_option( "dsa_www_link" ), //"yes",
	"order_link_new_tab"   => whmpress_get_option( "dsa_order_link_new_tab" ), //"0",
	"show_price"           => whmpress_get_option( "dsa_show_price" ),
	"show_years"           => whmpress_get_option( "dsa_show_years" ),
	"enable_transfer_link" => whmpress_get_option( "dsa_transfer_link" ),
    "order_landing_page"=>"",

	"append_url"           => '',
    'action' => '',

], $atts ) );
extract($params);

// replacing {wp-path} placeholder with website's homepage url
$action = str_replace('{wp-path}', get_home_url(), $action);

global $wpdb;
$smarty_array=[];

$button_text = __( $button_text, "whmpress" );
$new_tab_html = '';
if ( in_array( strtolower( $order_link_new_tab ), [ 'yes', '1' ] ) ) {
	$new_tab_html = 'target="_blank"';
}
$ajaxID = uniqid("ajaxForm");
$ACTION = empty($action) ? "" : "$action";

$WHMPress = new WHMpress();

# Generating output result
$HTML = "";
//$HTML = print_r($_POST, true);
if ( isset( $_POST["search_bulk_domain"] ) ) {
	$HTML .= "<div class='result-div'>";

	$extention_selection = isset( $_POST["extention_selection"] ) ? $_POST["extention_selection"] : "0";

	if ( $extention_selection == "1" ) {
		$domains_set = isset( $_POST["search_bulk_domain"] ) ? $_POST["search_bulk_domain"] : "";
		$domains_set = explode( "\n", $domains_set );
		if ( ! isset( $_POST["extension"] ) ) {
			$extension          = [ ".com" ];
			$_POST["extension"] = [ ".com" ];
		}
		else {
			$extension = $_POST["extension"];
		}
		//$HTML .= print_r($_POST, true);
		$domains = [];

		foreach ( $extension as $ext ) {
			foreach ( $domains_set as $domain ) {
				$domains[] = $domain . $ext;
			}
		}

	}
	else {
		$domains = isset( $_POST["search_bulk_domain"] ) ? $_POST["search_bulk_domain"] : "";
		$domains = explode( "\n", $domains );
	}


	include_once( WHMP_PLUGIN_DIR . "/includes/whois.class.php" );
	$whois = new Whois;

	foreach ( $domains as $domain ) {
        if (!empty(trim($domain))){
            $dom = whmp_get_domain_clean($domain);

            $dom = preg_replace( '/_[^_]*$/', '', $dom );

            $dom["full"] = $dom["short"] . "." . $dom["ext"];

            $dom["og"] = true;

            //---Get whois info
            $whois_server = whmp_get_whois_servers($dom["ext"]);

            //---Append whois server info to domain
            $dom["info"] = $whois_server[$dom["ext"]];

            //---check availability
            $result = $whois->whoislookup_i($dom);

            //---build top result
            $__smarty = whmp_domain_search_smarty($dom, $params, $result);


            //---add to smarty domain array

            $smarty_array = array_merge($smarty_array, $__smarty);


            if ($result) {
                $ext = "." . ltrim($dom["ext"], ".");
                $Dom = $dom["full"];
                $Message = $__smarty["message"];
                $price = $__smarty["price"];

                $register_text = whmpress_get_option('register_domain_button_text');
                if ($register_text == "") {
                    $register_text = __("Select", "whmpress");
                }

                $_url = $__smarty["order_url"];

                if (!empty($price)) {
                    $button = "<a href='" . $_url . $append_url . "' class='buy-button' " . $new_tab_html . ">$register_text</a>";
                } else {
                    $button = "";
                }

                $pricef = $price;
                $year = $__smarty["duration"];
                ob_start();
                ?>
                <div class='found-div'>
                    <div class="domain-name"><?php echo $Message; ?></div>
                    <?php if (!in_array(strtolower($show_price), ['no', '0'])) { ?>
                        <div class="rate"><?php echo $pricef; ?></div>
                    <?php } ?>
                    <?php if (!in_array(strtolower($show_years), ['no', '0'])) { ?>
                        <div class="year"><?php echo $year; ?></div>
                    <?php } ?>
                    <div class="select-box">
                        <?php echo $button; ?>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <?php
                $HTML .= ob_get_clean();
            } else {

                $ext = "." . ltrim($dom["ext"], ".");
                $Dom = $domain;
                $www_link_html = "<a class=\"www-button\" href='http://{$Dom}' target='_blank'>" . __("WWW", "whmpress") . "</a>";

                $whois_link_html = "<a class='whois-button' href='" . WHMP_PLUGIN_URL . "/whois.php?domain={$Dom}' target='_blank'>" . __("WHOIS", "whmpress") . "</a>";


                // Transfer button generation
                $Q = "SELECT d.id, d.extension 'tld', t.type, c.code, c.suffix, c.prefix, t.msetupfee, t.qsetupfee
                FROM `" . whmp_get_domain_pricing_table_name() . "` AS d
                INNER JOIN `" . whmp_get_pricing_table_name() . "` AS t ON t.relid = d.id
                INNER JOIN `" . whmp_get_currencies_table_name() . "` AS c ON c.id = t.currency
                WHERE t.type
                IN (
                'domaintransfer'
                ) AND d.extension IN ('{$ext}')
                AND c.code='" . whmp_get_currency_code(whmp_get_currency()) . "' 
                ORDER BY d.id ASC 
                LIMIT 0 , 30";
                $price = $wpdb->get_row($Q, ARRAY_A);

                $register_text = whmpress_get_option('transfer_domain_button_text');
                if ($register_text == "") {
                    $register_text = __("Transfer", "whmpress");
                }
                $_url = $WHMPress->get_whmcs_url("domainchecker") . "&a=add&domain=transfer&sld={$__smarty['domain_short']}&tld={$ext}";
                if (!empty($price["msetupfee"])) {
                    $button = "<a href='" . $_url . $append_url . "' class='buy-button' " . $new_tab_html . ">$register_text</a>";
                } else {
                    $button = "";
                }

                $Message = whmpress_get_option('ongoing_domain_not_available_message');
                if ($Message == "") {
                    $Message = "[domain-name] is registered";
                }
                $Message = str_replace("[domain-name]", "<span>" . $Dom . "</span>", $Message);

                ob_start();
                ?>
                <div class='not-found-div'>
                    <div class="domain-name"><?php echo $Message; ?></div>

                    <div class="select-box">
                        <?php if (!in_array(strtolower($www_link), ['no', '0'])) {
                            echo $www_link_html;
                        }
                        if (!in_array(strtolower($whois_link), ['no', '0'])) {
                            echo $whois_link_html;
                        }
                        if (!in_array(strtolower($enable_transfer_link), ['no', '0'])) {
                            echo $button;
                        }
                        ?>
                    </div>
                </div>
                <?php
                $HTML .= ob_get_clean();
            }
        }
	}
$HTML .= "</div>";
}

$extensions        = $wpdb->get_results( "SELECT `extension` FROM `" . whmp_get_domain_pricing_table_name() . "` ORDER BY `order`" );
$exts              = "";
$smarty_extensions = [];
foreach ( $extensions as $ext ) {
	if ( isset( $_POST["extension"] ) && is_array( $_POST["extension"] ) ) {
		$checked = in_array( $ext->extension, $_POST["extension"] ) ? "checked=checked" : "";
	}
	else {
		$checked = "";
	}
	$exts                .= "<div class=\"\">
              <input type=\"checkbox\" value=\"{$ext->extension}\" id=\"{$ext->extension}\" name=\"extension[]\" $checked />
              <label for=\"{$ext->extension}\">{$ext->extension}</label>
            </div>\n";
	$smarty_extensions[] = $ext->extension;
}

$WHMPress = new WHMPress;

$html_template = $WHMPress->check_template_file( $html_template, "whmpress_domain_search_bulk" );

if ( is_file( $html_template ) ) {
	$search_bulk_domain = isset( $_POST["search_bulk_domain"] ) ? $_POST["search_bulk_domain"] : "";
	$vars               = [
		'extension_selection' => '<label><input name="extention_selection" value="0" checked="" type="radio"> ' . esc_html__( 'I entered fully qualified names', 'whmpress' ) . ' </label><br><label><input name="extention_selection" value="1" type="radio"> ' . esc_html__( 'Search these extensions', 'whmpress' ) . ' </label>',
		"search_textarea"     => '<textarea required="required" class="' . $text_class . '" placeholder="' . __( $placeholder, "whmpress" ) . '" name="search_bulk_domain">' . $search_bulk_domain . '</textarea>',
		"search_button"       => '<button class="search_btn ' . $button_class . '">' . $button_text . '</button>',
		"search_results"      => $HTML,
		"button_text"         => $button_text,
		"data_extensions"     => $smarty_extensions,
	];

	# Getting custom fields and adding in output
	$TemplateArray = $WHMPress->get_template_array( "whmpress_domain_search_bulk" );
	foreach ( $TemplateArray as $custom_field ) {
		$vars[ $custom_field ] = isset( $atts[ $custom_field ] ) ? $atts[ $custom_field ] : "";
	}

	$OutputString = whmp_smarty_template( $html_template, $vars );

	return $OutputString;
}
else {
	//$str = '<form method="post">'."\n";
	$search_bulk_domain = isset( $_POST["search_bulk_domain"] ) ? $_POST["search_bulk_domain"] : "";
	//$str .= '<textarea required="required" class="'.$text_class.'" placeholder="'.$placeholder.'" name="search_bulk_domain">'.$search_bulk_domain.'</textarea>'."\n";

	if ( isset( $_POST["extention_selection"] ) && $_POST["extention_selection"] == "1" ) {
		$display = "";
	}
	else {
		$display = "none";
	}
	if ( ! isset( $_POST["extention_selection"] ) || ( isset( $_POST["extention_selection"] ) && $_POST["extention_selection"] == "0" ) ) {
		$checked1 = "checked";
	}
	else {
		$checked1 = "";
	}

	if ( isset( $_POST["extention_selection"] ) && $_POST["extention_selection"] == "1" ) {
		$checked2 = "checked";
	}
	else {
		$checked2 = "";
	}

	$ientered    = __( "I entered fully qualified names", "whmpress" );
	$sthext      = __( "Search these extentions", "whmpress" );
	$placeholder = __( $placeholder, "whmpress" );
	$str         = <<<EOT
    <div>
    <form method="post" action="$ACTION">
        <div class="bulk-domains">
            <textarea required="required" class="$text_class" placeholder="$placeholder" name="search_bulk_domain">$search_bulk_domain</textarea>
        </div>
        <div class="bulk-options">
            <div class="extention-selection">
                <label><input type="radio" name="extention_selection" value="0" $checked1> $ientered</label><br>
                <label><input type="radio" name="extention_selection" value="1" $checked2> $sthext</label>
            </div>
            <div class="extentions" style="display:$display">
                $exts
            </div>
            <div style="clear:both"></div>
            <div class="search-button">
                <button class="search_btn $button_class">$button_text</button>
            </div>
        </div>
    </form>
    </div>
    <div style="clear:both"></div>
EOT;

	# Returning output form
	$ID    = ! empty( $html_id ) ? "id='$html_id'" : "";
	$CLASS = ! empty( $html_class ) ? "class='$html_class'" : "";

	return "<!-- WHMPress -->\n<div $CLASS $ID>" . $str . $HTML . "</div><!-- End WHMPress -->";
}