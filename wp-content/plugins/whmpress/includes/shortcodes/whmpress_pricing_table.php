<?php


if (is_file(WHMP_PLUGIN_DIR . "/templates/whmpress.css")) {
    wp_enqueue_style('whmpress-temp-style', WHMP_PLUGIN_URL . '/templates/whmpress.css');
}

// If WHMPress settings -> Styles -> include FontAwesome selected Yes
if (get_option('include_fontawesome') == "1") {
    wp_enqueue_style('font-awesome-script', "//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css");
}

$last_synced = get_option( "sync_time" );
$site_url    = get_site_url();
if ( $last_synced == "" ) {
	echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
	echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

extract( shortcode_atts( [
	'html_template'            => '',
	'image'                    => '',
	'id'                       => '0',
	'html_class'               => 'whmpress whmpress_pricing_table',
	'html_id'                  => '',
	'billingcycle'             => whmpress_get_option( "pt_billingcycle" ),
	'show_price'               => whmpress_get_option( "pt_show_price" ), //'Yes',
	'process_description'      => whmpress_get_option( "pt_process_description" ), //'Yes',
	'show_description_icon'    => whmpress_get_option( "pt_show_description_icon" ), //'Yes',
	'show_description_tooltip' => whmpress_get_option( "pt_show_description_tooltip" ), //'Yes',
	'show_combo'               => whmpress_get_option( "pt_show_combo" ), //'No',
	'show_button'              => whmpress_get_option( "pt_show_button" ), //'Yes',
	"show_discount"            => whmpress_get_option( "combo_show_discount" ),
	'discount_type'            => whmpress_get_option( 'combo_discount_type' ),
	'primary_color'            => '',
	'secondary_color'          => '',
	'convert_monthly'          => '',
	'explain_convert_monthly'  => '',
	'currency'                 => '0',
	'override_order_url'       => '',
	'override_order_combo_url' => '',
	'append_order_url'         => '',

	"button_text"  => whmpress_get_option( "pt_button_text" ), //"Order",
	"button_class" => "whmpress whmpress_order_button",
], $atts ) );

if ( $primary_color == '#000000' && $secondary_color == '#000000' ) {
	$primary_color   = '';
	$secondary_color = '';
}

if ( ! whmp_is_valid_color( $primary_color ) ) {
	$primary_color = '';
}
if ( ! whmp_is_valid_color( $secondary_color ) ) {
	$secondary_color = '';
}
$random_id   = 'whmp_table_' . rand( 10000, 99999 );
$button_text = __( $button_text, "whmpress" );


if ( empty( $currency ) ) {

	$currency = whmp_get_current_currency_id_i();

	/*if ( ! session_id() ) {
	    $cacheValue = get_option('whmpress_session_cache_limiter_value');
        session_cache_limiter($cacheValue);
		session_start();
	}
	if ( isset( $_SESSION["whcom_currency"] ) ) {
		$currency = $_SESSION["whcom_currency"];

	}
	if ( empty( $currency ) ) {
		$currency = whmp_get_default_currency_id();
	}*/
}

# Checking parameters
#$html_class = !empty($atts["html_class"])?$atts["html_class"]:""; if ($html_class=="") $html_class = "whmpress whmpress_price_box";
#$html_id = !empty($atts["html_id"])?$atts["html_id"]:"";
#$id = !empty($atts["id"])?$atts["id"]:"0";
#$billingcycle = !empty($atts["billingcycle"])?$atts["billingcycle"]:whmpress_get_option("billingcycle");
#$show_price = !empty($atts["show_price"])?$atts["show_price"]:"Yes";
#$show_combo = !empty($atts["show_combo"])?$atts["show_combo"]:"No";
#$show_button = !empty($atts["show_button"])?$atts["show_button"]:"Yes";

# Getting data from MySQL
//global $wpdb;
/*$Q = "SELECT `name`,`description` FROM `".whmp_get_products_table_name()."` WHERE `id`=$id";
$row = $wpdb->get_row($Q,ARRAY_A);
if (isset($row["name"])) $row["name"] = whmpress_encoding($row["name"]);*/

$product_found = false;
global $wpdb;
$Q   = "SELECT * FROM `" . whmp_get_products_table_name() . "` WHERE `id`=$id";
$row = $wpdb->get_row( $Q, ARRAY_A );
if ( ! empty( $row ) ) {
	$product_found = true;
}

if ( $product_found ) {

	$row["name"]       = whmpress_name_function( [ "no_wrapper" => "1", "id" => $id ] );
	$description       = $row["description"] = whmpress_description_function(
		[
			"id" => $id,
		]
	);
	$description_split = $row["description"] = whmpress_description_function(
		[
			"id"                => $id,
			"split_description" => 'yes',
		]
	);


	$tag_line = $row["tag_line"] = whmpress_cdescription_function(
		[
			"id" => $id,
		]
	);

//------- new functions test start

	$tmp1     = whmp_price_i(
		[
			'id'           => $id,
			'currency_id'  => $currency,
			'billingcycle' => $billingcycle,
			'sudo_monthly' => $convert_monthly,
		]
	);
	$tmpprice = 0;


	if ( $convert_monthly == 'yes' ) {
		$price_tmp = $tmp1['sudo_price'];
	}
	else {
		$price_tmp = $tmp1['price'];
	}



	$tmp2 = whmp_format_price_i(
		[
			'price'       => $price_tmp,
			'paytype'     => $tmp1['paytype'],
			'currency_id' => $currency,
			'decimals'    => whmpress_get_option( 'default_decimal_places' )
		]
	);

	// get duration style from whmpress settings

	$price = whmp_format_price_essentials_specific(
		[
			'price'              => $tmp2,
			'paytype'            => $tmp1['paytype'],
			'billingcycle'       => $billingcycle,
			'duration_connector' => whmpress_get_option( "default_currency_duration_connector" ),
			'duration_style'     => whmpress_get_option( "default_currency_duration_style" ),
			'currency_id'        => $currency,
			'no_of_months'       => $convert_monthly,
		]
	);

//------- new functions test END

	$order_url = whmpress_order_url_function(
		[
			"id"           => $id,
			"billingcycle" => $billingcycle,
			"currency"     => $currency,
		]
	);

	$order_url .= ltrim( $append_order_url, "&" );


	if ( strtolower( $show_combo ) == "yes" && $tmp1['paytype'] == 'recurring' ) {
		# Getting combo
		$combo       = whmpress_order_combo_function(
			[
				"id"                       => $id,
				"show_button"              => "Yes",
				"currency"                 => $currency,
				"discount_type"            => $discount_type,
				"button_text"              => $button_text,
				"button_class"             => $button_class,
				"params"                   => ltrim( $append_order_url, "&" ),
				"override_order_combo_url" => $override_order_combo_url,
			]
		);
		$show_button = "No";
	}
	else {
		$combo = "";
	}
	if ( trim( $override_order_url ) != "" ) {
		//$button="<a class=".$button_class. " href=".$override_order_url.">".$button_text."</a>";
		$button = "<a class=\"{$button_class}\" href=\"{$override_order_url}\">{$button_text}</a>";
		//== set override_order_url with currency and product id
        $directed_order_url = $override_order_url . '?currency=' . $currency . '&id=' . $id;
        $button_with_parameters = "<a class=\"{$button_class}\" href=\"{$directed_order_url}\">{$button_text}</a>";
	}
	else {
		if ( strtolower( $show_button ) == "yes" ) {
			# Getting button
			$button = whmpress_order_button_function( [
				"id"           => $id,
				"button_text"  => $button_text,
				"billingcycle" => $billingcycle,
				"currency"     => $currency,
				"params"       => ltrim( $append_order_url, "&" ),


			] );
		}
		else {
			$button = "";
		}
        $button_with_parameters = "";
	}




# Check if template file exists in theme folder
	$WHMPress = new WHMPress;

	//== Get all prices of selected product
    $all_prices = $WHMPress -> get_all_prices(
            [
                'currency' => $currency,
                'product_id' =>  $id,
                'prefix_required' => 'no',
            ]
    );

    //== Get actual price without setup price and without converted to monthly
    $price_without_converted_to_monthly = $all_prices[$billingcycle]['package'] - $all_prices[$billingcycle]['setup'];

    //== Get discount according to billingcycle
    $get_discount = $WHMPress -> whmpress_price_discount($billingcycle,$all_prices);

    //== Get all tooltips
    $all_tooltips = $WHMPress -> return_all_tooltip();

    //== Get free domain price
    $free_domain_price = whmp_domain_price_i( [
        "extension"   => '.com',
        "price_type"  => 'domainregister',
        "years"        => '1',
        "currency"    => $currency,
        "process_tax" => "1",
    ] );


	$html_template = $WHMPress->check_template_file( $html_template, "whmpress_pricing_table" );

	if ( is_file( $html_template ) ) {

		$button_text = whmpress_encoding( $button_text );

		$vars = [
			"product_name"             => $row["name"],
			"product_price"            => $price['price'],
			"product_description"      => $description,
			"split_description"        => $description_split,
			"process_description"      => $process_description,
			"show_description_icon"    => $show_description_icon,
			"show_description_tooltip" => $show_description_tooltip,
			"product_tag_line"         => $tag_line,
			"product_order_combo"      => $combo,
			"product_order_button"     => $button,
            "order_button_with_parameters" => $button_with_parameters,
			"order_button_text"        => $button_text,
			"image"                    => $image,
			"prefix"                   => $price['prefix'],
			"suffix"                   => $price['suffix'],
			"amount"                   => $tmp2['amount'],
			"fraction"                 => $tmp2['fraction'],
			"duration"                 => $price['duration'],
			"duration_style_2"         => $price['duration'],
			"decimal"                  => $tmp2['decimal_separator'],
			"primary_color"            => $primary_color,
			"secondary_color"          => $secondary_color,
			"random_id"                => $random_id,
			"order_url"                => $order_url,
			"button_text"              => $button_text,
			"config_option_string"     => whmpress_get_option( "config_option_string" ),
			"paytype"                  => $tmp1['paytype'],
			"price_sub_text"           => $tmp1['sudo_price_reason'],
            "product_discount"         => $get_discount["percentage_discount"],
            "product_price_without_conversion" => $price_without_converted_to_monthly,
            "total_price_according_month" => $get_discount['actual_price_according_monthly'],
            "free_domain_price" => $free_domain_price,
            "all_tooltips_data" => $all_tooltips
		];

		# Getting custom fields and adding in output
		$TemplateArray = $WHMPress->get_template_array( "whmpress_pricing_table" );

		foreach ( $TemplateArray as $custom_field ) {
			$vars[ $custom_field ] = isset( $atts[ $custom_field ] ) ? $atts[ $custom_field ] : "";
		}

		$OutputString = whmp_smarty_template( $html_template, $vars );

		return $OutputString;
	}
	else {

		# Generating OutputString
		$OutputString = "<h3>" . $row["name"] . "</h3>";
		if ( $tag_line != '' ) {
			$OutputString .= '<div class="pricing_table_detail"><div class="holder">' . $tag_line . '</div></div>';
		}
		$OutputString .= $description;


//	# Check if price is requested or not

		if ( strtolower( $show_price ) == "yes" ) {
			$OutputString .= "<h4>" . $price['price'] . "</h4>";
		}

		# Check if combo is requested or not
		if ( strtolower( $show_combo ) == "yes" ) {
			$OutputString .= $combo;
		}

		# Check if button is requested or not
		if ( strtolower( $show_button ) == "yes" ) {
			$OutputString .= $button;
		}

		# Returning output string with wrapper div
		$ID    = ! empty( $html_id ) ? "id='$html_id'" : "";
		$CLASS = ! empty( $html_class ) ? "class='$html_class'" : "";

		return "<div $CLASS $ID>" . $OutputString . "</div>";
	}
}
else {
	ob_start(); ?>
	<div>
		<?php esc_html_e( 'Invalid Product ID Provided', 'whmpress' ) ?>
	</div>

	<?php return ob_get_clean();
}
