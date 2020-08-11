<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("my_quotes");

$currency = whcom_get_current_currency();
$args = array(
    "userid" => whcom_get_current_client_id()
    //"stage"=>array('Delivered','On Hold','Accepted','Lost','Dead'),
);

$response = wcap_get_quotes($args);


if ($response["result"] == "success") {
    $quotes = $response;
} else {
    wcap_show_error($response["result"]);
}


/// count status
$fill_array = [
    "All" => "0",
    "Delivered" => "0",
    "Accepted" => "0",
    "Expired" => "0",
];
$status_array = wcap_count_stage($fill_array, $quotes["quotes"]["quote"]);


?>


<div class="wcap_billings">
    <div class="wcap whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <div class="whcom_panel">
                    <div class="whcom_panel_header whcom_has_icon">
                        <i class="whcom_icon_filter whcom_header_icon"></i><?php esc_html_e('Status', "whcom") ?>
                    </div>
                    <div class="whcom_panel_body whcom_has_list">
                        <ul class="whcom_list_wcap_style_2">
                            <li>
                                <a class="wcap_invoices_filter" data-status=""
                                   href="#"><?php esc_html_e('All', "whcom") ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["All"]; ?></span></a>
                            </li>

                            <li>
                                <a class="wcap_invoices_filter" data-status="Delivered"
                                   href="#"><?php esc_html_e('Delivered', "whcom") ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["Delivered"]; ?></span></a>
                            </li>
                            <li>
                                <a class="wcap_invoices_filter" data-status="Accepted"
                                   href="#"><?php esc_html_e('Accepted', "whcom") ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["Accepted"]; ?></span></a>
                            </li>

                            <li>
                                <a class="wcap_invoices_filter" data-status="Expired"
                                   href="#"><?php esc_html_e('Expired', "whcom") ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["Expired"]; ?></span></a>
                            </li>

                        </ul>
                    </div>
                </div>

                <?php wcap_render_billing_panel(); ?>
            </div>
        <?php } ?>

        <div class="<?php echo ($show_sidebar) ? "whcom_col_sm_9" : "whcom_col_12" ?>">

            <div class="whcom_page_heading">
                <?php esc_html_e("My Quotes", "whcom") ?>
            </div>
            <div class="wcap_domains_table whcom_table whcom_margin_bottom_15">

                <table class="dt-responsive wcap_responsive_table whcom_table data_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th><?php esc_html_e("Quote", "whcom") ?></th>
                        <th><?php esc_html_e("Subject", "whcom") ?></th>
                        <th><?php esc_html_e("Date Created", "whcom") ?></th>
                        <th><?php esc_html_e("Valid Until", "whcom") ?></th>
                        <th><?php esc_html_e("Stage", "whcom") ?></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($quotes["quotes"]["quote"] as $quote) {
                        //$link = $thi->generate_auto_auth_url("dl.php?wcap_no_redirect=1&id=" . $quote["id"] . "&type=q");

                        $args = [
                            'goto' => "dl.php?id=" . $quote["id"] . "&type=q",
                            'append_no_redirect' => 'yes'
                        ];
                        $link = whcom_generate_auto_auth_link($args);

                        if ($quote["stage"] != "Draft") {
                            if ($quote["stage"] == "Dead" || $quote["stage"] == "Lost") {
                                $quote["stage"] = "Expired";
                            }

                            if (strtolower($quote["stage"]) == 'expired') {
                                $stage_class = "whcom_pill_block whcom_pill_none";
                            } else if (strtolower($quote["stage"]) == 'accepted') {
                                $stage_class = "whcom_pill_block whcom_pill_success";
                            } else if (strtolower($quote["stage"]) == 'delivered') {
                                $stage_class = "whcom_pill_block whcom_pill_info";
                            }

                            ?>
                            <tr data-status="<?php echo $quote["stage"]; ?>">
                                <td><?php echo $quote["id"] ?></td>
                                <td><?php echo $quote["subject"] ?></td>
                                <td><?php echo wcap_date_ml($quote["datecreated"]) ?></td>
                                <td><?php echo wcap_date_ml($quote["validuntil"]) ?></td>
                                <td>
                                    <span class="<?php echo $stage_class ?>"> <?php echo wcap_status_ml($quote["stage"]) ?></span>
                                </td>
                                <td><a class="whcom_button whcom_icon_download"
                                       href="<?php echo $link ?>"> <?php esc_html_e("Download", "whcom"); ?></a></td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
