<?php
//page initialization, veriables for whole page

$client_area_url = get_option("wcapfield_after_logout_redirect_url", '');

$show_sidebar = wcap_show_side_bar("home");

$client_row = wcap_get_clients_details("clientid=" . whcom_get_current_client_id());
$service_response = wcap_get_client_products("clientid=" . whcom_get_current_client_id());

if ($service_response["result"] == "error") {
    $service_response = [];
    $service_response["active_services"] = 0;
}


$domains = wcap_get_client_domains("clientid=" . whcom_get_current_client_id());
$active_domains = 0;
if (is_string($domains)) {
    $domains = [];
    $domains["totalresults"] = 0;
}
foreach ($domains["domains"]["domain"] as $row) {
    if ($row["status"] == "Active") {
        $active_domains++;
    }

}

$tickets = wcap_get_tickets("limitnum=9999&clientid=" . whcom_get_current_client_id());
$open_tickets = 0;

if (isset($tickets["tickets"]["ticket"]) && is_array($tickets["tickets"]["ticket"])) {
    foreach ($tickets["tickets"]["ticket"] as $ticket) {
        if (($ticket["status"] == "Open") || ($ticket["status"] == "Customer-Reply")) {
            $open_tickets++;
        }
    }
}


$invoices = wcap_get_invoices("status=Unpaid&userid=" . whcom_get_current_client_id());
if (isset($invoices["invoices"]["invoice"]) && is_array($invoices["invoices"]["invoice"])) {
    $invoices = count($invoices["invoices"]["invoice"]);
} else {
    $invoices = 0;
}

?>


<div class="wcap_services ">
    <?php echo wcap_verify_client(); echo wcap_verify_client_check(); ?>
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <div class="whcom_panel">
                    <div class="whcom_panel_header whcom_has_icon ">
                        <i class="whcom_icon_user-3 panel_header_icon"></i><?php esc_html_e('Your info', "whcom") ?>
                    </div>
                    <div class="whcom_panel_body">
                        <div>
                            <strong><?php echo $client_row['client']['companyname'] ?></strong>
                        </div>

                        <div>
                            <em>
                                <?php echo $client_row['client']['fullname'] ?></em><br>
                            <?php echo $client_row['client']['address1'] ?><br>
                            <?php echo $client_row['client']['address2'] ?><br>
                            <?php echo $client_row['client']['city'] . ", " . $client_row['client']['fullstate'] . ", " . $client_row['client']['postcode'] ?>
                            <br>
                            <?php echo $client_row['client']['countryname'] ?>
                        </div>

                    </div>
                    <div class="whcom_panel_footer">
                        <a class="whcom_button whcom_button_small whcom_button_success whcom_button_block wcap_load_page"
                           data-page="profile" href="#">
                            <i class="whcom_icon_pencil"></i> <?php esc_html_e('Update', "whcom") ?></a>
                    </div>
                </div>
                <div class="whcom_panel side_bar_bottom">
                    <div class="whcom_panel_header whcom_has_icon side_bar_bottom">
                        <i class="whcom_icon_bookmark panel_header_icon"></i> <?php esc_html_e('Shortcuts', "whcom") ?>
                    </div>
                    <div class="whcom_panel_body whcom_has_list side_bar_bottom">
                        <ul class="whcom_list_wcap_style_1">
                            <li>
                                <a class="wcap_load_page" data-page="order_new_service"
                                   href="#"><?php esc_html_e('Order New Services', "whcom") ?></a>
                                <i class="whcom_icon_basket-1"></i>
                            </li>


                            <?php
                            /*
                             * Assign WCAP_IS_WCOP_ACTIVE function to $wcop_active variable
                             * Author: zain
                             */
                            $wcop_active=wcap_is_wcop_active();
                            //todo: move this sidebar in function
                            if ($wcop_active) {
                                $class = "";
                                $field = 'configure_product' . whcom_get_current_language();
                                $base_url = esc_attr(get_option($field, ''));

                                $services_data = "";
                                $services_url = $base_url . "?order_type=order_product";

                                $domains_register_data = "";
                                $domains_register_url = $base_url . "?order_type=order_domain";

                                $domains_transfer_data = "";
                                $domains_transfer_url = $base_url . "?order_type=order_domain&domain=transfer";

                            } else {
                                $class = "wcap_load_page";

                                $services_data = "order_new_service";
                                $services_url = "";

                                $domains_register_data = "order_process";
                                $domains_register_url = "a=add&domain=register";

                                $domains_transfer_data = "order_process";
                                $domains_transfer_url = "a=add&domain=transfer";
                            }
                            ?>

                            <li>
                                <a class="<?php echo $class ?>" data-page="<?php echo $domains_register_data ?>"
                                   href="<?php echo $domains_register_url ?>"><?php esc_html_e('Register a New Domain', "whcom") ?></a>
                                <i class="whcom_icon_globe-1"></i>
                            </li>
                            <li>
                                <a class="whcom_client_logout"
                                   data-page="process_logout"
                                   href="<?php echo $client_area_url ?>"
                                   id="whmcs_logout_btn"
                                >
                                    <?php esc_html_e('Logout', "whcom") ?></a>

                                <i class="whcom_icon_left-big"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="whcom_panel_footer whcom_text_right"></div>
                </div>

            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <?php echo esc_html__("Welcome Back", "whcom") . ", " . $client_row['client']['firstname'] ?>
            </div>
            <?php //main content ?>
            <div class="wcap_services ">
                <div class="wcap_services_boxes whcom_clearfix whcom_row whcom_row_no_gap">
                    <div class="whcom_col_sm_3">
                        <div class="wcap_service_box">
                            <i class="whcom_icon_cube wcap_service_icon"></i>
                            <div class="wcap_service_box_qty">
                                <span><?php echo $service_response["active_services"]; ?></span>
                            </div>
                            <div class="wcap_service_box_title">
                                <a class="wcap_load_page" data-page="services"
                                   href="#"><?php esc_html_e("Services", "whcom") ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="whcom_col_sm_3">
                        <div class="wcap_service_box">
                            <i class="whcom_icon_globe-1 wcap_service_icon"></i>
                            <div class="wcap_service_box_qty">
                                <span><?php echo $active_domains ?></span>
                            </div>
                            <div class="wcap_service_box_title">
                                <a class="wcap_load_page" data-page="domains"
                                   href="#"><?php esc_html_e("Domains", "whcom") ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="whcom_col_sm_3">
                        <div class="wcap_service_box">
                            <I class="whcom_icon_chat wcap_service_icon"></I>
                            <div class="wcap_service_box_qty">
                                <span><?php echo $open_tickets ?></span>
                            </div>
                            <div class="wcap_service_box_title">
                                <a class="wcap_load_page" data-page="tickets"
                                   href="#"><?php esc_html_e("Tickets", "whcom") ?></a>
                            </div>
                        </div>
                    </div>

                    <div class="whcom_col_sm_3">
                        <div class="wcap_service_box">
                            <I class="whcom_icon_credit-card wcap_service_icon"></I>
                            <div class="wcap_service_box_qty">
                                <span><?php echo $invoices; ?></span>
                            </div>
                            <div class="wcap_service_box_title">
                                <a class="wcap_load_page" data-page="my_invoices"
                                   href="#"><?php esc_html_e("My Invoices", "whcom") ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wcap_dashboard_panels">
                <div class="whcom_row">
                    <div class="whcom_col_sm_6">
                        <div class="whcom_panel whcom_panel_fancy_1 whcom_panel_success">
                            <div class="whcom_panel_header whcom_has_icon">
                                <i class="whcom_icon_cube panel_header_icon"></i>
                                <?php esc_html_e('Your Active Products/Services', "whcom") ?>
                                <a href=""
                                   class="whcom_button whcom_button_success whcom_button_small whcom_pull_right
                                    wcap_load_page"
                                   data-page="services"
                                ><?php esc_html_e('View All', "whcom") ?></a>
                                <div style="clear: both;"></div>
                            </div>
                            <div class="whcom_panel_body whcom_has_list whcom_panel_body_max_height_400">
                                <?php
                                if ($service_response["active_services"] > 0) { ?>
                                    <ul class="whcom_list_wcap_style_2">
                                        <?php foreach ($service_response['products']['product'] as $product) {
                                            if ($product['status'] == 'Active') { ?>
                                                <li>
                                                    <a href="?id=<?php echo $product["id"] ?>" class="wcap_load_page "
                                                       data-page="productdetails">
                                                        <?php echo $product['translated_name'] ?>
                                                        - <?php echo $product['groupname'] ?><br>
                                                        <span class="text-domain"><?php echo $product['domain'] ?></span>
                                                    </a>
                                                </li>
                                            <?php }
                                        } ?>
                                    </ul>
                                    <?php
                                } else {
                                    esc_html_e('No Products Found', "whcom");
                                }
                                ?>
                            </div>
                            <div class="whcom_panel_footer"></div>
                        </div>
                    </div>
                    <div class="whcom_col_sm_6">
                        <div class="whcom_panel whcom_panel_fancy_1 whcom_panel_primary">
                            <div class="whcom_panel_header whcom_has_icon">
                                <i class="whcom_icon_chat panel_header_icon"></i>
                                <?php esc_html_e('Recent Support Tickets', "whcom") ?>
                                <a href="" class="whcom_button whcom_button_small whcom_pull_right wcap_load_page"
                                   data-page="submitticket">
                                    <i class="whcom_icon_plus"></i> <?php esc_html_e('Open New Ticket', "whcom") ?>
                                </a>
                                <div style="clear: both;"></div>
                            </div>
                            <div class="whcom_panel_body whcom_has_list whcom_panel_body_max_height_400">
                                <?php if (isset($tickets["tickets"]["ticket"]) && is_array($tickets["tickets"]["ticket"]) && !empty($tickets["tickets"]["ticket"])) { ?>
                                    <ul class="whcom_list_wcap_style_2">
                                        <?php $count = 0; ?>
                                        <?php foreach ($tickets["tickets"]["ticket"] as $ticket) { ?>
                                            <?php
                                            $count++;
                                            if ($count > 10) {
                                                break;
                                            }
                                            $status_class = "whcom_button_" . wcap_ticket_status_color($ticket['status']);
                                            ?>
                                            <li>
                                                <a data-id="<?php echo $ticket["tid"] ?>"
                                                   class="wcap_load_single_ticket"
                                                   data-page="viewticket">
                                                    <strong>#<?php echo $ticket["tid"] ?>
                                                        - <?php echo $ticket["subject"] ?></strong>
                                                    <label class="whcom_button_micro whcom_button whcom_pull_right <?php echo $status_class; ?>">
                                                        <?php echo $ticket["status"] ?></label><br>
                                                    <small><?php echo $ticket["lastreply"] ?></small>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } else {
                                    esc_html_e('No Ticket Found', "whcom");
                                } ?>
                            </div>
                            <div class="whcom_panel_footer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





