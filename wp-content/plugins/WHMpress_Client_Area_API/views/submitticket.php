<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("openticket", true);

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}
$depts = whcom_get_all_departments();

?>

<div class="wcap_knowledgebase ">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_support_panel(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("Open Ticket", "whcom" ) ?></span>
            </div>

            <?php //main content ?>
            <div class="whcom_margin_bottom_15">
                <div class="whcom_margin_bottom_15">
                    <?php esc_html_e("If you can't find a solution to your problems in our knowledgebase, you can submit a ticket by selecting the appropriate department below.","whcom" );?>
                </div>

                <?php foreach ($depts as $dept) { ?>
                <div class="whcom_panel">
                    <div class="whcom_panel_body">
                        <div class="whcom_text_bold whcom_margin_bottom_15">
                            <i class="whcom_icon_mail-2"></i>
                            <a href="#" class="wcap_load_page" data-page="open_ticket2" data-id="<?php echo $dept["id"] ?>"><?php echo $dept["name"]?></a>
                        </div>
                        <div class="whcom_margin_bottom_15"><?php printf(esc_html__('Ticket Related to %1$s',"whcom" ),$dept['name']);?> </div>

                    </div>
                </div>
                <?php } ?>


            </div>


        </div>
    </div>
</div>




