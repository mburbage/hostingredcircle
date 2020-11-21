<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

if ( ! function_exists( 'whcom_get_product_count' ) ) {
    function whcom_get_product_count() {
        if(!empty($_SESSION['whcom_product_count'])){
            $response = $_SESSION['whcom_product_count'];
        }
        else {
            $args = [
                "action" => "whcom_get_product_count",
            ];
            $response = $_SESSION['whcom_product_count'] = whcom_process_helper($args)['data'];
        }
        return $response;
    }
}

if ( ! function_exists( 'whcom_get_all_products' ) ) {
    function whcom_get_all_products( $gids = '', $pids = '' ) {

        //== check if polylang active or not
        $plugin_status = check_plugin_activation_status();
        if ( ! empty( $_SESSION['whcom_all_products'] ) ) {
            $product_count = whcom_get_product_count();
            $groups      = (!empty ($_SESSION['whcom_all_products']['groups'])) ? $_SESSION['whcom_all_products']['groups'] : [];
            $count       = 0;
            foreach ( $groups as $group ) {
                if (!empty($group['products']) && is_array($group['products'])) {
                    foreach ( $group['products'] as $product ) {
                        $count ++;
                    }
                }
            }
            if ( $count == $product_count ) {
                $response = $_SESSION['whcom_all_products'];
            }
            else {
                if($plugin_status == '1'){
                    $args     = [
                        "action"       => "whcom_get_all_products",
                        "pll_language" => whcom_get_current_language(true)
                    ];
                }else {
                    $args = [
                        "action" => "whcom_get_all_products",
                        "language" => whcom_get_whmcs_relevant_language(),
                    ];
                }
                $response = $_SESSION['whcom_all_products'] = whcom_process_helper( $args )['data'];
            }

        }
        else {
            if($plugin_status == '1'){
                $args     = [
                    "action"       => "whcom_get_all_products",
                    "pll_language" => whcom_get_current_language(true)
                ];
            }else {
                $args = [
                    "action" => "whcom_get_all_products",
                    "language" => whcom_get_whmcs_relevant_language(),
                ];
            }
            $response = $_SESSION['whcom_all_products'] = whcom_process_helper( $args )['data'];
        }
        $gids = ( $gids == '' ) ? [] : explode( ',', $gids );
        $pids = ( $pids == '' ) ? [] : explode( ',', $pids );
        if ( ( ! empty( $response['groups'] ) ) && is_array( $response['groups'] ) && ( ! empty( $gids ) ) ) {
            foreach ( $response['groups'] as $g_id => $group ) {
                if ($group == 'English' || $group == 'english') {
                    unset($group);
                }else {
                    if (!in_array($group['id'], $gids)) {
                        unset($response['groups'][$g_id]);
                    }
                }
            }
        }
        if ( ( ! empty( $response['groups'] ) ) && is_array( $response['groups'] ) && ( ! empty( $pids ) ) ) {
            foreach ( $response['groups'] as $g_id => $group ) {
                if ( ( ! empty( $group['products'] ) ) && is_array( $group['products'] ) ) {
                    foreach ( $group['products'] as $p_id => $product ) {
                        if ( ! in_array( $product['id'], $pids ) ) {
                            unset( $response['groups'][ $g_id ]['products'][ $p_id ] );
                        }
                    }
                }
            }
        }

        return $response;
    }
}

if( !function_exists('whcom_get_all_departments'))
{
    function whcom_get_all_departments(){
        $args     = [
            "action" => "whcom_get_all_departments",
        ];
        $support_departments = $_SESSION['whcom_all_support_departments'] = whcom_process_helper( $args )['data'];
        return $support_departments;
    }
}

if ( ! function_exists( 'whcom_get_product_details' ) ) {
    function whcom_get_product_details( $pid = - 1 ) {
        $response = false;
        if ( ! empty( $_SESSION['whcom_cart']['cart_products'][ $pid ]) ) {
            $response = $_SESSION['whcom_cart']['cart_products'][ $pid ];
        }
        else {
            $all_groups = whcom_get_all_products();
            if ( ! empty( $all_groups['groups'] ) && is_array( $all_groups['groups'] ) ) {
                foreach ( $all_groups['groups'] as $group ) {
                    if ( ! empty( $group['products'] ) && is_array( $group['products'] ) ) {
                        foreach ( $group['products'] as $product ) {
                            if ( $product['id'] == $pid ) {
                                $response                                        = $product;
                                $_SESSION['whcom_cart']['cart_products'][ $pid ] = $product;
                                continue;
                            }
                        }
                    }
                    if ( $response ) {
                        continue;
                    }
                }
            }
        }

        return $response;
    }
}

if ( ! function_exists( 'whcom_render_product_price' ) ) {
    function whcom_render_product_price($product) {
        $output = '';
        $product = (is_array($product)) ? $product : whcom_get_product_details((int)$product);

        reset( $product['lowest_price'] );
        $billing_cycle = key( $product['lowest_price'] );

        $starting_from = (!empty($product['prd_configoptions'])) ? esc_html__( "Starting From", "whcom" ) : '&nbsp;';
        if (!empty($product['prd_configoptions']) && is_array($product['prd_configoptions'])) {
            $product_price    = $product['lowest_price'][$billing_cycle]['price'];
            foreach ($product['prd_configoptions'] as $prd_configoption) {
                if (!empty($prd_configoption['sub_options']) && is_array($prd_configoption['sub_options'])) {
                    switch ($prd_configoption['optiontype']) {
                        case '1' : { // Select
                            foreach ($prd_configoption['sub_options'] as $prd_sub_option) {
                                $product_price += $prd_sub_option['all_prices'][$billing_cycle]['price'];
                                break;
                            }
                            break;
                        }
                        case '2' : { // Radio
                            foreach ($prd_configoption['sub_options'] as $prd_sub_option) {
                                $product_price += $prd_sub_option['all_prices'][$billing_cycle]['price'];
                                break;
                            }
                            break;
                        }
                        case '3' : { // Checkbox
                            foreach ($prd_configoption['sub_options'] as $prd_sub_option) {
                                //$product_price += $prd_sub_option['all_prices'][$billing_cycle]['price'];
                                break;
                            }
                            break;
                        }
                        case '4' : { // Number
                            foreach ($prd_configoption['sub_options'] as $prd_sub_option) {
                                $product_price += ($prd_sub_option['all_prices'][$billing_cycle]['price'] * (int)$prd_configoption['qtyminimum']);
                                break;
                            }
                            break;
                        }
                        default : {

                        }
                    }
                }
            }
        }
        else {
            $product_price    = $product['lowest_price'][$billing_cycle]['price'];
        }
        $setup_fee = $product['lowest_price'][$billing_cycle]['setup'];
        $setup_fee_text = ($setup_fee > 0) ? whcom_format_amount($product['lowest_price'][$billing_cycle]['setup']) . ' ' . esc_html__( "Setup Fee", "whcom" ) : '&nbsp;';

        ob_start() ?>
        <div class="whcom_margin_bottom_15 whcom_bordered_bottom whcom_text_center">
            <div><?php echo $starting_from; ?></div>
            <div><?php echo whcom_format_amount($product_price); ?></div>
            <div><?php echo whcom_convert_billingcycle($billing_cycle); ?></div>
            <div class="whcom_margin_bottom_15"><?php echo $setup_fee_text?></div>
        </div>

        <?php
        $output = ob_get_clean();
        return $output;
    }
}

if ( ! function_exists( 'whcom_render_product_price_no_setup' ) ) {
    function whcom_render_product_price_no_setup($product) {
        $output = '';
        $product = (is_array($product)) ? $product : whcom_get_product_details((int)$product);

        reset( $product['lowest_price'] );
        $billing_cycle = key( $product['lowest_price'] );

        $starting_from = (!empty($product['prd_configoptions'])) ? esc_html__( "Starting From", "whcom" ) : '&nbsp;';
        if (!empty($product['prd_configoptions']) && is_array($product['prd_configoptions'])) {
            $product_price    = $product['lowest_price'][$billing_cycle]['price'];
            foreach ($product['prd_configoptions'] as $prd_configoption) {
                if (!empty($prd_configoption['sub_options']) && is_array($prd_configoption['sub_options'])) {
                    switch ($prd_configoption['optiontype']) {
                        case '1' : { // Select
                            foreach ($prd_configoption['sub_options'] as $prd_sub_option) {
                                $product_price += $prd_sub_option['all_prices'][$billing_cycle]['price'];
                                break;
                            }
                            break;
                        }
                        case '2' : { // Radio
                            foreach ($prd_configoption['sub_options'] as $prd_sub_option) {
                                $product_price += $prd_sub_option['all_prices'][$billing_cycle]['price'];
                                break;
                            }
                            break;
                        }
                        case '3' : { // Checkbox
                            foreach ($prd_configoption['sub_options'] as $prd_sub_option) {
                                //$product_price += $prd_sub_option['all_prices'][$billing_cycle]['price'];
                                break;
                            }
                            break;
                        }
                        case '4' : { // Number
                            foreach ($prd_configoption['sub_options'] as $prd_sub_option) {
                                $product_price += ($prd_sub_option['all_prices'][$billing_cycle]['price'] * (int)$prd_configoption['qtyminimum']);
                                break;
                            }
                            break;
                        }
                        default : {

                        }
                    }
                }
            }
        }
        else {
            $product_price    = $product['lowest_price'][$billing_cycle]['price'];
        }
        $setup_fee = $product['lowest_price'][$billing_cycle]['setup'];
        $setup_fee_text = ($setup_fee > 0) ? whcom_format_amount($product['lowest_price'][$billing_cycle]['setup']) . ' ' . esc_html__( "Setup Fee", "whcom" ) : '&nbsp;';

        ob_start() ?>
        <div class="whcom_margin_bottom_15 whcom_bordered_bottom whcom_text_center">
            <!--            <div>--><?php //echo $starting_from; ?><!--</div>-->
            <div><?php echo whcom_format_amount($product_price); ?></div>
            <div><?php echo whcom_convert_billingcycle($billing_cycle); ?></div>
            <!--            <div class="whcom_margin_bottom_15">--><?php //echo $setup_fee_text?><!--</div>-->
        </div>

        <?php
        $output = ob_get_clean();
        return $output;
    }
}

if ( ! function_exists( 'whcom_get_all_addons' ) ) {
    function whcom_get_all_addons() {


        if ( ( ! empty( $_SESSION['whcom_all_addons'] ) ) ) {
            $response = $_SESSION['whcom_all_addons'];
        }
        else {
            $args     = [
                "action" => "whcom_get_all_addons",
            ];
            $response = $_SESSION['whcom_all_addons'] = whcom_process_helper( $args )['data'];
        }
        $args     = [
            "action" => "whcom_get_all_addons",
        ];
        $response = $_SESSION['whcom_all_addons'] = whcom_process_helper( $args )['data'];

        return $response;
    }
}

if ( ! function_exists( 'whcom_get_addon_details' ) ) {
    function whcom_get_addon_details($addonid = 0 ) {
        $all_addons = whcom_get_all_addons();
        $response = [];
        if (!empty($all_addons[$addonid]) && is_array($all_addons[$addonid])) {
            $response = $all_addons[$addonid];
        }
        return $response;
    }
}

if ( ! function_exists( 'whcom_get_service_details' ) ) {
    function whcom_get_service_details($service_id = 0) {
        $response = [];
        if ($service_id > 0) {

            $service_details = whcom_process_api( [
                'action' => 'GetClientsProducts',
                'serviceid' => $service_id
            ]);
            if (!empty($service_details['result']) && (string) $service_details['result'] == 'success'&& (!empty($service_details['products'])) && (!empty($service_details['products']['product'][0])) ) {
                $response = $service_details['products']['product'][0];
            }
        }
        return $response;
    }
}