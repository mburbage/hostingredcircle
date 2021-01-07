<style>
    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal {
        background-color: transparent !important;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul {
        display: table;
        table-layout: fixed;
        width: 100%;
        margin: 0;
        padding-left: 0;
        list-style: none;
        margin-bottom: 30px;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul li {
        position: relative;
        display: table-cell;
        width: 2%;
        padding: 0 10px 20px;
        font-size: 17px;
        text-align: center;
        vertical-align: middle;
        counter-increment: step;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li {
        background-color: #3f5167;
        color: #a6afba;
        text-align: center;
        padding: 40px 0;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul li:before {
        content: " ";
        position: absolute;
        left: 50%;
        bottom: -2px;
        width: 100%;
        border-bottom: 4px solid #59697d;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul li:last-child:before {
        border: none;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul li.active:before {
        border-color: #52d2f0;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul li.current:before {
        border-color: #59697d;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul li:after {
        content: counter(step);
        position: absolute;
        bottom: 0;
        left: 50%;
        -ms-transform: translate(-50%, 50%);
        transform: translate(-50%, 50%);
        display: block;
        width: 20px;
        height: 20px;
        font-size: 14px;
        line-height: 1;
        padding: 3px;
        font-weight: 700;
        text-align: center;
        color: #3f5167;
        background-color: #59697d;
        border-radius: 50%;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul.active:after {
        color: #3f5167;
        background-color: #52d2f0;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul li.current:after {
        color: #3f5167;
        background-color: #fff !important;
        box-shadow: 0 0 0 4px rgba(82, 210, 240, 0.5);
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul li.current:after {
        color: #3f5167;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(82, 210, 240, 0.5);
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul li.active:not(.current):after {
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        content: "\f00c";
        font-size: 14px;
        line-height: 16px;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul li.active.current {
        color: #fff;
        fo
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul li.active {
        color: #52d2f0;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li ul li.active:after {
        color: #3f5167;
        background-color: #52d2f0;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal.whcom_bordered_sides {
        border: none;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .wcop_sp_nav.whcom_nav_container.whcom_sticky_item {
        display: none;
    }

    /*.whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field label.whcom_radio:before,*/
    /*.whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field label.whcom_checkbox:before{*/
    /*content: '';*/
    /*position: absolute;*/
    /*border-style: solid;*/
    /*border-width: 1px !important;*/
    /*border-color: #999;*/
    /*border-radius: 50%;*/
    /*background-color: #fff;*/
    /*transition-duration: .2s;*/
    /*transition-timing-function: cubic-bezier(.4,0,.2,1);*/
    /*-webkit-user-select: none;*/
    /*-moz-user-select: none;*/
    /*-ms-user-select: none;*/
    /*user-select: none;*/
    /*}*/
    /*.whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field label.whcom_checked{*/
    /*position: relative;*/
    /*}*/
    /*.whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field label.whcom_checked:after{*/
    /*content: '';*/
    /*border-radius: 50%;*/
    /*background: #113f6d !important;*/
    /*transition-duration: .2s;*/
    /*height: 10px;*/
    /*width: 10px;*/
    /*transition-timing-function: cubic-bezier(.4,0,.2,1);*/
    /*-webkit-user-select: none;*/
    /*-moz-user-select: none;*/
    /*-ms-user-select: none;*/
    /*user-select: none;*/
    /*left: 5px;*/
    /*z-index: 9999;*/
    /*top: 12px;*/
    /*position: absolute;*/
    /*}*/
    .whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field label.whcom_checkbox {
        color: #113f6d;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .wcop_sp_addons_options_container .whcom_panel {
        padding: 2rem;
        border: 1px solid #59d2ef;
        border-radius: 6px;
        background: #fff;
        cursor: pointer;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .wcop_sp_addons_options_container .whcom_panel .whcom_button {
        display: none !important;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .wcop_sp_addons_options_container .whcom_form_field {
        text-align: left;
        padding: 0;
        margin-bottom: 0;
        height: 69px;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .whcom_col_sm_6.whcom_client-area .whcom_col_sm_4,
    .whcom_main.wcop_sp_02_sleek_minimal .whcom_col_sm_6.whcom_client-area .whcom_col_sm_6 {
        width: 100%;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_billing_info .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links {
        margin: 0;
        border: none !important;
        margin-bottom: 15px;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_billing_info .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li.active {
        display: none;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_billing_info .whcom_tabs_container .whcom_col_sm_6.whcom_client-area ul.whcom_tab_links li {
        height: 55px;
        line-height: 29px;
        /*background: #59d2ef;*/
        font-weight: 600;
        /*color: #000;*/
        padding: 12px 18px;
        border: 0;
        border-radius: 6px;
        text-shadow: none;
    }

    .whcom_main.wcop_sp_02_sleek_minimal div#wcop_billing_info .whcom_tabs_content {
        padding: 0;
        background-color: #f4f5f3;
        border: 1px solid #e9ebe7;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .login-heading-title {
        margin: 0px;
        padding: 0px;
        padding-top: 15px;
        padding-bottom: 15px;
        text-align: center;
        font-weight: bold;
        background-color: #E9E9E9;
        border-bottom: 2px solid #D1D1D1;
    }

    .whcom_main.wcop_sp_02_sleek_minimal div#wcop_billing_info .whcom_tabs_content .login-new-account {
        margin: 11px 35px 36px 15px;
    }

    .whcom_main.wcop_sp_02_sleek_minimal div#wcop_sp_user_login .whcom_form_field input {
        float: none;
        margin: 0 auto;
        height: 42px !important;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field > input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]),
    .whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field select,
    .whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field textarea,
    .whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field .whcom_plus,
    .whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field .whcom_minus {
        height: 42px !important;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field > input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):focus,
    .whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field select:focus,
    .whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field textarea:focus,
    .whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field .whcom_plus:focus,
    .whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field .whcom_minus:focus {
        border-color: rgba(82, 168, 236, 0.8);
        outline: 0;
        outline: thin dotted \9;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
    }

    /*.whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field > input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):invalid,*/
    /*.whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field select:invalid,*/
    /*.whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field textarea:invalid,*/
    /*.whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field .whcom_plus:invalid,*/
    /*.whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field .whcom_minus:invalid{*/
    /*border-color: red;*/
    /*}*/
    .whcom_main.wcop_sp_02_sleek_minimal div#wcop_sp_user_login label {
        display: none;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .whcom_tabs_container.whcom_tabs_fancy_2 .login-new-account ul {
        margin-left: 35px !important;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links {
        margin: 0;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .login-new-account ul li {
        padding-top: 10px;
        font-size: 12px;
        line-height: 14px;
    }

    .whcom_main.wcop_sp_02_sleek_minimal div#wcop_billing_info .whcom_col_sm_6.whcom_client-area .whcom_form_field.whcom_form_field_horizontal label {
        float: none;
    }

    .whcom_main.wcop_sp_02_sleek_minimal div#wcop_billing_info .whcom_col_sm_6.whcom_client-area .whcom_form_field.whcom_form_field_horizontal .whcom_radio_container {
        width: 100%;
    }

    .whcom_main.wcop_sp_02_sleek_minimal div#wcop_billing_info .whcom_col_sm_6.whcom_client-area .whcom_form_field {
        margin-bottom: 10px;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .wcop_sp_addons_options_container .whcom_panel .whcom_panel_footer {
        padding-bottom: 0 !important;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .wcop_sp_addons_options_container .whcom_panel .whcom_padding_10 {
        padding: 0 !important;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .wcop_sp_addons_options_container .whcom_panel .whcom_padding_10 span:first-child {
        display: block;
        font-size: 19px;
        color: #113f6d;
        font-weight: 700;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .wcop_sp_section_heading i {
        display: none;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .wcop_sp_section_heading {
        /*color: #0068b1;*/
        border-bottom: 1px solid #bbb;
        padding: 15px 15px;
        margin-bottom: 20px;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_sp_domain_config .wcop_sp_section_heading {
        background-color: #e9ebe7 !important;
        /*color: #59697d;*/
        font-weight: 400;
        border: none;
        padding: 2px 10px;
        height: 40px;
        line-height: 38px;
        position: relative;
    }

    /*#wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_sp_domain_config .wcop_sp_section_heading:before {*/
    /*content: "";*/
    /*background: #fff;*/
    /*height: 45px;*/
    /*width: 79px;*/
    /*position: absolute;*/
    /*bottom: -498%;*/
    /*left: -10px;*/
    /*z-index: 99999;*/
    /*}*/
    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_sp_choose_a_domain .whcom_text_success {
        /*color: #b0ca67 !important;*/
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_sp_choose_a_domain .whcom_button.whcom_button_success {
        /*border-color: #b0ca67;*/
        /*background: #b0ca67 ;*/
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_sp_choose_a_domain .whcom_button {
        height: 42px;
        line-height: 18px !important;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_sp_choose_a_domain .whcom_button.whcom_button_success:hover {
        /*border-color: #72ca44;*/
        /*background: #72CA44 ;*/
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_sp_domain_config label.main_label {
        /*color: #113f6d;*/
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .whcom_alert.whcom_alert_info {
        /*border-color: #b3becc;*/
        /*background-color: #dfeaf8;*/
        /*color: #3f5167;*/
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .whcom_sub_heading_style_1 {
        border: none;
        text-align: left;
        font-size: 22px;
        color: #0068b1;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .whcom_sub_heading_style_1 span {
        font-size: 18px;
        color: #0068b1;
        background: transparent;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .whcom_button_block {
        /*background-color: #0068b1;*/
        height: 42px;
        line-height: 18px !important;
    }

    /*#wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .whcom_button_block:hover{*/
    /*background-color: #22527b;*/
    /*border-color: #22527b;*/
    /*}*/
    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal button.whcom_button.whcom_button_big {
        /*background-color: #0068b1;*/
        /*border: none;*/
        height: 37px;
        line-height: 0px !important;
        font-size: 14px !important;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal button.whcom_button.whcom_button_big:hover {
        /*background-color: #22527b;*/
        /*border-color: #22527b;*/
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .whcom_form_field label {
        /*color: #0068b1;*/
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .whcom_tabs_container.whcom_tabs_fancy_2 ul {
        font-size: 0;
        border: none;
    }

    .whcom_main.wcop_sp_02_sleek_minimal .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li {
        /*background: rgba(40,44,42,0.05);
        color: #74777b;*/
        position: relative;
        -webkit-transition: color 0.2s;
        transition: color 0.2s;
        padding: 12px 49px;
        padding-top: 53px;
        border: 1px solid rgba(40, 44, 42, 0.1);
        font-size: 13px;
        margin: 0;
        font-weight: 700;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_sp_choose_a_domain .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li::before {
        content: "\f0ec";
        position: absolute;
        top: 12px;
        left: 46%;
        font-size: 25px;
        font-family: FontAwesome;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_sp_choose_a_domain .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li:first-child:before {
        content: "\f233";
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_sp_choose_a_domain .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li:last-child:before {
        content: "\f046";
    }

    .whcom_main.wcop_sp_02_sleek_minimal .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li.active {
        background: transparent;
        box-shadow: inset 0 3px 0;
        /*color: #52d2f0;*/
        border-bottom: 0;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_review_checkout .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li:before {
        content: "\f06b";
        position: absolute;
        top: 12px;
        left: 46%;
        font-size: 25px;
        font-family: FontAwesome;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_review_checkout .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li:last-child:before {
        content: "\f080";
    }

    div#wcop_choose_a_hosting .prev {
        /*display: none;*/
    }

    div#wcop_choose_a_hosting .prev.show-button {
        display: block;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_billing_info {
        position: relative;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_billing_info .whcom_form_field.whcom_text_center {
        position: absolute;
        right: -3px;
        bottom: -70px;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal div#wcop_sp_domain_config .whcom_form_field label.whcom_checked:after {
        top: 10px;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .wcop_sp_order_summary {
        color: grey;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .wcop_sp_order_summary strong {
        color: #113f6d;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .wcop_sp_order_summary .whcom_text_right.whcom_text_2x {
        color: #b0ca67;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .nav_div {
        display: none;
    }

    #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .wcop_sp_order_summary .whcom_list_bordered li {
        margin-top: 0px;
    }
    .wcop_billing_info_predecessor_text {
        height: 5em;
        padding-top: 0.3125em;
        font-size: 17px;
        font-weight: 400;
    }

    .wcop_billing_info_content.wcop_sp_section_content.whcom_row {
        border: 1px solid #cccccc;
        padding: 10px 10px 0 10px !important;
        max-width: 940px !important;
    }

    .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal div#wcop_billing_info .whcom_form_field.whcom_text_center {
        position: absolute;
        right: 73px;
        bottom: 31px;
    }

    @media (max-width: 1150px) {
        .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li li span {
            display: none;
        }

        .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li li.current span {
            display: inline;
        }
    }

    @media only screen and (min-width: 1150px) {
        #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .my_container {
            width: 960px;
            margin: 0 auto;
        }
    }

    @media only screen and (max-width: 750px) {
        #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li {
            display: block;
        }
    }

    @media only screen and (max-width: 600px) {
        .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li li.current span {
            display: none;
        }

        #wcop_sp_main.whcom_main.wcop_sp_02_sleek_minimal .nav_div {
            display: block;
        }

        .wcop_main.wcop_sp_main.wcop_sp_02_sleek_minimal .wcop-wight-li {
            padding-top: 25px;
        }
    }
</style>


<?php defined('ABSPATH') or die("Cannot access pages directly.");
?>
<?php
$show_prod_desc = $atts['show_summary_product_description'];
$promocode = $atts['promocode'];
$hide_group_name = $atts['hide_group_name_summary'];
$_SESSION['hide_group_name'] = $hide_group_name;
$_SESSION['prod_desc'] = $show_prod_desc;
?>

<div class="whcom_main wcop_main wcop_sp_main wcop_sp_02_sleek_minimal whcom_bordered_sides" id="wcop_sp_main">
    <?php if (strtolower($atts['hide_navigation']) != 'yes') { ?>
        <div class="wcop-wight-li" style="margin-bottom: 55px">
            <div class="nav_div" style="text-align: center; color: #fff">
                <div class="wcop_sp_div">Domain</div>
                <div class="wcop_sp_div">Hosting Plan</div>
                <div class="wcop_sp_div">Services</div>
                <div class="wcop_sp_div">Billing Info</div>
                <div class="wcop_sp_div">Checkout</div>
            </div>
            <?php
            $steps_array_count = wcop_sp_measure_step_count($hide_steps_array = [
                'hide_domain' => strtolower($atts['hide_domain']),
                'hide_product' => strtolower($atts['hide_product']),
                'hide_additional_services' => strtolower($atts['hide_additional_services']),
                'hide_promo' => strtolower($atts['hide_promo']),
            ]);

            ?>
            <div>
                <ul id="foo">
                    <?php if ($atts['hide_domain'] != 'yes') { ?>
                        <li class="step-<?php echo $steps_array_count['domain_count'] ?>">
                            <span>Domain</span>
                        </li>
                    <?php } ?>
                    <?php if ($atts['hide_product'] != 'yes') { ?>
                        <li class="step-<?php echo $steps_array_count['product_count'] ?>">
                            <span>Hosting Plan</span>
                        </li>
                    <?php } ?>
                    <?php if ($atts['hide_additional_services'] != 'yes') { ?>
                        <li class="step-<?php echo $steps_array_count['service_count'] ?>">
                            <span>Services</span>
                        </li>
                    <?php } ?>
                    <li class="step-<?php echo $steps_array_count['billing_count'] ?>">
                        <span>Billing Info</span>
                    </li>
                    <li class="step-<?php echo $steps_array_count['checkout_count'] ?>">
                        <span>Checkout</span>
                    </li>
                </ul>
            </div>
        </div>
    <?php } ?>
    <div class="my_container">
        <?php include wcop_get_template_directory() . '/templates/single_page/01_default/01_top_nav.php' ?>
        <?php include wcop_get_template_directory() . '/templates/single_page/01_default/02_product_dropdowns.php' ?>
        <?php if (strtolower($atts['hide_domain']) != 'yes') { ?>
            <div id="wcop_sp_choose_a_domain"
                 class="wcop_sp_section wcop_sp_section_domain whcom_margin_bottom_0 whcom_bg_white whcom_padding_bottom_30 sleek_minimal_domain_section">
                <?php include_once(wcop_get_template_directory() . '/templates/single_page/02_sleek_minimal/02_domain.php'); ?>
            </div>
        <?php } ?>
        <div class="wcop_sp_add_product_form">
            <form class="wcop_sp_add_product" method="post">
                <input type="hidden" name="action" value="wcop_sp_process">
                <input type="hidden" name="wcop_sp_what" value="add_order">
                <input type="hidden" name="wcop_sp_template" value="02_sleek_minimal">
                <input type="hidden" name="cart_index" value="-1">
                <input type="hidden" name="default_billingcycle" value="<?php echo $atts['billingcycle']; ?>">
                <div class="mydivs">
                    <?php if (strtolower($atts['hide_domain']) != 'yes') { ?>
                        <div id="wcop_sp_domain_config" class="wcop_sp_section wcop_sp_section_domain sleek_minimal_domain_config_section"
                             style="display: none">
                            <div class="wcop_sp_section_heading whcom_bg_primary whcom_text_white">
                                <i class="whcom_icon_www"></i>
                                <span><?php esc_html_e("Domain Configuration", "whcom") ?></span>
                                <span id="edit_domain"
                                      style="float: right; cursor: pointer"><?php esc_html_e("Edit Domain", "whcom") ?></span>
                            </div>
                            <div class="wcop_sp_section_content">
                            </div>

                                <div class="my-button-item">
                                    <div class="wcop_sp_button">
                                        <button type="button" name="next" class="next"  disabled="disabled" value="continue" onclick="Gotonext('.sleek_minimal_domain_config_section')" style="float:right;">Continue</button>
                                    </div>
                                </div>

                        </div>
                    <?php } ?>
                    <?php if (strtolower($atts['hide_product']) != 'yes') { ?>
                        <div id="wcop_choose_a_hosting"
                             class="sleek_minimal_product_section wcop_sp_section <?php echo (!empty($atts['hide_selected_product']) && strtolower($atts['hide_selected_product']) == 'yes' && !empty($atts['pid'])) ? 'hidden' : '' ?>">
                            <?php include_once(wcop_get_template_directory() . '/templates/single_page/02_sleek_minimal/03_product.php'); ?>
                        </div>
                    <?php } ?>
                    <?php if (strtolower($atts['hide_additional_services']) != 'yes') { ?>
                        <div id="wcop_additional_services" class="wcop_sp_section sleek_minimal_additional_services_section">
                            <?php include_once(wcop_get_template_directory() . '/templates/single_page/02_sleek_minimal/04_options.php'); ?>
                        </div>
                    <?php } ?>

                    <div id="wcop_billing_info" class="wcop_sp_section sleek_minimal_billing_info_section">
                        <!-- Billing info Predecessor -->
                        <?php if ($atts['post_load_login_form'] == 'yes') { ?>
                            <div class="wcop_billing_info_predecessor">
                                <div class="wcop_sp_section_heading">
                                    <i class="whcom_icon_credit-card"></i>
                                    <span><?php esc_html_e("Enter Your Billing Info", "whcom") ?></span>
                                </div>
                                <div class="wcop_billing_info_content wcop_sp_section_content whcom_row">
                                    <!-- Register section  -->
                                    <div class="whcom_form_field whcom_col_sm_6">
                                        <div class="whcom_text_2x"><?php esc_html_e("Don't have an account?", 'whcom') ?></div>
                                        <div class="wcop_billing_info_predecessor_text">
                                            <p><?php esc_html_e('No problem. Click below to register now and then continue with checkout process', 'whcom') ?></p>
                                        </div>
                                        <button type="button" id="wcop_sp_client_register_section"
                                                class="whcom_button whcom_pull_left whcom_margin_bottom_0"><?php esc_html_e('Register', "whcom") ?></button>
                                    </div>
                                    <!-- Login Section -->
                                    <div class="whcom_form_field whcom_col_sm_6">
                                        <div class="whcom_text_2x"><?php esc_html_e('Returning Customer', 'whcom') ?></div>
                                        <div class="wcop_billing_info_predecessor_text">
                                            <p><?php esc_html_e('If you already have an account click below to log in', 'whcom') ?></p>
                                        </div>
                                        <button type="button" id="wcop_sp_client_login_section"
                                                class="whcom_button whcom_pull_left whcom_margin_bottom_0"><?php esc_html_e('Login', "whcom") ?></button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- end -->
                        <?php include_once(wcop_get_template_directory() . '/templates/single_page/02_sleek_minimal/05_client.php'); ?>
                    </div>

                    <div id="wcop_review_checkout" class="wcop_sp_section sleek_minimal_checkout_section">
                        <?php include_once(wcop_get_template_directory() . '/templates/single_page/02_sleek_minimal/07_checkout.php'); ?>
                    </div>

                </div>
            </form>
        </div>

    </div>
</div>


<script>


    jQuery(document).ready(function () {
        var divs = jQuery('.mydivs > .wcop_sp_section');
        divs.hide().first().show();
        jQuery('.step-0').addClass('active current');
    });

    sleek_minimal_step_count = 0;
    function Gotonext(current_class_name){
        jQuery('.sleek_minimal_domain_section').css('display', 'none');
        jQuery('.sleek_minimal_domain_config_section').css('display', 'none');
        jQuery('.sleek_minimal_product_section').css('display', 'none');
        jQuery('.sleek_minimal_additional_services_section').css('display', 'none');
        jQuery('.sleek_minimal_checkout_section').css('display', 'none');
        jQuery('.sleek_minimal_billing_info_section').css('display', 'none');

        jQuery(current_class_name).next().css('display', 'block');

        var advanced_sleek_minimal_count = sleek_minimal_step_count+1;
        if (jQuery('.wcop-wight-li li').hasClass('step-' + sleek_minimal_step_count + ' active current')) {
            jQuery(".wcop-wight-li li.step-" + sleek_minimal_step_count).removeClass(' current');
            jQuery(".wcop-wight-li li.step-" + advanced_sleek_minimal_count).addClass(' active current');
        }
        sleek_minimal_step_count++;
    }

    function Gotoprevious(current_class_name) {
        jQuery('.sleek_minimal_domain_section').css('display', 'none');
        jQuery('.sleek_minimal_domain_config_section').css('display', 'none');
        jQuery('.sleek_minimal_product_section').css('display', 'none');
        jQuery('.sleek_minimal_additional_services_section').css('display', 'none');
        jQuery('.sleek_minimal_checkout_section').css('display', 'none');
        jQuery('.sleek_minimal_billing_info_section').css('display', 'none');

        jQuery(current_class_name).prev().css('display', 'block');

        var advanced_sleek_minimal_prev_count = sleek_minimal_step_count-1;
        if (jQuery('.wcop-wight-li li').hasClass('step-' + sleek_minimal_step_count + ' active')) {
            jQuery(".wcop-wight-li li.step-" + sleek_minimal_step_count).removeClass(' active current');
            jQuery(".wcop-wight-li li.step-" + advanced_sleek_minimal_prev_count).addClass(' active current');
        }
        sleek_minimal_step_count--;
    }

    function skip(){
        jQuery('.sleek_minimal_domain_section').css('display', 'none');
        jQuery('.sleek_minimal_product_section').css('display', 'block');
        jQuery(".wcop-wight-li li.step-" + 0).removeClass(' current');
        jQuery(".wcop-wight-li li.step-" + 1).addClass(' active current');
        sleek_minimal_step_count++;
    }

    jQuery("#require_Domain_search").click(function () {
        var domain_name_text = document.getElementById("domain");
        if ((domain_name_text.value) !== '') {
            jQuery('.next').removeAttr("disabled");
        }
    });


    jQuery("#require_Domain_transfer").click(function () {
        var domain_name_text = document.getElementById("domain_transfer");
        if ((domain_name_text.value) !== '') {
            jQuery('.next').removeAttr("disabled");
        }
    });

    jQuery("#require_Domain_use").click(function () {
        var domain_name_text = document.getElementById("domain_use");
        if ((domain_name_text.value) !== '') {
            jQuery('.next').removeAttr("disabled");
        }
    });
</script>