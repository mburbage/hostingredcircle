<?php defined('ABSPATH') or die("Cannot access pages directly.");

function wcap_get_support_depts()
{
    $args = [
        "action" => "GetSupportDepartments",
        "ignore_dept_assignments" => 1,
    ];

    $response = whcom_process_api($args);

    if (isset($response["result"]) && $response["result"] == "success") {
        if (isset($response["departments"]["department"]) && is_array($response["departments"]["department"])) {
            return $response["departments"]["department"];
        } else {
            return [];
        }
    }

    if (isset($response["result"]) && isset($response["message"]) && $response["result"] == "error") {
        return $response["message"];
    }

    return "Unknown error";
}

function wcap_get_security_questions()
{
    $response = whcom_process_helper(['action' => 'security_questions']);

    return $response;

}

function wcap_decrypt_security_questions($args = "")
{
    $default = [
        "security_questions" => "",
    ];

    $args = wp_parse_args($args, $default);
    $args["action"] = "DecryptPassword";
    $args["password2"] = $args["security_questions"];
    unset($args["security_questions"]);

    $response = whcom_process_api($args);

    if (isset($response["result"]) && $response["result"] == "success") {
        return $response["password"];
    }

    if (isset($response["result"]) && isset($response["message"]) && $response["result"] == "error") {
        return $response["error"];
    }

    return "Unknown error";

}


function wcap_get_clients_accounts($args = "")
{
    $default = [
        "action" => "GetContacts",
        "clientid" => "",
        "email" => "",
        "stats" => true,
    ];
    $args = wp_parse_args($args, $default);

    extract($args);

    if ($args["clientid"] == "") {
        unset($args["clientid"]);
    }
    if ($args["email"] == "") {
        unset($args["email"]);
    }

    $response = whcom_process_api($args);

    if (!isset($response["result"])) {
        return print_r($response, true);
    } else if ($response["result"] == "success") {
        return $response;
    } else {
        return $response["message"];
    }
}

function wcap_get_clients_details($args = "")
{
    $default = [
        "action" => "GetClientsDetails",
        "clientid" => "",
        "email" => "",
        "stats" => true,
        "set_currency" => "0",
    ];

    $args = wp_parse_args($args, $default);

    extract($args);

    if ($args["clientid"] == "") {
        unset($args["clientid"]);
    }
    if ($args["email"] == "") {
        unset($args["email"]);
    }


    $response = $_SESSION['specific_client_details'] = whcom_process_api($args);

    if (isset($response["result"]) && $response["result"] == "success") {
        return $response;
    }

    if (isset($response["result"]) && isset($response["message"]) && $response["result"] == "error") {
        return $response["error"];
    }

    return "Unknown error";

}


function wcap_get_ticket($args = "")
{
    $default = [
        "action" => "GetTicket",
        "ticketnum" => "",
        "ticketid" => "",
        "repliessort" => "DESC",
    ];

    $args = wp_parse_args($args, $default);

    $response = whcom_process_api($args);

    if (isset($response["result"]) && $response["result"] == "error") {
        return $response["message"];
    } else {
        return $response;
    }
}

function wcap_get_payment_methods()
{
    $args["action"] = "GetPaymentMethods";

    $response = whcom_process_api($args);


    if (isset($response["result"]) && $response["result"] == "success") {
        if (isset($response["paymentmethods"]["paymentmethod"])) {
            return $response["paymentmethods"]["paymentmethod"];
        }
    }

    if (isset($response["result"]) && $response["result"] == "error") {
        return "Nothing Found";
    }

    return "Unknown error";

}


function wcap_get_client_custom_fields($args = "")
{
    $default = [
        "action" => "whmpress_cart_get_custom_fields",
    ];

    $args = wp_parse_args($args, $default);

    $response = whcom_process_helper($args);

    return $response;

}


function wcap_get_domain_locking_status($args = "")
{

    $default = [
        "domainid" => "",
        "action" => "DomainGetLockingStatus",

    ];

    $args = wp_parse_args($args, $default);
    $res = whcom_process_api($args);

    if (isset($res["lockstatus"])) {
        $response["status"] = "OK";
        $response["data"] = $res["lockstatus"];
    } else {
        $response["status"] = "ERROR";
        $response["error"] = $res["message"];
    }


    return $response;
}

function wcap_get_domain_whois_info($args = "")
{
    $default = [
        "domainid" => "",
        "action" => "DomainGetWhoisInfo",
    ];

    $args = wp_parse_args($args, $default);

//    $xml = new SimpleXMLElement('<contactdetails/>');

    $response = whcom_process_api($args);

    return $response;
}

function wcap_get_domain_nameservers($args = "")
{
    $default = [
        "domainid" => "",
        "action" => "DomainGetNameservers",
    ];

    $args = wp_parse_args($args, $default);

    $response = whcom_process_api($args);

    if (isset($response["ns1"])) {
        $response["status"] = "OK";
        $response["data"] = $response;
    } else {
        $response["status"] = "ERROR";
    }

    return $response;
}

function wcap_get_client_domains($args = "")
{
    $default = [
        /*        "limitstart" => "0",
                "limitnum" => "25",*/
        "action" => "GetClientsDomains",
        "clientid" => "",
        "domainid" => "",
        "domain" => "",
    ];

    $args = wp_parse_args($args, $default);

    extract($args);

    if (empty($args["clientid"])) {
        unset($args["clientid"]);
    }
    if (empty($args["domainid"])) {
        unset($args["domainid"]);
    }
    if (empty($args["domain"])) {
        unset($args["domain"]);
    }

    $response = whcom_process_api($args);

    if (!isset($response["result"])) {
        return "Unknown Error";
    } else if ($response["result"] == "success") {
        return $response;
    }
}

function wcap_get_tickets($args = "")
{

    $default = [
        /*            "limitstart" => "0",
                    "limitnum" => "25",*/
        "action" => "GetTickets",
        "deptid" => "",
        "clientid" => whcom_get_current_client_id(),
        "email" => "",
        "status" => "",
        "subject" => "",
        //"ignore_dept_assignments" => true,
    ];


    $args = wp_parse_args($args, $default);

    extract($args);

    if ($args["deptid"] == "") {
        unset($args["deptid"]);
    }
    if ($args["clientid"] == "") {
        unset($args["clientid"]);
    }
    if ($args["email"] == "") {
        unset($args["email"]);
    }
    if ($args["status"] == "") {
        unset($args["status"]);
    }
    if ($args["subject"] == "") {
        unset($args["subject"]);
    }
    if ($args["ignore_dept_assignments"] == "") {
        unset($args["ignore_dept_assignments"]);
    }

    $response = whcom_process_api($args);

    if (!isset($response["result"])) {
        return print_r($response, true);
    } else if ($response["result"] == "success") {
        if (!isset($response["tickets"]["ticket"])) {
            $response["tickets"]["ticket"] = [];
        }

        return $response;
    } else {
        return $response["message"];
    }
}


function wcap_get_upgradable_products($args = "")
{
    $default = [
        "pid" => "",
    ];

    $args = wp_parse_args($args, $default);
    $rows = wcap_get_whmcs_table_data("name=tblproduct_upgrade_products");
    if ($rows["status"] == "OK") {
        $rows = $rows["data"];
    }
    $pids = [];
    foreach ($rows as $k => $row) {
        if ($row["product_id"] == $args["pid"]) {
            $pids[] = $row["upgrade_product_id"];
        }
    }

    return $pids;

}

function wcap_get_whmcs_table_data($args = "")
{
    $default = [
        "wcap_db_request" => "",
        "action" => "table",
        "name" => "",
    ];

    $args = wp_parse_args($args, $default);

    $response = whcom_process_helper($args);

    return $response;

}

function wcap_get_upgrade_options_status($productid)
{

    $tmp = whcom_get_product_details($productid);

    $return = ($tmp["configoptionsupgrade"] == 1) ? true : false;

    return $return;
}

function wcap_get_products($args = "")
{
    $default = [
        "pid" => "",            // Can be comma separated
        "gid" => "",            // Group ID
        "module" => ""          //
    ];
    $args = wp_parse_args($args, $default);

    $args["action"] = "GetProducts";

    $response = whcom_process_api($args);
    $default_currency = whcom_get_current_currency();


    if (isset($response["result"]) && $response["result"] == "error") {
        return @$response["message"];
    } else if (isset($response["products"]["product"])) {
        $Output["total"] = $response["totalresults"];
        foreach ($response["products"]["product"] as $product) {
            if (isset($product["pricing"]) && is_array($product["pricing"])) {
                $price_array = $price_array2 = $price_setup_array = [];
                foreach ($product["pricing"] as $currency_code => $currency_array) {
                    $price_string = "";
                    if ($currency_array["monthly"] > 0) {
                        $price_array[$currency_code]["monthly"] = $currency_array["prefix"] . $currency_array["monthly"] . " " . trim($currency_array["suffix"]);
                        $price_array2[$currency_code]["monthly"] = $currency_array["monthly"];
                        $price_string = $price_array[$currency_code]["monthly"] . "\n" . esc_html__("Monthly", "whcom");
                    }
                    $price_setup_array[$currency_code]["msetupfee"] = $currency_array["msetupfee"];
                    if ($currency_array["quarterly"] > 0) {
                        $price_array[$currency_code]["quarterly"] = $currency_array["prefix"] . $currency_array["quarterly"] . " " . trim($currency_array["suffix"]);
                        $price_array2[$currency_code]["quarterly"] = $currency_array["quarterly"];
                        if (empty($price_string)) {
                            $price_string = $price_array[$currency_code]["quarterly"] . "\n" . esc_html__("Quarterly", "whcom");
                        }
                    }
                    $price_setup_array[$currency_code]["qsetupfee"] = $currency_array["qsetupfee"];
                    if ($currency_array["semiannually"] > 0) {
                        $price_array[$currency_code]["semiannually"] = $currency_array["prefix"] . $currency_array["semiannually"] . " " . trim($currency_array["suffix"]);
                        $price_array2[$currency_code]["semiannually"] = $currency_array["semiannually"];
                        if (empty($price_string)) {
                            $price_string = $price_array[$currency_code]["semiannually"] . "\n" . esc_html__("Semi Annually", "whcom");
                        }
                    }
                    $price_setup_array[$currency_code]["ssetupfee"] = $currency_array["ssetupfee"];
                    if ($currency_array["annually"] > 0) {
                        $price_array[$currency_code]["annually"] = $currency_array["prefix"] . $currency_array["annually"] . " " . trim($currency_array["suffix"]);
                        $price_array2[$currency_code]["annually"] = $currency_array["annually"];
                        if (empty($price_string)) {
                            $price_string = $price_array[$currency_code]["annually"] . "\n" . esc_html__("Annually", "whcom");
                        }
                    }
                    $price_setup_array[$currency_code]["asetupfee"] = $currency_array["asetupfee"];
                    if ($currency_array["biennially"] > 0) {
                        $price_array[$currency_code]["biennially"] = $currency_array["prefix"] . $currency_array["biennially"] . " " . trim($currency_array["suffix"]);
                        $price_array2[$currency_code]["biennially"] = $currency_array["biennially"];
                        if (empty($price_string)) {
                            $price_string = $price_array[$currency_code]["biennially"] . "\n" . esc_html__("Bi Annually", "whcom");
                        }
                    }
                    $price_setup_array[$currency_code]["bsetupfee"] = $currency_array["bsetupfee"];
                    if ($currency_array["triennially"] > 0) {
                        $price_array[$currency_code]["triennially"] = $currency_array["prefix"] . $currency_array["triennially"] . " " . trim($currency_array["suffix"]);
                        $price_array2[$currency_code]["triennially"] = $currency_array["triennially"];
                        if (empty($price_string)) {
                            $price_string = $price_array[$currency_code]["triennially"] . "\n" . esc_html__("Tri Annually", "whcom");
                        }
                    }
                    $price_setup_array[$currency_code]["tsetupfee"] = $currency_array["tsetupfee"];
                    if ($default_currency == $currency_code) {
                        $product["price_string"] = $price_string;
                    }
                }
                $product["price_info"] = $price_array;
                $product["price_info2"] = $price_array2;
                $product["price_setup_info"] = $price_setup_array;
            }
            $Output[$product["gid"]][] = $product;
        }

        return $Output;
    } else {
        return $response;
    }
}


function wcap_get_invoices($args = "")
{
    $default = [
        "userid" => "",
        "status" => "",
        "action" => "GetInvoices",
        "limitstart" => "0",
        "limitnum" => "9999"
    ];

    $args = wp_parse_args($args, $default);

    extract($args);

    if ($args["userid"] == "") {
        unset($args["userid"]);
    }
    if ($args["status"] == "") {
        unset($args["status"]);
    }

    $response = whcom_process_api($args);

    if (!isset($response["result"])) {
        return print_r($response, true);
    } else if ($response["result"] == "success") {
        if (!isset($response["invoices"]["invoice"])) {
            $response["invoices"]["invoice"] = [];
        }

        return $response;
    } else {
        return $response["message"];
    }
}


function wcap_get_client_payment_method()
{
    $client = whcom_get_current_client();
    if (empty($client["defaultgateway"])) {
        $payment_methods = wcap_get_payment_methods();

        return empty($payment_methods[0]["module"]) ? "" : $payment_methods[0]["module"];
    }

    return $client["defaultgateway"];
}


function wcap_get_affiliate($affiliate_id)
{
    $args = [
        "userid" => $affiliate_id,
        "action" => "GetAffiliates",
    ];

    $response = whcom_process_api($args);

    if (!isset($response["result"])) {
        return $response;
    } else {
        return $response;
    }
}


function wcap_service_pending_invoice($user_id, $service_id)
{
    $invoice_pending = "";

    $args = [
        "userid" => $user_id,
        "status" => "Unpaid",
    ];

    $response = wcap_get_invoices($args);
    foreach ($response["invoices"]["invoice"] as $invoice) {

        $invoice_items = wcap_get_invoice($invoice["id"]);

        foreach ($invoice_items["items"]["item"] as $item) {

            $invoice_pending = ((int)($item["relid"]) == (int)$service_id) ? true : false;
            if ($invoice_pending) {
                break;
            }
        }
        if ($invoice_pending) {
            break;
        }
    }

    return $invoice_pending;
}

function wcap_get_invoice($invoice_id)
{
    $args = [
        "invoiceid" => $invoice_id,
        "action" => "GetInvoice",
    ];

    $response = whcom_process_api($args);

    if (!isset($response["result"])) {
        return $response;
    } else {
        return $response;
    }
}


function wcap_updowngrade_options($args = "")
{
    $default = [
        "serviceid" => "",
        "calconly" => "1",
        "paymentmethod" => "",
        "type" => "configoptions",
        "configoptions" => [],
    ];

    $args = wp_parse_args($args, $default);

    if ($args["calconly"] == "1") {
        $args["calconly"] = true;
    } else {
        $args["calconly"] = false;
    }
    $args["action"] = "UpgradeProduct";


    $res = whcom_process_api($args);

    $response = [
        'status' => 'ERROR',
        'errors' => [],
        'message' => esc_html__("Something Went Wrong", "whcom"),
    ];

    if (!empty($res["error"])) {
        $title = esc_html__("Error", "whcom");
        $response["message"] = wcap_render_message($title, $res["error"], "danger");
    } else if (isset($res["result"]) && $res["result"] == "success") {
        $response["status"] = "OK";
        $response["response"] = $res;
        $message = esc_html__("Please wait while you are redirected to the gateway you chose to make payment...", "whcom");
        $response["message"] = wcap_render_message("", $message, "success");
    } else {
        $response["errors"] = $response;
    }


    if ($args["calconly"]) {
        return $res;
    } else {
        return json_encode($response);
    }


}


function wcap_updowngrade_service($args = "")
{
    $default = [
        "serviceid" => "",
        "calconly" => "1",
        "paymentmethod" => "",
        "type" => "product",
        "newproductid" => "",
        "newproductbillingcycle" => "",
        "promocode" => "",
        "configoptions" => [],
    ];

    $args = wp_parse_args($args, $default);
    if ($args["calconly"] == "1") {
        $args["calconly"] = true;
    } else {
        $args["calconly"] = false;
    }
    $args["action"] = "UpgradeProduct";

    $res = whcom_process_api($args);

    $response = [
        'status' => 'ERROR',
        'errors' => [],
        'message' => esc_html__("Something Went Wrong", "whcom"),
    ];

    if (isset($res["result"]) && $res["result"] == "error") {
        $title = esc_html__("Error", "whcom");
        $response["message"] = wcap_render_message($title, $res["message"], "danger");
    } else if (isset($res["result"]) && $res["result"] == "success") {
        $response["status"] = "OK";
        if (!empty($res['invoiceid'])) {


            $response['status'] = 'OK';
            $response['message'] = esc_html__('Your product has been ordered...');
            $response['redirect_link'] = $response['response_form'] = $response['invoice_link'] = $response['show_cc'] = '';
            $field = 'order_complete_redirect' . whcom_get_current_language();
            if (url_to_postid(esc_attr(get_option($field))) > '0') {
                $response['redirect_link'] = '<a href="' . esc_attr(get_option($field)) . '" class="whcom_button">' . esc_html__('Dashboard', 'whcom') . '</a> ';
                $ca_url_set = 'yes';
            }


            $response['redirect_link'] = '<a href="?whmpca=dashboard" class="whcom_button">' . esc_html__('Dashboard', 'whcom') . '</a> ';

            # Generate AutoAuth URL & Redirect
            $args = [
                'goto' => "viewinvoice.php?wcap_no_redirect=1&id=" . $res['invoiceid'],
            ];
            $url = whcom_generate_auto_auth_link($args);

            // todo: to be changed
            $order_complete_url = get_option('wcapfield_client_area_url' . whcom_get_current_language(), '?whmpca=dashboard');


            if (get_option('wcapfield_show_invoice_as', 'popup') == 'popup') {
                $redirect_link = '<a class="whcom_op_thickbox_redirect_overlay" href="' . $order_complete_url . '">' . esc_html__('Close', 'whcom') . '</a> ';
                $invoice_div = '<div id="invoice_' . $res['invoiceid'] . '" style="display:none;"><iframe style="width: 100%; height: 100%; overflow: auto;" src="' . $url . '"></iframe>' . $redirect_link . '</div>';
                $invoice_anchor = '<a href="#TB_inline?width=1050&height=550&inlineId=invoice_' . $res['invoiceid'] . '" class="thickbox whcom_button whcom_op_view_invoice_button">' . esc_html__('View Invoice', 'whcom') . '</a> ';
                $response['invoice_link'] = $invoice_anchor . $invoice_div;
                $response['show_cc'] = 'show_invoice';
            } else {
                $response['invoice_link'] = '<a target="_blank" href="?whmpca=viewinvoice&id=' . $res['invoiceid'] . '" class="whcom_button wcop_view_invoice_button">' . esc_html__('View Invoice', "whcom") . '</a> ';
            }

            ob_start(); ?>
            <div style="padding: 6%; max-width: 680px; margin: 0 auto 40px">

                <div class="whcom_alert whcom_alert_success whcom_margin_bottom_45">
                    <span><?php esc_html_e("Your order has been placed, it will be activated once the invoice is paid. If you have just paid the invoice, ignore this message", "whcom"); ?> </span>
                </div>

                <div class="whcom_row">
                    <div class="whcom_col_sm_6 whcom_text_center whcom_text_right_sm whcom_margin_bottom_15">
                        <?php echo $response['redirect_link']; ?>
                    </div>
                    <div class="whcom_col_sm_6 whcom_text_center whcom_text_left_sm whcom_margin_bottom_15">
                        <?php echo $response['invoice_link']; ?>
                    </div>
                </div>

            </div>

            <?php
            $response['message'] = ob_get_clean();


        } else {
            $message = esc_html__("Please wait while you are redirected to the gateway you chose to make payment...", "whcom");
            $response["message"] = wcap_render_message("", $message, "success");
        }

        $response ["response"] = $res;

    } else {
        $response["errors"] = $response;
    }


    if ($args["calconly"]) {
        return $res;
    } else {
        return json_encode($response);
    }


}


function wcap_get_announcements()
{
    $args = [
        "action" => "GetAnnouncements",
    ];

    $response = whcom_process_api($args);

    return $response;
}


function wcap_get_countries()
{
    $countries = [
        'AF' => 'Afghanistan',
        'AX' => 'Aland Islands',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua And Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BA' => 'Bosnia And Herzegovina',
        'BW' => 'Botswana',
        'BV' => 'Bouvet Island',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory',
        'BN' => 'Brunei Darussalam',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CA' => 'Canada',
        'CV' => 'Cape Verde',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos (Keeling) Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros',
        'CG' => 'Congo',
        'CD' => 'Congo, Democratic Republic',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'CI' => 'Cote D\'Ivoire',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DK' => 'Denmark',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands (Malvinas)',
        'FO' => 'Faroe Islands',
        'FJ' => 'Fiji',
        'FI' => 'Finland',
        'FR' => 'France',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernsey',
        'GN' => 'Guinea',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HM' => 'Heard Island & Mcdonald Islands',
        'VA' => 'Holy See (Vatican City State)',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran, Islamic Republic Of',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IM' => 'Isle Of Man',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'KR' => 'Korea',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LA' => 'Lao People\'s Democratic Republic',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libyan Arab Jamahiriya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macao',
        'MK' => 'Macedonia',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Mexico',
        'FM' => 'Micronesia, Federated States Of',
        'MD' => 'Moldova',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'ME' => 'Montenegro',
        'MS' => 'Montserrat',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NL' => 'Netherlands',
        'AN' => 'Netherlands Antilles',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territory, Occupied',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'RE' => 'Reunion',
        'RO' => 'Romania',
        'RU' => 'Russian Federation',
        'RW' => 'Rwanda',
        'BL' => 'Saint Barthelemy',
        'SH' => 'Saint Helena',
        'KN' => 'Saint Kitts And Nevis',
        'LC' => 'Saint Lucia',
        'MF' => 'Saint Martin',
        'PM' => 'Saint Pierre And Miquelon',
        'VC' => 'Saint Vincent And Grenadines',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome And Principe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia And Sandwich Isl.',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard And Jan Mayen',
        'SZ' => 'Swaziland',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syrian Arab Republic',
        'TW' => 'Taiwan',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania',
        'TH' => 'Thailand',
        'TL' => 'Timor-Leste',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad And Tobago',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks And Caicos Islands',
        'TV' => 'Tuvalu',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States',
        'UM' => 'United States Outlying Islands',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VE' => 'Venezuela',
        'VN' => 'Viet Nam',
        'VG' => 'Virgin Islands, British',
        'VI' => 'Virgin Islands, U.S.',
        'WF' => 'Wallis And Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
    ];

    return $countries;
}


function wcap_ticket_status_color($status = "")
{

    $map = [
        "open" => "success",
        "closed" => "notice",
        "customer-reply" => "danger",
    ];

    return $map[strtolower($status)];

}

function wcap_date($date, $format = "")
{
    if (empty($format)) {
        $format = get_option("date_format");
    }

    return date($format, strtotime($date));
}


function wcap_datetime($date, $format = "")
{
    if (empty($format)) {
        $format = get_option("date_format") . " " . get_option("time_format");
    }

    return date($format, strtotime($date));
}

function wcap_time($date, $format = "")
{
    if (empty($format)) {
        $format = get_option("time_format");
    }

    return date($format, strtotime($date));
}


function wcap_date_ml($date, $format = "")
{
    $date = str_replace('/', '-', $date);
    $date = strtotime($date);

    return date_i18n(get_option('date_format'), $date);

}

function wcap_datetime_ml($date, $format = "")
{

    if (empty($format)) {
        $format = "%B %e, %G";
    }

    $locale = wcap_get_current_language() . '.UTF-8';
    setlocale(LC_TIME, $locale);

    return strftime($format, $date);
}

function wcap_status_ml($status)
{
    $status = trim(strtolower($status));

    $status_t = [
        "active" => esc_html__("Active", "whcom"),
        "completed" => esc_html__("Completed", "whcom"),
        "pending" => esc_html__("Pending", "whcom"),
        "suspended" => esc_html__("Suspended", "whcom"),
        "terminated" => esc_html__("Terminated", "whcom"),
        "cancelled" => esc_html__("Cancelled", "whcom"),
        "paid" => esc_html__("Paid", "whcom"),
        "unpaid" => esc_html__("Unpaid", "whcom"),
        "refunded" => esc_html__("Refunded", "whcom"),
        "delivered" => esc_html__("Delivered", "whcom"),
        "accepted" => esc_html__("Accepted", "whcom"),
        "expired" => esc_html__("Expired", "whcom"),
        "open" => esc_html__("Open", "whcom"),
        "answered" => esc_html__("Answered", "whcom"),
        "customer-reply" => esc_html__("Customer-Reply", "whcom"),
        "closed" => esc_html__("Closed", "whcom"),

    ];

    return (isset($status_t[$status])) ? $status_t[$status] : $status;

}


function wcap_yesno($var)
{

    if ((bool)trim($var)) {
        return esc_html__("Yes", "whcom");
    } else {
        return esc_html__("No", "whcom");
    }
}

function wcap_ed($var)
{
    if ($var) {
        return esc_html__("Disabled", "whcom");
    } else {
        return esc_html__("Enabled", "whcom");
    }
}


function wcap_validate_reset_password_url($args = "")
{
    $default = [
        "token" => "",
        "email" => "",
    ];
    $args = wp_parse_args($args, $default);

    return password_verify($args["email"] . date("dMY"), $args["token"]);
}

function wcap_get_login_redirect_url()
{
    //the function will return redirect URL according to current language, and default if nothing found
    //empty(get_option("wcapfield_after_login_redirect_url")) ? 0 : get_option("wcapfield_after_login_redirect_url");
    $url_option = "wcapfield_after_login_redirect_url" . whcom_get_current_language();

    return get_option($url_option);
}

function wcap_render_invoice_popup($url, $redirect_link, $invoice_id)
{

    $redirect_link = '<a class="whcom_op_thickbox_redirect_overlay" href="' . $redirect_link . '">' . esc_html__('Close', 'whcom') . '</a> ';

    $invoice_div = '<div id="invoice_' . $invoice_id . '" style="display:none;"><iframe style="width: 100%; height: 100%; overflow: auto;" src="' . $url . '"></iframe>' . $redirect_link . '</div>';
    $invoice_anchor = '<a href="#TB_inline?width=1050&height=550&inlineId=invoice_' . $invoice_id . '" class="thickbox whcom_button whcom_op_view_invoice_button">' . esc_html__('View Invoice', 'whcom') . '</a> ';
    $response = $invoice_anchor . $invoice_div;

    return $response;
}

function wcap_render_message($title, $message, $type)
{
    $class = ($type == "") ? '' : 'whcom_alert whcom_alert_' . $type . '"';
    $html = '<div class="whcom_margin_bottom_15 ' . $class . '">';


    If (trim($title) != "") {
        $html .= '<div class="whcom_margin_bottom_15"> ' . $title . ' </div>';
    }


    if (is_array($message)) {
        $html .= '<ul class="whcom_list_padded_narrow">';
        foreach ($message['errors'] as $error) {
            $message['message'] .= '<li>' . $error . '</li>';
        }
        $message['message'] .= '</ul>';
    } else {
        $html .= '<div> ' . $message . ' </div>';
    }
    $html .= '</div>';

    return $html;
}

function wcap_render_button($title, $page, $href, $type, $icon = "", $icon_left = false)
{
    $class = ($type == "") ? 'whcom_button' : 'whcom_button whcom_button_' . $type . '"';
    $href = (trim($href) == "") ? "" : $href;
    $icon = ($icon = !"") ? 'whcom_icon_' . $icon : "";
    ?>
    <a class="wcap_load_page <?php echo $class ?>"
       data-page="<?php echo $page ?>"
       href="<?php echo $href ?>">
        <?php echo ($icon_left == true & $icon <> "") ? "<i class=" . $icon . "</i>" : ""; ?>
        <?php echo $title ?>
        <?php echo ($icon_left == false & $icon <> "") ? "<i class=" . $icon . "</i>" : ""; ?>

    </a>
    <?php
}

function wcap_render_continue_button($page, $href)
{
    $html = '<a class="wcap_load_page" data-page="' . $page . '"';
    $html .= '<button class="whcom_button whcom_button_secondary>';
    $html .= 'href="' . $href . '">' . esc_html__("Continue", "whcom") . ' <i class="whcom_icon_right-circled" </i>';
    $html .= '</button></a>';

    return $html;
}


function wcap_render_back_button($page, $href)
{

    $html = '<a class="wcap_load_page" data-page="' . $page . '"' . ' href="' . $href . '">';
    $html .= '<button class="whcom_button whcom_button_secondary">';
    $html .= '<i class="whcom_icon_left-circled"></i>';
    $html .= ' ' . esc_html__("Back", "whcom");
    $html .= '</button></a>';

    return $html;
}


function wcap_render_back_to_dashboard_button()
{
    ?>
    <div class="whcom_text_center">
        <button class="whcom_button whcom_button_secondary wcap_load_page" data-page="dashboard">
            <i class="whcom_icon_angle-circled-left"></i> <?php esc_html_e("Return to Client Area", "whcom"); ?>
        </button>
    </div>

    <?php
}


function wcap_cc_saveable()
{
    $saveable = false;
    $active_gateways = whcom_get_payment_gateways();
    if ($active_gateways["status"] == "OK") {
        foreach ($active_gateways["payment_gateways"] as $gateway) {
            $type = wcap_payment_gateway_type($gateway["module"]);
            if ($type == "m" || $type == "t") {
                $saveable = true;
            }

        }
    }

    return $saveable;

}


function wcap_payment_gateway_type($gateway)
{
    $gateway_array =
        [
            "asiapay" => "m",
            "authorize" => "m",
            "bluepay" => "m",
            "camtech" => "m",
            "cyberbit" => "m",
            "ematters" => "m",
            "eprocessingnetwork" => "m",
            "fasthosts" => "m",
            "imsp" => "m",
            "ippay" => "m",
            "kuveytturk" => "m",
            "linkpoint" => "m",
            "merchantpartners" => "m",
            "mwarrior" => "m",
            "moneris" => "m",
            "navigate" => "m",
            "netbilling" => "m",
            "netregistrypay" => "m",
            "offlinecc" => "m",
            "optimalpayments" => "m",
            "payjunction" => "m",
            "payflowpro" => "m",
            "paypalpaymentspro" => "m",
            "planetauthorize" => "m",
            "psigate" => "m",
            "quantumgateway" => "m",
            "sagepayrepeats" => "m",
            "secpay" => "m",
            "securepay" => "m",
            "securepayau" => "m",
            "securetrading" => "m",
            "trustcommerce" => "m",
            "usaepay" => "m",
            "worldpayinvisible" => "m",
            "worldpayinvisiblexml" => "m",

            "acceptjs" => "t",
            "authorizecim" => "t",
            "bluepayremote" => "t",
            "ewaytokens" => "t",
            "monerisvault" => "t",
            "paypalpaymentsproref" => "t",
            "quantumvault" => "t",
            "sagepaytokens" => "t",
            "stripe" => "t",
            "worldpayfuturepay" => "t",


            "tco" => "tp",
            "amazonsimplepay" => "tp",
            "authorizeecheck" => "tp",
            "banktransfer" => "tp",
            "bluepayecheck" => "tp",
            "boleto" => "tp",
            "cashu" => "tp",
            "ccavenue" => "tp",
            "ccavenuev2" => "tp",
            "chronopay" => "tp",
            "f2b" => "tp",
            "directdebit" => "tp",
            "eonlinedata" => "tp",
            "epath" => "tp",
            "eeecurrency" => "tp",
            "paymentsgateway" => "tp",
            "gate2shop" => "tp",
            "mollieideal" => "tp",
            "inpay" => "tp",
            "mailin" => "tp",
            "moipapi" => "tp",
            "nochex" => "tp",
            "pagseguro" => "tp",
            "paymateau" => "tp",
            "paymatenz" => "tp",
            "paymentexpress" => "tp",
            "ntpnow" => "tp",
            "paymex" => "tp",
            "paypal" => "tp",
            "paypalexpress" => "tp",
            "paypoint" => "tp",
            "payson" => "tp",
            "payza" => "tp",
            "protx" => "tp",
            "protxvspform" => "tp",
            "skrill" => "tp",
            "moneybookers" => "tp",
            "slimpay" => "tp",
            "finansbank" => "tp",
            "garantibank" => "tp",
            "worldpay" => "tp",

        ];
    $type = (isset($gateway_array[$gateway])) ? $gateway_array[$gateway] : "tp";

    return $type;
}

function wcap_get_domain_epp_code($domain_id)
{

    $args ["domainid"] = $domain_id;
    $args["action"] = "DomainRequestEPP";

    $res = whcom_process_api($args);

    $response = [
        'status' => 'ERROR',
        'errors' => [],
        'message' => esc_html__("Something Went Wrong", "whcom"),
    ];

    if (!empty($res["error"])) {
        $response["message"] = $res["error"];
    } else if (isset($res["eppcode"])) {
        $response["status"] = "OK";
        $response["message"] = $res["eppcode"];
    } else {
        $response["errors"] = $response;
    }

    return $response;
}


function wcap_page_info($page)
{
    $W = new WCAP();

    $show = true;
    $href = "#";
    $class = "";
    $page_ = "";
    $label = "";
    $url = "";

    $menu_settings = get_option("wcapfield_hide_whmcs_menu_sections");
    $menu = $W->get_menu_array();
    //wcap_ppa($menu);
//    wcap_ppa($menu_settings);

    $menu_a = ($menu_settings == "") ? [] : $menu_settings;


    $index = wcap_map_submenu($page);
    if ((int)$index <= 0) {
        $index = substr($index, 1);
        $label = $menu[$index]['label'];
        $page_ = $menu[$index]['page'];
        $class = $menu[$index]['class'];
        $icon = $menu[$index]['icon'];
        $href = $menu[$index]['href'];
        $show = $menu[$index]['show'];


        if (isset($menu_a[$index]['hide']) && $menu_a[$index]['hide'] == 'hide') {
            $show = false;
        }

        if (isset($menu_a[$index]['[url_override]']) && $menu_a[$index]['[url_override]'] != '') {
            $url = $menu_a[$index]['[url_override]'];
        }
    } else {

        $label = $menu[$index]['sub'][$page]['label'];
        $page_ = $menu[$index]['sub'][$page]['page'];
        $class = $menu[$index]['sub'][$page]['class'];
        $icon = $menu[$index]['sub'][$page]['icon'];
        $href = $menu[$index]['sub'][$page]['href'];
        $show = $menu[$index]['sub'][$page]['show'];


        if (isset($menu_a[$index]['sub'][$page]['hide']) && $menu_a[$index]['sub'][$page]['hide'] == 'hide') {
            $show = false;
        }

        if (isset($menu_a[$index]['sub'][$page]['url_override']) && $menu_a[$index]['sub'][$page]['url_override'] != '') {
            $url = $menu_a[$index]['[url_override]'];
        }

    }

    $class = ($url == "") ? "wcap_load_page" : "";
    $href = ($url == "") ? $href : $url;
    $href = ($href == "") ? "#" : $href;

    $page = [
        "show" => $show,
        "href" => $href,
        "class" => $class,
        "page" => $page_,
        "label" => $label,
        "icon" => $icon,
    ];

    return $page;

}


function wcap_render_sidebar_li($link)
{
    $output = ' <li>';
    $output .= '<a class="' . $link['class'] . '"';
    $output .= 'data-page="' . $link['page'] . '"';
    $output .= 'href="' . $link['href'] . '">';
    $output .= $link['label'];
    $output .= '</a>';
    $output .= '<i class="' . $link['icon'] . '"></i>';
    $output .= '</li>';

    return $output;
}

function wcap_render_sidebar_cart_li()
{
    $m = [
        "show" => true,
        "href" => "a=view",
        "class" => "wcap_load_page",
        "page" => "order_process",
        "label" => esc_html__('View Cart', "whcom"),
        "icon" => "whcom_icon_basket",
    ];

    return wcap_render_sidebar_li($m);

}


function wcap_map_submenu($page)
{

    $logged_in = whcom_is_client_logged_in();


    if ($logged_in) {
        $map = [
            "home" => "-0",

            "services" => "-10",
            "my_services" => "10",
            "my_services_seprator" => "10",
            "order_new_services" => "10",
            "addons" => "10",

            "domains" => "-20",
            "my_domains" => "20",
            "seprator" => "20",
            "domain_renewals" => "20",
            "domain_register" => "20",
            "domain_transfer" => "20",

            "billing" => "-30",
            "my_invoices" => "30",
            "my_quotes" => "30",
            "mass_pay" => "30",


            "support" => "-40",
            "tickets" => "40",
            "announcements" => "40",
            "knowledgebase" => "40",
            "downloads" => "40",
            "network_status" => "40",

            "openticket" => "-50",

            "affiliates" => "-60",

            "account" => "-70",
            "edit_account_details" => "70",
            "credit_card" => "70",
            "contacts_subaccounts" => "70",
            "change_password" => "70",
            "security_settings" => "70",
            "email_history" => "70",
            "seprator" => "70",
            "logout" => "70",
        ];
    }
    if (!($logged_in)) {
        $map = [
            "home" => "-0",
            "store" => "-10",
            "announcements" => "-20",
            "knowledgebase" => "-30",
            "network_status" => "-40",
            "contact" => "-50",

            "account" => "-70",
            "login" => "70",
            "create_client_account" => "70",
            "password_reset" => "70",

        ];


    }

    if (isset($map[$page])) {
        return $map[$page];
    } else {
        return -1;
    }
}


function wcap_translate_api_respone($str)
{


    $arr = [

        "Email or Password Invalid" => esc_html__("Email or Password Invalid", "whcom"),
        "You did not enter the card expiry date" => esc_html__("You did not enter the card expiry date", "whcom"),
        "The expiry date must be entered in the format MM/YY and must not be in the past" => esc_html__("The expiry date must be entered in the format MM/YY and must not be in the past", "whcom"),


    ];

    foreach ($arr as $key => $trans) {
        if ($key == $str) {
            $str = $trans;
        }
    }

    return $str;

}

function wcap_get_invoice_link($url, $invoice_id)
{
    if (get_option('wcapfield_show_invoice_as', 'popup') == 'minimal') {
        $invoice_link = '<a href="' . $url . '" class="whcom_button wcop_view_invoice_button">' . esc_html__('View Invoice', "whcom") . '</a> ';
    } else if (get_option('wcapfield_show_invoice_as', 'popup') == 'same_tab') {
        $invoice_link = '<a href="?whmpca=order_process&a=viewinvoice&id=' . $invoice_id . '" class="whcom_button wcop_view_invoice_button">' . esc_html__('View Invoice', "whcom") . '</a> ';
    } else if (get_option('wcapfield_show_invoice_as', 'popup') == 'new_tab') {
        $invoice_link = '<a target="_blank" href="?whmpca=order_process&a=viewinvoice&id=' . $invoice_id . '" class="whcom_button wcop_view_invoice_button">' . esc_html__('View Invoice', "whcom") . '</a> ';
    } else {
        $redirect_link = '<a class="whcom_op_thickbox_redirect_overlay" href="' . $order_complete_url . '">' . esc_html__('Close', 'whcom') . '</a> ';
        $invoice_div = '<div id="invoice_' . $invoice_id . '" style="display:none;"><iframe style="width: 100%; height: 100%; overflow: auto;" src="' . $url . '"></iframe>' . $redirect_link . '</div>';
        $invoice_anchor = '<a href="#TB_inline?width=1050&height=550&inlineId=invoice_' . $invoice_id . '" class="thickbox whcom_button whcom_op_view_invoice_button">' . esc_html__('View Invoice', 'whcom') . '</a> ';
        $invoice_link = $invoice_anchor . $invoice_div;
    }

    return $invoice_link;

}

function temp1()
{
    /*
    todo: need to make a generic java script funcion, test with update contacts
    final response paramter for ajax

            status = OK, ERROR
            message = compiled message for display
            errors = any errors/ checks generated by us
            response = any additions resposne by us
            api_response = raw api response
            action_dont_hide = YES, if you dont want to hide div
            action_refresh = YES, if  you want to refresh the page

        */

}


// Verify Purchase Code

function wcap_verify_purchase()
{
    $verify_action = (!empty($_POST) && !empty($_POST['verify_action'])) ? esc_attr($_POST['verify_action']) : '';
    if ($verify_action == 'verify') {
        echo wcap_verify_purchase_function($_POST);
    } else if ($verify_action == 'un_verify') {
        echo wcap_un_verify_purchase_function($_POST);
    } else {
        echo esc_html__('Incorrect Information', 'whcom');
    }
    die();
}

add_action('wp_ajax_wcap_verify_purchase', 'wcap_verify_purchase');

if (!function_exists('is_wcap_verified')) {
    function is_wcap_verified()
    {
        //echo get_option( "wcap_registration_status", 'no' );
        return strtolower(get_option("wcap_registration_status", 'no')) == "yes";
    }
}

if (!function_exists('wcap_verify_purchase_function')) {
    function wcap_verify_purchase_function($vars = [])
    {
        $url = "http://plugins.creativeon.com/envato/";

        $vars["registered_url"] = parse_url(get_bloginfo("url"), PHP_URL_HOST);
        if ($vars["registered_url"] == "") {
            $vars["registered_url"] = parse_url(get_bloginfo("url"), PHP_URL_PATH);
        }
        $vars["registered_url"] = str_replace("www.", "", $vars["registered_url"]);

        $vars["item_name"] = "WHMCS Client Area for WordPress by WHMpress";
        $vars["version"] = WHCOM_VERSION;

        if (!isset($vars["email"])) {
            $vars["email"] = get_option("wcap_registration_email");
        }
        if ($vars["email"] == "") {
            $vars["email"] = get_option("admin_email");
        }

        if (!isset($vars["purchase_code"])) {
            $vars["purchase_code"] = get_option("wcap_registration_code");
        }
        $vars["registered_url"] = 'wordpress.dev';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_POST, count($vars));
        #curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        #curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = $vars;
        if (is_array($vars)) {
            $vars = http_build_query($vars);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $output = curl_exec($ch);

        if ($errno = curl_errno($ch)) {
            $error_message = curl_error($ch);

            return "cURL error:\n {$error_message}<br />Fetching: $url";
        }

        if ($output == "OK") {
            update_option("wcap_registration_code", $data["purchase_code"]);
            update_option("wcap_registration_email", $data["email"]);
            update_option("wcap_registration_status", "yes");
        } else {
            update_option("wcap_registration_status", "no");
        }

        return $output;
    }
}

if (!function_exists('wcap_un_verify_purchase_function')) {
    function wcap_un_verify_purchase_function($vars = [])
    {
        $url = "http://plugins.creativeon.com/envato/unverify.php";
        $vars["purchase_code"] = get_option("wcap_registration_code");
        $vars["email2"] = get_option("wcap_registration_email");
        $vars["registered_url"] = parse_url(get_bloginfo("url"), PHP_URL_HOST);
        $vars["registered_url"] = str_replace("www.", "", $vars["registered_url"]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        #curl_setopt($ch, CURLOPT_COOKIE, $cookies);
        curl_setopt($ch, CURLOPT_POST, count($vars));
        #curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        #curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = $vars;
        if (is_array($vars)) {
            $vars = http_build_query($vars);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $output = curl_exec($ch);

        if ($output == "OK") {
            update_option("wcap_registration_code", '');
            update_option("wcap_registration_email", '');
            update_option("wcap_registration_status", "no");
        }

        echo $output;
    }
}

if (!function_exists('wcap_verification_notice')) {
    function wcap_verification_notice()
    {

        if (!is_wcap_verified()) {
            $class = 'notice notice-error';
            $message = esc_html__('Your copy of WHMCS Client Area API (WCAP) is not verified.', 'whcom');
            $link = esc_html__('Please verify your copy of WCAP', 'whcom');
            $url = admin_url('admin.php?page=wcap');
            printf('<div class="%1$s"><p>%2$s <a href="%3$s">%4$s</a></p></div>', $class, $message, $url, $link);
        }
    }

    add_action('admin_notices', 'wcap_verification_notice');
}

if (!function_exists('wcap_url_notice')) {
    function wcap_url_notice()
    {
        $order_url = get_option('wcapfield_client_area_url' . whcom_get_current_language(), '');

        if (empty($order_url)) {
            $class = 'notice notice-warning';
            $message = esc_html__('Paste the Client Area short-code page URL in settings.', 'whcom');
            $link = esc_html__('Click Here to paste URL', 'whcom');
            $url = admin_url('admin.php?page=wcap-settings');
            printf('<div class="%1$s"><p>%2$s <a href="%3$s">%4$s</a></p></div>', $class, $message, $url, $link);
        }
    }

    add_action('admin_notices', 'wcap_url_notice');
}

if (!function_exists('wcap_verify_client')) {
    function wcap_verify_client()
    {
        $message = '';
        if (whcom_is_client_logged_in() && !empty($_REQUEST['verificationId']) && !empty(esc_attr($_REQUEST['verificationId']))) {
            $client_id = whcom_get_current_client_id();
            $code = esc_attr($_REQUEST['verificationId']);

            $code_details = whcom_process_helper([
                'action' => 'whcom_validate_email_verification_code',
                'verification_code' => $code,
                'clientid' => $client_id,
            ]);

            if (is_string($code_details['data'])) {
                if ($code_details['data'] == 'verified') {
                    $message = '<div class="whcom_alert whcom_alert_success">';
                    $message .= esc_html__('Thank you for confirming your email address.', 'whcom');
                    $message .= '</div>';
                } else if ($code_details['data'] != 'already-verified') {
                    $message = '<div class="whcom_alert whcom_alert_danger">';
                    $message .= esc_html__('This email verification key has expired.', 'whcom');
                    $message .= '</div>';
                }
            } else {
                $message = '<div class="whcom_alert whcom_alert_success">';
                $message .= esc_html__('Thank you for confirming your email address.', 'whcom');
                $message .= '</div>';
            }
        }

        // This email verification key has expired. Please request a new one.


        return $message;
    }
}

if (!function_exists('wcap_verify_client_check')) {
    function wcap_verify_client_check()
    {
        $client_id = whcom_get_current_client_id();
        $response = whcom_process_helper([
            "action" => "whcom_validate_email_check",
            'clientid' => $client_id,
        ]);
        if (get_option("whcom_email_verification_message") == "yes" && $response['data'] == 'not-verified') {
            $message = '<div class="whcom_alert whcom_alert_warning">';
            $message .= esc_html__('Please check your email and follow the link to verify your email address.', 'whcom');
            $message .= '</div>';
        }
        return $message;
    }
}

if (!function_exists('wcap_generate_whois_content')) {
    function wcap_generate_whois_content($domain = '')
    {

        $html = '';
        if ($domain != "") {
            include_once(WCAP_PATH . "/library/wcapwhois.class.php");
            $whois = new WcapWhois();
            $domain = ltrim($domain, '//');
            if (substr(strtolower($domain), 0, 7) == "http://") {
                $domain = substr($domain, 7);
            }
            if (substr(strtolower($domain), 0, 8) == "https://") {
                $domain = substr($domain, 8);
            }
            $domain = "http://" . $domain;
            $domain = parse_url($domain);
            if (strtolower(substr($domain["host"], 0, 4)) == "www.") {
                $domain["host"] = substr($domain["host"], 4);
            }
            if (strtolower(substr($domain["host"], 0, 3)) == "ww.") {
                $domain["host"] = substr($domain["host"], 3);
            }

//            $domain["extension"] = whmp_get_domain_extension( $domain["host"] );
//            if ( $domain["extension"] == "" ) {
//                $domain["host"] .= ".com";
//                $domain["extension"] = "com";
//            }
//            $html = $whois->whoislookup( $domain["host"], $domain["extension"], true );
        }

        return '<pre>' . $html . '</pre>';
    }

//todo: Implement VC and Fusion Builder Array in a better way
    function get_shortcode_parameters($shortcode)
    {

        switch ($shortcode) {

            case "whmcs_client_area":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WCAP Client Area", "whcom"),
                    ),
                    "params" => array(
                        array(
                            "type" => "textfield",
                            "heading" => __("No Parameter", "whcom"),
                            "param_name" => "default",
                            "value" => __("", "whcom"),
                            "description" => __("Displays the WHMCS Client Area. It takes no necessary parameters to work by default,  Settings are controlled by admin area settings. For optional advanced parameters, use advanced tab.", "whcom")
                        ),
                        array(
                            "type" => "textfield",
                            "heading" => __("Currency ID", "whcom"),
                            "group" => "Advance",
                            "param_name" => "currency",
                            "value" => __("", "whcom"),
                            "description" => __("Used with multi-currency, set the Currency in which price is displayed, if not mentioned session currency is used (which user have selected), if no session is found, currency set as default in WHMCS is used.", "whcom")
                        ),
                        array(
                            "type" => "textfield",
                            "heading" => __("Promocode", "whcom"),
                            "group" => "Advance",
                            "param_name" => "promocode",
                            "value" => __("", "whcom"),
                            "description" => __("This will take promocode and apply on final invoice automatically.", "whcom")
                        ),
                    ),
                );
                break;

            case "wcap_logged_in_content":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WCAP Logged In", "whcom"),
                    ),
                    "params" => array(
                        array(
                            "type" => "textfield",
                            "heading" => __("No Parameter", "whcom"),
                            "param_name" => "default",
                            "value" => __("", "whcom"),
                            "description" => __("It takes no necessary parameters to work by default,  Settings are controlled by admin area settings.", "whcom")
                        ),
                    ),
                );
                break;

            case "wcap_logged_out_content":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WCAP Logged Out", "whcom"),
                    ),
                    "params" => array(
                        array(
                            "type" => "textfield",
                            "heading" => __("No Parameter", "whcom"),
                            "param_name" => "default",
                            "value" => __("", "whcom"),
                            "description" => __("It takes no necessary parameters to work by default,  Settings are controlled by admin area settings.", "whcom")
                        ),
                    ),
                );
                break;

            case "wcap_whmcs_nav_menu":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WCAP Navigation Menu", "whcom"),
                    ),
                    "params" => array(
                        array(
                            "type" => "textfield",
                            "heading" => __("No Parameter", "whcom"),
                            "param_name" => "default",
                            "value" => __("", "whcom"),
                            "description" => __("It takes no necessary parameters to work by default,  Settings are controlled by admin area settings.", "whcom")
                        ),
                    ),
                );
                break;

            case "wcap_login_form":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WCAP Login Form", "whcom"),
                    ),
                    "params" => array(
                        array(
                            "type" => "textfield",
                            "heading" => __("No Parameter", "whcom"),
                            "param_name" => "default",
                            "value" => __("", "whcom"),
                            "description" => __("It takes no necessary parameters to work by default,  Settings are controlled by admin area settings.", "whcom")
                        ),
                    ),
                );
                break;
            default:
                return array();
        }
    }
}


