<?php defined('ABSPATH') or die("Cannot access pages directly.");


function wcap_is_wcop_active()
{

    if (!function_exists('is_plugin_active')) {
        return false;
    }

    if (is_plugin_active('whmpress_whmcs_cart/whmpress_whmcs_cart.php')) {
        return true;
    } else {
        return false;
    }

}


function wcap_use_whmpress_cart_links()
{
    $wcap_configured = false;
    if (!function_exists('is_plugin_active')) {
        return false;
    }
    if (is_plugin_active('whmpress_whmcs_cart/whmpress_whmcs_cart.php')) {
        $field = 'configure_product' . wcap_get_current_language();
        if (url_to_postid(esc_attr(get_option($field))) > 0) {
            $wcap_configured = true;
        }
    }

    return $wcap_configured;
}

function wcap_count_status($fill_array, $status_array)
{

    $tmp = [];
    foreach ($status_array as $status) {
        $tmp[] = $status["status"];
        $tmp[] = "All";
    }

    $status_array = array_count_values($tmp);
    $status_array = array_merge($fill_array, $status_array);

    return $status_array;

}

function wcap_count_stage($fill_array, $status_array)
{

    $tmp = [];
    foreach ($status_array as $status) {
        if ($status["stage"] != "Draft") {
            if ($status["stage"] == "Dead" || $status["stage"] == "Lost") {
                $status["stage"] = "Expired";
            }
            $tmp[] = $status["stage"];
            $tmp[] = "All";
        }
    }

    $status_array = array_count_values($tmp);
    $status_array = array_merge($fill_array, $status_array);

    return $status_array;

}

/*
// todo: to remove
function wcap_is_info_valid()
{
    $api_test = whcom_api_test();

    return $api_test;
}*/

if (!function_exists('wcap_ppa')) {
    function wcap_ppa($mr, $str = "")
    {
        echo "<pre>";
        echo $str . "<br>";
        print_r($mr);
        echo "</pre>";
    }
}

function wcap_render_support_panel()
{
    ?>
        <div class="whcom_panel">
        <div class="whcom_panel_header whcom_has_icon">
            <i class="whcom_icon_lifebuoy panel_header_icon"></i>
            <?php esc_html_e('Support', "whcom" ) ?>
        </div>
        <div class="whcom_panel_body whcom_has_list">
            <ul class="whcom_list_wcap_style_1">

            <?php

            $m=wcap_page_info("tickets");
            if ($m['show'])
            {
                $m['label']=esc_html__("My Support Tickets","whcom");
                echo wcap_render_sidebar_li($m);
            }

            $m=wcap_page_info("openticket");
            if ($m['show'])
            {
                echo wcap_render_sidebar_li($m);
            }

            $m=wcap_page_info("announcements");
            if ($m['show'])
            {
                echo wcap_render_sidebar_li($m);
            }

            $m=wcap_page_info("knowledgebase");
            if ($m['show'])
            {
                echo wcap_render_sidebar_li($m);
            }

            $m=wcap_page_info("downloads");
            if ($m['show'])
            {
                echo wcap_render_sidebar_li($m);
            }

            $m=wcap_page_info("network_status");
            if ($m['show'])
            {
                echo wcap_render_sidebar_li($m);
            }
            ?>

            </ul>
        </div>
    </div>


    <?php
}

function wcap_render_ticket_info($ticket){
    ?>
    <div class="whcom_panel">
        <div class="whcom_panel_header whcom_has_icon">
            <i class="whcom_icon_ticket"></i>
            <?php esc_html_e('Ticket Information', "whcom" ) ?>
        </div>
        <div class="whcom_panel_body whcom_has_list">
            <ul class="whcom_list_bordered whcom_list_padded">
                <li>
                    #<?php echo $ticket["tid"] ?> - <?php echo $ticket["subject"] ?>
                    <div>
                        <label class="whcom_button_tiny whcom_button whcom_button_<?php echo wcap_ticket_status_color($ticket["status"]) ?>">
                            <?php echo $ticket["status"] ?></label>

                    </div>
                </li>


                <li>
                    <div class="whcom_text_small whcom_text_small">
                        <?php esc_html_e('Department', "whcom" ) ?>
                    </div>
                    <?php echo $ticket["deptname"] ?>
                </li>
                <li>
                    <div class="whcom_text_small whcom_text_small">
                        <?php esc_html_e('Submitted', "whcom" ) ?>
                    </div>
                    <?php echo wcap_datetime($ticket["date"]) ?>
                </li>
                <li>
                    <div class="whcom_text_small whcom_text_small">
                        <?php esc_html_e('Last Updated', "whcom" ) ?>
                    </div>
                    <?php echo wcap_datetime($ticket["lastreply"]) ?>

                </li>
                <li>
                    <div class="whcom_text_small whcom_text_small">
                        <?php esc_html_e('Priority', "whcom" ) ?>
                    </div>
                    <?php echo $ticket["priority"] ?>

                </li>
            </ul>
        </div>
    </div>
<?php
}

function wcap_render_register_panel()
{
    ?>
    <div class="whcom_panel">
        <div class="whcom_panel_header whcom_has_icon">
            <i class="whcom_icon_user-3 panel_header_icon"></i><?php esc_html_e('Already Registered?', "whcom" ) ?>
        </div>
        <div class="whcom_panel_body whcom_has_list">
            <ul class="whcom_list_wcap_style_2">
                <li>
                    <a href="#">
                        <?php esc_html_e('Already registered with us? If so, click the button below to login to our client area from where you can manage your account.', "whcom" ) ?>

                    </a>


                </li>
                <li>
                    <a class="wcap_load_page" data-page="login"
                       href="#"><?php esc_html_e('Login', "whcom" ) ?></a>
                    <i class="whcom_icon_user-3 whcom_list_right_icon"> </i>
                </li>
                <li>
                    <a class="wcap_load_page" data-page="password_reset"
                       href="#"><?php esc_html_e('Lost Password reset', "whcom" ) ?></a>
                    <i class="whcom_icon_asterisk whcom_list_right_icon"> </i>
                </li>
            </ul>
        </div>
    </div>

    <div class="whcom_panel">
        <div class="whcom_panel_header whcom_has_icon">
            <i class="whcom_icon_user-3 panel_header_icon"></i><?php esc_html_e('Why security questions?', "whcom" ) ?>
        </div>
        <div class="whcom_panel_body whcom_has_list">
            <ul class="whcom_list_bordered whcom_has_icons whcom_has_links ">
                <li>
                    <a href="#">
                        <?php esc_html_e('Setting a security question will provide extra security, as all changes to your account require providing the additional information from your question.', "whcom" ) ?>

                    </a>


                </li>
            </ul>
        </div>
    </div>


    <?php
}


function wcap_render_billing_panel()
{
    ?>
    <div class="whcom_panel">
        <div class="whcom_panel_header whcom_has_icon">
            <i class="whcom_icon_bank panel_header_icon"></i><?php esc_html_e('View', "whcom" ) ?>
        </div>
        <div class="whcom_panel_body whcom_has_list">
            <ul class="whcom_list_wcap_style_1">
                <?php
                $m =wcap_page_info("my_invoices");
                echo ($m['show'])?wcap_render_sidebar_li($m):"";

                $m =wcap_page_info("my_quotes");
                echo ($m['show'])?wcap_render_sidebar_li($m):"";

                $m =wcap_page_info("mass_pay");
                echo ($m['show'])?wcap_render_sidebar_li($m):"";

                $m =wcap_page_info("credit_card");
                echo ($m['show'])?wcap_render_sidebar_li($m):"";

                 ?>

            </ul>
        </div>
    </div>

    <?php
}


function wcap_render_domains_panel_action()
{
    ?>
    <div class="whcom_panel">
        <div class="whcom_panel_header whcom_has_icon">
            <i class="whcom_icon_plus panel_header_icon"></i><?php esc_html_e('Actions', "whcom" ) ?>
        </div>
        <div class="whcom_panel_body whcom_has_list">
            <ul class="whcom_list_wcap_style_1">

                <?php
                $m=wcap_page_info("domain_renewals");
                if ($m['show']){
                    echo wcap_render_sidebar_li($m);
                }

                $m=wcap_page_info("domain_register");
                if ($m['show']){
                    echo wcap_render_sidebar_li($m);
                }

                $m=wcap_page_info("domain_transfer");
                if ($m['show']){
                    echo wcap_render_sidebar_li($m);
                }

                echo wcap_render_sidebar_cart_li();

                ?>


            </ul>
        </div>
        <div class="whcom_panel_footer whcom_text_right">

        </div>

    </div>

    <?php
}

function wcap_render_domain_detail_panel($id, $status, $registrar)
{

    $class_li = "";
    if ($status == "pending") {
        $class_li = "wcom_disabled";
    }

    ?>


    <div class="whcom_panel">
        <div class="whcom_panel_header whcom_has_icon">
            <i class="whcom_icon_cog panel_header_icon"></i>
            <?php esc_html_e('Manage', "whcom" ); ?>
        </div>
        <div class="whcom_panel_body whcom_has_list">
            <ul class="whcom_list_wcap_style_1">
                <li>
                    <a href="?id=<?php echo $id ?>&do=overview" class="wcap_load_page"
                       data-page="domaindetail">
                        <?php echo __("Overview", "whcom" ); ?>
                    </a>
                </li>


                <li class="<?php echo $class_li; ?>">
                    <a href="?id=<?php echo $id ?>&do=autorenew" class="wcap_load_page"
                       data-page="domaindetail">
                        <?php esc_html_e("Auto Renew", "whcom" ); ?>
                    </a>
                </li>

                <?php if ($registrar != "") { ?>
                    <li>
                        <a href="?id=<?php echo $id ?>&do=ns" class="wcap_load_page"
                           data-page="domaindetail">
                            <?php echo __("Nameservers", "whcom" ); ?>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($status == "Active" & $registrar != "") { ?>
                    <li>
                        <a href="?id=<?php echo $id ?>&do=lock" class="wcap_load_page"
                           data-page="domaindetail">
                            <?php echo __("Registrar Lock", "whcom" ); ?>
                        </a>
                    </li>
                <?php } ?>


                <li>
                    <a href="?id=<?php echo $id ?>&do=addons" class="wcap_load_page"
                       data-page="domaindetail">
                        <?php echo __("Addons", "whcom" ); ?>
                    </a>
                </li>

                <?php if ($registrar != "") { ?>
                    <li>
                        <a href="?id=<?php echo $id ?>&do=contact" class="wcap_load_page"
                           data-page="domaindetail">
                            <?php echo __("Contact Information", "whcom" ); ?>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($status == "Active" & $registrar != "") { ?>
                    <li>
                        <a href="?id=<?php echo $id ?>&do=epp" class="wcap_load_page"
                           data-page="domaindetail">
                            <?php echo __("EPP Code", "whcom" ); ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <?php
}

function wcap_render_categories_panel($remote_page = true) {
	$theclass="";
	$thepage="";

	if ($remote_page==true) {
	     $theclass="wcap_load_page";
	     $thepage='data-page = "order_new_service"';
	}
	$response = whcom_get_all_products();
	$groups = $response;

	?>

    <div class="whcom_panel">
        <div class="whcom_panel_header whcom_has_icon">
            <i class="whcom_icon_basket-1"></i> <?php esc_html_e('Categories', "whcom" ) ?>
        </div>
        <div class="whcom_panel_body whcom_has_list">
            <ul class="whcom_list_wcap_style_2">
                <?php
                foreach ($groups["groups"] as $index => $group)
                    {
                        $group_unique_id=strtolower( str_replace( ' ', '', $group["name"] ) ) . $group["id"];
                        $name=($group["name"]);
                        if (is_numeric($index)){
                        ?>
                        <li
                        <?php echo $thepage; ?>
                        data-tab="<?php echo $group_unique_id ?> "
                        class="<?php echo $theclass?>"
                        href="active=<?php echo $group_unique_id ?>"
                        ><a>
                        <?php echo $name ?>
                        </a>
                        </li>
                 <?php } } ?>
            </ul>
        </div>
    </div>
    <?php
}

//todo: this should be moved to whcom
function wcap_calculate_default_product_price( $product ) {

	$output        = [
		'price'        => '0.00',
		'billingcycle' => 'free',
	];
	$billingcycles = [
		'monthly',
		'quarterly',
		'semiannually',
		'annually',
		'biennially',
		'triennially',
	];
$setup_key="";
	if ( ! empty( $product ) && is_array( $product ) ) {
		$paytype = $product['paytype'];
		if ( $paytype == 'onetime' ) {
			$output['price']        = $product['monthly'];
			$output['billingcycle'] = esc_html__( 'One Time', 'wcop' );
			$output['setup'] = $product['msetupfee'];
		}
		else if ( $paytype == 'recurring' ) {
			foreach ( $billingcycles as $billingcycle ) {
				if ( $product[ $billingcycle ] > 0 ) {
				    $setup_key=substr($billingcycle, 0, 1)."setupfee";
					$price        = $product[ $billingcycle ];
					$billingcycle = esc_html__( $billingcycle, 'wcop' );
					$setup_fee = $product[$setup_key];
					break;
				}
			}
		}
	}

    	// Configurable options types
		// 1 = DropDown, 2 = Radio, 3 = Checkbox(Yes/No), 4 = TextBox(Qty)

        // we have minimum billing cylce now, lets calculate configuration proice for that cycle


    $product_row=$product;
	$configurable=0;
	$config_price = 0;
	$config_setup = 0;
		$config_array     = [];
		if ( count( $product_row["prd_configoptions"] ) > 0 ) {
		    $configurable=1;
			foreach ( $product_row["prd_configoptions"] as $configoption ) {
/*
			    */
				$index = 0;
				if ( $configoption["optiontype"] == "1" || $configoption["optiontype"] == "2" ) {
						$price_tmp=[];
						$setup_tmp=[];
						$total_tmp=[];
						$i=0;
				        foreach ( $configoption["sub_options"] as $k => $conf ) {
                            $price_tmp[$i]=$conf[$billingcycle];
                            $setup_tmp[$i]=$conf[$setup_key];
                            $total_tmp[$i]=$price_tmp[$i] + $setup_tmp[$i];
                            $i++;
						}

                        $total_min=min($total_tmp);
    					$config_price += $total_min;
    					$config_setup +=0;

				}
				else if ( $configoption["optiontype"] == "3" ) { //todo: complete minimum calculation for remaining 2 types
					if ( isset( $configoption["sub_options"][0])){

						$config_price += 0;
					}

				}
				else if ( $configoption["optiontype"] == "4" ) {
					$config_price += 0;
				}
			}
		}

		$output= [
			"price"            => $price,
			"setup"            => $setup_fee,
			"billingcycle"     => $billingcycle,
			"pricetype"        => $paytype,
            "configurable"     => $configurable,
			"config_price"     => $config_price,
			"config_setup"     => $config_setup,

		];

	return $output;
}


function wcap_render_services_panel_action()
{
    ?>
    <div class="whcom_panel">
        <div class="whcom_panel_header whcom_has_icon">
            <i class="whcom_icon_plus panel_header_icon"></i> <?php esc_html_e('Actions', "whcom" ) ?>
        </div>
        <div class="whcom_panel_body whcom_has_list">
            <ul class="whcom_list_wcap_style_1">
            <?php

            $m=wcap_page_info("order_new_services");
            if ($m['show'])
            {
                $m['label']=esc_html__("Place a New Order","whcom");

                echo wcap_render_sidebar_li($m);
            }

            $m=wcap_page_info("addons");
            if ($m['show'])
            {
                echo wcap_render_sidebar_li($m);
            }

            echo wcap_render_sidebar_cart_li();

            ?>

            </ul>
        </div>
    </div>

    <?php
}

function wcap_render_profile_panel()
{
    ?>
    <div class="whcom_panel">
        <div class="whcom_panel_header"><i class="whcom_icon_user-3"></i>
            <?php esc_html_e('My Account', "whcom" ); ?>
        </div>
        <div class="whcom_panel_body whcom_has_list">
            <ul class="whcom_list_wcap_style_1">
            <?php
            $m=wcap_page_info("edit_account_details");
            echo ($m['show'])?wcap_render_sidebar_li($m):"";

            $m=wcap_page_info("credit_card");
            echo ($m['show'])?wcap_render_sidebar_li($m):"";

            $m=wcap_page_info("contacts_subaccounts");
            echo ($m['show'])?wcap_render_sidebar_li($m):"";

            $m=wcap_page_info("change_password");
            echo ($m['show'])?wcap_render_sidebar_li($m):"";

            $m=wcap_page_info("security_settings");
            echo ($m['show'])?wcap_render_sidebar_li($m):"";

            $m=wcap_page_info("email_history");
            echo ($m['show'])?wcap_render_sidebar_li($m):"";


 ?>

        </div>
    </div>

    <?php
}

function wcap_show_side_bar($page,$logged_in="")
{
    /* 0 - home
 * 10 - store
 * 20 - Announcements
 * 30 - knowledgebase
 * 40 - networkstatus
 * 50 - Contact us
 * 70 - Account
 * * Login
 * * register
 * * forget password
 */

    $logged_in= ($logged_in=="") ? whcom_is_client_logged_in() : $logged_in;

    if ($logged_in) {
        $map = [
            "home" => "0",

            "services" => "10",
            "my_services" => "10",
            "my_services_seprator" => "10",
            "order_new_services" => "10",
            "addons" =>"10",

            "domains" => "20",
            "my_domains" => "20",
            "seprator" => "20",
            "domain_renewals" => "20",
            "domain_register" => "20",
            "domain_transfer"=>"20",

            "billing" => "30",
            "my_invoices" => "30",
            "my_quotes" => "30",
            "mass_pay" => "30",


            "support" => "40",
            "tickets" => "40",
            "announcements" => "40",
            "knowledgebase" => "40",
            "downloads" => "40",
            "network_status" => "40",

            "openticket" => "50",

            "affiliates"=>"60",

            "account" => "70",
            "edit_account_details" => "70",
            "credit_card" =>"70",
            "contacts_subaccounts" => "70",
            "change_password" => "70",
            "security_settings" => "70",
            "email_history" => "70",
            "seprator" => "70",
            "logout" => "70",
        ];

            $menu_settings = (get_option("wcapfield_hide_whmcs_menu_sections") == '') ? [] :
        get_option("wcapfield_hide_whmcs_menu_sections");


    }
    if (! ($logged_in)){
        $map = [
            "home" => "0",
            "store" => "10",
            "announcements" => "20",
            "knowledgebase" => "30",
            "network_status" => "40",
            "contact" => "50",

            "account" => "70",
            "login" => "70",
            "create_client_account" => "70",
            "password_reset" => "70",

        ];

            $menu_settings = (get_option("wcapfield_hide_whmcs_menu_sections_front") == '') ? [] :
        get_option("wcapfield_hide_whmcs_menu_sections_front");

    }
    $show_side_bar=true;

    if (isset($map[$page])){

        $main_index = $map[$page];
        $menu_settings[$main_index]['sub'][$page]['hide_sidebar'];

        if ($menu_settings[$main_index]['sub'][$page]['hide_sidebar'] == 'hide_sidebar') {
            $show_side_bar=false;
        }

        elseif ($menu_settings[$main_index]['hide_sidebar'] == 'hide_sidebar') {
            $show_side_bar=false;
        }
        return $show_side_bar;
    }
    else{
        return "";
    }

}





function wcap_get_current_language()
{
    if (defined('ICL_LANGUAGE_CODE')) {
        return ICL_LANGUAGE_CODE;
    } elseif (function_exists('pll_current_language')) {
        return pll_current_language();
    } elseif (isset($_GET["lang"])) {
        return $_GET["lang"];
    } else {
        return get_locale();
    }
}


function wcap_debug_info()
{
    global $wpdb;

    $WCAP = new WCAP;


    /*    $whmcs_info = "";
        $whmcs_info = "WHMCS Info\n============\n";
        $whmcs_info .= "Version: {$_version}\n";
        $whmcs_info .= "System URL: " . $_url . "\n";
        $whmcs_info .= "System SSL URL: " . $ssl_url . "\n";*/


    ?>
    <textarea onfocus="jQuery(this).select();" style="width: 100%;height: 600px;" readonly="readonly">

    cURL Extension Info
    ===================
    <?php echo function_exists('curl_version') ? "Installed" : "Not Installed"; ?>


    ?>
    cURL Test with port 443 and google.com: <?php


    ?>
    <?php wp_die();
}


    function wcap_print_menu($menu_settings, $WCAP_Menu, $show)
    {

        foreach ($WCAP_Menu as $menu_key => $menu_array) {


            if ($show == "left") { //show all except 70
                if ($menu_key == '70') {
                    continue;
                }


                if ($menu_array['show']==FALSE){
                    continue;
                }
            }

            if ($show == 'right') { //show only 70
                if ($menu_key != '70') {
                    continue;
                }
            }

            // if an entry is hidden, continue to next entry, dont showit
            if (isset($menu_settings[$menu_key]['hide']) && $menu_settings[$menu_key]['hide'] == 'hide') {
                continue;
            }


            if ($menu_array["show"]==false)    {
                continue;
            }

            // set active menu
            $active_li = false;
            if (isset($menu_array['sub']) && is_array($menu_array['sub'])) {
                foreach ($menu_array['sub'] as $sub_menu_array) {
                    if (isset($sub_menu_array["page"]) && $sub_menu_array["page"] == $_GET['wcap']) {
                        $active_li = true;
                        break;
                    }
                }
            } else {
                if ($menu_array["page"] == $_GET['wcap']) {
                    $active_li = true;
                }
            }
            ?>

            <?php //display menu
            ?>
            <li class="<?php echo $active_li ? "current-menu-item" : "" ?>">

            <?php
            if (!empty ($menu_settings[$menu_key]['url_override']) && !($menu_settings[$menu_key]['url_override']) == "")
                {
                    $custom_url= $menu_settings[$menu_key]['url_override'];
                    $class="";
                }
            else
                {
                    $custom_url= "";
                    $class=$menu_array['class'];
                }

            ?>

                <a class="<?php echo $class ?>"
                    <?php
                    if (!(empty($custom_url))) {//if custom link, no need of data-page attribute
                        ?>
                        href="<?php echo $custom_url ?>"
                        <?php
                    } else //no URL provided
                    {
                        ?>
                        <?php if (!empty($menu_array["page"])) { ?>
                        data-page="<?php echo $menu_array["page"]; ?>"
                        <?php } ?>
                        href="<?php echo isset($menu_array["href"]) ? $menu_array["href"] : "#" ?>"
                        <?php
                    }

                    ?>
                   id="<?php echo isset($menu_array["id"]) ? $menu_array["id"] : "" ?>">
                    <?php echo $menu_array["label"] ?>
                    <?php echo (isset($menu_array['sub']) && is_array($menu_array['sub'])) ? ' <i class="whcom_icon_down-dir"></i>' : ''; ?>
                </a>

                <?php if (isset($menu_array['sub']) && is_array($menu_array['sub'])) {
                    ?>
                    <ul>

                        <?php foreach ($menu_array['sub'] as $sub_menu_key => $sub_menu_array) {
                            // if an entry is hidden, continue to next entry, dont showit
                            if (isset($menu_settings[$menu_key]['sub'][$sub_menu_key]['hide'])
                            && $menu_settings[$menu_key]['sub'][$sub_menu_key]['hide'] == 'hide') {
                                continue;
                            }


                            if ($sub_menu_array["show"]==false){
                                continue;
                            }

/*                            if (($EnableMassPay<>"on")&& ($sub_menu_key=="mass_pay")){
                                continue;
                            }


                            if (CC_SAVEABLE==false && $sub_menu_key=="credit_card"){
                                continue;
                            }*/

                            if ($sub_menu_array["label"] == "Separator") {
                                echo '<li class="separator"></li>';
                            } else {
                                ?>

                                <?php if (isset($sub_menu_array["page"])){ ?>
                                <li class="<?php echo $sub_menu_array["page"] == $_GET['wcap'] ? 'current-menu-item' : ""; ?>">
                                <?php

                                    if (!empty ($menu_settings[$menu_key]['sub'][$sub_menu_key]['url_override'])
                                            && trim($menu_settings[$menu_key]['sub'][$sub_menu_key]['url_override'])!="")
                                        {
                                            $custom_url= $menu_settings[$menu_key]['sub'][$sub_menu_key]['url_override'];
                                            $class="";
                                        }
                                    else
                                        {
                                            $custom_url= "";
                                            $class=$sub_menu_array['class'];
                                        }
                                ?>
                                    <a class="<?php echo $class ?>"
                                        <?php
                                        if (!empty ($custom_url))
                                            {//if custom link, no need of data-page attribute
                                                ?>
                                                href="<?php echo $custom_url ?>"
                                                <?php
                                            }
                                        else //no URL provided
                                            {
                                            ?>

                                                <?php if (!empty($sub_menu_array["page"])) { ?>
                                                data-page="<?php echo $sub_menu_array["page"]; ?>"
                                                <?php } ?>
                                                href="<?php echo isset($sub_menu_array["href"]) ? $sub_menu_array["href"] : "#" ?>"
                                                <?php
                                            }
                                        ?>
                                       id = "<?php echo isset($sub_menu_array["id"]) ? $sub_menu_array["id"] : "" ?>" >
                                        <?php echo $sub_menu_array["label"] ?>
                                    </a>
                                </li>
                                <?php } ?>
                            <?php }
                        } ?>
                    </ul>

                <?php } ?>
            </li>
        <?php }
    }

    function wcap_show_front_menu(){
            // hide menu if all menus is hidden
        $logged_in=whcom_is_client_logged_in();
        $hide_manu = (get_option("wcapfield_hide_whmcs_menu_front") == '') ? [] : get_option("wcapfield_hide_whmcs_menu_front");
        if (!($hide_manu) && !($logged_in)) {
            return true;

            //include_once (WCAP_PATH . "/views/top_links_front.php");
        }
        else{
            return false;
        }
    }

    function wcap_services_filter($services_array, $status, $is_summery) {
		$products_summery=[];
		$index=0;

	    foreach ($services_array["products"]["product"] as $product) {
	        if ($product["status"]==$status){
	            $products_summery[$index]["id"]=$product["id"];
	            $products_summery[$index]["pid"] = $product["pid"];
	            $products_summery[$index]["name"] = $product["name"];
	            $products_summery[$index]["domain"]=$product["domain"];
	            $products_summery[$index]["billingcycle"]=$product["billingcycle"];
	        }
	        else{
	            unset ($product);
	        }
	        $index++;
	    }

	    if ($is_summery) {
	        return $products_summery;
	    } else {
	        $services_array;
	    }

    }

    function wcap_products_with_addons($products_x,$products_filter ){

      //first get all products
     $product_list = array();
         foreach($products_x["groups"] as $group){
             $product_list[]  = $group['products'];
         }
         // delete all products other than provided filter
         foreach($products_filter as $key => $product){
             $prd_id=$product["pid"];
             foreach ($product_list as $single_product){
                 if(in_array($single_product[$prd_id],$single_product)){
                  if (empty($single_product[$prd_id]['prd_addons'])) {
                 unset($products_filter[$key]);
                 }
             }
             }

         }
        return $products_filter;
    }

     function wcap_products_simple_list($products_x ){

      //first get all products
     $product_list = [];
         foreach($products_x["groups"] as $group){
             $product_list = $product_list + $group['products'];
         }

        return $product_list;
    }

    function wcap_product_addons($product_list,$product_id ){
         //return array of addons supported by product
        $product_addons=[];
         // delete all products other than provided filter

             if (! empty($product_list[$product_id]['prd_addons'])) {
                    $product_addons=  $product_list[$product_id]['prd_addons'];
             }

        return $product_addons;
    }

    function wcap_column_years($column)
    {
    $column_years = [
		"msetupfee"=>"1",
		"qsetupfee"=>"2",
		"ssetupfee"=>"3",
		"asetupfee"=>"4",
		"bsetupfee"=>"5",
		"monthly"=>"6",
		"quarterly"=>"7",
		"semiannually"=>"8",
		"annually"=>"9",
		"biennially"=>"10",
	];

    return $column_years[$column];

    }


    function wcap_get_knowledgebase_cats()
    {
        $args = [
            "action" => "kb_categories",
        ];

        return whcom_process_helper($args);
    }


    function wcap_get_knowledgebase_articles($args = "")
    {
        $default = [
            "action" => "kb_articles",
        ];

        $args = wp_parse_args($args, $default);
        return whcom_process_helper($args);
    }


    function wcap_get_download_cats()
    {
        $args = [
            "action" => "download_categories",
        ];

        return whcom_process_helper($args);
    }


    function wcap_get_download_files($args = "")
    {
        $default = [
            "action" => "download_files",
        ];

        $args = wp_parse_args($args, $default);
        return whcom_process_helper($args);
    }


    function wcap_get_network_status()
    {
        $args = [
            "action" => "network_status",
        ];
        return whcom_process_helper($args);
    }


    function wcap_get_email_history($args = "")
    {
        $default = [
            "action" => "email_history",
        ];

        $args = wp_parse_args($args, $default);
        return whcom_process_helper($args);
    }


    function wcap_get_cancellation_status($service_id)
    {
        $args = [
            "service_id" => $service_id,
            "action" => "cancelation_status",
        ];

        return whcom_process_helper($args);
    }


    function wcap_get_whmcs_domains($args = "")
    {
        $default = [
            "action" => "domains",
            "extension" => "",
        ];

        $args = wp_parse_args($args, $default);
        return whcom_process_helper($args);
    }


    function wcap_get_whmcs_products($args = "")
    {
        $default = [
            "action" => "products",
            "currency" => "",
        ];

        $args = wp_parse_args($args, $default);
        return whcom_process_helper($args);
    }

    function wcap_show_error($error){
        ?>
        <div class="whcom_alert whcom_alert_danger whcom_text_center">
            <?php echo $error ?>
        </div>
        <?php
    }

    function wcap_get_addons($args = "")
    {
        $default = [
            "action" => "addons",
            "pid" => "",
            "clientid" => "",
        ];

        $args = wp_parse_args($args, $default);

        if (empty($args["pid"])) {
            unset($args["pid"]);
        }

        extract($args);
        $response = whcom_process_helper($args);

        //$response['args'] = $args;
/*        $response=$response["data"];
            foreach ($response as $k => &$prd) {
                $prd["packages"] = wcap_make_array($prd["packages"]);
                if ($pid == "" && !in_array($pid, $prd["packages"])) {
                    unset($response[$k]);
                }
            }*/
        return $response;
    }

    function wcap_get_quotes($args="")
    {
        $default = [
            "userid" => "",
            "action" => "GetQuotes",
        ];

        $args = wp_parse_args($args, $default);

        extract($args);

        if ($args["status"] == "") {
            unset($args["status"]);
        }


        $response = whcom_process_api($args);

        return $response;

    }


    function wcap_get_all_products_x()
    {
        $response = whcom_process_helper(['action' => 'whcom_get_all_products']);
        return $response;
    }


    function wcap_get_client_products($args = "")
    {
        ## Get services
        $default = [
            "clientid" => "0",
            "serviceid" => "0",
            "pid" => "0",
            "domain" => "",
            "username2" => "",
            "status" => "",
        ];

        $args = wp_parse_args($args, $default);
        $args["action"] = "GetClientsProducts";
        extract($args);

        if (empty($args["clientid"])) {
            unset($args["clientid"]);
        }
        if (empty($args["serviceid"])) {
            unset($args["serviceid"]);
        }
        if (empty($args["pid"])) {
            unset($args["pid"]);
        }
        if (empty($args["domain"])) {
            unset($args["domain"]);
        }
        if (empty($args["username2"])) {
            unset($args["username2"]);
        }
        if (empty($args["status"])) {
            unset($args["status"]);
        }


        $response = whcom_process_api($args);
        if (!isset($response["result"])) {
            $response["result"]="error";
            return print_r($response, true);
        }

        if (isset($response["result"])) {
            if ($response["result"] == "success") {
                $response["active_services"] = 0;

                if (isset($response["products"]["product"]) && is_array($response["products"]["product"])) {
                    foreach ($response["products"]["product"] as $key => &$product) {
                        if ($product["status"] == "Active") {
                            $response["active_services"]++;
                        }

                        if (!empty($status) && $product["status"] <> $status) {
                            unset($response["products"]["product"][$key]);
                            $response["totalresults"]--;
                        }
                    }
                }
            } else {
                //do nothing
            }
        }
        return $response;
    }



    //todo: functions are here for codes portability and can be removed afterwords
    function wcap_make_array($arr, $sep = ",", $considerLineBreaks = false)
    {
        if (is_string($arr) && trim($arr) == "") {
            return [];
        }
        if (is_array($arr)) {
            return $arr;
        }
        if (wcap_is_json($arr)) {
            $arr = json_decode($arr, true);

            return $arr;
        }
        if ($considerLineBreaks) {
            $arr = str_replace("\n", $sep, $arr);
        }
        //$arr = str_replace("'", "''", $arr);            // To avoid error MySQL insertion/update.
        $arr = explode($sep, $arr);
        $arr = array_map('trim', $arr);
        $arr = array_filter($arr);

        return $arr;
    }

    function wcap_is_json($string)
    {
        if (is_numeric($string)) {
            return false;
        }
        if (is_bool($string)) {
            return false;
        }
        if (is_null($string)) {
            return false;
        }
        if (!is_string($string)) {
            return false;
        }
        if ($string == "" || $string == " ") {
            return false;
        }
        @json_decode($string);

        return (json_last_error() == JSON_ERROR_NONE);
    }
if (! function_exists('check_plugin_activation_status')){
    function  check_plugin_activation_status(){
        require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
        if(is_plugin_active('polylang/polylang.php')){
            return '1';
        } else{
            return '0';
        }
    }
    add_action( 'admin_init', 'check_plugin_activation_status' );
}
