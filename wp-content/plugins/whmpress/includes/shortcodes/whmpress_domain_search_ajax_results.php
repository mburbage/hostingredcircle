<?php
/**
 * Displays whois search result submitted by whmpress_whois_search form
 *
 * List of parameters
 * searchonly = * for all domain or get result only for specific extensions comma seperated
 * html_class = HTML class for wrapper
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
	'searchonly'              => '*',
	'html_class'              => 'whmpress whmpress_domain_search_ajax_results',
	'html_id'                 => '',
	'style'                   => '',
	"whois_link"              => whmpress_get_option( "dsar_whois_link" ), // "yes",
	"www_link"                => whmpress_get_option( "dsar_www_link" ), //"yes",
	"disable_domain_spinning" => whmpress_get_option( "dsar_disable_domain_spinning" ),
	"order_landing_page"      => whmpress_get_option( "dsar_order_landing_page" ),
	"order_link_new_tab"      => whmpress_get_option( "dsar_order_link_new_tab" ),
	"show_years"              => whmpress_get_option( "dsar_show_years" ),
	"show_price"              => whmpress_get_option( "dsar_show_years" ),
	"search_extensions"       => whmpress_get_option( "dsa_search_extensions" ),
	"enable_transfer_link"    => whmpress_get_option( "dsa_enable_transfer_link" ),
	"target_div"              => "#search_result_div",
], $atts );
extract( $params );

$WHMPress = new WHMPress;

# Checking for parameters
$the_lang = "";
$SD       = isset( $_GET["search_domain"] ) ? $_GET["search_domain"] : "";
if ( $SD == "" ) {
	$SD = isset( $_GET["domain"] ) ? $_GET["domain"] : "";
}
$ajax_id = trim($target_div, "#");
$JavaCodes = "<script>jQuery(function(){
        /*jQuery.post(WHMPAjax.ajaxurl, {'params':" . whmpress_json_encode( $params ) . ",'show_price':'$show_price','show_years':'$show_years','order_landing_page':'$order_landing_page','order_link_new_tab':'$order_link_new_tab','disable_domain_spinning':'$disable_domain_spinning','search_domain':'{$SD}','domain':jQuery('#search_box').val(),'action':'whmpress_action','www_link':'$www_link','whois_link':'$whois_link','do':'getDomainData','searchonly':'{$searchonly}','skip_extra':'$search_extensions','page':'1','lang':'" . $the_lang . "'}, function(data){
            jQuery(\"$target_div\").html(data);
        });*/
        //alert (\"" . $WHMPress->get_current_language() . "\");
        jQuery(document).on('click', \"#load-more-div button\", function () {
            jQuery(\"#load-more-div\").remove();
            jQuery(\"$target_div\").append('<div id=\"waiting_div\" style=\"font-size:30px;text-align: center;\"><i class=\"fa fa-spinner fa-spin whmp_domain_search_ajax_results_spinner\"></i></div>');
            whmp_page++;
            
            var form_id = '#form{$ajax_id}';
            if ( jQuery( form_id ).length == 0 ) {
               form_id = form_id.substring(0, form_id.length - 1);
            }
            var dom = jQuery(form_id).find('input[type=search]').val();
            
            jQuery.post(WHMPAjax.ajaxurl, {'domain':dom,'params':" . whmpress_json_encode( $params ) . ",'style':'$style','show_price':'$show_price','show_years':'$show_years','order_landing_page':'$order_landing_page','order_link_new_tab':'$order_link_new_tab','disable_domain_spinning':'$disable_domain_spinning','action':'whmpress_action','do':'loadWhoisPage','www_link':'$www_link','whois_link':'$whois_link','skip_extra':'$search_extensions','page':whmp_page,'searchonly':'{$searchonly}','lang':'" . $the_lang . "'}, function(data){
                jQuery(\"#waiting_div\").remove();
                jQuery(\".result-div\").append(data);
            });
        });
    });
    </script>\n";

$html_template = $WHMPress->check_template_file( $html_template, "whmpress_domain_search_ajax_results" );

## Instructions create a div in html template file with id search_result_div
if ( is_file( $html_template ) ) {
	$vars = [
	];
	
	# Getting custom fields and adding in output
	$TemplateArray = $WHMPress->get_template_array( "whmpress_domain_search_ajax_results" );
	foreach ( $TemplateArray as $custom_field ) {
		$vars[ $custom_field ] = isset( $atts[ $custom_field ] ) ? $atts[ $custom_field ] : "";
	}
	
	$OutputString = whmp_smarty_template( $html_template, $vars );
	
	return $JavaCodes . "\n\n" . $OutputString;

} else {
	if ( isset( $_REQUEST["search_domain"]  ) ) {
		$str = "";
		/*$str .= '<div style="clear:both"></div><div id="search_result_div">'."\n";
		$str .= '<div style="font-size:30px;text-align: center;">'."\n";
		$str .= '<i class="fa fa-spinner fa-spin"></i>'."\n";
		$str .= "</div>\n";
		$str .= "</div>\n";*/
		
		if ( isset( $_GET["ext"] ) ) {
			$_REQUEST["search_domain"] .= $_GET["ext"];
		}
		
	} else {
		$str = "";
	}
	
	$str .= $JavaCodes;
	
	$ID    = ! empty( $html_id ) ? "id='$html_id'" : "";
	$CLASS = ! empty( $html_class ) ? "class='$html_class'" : "";

	
	return "<div $CLASS $ID>" . $str . "</div>";
}