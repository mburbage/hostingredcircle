<?php

$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

extract( shortcode_atts( [
    'html_template' => '',
    'image'         => '',
    'html_id'       => '',
    'html_class'    => 'whmpress whmpress_description',
    'id'            => '0',
    'show_as'       => whmpress_get_option( 'dsc_description' ),
    'no_wrapper'    => "No",
    'with_section'    => "No",
    'split_description'    => "No",
], $atts ) );

# Getting data from mysql tables
global $wpdb;
$WHMPress = new WHMPress;

$field = "whmpress_product_" . $id . "_desc_" . $WHMPress->get_current_language();
$field2 = "whmpress_product_" . $id . "_append_desc_" . $WHMPress->get_current_language();
$v     = get_option( $field );
if ( empty( $v ) ) {
    $Q            = "SELECT `description` FROM `" . whmp_get_products_table_name() . "` WHERE `id`=$id";
    $ndescription = $description = $wpdb->get_var( $Q ) . "\r\n" . get_option( $field2 );
} else {
    $ndescription = $description = get_option( $field ) . "\r\n" . get_option( $field2 );
}




$ndescription = trim( strip_tags( $ndescription, '<strong><s><del><strike>' ), "\n" );
$ndescription = explode( "\n", $ndescription );
$section_index = 0;
$description_section_index = 0;
$description_section = [];

foreach ($ndescription as $line) {
    if (strpos($line, "--") !== false && strpos($line, "--", 3) == true) {
        $description_section_index = $section_index;
        $section = str_replace("--", "", $line);
        $group_para["section"][$section_index] = $section;
        $section_index++;
    } else {
        $strpos = strpos($line, ":");
        $feature = substr($line, 0, $strpos);
        $value = trim(substr($line, $strpos + 1));

        $plan["description_section"][$description_section_index][$feature] = [
            "feature" => $feature,
            "value" => $value,
        ];

    }
}

if (isset($group_para)) {
    $all_array = array_merge($ndescription, $group_para, $plan);
    $x = 0;
    $section = '';
    $group = $all_array;
    $dec_array = $ndescription;
    $section_features = [];


    ## if description is not extis
    if (strtolower(trim($group['section'][0])) != "description") {
        array_unshift($group["section"], "");
        array_unshift($group['description_section'], []);
    }

    ## if Highlights is not extis
    if (strtolower(trim($group['section'][1])) != "highlights") {
        array_unshift($group["section"], "");
        array_unshift($group['description_section'], []);
    }

    foreach ($group["section"] as $title) {
        $section_title = $title . "\n";

        $features_set = false;
        $section_values = '';

        foreach ($group["description_section"] as $plan) {

            if ($features_set == false) {
                $value = whmpress_feature_row_html($group['description_section'][$x]);
                array_push($section_features, $value);
                $features_set = true;
            }
        }


        $section .= $section_title;
        $x++;
    }
    $call_back_func = true;
}
if(isset($call_back_func)){
    return $section_features;
}else{
    $smarty_array = [];
    foreach ( $ndescription as $line ) {
        if ( trim( $line ) <> "" ) {
            $data                  = [];
            $data["feature"]       = $line;
            $totay                 = explode( ":", $line );

            $tooltip_data = $WHMPress->return_tooltip(trim( $totay[0]));
            $data["feature_title"] = trim( $totay[0] );
            $data["feature_value"] = isset( $totay[1] ) ? trim( $totay[1] ) : "";
            $data["tooltip_text"] = stripcslashes($tooltip_data['tooltip_text']);
            $data["icon_class"] = $tooltip_data['icon_class'];
            $smarty_array[] = $data;
        }
    }

    return $smarty_array;
}
