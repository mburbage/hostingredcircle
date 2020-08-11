<?php

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}

?>


<div class="whcom_row">
    <div class="whcom_col_sm_3">

    </div>

    <div class="whcom_col_sm_6">
        <div class="">
            <div class="whcom_margin_bottom_30">
            </div>
            <div class="whcom_margin_bottom_30">
                <div class="whcom_page_heading">
                    <?php esc_html_e("Logged Out", "whcom" ) ?>
                </div>
            </div>


            <div class="whcom_row">
                <div class="whcom_panel_body">
                    <div id="success_message">
                        <div class="whcom_alert whcom_alert_success">
                            <strong><?php esc_html_e("You have been successfully logged out.", "whcom" ) ?></strong>
                        </div>
                    </div>
                    <div id="error_message" class="whcom_alert whcom_alert_danger" style="display: none;">
                    </div>

                    <div class="whcom_margin_bottom_15 wcap_load_page" data-page="login">
                        <button class="whcom_button_secondary"><?php esc_html_e("Click here to continue", "whcom" ); ?></button>
                    </div>

                </div>
            </div>

        </div>
        <div class="whcom_col_sm_3">

        </div>
    </div>
</div>


