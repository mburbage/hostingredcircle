<?php

$hide_manu = (get_option("wcapfield_hide_whmcs_menu_front") == '') ? [] : get_option("wcapfield_hide_whmcs_menu_front");

if (!($hide_manu) && !whcom_is_client_logged_in()) {
    include_once $this->Path . "/views/top_links_front.php";
}

?>

<div class="wcap_services ">
    <div class="whcom_page_heading">
        <h2><?php _e( "Transfer Domain", "whcom" ) ?></h2>
    </div>
    <div class="whcom_row whcom_tabs_container">
        <?php
        if (wcap_show_side_bar($page, TRUE)) {
        ?>

        <div class="whcom_col_sm_3">
            <?php
            wcap_render_categories_panel();
            wcap_render_services_panel_action();
            ?>
        </div>
        <div class="whcom_col_sm_9">
            <?php } else  { ?>
            <div class="whcom_col_sm_12">
                <?php  }  ?>

                <div class="whcom_row">
                    <div class="whcom_col_lg_8">
                        <div class="whcom_panel">
                            <div class="whcom_panel_header">
                                <span><?php esc_html_e("Single Domain Transfer","whcom" ) ?></span>
                            </div>
                            <div class="whcom_panel_body">
                            <div>
                                    <form id="domain_search_form">
                                        <input type="hidden" name="what" value="domain_whois">
                                        <input type="hidden" name="action" value="wcap_requests">
                                        <input type="hidden" name="type" value="transfer ">

                                        <div class="whcom_form_field">
                                            <label for="text">Domain Name</label>
                                            <input type="text" name="domain" id="domain" placeholder="Type a domain name">
                                        </div>

                                        <div class="whcom_form_field">
                                            <label for="text">Authorization Code</label>
                                            <input type="text" name="domain" id="domain" placeholder="Epp Code/ Auth Code">
                                        </div>

                                        <div style="display: none" class="whcom_alert whcom_alert_danger"><?php echo __( "The domain you entered is not valid", "whcom" ) ?></div>
                                        <div style="display: none" class="whcom_alert whcom_alert_danger"><?php echo __( "You cannot transfer a domain that isn't registered", "whcom" ) ?></div>




                                        <div style="display: none" class="whcom_alert whcom_alert_success"><?php echo __( "Congratulations, this domain is available!", "whcom" ) ?></div>


                                        <div class="whcom_panel_footer">
                                            <button type="submit" class="whcom_button"><?php echo __( "Add to Cart", "whcom" ) ?></button>
                                        </div>



                                    </form>

                                </div>

                            </div>
                        </div>

                        <div class="whcom_row">
                            <div class="whcom_col_12">
                                * <?php esc_html_e("Excludes certain TLDs and recently renewed domains","whcom" ) ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
    </div>







