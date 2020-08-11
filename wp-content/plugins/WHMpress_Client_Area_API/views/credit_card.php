<?php
$show_sidebar = wcap_show_side_bar("credit_card");
$client = whcom_get_current_client();
$cctype = $client['cctype'];
$cclastfour = $client["cclastfour"];
$client_id = whcom_get_current_client_id();
?>
<div class="wcap_billings wcap_view_container">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>

            <div class="whcom_col_sm_3">
                <?php
                wcap_render_profile_panel();
                wcap_render_billing_panel();
                ?>
            </div>

        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? "whcom_col_sm_9" : "whcom_col_sm_12" ?>">
            <div class="whcom_page_heading">
                <?php esc_html_e("Credit Card Details", "whcom") ?>
            </div>

            <div class="wcap_view_response">

            </div>

            <div class="wcap_view_content">
                <div id="current-card">
                    <style>
                        div.credit-card {
                            margin: 0 auto 30px;
                            max-width: 400px;
                            background-color: #f8f8f8;
                            border: 1px solid #ccc;
                            border-radius: 8px;
                        }

                        div.card-icon {
                            float: left;
                            padding: 7px 7px;
                            font-size: 1.2em;
                        }

                        div.credit-card div.card-number {
                            padding: 10px;
                            background-color: #ccc;
                            font-size: 1.6em;
                            text-align: center;
                            clear: both;
                        }

                        div.credit-card div.card-start {
                            float: left;
                            padding: 20px 0 50px 50px;
                            font-size: 1.3em;
                            text-align: right;
                        }

                        div.credit-card div.card-expiry {
                            float: right;
                            padding: 20px 50px 50px 0;
                            height: 120px;
                            font-size: 1.3em;
                            text-align: right;
                        }

                        div.credit-card div.end {
                            clear: both;
                        }

                        div.credit-card div.card-icon {
                            float: left;
                            padding: 7px 7px;
                            font-size: 1.2em;
                        }

                        .pull-right {
                            float: right !important;
                        }

                    </style>


                    <div class="credit-card">
                        <div class="card-icon pull-right">
                            <b class=" ">&nbsp;</b>
                            <?php echo $cctype ?>
                        </div>
                        <div class="card-type">
                        </div>
                        <div class="card-number">
                            xxxx xxxx xxxx <?php echo $cclastfour ?>
                        </div>
                        <div class="card-start">
                        </div>
                        <div class="card-expiry">
                            <!--                            Expires: 12/18-->
                        </div>
                        <div class="end"></div>
                    </div>

                </div>
<!--                <form method="post" action="">-->
<!--                    <div class="whcom_text_center">-->
<!--                        <div class="whcom_form_field whcom_form_field_horizontal">-->
<!--                            <button class="whcom_button_danger" type="submit">-->
<!--                                --><?php //esc_html_e("Delete", "whcom") ?><!--</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </form>-->

                <h3><?php esc_html_e("Enter New Card Information Below", "whcom"); ?></h3>
                <!-- Card Type -->

                <?php
                $whcom_whmcs_settings = whcom_get_whmcs_setting();
                $cc_types = (!empty($whcom_whmcs_settings) && !empty($whcom_whmcs_settings['AcceptedCardTypes'])) ? $whcom_whmcs_settings['AcceptedCardTypes'] : '';
                $cc_types = explode(',', $cc_types);
                if (!empty($cc_types)) { ?>
                <!--Payment Options-->
                <form id="update_credit_card_form">
                    <input type="hidden" name="action" value="wcap_requests">
                    <input type="hidden" name="what" value="update_credit_card">
                    <input type="hidden" name="clientid" value="<?php echo $client_id ?>">
                    <div class="whcom_sp_cc_fields">
                        <div class="whcom_row">
                            <div class="whcom_col_sm_6">
                                <!-- Card Type -->
                                <div class="whcom_form_field">
                                    <label for="cardtype"
                                           class="main_label"><?php esc_html_e('Card Type', 'whcom') ?></label>
                                    <select name="cardtype" id="cardtype">
                                        <?php foreach ($cc_types as $cc_type) { ?>
                                            <option value="<?php echo $cc_type ?>"><?php echo $cc_type ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="whcom_col_sm_6">
                                <!-- Card Number -->
                                <div class="whcom_form_field">
                                    <label for="cardnum"
                                           class="main_label"><?php esc_html_e('Card Number', 'whcom') ?></label>
                                    <input type="number" name="cardnum" id="cardnum" value="">
                                </div>
                            </div>
                            <div class="whcom_col_sm_6">
                                <!-- Expiry Date -->
                                <div class="whcom_form_field">
                                    <label class="" for="exp_month"><?php esc_html_e('Expiry Date', 'whcom') ?></label>
                                    <div class="whcom_checkbox_container">
                                        <div class="whcom_row">
                                            <div class="whcom_col_xs_6">
                                                <select name="exp_month" id="exp_month" title="Expiry Month">
                                                    <option value="01"><?php esc_html_e('Jan', 'whcom') ?></option>
                                                    <option value="02"><?php esc_html_e('Feb', 'whcom') ?></option>
                                                    <option value="03"><?php esc_html_e('Mar', 'whcom') ?></option>
                                                    <option value="04"><?php esc_html_e('Apr', 'whcom') ?></option>
                                                    <option value="05"><?php esc_html_e('May', 'whcom') ?></option>
                                                    <option value="06"><?php esc_html_e('Jun', 'whcom') ?></option>
                                                    <option value="07"><?php esc_html_e('Jul', 'whcom') ?></option>
                                                    <option value="08"><?php esc_html_e('Aug', 'whcom') ?></option>
                                                    <option value="09"><?php esc_html_e('Sep', 'whcom') ?></option>
                                                    <option value="10"><?php esc_html_e('Oct', 'whcom') ?></option>
                                                    <option value="11"><?php esc_html_e('Nov', 'whcom') ?></option>
                                                    <option value="12"><?php esc_html_e('Dec', 'whcom') ?></option>
                                                </select>
                                            </div>
                                            <div class="whcom_col_xs_6">
                                                <select name="exp_year" title="Expiry Year">
                                                    <option value="17"><?php esc_html_e('2017', 'whcom') ?></option>
                                                    <option value="18"><?php esc_html_e('2018', 'whcom') ?></option>
                                                    <option value="19"><?php esc_html_e('2019', 'whcom') ?></option>
                                                    <option value="20"><?php esc_html_e('2020', 'whcom') ?></option>
                                                    <option value="21"><?php esc_html_e('2021', 'whcom') ?></option>
                                                    <option value="22"><?php esc_html_e('2022', 'whcom') ?></option>
                                                    <option value="23"><?php esc_html_e('2023', 'whcom') ?></option>
                                                    <option value="24"><?php esc_html_e('2024', 'whcom') ?></option>
                                                    <option value="25"><?php esc_html_e('2025', 'whcom') ?></option>
                                                    <option value="26"><?php esc_html_e('2026', 'whcom') ?></option>
                                                    <option value="27"><?php esc_html_e('2027', 'whcom') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="whcom_col_sm_6">
                                <!-- Card CVV -->
                                <div class="whcom_form_field">
                                    <label for="cvv" class="main_label"><?php esc_html_e('Card CVV', 'whcom') ?></label>
                                    <input type="password" name="cvv" id="cvv" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="whcom_text_center">
                        <div class="whcom_form_field whcom_form_field_horizontal">
                            <button type="submit"><?php esc_html_e("Save Changes", "whcom") ?></button>
                            <button class="whcom_button_secondary"><?php esc_html_e("Cancel", "whcom") ?></button>
                        </div>
                    </div>

                    <?php } ?>


                </form>


            </div>

        </div>


    </div>
</div>

<div id="success_message" class="whcom_alert whcom_alert_success" style="display: none;"></div>
<div id="error_message" class="whcom_alert whcom_alert_warning" style="display: none;"></div>

<script>

</script>


