<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar( "downloads", true );

$response = wcap_get_download_cats();


?>

<div class="wcap_services ">
    <div class="whcom_row">
        <?php if ( $show_sidebar ) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_support_panel(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ( $show_sidebar ) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("Downloads", "whcom" ) ?></span>
            </div>

            <?php //main content ?>
            <div class="whcom_margin_bottom_30">
                <h3><?php esc_html_e("Categories", "whcom" ) ?></h3>

                <?php if ($response["status"] != "OK") { ?>
                    <div class="whcom_alert whcom_alert_danger whcom_text_center">
                        <?php echo $response["message"] ?>
                    </div>
                <?php } ?>

                <?php if ($response["status"] == "OK") { ?>
                    <?php foreach ($response["data"] as $key => $category) {
                        ?>
                        <div class="whcom_margin_bottom_30">

                            <div>
                                <i class="whcom_icon_folder-empty"></i>
                                <a href="?catid=<?php echo $category["id"] ?>" class="wcap_load_page" data-page="download_files">
                                    <?php echo $category["name"] ?>
                                </a>
                            </div>

                            <div>
                                <?php echo $category["description"] ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>



