<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("tickets", true);

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}

$depts = whcom_get_all_departments();
$depts_array = [];
foreach ($depts as $dept) {
    $depts_array[$dept["id"]] = $dept["name"];
}

$tickets = wcap_get_tickets([
    "clientid" => whcom_get_current_client_id(),
    //"limitnum" => 99999,
]);

// count tickets
$fill_array = [
    "All" => "0",
    "Open" => "0",
    "Answered" => "0",
    "Customer-Reply" => "0",
    "Closed" => "0"
];
$status_array = wcap_count_status($fill_array, $tickets["tickets"]["ticket"]);


?>

<div class="wcap_tickets">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <div class="whcom_panel">
                    <div class="whcom_panel_header whcom_has_icon">
                        <i class="whcom_icon_filter panel_header_icon"></i><?php esc_html_e('View', "whcom" ) ?>
                    </div>

                    <div class="whcom_panel_body whcom_has_list">
                        <ul class="whcom_list_wcap_style_2">

                            <li>
                                <a class="wcap_tickets_filter" data-status=""
                                   href="#"><?php esc_html_e('All', "whcom" ); ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["All"]; ?></span>

                                </a>
                            </li>

                            <li>
                                <a class="wcap_tickets_filter" data-status="Open"
                                   href="#"><?php esc_html_e('Open', "whcom" ) ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["Open"]; ?></span>
                                </a>

                            </li>
                            <li>
                                <a class="wcap_tickets_filter" data-status="Answered"
                                   href="#"><?php esc_html_e('Answered', "whcom" ) ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["Answered"]; ?></span></a>
                            </li>
                            <li>
                                <a class="wcap_tickets_filter" data-status="Customer-Reply"
                                   href="#"><?php esc_html_e('Customer-Reply', "whcom" ) ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["Customer-Reply"]; ?></span></a>
                            </li>
                            <li>
                                <a class="wcap_tickets_filter" data-status="Closed"
                                   href="#"><?php esc_html_e('Closed', "whcom" ) ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["Closed"]; ?></span></a>
                            </li>


                        </ul>
                    </div>
                </div>

                <?php wcap_render_support_panel(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("My Support Tickets ", "whcom" ) ?></span>
            </div>

            <?php //main content ?>
            <div class="whcom_margin_bottom_15">
                <div class="wcap_domains_table whcom_table whcom_margin_bottom_15">
                    <table class="dt-responsive wcap_responsive_table data_table" style="width: 100%">
                        <thead>
                        <tr>
                            <!--<th>Ticket ID</th>-->
                            <th><?php esc_html_e("Department", "whcom" ) ?></th>
                            <th><?php esc_html_e("Subject", "whcom" ) ?></th>
                            <th><?php esc_html_e("Status", "whcom" ) ?></th>
                            <!--<th>Priority</th>-->
                            <th><?php esc_html_e("Last Updated", "whcom" ); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($tickets["tickets"]["ticket"] as $ticket) {
                            ?>
                            <tr data-status="<?php echo $ticket["status"]; ?>" style="cursor: pointer;"
                                data-id="<?php echo $ticket["tid"] ?>" class="wcap_load_single_ticket"
                                data-page="viewticket">
                                <!--<td><?php /*echo $ticket["tid"] */ ?></td>-->
                                <td><?php echo $depts_array[$ticket["deptid"]] ?></td>
                                <td>
                                    <?php echo "<i>#" . $ticket["tid"] . "</i>" . "<br>" . $ticket["subject"] ?>
                                </td>
                                <td>
                                    <span class="whcom_pill_block whcom_pill_<?php echo wcap_ticket_status_color($ticket["status"]) ?>">
                                    <?php echo wcap_status_ml($ticket["status"]) ?>
                                </span>

                                </td>
                                <!--<td><?php /*echo $ticket["priority"] */ ?></td>-->
                                <td>
                                    <div><?php echo wcap_date_ml($ticket["lastreply"]) ?></div>
                                    <div><?php echo wcap_time($ticket["lastreply"]) ?></div>
                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>

