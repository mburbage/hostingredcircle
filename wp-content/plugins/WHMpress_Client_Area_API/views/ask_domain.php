<script>
    var product = <?php echo json_encode( $product ) ?>;
</script>
<div class="whcom_page_heading">
    <h2><?php esc_html_e( 'Choose a Domain', "whcom" ) ?></h2>
</div>
<div class="whcom_main">
    <div class="row">
        <div class="whmcs_col_sm_6">
            <form id="ask_domain_form">
                <input type="hidden" name="action" value="wcap_requests">
                <input type="hidden" name="what" value="domain_whois">

                <div class="whcom_form_field whcom_form_field_horizontal  ">
                    <label class="main_label"></label>
                    <div class="whmpress_cart_radio_container">


                        <input id="domain_register" type="radio" checked="checked" value="domainregister"
                               name="paytype">
                        <label for="domain_register">
							<?php echo __( "Register a new domain", "whcom" ) ?>

                        </label>


                        <input id="transfer_domain" type="radio" value="domainown" name="paytype">
                        <label for="transfer_domain">
							<?php echo __( "I will use my existing domain and update my nameservers", "whcom" ) ?>
                        </label>


                    </div>
                </div>

                <div class="whcom_form_field whcom_form_field_horizontal">
                    <label class="main_label"></label>
                    <input name="domain" placeholder="<?php esc_html_e( 'Find your new domain name', "whcom" ) ?>">
                    <span id="domain_check_form" style="margin-left:10px;">
            <button class="whcom_button" id="domain_whois_check_btn"><?php echo __( "Check", "whcom" ) ?></button>
        </span>
                    <span id="domain_own_check_div" style="display: none; margin-left: 10px">
            <button id="domain_own_check_btn" type="button"
                    class="whcom_button"><?php echo __( "Use", "whcom" ) ?></button>
        </span>
                    <div class="whcom_form_field whcom_text_center_sm" id="asking_domain_response"></div>
                </div>

            </form>
            <div class="whcom_text_center">
                <a id="continue_btn" href='?pid=<?php echo $product["id"] ?>' class='whcom_button wcap_load_page'
                   data-page='add_service_page' style="display: none">Continue <i class="fa fa-right-arrow"></i></a>
            </div>
        </div>
    </div>
</div>




