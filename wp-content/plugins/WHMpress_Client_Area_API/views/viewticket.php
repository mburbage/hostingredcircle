<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("tickets", true);

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}


if (!isset($_POST["tid"])) {
    echo "Ticket ID missng";
    exit;
}

$ticket = wcap_get_ticket("ticketnum=" . $_POST["tid"]);
if (!is_array($ticket)) {
    echo "Invalid ticket!<br>";
    echo $ticket;
    exit;
}

include_once(WCAP_PATH . '/library/Parsedown.php');
$parse = new Parsedown();


?>

<div class="wcap_knowledgebase ">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_ticket_info($ticket) ?>
                <?php wcap_render_support_panel(); ?>

            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("View Ticket", "whcom" ) ?></span>
            </div>

            <?php //main content ?>
            <div class="whcom_margin_bottom_15">

                <div onclick="jQuery('#reply_ticket_form_div').slideToggle();"
                     style="padding:10px;text-align: center;cursor: pointer; margin-bottom: 15px;">
                    <button class="whcom_button_block whcom_icon_plus whcom_button_info"> <?php esc_html_e("Add Reply", "whcom" ) ?></button>
                </div>
                <div id="reply_ticket_form_div" class="whcom_margin_bottom_15"  style="display: none;">
                    <form id="reply_ticket_form">
                        <input type="hidden" name="action" value="wcap_requests">
                        <input type="hidden" name="what" value="reply_ticket">
                        <input type="hidden" name="ticketid" value="<?php echo $ticket["ticketid"] ?>">
                        <input type="hidden" name="userid" value="<?php echo whcom_get_current_client_id() ?>">
                        <div class="whcom_row">
                            <div class="whcom_col_sm_6">
                                <div class="whcom_form_field ">
                                    <label class="main_label"><?php esc_html_e('Name', "whcom" ) ?></label>
                                    <input name="name" readonly="readonly" value="<?php echo $ticket["name"] ?>">
                                </div>
                            </div>
                            <div class="whcom_col_sm_6">
                                <div class="whcom_form_field ">
                                    <label class="main_label"><?php esc_html_e('Email Address', "whcom" ) ?></label>
                                    <input name="email" readonly="readonly" value="<?php echo $ticket["email"] ?>">
                                </div>
                            </div>
                            <div class="whcom_col_sm_12">
                                <div class="whcom_form_field ">
                                    <label class="main_label"><?php esc_html_e('Message', "whcom" ) ?></label>
                                    <textarea name="message" id="wcap_reply_editor" rows="6"
                                              style="max-width: 100%;"></textarea>
                                </div>
                            </div>
                            <div class="whcom_col_sm_12 whcom_text_center">
                                <div class="whcom_form_field ">
                                    <button>
                                        <?php esc_html_e('Submit', "whcom" ) ?>
                                    </button>
                                    <button class="whcom_button_secondary" type="reset" onclick="jQuery('#reply_ticket_form_div').slideToggle();">
                                        <?php esc_html_e('Cancel', "whcom" ) ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                <?php foreach ($ticket["replies"]["reply"] as $reply) { ?>
                    <div class="whcom_panel">
                        <div class="whcom_panel_header">
                            <div class="whcom_row">
                                <div class="whcom_col_sm_6 whcom_text_small whcom_icon_user-3">
                                    <?php echo $reply["name"] ?><br>
                                    <?php echo $reply["email"] ?>

                                </div>
                                <div class="whcom_col_sm_6 whcom_text_right whcom_text_small">
                                    <?php echo wcap_datetime($reply["date"]) ?>
                                </div>
                            </div>

                        </div>
                        <div class="whcom_panel_body" id="message_body">
                            <?php echo nl2br($parse->text($reply["message"])) ?>
                        </div>
                    </div>
                <?php } ?>


            </div>


        </div>
    </div>
</div>


<script>
    simplemde = new SimpleMDE({element: jQuery('.wcap_md_editor')[0]});
</script>

