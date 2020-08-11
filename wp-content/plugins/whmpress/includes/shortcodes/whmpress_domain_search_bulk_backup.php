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

$params = shortcode_atts( [
	'html_template'           => '',
	'image'                   => '',
	'text_class'              => '',
	'button_class'            => '',
	'action'                  => '',
	'style'                   => '',
	'html_class'              => 'whmpress whmpress_domain_search_ajax',
	'html_id'                 => '',
	'placeholder'             => whmpress_get_option( "dsa_placeholder" ),  // "Search"
	'button_text'             => whmpress_get_option( "dsa_button_text" ), //'Search',
	"whois_link"              => whmpress_get_option( "dsa_whois_link" ), //"yes",
	"www_link"                => whmpress_get_option( "dsa_www_link" ), //"yes",
	"www_text"                => whmpress_get_option( "dsa_www_text", __( 'WWW', 'whmpress' ) ), //"yes",
	"whois_text"              => whmpress_get_option( "dsa_whois_text", __( 'WhoIs', 'whmpress' ) ), //"yes",
	"disable_domain_spinning" => whmpress_get_option( "dsa_disable_domain_spinning" ), //"0",
	"order_landing_page"      => whmpress_get_option( "dsa_order_landing_page" ), //"0",
	"order_link_new_tab"      => whmpress_get_option( "dsa_order_link_new_tab" ), //"0",
	"show_price"              => whmpress_get_option( "dsa_show_price" ),
	"show_years"              => whmpress_get_option( "dsa_show_years" ),
	"search_extensions"       => whmpress_get_option( "dsa_search_extensions" ),
	"enable_transfer_link"    => whmpress_get_option( "dsa_transfer_link" ),
	"append_url"              => ''
], $atts );
extract( $params );

$params['register_text'] = $params['button_text'];
$params['transfer_text'] = $params['button_text'];

global $wpdb;
$button_text = __( $button_text, "whmpress" );

$WHMPress = new WHMpress();

$ajaxID = uniqid( "ajaxForm" );
$loading_text = __( "Loading", "whmpress" );
$the_lang = '';
$htmlID = "#{$ajaxID}2";



# Generating output result
$HTML = "";
if ( isset( $_POST["search_bulk_domain"] ) ) {

	$HTML .= "<div class='result-div'>";

	ob_start();
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

	global $wpdb;
	$result_a = [];
	?>
    <script>
		function openWhois( a ) {
			window.open( a, "whmpwin", "width=600,height=600,toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=0" );
		}
    </script>
	<?php
	foreach ( $domains as $domain ) {
		if ( trim( $domain ) <> "" ) {
			$domain = whmp_get_domain_clean( $domain );
			if ( $domain["ext"] == "" ) {
				$domain["ext"]  = ".com";
				$domain["full"] = $domain["short"] . $domain["ext"];
			}
			//$message = whmp_get_domain_message($message);
			$result       = $whois->whoislookup( $domain["full"], $domain["ext"] );
			$domain["og"] = false;


			$result_a = whmp_domain_search_smarty( $domain, $params, $result );

		}
		?>

        <!-- Render Output -->

        <ul class="whmp_search_ajax_result">
            <li class="whmp_icon"><i class="fa fa-2x fa"></i>

            </li>
            <li class="whmp_domain"><strong>  <?php
					if ( $result == 1 ) {
						echo $result_a['domain'];
					}
					?> </strong><?php echo $result_a['message'] ?></li>

            <li class="whmp_domain_price"><span> <?php echo $result_a['price'] ?> </span></li>

            <li class="whmp_domain_price"><span> <?php echo $result_a['duration'] ?> </span></li>

            <li class="whmp_search_ajax_buttons">
				<?php
				if ( $result_a["available"] == '1' ) {
					if ( $result_a["order_button_text"] != "" ) {
						?>
                        <a class="" href="<?php $result_a['order_url'] ?>"><i
                                    class="fa fa-cart-plus"></i><?php echo $result_a['order_button_text'] ?></a>
						<?php
					}
				}
				else { ?>
                    <a class=""
                       href="<?php $domain['order_url'] ?>" <?php //$domain['button_action'] ?>> <?php echo $params['transfer_text'] ?> </a>

					<?php $result_a['hidden_form'];
				}
				if ( strtolower( $params["www_link"] ) != "no" ) { ?>
                    <a class="" target="_blank" href="http://<?php $domain['domain'] ?>"><?php {
							$params['www_text'];
						} ?></a>
				<?php }
				if ( strtolower( $params["whois_link"] ) != "no" ) { ?>
                    <a class="whois-btn"
                       onclick="openWhois( <?php $domain['whois_link'] ?>)"><?php $params['whois_text'] ?></a>
				<?php } ?>
            </li>


        </ul>

		<?php
	}


	$HTML .= ob_get_clean();
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
		"search_textarea" => '<textarea required="required" class="' . $text_class . '" placeholder="' . __( $placeholder, "whmpress" ) . '" name="search_bulk_domain">' . rtrim( $search_bulk_domain ) . '</textarea>',
		"search_button"   => '<button class="search_btn ' . $button_class . '">' . $button_text . '</button>',
		"search_results"  => rtrim( $HTML ),
		"button_text"     => $button_text,
		"data_extensions" => $smarty_extensions,
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
	ob_start(); ?>
    <script>
		jQuery( document ).ready( function () {
			jQuery( 'input:radio[name="extention_selection"]' ).change( function () {
				if ( jQuery( this ).val() == '0' ) {
					jQuery( '.extentions' ).css( 'display', 'none' );
				}
				else {
					jQuery( '.extentions' ).css( 'display', 'block' );
				}
			} );
		} );

		function Search<?php echo $ajaxID; ?> ( form ) {
			whmp_page = 1;
			jQuery( '<?php echo $htmlID; ?>' ).html("<div class='whmp_loading_div'><i class='fa fa-spinner fa-spin whmp_domain_search_ajax_results_spinner'></i> <?php echo $loading_text; ?></div>");
			jQuery.post( WHMPAjax.ajaxurl, {
				'params': " . whmpress_json_encode( $params ) . ",
				'style': '$style',
				'show_price': '$show_price',
				'show_years': '$show_years',
				'order_landing_page': '$order_landing_page',
				'order_link_new_tab': '$order_link_new_tab',
				'disable_domain_spinning': '$disable_domain_spinning',
				'domain': jQuery( '#form<?php echo $ajaxID; ?> input[type=search]' ).val(),
				'action': 'whmpress_action',
				'do': 'getDomainData',
				'www_link': '<?php echo $www_link; ?>',
				'whois_link': '<?php echo $whois_link; ?>',
				'enable_transfer_link': '<?php echo $enable_transfer_link; ?>',
				'searchonly': '*',
				'skip_extra': '<?php echo $search_extensions; ?>',
				'page': '1',
				'lang': '<?php echo $the_lang; ?>'
			}, function ( data ) {
				console.log(data);
				jQuery( '<?php echo $htmlID; ?>' ).html( data );
			} );
			return false;
		}
    </script>
    <div class="whmpress_domain_search_bulk">
        <form method="post" onsubmit='return Search<?php echo $ajaxID;?>(this)'>
            <div class="bulk-domains">
                <textarea required="required" class="<?php echo $text_class; ?>"
                          placeholder="<?php echo $placeholder; ?>"
                          name="search_bulk_domain"><?php echo rtrim( $search_bulk_domain ) ?></textarea>
            </div>
            <div class="bulk-options">
                <div class="extention-selection">
                    <label><input type="radio" name="extention_selection"
                                  value="0" <?php echo $checked1 ?>> <?php echo $ientered ?></label><br>
                    <label><input type="radio" name="extention_selection"
                                  value="1" <?php echo $checked2 ?>> <?php echo $sthext ?></label>
                </div>
                <div class="extentions" style="display: <?php echo $display; ?>;">
					<?php echo $exts ?>
                </div>
                <div style="clear:both"></div>
                <div class="search-button">
                    <button class="search_btn $button_class"><?php echo $button_text; ?></button>
                </div>
            </div>
        </form>
    </div>
    <div style="clear:both"></div>
	<?php
	$str = ob_get_clean();

	# Returning output form
	$ID    = ! empty( $html_id ) ? "id='$html_id'" : "";
	$CLASS = ! empty( $html_class ) ? "class='$html_class'" : "";

	return "<!-- WHMPress -->\n<div $CLASS $ID>" . rtrim( $str ) . $HTML . "</div><!-- End WHMPress -->";
}