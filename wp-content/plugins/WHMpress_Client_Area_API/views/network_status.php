<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("network_status");


//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}

$response = wcap_get_network_status();

$event_status = [
    "Reported" => ""
];

$event_priority = [
    "Critical" => "danger",
    "Low" => "success",
    "Medium" => "info",
    "High" => "warning",
]

?>

<div class="wcap_services ">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_support_panel(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("Network Status", "whcom" ) ?></span>
            </div>

            <?php if ($response["status"] != "OK") { ?>
                <div class="whcom_alert whcom_alert_danger whcom_text_center">
                    <?php echo $response["message"] ?>
                </div>
            <?php } ?>

            <?php if ($response["status"] == "OK") { ?>
                <?php //main content ?>
                <div class="whcom_margin_bottom_15">
                    <?php foreach ($response["data"] as $key => $event) { ?>
                        <div class="whcom_panel whcom_margin_bottom_15 whcom_panel_fancy_2 whcom_panel_<?php echo $event_priority[$event["priority"]]; ?> ">
                            <div class="whcom_panel_header">
                                <span><?php echo $event["title"] . " - " . $event["status"] ?></span>
                            </div>
                            <div class="whcom_panel_body whcom_has_list whcom_list_">
                                <ul class="whcom_list_bordered whcom_list_padded">
                                    <li class='whcom_alert whcom_alert_" <?php echo $event_priority[$event["priority"]] ?> " '>
                                        <strong> <?php echo __("Priority", "whcom" ) ?> </strong>
                                        - <?php echo $event["priority"] ?>
                                    </li>

                                    <?php if ($event["type"] == 'Server') { ?>
                                        <li>
                                            <strong> <?php echo __("Affecting", "whcom" ) ?> Server </strong>
                                            - <?php echo $event["name"] ?>
                                        </li>
                                    <?php } ?>
                                    <?php if ($event["type"] != 'Server') { ?>
                                        <li>
                                            <strong> <?php echo __("Affecting", "whcom" ) . " " . $event["type"] ?> </strong>
                                            - <?php echo $event["affecting"] ?>
                                        </li>
                                    <?php } ?>

                                    <li>
                                        <?php echo $event["description"] ?>
                                    </li>

                                    <li><strong> <?php echo __("Date", "whcom" ) . " - " ?> </strong>
                                        <span>
                                            <?php echo $event["startdate"] ?>
                                        </span>

                                        <span>
                                            <?php echo $event["enddate"] ?>
                                        </span>

                                    </li>

                                    <li>
                                        <strong> <?php echo __("Last updated", "whcom" ) . " - "; ?></strong>
                                        <?php echo $event["lastupdate"] ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

        </div>
    </div>
</div>







