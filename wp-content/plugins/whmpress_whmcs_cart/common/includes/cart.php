<?php defined('ABSPATH') or die("Cannot access pages directly.");


if (!function_exists('whcom_add_update_cart_item')) {
    function whcom_add_update_cart_item($cart_item = [], $index = -1)
    {
        if (isset($cart_item['cart_index'])) {
            $index = (int)$cart_item['cart_index'];
        }
        $response = [
            'status' => 'ERROR',
            'cart_index' => $index,
            'message' => ''
        ];
        if (!empty($cart_item['domain'])) {
            $current_cart_items = whcom_get_cart()['all_items'];
            foreach ($current_cart_items as $current_cart_index => $current_cart_item) {
                if (!empty($current_cart_item['domain']) && (strtolower($current_cart_item['domain']) == strtolower($cart_item['domain']))) {
                    $cart_item = array_merge($current_cart_item, $cart_item);
                    $index = $current_cart_index;
                }
            }
        }

        if (!empty($cart_item['domain'])) {
            $tld = whcom_get_tld_from_domain($cart_item['domain']);
            $_SESSION['whcom_cart']['cart_domains'][$tld] = whcom_get_tld_details($tld);
        }
        if (!empty($cart_item['pid'])) {
            $pid = $cart_item['pid'];
            $_SESSION['whcom_cart']['cart_products'][$pid] = whcom_get_product_details($pid);
        }

        $response['cart_item'] = $cart_item;
        $cart_items = (!empty($_SESSION['whcom_cart']['all_items'])) ? $_SESSION['whcom_cart']['all_items'] : [];

        $addons = (isset($cart_item['addons'])) ? implode(',', $cart_item['addons']) : '';
        $new_cart_item = [
            'pid' => (isset($cart_item['pid'])) ? $cart_item['pid'] : '',
            //'addonids'        => ( isset( $cart_item['addonids'] ) ) ? $cart_item['addonids'] : '',
            //'serviceids'      => ( isset( $cart_item['serviceids'] ) ) ? $cart_item['serviceids'] : '',
            'cid' => (isset($cart_item['cid'])) ? $cart_item['cid'] : whcom_get_current_currency_id(),
            'billingcycle' => (isset($cart_item['billingcycle'])) ? $cart_item['billingcycle'] : '',
            'domain' => (isset($cart_item['domain'])) ? $cart_item['domain'] : '',
            'domaintype' => (isset($cart_item['domaintype'])) ? $cart_item['domaintype'] : '',
            'regperiod' => (isset($cart_item['regperiod'])) ? $cart_item['regperiod'] : '',
            'configoptions' => (isset($cart_item['configoptions'])) ? $cart_item['configoptions'] : [],
            'customfields' => (isset($cart_item['customfields'])) ? $cart_item['customfields'] : [],
            'addons' => $addons,
            'domainfields' => (isset($cart_item['domainfields'])) ? $cart_item['domainfields'] : [],
            'dnsmanagement' => (isset($cart_item['dnsmanagement'])) ? $cart_item['dnsmanagement'] : '',
            'emailforwarding' => (isset($cart_item['emailforwarding'])) ? $cart_item['emailforwarding'] : '',
            'idprotection' => (isset($cart_item['idprotection'])) ? $cart_item['idprotection'] : '',
            'eppcode' => (isset($cart_item['eppcode'])) ? $cart_item['eppcode'] : '',
            'hostname' => (isset($cart_item['hostname'])) ? $cart_item['hostname'] : '',
            'ns1prefix' => (isset($cart_item['ns1prefix'])) ? $cart_item['ns1prefix'] : '',
            'ns2prefix' => (isset($cart_item['ns2prefix'])) ? $cart_item['ns2prefix'] : '',
            'rootpw' => (isset($cart_item['rootpw'])) ? $cart_item['rootpw'] : '',

            // Danger below !!!
            //'priceoverride'       => ( isset( $cart_item['priceoverride'] ) ) ? $cart_item['priceoverride'] : '',
            //'domainpriceoverride' => ( isset( $cart_item['domainpriceoverride'] ) ) ? $cart_item['domainpriceoverride'] : '',
            //'domainrenewoverride' => ( isset( $cart_item['domainrenewoverride'] ) ) ? $cart_item['domainrenewoverride'] : '',

        ];

        if (!empty($cart_items[$index])) {
            foreach ($new_cart_item as $i => $item) {
                if (empty($item) || $item == '') {
                    unset($new_cart_item[$i]);
                }
                if ($item == 'to_unset_string') {
                    $new_cart_item[$i] = '';
                }
                if ($item == 'to_unset_array') {
                    $new_cart_item[$i] = [];
                }
            }
            $_SESSION['whcom_cart']['current_item'] = $index;
            $_SESSION['whcom_cart']['all_items'][$index] = array_merge($_SESSION['whcom_cart']['all_items'][$index], $new_cart_item);
            $response['status'] = 'OK';
            $response['message'] = esc_html__("Items has been updated successfully", "whcom");
            $response['cart_index'] = $index;
        } else {
            $_SESSION['whcom_cart']['all_items'][] = $new_cart_item;

            $response['status'] = 'OK';
            $response['message'] = esc_html__("Items has been added to cart successfully", "whcom");
            $response['cart_index'] = $_SESSION['whcom_cart']['current_item'] = max(array_keys($_SESSION['whcom_cart']['all_items']));
        }

        // Order specific cart processing
        $order_specific_items = [
            'addonid' => (!empty($cart_item['addonid']) && $cart_item['addonid'] > 0) ? (int)$cart_item['addonid'] : "",
            // int	            The Addon ID for an Addon Only Order
            'serviceid' => (!empty($cart_item['serviceid']) && $cart_item['serviceid'] > 0) ? (int)$cart_item['serviceid'] : "",
            // int	            The service ID for the addon only order
            'affid' => (!empty($cart_item['affid']) && $cart_item['affid'] > 0) ? (int)$cart_item['affid'] : "",
            // int	            The affiliate id to associate with the order
            'contactid' => (!empty($cart_item['contactid']) && $cart_item['contactid'] > 0) ? (int)$cart_item['contactid'] : "",
            // int	            The id of the contact, associated with the client, that should apply to all domains in the order

            'promooverride' => (!empty($cart_item['promooverride'])) ? (bool)$cart_item['promooverride'] : "",
            // bool	            Should the promotion apply to the order even without matching promotional products
            'noinvoice' => (!empty($cart_item['noinvoice'])) ? (bool)$cart_item['noinvoice'] : "",
            // bool	            Set to true to suppress the invoice generating for the whole order
            'noinvoiceemail' => (!empty($cart_item['noinvoiceemail'])) ? (bool)$cart_item['noinvoiceemail'] : "",
            // bool	            Set to try to suppress the Invoice Created email being sent for the order
            'noemail' => (!empty($cart_item['noemail'])) ? (bool)$cart_item['noemail'] : "",
            // bool	            Set to true to suppress the Order Confirmation email being sent

            'paymentmethod' => (!empty($cart_item['paymentmethod'])) ? (string)$cart_item['paymentmethod'] : "",
            // string           The payment method for the order in the system format. eg. paypal, mailin
            'nameserver1' => (!empty($cart_item['domainns1'])) ? (string)$cart_item['domainns1'] : "",
            // string	        The first nameserver to apply to all domains in the order
            'nameserver2' => (!empty($cart_item['domainns2'])) ? (string)$cart_item['domainns2'] : "",
            // string	        The second nameserver to apply to all domains in the order
            'nameserver3' => (!empty($cart_item['domainns3'])) ? (string)$cart_item['domainns3'] : "",
            // string	        The third nameserver to apply to all domains in the order
            'nameserver4' => (!empty($cart_item['domainns4'])) ? (string)$cart_item['domainns4'] : "",
            // string	        The fourth nameserver to apply to all domains in the order
            'nameserver5' => (!empty($cart_item['domainns5'])) ? (string)$cart_item['domainns5'] : "",
            // string	        The fifth nameserver to apply to all domains in the order
            'promocode' => (!empty($cart_item['promocode'])) ? (string)$cart_item['promocode'] : "",
            // string	        The promotion code to apply to the order
            'clientip' => (!empty($cart_item['clientip'])) ? (string)$cart_item['clientip'] : "",
            // string	        The ip address to associate with the order
            //'domainrenewals' => ( isset( $cart_item['domainrenewals'] ) ) ? $cart_item['domainrenewals'] : [],
            // array            A name -> value array of $domainName -> $renewalPeriod renewals to add an order for
        ];

        foreach ($order_specific_items as $i => $item) {
            if (empty($item) || $item == '') {
                unset($order_specific_items[$i]);
            }
            if ($item == 'to_unset_string') {
                $order_specific_items[$i] = '';
            }
            if ($item == 'to_unset_array') {
                $order_specific_items[$i] = [];
            }
        }

        $_SESSION['whcom_cart']['order_specific'] = array_merge($_SESSION['whcom_cart']['order_specific'], $order_specific_items);

        if (!empty($cart_item['domainrenewals']) && is_array($cart_item['domainrenewals'])) {
            $_SESSION['whcom_cart']['order_specific']['domainrenewals'] = (!empty($_SESSION['whcom_cart']['order_specific']['domainrenewals']) && is_array($_SESSION['whcom_cart']['order_specific']['domainrenewals'])) ? $_SESSION['whcom_cart']['order_specific']['domainrenewals'] : [];
            $_SESSION['whcom_cart']['order_specific']['domainrenewals'] = array_merge($_SESSION['whcom_cart']['order_specific']['domainrenewals'], $cart_item['domainrenewals']);
        }

        if (!empty($cart_item['addonids']) && (int)$cart_item['addonids'] > 0 && !empty($cart_item['serviceids']) && (int)$cart_item['serviceids'] > 0) {
            $_SESSION['whcom_cart']['order_specific']['addonids'] = (!empty($_SESSION['whcom_cart']['order_specific']['addonids']) && is_array($_SESSION['whcom_cart']['order_specific']['addonids'])) ? $_SESSION['whcom_cart']['order_specific']['addonids'] : [];
            $_SESSION['whcom_cart']['order_specific']['addonids'] = array_merge($_SESSION['whcom_cart']['order_specific']['addonids'], [(int)$cart_item['addonids']]);
            $_SESSION['whcom_cart']['order_specific']['serviceids'] = (!empty($_SESSION['whcom_cart']['order_specific']['serviceids']) && is_array($_SESSION['whcom_cart']['order_specific']['serviceids'])) ? $_SESSION['whcom_cart']['order_specific']['serviceids'] : [];
            $_SESSION['whcom_cart']['order_specific']['serviceids'] = array_merge($_SESSION['whcom_cart']['order_specific']['serviceids'], [(int)$cart_item['serviceids']]);
        }

        return $response;
    }
}

if (!function_exists('whcom_get_cart_index')) {
    function whcom_get_cart_index()
    {
        return (!empty($_SESSION['whcom_cart']['current_item'])) ? $_SESSION['whcom_cart']['current_item'] : -1;
    }
}

if (!function_exists('whcom_delete_cart_item')) {
    function whcom_delete_cart_item($index = -1)
    {
        $response = [
            'status' => 'ERROR',
            'index' => $index,
            'message' => esc_html__('Item not available in cart', 'whcom')
        ];
        $index = intval($index);
        if (!empty($_SESSION['whcom_cart']['all_items'][$index])) {
            unset($_SESSION['whcom_cart']['all_items'][$index]);
            $_SESSION['whcom_cart']['current_item'] = -1;
            $response['status'] = 'OK';
            $response['message'] = esc_html__('Item deleted from cart', 'whcom');
        }

        return $response;
    }
}

if (!function_exists('whcom_reset_cart')) {
    function whcom_reset_cart()
    {
        $_SESSION['whcom_cart']['all_items'] = [];
        $_SESSION['whcom_cart']['order_specific'] = [];
        $_SESSION['whcom_cart']['current_item'] = -1;

        return true;
    }
}

if (!function_exists('whcom_get_cart')) {
    function whcom_get_cart()
    {
        return [
            'all_items' => (!empty($_SESSION['whcom_cart']['all_items'])) ? $_SESSION['whcom_cart']['all_items'] : [],
            'order_specific' => (!empty($_SESSION['whcom_cart']['order_specific'])) ? $_SESSION['whcom_cart']['order_specific'] : [],
        ];
    }
}

if (!function_exists('whcom_get_cart_item')) {
    function whcom_get_cart_item($index = -1)
    {
        $response = [
            'cart_item' => [],
        ];
        $cart_items = (!empty($_SESSION['whcom_cart']['all_items'])) ? $_SESSION['whcom_cart']['all_items'] : [];
        if (!empty($cart_items[$index])) {
            $response['cart_item'] = $cart_items[$index];
        }

        return $response;
    }
}

if (!function_exists('whcom_get_submit_able_cart')) {
    function whcom_get_submit_able_cart()
    {
        $curr_cart = whcom_get_cart();
        $all_items = $curr_cart['all_items'];
        $order_specific = $curr_cart['order_specific'];

        $submit_able_cart = [];

        foreach ($all_items as $item) {
            $item_configoptions = (!empty($item['configoptions']) && is_array($item['configoptions'])) ? $item['configoptions'] : [];
            $item_customfields = (!empty($item['customfields']) && is_array($item['customfields'])) ? $item['customfields'] : [];
            $item_domainfields = (!empty($item['domainfields']) && is_array($item['domainfields'])) ? $item['domainfields'] : [];

            $configoptions = $customfields = $domainfields = [];
            foreach ($item_configoptions as $cart_index => $option) {
                $configoptions[$cart_index] = $option;
            }
            $configoptions = (!empty($configoptions) && is_array($configoptions)) ? base64_encode(serialize($configoptions)) : 'to_unset';
            foreach ($item_customfields as $cart_index => $option) {
                $customfields[$cart_index] = $option;
            }
            $customfields = (!empty($customfields) && is_array($customfields)) ? base64_encode(serialize($customfields)) : 'to_unset';
            foreach ($item_domainfields as $cart_index => $option) {
                $domainfields[$cart_index] = $option;
            }
            $domainfields = (!empty($domainfields) && is_array($domainfields)) ? base64_encode(serialize($domainfields)) : 'to_unset';
            $array = [
                // Item specific elements (Separate for each item)
                'pid' => (!empty($item['pid']) && $item['pid'] > 0) ? (int)$item['pid'] : "to_unset",
                // int[]	        The array of product ids to add the order for
                'regperiod' => (!empty($item['regperiod']) && $item['regperiod'] > 0) ? (int)$item['regperiod'] : "to_unset",
                // int[]	        For domain registrations, the registration periods for the domains in the order
                //'addonids'            => ( ! empty( $item['addonids'] ) && $item['addonids'] > 0 ) ? (int) $item['addonids'] : "to_unset",
                // int[]	        An Array of addon ids for an Addon Only Order
                //'serviceids'          => ( ! empty( $item['serviceids'] ) && $item['serviceids'] > 0 ) ? (int) $item['serviceids'] : "to_unset",
                // int[]	        An array of service ids to associate the addons for an Addon Only order
                'priceoverride' => (isset($item['priceoverride']) && $item['priceoverride'] >= 0) ? (float)$item['priceoverride'] : "to_unset",
                // float[]	        Override the price of the product being ordered
                'domainpriceoverride' => (isset($item['domainpriceoverride']) && $item['domainpriceoverride'] >= 0) ? (float)$item['domainpriceoverride'] : "to_unset",
                // float[]	        Override the price of the registration price on the domain being ordered
                'domainrenewoverride' => (isset($item['domainrenewoverride']) && $item['domainrenewoverride'] >= 0) ? (float)$item['domainrenewoverride'] : "to_unset",
                // float[]	        Override the price of the renewal price on the domain being ordered
                'dnsmanagement' => (!empty($item['dnsmanagement'])) ? (bool)$item['dnsmanagement'] : "to_unset",
                // bool[]	        Add DNS Management to the Domain Order
                'emailforwarding' => (!empty($item['emailforwarding'])) ? (bool)$item['emailforwarding'] : "to_unset",
                // bool[]	        Add Email Forwarding to the Domain Order
                'idprotection' => (!empty($item['idprotection'])) ? (bool)$item['idprotection'] : "to_unset",
                // bool[]	        Add ID Protection to the Domain Order
                'domain' => (!empty($item['domain'])) ? (string)$item['domain'] : "to_unset",
                // string[]	        The array of domain names associated with the products/domains
                'billingcycle' => (!empty($item['billingcycle'])) ? (string)$item['billingcycle'] : "to_unset",
                // string[]	        The array of billing cycles for the products
                'domaintype' => (!empty($item['domaintype']) && in_array($item['domaintype'], [
                        'register',
                        'transfer'
                    ])) ? (string)$item['domaintype'] : "to_unset",
                // string[]	        For domain registrations, an array of register or transfer values
                'eppcode' => (!empty($item['eppcode'])) ? (string)$item['eppcode'] : "to_unset",
                // string[]	        For domain transfers. The epp codes for the domains being transferred in the order
                'addons' => (!empty($item['addons'])) ? (string)$item['addons'] : "to_unset",
                // string[]	        A comma separated list of addons to create on order with the products
                'hostname' => (!empty($item['hostname'])) ? (string)$item['hostname'] : "to_unset",
                // string[]	        The hostname of the server for VPS/Dedicated Server orders
                'ns1prefix' => (!empty($item['ns1prefix'])) ? (string)$item['ns1prefix'] : "to_unset",
                // string[]	        The first nameserver prefix for the VPS/Dedicated server. Eg. ns1 in ns1.hostname.com
                'ns2prefix' => (!empty($item['ns2prefix'])) ? (string)$item['ns2prefix'] : "to_unset",
                // string[]	        The second nameserver prefix for the VPS/Dedicated server. Eg. ns2 in ns2.hostname.com
                'rootpw' => (!empty($item['rootpw'])) ? (string)$item['rootpw'] : "to_unset",
                // string[]	        The second nameserver prefix for the VPS/Dedicated server. Eg. ns2 in ns2.hostname.com
                'customfields' => (!empty($customfields)) ? $customfields : "to_unset",
                // string[]	        an array of base64 encoded serialized array of product custom field values
                'configoptions' => (!empty($configoptions)) ? $configoptions : "to_unset",
                // string[]	        an array of base64 encoded serialized array of product configurable options values
                'domainfields' => (!empty($domainfields)) ? $domainfields : "to_unset",
                // string[]	        an array of base64 encoded serialized array of TLD Specific Field Values
            ];
            foreach ($array as $key => $val) {
                if ($val === "to_unset") {
                    unset($array[$key]);
                } else {
                    $submit_able_cart[$key][] = $val;
                }
            }
        }
        $array = [
            // Order specific elements (Universal for whole order)
            'addonid' => (!empty($order_specific['addonid']) && $order_specific['addonid'] > 0) ? (int)$order_specific['addonid'] : "to_unset",
            // int	            The Addon ID for an Addon Only Order
            'serviceid' => (!empty($order_specific['serviceid']) && $order_specific['serviceid'] > 0) ? (int)$order_specific['serviceid'] : "to_unset",
            // int	            The service ID for the addon only order
            'affid' => (!empty($order_specific['affid']) && $order_specific['affid'] > 0) ? (int)$order_specific['affid'] : "to_unset",
            // int	            The affiliate id to associate with the order
            'contactid' => (!empty($order_specific['contactid']) && $order_specific['contactid'] > 0) ? (int)$order_specific['contactid'] : "to_unset",
            // int	            The id of the contact, associated with the client, that should apply to all domains in the order

            'promooverride' => (!empty($order_specific['promooverride'])) ? (bool)$order_specific['promooverride'] : "to_unset",
            // bool	            Should the promotion apply to the order even without matching promotional products
            'noinvoice' => (!empty($order_specific['noinvoice'])) ? (bool)$order_specific['noinvoice'] : "to_unset",
            // bool	            Set to true to suppress the invoice generating for the whole order
            'noinvoiceemail' => (!empty($order_specific['noinvoiceemail'])) ? (bool)$order_specific['noinvoiceemail'] : "to_unset",
            // bool	            Set to try to suppress the Invoice Created email being sent for the order
            'noemail' => (!empty($order_specific['noemail'])) ? (bool)$order_specific['noemail'] : "to_unset",
            // bool	            Set to true to suppress the Order Confirmation email being sent

            'paymentmethod' => (!empty($order_specific['paymentmethod'])) ? (string)$order_specific['paymentmethod'] : "to_unset",
            // string           The payment method for the order in the system format. eg. paypal, mailin
            'nameserver1' => (!empty($order_specific['nameserver1'])) ? (string)$order_specific['nameserver1'] : "to_unset",
            // string	        The first nameserver to apply to all domains in the order
            'nameserver2' => (!empty($order_specific['nameserver2'])) ? (string)$order_specific['nameserver2'] : "to_unset",
            // string	        The second nameserver to apply to all domains in the order
            'nameserver3' => (!empty($order_specific['nameserver3'])) ? (string)$order_specific['nameserver3'] : "to_unset",
            // string	        The third nameserver to apply to all domains in the order
            'nameserver4' => (!empty($order_specific['nameserver4'])) ? (string)$order_specific['nameserver4'] : "to_unset",
            // string	        The fourth nameserver to apply to all domains in the order
            'nameserver5' => (!empty($order_specific['nameserver5'])) ? (string)$order_specific['nameserver5'] : "to_unset",
            // string	        The fifth nameserver to apply to all domains in the order
            'promocode' => (!empty($order_specific['promocode'])) ? (string)$order_specific['promocode'] : "to_unset",
            // string	        The promotion code to apply to the order
            'clientip' => (!empty($order_specific['clientip'])) ? (string)$order_specific['clientip'] : "to_unset",
            // string	        The ip address to associate with the order

            'addonids' => (!empty($order_specific['addonids'])) ? $order_specific['addonids'] : "to_unset",
            'serviceids' => (!empty($order_specific['serviceids'])) ? $order_specific['serviceids'] : "to_unset",
            'domainrenewals' => (!empty($order_specific['domainrenewals'])) ? $order_specific['domainrenewals'] : "to_unset",
            // array	        A name -> value array of $domainName -> $renewalPeriod renewals to add an order for
        ];
        foreach ($array as $key => $val) {
            if ($val === "to_unset") {
                unset($array[$key]);
            }
        }

        $submit_able_cart = array_merge($submit_able_cart, $array);

        return [
            'current' => $curr_cart,
            'submit_able' => $submit_able_cart
        ];
    }
}

if (!function_exists('whcom_submit_order')) {
    function whcom_submit_order()
    {
        $action_array = [
            'action' => 'AddOrder',
            'clientid' => whcom_get_current_client_id(),
        ];
        $cart_array = whcom_get_submit_able_cart()['submit_able'];

        $order_array = array_merge($action_array, $cart_array);
        $order_array['clientip'] = whcom_get_user_ip();
        $res = whcom_process_api($order_array);
        $res['order_array'] = $order_array;
        if (!empty($res['result']) && $res['result'] == 'success') {
            whcom_reset_cart();
        }

        return $res;
    }
}

if (!function_exists('whcom_get_invoice_number')) {
    function whcom_get_invoice_number($invoide_id)
    {
        $action_array = [
            'action' => 'GetInvoice',
            'invoiceid' => $invoide_id,
        ];
        return whcom_process_api($action_array);
    }
}

if (!function_exists('whcom_get_product')) {
    function whcom_get_product($pid = '')
    {
        $action_array = [
            'action' => 'GetProducts',
            'pid' => $pid,
        ];
        $single_product = whcom_process_api($action_array);
        return $single_product;
    }
}

if (!function_exists('whcom_get_current_promo')) {
    function whcom_get_current_promo()
    {
        $promo_code = (!empty(whcom_get_cart()['order_specific']['promocode'])) ? whcom_get_cart()['order_specific']['promocode'] : '';
        $promo_details = [];
        if (!empty($promo_code)) {
            $promo_details = whcom_get_promotion($promo_code);
        }

        return reset($promo_details);
    }
}

if (!function_exists('whcom_get_promotion')) {
    function whcom_get_promotion($code = '')
    {
        $argc = [
            'action' => 'GetPromotions',
            'code' => (string)$code
        ];

        $promotions_raw = whcom_process_api($argc);
        $promotions = [];
        if (!empty($promotions_raw) && !empty($promotions_raw['promotions']) && !empty($promotions_raw['promotions']['promotion'])) {
            if (is_array($promotions_raw['promotions']['promotion'])) {
                foreach ($promotions_raw['promotions']['promotion'] as $promotion) {
                    $promotions[$promotion['id']] = $promotion;
                }
            }
        }

        return $promotions;
    }
}

if (!function_exists('whcom_validate_item_promotion')) {

    function whcom_validate_item_promotion($type = 'product', $item = '', $duration = '', $promo_array = [])
    {

        $response = false;

        if (!empty($item) && !empty($duration)) {
            if (empty($promo_array)) {
                $promo_array = whcom_get_current_promo();
            }

            // Checking if promo is expired
            if ($promo_array["startdate"] <> "0000-00-00" && $promo_array["expirationdate"] <> "0000-00-00") {
                if (time() < strtotime($promo_array["startdate"]) || time() > strtotime($promo_array["expirationdate"])) {
                    return false;
                }
            }
            // Checking if promo is usage limit is reached
            if ($promo_array["uses"] > 0 && $promo_array["maxuses"] > 0 && $promo_array["uses"] >= $promo_array["maxuses"]) {
                return false;
            }


            // One Time,Monthly,Quarterly,Semi-Annually,Annually,Biennially,Triennially,
            // 1Years,2Years,3Years,4Years,5Years,6Years,7Years,8Years,9Years,10Years
            $eligible_durations = explode(',', (string)$promo_array["cycles"]);
            $billingcycles = [
                'onetime' => 'One Time',
                'monthly' => 'Monthly',
                'quarterly' => 'Quarterly',
                'semiannually' => 'Semi-Annually',
                'annually' => 'Annually',
                'biennially' => 'Biennially',
                'triennially' => 'Triennially',
            ];
            $eligible_billingcycles = [];
            foreach ($billingcycles as $key => $billingcycle) {
                if (in_array($billingcycles, $eligible_durations)) {
                    $eligible_billingcycles[] = $key;
                }
            }

            $years = [
                '1' => '1Years',
                '2' => '2Years',
                '3' => '3Years',
                '4' => '4Years',
                '5' => '5Years',
                '6' => '6Years',
                '7' => '7Years',
                '8' => '8Years',
                '9' => '9Years',
                '10' => '10Years',
            ];
            $eligible_years = [];
            foreach ($years as $key => $year) {
                if (in_array($year, $eligible_durations)) {
                    $eligible_years[] = $key;
                }
            }


            $eligible_items = explode(',', (string)$promo_array["appliesto"]);

            // Type is product
            if ($type == 'product' && in_array($item, $eligible_items) && (empty($eligible_billingcycles) || in_array($duration, $eligible_billingcycles))) {
                $response = true;
            }
            // Type is addon
            if ($type == 'addon' && in_array('A' . $item, $eligible_items) && (empty($eligible_billingcycles) || in_array($duration, $eligible_billingcycles))) {
                $response = true;
            }
            // Type is domain
            if ($type == 'domain' && in_array('D' . $item, $eligible_items) && (empty($eligible_years) || in_array($duration, $eligible_years))) {
                $response = true;
            }


        }

        return $response;
    }
}

if (!function_exists('whcom_calculate_item_discount')) {
    function whcom_apply_item_discount($price, $setup, $current_discount = [])
    {
        $discount = 0.00;
        if (empty($current_discount)) {
            $current_discount = whcom_get_current_promo();
        }
        if (!empty($current_discount) && is_array($current_discount)) {
            switch ($current_discount['type']) {
                case 'Free Setup' :
                    {
                        $discount = $setup;
                        $setup = 0.00;
                        break;
                    }
                case 'Fixed Amount' :
                    {
                        $discount = (float)$current_discount['value'];
                        $price = $price - $discount;
                        break;
                    }
                case 'Price Override' :
                    {
                        $old_price = $price;
                        $setup = 0.00;
                        $item_price = (float)$current_discount['value'];
                        $discount = $old_price - $item_price;
                        //== To override price
                        $price = $item_price;
                        break;
                    }
                case 'Percentage' :
                    {
                        $per = (float)$current_discount['value'];
                        $item_dis = ($price * $per) / 100;
                        $setup_dis = ($setup * $per) / 100;


                        $price = $price - $item_dis;
                        $setup = $setup - $setup_dis;


                        $discount = $item_dis + $setup_dis;
                        break;
                    }
                default :
                    {

                    }
            }
        }
        if ($price + $setup < 0) {
            $price = 0.00;
            $setup = 0.00;
        }

        return [
            'price' => $price,
            'setup' => $setup,
            'discount' => $discount
        ];
    }
}

if (!function_exists('whcom_apply_item_taxes')) {
    function whcom_apply_item_taxes($item_price_dummy, $domain_price_dummy, $setup_price, $cart_item, $product)
    {

    }
}

if (!function_exists('whcom_render_reset_cart')) {
    function whcom_render_reset_cart()
    {
        ob_start(); ?>
        <form class="whcom_op_reset_cart_form" method="post">
            <input type="hidden" name="action" value="whcom_op">
            <input type="hidden" name="whcom_op_what" value="reset_cart">
            <input type="hidden" name="confirm_string"
                   value="<?php esc_html_e('Are you sure you want to empty the cart?', 'whcom') ?>">
            <div class="">
                <button type="submit" class="whcom_button whcom_button_small">
                    <i class="whcom_icon_trash-1"></i> <?php esc_html_e('Empty Cart', 'whcom') ?></button>
            </div>
        </form>
        <?php
        return ob_get_clean();
    }
}

if (!function_exists('whcom_is_cart_empty')) {
    function whcom_is_cart_empty()
    {
        $cart = whcom_get_cart();
        $cart_items = $cart['all_items'];
        $order = $cart['order_specific'];
        $cart_empty = true;
        if (!empty($order['domainrenewals'])) {
            return false;
        }
        foreach ($cart_items as $cart_item) {
            if ((!empty($cart_item['pid']) && (int)$cart_item['pid'] > 0) || (!empty($cart_item['domain'])) || (!empty($cart_item['addonids']) && !empty($cart_item['addonids']))) {
                $cart_empty = false;
                break;
            }
        }


        return $cart_empty;
    }
}

if (!function_exists('whcom_clear_session_cache')) {
    function whcom_clear_session_cache()
    {
        $_SESSION['whcom_all_tlds'] = [];
        $_SESSION['whcom_all_products'] = [];
        $_SESSION['whcom_cart']['cart_domains'] = [];
        $_SESSION['whcom_cart']['cart_products'] = [];
    }
}

if (!function_exists('whcom_update_cart_domains')) {
    function whcom_update_cart_domains()
    {
        $cart_indexes = (!empty($_POST['cart_indexes']) && is_array($_POST['cart_indexes'])) ? $_POST['cart_indexes'] : [];

        $domain_dnsmanagements = (!empty($_POST['dnsmanagement']) && is_array($_POST['dnsmanagement'])) ? $_POST['dnsmanagement'] : [];
        $domain_idprotections = (!empty($_POST['idprotection']) && is_array($_POST['idprotection'])) ? $_POST['idprotection'] : [];
        $domain_emailforwardings = (!empty($_POST['emailforwarding']) && is_array($_POST['emailforwarding'])) ? $_POST['emailforwarding'] : [];
        foreach ($cart_indexes as $cart_index => $dummy_val) {
            $addons_array = [
                'dnsmanagement' => (!empty($domain_dnsmanagements[$cart_index])) ? '1' : 'to_unset_string',
                'idprotection' => (!empty($domain_idprotections[$cart_index])) ? '1' : 'to_unset_string',
                'emailforwarding' => (!empty($domain_emailforwardings[$cart_index])) ? '1' : 'to_unset_string',
            ];
            whcom_add_update_cart_item($addons_array, $cart_index);
        }


        $domain_fields = (!empty($_POST['domainfields']) && is_array($_POST['domainfields'])) ? $_POST['domainfields'] : [];
        foreach ($domain_fields as $cart_index => $domain_field) {
            whcom_add_update_cart_item(['domainfields' => $domain_field], $cart_index);
        }

        $domain_durations = (!empty($_POST['domainduration']) && is_array($_POST['domainduration'])) ? $_POST['domainduration'] : [];
        foreach ($domain_durations as $cart_index => $domain_duration) {
            whcom_add_update_cart_item(['regperiod' => (int)$domain_duration], $cart_index);
        }

        $domain_epps = (!empty($_POST['eppcode']) && is_array($_POST['eppcode'])) ? $_POST['eppcode'] : [];
        foreach ($domain_epps as $cart_index => $domain_epp) {
            whcom_add_update_cart_item(['eppcode' => $domain_epp], $cart_index);
        }

        $domainns1 = (!empty($_POST['domainns1'])) ? $_POST['domainns1'] : '';
        $domainns2 = (!empty($_POST['domainns2'])) ? $_POST['domainns2'] : '';
        $domainns3 = (!empty($_POST['domainns3'])) ? $_POST['domainns3'] : '';
        $domainns4 = (!empty($_POST['domainns4'])) ? $_POST['domainns4'] : '';
        $domainns5 = (!empty($_POST['domainns5'])) ? $_POST['domainns5'] : '';
        whcom_add_update_cart_item([
            'domainns1' => $domainns1,
            'domainns2' => $domainns2,
            'domainns3' => $domainns3,
            'domainns4' => $domainns4,
            'domainns5' => $domainns5,
        ], 0);
    }
}

