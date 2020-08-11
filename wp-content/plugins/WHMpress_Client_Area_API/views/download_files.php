<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("addons", true);

$args = [
    "catid" => $_POST['catid'],
];
$response = wcap_get_download_files($args);

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
                <span><?php esc_html_e("Downloads", "whcom" ) ?></span>
            </div>

            <?php if ($response["status"] != "OK") { ?>
                <div class="whcom_alert whcom_alert_danger whcom_text_center">
                    <?php echo $response["message"] ?>
                </div>
            <?php } ?>

            <?php if ($response["status"] == "OK") { ?>
                <?php //main content ?>
                <h3><?php esc_html_e("Files", "whcom" ) ?></h3>
                <div class="whcom_margin_bottom_15">

                    <div class="whcom_panel">
                        <div class="whcom_panel_body whcom_has_list">
                            <ul class="whcom_tab_links whcom_list_fancy whcom_list_bordered whcom_list_hover whcom_list_padded">

                                <?php foreach ($response["data"] as $key => $file) {
                                    $args=[
                                        'goto'                  => "dl.php?type=d&id=" . $file["id"] ,
                                        'append_no_redirect'    => 'yes'
                                    ];
                                    $link =whcom_generate_auto_auth_link($args);
                                    //$link = $thi->generate_auto_auth_url("dl.php?wcap_no_redirect=1&id=" . $file["id"] . "&type=d");
                                    ?>

                                    <li>
                                        <a class="" href="<?php echo $link ?>">
                                            <i class="whcom_icon_download"></i>
                                            <strong><?php echo $file["title"] ?></strong><br>
                                            <?php echo $file["description"] ?><br>
                                            <?php echo esc_html__("Type", "whcom" ) . ": " . $file["type"] ?><br>
                                        </a>
                                    </li>

                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                </div>
            <?php } ?>

        </div>
    </div>
</div>



