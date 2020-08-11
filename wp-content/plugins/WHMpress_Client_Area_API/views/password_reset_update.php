<?php
//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}

?>

<div class="whcom_row">
    <div class="whcom_col_sm_2">

    </div>

    <div class="whcom_col_sm_8">
        <div class="">
            <div class="whcom_page_heading">
                <h2><?php esc_html_e("Lost Password Reset", "whcom" ) ?></h2>
            </div>


            <div class="whcom_row">
                <div class="whcom_panel_body">
                    <p>
                    <div class="whcom_alert whcom_alert_success">
                        <strong><?php esc_html_e("Validation Email Sent", "whcom" ) ?></strong>
                    </div>

                        <?php esc_html_e("The password reset process has now been started. Please check your email for instructions on what to do next.", "whcom" ) ?>
                    </p>



                </div>
            </div>

    </div>
</div>
