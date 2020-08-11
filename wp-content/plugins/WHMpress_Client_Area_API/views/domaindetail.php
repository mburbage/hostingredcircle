<?php
//page initialization, veriables for whole page

$show_sidebar = wcap_show_side_bar("addons", true);

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}

$domain_found = FALSE;

$curr = whcom_get_current_currency();
$_POST["do"] = isset($_POST["do"]) ? $_POST["do"] : "overview";
$_POST["clientid"] = whcom_get_current_client_id();
$domain_id = isset($_POST["id"]) ? $_POST["id"] : "";
$client_id = whcom_get_current_client_id();
$do = $_POST["do"];
$domain_locked = "";
$domain_status = "";
$domain_name = "";

$args = [
    "domainid" => $domain_id,
    "clientid" => $client_id,
];


$domain = wcap_get_client_domains($args);
if (!isset($domain["domains"]["domain"][0])) {
    $domain_found = FALSE;
} else {
    $domain_found = TRUE;
    $domain = $domain["domains"]["domain"][0];
    $domain_status = $domain["status"];

    if ($domain_status == "Active") {
        $response = wcap_get_domain_locking_status(["domainid" => $domain_id]);
        $domain_locked = $response["data"];
    }

    $domain_name = $domain["domainname"];
    $domain_registrar = $domain["registrar"];
}


?>

<div class="wcap_knowledgebase wcap_view_container">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php
                if ($domain_found) {
                    wcap_render_domain_detail_panel($domain_id, $domain_status, $domain_registrar);
                }
                wcap_render_domains_panel_action();
                ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">

            <div class="whcom_page_heading">
                <?php if ($domain_found) { ?>
                    <span><?php esc_html_e("Managing", "whcom");
                        echo " " . $domain_name; ?></span>
                <?php } ?>
            </div>


            <?php //main content ?>
            <div class="wcap_view_response"></div>
            <div class="whcom_margin_bottom_15 wcap_view_content">
                <?php if (!$domain_found) {
                    wcap_show_error("Domain not found");
                }
                ?>

                <?php if ($domain_found) { ?>

                    <?php if ($domain_status != "Active") {
                        ?>
                        <div class="whcom_alert whcom_alert_warning">
                    <span>
                <?php esc_html_e("This domain is not currently active. Domains cannot be managed unless active.", "whcom"); ?>
                </span>
                        </div>
                    <?php } ?>

                    <?php if ($domain_status == "Active") { ?>

                        <?php if ($_POST["do"] == "overview") { ?>
                            <?php
                            /*
                             * Other/ General Section
                             */
                            ?>

                            <div class="whcom_row">
                                <h3> <?php _e("Overview", "whcom") ?></h3>
                            </div>
                            <?php
                            if ($domain_status == "active") {
                                if ($domain_locked == "unlocked") { ?>
                                    <div class="whcom_alert whcom_alert_danger">
                                        <strong><?php esc_html_e("Domain Currently Unlocked!", "whcom"); ?></strong><br>
                                        <?php esc_html_e("You should enable the registrar lock unless you are transferring the domain.", "whcom"); ?>
                                    </div>
                                <?php }
                            } ?>

                            <div class="whcom_row">
                                <div class="whcom_col_sm_6">
                                    <div class="whcom_margin_bottom_15">
                                        <div class="whcom_text_bold">
                                            <?php echo __("Domain", "whcom") . ":" ?>
                                        </div>
                                        <?php echo $domain["domainname"] ?>
                                    </div>

                                    <div class="whcom_margin_bottom_15">
                                        <div class="whcom_text_bold">
                                            <?php echo __("Registration Date", "whcom") . ":" ?>
                                        </div>
                                        <?php echo $domain["regdate"] ?>
                                    </div>

                                    <div class="whcom_margin_bottom_15">
                                        <div class="whcom_text_bold">
                                            <?php echo __("Next Due Date", "whcom") . ":" ?>
                                        </div>
                                        <?php echo $domain["nextduedate"] ?>
                                    </div>

                                    <div class="whcom_margin_bottom_15">
                                        <div class="whcom_text_bold">
                                            <?php echo __("Status", "whcom") . ":" ?>
                                        </div>
                                        <?php echo $domain["status"] ?>
                                    </div>

                                </div>

                                <div class="whcom_col_sm_6">
                                    <div class="whcom_margin_bottom_15">
                                        <div class="whcom_text_bold">
                                            <?php echo __("First Payment Amount", "whcom") . ":" ?>
                                        </div>
                                        <?php echo $curr["prefix"] . $domain["firstpaymentamount"] ?>
                                    </div>

                                    <div class="whcom_margin_bottom_15">
                                        <div class="whcom_text_bold">
                                            <?php echo __("Recurring Amount", "whcom") . ":" ?>
                                        </div>
                                        <?php echo $curr["prefix"] . $domain["recurringamount"] ?>
                                    </div>

                                    <div class="whcom_margin_bottom_15">
                                        <div class="whcom_text_bold">
                                            <?php echo __("Payment Method", "whcom") . ":" ?>
                                        </div>
                                        <?php echo $domain["paymentmethod"] ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($do == "autorenew") {
                            /*
                             * Other/ General Section
                             */
                            ?>

                            <div class="whcom_row">
                                <h3> <?php _e("Auto Renew", "whcom") ?></h3>
                            </div>

                            <div class="whcom_alert whcom_alert_info whcom_margin_bottom_30">
                                <?php esc_html_e("Enable auto renew to have us automatically send you a renewal invoice before your domain expires. ", "whcom"); ?>
                            </div>

                            <div class="whcom_row">
                                <div class="whcom_col_sm_12">
                                    <?php
                                    //fetch auto renew status here
                                    $auto_renew_status = !$domain["donotrenew"];
                                    $new_status = ($auto_renew_status) ? "0" : "1";

                                    if ($auto_renew_status == 1) {
                                        $label = esc_html__("Disable Auto Renew", "whcom");
                                        $show_label = esc_html__("Enabled", "whcom");
                                        $class = "whcom_bg_success";
                                    } elseif ($auto_renew_status == 0) {
                                        $label = esc_html__("Enable Auto Renew", "whcom");
                                        $show_label = esc_html__("Disabled", "whcom");
                                        $class = "whcom_bg_danger";
                                    }
                                    ?>

                                    <div class="whcom_margin_bottom_15 whcom_text_center whcom_padding_bottom_45 ">
                                        <h3><?php echo esc_html__("Auto Renewal Status", "whcom") . ":" ?>
                                            <span class="<?php echo $class ?> whcom_padding_5_10">
                                                <?php echo $show_label ?>
                                            </span>
                                        </h3>
                                    </div>

                                    <form id="manage_domain_auto-renew_form">
                                        <input type="hidden" name="action" value="wcap_requests">
                                        <input type="hidden" name="what" value="update_auto_renew_status">
                                        <input type="hidden" name="domainid" value="<?php echo $domain_id ?>">
                                        <input type="hidden" name="oldvalue" value="<?php echo $old_status ?>">
                                        <input type="hidden" name="newvalue" value="<?php echo $new_status ?>">
                                        <div>
                                            <div class="whcom_form_field whcom_text_center">
                                                <button class="whcom_button"><?php echo $label; ?></button>
                                            </div>
                                        </div>
                                    </form>


                                </div>

                            </div>
                        <?php } ?>

                        <?php if ($_POST["do"] == "ns") { ?>
                            <?php
                            $response = wcap_get_domain_nameservers(["domainid" => $domain_id]);
                            ?>
                            <?php if ($response["status"] == "ERROR") { ?>
                                <?php wcap_show_error($response["error"]) ?>
                            <?php } ?>

                            <?php if ($response["status"] == "OK") { ?>
                                <div class="whcom_margin_bottom_15">
                                    <h3><?php echo __("Nameservers", "whcom") ?></h3>
                                </div>

                                <div class=" whcom_margin_bottom_15">
                                    <div class="whcom_alert whcom_alert_info">
                                        <?php _e("You can change where your domain points to here. Please be aware changes can take up to 24 hours to propagate.", "whcom"); ?>
                                    </div>
                                </div>


                                <div class="whcom_margin_bottom_15">
                                    <form id="update_dns_form">
                                        <input type="hidden" name="action" value="wcap_requests">
                                        <input type="hidden" name="what" value="update_dns_servers">
                                        <input type="hidden" name="domainid" value="<?php echo $domain_id ?>">
                                        <div>
                                            <div class="whcom_form_field">
                                                <label class="main_label"><?php _e("Nameserver 1", "whcom") ?></label>
                                                <input name="ns1" value="<?php echo $response["ns1"] ?>">
                                            </div>
                                            <div class="whcom_form_field">
                                                <label class="main_label"><?php _e("Nameserver 2", "whcom") ?></label>
                                                <input name="ns2" value="<?php echo $response["ns2"] ?>">
                                            </div>
                                            <div class="whcom_form_field">
                                                <label class="main_label"><?php _e("Nameserver 3", "whcom") ?></label>
                                                <input name="ns3" value="<?php echo $response["ns3"] ?>">
                                            </div>
                                            <div class="whcom_form_field">
                                                <label class="main_label"><?php _e("Nameserver 4", "whcom") ?></label>
                                                <input name="ns4" value="<?php echo $response["ns4"] ?>">
                                            </div>
                                            <div class="whcom_form_field">
                                                <label class="main_label"><?php _e("Nameserver 5", "whcom") ?></label>
                                                <input name="ns5" value="<?php echo $response["ns5"] ?>">
                                            </div>
                                            <div class="whcom_form_field whcom_text_center">
                                                <button class="whcom_button"><?php _e("Change Nameservers", "whcom") ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            <?php } ?>

                        <?php } ?>

                        <?php if ($_POST["do"] == "lock") { ?>

                            <div>
                                <h3><?php echo __("Registrar Lock", "whcom") ?></h3>
                            </div>

                            <div class="whcom_row whcom_margin_bottom_15">
                                <div class='whcom_alert whcom_alert_info whcom_margin_bottom_15'>
                                    <?php esc_html_e("Lock your domain to prevent it from being transferred away without your authorization.", "whcom") ?>
                                </div>
                            </div>

                            <? $response = wcap_get_domain_locking_status(["domainid" => $domain_id]); ?>
                            <?php if ($response["status"] == "ERROR") { ?>
                                <div class="whcom_padding_bottom_30">
                                    <?php wcap_show_error($response["error"]) ?>
                                </div>
                            <?php } ?>

                            <?php if ($response["status"] == "OK") { ?>
                                <div class="whcom_row">
                                    <div class="whcom_text_center text_large whcom_margin_bottom_15">
                                        <?php

                                        $lock_status = $response["data"];
                                        $new_status = 1;

                                        if ($lock_status == "unlocked") {
                                            $label_text = esc_html__("Disabled", "whcom");
                                            $label_class = "whcom_bg_danger";

                                            $button_text = esc_html__("Enable Registrar Lock", "whcom");
                                            $button_class = "whcom_button whcom_button_success whcom_button_big";

                                            $old_status = 0;
                                            $new_status = 1;

                                        }
                                        if ($lock_status == "locked") {
                                            $label_text = esc_html__("Enabled", "whcom");
                                            $label_class = "whcom_bg_success";

                                            $button_text = esc_html__("Disable Registrar Lock", "whcom");
                                            $button_class = "whcom_button whcom_button_danger whcom_button_big";
                                            $old_status = 1;
                                            $new_status = 0;
                                        }
                                        ?>
                                        <div class="whcom_margin_bottom_15 whcom_text_center whcom_padding_bottom_45 ">
                                            <h3><?php echo esc_html__("Registrar Lock Status:", "whcom") ?>
                                                <span class="<?php echo $label_class ?> whcom_padding_5_10">
                                                <?php echo $label_text ?>
                                            </span>
                                            </h3>
                                        </div>

                                        <form id="manage_registrar_lock_form">
                                            <input type="hidden" name="action" value="wcap_requests">
                                            <input type="hidden" name="what" value="update_registrar_lock_status">
                                            <input type="hidden" name="domainid" value="<?php echo $domain_id ?>">
                                            <input type="hidden" name="oldvalue" value="<?php echo $old_status ?>">
                                            <input type="hidden" name="newvalue" value="<?php echo $new_status ?>">
                                            <div>
                                                <div class="whcom_form_field whcom_text_center">
                                                    <button class="whcom_button <?php echo $button_class ?>">
                                                        <?php echo $button_text; ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                </div>

                            <?php } ?>
                        <?php } ?>


                        <?php if ($_POST["do"] == "addons") { ?>
                            <?php //***** Addons ***** ?>

                            <div class="whcom_row whcom_padding_bottom_30">
                                <h3> <?php _e("Addons", "whcom") ?></h3>
                                <div>
                                    <?php esc_html_e("The following addons are available for your domain(s)...", "whcom"); ?>
                                </div>

                            </div>
                            <?php $tld = whcom_get_tld_details(whcom_get_tld_from_domain($domain_name)); ?>

                            <?php if ($tld["idprotection"] == "on") { ?>
                                <div class="whcom_row whcom_padding_bottom_30">
                                    <div class="whcom_col_sm_2">
                                        <div class="whcom_text_right">
                                            <i class="whcom_icon_shield whcom_text_large "></i>
                                        </div>
                                    </div>
                                    <div class="whcom_col_sm_10">
                                        <div class="whcom_text_bold">
                                            <?php esc_html_e("ID Protection", "whcom"); ?>
                                        </div>

                                        <div>
                                            <?php esc_html_e("Protect your personal information and reduce the amount of spam to your inbox by enabling ID Protection.", "whcom"); ?>
                                        </div>
                                        <div>
                                            <?php
                                            wcap_render_button(esc_html__("Buy Now", "whcom"),
                                                "domain_addons",
                                                "?domain_id=" . $domain_id . "&addon_type=idprotection",
                                                "");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($tld["dnsmanagement"] == "on") { ?>
                                <div class="whcom_row whcom_padding_bottom_30">
                                    <div class="whcom_col_sm_2">
                                        <div class="whcom_text_right">
                                            <i class="whcom_icon_cloud whcom_text_large "></i>
                                        </div>
                                    </div>
                                    <div class="whcom_col_sm_10">
                                        <div class="whcom_text_bold">
                                            <?php esc_html_e("DNS Host Record Management", "whcom"); ?>
                                        </div>

                                        <div>
                                            <?php esc_html_e("External DNS Hosting can help speed up your website and improve availability with increased redundancy.", "whcom"); ?>
                                        </div>
                                        <div>
                                            <?php
                                            wcap_render_button(esc_html__("Buy Now", "whcom"),
                                                "domain_addons",
                                                "?domain_id=" . $domain_id . "&addon_type=dnsmanagement",
                                                "");
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($tld["emailforwarding"] == "on") { ?>
                                <div class="whcom_row whcom_padding_bottom_30 ">
                                    <div class="whcom_col_sm_2">
                                        <div class="whcom_text_right">
                                            <i class="whcom_icon_mail-alt whcom_text_large"></i>
                                        </div>
                                    </div>
                                    <div class="whcom_col_sm_10">
                                        <div>
                                            <?php esc_html_e("Email Forwarding", "whcom"); ?>
                                        </div>

                                        <div>
                                            <?php esc_html_e("Get emails forwarded to alternate email addresses of your choice so that you can monitor all from a single account.", "whcom"); ?>
                                        </div>
                                        <div>
                                            <?php
                                            wcap_render_button(esc_html__("Buy Now", "whcom"),
                                                "domain_addons",
                                                "?domain_id=" . $domain_id . "&addon_type=emailforwarding",
                                                "");
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>

                        <?php if ($_POST["do"] == "contact") { ?>
                            <?php //********** Update Whois/ Contact Details ***********?>
                            <div class="whcom_row whcom_padding_bottom_30">
                                <h3> <?php _e("Contact Information", "whcom") ?></h3>
                                <div class="whcom_alert whcom_alert_info">
                                    <?php esc_html_e("It is important to keep your domain WHOIS contact information up-to-date at all times to avoid losing control of your domain.", "whcom"); ?>
                                </div>
                            </div>


                            <?php
                            $response = wcap_get_domain_whois_info("domainid=" . $_POST["id"]);
                            ?>

                            <form id="update_whois_form">
                                <input type="hidden" name="action" value="wcap_requests">
                                <input type="hidden" name="what" value="update_wohis_info">
                                <input type="hidden" name="domainid" value="<?php echo $_POST["id"] ?>">
                                <?php
                                $countries = wcap_get_countries(); ?>
                                <div class="whcom_tabs_container">

                                    <ul class="whcom_tabs">
                                        <?php
                                        $active = 'current';
                                        foreach ($response as $key => $data) {
                                            if ($key == "result") {
                                                continue;
                                            } ?>
                                            <li data-tab="<?php echo 'contact_' . $key; ?>"
                                                class="<?php echo $active; ?>"><?php echo $key; ?></li>
                                            <?php
                                            $active = '';
                                        }
                                        ?>
                                    </ul>

                                    <?php
                                    $active = 'current';
                                    foreach ($response as $key => $data) {
                                        if ($key == "result") {
                                            continue;
                                        } else if (is_array($data)) { ?>
                                            <div id="<?php echo 'contact_' . $key; ?>"
                                                 class=" <?php echo $active; ?> wcap_tab_content">
                                                <div class="wcap_sub_heading">
                                                    <h3><?php echo __($key . " Contact", "wcap") ?></h3>
                                                </div>
                                                <?php foreach ($data as $k => $v) {
                                                    /*if ( $k == "Full_Name" ) {
                                                        $k = "Name";
                                                    }
                                                    if ($k=="Company_Name") $k="Company";
                                                    if ($k=="Address_1") $k="Address1";
                                                    if ($k=="Address_2") $k="Address2";
                                                    if ($k=="Postcode") $k="Zip";
                                                    if ($k=="Phone_Country_Code") $k="Tel_Country_Code";
                                                    if ($k=="Phone_Number") $k="Telephone";*/
                                                    ?>
                                                    <div class="whcom_form_field">
                                                        <label for="form_field_2"
                                                               class="main_label"><?php echo str_replace("_", " ", $k) ?></label>
                                                        <label class="main_label">

                                                        </label>
                                                        <?php if ($k == "Country") { ?>
                                                            <select name="<?php echo $key ?>[<?php echo $k ?>]">
                                                                <?php foreach ($countries as $ck => $country) {
                                                                    $S = $ck == $v ? "selected=selected" : "";
                                                                    ?>
                                                                    <option value="<?php echo $ck ?>" <?php echo $S ?>>
                                                                        <?php echo $country ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <input name="<?php echo $key ?>[<?php echo $k ?>]"
                                                                   value="<?php echo $v ?>">
                                                        <?php } ?>
                                                    </div>
                                                    <?php if ($k == "Address_2" || $k == "Address2") { ?>
                                                        <div class="whcom_form_field">
                                                            <label for="form_field_2" class="main_label">
                                                                <?php esc_html_e("Address 2", "whcom"); ?>
                                                            </label>
                                                            <input name="<?php echo $key ?>[Address_3]" value="">
                                                        </div>
                                                    <?php }
                                                }
                                                $active = ''; ?>
                                            </div>
                                            <?php
                                        }
                                    } ?>
                                </div>
                                <div class="whcom_form_field whcom_text_center">
                                    <button class="whcom_button"><?php esc_html_e("Save Changes", "whcom") ?></button>
                                    <button class="whcom_button whcom_button_secondary"
                                            type="reset"><?php esc_html_e("Cancel Changes", "whcom"); ?></button>
                                </div>
                            </form>
                        <?php } ?>

                        <?php if ($do == "epp") { ?>
                            <div>
                                <h3> <?php esc_html_e("Domain EPP Code", "whcom") ?></h3>
                                <div class="whcom_margin_bottom_30">
                                    <?php esc_html_e("The EPP Code is basically a password for a domain name. It is a security measure, ensuring that only the domain name owner can transfer a domain name. You will need it if you are wanting to transfer the domain to another registrar.", "whcom"); ?>
                                </div>
                                <?php
                                $response = wcap_get_domain_epp_code($domain_id);

                                if ($response["status"] == "OK") {
                                    echo wcap_render_message("",
                                        esc_html__("The EPP Code for your domain is:", "whcom") . " " . $response["message"],
                                        "warning");
                                } elseif ($response["status"] == "ERROR") {
                                    echo wcap_render_message("", $response["message"], "danger");
                                }
                                ?>

                            </div>

                        <?php } ?>


                    <?php } ?>
                <?php } ?>

            </div>


        </div>
    </div>
</div>




