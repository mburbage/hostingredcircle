<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("openticket", true);
$response['id'] = $_SESSION['response_id'];

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}

$current_user = whcom_get_current_client();
// echo "<pre>".print_r($current_user,true)."</pre>";

?>

<div class="wcap_open_ticket2">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_support_panel(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("Open Ticket", "whcom") ?></span>
            </div>

            <?php //main content ?>
            <div id="open_ticket_message" class=""></div>
            <!-- div to accept the response either ticket is created successfully or not -->
            <div id="ticket_response" class=""></div>
            <div id="success-message">
                <div class="whcom_alert whcom_alert_success whcom_text_large">
                    <span class="whcom_icon_ok-circled"></span>
                    <span> <?php echo esc_html_x("New ticket has been created, Ticket # ", "whcom") . $response['id'] ?> </span>
                </div>
                <div class="whcom_text_center">
                    <button class="whcom_button whcom_button_primary wcap_load_page" data-page="tickets">
                        <?php echo esc_html_x("View All Ticket", "whcom") ?> </button>
                </div>
            </div>
            <form id="open_ticket_form">
                <input type="hidden" name="action" value="wcap_requests">
                <input type="hidden" name="what" value="open_new_ticket">
                <div class="whcom_row">
                    <div class="whcom_col_sm_6">
                        <div class="whcom_form_field ">
                            <label class="main_label"><?php esc_html_e('Name', "whcom") ?></label>
                            <input type="text" name="name" readonly="readonly"
                                   value="<?php echo $current_user["fullname"]; ?>" style="max-width: 100%">
                        </div>
                    </div>
                    <div class="whcom_col_sm_6">
                        <div class="whcom_form_field ">
                            <label class="main_label"><?php esc_html_e('Email Address', "whcom") ?></label>
                            <input type="text" name="email" readonly="readonly"
                                   value="<?php echo $current_user ["email"]; ?>" style="max-width: 100%">
                        </div>
                    </div>
                    <div class="whcom_col_sm_12">
                        <div class="whcom_form_field ">
                            <label class="main_label"><?php esc_html_e('Subject', "whcom") ?></label>
                            <input type="text" name="subject" required style="max-width: 100%">
                        </div>
                    </div>
                    <div class="whcom_col_sm_4">
                        <div class="whcom_form_field ">
                            <label class="main_label"><?php esc_html_e('Department', "whcom") ?></label>
                            <?php $depts = whcom_get_all_departments(); ?>
                            <select name="deptid">
                                <?php foreach ($depts as $dept) {
                                    $selected = $dept["id"] == @$_POST["dept_id"] ? "selected=selected" : "";
                                    ?>
                                    <option <?php echo $selected ?>
                                            value="<?php echo $dept["id"] ?>"><?php echo $dept["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="whcom_col_sm_4">
                        <div class="whcom_form_field ">
                            <label class="main_label"><?php esc_html_e('Related Service', "whcom") ?></label>
                            <?php
                            $services = wcap_get_client_products("limitnum=99999&clientid=" . whcom_get_current_client_id());
                            if (isset($services["products"]["product"])) {
                                $services = $services["products"]["product"];
                            } else {
                                $services = [];
                            }

                            $domains = wcap_get_client_domains("limitnum=99999&clientid=" . whcom_get_current_client_id());
                            if (isset($domains["domains"]["domain"])) {
                                $domains = $domains["domains"]["domain"];
                            } else {
                                $domains = [];
                            }
                            ?>
                            <select name="relatedservice">
                                <?php esc_html_e("None", "whcom") ?>
                                <?php foreach ($services as $service) { ?>
                                    <option value="S<?php echo $service["id"] ?>"><?php echo $service["name"] ?>
                                        (<?php echo $service["status"] ?>)
                                    </option>
                                <?php } ?>
                                <?php foreach ($domains as $domain) { ?>
                                    <option value="D<?php echo $domain["id"] ?>"><?php echo $domain["domainname"] ?>
                                        (<?php echo $domain["status"] ?>)
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="whcom_col_sm_4">
                        <div class="whcom_form_field ">
                            <label class="main_label"><?php esc_html_e('Priority', "whcom") ?></label>
                            <select name="priority">
                                <option><?php esc_html_e("High", "whcom") ?></option>
                                <option selected="selected"><?php esc_html_e("Medium", "whcom") ?></option>
                                <option><?php esc_html_e("Low", "whcom") ?></option>
                            </select>

                        </div>
                    </div>
                    <div class="whcom_col_sm_12">
                        <div class="whcom_form_field">
                            <label class="main_label"><?php esc_html_e('Message', "whcom") ?></label>
                            <textarea name="message" id="wcap_ticket_editor" rows="6"
                                      style="max-width: 100%;"></textarea>
                        </div>
                    </div>
                    <div class="whcom_col_sm_12">
                        <div class="whcom_form_field">
                            <label class="main_label"><?php esc_html_e('Attachments', "whcom") ?></label>
                            <input type="file" name="upload" id="upload" class="form-control" style="line-height: 15px;">
                        </div>
                    </div>
                    <div class="whcom_col_sm_12">
                        <div class="whcom_text_center">
                            <button type="submit" class="whcom_button"><?php esc_html_e('Submit', "whcom") ?></button>
                            <button class="whcom_button whcom_button_secondary wcap_load_page" data-page="tickets"><?php esc_html_e('Cancel', "whcom") ?></button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>


<script>
    var simplemde = new SimpleMDE({element: jQuery('.wcap_md_editor')[0]});


    var uploadForm = jQuery("#open_ticket_form");
    jQuery("#success-message").hide();

    uploadForm.submit(function (e) {
        e.preventDefault();
        // Moved inside
        var formData = new FormData(uploadForm[0]);
        console.log(formData);

        jQuery.ajax({
            url: wcap_ajaxurl,
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function (d) {
                res = JSON.parse(d);
                jQuery("#open_ticket_form").hide();
                jQuery('html, body').animate({
                    scrollTop: jQuery('#open_ticket_message').offset().top - 10000 //#DIV_ID is an example. Use the id of your destination on the page
                }, 'slow');
                //jQuery("#success-message").show();
                jQuery("#ticket_response").html(res.response_html);

            }
        });

    });

</script>







