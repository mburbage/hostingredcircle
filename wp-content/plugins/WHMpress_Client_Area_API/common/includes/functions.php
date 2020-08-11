<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

/**====================================================================**/
/**==       General Functions                                        ==**/
/**====================================================================**/
if ( ! function_exists( 'whcom_ppa' ) ) {
    function whcom_ppa( $var, $text = '' ) {
        $text = ( ! empty( $text ) ) ? (string) $text . ': ' : '';
        echo "<pre>" . $text . print_r( $var, true ) . "</pre>";

        return;
    }
}
if ( ! function_exists( 'whcom_is_json' ) ) {
    function whcom_is_json( $string ) {
        if ( is_numeric( $string ) ) {
            return false;
        }
        if ( is_bool( $string ) ) {
            return false;
        }
        if ( is_null( $string ) ) {
            return false;
        }
        if ( ! is_string( $string ) ) {
            return false;
        }
        if ( $string == "" || $string == " " ) {
            return false;
        }
        @json_decode( $string );

        return ( json_last_error() == JSON_ERROR_NONE );
    }
}
if ( ! function_exists( 'whcom_get_current_language' ) ) {
    function whcom_get_current_language($poly_lang_active_flag = false) {
        if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
            if($poly_lang_active_flag == true) {
                $Lang = [
                    "ar" => "Arabic",
                    "az" => "Azerbaijani",
                    "ca" => "Catalan",
                    "hr" => "Croatian",
                    "cs" => "Czech",
                    "da" => "Danish",
                    "de" => "German",
                    "en" => "English",
                    "fa" => "Farsi",
                    "fr" => "French",
                    "hu" => "Hungarian",
                    "it" => "Italian",
                    "nb" => "Norwegian",
                    "pt" => "Portuguese-pt",
                    "ru" => "Russian",
                    "es" => "Spanish",
                    "sv" => "Swedish",
                    "tr" => "Turkish",
                    "nl" => "Dutch",
                ];
                if (array_key_exists(ICL_LANGUAGE_CODE, $Lang)) {
                    return $Lang[ICL_LANGUAGE_CODE];
                } else {
                    return 'English';
                }
            }else {
                return ICL_LANGUAGE_CODE;
            }
        }
        elseif ( function_exists( 'pll_current_language' ) ) {
            return pll_current_language();
        }
        elseif ( ! empty( $_REQUEST["lang"] ) ) {
            return $_REQUEST["lang"];
        }
        else {
            return get_locale();
        }
    }
}
if ( ! function_exists( 'whcom_get_whmcs_relevant_language' ) ) {
    function whcom_get_whmcs_relevant_language () {
        $Lang = [
            "ar"    => "Arabic",
            "az"    => "Azerbaijani",
            "ca"    => "Catalan",
            "hr"    => "Croatian",
            "cs_CZ" => "Czech",
            "da_DK" => "Danish",
            "de_DE" => "German",
            "en_US" => "English",
            "en_AU" => "English",
            "en_GB" => "English",
            "en"    => "English",
            "fa_IR" => "Farsi",
            "fr_FR" => "French",
            "de_CH" => "German",
            "hu_HU" => "Hungarian",
            "it_IT" => "Italian",
            "nb_NO" => "Norwegian",
            "pt_BR" => "Portuguese-br",
            "pt_PT" => "Portuguese-pt",
            "ru_RU" => "Russian",
            "es_ES" => "Spanish",
            "sv_SE" => "Swedish",
            "tr_TR" => "Turkish",
            "nl_NL" => "Dutch",
        ];
        $curr_lang = whcom_get_current_language();
        if (array_key_exists($curr_lang,$Lang)) {
            return $Lang[$curr_lang];
        }
        else {
            return 'English';
        }
    }
}
if ( ! function_exists( 'whcom_get_user_ip' ) ) {
    function whcom_get_user_ip() {
        foreach (
            [
                'HTTP_CLIENT_IP',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_X_CLUSTER_CLIENT_IP',
                'HTTP_FORWARDED_FOR',
                'HTTP_FORWARDED',
                'REMOTE_ADDR',
            ] as $key
        ) {
            if ( array_key_exists( $key, $_SERVER ) === true ) {
                foreach ( explode( ',', $_SERVER[ $key ] ) as $ip ) {
                    if ( filter_var( $ip, FILTER_VALIDATE_IP ) !== false ) {
                        return $ip;
                    }
                }
            }
        }

        return "";
    }
}
if ( ! function_exists( 'whcom_convert_billingcycle' ) ) {
    function whcom_convert_billingcycle( $args ) {
        $return_string        = '';
        $valid_billing_cycles = [
            "monthly",
            "quarterly",
            "semiannually",
            "annually",
            "biennially",
            "triennially",
            "onetime",
            "free",
            "setup",
        ];
        if ( ! is_array( $args ) ) {
            $args = [
                'billingcycle' => (string) $args
            ];
        }
        $default = [
            'billingcycle' => 'monthly',
            'style'        => 'duration',
        ];
        $args    = wp_parse_args( $args, $default );
        if ( in_array( strtolower( $args['billingcycle'] ), $valid_billing_cycles ) ) {
            $styles = [
                "monthly" => [
                    "months"    => 1,
                    "duration"  => esc_html__( "Monthly", "whcom" ),
                    "duration2" => esc_html__( "1 month", "whcom" ),
                    "long"      => esc_html__( "Month", "whcom" ),
                    "short"     => esc_html__( "mo", "whcom" ),
                    "monthly"   => esc_html__( "1 Month", "whcom" ),
                ],

                "setup" => [
                    "months"    => 1,
                    "duration"  => esc_html__( "Setup", "whcom" ),
                    "duration2" => esc_html__( "Setup", "whcom" ),
                    "long"      => esc_html__( "Setup", "whcom" ),
                    "short"     => esc_html__( "Setup", "whcom" ),
                    "monthly"   => esc_html__( "Setup", "whcom" ),
                ],

                "quarterly" => [
                    "months"    => 3,
                    "duration"  => esc_html__( "Quarterly", "whcom" ),
                    "duration2" => esc_html__( "3 month", "whcom" ),
                    "long"      => esc_html__( "Quarter", "whcom" ),
                    "short"     => esc_html__( "qu", "whcom" ),
                    "monthly"   => esc_html__( "3 Months", "whcom" ),
                ],

                "semiannually" => [
                    "months"    => 6,
                    "duration"  => esc_html__( "Semi Annually", "whcom" ),
                    "duration2" => esc_html__( "6 month", "whcom" ),
                    "long"      => esc_html__( "Half year", "whcom" ),
                    "short"     => esc_html__( "sa", "whcom" ),
                    "monthly"   => esc_html__( "6 Months", "whcom" ),
                ],

                "annually" => [
                    "months"    => 12,
                    "duration"  => esc_html__( "Annually", "whcom" ),
                    "duration2" => esc_html__( "1 year", "whcom" ),
                    "long"      => esc_html__( "Year", "whcom" ),
                    "short"     => esc_html__( "yr", "whcom" ),
                    "monthly"   => esc_html__( "12 Months", "whcom" ),
                ],

                "biennially" => [
                    "months"    => 24,
                    "duration"  => esc_html__( "Biennially", "whcom" ),
                    "duration2" => esc_html__( "2 Year", "whcom" ),
                    "long"      => esc_html__( "2 Years", "whcom" ),
                    "short"     => esc_html__( "2 yrs", "whcom" ),
                    "monthly"   => esc_html__( "24 Months", "whcom" ),
                ],

                "triennially" => [
                    "months"    => 36,
                    "duration"  => esc_html__( "Triennially", "whcom" ),
                    "duration2" => esc_html__( "3 Year", "whcom" ),
                    "long"      => esc_html__( "3 Years", "whcom" ),
                    "short"     => esc_html__( "3 yrs", "whcom" ),
                    "monthly"   => esc_html__( "36 Months", "whcom" ),
                ],

                "free" => [
                    "months"    => 0,
                    "duration"  => esc_html__( "Free", "whcom" ),
                    "duration2" => esc_html__( "Free", "whcom" ),
                    "long"      => esc_html__( "Free", "whcom" ),
                    "short"     => esc_html__( "Free", "whcom" ),
                    "monthly"   => esc_html__( "Free", "whcom" ),
                ],

                "onetime" => [
                    "months"    => 1,
                    "duration"  => esc_html__( "One Time", "whcom" ),
                    "duration2" => esc_html__( "One Time", "whcom" ),
                    "long"      => esc_html__( "One Time", "whcom" ),
                    "short"     => esc_html__( "One Time", "whcom" ),
                    "monthly"   => esc_html__( "One Time", "whcom" ),
                ]
            ];

            $return_string = $styles[ strtolower( $args['billingcycle'] ) ]['duration'];
        }
        else {
            $return_string = ucfirst( $args['billingcycle'] );
            //== Translating Base_price and Final_price
            if($return_string == "Base_price")
            {
                $return_string = esc_html__('Base_price','whcom');
            }
            elseif ($return_string == "Final_price"){
                $return_string = esc_html__('Final_price','whcom');
            }

        }

        return $return_string;
    }
}
if ( ! function_exists( 'whcom_whmcs_decrypt' ) ) {
    function whcom_whmcs_decrypt( $string = '' ) {

        $args = [
            'action'    => 'DecryptPassword',
            'password2' => $string
        ];

        return whcom_process_api( $args );
    }
}
if ( ! function_exists( 'whcom_get_tax_levels' ) ) {
    function whcom_get_tax_levels() {
        $response   = [
            'level1_rate'  => 0.00,
            'level1_title' => '',
            'level2_rate'  => 0.00,
            'level2_title' => '',
            'hav_countries' => false
        ];
        if(!empty($_SESSION['whcom_taxes']))
        {
            $taxes = $_SESSION['whcom_taxes'];
        }else {
            $args = [
                "action" => "whcom_get_tax_levels",
            ];
            $taxes = $_SESSION['whcom_taxes'] = whcom_process_helper($args)['data'];
        }
        $country    = whcom_get_default_country();
        if (isset($_SESSION['whcom_user']['client']['fullstate'])){
            $state      = strtolower( $_SESSION['whcom_user']['client']['fullstate']);
        }else{
            $state      = strtolower( $_SESSION['whcom_tax_default_state'] );
        }
        if(!empty($_SESSION['whcom_tax_status']))
        {
            $taxStatusArray = $_SESSION['whcom_tax_status'];
        }else {
            //== if tax toggle is set to ON
            if (isset(whcom_process_helper($args)['taxToggle'])) {
                $taxStatusArray = $_SESSION['whcom_tax_status'] = whcom_process_helper($args)['taxToggle'];
            }
        }
        $taxStatus = !empty($taxStatusArray) ?  $taxStatusArray[0]['value'] : "";
        $l1_taxes   = [];
        $l2_taxes   = [];
        $applied_l1 = [];
        $applied_l2 = [];
        if ( ! empty( $taxes ) && is_array( $taxes ) ) {
            foreach ( $taxes as $tax ) {
                if ( ! empty( $tax['taxrate'] ) && (float) $tax['taxrate'] > 0 ) {
                    if ( $tax['level'] == '1' ) {
                        $l1_taxes[] = $tax;
                    }
                    if ( $tax['level'] == '2' ) {
                        $l2_taxes[] = $tax;
                    }
                    if (!empty($tax['country'])) {
                        $response['hav_countries'] = true;
                    }
                }
            }
        }

        // Level 1 Taxes
        // Matching Country + State
        foreach ($l1_taxes as $l1_tax) {
            if ($l1_tax['country'] == $country && strtolower($l1_tax['state']) == strtolower($state) && $taxStatus == "on") {
                $applied_l1 = $l1_tax;
                break;
            }
        }
        // Matching Country if above failed
        if (empty($applied_l1)) {
            foreach ($l1_taxes as $l1_tax) {
                if ($l1_tax['country'] == $country && $taxStatus == "on") {
                    $applied_l1 = $l1_tax;
                    break;
                }
            }
        }
        // Matching Any tax if both of above failed
        if (empty($applied_l1) && empty($l1_tax['country']) && empty($l1_tax['state']) && $taxStatus == "on") {
            foreach ($l1_taxes as $l1_tax) {
                $applied_l1 = $l1_tax;
                break;
            }
        }
        // Applying tax if anything found from any of above
        if ( !empty($applied_l1) && $taxStatus == "on" ) {
            $response['level1_rate']  = ( ! empty( $applied_l1['taxrate'] ) ) ? (float) $applied_l1['taxrate'] : 0.00;
            $response['level1_title'] = ( ! empty( $applied_l1['name'] ) ) ? (string) $applied_l1['name'] : '';
        }

        // Level 2 Taxes
        // Matching Country + State
        foreach ($l2_taxes as $l2_tax) {
            if ($l2_tax['country'] == $country && strtolower($l2_tax['state']) == strtolower($state) && $taxStatus == "on") {
                $applied_l2 = $l2_tax;
                break;
            }
        }
        // Matching Country if above failed
        if (empty($applied_l2) && $taxStatus == "on") {
            foreach ($l2_taxes as $l2_tax) {
                if ($l2_tax['country'] == $country && $l2_tax['country'] != $l1_tax['country'] && $taxStatus == "on") {
                    $applied_l2 = $l2_tax;
                    break;
                }
            }
        }
        // Matching Any tax if both of above failed
        if (empty($applied_l2) && empty($l2_tax['country']) && empty($l2_tax['state']) && $taxStatus == "on") {
            foreach ($l2_taxes as $l2_tax) {
                $applied_l2 = $l2_tax;
                break;
            }
        }
        // Applying tax if anything found from any of above
        if ( !empty($applied_l2) && $taxStatus == "on" ) {
            $response['level2_rate']  = ( ! empty( $applied_l2['taxrate'] ) ) ? (float) $applied_l2['taxrate'] : 0.00;
            $response['level2_title'] = ( ! empty( $applied_l2['name'] ) ) ? (string) $applied_l2['name'] : '';
        }

        return $response;
    }
}
if ( ! function_exists( 'whcom_calculate_tax' ) ) {
    function whcom_calculate_tax( $price = 0.00, $tax_settings = [] ) {
        $base_price    = $final_price = $price = (float) $price;
        $level1_amount = $level2_amount = false;


        $tax_settings = ( empty( $tax_settings ) ) ? whcom_get_whmcs_setting() : $tax_settings;

        $TaxType       = $tax_settings['TaxType'];
        $TaxL2Compound = $tax_settings['TaxL2Compound'];
        $tax_levels    = whcom_get_tax_levels();

        $level1_rate = (float) $tax_levels['level1_rate'];
        $level2_rate = (float) $tax_levels['level2_rate'];

        if ( $tax_settings['TaxEnabled'] == 'on' ) {
            if ( ! empty( $level1_rate ) ) {
                if ( $TaxType == "Exclusive" ) {
                    $level1_amount = $price * ( $level1_rate / 100 );
                    $final_price   = $price + $level1_amount;
                }
                else if ( $TaxType == "Inclusive" ) {
                    // Inclusive Tax > Tax Amount = ( Item Price / ( 100 + Tax Rate ) ) x Tax Rate

                    $level1_amount = ( $price / ( 100 + $level1_rate ) ) * $level1_rate;
                    $base_price    = $price - $level1_amount;
                    $final_price   = $price;
                }
            }
            if ( ! empty( $level2_rate ) && ( $level1_amount ) ) {
                if ( strtolower( $TaxL2Compound ) == "on" ) {
                    $price = $level1_amount + $price;
                }

                $level2_amount = 0;
                if ( $TaxType == "Exclusive" ) {
                    $level2_amount = $price * ( $level2_rate / 100 );
                    $final_price   = $final_price + $level2_amount;
                }
                else if ( $TaxType == "Inclusive" ) {
                    $level2_amount = ( $price / ( 100 + $level2_rate ) ) * $level2_rate;
                    $base_price    = $final_price - $level2_amount;
                }
            }
        }


        $response = [
            'base_price'  => (float) $base_price,
            'l1_amount'   => (float) $level1_amount,
            'l2_amount'   => (float) $level2_amount,
            'final_price' => (float) $final_price,
        ];

        return $response;
    }
}
if ( ! function_exists( 'whcom_generate_auto_auth_link' ) ) {
    function whcom_generate_auto_auth_link( $args = [] ) {
        if (whcom_is_client_logged_in()) {
            $goto    = $append_no_redirect = '';
            $default = [
                'goto'               => "clientarea.php",
                'append_no_redirect' => 'yes'
            ];
            $args    = wp_parse_args( $args, $default );
            extract( $args );
            $whmcs_url   = esc_url( get_option( 'whcom_whmcs_admin_url' ) );
            $whmcs_token = esc_attr( get_option( 'whcom_whmcs_admin_auth_key' ) );
            $timestamp = time(); # Get current timestamp
            $email     = whcom_get_current_client()['email']; # Clients Email Address to Login
            $hash = sha1( $email . $timestamp . $whmcs_token ); # Generate Hash
            $redirect = ( $append_no_redirect == 'yes' ) ? '&wcap_no_redirect=yes' : '';
            # Generate AutoAuth URL & Redirect
            $url = $whmcs_url . '/dologin.php' . "?email=$email&timestamp=$timestamp&hash=$hash&goto=" . urlencode( $goto ) . $redirect;
        }
        else {
            $url = '';
        }
        return $url;
    }
}
if ( ! function_exists( 'whcom_get_countries_array' ) ) {
    function whcom_get_countries_array() {
        $countries = array
        (
            'AF' => esc_html__( 'Afghanistan', 'whcom' ),
            'AX' => esc_html__( 'Aland Islands', 'whcom' ),
            'AL' => esc_html__( 'Albania', 'whcom' ),
            'DZ' => esc_html__( 'Algeria', 'whcom' ),
            'AS' => esc_html__( 'American Samoa', 'whcom' ),
            'AD' => esc_html__( 'Andorra', 'whcom' ),
            'AO' => esc_html__( 'Angola', 'whcom' ),
            'AI' => esc_html__( 'Anguilla', 'whcom' ),
            'AQ' => esc_html__( 'Antarctica', 'whcom' ),
            'AG' => esc_html__( 'Antigua And Barbuda', 'whcom' ),
            'AR' => esc_html__( 'Argentina', 'whcom' ),
            'AM' => esc_html__( 'Armenia', 'whcom' ),
            'AW' => esc_html__( 'Aruba', 'whcom' ),
            'AU' => esc_html__( 'Australia', 'whcom' ),
            'AT' => esc_html__( 'Austria', 'whcom' ),
            'AZ' => esc_html__( 'Azerbaijan', 'whcom' ),
            'BS' => esc_html__( 'Bahamas', 'whcom' ),
            'BH' => esc_html__( 'Bahrain', 'whcom' ),
            'BD' => esc_html__( 'Bangladesh', 'whcom' ),
            'BB' => esc_html__( 'Barbados', 'whcom' ),
            'BY' => esc_html__( 'Belarus', 'whcom' ),
            'BE' => esc_html__( 'Belgium', 'whcom' ),
            'BZ' => esc_html__( 'Belize', 'whcom' ),
            'BJ' => esc_html__( 'Benin', 'whcom' ),
            'BM' => esc_html__( 'Bermuda', 'whcom' ),
            'BT' => esc_html__( 'Bhutan', 'whcom' ),
            'BO' => esc_html__( 'Bolivia', 'whcom' ),
            'BA' => esc_html__( 'Bosnia And Herzegovina', 'whcom' ),
            'BW' => esc_html__( 'Botswana', 'whcom' ),
            'BV' => esc_html__( 'Bouvet Island', 'whcom' ),
            'BR' => esc_html__( 'Brazil', 'whcom' ),
            'IO' => esc_html__( 'British Indian Ocean Territory', 'whcom' ),
            'BN' => esc_html__( 'Brunei Darussalam', 'whcom' ),
            'BG' => esc_html__( 'Bulgaria', 'whcom' ),
            'BF' => esc_html__( 'Burkina Faso', 'whcom' ),
            'BI' => esc_html__( 'Burundi', 'whcom' ),
            'KH' => esc_html__( 'Cambodia', 'whcom' ),
            'CM' => esc_html__( 'Cameroon', 'whcom' ),
            'CA' => esc_html__( 'Canada', 'whcom' ),
            'CV' => esc_html__( 'Cape Verde', 'whcom' ),
            'KY' => esc_html__( 'Cayman Islands', 'whcom' ),
            'CF' => esc_html__( 'Central African Republic', 'whcom' ),
            'TD' => esc_html__( 'Chad', 'whcom' ),
            'CL' => esc_html__( 'Chile', 'whcom' ),
            'CN' => esc_html__( 'China', 'whcom' ),
            'CX' => esc_html__( 'Christmas Island', 'whcom' ),
            'CC' => esc_html__( 'Cocos (Keeling) Islands', 'whcom' ),
            'CO' => esc_html__( 'Colombia', 'whcom' ),
            'KM' => esc_html__( 'Comoros', 'whcom' ),
            'CG' => esc_html__( 'Congo', 'whcom' ),
            'CD' => esc_html__( 'Congo, Democratic Republic', 'whcom' ),
            'CK' => esc_html__( 'Cook Islands', 'whcom' ),
            'CR' => esc_html__( 'Costa Rica', 'whcom' ),
            'CI' => esc_html__( 'Cote D\'Ivoire', 'whcom' ),
            'HR' => esc_html__( 'Croatia', 'whcom' ),
            'CU' => esc_html__( 'Cuba', 'whcom' ),
            'CY' => esc_html__( 'Cyprus', 'whcom' ),
            'CZ' => esc_html__( 'Czech Republic', 'whcom' ),
            'DK' => esc_html__( 'Denmark', 'whcom' ),
            'DJ' => esc_html__( 'Djibouti', 'whcom' ),
            'DM' => esc_html__( 'Dominica', 'whcom' ),
            'DO' => esc_html__( 'Dominican Republic', 'whcom' ),
            'EC' => esc_html__( 'Ecuador', 'whcom' ),
            'EG' => esc_html__( 'Egypt', 'whcom' ),
            'SV' => esc_html__( 'El Salvador', 'whcom' ),
            'GQ' => esc_html__( 'Equatorial Guinea', 'whcom' ),
            'ER' => esc_html__( 'Eritrea', 'whcom' ),
            'EE' => esc_html__( 'Estonia', 'whcom' ),
            'ET' => esc_html__( 'Ethiopia', 'whcom' ),
            'FK' => esc_html__( 'Falkland Islands (Malvinas)', 'whcom' ),
            'FO' => esc_html__( 'Faroe Islands', 'whcom' ),
            'FJ' => esc_html__( 'Fiji', 'whcom' ),
            'FI' => esc_html__( 'Finland', 'whcom' ),
            'FR' => esc_html__( 'France', 'whcom' ),
            'GF' => esc_html__( 'French Guiana', 'whcom' ),
            'PF' => esc_html__( 'French Polynesia', 'whcom' ),
            'TF' => esc_html__( 'French Southern Territories', 'whcom' ),
            'GA' => esc_html__( 'Gabon', 'whcom' ),
            'GM' => esc_html__( 'Gambia', 'whcom' ),
            'GE' => esc_html__( 'Georgia', 'whcom' ),
            'DE' => esc_html__( 'Germany', 'whcom' ),
            'GH' => esc_html__( 'Ghana', 'whcom' ),
            'GI' => esc_html__( 'Gibraltar', 'whcom' ),
            'GR' => esc_html__( 'Greece', 'whcom' ),
            'GL' => esc_html__( 'Greenland', 'whcom' ),
            'GD' => esc_html__( 'Grenada', 'whcom' ),
            'GP' => esc_html__( 'Guadeloupe', 'whcom' ),
            'GU' => esc_html__( 'Guam', 'whcom' ),
            'GT' => esc_html__( 'Guatemala', 'whcom' ),
            'GG' => esc_html__( 'Guernsey', 'whcom' ),
            'GN' => esc_html__( 'Guinea', 'whcom' ),
            'GW' => esc_html__( 'Guinea-Bissau', 'whcom' ),
            'GY' => esc_html__( 'Guyana', 'whcom' ),
            'HT' => esc_html__( 'Haiti', 'whcom' ),
            'HM' => esc_html__( 'Heard Island & Mcdonald Islands', 'whcom' ),
            'VA' => esc_html__( 'Holy See (Vatican City State)', 'whcom' ),
            'HN' => esc_html__( 'Honduras', 'whcom' ),
            'HK' => esc_html__( 'Hong Kong', 'whcom' ),
            'HU' => esc_html__( 'Hungary', 'whcom' ),
            'IS' => esc_html__( 'Iceland', 'whcom' ),
            'IN' => esc_html__( 'India', 'whcom' ),
            'ID' => esc_html__( 'Indonesia', 'whcom' ),
            'IR' => esc_html__( 'Iran, Islamic Republic Of', 'whcom' ),
            'IQ' => esc_html__( 'Iraq', 'whcom' ),
            'IE' => esc_html__( 'Ireland', 'whcom' ),
            'IM' => esc_html__( 'Isle Of Man', 'whcom' ),
            'IL' => esc_html__( 'Israel', 'whcom' ),
            'IT' => esc_html__( 'Italy', 'whcom' ),
            'JM' => esc_html__( 'Jamaica', 'whcom' ),
            'JP' => esc_html__( 'Japan', 'whcom' ),
            'JE' => esc_html__( 'Jersey', 'whcom' ),
            'JO' => esc_html__( 'Jordan', 'whcom' ),
            'KZ' => esc_html__( 'Kazakhstan', 'whcom' ),
            'KE' => esc_html__( 'Kenya', 'whcom' ),
            'KI' => esc_html__( 'Kiribati', 'whcom' ),
            'KR' => esc_html__( 'Korea', 'whcom' ),
            'KW' => esc_html__( 'Kuwait', 'whcom' ),
            'KG' => esc_html__( 'Kyrgyzstan', 'whcom' ),
            'LA' => esc_html__( 'Lao People\'s Democratic Republic', 'whcom' ),
            'LV' => esc_html__( 'Latvia', 'whcom' ),
            'LB' => esc_html__( 'Lebanon', 'whcom' ),
            'LS' => esc_html__( 'Lesotho', 'whcom' ),
            'LR' => esc_html__( 'Liberia', 'whcom' ),
            'LY' => esc_html__( 'Libyan Arab Jamahiriya', 'whcom' ),
            'LI' => esc_html__( 'Liechtenstein', 'whcom' ),
            'LT' => esc_html__( 'Lithuania', 'whcom' ),
            'LU' => esc_html__( 'Luxembourg', 'whcom' ),
            'MO' => esc_html__( 'Macao', 'whcom' ),
            'MK' => esc_html__( 'Macedonia', 'whcom' ),
            'MG' => esc_html__( 'Madagascar', 'whcom' ),
            'MW' => esc_html__( 'Malawi', 'whcom' ),
            'MY' => esc_html__( 'Malaysia', 'whcom' ),
            'MV' => esc_html__( 'Maldives', 'whcom' ),
            'ML' => esc_html__( 'Mali', 'whcom' ),
            'MT' => esc_html__( 'Malta', 'whcom' ),
            'MH' => esc_html__( 'Marshall Islands', 'whcom' ),
            'MQ' => esc_html__( 'Martinique', 'whcom' ),
            'MR' => esc_html__( 'Mauritania', 'whcom' ),
            'MU' => esc_html__( 'Mauritius', 'whcom' ),
            'YT' => esc_html__( 'Mayotte', 'whcom' ),
            'MX' => esc_html__( 'Mexico', 'whcom' ),
            'FM' => esc_html__( 'Micronesia, Federated States Of', 'whcom' ),
            'MD' => esc_html__( 'Moldova', 'whcom' ),
            'MC' => esc_html__( 'Monaco', 'whcom' ),
            'MN' => esc_html__( 'Mongolia', 'whcom' ),
            'ME' => esc_html__( 'Montenegro', 'whcom' ),
            'MS' => esc_html__( 'Montserrat', 'whcom' ),
            'MA' => esc_html__( 'Morocco', 'whcom' ),
            'MZ' => esc_html__( 'Mozambique', 'whcom' ),
            'MM' => esc_html__( 'Myanmar', 'whcom' ),
            'NA' => esc_html__( 'Namibia', 'whcom' ),
            'NR' => esc_html__( 'Nauru', 'whcom' ),
            'NP' => esc_html__( 'Nepal', 'whcom' ),
            'NL' => esc_html__( 'Netherlands', 'whcom' ),
            'AN' => esc_html__( 'Netherlands Antilles', 'whcom' ),
            'NC' => esc_html__( 'New Caledonia', 'whcom' ),
            'NZ' => esc_html__( 'New Zealand', 'whcom' ),
            'NI' => esc_html__( 'Nicaragua', 'whcom' ),
            'NE' => esc_html__( 'Niger', 'whcom' ),
            'NG' => esc_html__( 'Nigeria', 'whcom' ),
            'NU' => esc_html__( 'Niue', 'whcom' ),
            'NF' => esc_html__( 'Norfolk Island', 'whcom' ),
            'MP' => esc_html__( 'Northern Mariana Islands', 'whcom' ),
            'NO' => esc_html__( 'Norway', 'whcom' ),
            'OM' => esc_html__( 'Oman', 'whcom' ),
            'PK' => esc_html__( 'Pakistan', 'whcom' ),
            'PW' => esc_html__( 'Palau', 'whcom' ),
            'PS' => esc_html__( 'Palestinian Territory, Occupied', 'whcom' ),
            'PA' => esc_html__( 'Panama', 'whcom' ),
            'PG' => esc_html__( 'Papua New Guinea', 'whcom' ),
            'PY' => esc_html__( 'Paraguay', 'whcom' ),
            'PE' => esc_html__( 'Peru', 'whcom' ),
            'PH' => esc_html__( 'Philippines', 'whcom' ),
            'PN' => esc_html__( 'Pitcairn', 'whcom' ),
            'PL' => esc_html__( 'Poland', 'whcom' ),
            'PT' => esc_html__( 'Portugal', 'whcom' ),
            'PR' => esc_html__( 'Puerto Rico', 'whcom' ),
            'QA' => esc_html__( 'Qatar', 'whcom' ),
            'RE' => esc_html__( 'Reunion', 'whcom' ),
            'RO' => esc_html__( 'Romania', 'whcom' ),
            'RU' => esc_html__( 'Russian Federation', 'whcom' ),
            'RW' => esc_html__( 'Rwanda', 'whcom' ),
            'BL' => esc_html__( 'Saint Barthelemy', 'whcom' ),
            'SH' => esc_html__( 'Saint Helena', 'whcom' ),
            'KN' => esc_html__( 'Saint Kitts And Nevis', 'whcom' ),
            'LC' => esc_html__( 'Saint Lucia', 'whcom' ),
            'MF' => esc_html__( 'Saint Martin', 'whcom' ),
            'PM' => esc_html__( 'Saint Pierre And Miquelon', 'whcom' ),
            'VC' => esc_html__( 'Saint Vincent And Grenadines', 'whcom' ),
            'WS' => esc_html__( 'Samoa', 'whcom' ),
            'SM' => esc_html__( 'San Marino', 'whcom' ),
            'ST' => esc_html__( 'Sao Tome And Principe', 'whcom' ),
            'SA' => esc_html__( 'Saudi Arabia', 'whcom' ),
            'SN' => esc_html__( 'Senegal', 'whcom' ),
            'RS' => esc_html__( 'Serbia', 'whcom' ),
            'SC' => esc_html__( 'Seychelles', 'whcom' ),
            'SL' => esc_html__( 'Sierra Leone', 'whcom' ),
            'SG' => esc_html__( 'Singapore', 'whcom' ),
            'SK' => esc_html__( 'Slovakia', 'whcom' ),
            'SI' => esc_html__( 'Slovenia', 'whcom' ),
            'SB' => esc_html__( 'Solomon Islands', 'whcom' ),
            'SO' => esc_html__( 'Somalia', 'whcom' ),
            'ZA' => esc_html__( 'South Africa', 'whcom' ),
            'GS' => esc_html__( 'South Georgia And Sandwich Isl.', 'whcom' ),
            'ES' => esc_html__( 'Spain', 'whcom' ),
            'LK' => esc_html__( 'Sri Lanka', 'whcom' ),
            'SD' => esc_html__( 'Sudan', 'whcom' ),
            'SR' => esc_html__( 'Suriname', 'whcom' ),
            'SJ' => esc_html__( 'Svalbard And Jan Mayen', 'whcom' ),
            'SZ' => esc_html__( 'Swaziland', 'whcom' ),
            'SE' => esc_html__( 'Sweden', 'whcom' ),
            'CH' => esc_html__( 'Switzerland', 'whcom' ),
            'SY' => esc_html__( 'Syrian Arab Republic', 'whcom' ),
            'TW' => esc_html__( 'Taiwan', 'whcom' ),
            'TJ' => esc_html__( 'Tajikistan', 'whcom' ),
            'TZ' => esc_html__( 'Tanzania', 'whcom' ),
            'TH' => esc_html__( 'Thailand', 'whcom' ),
            'TL' => esc_html__( 'Timor-Leste', 'whcom' ),
            'TG' => esc_html__( 'Togo', 'whcom' ),
            'TK' => esc_html__( 'Tokelau', 'whcom' ),
            'TO' => esc_html__( 'Tonga', 'whcom' ),
            'TT' => esc_html__( 'Trinidad And Tobago', 'whcom' ),
            'TN' => esc_html__( 'Tunisia', 'whcom' ),
            'TR' => esc_html__( 'Turkey', 'whcom' ),
            'TM' => esc_html__( 'Turkmenistan', 'whcom' ),
            'TC' => esc_html__( 'Turks And Caicos Islands', 'whcom' ),
            'TV' => esc_html__( 'Tuvalu', 'whcom' ),
            'UG' => esc_html__( 'Uganda', 'whcom' ),
            'UA' => esc_html__( 'Ukraine', 'whcom' ),
            'AE' => esc_html__( 'United Arab Emirates', 'whcom' ),
            'GB' => esc_html__( 'United Kingdom', 'whcom' ),
            'US' => esc_html__( 'United States', 'whcom' ),
            'UM' => esc_html__( 'United States Outlying Islands', 'whcom' ),
            'UY' => esc_html__( 'Uruguay', 'whcom' ),
            'UZ' => esc_html__( 'Uzbekistan', 'whcom' ),
            'VU' => esc_html__( 'Vanuatu', 'whcom' ),
            'VE' => esc_html__( 'Venezuela', 'whcom' ),
            'VN' => esc_html__( 'Viet Nam', 'whcom' ),
            'VG' => esc_html__( 'Virgin Islands, British', 'whcom' ),
            'VI' => esc_html__( 'Virgin Islands, U.S.', 'whcom' ),
            'WF' => esc_html__( 'Wallis And Futuna', 'whcom' ),
            'EH' => esc_html__( 'Western Sahara', 'whcom' ),
            'YE' => esc_html__( 'Yemen', 'whcom' ),
            'ZM' => esc_html__( 'Zambia', 'whcom' ),
            'ZW' => esc_html__( 'Zimbabwe', 'whcom' ),
        );



        return $countries;
    }
}
if ( ! function_exists( 'whcom_get_countries_code_array' ) ) {
    function whcom_get_countries_code_array() {
        $countries = array
        (
            'AF' => esc_html__( 'Afghanistan', 'whcom' ),
            'AX' => esc_html__( 'Aland Islands', 'whcom' ),
            'AL' => esc_html__( 'Albania', 'whcom' ),
            'DZ' => esc_html__( 'Algeria', 'whcom' ),
            'AS' => esc_html__( 'American Samoa', 'whcom' ),
            'AD' => esc_html__( 'Andorra', 'whcom' ),
            'AO' => esc_html__( 'Angola', 'whcom' ),
            'AI' => esc_html__( 'Anguilla', 'whcom' ),
            'AQ' => esc_html__( 'Antarctica', 'whcom' ),
            'AG' => esc_html__( 'Antigua And Barbuda', 'whcom' ),
            'AR' => esc_html__( 'Argentina', 'whcom' ),
            'AM' => esc_html__( 'Armenia', 'whcom' ),
            'AW' => esc_html__( 'Aruba', 'whcom' ),
            'AU' => esc_html__( 'Australia', 'whcom' ),
            'AT' => esc_html__( 'Austria', 'whcom' ),
            'AZ' => esc_html__( 'Azerbaijan', 'whcom' ),
            'BS' => esc_html__( 'Bahamas', 'whcom' ),
            'BH' => esc_html__( 'Bahrain', 'whcom' ),
            'BD' => esc_html__( 'Bangladesh', 'whcom' ),
            'BB' => esc_html__( 'Barbados', 'whcom' ),
            'BY' => esc_html__( 'Belarus', 'whcom' ),
            'BE' => esc_html__( 'Belgium', 'whcom' ),
            'BZ' => esc_html__( 'Belize', 'whcom' ),
            'BJ' => esc_html__( 'Benin', 'whcom' ),
            'BM' => esc_html__( 'Bermuda', 'whcom' ),
            'BT' => esc_html__( 'Bhutan', 'whcom' ),
            'BO' => esc_html__( 'Bolivia', 'whcom' ),
            'BA' => esc_html__( 'Bosnia And Herzegovina', 'whcom' ),
            'BW' => esc_html__( 'Botswana', 'whcom' ),
            'BV' => esc_html__( 'Bouvet Island', 'whcom' ),
            'BR' => esc_html__( 'Brazil', 'whcom' ),
            'IO' => esc_html__( 'British Indian Ocean Territory', 'whcom' ),
            'BN' => esc_html__( 'Brunei Darussalam', 'whcom' ),
            'BG' => esc_html__( 'Bulgaria', 'whcom' ),
            'BF' => esc_html__( 'Burkina Faso', 'whcom' ),
            'BI' => esc_html__( 'Burundi', 'whcom' ),
            'KH' => esc_html__( 'Cambodia', 'whcom' ),
            'CM' => esc_html__( 'Cameroon', 'whcom' ),
            'CA' => esc_html__( 'Canada', 'whcom' ),
            'CV' => esc_html__( 'Cape Verde', 'whcom' ),
            'KY' => esc_html__( 'Cayman Islands', 'whcom' ),
            'CF' => esc_html__( 'Central African Republic', 'whcom' ),
            'TD' => esc_html__( 'Chad', 'whcom' ),
            'CL' => esc_html__( 'Chile', 'whcom' ),
            'CN' => esc_html__( 'China', 'whcom' ),
            'CX' => esc_html__( 'Christmas Island', 'whcom' ),
            'CC' => esc_html__( 'Cocos (Keeling) Islands', 'whcom' ),
            'CO' => esc_html__( 'Colombia', 'whcom' ),
            'KM' => esc_html__( 'Comoros', 'whcom' ),
            'CG' => esc_html__( 'Congo', 'whcom' ),
            'CD' => esc_html__( 'Congo, Democratic Republic', 'whcom' ),
            'CK' => esc_html__( 'Cook Islands', 'whcom' ),
            'CR' => esc_html__( 'Costa Rica', 'whcom' ),
            'CI' => esc_html__( 'Cote D\'Ivoire', 'whcom' ),
            'HR' => esc_html__( 'Croatia', 'whcom' ),
            'CU' => esc_html__( 'Cuba', 'whcom' ),
            'CY' => esc_html__( 'Cyprus', 'whcom' ),
            'CZ' => esc_html__( 'Czech Republic', 'whcom' ),
            'DK' => esc_html__( 'Denmark', 'whcom' ),
            'DJ' => esc_html__( 'Djibouti', 'whcom' ),
            'DM' => esc_html__( 'Dominica', 'whcom' ),
            'DO' => esc_html__( 'Dominican Republic', 'whcom' ),
            'EC' => esc_html__( 'Ecuador', 'whcom' ),
            'EG' => esc_html__( 'Egypt', 'whcom' ),
            'SV' => esc_html__( 'El Salvador', 'whcom' ),
            'GQ' => esc_html__( 'Equatorial Guinea', 'whcom' ),
            'ER' => esc_html__( 'Eritrea', 'whcom' ),
            'EE' => esc_html__( 'Estonia', 'whcom' ),
            'ET' => esc_html__( 'Ethiopia', 'whcom' ),
            'FK' => esc_html__( 'Falkland Islands (Malvinas)', 'whcom' ),
            'FO' => esc_html__( 'Faroe Islands', 'whcom' ),
            'FJ' => esc_html__( 'Fiji', 'whcom' ),
            'FI' => esc_html__( 'Finland', 'whcom' ),
            'FR' => esc_html__( 'France', 'whcom' ),
            'GF' => esc_html__( 'French Guiana', 'whcom' ),
            'PF' => esc_html__( 'French Polynesia', 'whcom' ),
            'TF' => esc_html__( 'French Southern Territories', 'whcom' ),
            'GA' => esc_html__( 'Gabon', 'whcom' ),
            'GM' => esc_html__( 'Gambia', 'whcom' ),
            'GE' => esc_html__( 'Georgia', 'whcom' ),
            'DE' => esc_html__( 'Germany', 'whcom' ),
            'GH' => esc_html__( 'Ghana', 'whcom' ),
            'GI' => esc_html__( 'Gibraltar', 'whcom' ),
            'GR' => esc_html__( 'Greece', 'whcom' ),
            'GL' => esc_html__( 'Greenland', 'whcom' ),
            'GD' => esc_html__( 'Grenada', 'whcom' ),
            'GP' => esc_html__( 'Guadeloupe', 'whcom' ),
            'GU' => esc_html__( 'Guam', 'whcom' ),
            'GT' => esc_html__( 'Guatemala', 'whcom' ),
            'GG' => esc_html__( 'Guernsey', 'whcom' ),
            'GN' => esc_html__( 'Guinea', 'whcom' ),
            'GW' => esc_html__( 'Guinea-Bissau', 'whcom' ),
            'GY' => esc_html__( 'Guyana', 'whcom' ),
            'HT' => esc_html__( 'Haiti', 'whcom' ),
            'HM' => esc_html__( 'Heard Island & Mcdonald Islands', 'whcom' ),
            'VA' => esc_html__( 'Holy See (Vatican City State)', 'whcom' ),
            'HN' => esc_html__( 'Honduras', 'whcom' ),
            'HK' => esc_html__( 'Hong Kong', 'whcom' ),
            'HU' => esc_html__( 'Hungary', 'whcom' ),
            'IS' => esc_html__( 'Iceland', 'whcom' ),
            'IN' => esc_html__( 'India', 'whcom' ),
            'ID' => esc_html__( 'Indonesia', 'whcom' ),
            'IR' => esc_html__( 'Iran, Islamic Republic Of', 'whcom' ),
            'IQ' => esc_html__( 'Iraq', 'whcom' ),
            'IE' => esc_html__( 'Ireland', 'whcom' ),
            'IM' => esc_html__( 'Isle Of Man', 'whcom' ),
            'IL' => esc_html__( 'Israel', 'whcom' ),
            'IT' => esc_html__( 'Italy', 'whcom' ),
            'JM' => esc_html__( 'Jamaica', 'whcom' ),
            'JP' => esc_html__( 'Japan', 'whcom' ),
            'JE' => esc_html__( 'Jersey', 'whcom' ),
            'JO' => esc_html__( 'Jordan', 'whcom' ),
            'KZ' => esc_html__( 'Kazakhstan', 'whcom' ),
            'KE' => esc_html__( 'Kenya', 'whcom' ),
            'KI' => esc_html__( 'Kiribati', 'whcom' ),
            'KR' => esc_html__( 'Korea', 'whcom' ),
            'KW' => esc_html__( 'Kuwait', 'whcom' ),
            'KG' => esc_html__( 'Kyrgyzstan', 'whcom' ),
            'LA' => esc_html__( 'Lao People\'s Democratic Republic', 'whcom' ),
            'LV' => esc_html__( 'Latvia', 'whcom' ),
            'LB' => esc_html__( 'Lebanon', 'whcom' ),
            'LS' => esc_html__( 'Lesotho', 'whcom' ),
            'LR' => esc_html__( 'Liberia', 'whcom' ),
            'LY' => esc_html__( 'Libyan Arab Jamahiriya', 'whcom' ),
            'LI' => esc_html__( 'Liechtenstein', 'whcom' ),
            'LT' => esc_html__( 'Lithuania', 'whcom' ),
            'LU' => esc_html__( 'Luxembourg', 'whcom' ),
            'MO' => esc_html__( 'Macao', 'whcom' ),
            'MK' => esc_html__( 'Macedonia', 'whcom' ),
            'MG' => esc_html__( 'Madagascar', 'whcom' ),
            'MW' => esc_html__( 'Malawi', 'whcom' ),
            'MY' => esc_html__( 'Malaysia', 'whcom' ),
            'MV' => esc_html__( 'Maldives', 'whcom' ),
            'ML' => esc_html__( 'Mali', 'whcom' ),
            'MT' => esc_html__( 'Malta', 'whcom' ),
            'MH' => esc_html__( 'Marshall Islands', 'whcom' ),
            'MQ' => esc_html__( 'Martinique', 'whcom' ),
            'MR' => esc_html__( 'Mauritania', 'whcom' ),
            'MU' => esc_html__( 'Mauritius', 'whcom' ),
            'YT' => esc_html__( 'Mayotte', 'whcom' ),
            'MX' => esc_html__( 'Mexico', 'whcom' ),
            'FM' => esc_html__( 'Micronesia, Federated States Of', 'whcom' ),
            'MD' => esc_html__( 'Moldova', 'whcom' ),
            'MC' => esc_html__( 'Monaco', 'whcom' ),
            'MN' => esc_html__( 'Mongolia', 'whcom' ),
            'ME' => esc_html__( 'Montenegro', 'whcom' ),
            'MS' => esc_html__( 'Montserrat', 'whcom' ),
            'MA' => esc_html__( 'Morocco', 'whcom' ),
            'MZ' => esc_html__( 'Mozambique', 'whcom' ),
            'MM' => esc_html__( 'Myanmar', 'whcom' ),
            'NA' => esc_html__( 'Namibia', 'whcom' ),
            'NR' => esc_html__( 'Nauru', 'whcom' ),
            'NP' => esc_html__( 'Nepal', 'whcom' ),
            'NL' => esc_html__( 'Netherlands', 'whcom' ),
            'AN' => esc_html__( 'Netherlands Antilles', 'whcom' ),
            'NC' => esc_html__( 'New Caledonia', 'whcom' ),
            'NZ' => esc_html__( 'New Zealand', 'whcom' ),
            'NI' => esc_html__( 'Nicaragua', 'whcom' ),
            'NE' => esc_html__( 'Niger', 'whcom' ),
            'NG' => esc_html__( 'Nigeria', 'whcom' ),
            'NU' => esc_html__( 'Niue', 'whcom' ),
            'NF' => esc_html__( 'Norfolk Island', 'whcom' ),
            'MP' => esc_html__( 'Northern Mariana Islands', 'whcom' ),
            'NO' => esc_html__( 'Norway', 'whcom' ),
            'OM' => esc_html__( 'Oman', 'whcom' ),
            'PK' => esc_html__( 'Pakistan', 'whcom' ),
            'PW' => esc_html__( 'Palau', 'whcom' ),
            'PS' => esc_html__( 'Palestinian Territory, Occupied', 'whcom' ),
            'PA' => esc_html__( 'Panama', 'whcom' ),
            'PG' => esc_html__( 'Papua New Guinea', 'whcom' ),
            'PY' => esc_html__( 'Paraguay', 'whcom' ),
            'PE' => esc_html__( 'Peru', 'whcom' ),
            'PH' => esc_html__( 'Philippines', 'whcom' ),
            'PN' => esc_html__( 'Pitcairn', 'whcom' ),
            'PL' => esc_html__( 'Poland', 'whcom' ),
            'PT' => esc_html__( 'Portugal', 'whcom' ),
            'PR' => esc_html__( 'Puerto Rico', 'whcom' ),
            'QA' => esc_html__( 'Qatar', 'whcom' ),
            'RE' => esc_html__( 'Reunion', 'whcom' ),
            'RO' => esc_html__( 'Romania', 'whcom' ),
            'RU' => esc_html__( 'Russian Federation', 'whcom' ),
            'RW' => esc_html__( 'Rwanda', 'whcom' ),
            'BL' => esc_html__( 'Saint Barthelemy', 'whcom' ),
            'SH' => esc_html__( 'Saint Helena', 'whcom' ),
            'KN' => esc_html__( 'Saint Kitts And Nevis', 'whcom' ),
            'LC' => esc_html__( 'Saint Lucia', 'whcom' ),
            'MF' => esc_html__( 'Saint Martin', 'whcom' ),
            'PM' => esc_html__( 'Saint Pierre And Miquelon', 'whcom' ),
            'VC' => esc_html__( 'Saint Vincent And Grenadines', 'whcom' ),
            'WS' => esc_html__( 'Samoa', 'whcom' ),
            'SM' => esc_html__( 'San Marino', 'whcom' ),
            'ST' => esc_html__( 'Sao Tome And Principe', 'whcom' ),
            'SA' => esc_html__( 'Saudi Arabia', 'whcom' ),
            'SN' => esc_html__( 'Senegal', 'whcom' ),
            'RS' => esc_html__( 'Serbia', 'whcom' ),
            'SC' => esc_html__( 'Seychelles', 'whcom' ),
            'SL' => esc_html__( 'Sierra Leone', 'whcom' ),
            'SG' => esc_html__( 'Singapore', 'whcom' ),
            'SK' => esc_html__( 'Slovakia', 'whcom' ),
            'SI' => esc_html__( 'Slovenia', 'whcom' ),
            'SB' => esc_html__( 'Solomon Islands', 'whcom' ),
            'SO' => esc_html__( 'Somalia', 'whcom' ),
            'ZA' => esc_html__( 'South Africa', 'whcom' ),
            'GS' => esc_html__( 'South Georgia And Sandwich Isl.', 'whcom' ),
            'ES' => esc_html__( 'Spain', 'whcom' ),
            'LK' => esc_html__( 'Sri Lanka', 'whcom' ),
            'SD' => esc_html__( 'Sudan', 'whcom' ),
            'SR' => esc_html__( 'Suriname', 'whcom' ),
            'SJ' => esc_html__( 'Svalbard And Jan Mayen', 'whcom' ),
            'SZ' => esc_html__( 'Swaziland', 'whcom' ),
            'SE' => esc_html__( 'Sweden', 'whcom' ),
            'CH' => esc_html__( 'Switzerland', 'whcom' ),
            'SY' => esc_html__( 'Syrian Arab Republic', 'whcom' ),
            'TW' => esc_html__( 'Taiwan', 'whcom' ),
            'TJ' => esc_html__( 'Tajikistan', 'whcom' ),
            'TZ' => esc_html__( 'Tanzania', 'whcom' ),
            'TH' => esc_html__( 'Thailand', 'whcom' ),
            'TL' => esc_html__( 'Timor-Leste', 'whcom' ),
            'TG' => esc_html__( 'Togo', 'whcom' ),
            'TK' => esc_html__( 'Tokelau', 'whcom' ),
            'TO' => esc_html__( 'Tonga', 'whcom' ),
            'TT' => esc_html__( 'Trinidad And Tobago', 'whcom' ),
            'TN' => esc_html__( 'Tunisia', 'whcom' ),
            'TR' => esc_html__( 'Turkey', 'whcom' ),
            'TM' => esc_html__( 'Turkmenistan', 'whcom' ),
            'TC' => esc_html__( 'Turks And Caicos Islands', 'whcom' ),
            'TV' => esc_html__( 'Tuvalu', 'whcom' ),
            'UG' => esc_html__( 'Uganda', 'whcom' ),
            'UA' => esc_html__( 'Ukraine', 'whcom' ),
            'AE' => esc_html__( 'United Arab Emirates', 'whcom' ),
            'GB' => esc_html__( 'United Kingdom', 'whcom' ),
            'US' => esc_html__( 'United States', 'whcom' ),
            'UM' => esc_html__( 'United States Outlying Islands', 'whcom' ),
            'UY' => esc_html__( 'Uruguay', 'whcom' ),
            'UZ' => esc_html__( 'Uzbekistan', 'whcom' ),
            'VU' => esc_html__( 'Vanuatu', 'whcom' ),
            'VE' => esc_html__( 'Venezuela', 'whcom' ),
            'VN' => esc_html__( 'Viet Nam', 'whcom' ),
            'VG' => esc_html__( 'Virgin Islands, British', 'whcom' ),
            'VI' => esc_html__( 'Virgin Islands, U.S.', 'whcom' ),
            'WF' => esc_html__( 'Wallis And Futuna', 'whcom' ),
            'EH' => esc_html__( 'Western Sahara', 'whcom' ),
            'YE' => esc_html__( 'Yemen', 'whcom' ),
            'ZM' => esc_html__( 'Zambia', 'whcom' ),
            'ZW' => esc_html__( 'Zimbabwe', 'whcom' ),
        );



        return array_flip($countries);
    }
}
if ( ! function_exists( 'whcom_get_order_url' ) ) {
    function whcom_get_order_url() {

        $lang     = whcom_get_current_language();
        $base_url = '';
        if ( defined( 'WCOP_VERSION' ) ) {
            $field    = 'configure_product' . $lang;
            $base_url = esc_attr( get_option( $field, '' ) ) . '?';
        }
        else if ( defined( 'WCAP_VERSION' ) ) {
            $field    = 'wcapfield_client_area_url' . $lang;
            $base_url = get_option( $field, '' ) . '?whmpca=order_process';
        }

        return $base_url;
    }
}

if ( ! function_exists( 'whcom_cc_saveable' ) ) {
    function whcom_cc_saveable() {
        $saveable        = false;
        $active_gateways = whcom_get_payment_gateways();
        if ( $active_gateways["status"] == "OK" ) {
            foreach ( $active_gateways["payment_gateways"] as $gateway ) {
                $type = wcap_payment_gateway_type( $gateway["module"] );
                if ( $type == "m" || $type == "t" ) {
                    $saveable = true;
                }

            }
        }

        return $saveable;
    }
}
if ( ! function_exists( 'whcom_payment_gateway_type' ) ) {
    function whcom_payment_gateway_type( $gateway ) {
        $gateway_array =
            [
                "asiapay"              => "m",
                "authorize"            => "m",
                "bluepay"              => "m",
                "camtech"              => "m",
                "cyberbit"             => "m",
                "ematters"             => "m",
                "eprocessingnetwork"   => "m",
                "fasthosts"            => "m",
                "imsp"                 => "m",
                "ippay"                => "m",
                "kuveytturk"           => "m",
                "linkpoint"            => "m",
                "merchantpartners"     => "m",
                "mwarrior"             => "m",
                "moneris"              => "m",
                "navigate"             => "m",
                "netbilling"           => "m",
                "netregistrypay"       => "m",
                "offlinecc"            => "m",
                "optimalpayments"      => "m",
                "payjunction"          => "m",
                "payflowpro"           => "m",
                "paypalpaymentspro"    => "m",
                "planetauthorize"      => "m",
                "psigate"              => "m",
                "quantumgateway"       => "m",
                "sagepayrepeats"       => "m",
                "secpay"               => "m",
                "securepay"            => "m",
                "securepayau"          => "m",
                "securetrading"        => "m",
                "trustcommerce"        => "m",
                "usaepay"              => "m",
                "worldpayinvisible"    => "m",
                "worldpayinvisiblexml" => "m",

                "acceptjs"             => "t",
                "authorizecim"         => "t",
                "bluepayremote"        => "t",
                "ewaytokens"           => "t",
                "monerisvault"         => "t",
                "paypalpaymentsproref" => "t",
                "quantumvault"         => "t",
                "sagepaytokens"        => "t",
                "stripe"               => "t",
                "worldpayfuturepay"    => "t",


                "tco"             => "tp",
                "amazonsimplepay" => "tp",
                "authorizeecheck" => "tp",
                "banktransfer"    => "tp",
                "bluepayecheck"   => "tp",
                "boleto"          => "tp",
                "cashu"           => "tp",
                "ccavenue"        => "tp",
                "ccavenuev2"      => "tp",
                "chronopay"       => "tp",
                "f2b"             => "tp",
                "directdebit"     => "tp",
                "eonlinedata"     => "tp",
                "epath"           => "tp",
                "eeecurrency"     => "tp",
                "paymentsgateway" => "tp",
                "gate2shop"       => "tp",
                "mollieideal"     => "tp",
                "inpay"           => "tp",
                "mailin"          => "tp",
                "moipapi"         => "tp",
                "nochex"          => "tp",
                "pagseguro"       => "tp",
                "paymateau"       => "tp",
                "paymatenz"       => "tp",
                "paymentexpress"  => "tp",
                "ntpnow"          => "tp",
                "paymex"          => "tp",
                "paypal"          => "tp",
                "paypalexpress"   => "tp",
                "paypoint"        => "tp",
                "payson"          => "tp",
                "payza"           => "tp",
                "protx"           => "tp",
                "protxvspform"    => "tp",
                "skrill"          => "tp",
                "moneybookers"    => "tp",
                "slimpay"         => "tp",
                "finansbank"      => "tp",
                "garantibank"     => "tp",
                "worldpay"        => "tp",

            ];
        $type          = ( isset( $gateway_array[ $gateway ] ) ) ? $gateway_array[ $gateway ] : "tp";

        return $type;
    }
}
if ( ! function_exists( 'whcom_format_error_message' ) ) {
    function whcom_format_error_message( $errors = [], $title = '', $type = 'danger' ) {
        $class = ( empty( $type ) ) ? '' : 'whcom_alert whcom_alert_' . $type . '"';

        $html = '';
        if ( ! empty( $errors ) ) {
            $html = '<div class="whcom_margin_bottom_15 ' . $class . '">';
            If ( trim( $title ) != "" ) {
                $html .= '<div class="whcom_margin_bottom_15"> ' . $title . ' </div>';
            }
            if ( is_array( $errors ) ) {
                $html .= '<ul class="whcom_list_padded_narrow">';
                foreach ( $errors['errors'] as $error ) {
                    $html .= '<li>' . $error . '</li>';
                }
                $html .= '</ul>';
            }
            else {
                $html .= '<div> ' . $errors . ' </div>';
            }
            $html .= '</div>';
        }

        return $html;
    }
}
if ( ! function_exists( 'whcom_get_starred_string' ) ) {
    function whcom_get_starred_string( $str ) {
        $len = strlen( $str );
        if ( $len < 10 ) {
            return $str;
        }

        return substr( $str, 0, 4 ) . str_repeat( '*', $len - 8 ) . substr( $str, $len - 4, 4 );
    }
}
if ( ! function_exists( 'whcom_get_default_country' ) ) {
    function whcom_get_default_country () {
        if (isset($_SESSION['whcom_user']['client']['countrycode'])){
            $saved_country = $_SESSION['whcom_user']['client']['countrycode'];
        }else{
            $saved_country = $_SESSION['whcom_tax_default_country'];
        }
        $countries = whcom_get_countries_code_array();
        if (in_array((string) $saved_country, $countries)) {
            $country = (string)$saved_country;
        }
        else {
            $default_country = whcom_get_whmcs_setting('DefaultCountry');
            $country = $_SESSION['whcom_tax_default_country'] = $default_country;
        }

        return $country;
    }
}


/**====================================================================**/
/**==       INIT Function                                            ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/init.php";

/**====================================================================**/
/**==       Enqueuing CSS and JS                                     ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/enqueue.php";

/**====================================================================**/
/**==       Admin Pages Function                                     ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/admin_pages.php";

/**====================================================================**/
/**==       Settings Function                                        ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/settings.php";

/**====================================================================**/
/**==       API Functions                                            ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/api.php";


/**====================================================================**/
/**==       Helper Functions                                         ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/helper.php";


/**====================================================================**/
/**==       WHMCS Settings functions                                 ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/whmcs_settings.php";


/**====================================================================**/
/**==       Client Functions                                         ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/client.php";


/**====================================================================**/
/**==       Domain Functions                                         ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/domains.php";


/**====================================================================**/
/**==       Product Functions                                        ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/products.php";


/**====================================================================**/
/**==       Currency Functions                                       ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/currency.php";


/**====================================================================**/
/**==       Cart Functions                                           ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/cart.php";


/**====================================================================**/
/**==       Shortcode Functions                                      ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/shortcodes.php";


/**====================================================================**/
/**==       AJAX Functions                                           ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/ajax.php";


/**====================================================================**/
/**==       Order Process                                            ==**/
/**====================================================================**/
require_once WHCOM_PATH . "/includes/order_process.php";







