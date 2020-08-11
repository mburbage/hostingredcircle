<?php
/*
 *  Email History > thorugh WHMPress helper
 */

//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("addons", true);

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}


$userid = whcom_get_current_client_id();
$args= ['userid' => $userid];

$response = wcap_get_email_history($args);


?>


<div class="wcap_email_history">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_profile_panel(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("Email History", "whcom" ) ?></span>
            </div>

            <?php //main content ?>
            <div class="whcom_margin_bottom_15">
                <?php if ($response["status"] != "OK") { ?>
                    <div class="whcom_alert whcom_alert_danger whcom_text_center">
                        <?php echo $response["message"] ?>
                    </div>
                <?php } ?>

                <?php if ($response["status"] == "OK") { ?>
                    <div class="wcap_services_table whcom_table whcom_margin_bottom_15">
                        <table class="dt-responsive wcap_responsive_table data_table" style="width: 100%">
                            <thead>
                            <tr>
                                <th><?php esc_html_e("Date Sent", "whcom" ) ?></th>
                                <th><?php esc_html_e("Message Subject", "whcom" ) ?></th>
                                <th><?php esc_html_e("View", "whcom" ) ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($response["data"] as $key => $email) {

                                $args=[
                                    'goto'                  => "viewemail.php?id=" . $email["id"] . "&wcap_iframe",
                                    'append_no_redirect'    => 'yes'
                                ];
                                $link =whcom_generate_auto_auth_link($args);


                                ?>
                                <tr>
                                    <td>
                                        <?php echo $email["date"]; ?>
                                    </td>
                                    <td class="whcom_text_left">
                                        <?php
                                        //$subject = str_replace("`", "[", $email["subject"]);
                                        //$subject = str_replace("'", "]", $subject);
                                        // $subject="";
                                        ?>

                                        <div> <?php echo $email["subject"] ?></div>

                                    </td>
                                    <td class="whcom_text_center">
                                        <a class="ifancybox btn whcom_button" href="<?php echo $link ?>">
                                            <?php esc_html_e("View Message", "whcom" ) ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>

            </div>


        </div>
    </div>
</div>

