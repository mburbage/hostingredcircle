<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("order_new_services");

$domain_id = $_POST["domain_id"];
$addon_type = $_POST["addon_type"];

$settings = whcom_get_whmcs_setting();


$client_id = whcom_get_current_client_id();
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

if ($addon_type == "idprotection") {
    $addon_title = esc_html__("ID Protection", "whcom");
    $addon_description = esc_html__("Protect your personal information and reduce the amount of spam to your inbox by enabling ID Protection.", "whcom");
    $addon_price = whcom_format_amount($settings["DomainIDProtection"]);
}

if ($addon_type == "emailforwarding") {
    $addon_title = esc_html__("Email Forwarding", "whcom");
    $addon_description = esc_html__("Get emails forwarded to alternate email addresses of your choice so that you can monitor all from a single account.", "whcom");
    $addon_price = whcom_format_amount($settings["DomainEmailForwarding"]);
}

if ($addon_type == "dnsmanagement") {
    $addon_title = esc_html__("DNS Host Record Management", "whcom");
    $addon_description = esc_html__("External DNS Hosting can help speed up your website and improve availability with increased redundancy.", "whcom");
    $addon_price = whcom_format_amount($settings["DomainDNSManagement"]);
}

?>

<div class="wcap_services ">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php
                wcap_render_categories_panel();
                wcap_render_domains_panel_action();
                ?>

            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <?php
                esc_html_e("Manage", "whcom");
                echo " " . $domain_name;
                ?>
            </div>

            <?php //main content ?>
            <div class="whcom_margin_bottom_15">
                <h3> <?php echo $addon_title ?></h3>

                <div class="whcom_alert whcom_alert_info whcom_text_center">
                    <?php echo esc_html_e("Domain:", "whcom"); ?>
                    <span class="whcom_text_bold"> <?php echo $domain_name ?></span>
                </div>

                <div> <?php echo $addon_description ?></div>

                <form id="order_domain_addons_form">
                    <input type="hidden" name="action" value="wcap_requests">
                    <input type="hidden" name="what" value="order_domain_addon">
                    <input type="hidden" name="domainid" value="<?php echo $domain_id ?>">
                    <input type="hidden" name="addon_type" value="<?php echo $addon_type ?>">
                    <input type="hidden" name="addon_price" value="<?php echo $addon_price ?>">
                    <div>
                        <div class="whcom_form_field whcom_text_center">
                            <button class="whcom_button <?php echo $button_class ?>">
                                <?php echo esc_html__("Buy Now for", "whcom") . " " . $addon_price ?>
                            </button>
                        </div>
                    </div>
                </form>


            </div>
            <div id="output">

            </div>

        </div>
    </div>
</div>






