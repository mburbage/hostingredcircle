<style>
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek {
        background-color: transparent !important;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul {
        display: table;
        table-layout: fixed;
        width: 100%;
        margin: 0;
        padding-left: 0;
        list-style: none;
        margin-bottom: 30px;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li {
        position: relative;
        display: table-cell;
        width: 2%;
        padding: 0 10px 20px;
        font-size: 17px;
        text-align: center;
        vertical-align: middle;
        counter-increment: step;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li {
        background-color: #3f5167;
        color: #a6afba;
        text-align: center;
        padding: 40px 0;
    }

    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li:before {
        content: " ";
        position: absolute;
        left: 50%;
        bottom: -2px;
        width: 100%;
        border-bottom: 4px solid #59697d;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li:last-child:before{
        border: none;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.active:before {
        border-color: #52d2f0;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.current:before {
        border-color: #59697d;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li:after {
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
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul.active:after {
        color: #3f5167;
        background-color: #52d2f0;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.current:after {
        color: #3f5167;
        background-color: #fff !important;
        box-shadow: 0 0 0 4px rgba(82, 210, 240, 0.5);
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.current:after {
        color: #3f5167;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(82, 210, 240, 0.5);
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.active:not(.current):after {
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        content: "\f00c";
        font-size: 14px;
        line-height: 16px;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.active.current{
        color: #fff;
        fo
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.active{
        color: #52d2f0;
    }

    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.active:after {
        color: #3f5167;
        background-color: #52d2f0;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek.whcom_bordered_sides {
        border: none;
    }
    .whcom_main.wcop_sp_06_sleek .wcop_sp_nav.whcom_nav_container.whcom_sticky_item{
        display: none;
    }

    .whcom_main.wcop_sp_06_sleek .whcom_form_field label.whcom_radio:before,
    .whcom_main.wcop_sp_06_sleek .whcom_form_field label.whcom_checkbox:before{
        content: '';
        position: absolute;
        border-style: solid;
        border-width: 1px !important;
        border-color: #999;
        border-radius: 50%;
        background-color: #fff;
        transition-duration: .2s;
        transition-timing-function: cubic-bezier(.4,0,.2,1);
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .whcom_main.wcop_sp_06_sleek .whcom_form_field label.whcom_checked{
        position: relative;
    }
    .whcom_main.wcop_sp_06_sleek .whcom_form_field label.whcom_checked:after{
        content: '';
        border-radius: 50%;
        background: #113f6d !important;
        transition-duration: .2s;
        height: 10px;
        width: 10px;
        transition-timing-function: cubic-bezier(.4,0,.2,1);
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        left: 5px;
        z-index: 9999;
        top: 12px;
        position: absolute;
    }
    .whcom_main.wcop_sp_06_sleek .whcom_form_field label.whcom_checkbox{
        color: #113f6d;
    }
    .whcom_main.wcop_sp_06_sleek .wcop_sp_addons_options_container .whcom_panel{
        padding: 2rem;
        border: 1px solid #59d2ef;
        border-radius: 6px;
        background: #fff;
        cursor: pointer;
    }
    .whcom_main.wcop_sp_06_sleek .wcop_sp_addons_options_container .whcom_panel .whcom_button{
        display: none !important;
    }
    .whcom_main.wcop_sp_06_sleek .whcom_checkbox_container.whcom_text_center,
    .whcom_main.wcop_sp_06_sleek .wcop_sp_addons_options_container .whcom_form_field{
        text-align: left !important;
        padding: 0;
        margin-bottom: 0;
        height: 69px !important;
    }

    .whcom_main.wcop_sp_06_sleek .whcom_panel_body.whcom_form_field {
        padding: 0;
        margin-bottom: 0;
        height: 53px;
    }
    .whcom_main.wcop_sp_06_sleek .whcom_col_sm_6.whcom_client-area .whcom_col_sm_4,
    .whcom_main.wcop_sp_06_sleek .whcom_col_sm_6.whcom_client-area .whcom_col_sm_6 {
        width: 100%;
    }

    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_billing_info  .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links{
        margin: 0;
        border: none !important;
        margin-bottom: 15px;
    }

    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_billing_info .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li.active{
        display: none;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_billing_info .whcom_tabs_container .whcom_col_sm_6.whcom_client-area ul.whcom_tab_links li {
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
    .whcom_main.wcop_sp_06_sleek div#wcop_billing_info .whcom_tabs_content{
        padding: 0;
        background-color: #f4f5f3;
        border: 1px solid #e9ebe7;
    }
    .whcom_main.wcop_sp_06_sleek .login-heading-title {
        margin: 0px;
        padding: 0px;
        padding-top: 15px;
        padding-bottom: 15px;
        text-align: center;
        font-weight: bold;
        background-color: #E9E9E9;
        border-bottom: 2px solid #D1D1D1;
    }
    .whcom_main.wcop_sp_06_sleek div#wcop_billing_info .whcom_tabs_content .login-new-account {
        margin: 11px 35px 36px 15px;
    }

    .whcom_main.wcop_sp_06_sleek div#wcop_sp_user_login .whcom_form_field input{
        float: none;
        margin: 0 auto;
        height: 42px !important;
    }
    .whcom_main.wcop_sp_06_sleek .whcom_form_field > input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]),
    .whcom_main.wcop_sp_06_sleek .whcom_form_field select,
    .whcom_main.wcop_sp_06_sleek .whcom_form_field textarea,
    .whcom_main.wcop_sp_06_sleek .whcom_form_field .whcom_plus,
    .whcom_main.wcop_sp_06_sleek .whcom_form_field .whcom_minus{
        height: 42px !important;
        background: #fff;
    }
    .whcom_main.wcop_sp_06_sleek .whcom_form_field > input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):focus,
    .whcom_main.wcop_sp_06_sleek .whcom_form_field select:focus,
    .whcom_main.wcop_sp_06_sleek .whcom_form_field textarea:focus,
    .whcom_main.wcop_sp_06_sleek .whcom_form_field .whcom_plus:focus,
    .whcom_main.wcop_sp_06_sleek .whcom_form_field .whcom_minus:focus{
        border-color: rgba(82, 168, 236, 0.8);
        outline: 0;
        outline: thin dotted \9;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
    }
    /*.whcom_main.wcop_sp_06_sleek .whcom_form_field > input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):invalid,*/
    /*.whcom_main.wcop_sp_06_sleek .whcom_form_field select:invalid,*/
    /*.whcom_main.wcop_sp_06_sleek .whcom_form_field textarea:invalid,*/
    /*.whcom_main.wcop_sp_06_sleek .whcom_form_field .whcom_plus:invalid,*/
    /*.whcom_main.wcop_sp_06_sleek .whcom_form_field .whcom_minus:invalid{*/
    /*border-color: red;*/
    /*}*/
    .whcom_main.wcop_sp_06_sleek div#wcop_sp_user_login label {
        display: none;
    }
    .whcom_main.wcop_sp_06_sleek .whcom_tabs_container.whcom_tabs_fancy_2  .login-new-account ul{
        margin-left: 35px !important;
    }
    .whcom_main.wcop_sp_06_sleek .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links{
        margin: 0;
    }
    .whcom_main.wcop_sp_06_sleek  .login-new-account ul li {
        padding-top: 10px;
        font-size: 12px;
        line-height: 14px;
    }

    .whcom_main.wcop_sp_06_sleek div#wcop_billing_info .whcom_col_sm_6.whcom_client-area .whcom_form_field.whcom_form_field_horizontal label {
        float: none;
    }

    .whcom_main.wcop_sp_06_sleek div#wcop_billing_info .whcom_col_sm_6.whcom_client-area .whcom_form_field.whcom_form_field_horizontal .whcom_radio_container{
        width:100%;
    }
    .whcom_main.wcop_sp_06_sleek div#wcop_billing_info .whcom_col_sm_6.whcom_client-area .whcom_form_field{
        margin-bottom: 10px;
    }
    .whcom_main.wcop_sp_06_sleek .wcop_sp_addons_options_container .whcom_panel .whcom_panel_footer{
        padding-bottom: 0 !important;
    }
    .whcom_main.wcop_sp_06_sleek .wcop_sp_addons_options_container .whcom_panel .whcom_padding_10{
        padding: 0 !important;
    }
    .whcom_main.wcop_sp_06_sleek .wcop_sp_addons_options_container .whcom_panel .whcom_padding_10 span:first-child {
        display: block;
        font-size: 19px;
        color: #113f6d;
        font-weight: 700;
    }

    .whcom_main.wcop_sp_06_sleek .wcop_sp_section_heading i{
        display: none;
    }

    #wcop_sp_main.whcom_main.wcop_sp_06_sleek .wcop_sp_section_heading {
        /*color: #0068b1;*/
        border-bottom: none;
        padding: 15px 15px;
        margin-bottom: 0px;
        padding-top: 0;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_sp_domain_config .wcop_sp_section_heading{
        background-color: #e9ebe7 !important;
        /*color: #59697d;*/
        font-weight: 400;
        border: none;
        padding: 2px 10px;
        height: 40px;
        line-height: 38px;
        position: relative;
    }
    /*#wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_sp_domain_config .wcop_sp_section_heading:before {*/
        /*content: "";*/
        /*background: #fff;*/
        /*height: 45px;*/
        /*width: 79px;*/
        /*position: absolute;*/
        /*bottom: -498%;*/
        /*left: -10px;*/
        /*z-index: 99999;*/
    /*}*/
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_sp_choose_a_domain .whcom_text_success {
        /*color: #b0ca67 !important;*/
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_sp_choose_a_domain .whcom_button.whcom_button_success{
        /*border-color: #b0ca67;*/
        /*background: #b0ca67 ;*/
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_sp_choose_a_domain .whcom_tabs_container .whcom_button{
        height: 67px;
        line-height: 18px !important;
        text-transform: uppercase;
        font-weight: 600;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_sp_choose_a_domain .whcom_button.whcom_button_success:hover{
        /*border-color: #72ca44;*/
        /*background: #72CA44 ;*/
    }
    #wcop_sp_main.whcom_main.wcop_sp_6706_sleek div#wcop_sp_domain_config label.main_label {
        /*color: #113f6d;*/
    }

    #wcop_sp_main.whcom_main.wcop_sp_06_sleek .whcom_alert.whcom_alert_info {
        /*border-color: #b3becc;*/
        /*background-color: #dfeaf8;*/
        /*color: #3f5167;*/
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek  .whcom_sub_heading_style_1 {
        border: none;
        text-align: left;
        font-size: 22px;
        color: #0068b1;
    }
    div#wcop_sp_domain_config .whcom_panel.whcom_text_small.whcom_op_addon_container.whcom_bg_white {
        padding: 2rem;
        border: 1px solid #59d2ef;
        border-radius: 6px;
        background: #fff;
        cursor: pointer;
        padding-bottom: 10px;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek  .whcom_sub_heading_style_1 span{
        font-size: 18px;
        color: #0068b1;
        background: transparent;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_review_checkout .whcom_button_block {
        /*background-color: #0068b1;*/
        height: 67px;
        line-height: 18px !important;
    }
    /*#wcop_sp_main.whcom_main.wcop_sp_06_sleek .whcom_button_block:hover{*/
        /*background-color: #22527b;*/
        /*border-color: #22527b;*/
    /*}*/
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek button.whcom_button.whcom_button_big{
        /*background-color: #0068b1;*/
        /*border: none;*/
        font-size: 14px !important;
        background-color: #59d2ef;
        padding: .8rem 2rem !important;
        border: none;
        font-weight: 700;
        color: #113f6d;
        height: 47px;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek button.whcom_button.whcom_button_big:hover{
        /*background-color: #22527b;*/
        /*border-color: #22527b;*/
    }

    #wcop_sp_main.whcom_main.wcop_sp_06_sleek .whcom_form_field  label{
        /*color: #0068b1;*/
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek .whcom_tabs_container.whcom_tabs_fancy_2 ul {
        font-size: 0;
        border: none;
    }
    .whcom_main.wcop_sp_06_sleek .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li{
        background: #c6eff9;
        color: #333333 !important;
        position: relative;
        -webkit-transition: color 0.2s;
        transition: color 0.2s;
        padding: 12px 49px;
        padding-top: 53px;
        border: 1px solid #59d2ef;
        font-size: 13px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 18px;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_sp_choose_a_domain .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li::before{
        content: "\f0ec";
        position: absolute;
        top: 0;
        left: 0;
        font-size: 25px;
        font-family: FontAwesome;
        width: 100%;
        color: #113f6d;
        border-radius: 8px 8px 0px 0;
        text-align: center;
        padding-top: 9px;
        background: #ffffff;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_sp_choose_a_domain .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li:first-child:before{
        content: "\f233";
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_sp_choose_a_domain .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li:last-child:before{
        content: "\f046";
    }
    .whcom_main.wcop_sp_06_sleek .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li.active {
        box-shadow: none;
        color: #333333;
        border: 2px solid #00a2bf;
    }#wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_review_checkout .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li.active:before,
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_sp_choose_a_domain .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li.active:before{
        background: #e0f6fd;
    }

    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_review_checkout .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li:before{
        content: "\f06b";
        position: absolute;
        top: 0;
        left: 0;
        font-size: 25px;
        font-family: FontAwesome;
        width: 100%;
        color: #113f6d;
        border-radius: 8px 8px 0px 0;
        text-align: center;
        padding-top: 9px;
        background: #ffffff;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_review_checkout .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li:last-child:before{
        content: "\f080";
    }
    div#wcop_choose_a_hosting .prev {
        display: none;
    }
    div#wcop_choose_a_hosting .prev.show-button{
        display: block;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_billing_info{
        position: relative;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_billing_info .whcom_form_field.whcom_text_center {
        position: absolute;
        right: 34px;
        bottom: -108px;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_sp_domain_config .whcom_form_field label.whcom_checked:after{
        top: 10px;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek .wcop_sp_order_summary {
        color: grey;
        box-shadow: 0 2px 10px 0 rgba(0,0,0,.1);
        padding: 12px;
        margin-bottom: 14px;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek .wcop_sp_order_summary strong {
        color: #113f6d;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek .wcop_sp_order_summary .whcom_text_right.whcom_text_2x{
        background-color: #113f6d;
        color: #fff;
        width: 100%;
        max-width: 11rem;
        margin: 0 auto;
        margin-right: 0;
        padding: 1rem;
        font-size: 20px !important;
    }

    #wcop_sp_main.whcom_main.wcop_sp_06_sleek .nav_div{
        display: none;
    }

    label.whcom_label_product span.item_product span {
        display: flex;
        margin: 5px 0;
    }

    label.whcom_label_product.whcom_radio {
        border: 2px solid #59d2ef;
        background: #fff;
        display: block;
        position: relative;
        -ms-flex-pack: start;
        justify-content: start;
        border-radius: 6px;
        cursor: pointer;
        padding: 20px;
        padding-bottom: 0;
        margin-bottom: 10px;
        padding-left: 20px !important;
    }

    label.whcom_label_product.whcom_radio.selected span.item_product{

    }
    label.whcom_label_product.whcom_radio.whcom_checked {
        border: 2px solid #00a2bf;
        background: #e0f6fd;
        box-shadow: 0 4px 6px 1px #dfeaf8;
    }
    label.whcom_label_product.whcom_radio.whcom_checked:hover {
        border: 2px solid #59d2ef;
        background: #e0f6fd;
    }
    label.whcom_label_product.whcom_radio:before {
        top: 31px;
        left: 20px;
    }
    label.whcom_label_product.whcom_radio.whcom_checked:after {
        left: 25px !important;
        top: 26px !important;
    }
    label.whcom_label_product span.item_product {
        display: block;
        padding-top: 1.2rem;
        padding-left: 0;
        border-top: 1px solid #bbbdbf;
        margin-top: .6rem;
    }
    label.whcom_label_product.whcom_radio.selected span.item_product{
        display: none;
    }
    label.whcom_label_product span.item_product span span {
        display: inline-block;
        width: 100%;
        max-width: 65%;
        padding: 0 15px;
        margin: 0;
    }
    label.whcom_label_product span.item_product span strong {
        max-width: 35%;
        width: 100%;
        display: inline-block;
        padding-left: 15px;
    }

    label.whcom_label_product span.footer_product {
        display: block;
        background: #c6eff9;
        text-align: center;
        font-weight: 600;
        font-size: 18px;
        border-bottom-left-radius: inherit;
        border-bottom-right-radius: inherit;
        margin: 0 -20px;
        padding: 10px 0;
    }
    label.whcom_label_product span.whcom_product_content {
        display: block;
        position: relative;
        padding: 0;
        padding-left: 25px;
    }
    label.whcom_label_product.whcom_radio.selected span.whcom_product_content{
        padding-bottom: 20px;
    }
    label.whcom_label_product input[type=checkbox],  label.whcom_label_product input[type=radio]{
        opacity: 0;
        position: relative;
    }

    label.whcom_label_product span.whcom_product_content span {
        background-color: #b0ca67;
        padding: .2rem 1rem;
        border-radius: 1rem;
        font-size: 11px;
        color: #fff;
        white-space: nowrap;
        position: relative;
        left: 15px;
    }


    #wcop_sp_main.wcop_sp_main .wcop_sp_order_summary .whcom_list_bordered li {
        border: none;
        border-bottom: 1px solid #c1c1c1;
        margin-top: -1px;
    }
    #wcop_sp_main.wcop_sp_main .wcop_sp_order_summary .wcop_sp_summary_totals {
        margin: -1px 0 15px;
        padding: 0;
        border: none;
        border-top: 2px solid #d5dae0;
    }

    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_summary_totals span.whcom_pull_right {
        width: 11rem;
        text-align: right;
        padding: 1rem;
        background-color: #e0f6fd;
        font-weight: bold;
        color: black;
        font-size: 20px;
    }

    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_summary_totals .whcom_pull_right_sm {
        width: 11rem;
        text-align: right;
        padding: 1rem;
        background-color: #e0f6fd;
        font-weight: bold;
        color: black;
        font-size: 16px;
    }

    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_summary_totals .whcom_pull_left_sm {
        width: 78%;
    }

    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_summary_totals .whcom_pull_left_sm span.whcom_pull_left {
        width: 100%;
        text-align: right;
        padding: 1rem;
        font-size: 20px;
        font-weight: 400;
        color: #122844;
    }


    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_summary_totals .whcom_padding_10_0.whcom_bordered_bottom {
        padding: 0 !important;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_summary_totals .whcom_clearfix.whcom_margin_bottom_5.whcom_padding_5_0.whcom_bordered_bottom{
        margin-bottom: 0 !important;
    }

    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_summary_totals .whcom_padding_10_0.whcom_bordered_bottom span.whcom_pull_right{
        background-color: #f5fcfd;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .whcom_padding_10_0.whcom_bordered_bottom  span.whcom_pull_left,
    .whcom_clearfix.whcom_margin_bottom_5.whcom_padding_5_0.whcom_bordered_bottom span.whcom_pull_left {
        width: 78%;
        text-align: right;
        padding: 1rem;
        font-size: 20px;
        font-weight: 400;
        color: #122844;
    }

    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_summary_totals .whcom_clearfix.whcom_margin_bottom_30 {
        margin-bottom: 0 !important;
        border-top: 2px solid #000;
    }
    #wcop_sp_main.wcop_sp_main div#wcop_review_checkout .whcom_form_field > input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]),
    #wcop_sp_main.wcop_sp_main .wcop_sp_check_product_domain .whcom_form_field > input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]),
    #wcop_sp_main.wcop_sp_main .wcop_sp_check_product_domain .whcom_form_field select,
    #wcop_sp_main.wcop_sp_main div#wcop_review_checkout .whcom_form_field select{
        height: 67px !important;
        background: #fff;
        border: .2rem solid #e1e4df;
    }

    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .my-button-item button.next {
        background-color: #59d2ef;
        padding: .8rem 2rem;
        border: none;
        font-weight: 700;
        color: #113f6d;
        padding-right: 1rem;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .my-button-item button.next:hover {
        background-color: #34c4e2;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .my-button-item  i.whcom_icon_angle-circled-right,
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .my-button-item button.next i{
        margin-left: 10px;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .my-button-item button#skip_prev,
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .my-button-item button.prev.whcom_button_secondary.show-button {
        padding: .7rem 2rem;
        background-color: #fff;
        border: 1px solid #bdbec0;
        color: #113f6d;
        font-weight: 700;
        padding-left: 1rem;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .my-button-item button#skip_prev i,
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .my-button-item button.prev.whcom_button_secondary.show-button i{
        margin-right: 10px;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .open{
     cursor: pointer;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .whcom_prod_collapse{
        cursor: pointer;
    }

    div#wcop_choose_a_hosting .wcop_sp_section_content {
        padding: 0 !important;
    }

    button#skip {
        padding: .7rem 2rem;
        background-color: #fff;
        border: 1px solid #bdbec0;
        color: #113f6d;
        font-weight: 700;
        padding-right: 1rem;
    }
    .wcop_product_description_sleek strong.wcop_description_title,
    .wcop_product_description_sleek span.wcop_description_value {
        display: inline-block !important;
        width: 100%;
        max-width: 49%;
    }

    label.whcom_label_product span.footer_product .whcom_margin_bottom_15.whcom_bordered_bottom.whcom_text_center {
        margin-bottom: 0 !important;
        border: none;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek div#wcop_sp_domain_config span.whcom_button.whcom_button_block{
        display: none !important;
    }

    .wcop_main.wcop_sp_main.wcop_sp_06_sleek div#wcop_sp_domain_config .whcom_panel_footer.whcom_bg_white.whcom_text_center .whcom_padding_10 {
        display: block;
        font-size: 19px;
        color: #113f6d;
        font-weight: 700;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_radio_billingcycle_box {
        padding: 2rem;
        border: 1px solid #59d2ef;
        border-radius: 6px;
        background: #fff;
        display: inline-block;
        width: 100%;
        max-width: 31%;
        margin-right: 12px;
        margin-bottom: 12px;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_radio_billingcycle_box span.wcop_price_setup_fee,
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_radio_billingcycle_box strong.wcop_actual_price {
        display: block;
        text-align: center;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_radio_billingcycle_box strong.wcop_actual_price {
        border-top: 1px solid #CCCCCC;
        padding-top: 10px;
        margin-top: 10px;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_radio_billingcycle_box span.wcop_price_setup_fee {
        color:#333333;
        font-size: 13px;
    }
    div#wcop_billing_info .whcom_tabs_content .selected {
        display: none;
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
    @media (max-width: 1150px){
        .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li li span{
            display: none;
        }
        .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li li.current span {
            display: inline;
        }
    }
    @media only screen and (min-width: 1150px)  {
        #wcop_sp_main.whcom_main.wcop_sp_06_sleek .my_container{
            width: 960px;
            margin: 0 auto;
        }
    }
    @media only screen and (max-width: 750px){
        #wcop_sp_main.whcom_main.wcop_sp_06_sleek .whcom_tabs_container.whcom_tabs_fancy_2 ul.whcom_tab_links li{
            display: block;
            margin: 12px;
        }
    }
    @media only screen and (max-width: 600px){
        .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li li.current span {
           display: none;
        }
        #wcop_sp_main.whcom_main.wcop_sp_06_sleek .nav_div{
            display: block;
        }
        .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li{
            padding-top: 25px;
        }
        .whcom_main.wcop_sp_06_sleek .whcom_panel_body.whcom_form_field {
            height: 69px;
        }
        .whcom_main.wcop_sp_06_sleek .whcom_checkbox_container.whcom_text_center, .whcom_main.wcop_sp_06_sleek .wcop_sp_addons_options_container .whcom_form_field{
            height: 94px !important;
        }
        .wcop_main.wcop_sp_main.wcop_sp_06_sleek .whcom_padding_10_0.whcom_bordered_bottom span.whcom_pull_left, .whcom_clearfix.whcom_margin_bottom_5.whcom_padding_5_0.whcom_bordered_bottom span.whcom_pull_left{
            width: 50%;
            text-align: left;
        }
        .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_summary_totals span.whcom_pull_right {
            width: 140px
        }
        .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_summary_totals .whcom_pull_right_sm {
            width: 100%;
        }
        .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_summary_totals .whcom_pull_left_sm span.whcom_pull_left{
            text-align: left;
        }
        #wcop_sp_main.whcom_main.wcop_sp_06_sleek .wcop_sp_order_summary .whcom_text_right.whcom_text_2x{
            max-width: 100%;
        }
        #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_billing_info .whcom_form_field.whcom_text_center{
            right: 4px;
        }
    }


    @media only screen and (max-width: 320px) {
        #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_billing_info .whcom_form_field.whcom_text_center {
            right: 38px;
            bottom: -166px;
        }
        #wcop_sp_main.whcom_main.wcop_sp_06_sleek .my-button-item{
            text-align: center;
        }
        #wcop_sp_main.whcom_main.wcop_sp_06_sleek .my-button-item .skip_prev,
        #wcop_sp_main.whcom_main.wcop_sp_06_sleek .my-button-item .prev,
        #wcop_sp_main.whcom_main.wcop_sp_06_sleek .my-button-item .next {
            float: none !important;
            margin-bottom: 16px;
        }
        #wcop_sp_main.whcom_main.wcop_sp_06_sleek div#wcop_billing_info .whcom_tabs_container .whcom_col_sm_6.whcom_client-area ul.whcom_tab_links li{
            font-size: 15px;
        }
        .whcom_main.wcop_sp_06_sleek .whcom_checkbox_container.whcom_text_center, .whcom_main.wcop_sp_06_sleek .wcop_sp_addons_options_container .whcom_form_field {
            height: 106px !important;
        }
        .wcop_main.wcop_sp_main.wcop_sp_06_sleek .whcom_padding_10_0.whcom_bordered_bottom span.whcom_pull_left, .whcom_clearfix.whcom_margin_bottom_5.whcom_padding_5_0.whcom_bordered_bottom span.whcom_pull_left {
            width: 100%;
            text-align: center;
        }
        .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop_sp_summary_totals span.whcom_pull_right {
            width: 100%;
            text-align: center;
        }
    }
</style>


<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
?>
<?php
$show_prod_desc              = $atts['show_summary_product_description'];
$promocode                   = $atts['promocode'];
$hide_group_name             = $atts['hide_group_name_summary'];
$hide_domain_transfer        = $atts['hide_domain_transfer'];
$_SESSION['hide_domain_transfer_section'] = $hide_domain_transfer;
$_SESSION['hide_group_name'] = $hide_group_name;
$_SESSION['prod_desc']       = $show_prod_desc;
?>

<div class="whcom_main wcop_main wcop_sp_main wcop_sp_06_sleek whcom_bordered_sides" id="wcop_sp_main">
    <?php if (strtolower($atts['hide_navigation']) !='yes'){ ?>
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
                    <?php if ($atts['hide_domain'] != 'yes'){ ?>
                        <li class="step-<?php echo $steps_array_count['domain_count'] ?>">
                            <span>Domain</span>
                        </li>
                    <?php } ?>
                    <?php if ($atts['hide_product'] != 'yes'){  ?>
                        <li class="step-<?php echo $steps_array_count['product_count'] ?>">
                            <span>Hosting Plan</span>
                        </li>
                    <?php } ?>
                    <?php if ($atts['hide_additional_services'] != 'yes'){  ?>
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
        <?php include wcop_get_template_directory() . '/templates/single_page/01_default/01_top_nav.php'?>
        <?php include wcop_get_template_directory() . '/templates/single_page/01_default/02_product_dropdowns.php'?>
        <?php if ( strtolower( $atts['hide_domain'] ) != 'yes' ) { ?>
            <div id="wcop_sp_choose_a_domain" class="wcop_sp_section wcop_sp_section_domain whcom_margin_bottom_0 whcom_bg_white whcom_padding_bottom_30">
                <?php include_once( wcop_get_template_directory() . '/templates/single_page/06_sleek/02_domain.php' ); ?>
            </div>
        <?php } ?>
        <div class="wcop_sp_add_product_form">
            <form class="wcop_sp_add_product" method="post">
                <input type="hidden" name="action" value="wcop_sp_process">
                <input type="hidden" name="wcop_sp_what" value="add_order">
                <input type="hidden" name="wcop_sp_template" value="06_sleek">
                <input type="hidden" name="cart_index" value="-1">
                <input type="hidden" name="default_billingcycle" value="<?php echo $atts['billingcycle'];?>">
                <div class="mydivs">
                    <?php if ( strtolower( $atts['hide_domain'] ) != 'yes' ) { ?>
                        <div id="wcop_sp_domain_config" class="wcop_sp_section wcop_sp_section_domain" style="display: none">
                            <div class="wcop_sp_section_heading whcom_bg_primary">
                                <i class="whcom_icon_www"></i>
                                <span><?php esc_html_e( "Domain Configuration", "whcom" ) ?></span>
                                <span id="edit_domain" style="float: right; cursor: pointer"><?php esc_html_e( "Edit Domain", "whcom" ) ?></span>
                            </div>
                            <div class="wcop_sp_section_content">
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ( strtolower( $atts['hide_product'] ) != 'yes' ) { ?>
                        <div id="wcop_choose_a_hosting"
                             class="wcop_sp_section <?php echo (!empty($atts['hide_selected_product']) && strtolower($atts['hide_selected_product']) == 'yes' && !empty($atts['pid'])) ? 'hidden' : '' ?>">
                            <?php include_once( wcop_get_template_directory() . '/templates/single_page/06_sleek/03_product.php' ); ?>
                        </div>
                    <?php } ?>
                    <?php if ( strtolower( $atts['hide_additional_services'] ) != 'yes' ) { ?>
                        <div id="wcop_additional_services" class="wcop_sp_section">
                            <?php include_once( wcop_get_template_directory() . '/templates/single_page/06_sleek/04_options.php' ); ?>
                        </div>
                    <?php } ?>
                    <div id="wcop_billing_info" class="wcop_sp_section">
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
                        <?php include_once( wcop_get_template_directory() . '/templates/single_page/06_sleek/05_client.php' ); ?>
                    </div>

                    <div id="wcop_review_checkout" class="wcop_sp_section">
                        <?php include_once( wcop_get_template_directory() . '/templates/single_page/06_sleek/07_checkout.php' ); ?>
                    </div>

                </div>
            </form>
        </div>
        <div class="wcop_sp_section_content" >
            <div class="my-button-item">
                <?php if (strtolower($atts['hide_domain']) != 'yes') { ?>
                <div class="wcop_sp_button">
                    <?php if ( strtolower( $atts['hide_product'] ) != 'yes' ) { ?>
                    <button name="skip" id="skip" class="skip whcom_button_secondary" value="skip" onclick="skip()" style="float: left;">Skip <i class="whcom_icon_angle-circled-right"></i></button>
                    <?php } ?>
                    <button name="next" class="next"  disabled="disabled" value="continue" onclick="Gotonext()" style="float:right;">Next <i class="whcom_icon_angle-circled-right"></i></button>
                </div>
                <?php } ?>
                <div class="wcop_sp_button">
                    <?php if (strtolower($atts['hide_domain']) != 'yes') { ?>
                    <button name="skip_prev" id="skip_prev" class="skip_prev whcom_button_secondary" value="skip_prev" onclick="skip_prev()" style="float: left;"><i class="whcom_icon_angle-circled-left"></i> Previous</button>
                    <?php } ?>
                    <button name="next" class="next"   value="continue" onclick="Gotonext()" style="float:right;">Next <i class="whcom_icon_angle-circled-right"></i></button>
                </div>
                <?php if (strtolower($atts['hide_product']) != 'yes') { ?>
                <div class="wcop_sp_button">
                    <button name="prev" class="prev whcom_button_secondary" onclick="Gotoprevious()" style="float: left;"><i class="whcom_icon_angle-circled-left"></i> Previous</button>
                    <button name="next" class="next"   value="continue" onclick="Gotonext()" style="float:right;">Next <i class="whcom_icon_angle-circled-right"></i></button>
                </div>
                <?php } ?>
                <?php if (strtolower($atts['hide_additional_services']) != 'yes') { ?>
                <div class="wcop_sp_button">
                    <div class="wcop__inner__billing__info" <?php echo $atts['post_load_login_form'] == 'yes' ? 'style="display: none"' : 'style="display: block"'  ?>>
                    <button name="prev" class="prev whcom_button_secondary" onclick="Gotoprevious()" style="float: left;"><i class="whcom_icon_angle-circled-left"></i> Previous</button>
                    <button name="next" class="next" value="continue" onclick="Gotonext()" style="float:right;">Next <i class="whcom_icon_angle-circled-right"></i></button>
                    </div>
                </div>

                <div class="wcop_sp_button">
                    <button name="prev" class="prev whcom_button_secondary" onclick="Gotoprevious()" style="float: left;"><i class="whcom_icon_angle-circled-left"></i> Previous</button>
                </div>
                <?php } ?>
            </div>
            <!--<button name="prev" class="prev" onclick="Gotoprevious()" style="color: #fff; background-color: #929FAC; border: none; float: left">Back</button>
            <button name="next" disabled="disabled" class="next" value="continue" onclick="Gotonext()" style="float:right; background-color: #0068b1; border: none;">Continue</button>-->
<!--            <button name="skip" class="skip" value="skip" onclick="skip()" style="color: #fff; background-color: #929FAC; border: none; float: left">Skip</button>-->
<!--            <button name="skip_prev" class="skip_prev" value="skip_prev" onclick="skip_prev()" style="color: #fff; background-color: #929FAC; border: none; float: left">Back</button>-->
            <div style="clear: both"></div>
        </div>
    </div>
</div>




<script>



    jQuery(document).ready(function() {
        var divs = jQuery('.mydivs > .wcop_sp_section');
        var now = 0; // currently shown div
        divs.hide().first().show(); // hide all divs except first

        jQuery('.step-0').addClass('active current');

        jQuery("button[name=skip]").click(function() {
            divs.eq(now).hide();
            now = (now + 1 < divs.length) ? now + 1 : 0;
            divs.eq(now).show(); // show next
        });
        jQuery("button[name=next]").click(function() {
            divs.eq(now).hide();
            now = (now + 1 < divs.length) ? now + 1 : 0;
            divs.eq(now).show(); // show next
        });
        jQuery("button[name=prev]").click(function() {
            divs.eq(now).hide();
            now = (now > 0) ? now - 1 : divs.length - 1;
            divs.eq(now).show(); // show previous
        });
        jQuery("button[name=skip_prev]").click(function() {
            divs.eq(now).hide();
            now = (now > 0) ? now - 1 : divs.length - 1;
            divs.eq(now).show(); // show previous
        });
    });

    jQuery(document).ready(function() {
        var divs = jQuery('.my-button-item > .wcop_sp_button');
        var now = 0; // currently shown div
        divs.hide().first().show(); // hide all divs except first
        jQuery("button[name=skip]").click(function() {
            divs.eq(now).hide();
            now = (now + 1 < divs.length) ? now + 1 : 0;
            divs.eq(now).show(); // show next
        });
        jQuery("button[name=next]").click(function() {
            divs.eq(now).hide();
            now = (now + 1 < divs.length) ? now + 1 : 0;
            divs.eq(now).show(); // show next
        });
        jQuery("button[name=prev]").click(function() {
            divs.eq(now).hide();
            now = (now > 0) ? now - 1 : divs.length - 1;
            divs.eq(now).show(); // show previous
        });
        jQuery("button[name=skip_prev]").click(function() {
            divs.eq(now).hide();
            now = (now > 0) ? now - 1 : divs.length - 1;
            divs.eq(now).show(); // show previous
        });
    });


    jQuery(document).ready(function() {
        var divs = jQuery('.nav_div > .wcop_sp_div');
        var now = 0; // currently shown div
        divs.hide().first().show(); // hide all divs except first
        jQuery("button[name=skip]").click(function() {
            divs.eq(now).hide();
            now = (now + 1 < divs.length) ? now + 1 : 0;
            divs.eq(now).show(); // show next
        });
        jQuery("button[name=next]").click(function() {
            divs.eq(now).hide();
            now = (now + 1 < divs.length) ? now + 1 : 0;
            divs.eq(now).show(); // show next
        });
        jQuery("button[name=prev]").click(function() {
            divs.eq(now).hide();
            now = (now > 0) ? now - 1 : divs.length - 1;
            divs.eq(now).show(); // show previous
        });
        jQuery("button[name=skip_prev]").click(function() {
            divs.eq(now).hide();
            now = (now > 0) ? now - 1 : divs.length - 1;
            divs.eq(now).show(); // show previous
        });

    });
    ////    jQuery( document ).ready(function() {
    ////        jQuery("button").click(function (e) {
    ////            jQuery(".wcop-wight-li li.step-1").addClass("active current");
    ////            jQuery(".wcop-wight-li li.active").removeClass("current");
    ////            e.stopPropagation();
    ////        });
    //
    //    });


    var count=0;
    function skip(){
        jQuery("#wcop_sp_choose_a_domain").css("display","none");
        jQuery("#wcop_sp_domain_config").css("display","none");
        var divs = jQuery('.mydivs > .wcop_sp_section');
        var now = 0; // currently shown div
        jQuery(".wcop-wight-li li.step-" + 0).removeClass(' current');
        jQuery(".wcop-wight-li li.step-" + 1).addClass(' active current');
        /*divs.first().hide(); // hide all divs except first
        divs.eq("1").show();*/
       /* jQuery('.next').removeAttr("disabled");*/
//        jQuery('.skip_prev').show();
//        jQuery(".skip").hide();
        count++;

    }
    function skip_prev(){
        jQuery("#wcop_sp_choose_a_domain").css("display","block");
        jQuery("#wcop_sp_domain_config").css("display","block");
        if (jQuery('.wcop-wight-li li').hasClass('step-' + 1 + ' active')) {
            jQuery(".wcop-wight-li li.step-" + 1).removeClass(' active current');
            jQuery(".wcop-wight-li li.step-" + 0).addClass(' active current');
        }
        var divs = jQuery('.mydivs > .wcop_sp_section');
        var now = 0;
        /*divs.first().show(); // hide all divs except first
        divs.eq("1").hide();*/
//        jQuery(".skip_prev").hide();
        count=0;
    }

    function Gotonext()
    {
        var advanced_count = count+1;
        if (jQuery('.wcop-wight-li li').hasClass('step-' + count + ' active current')) {
            jQuery(".wcop-wight-li li.step-" + count).removeClass(' current');
            jQuery(".wcop-wight-li li.step-" + advanced_count).addClass(' active current');
        }
//        var element = document.getElementsByClassName("prev");
//        element.classList.add("active");
        jQuery(".prev").addClass('show-button');
//        jQuery(".skip").hide();
//        jQuery(".skip_prev").hide();
        count++;
    }
    function Gotoprevious()
    {
        var advanced_prev_count = count-1;
        if (jQuery('.wcop-wight-li li').hasClass('step-' + count + ' active')) {
            jQuery(".wcop-wight-li li.step-" + count).removeClass(' active current');
            jQuery(".wcop-wight-li li.step-" + advanced_prev_count).addClass(' active current');
        }
        count--;
    }


    //    jQuery(".whcom_button").click(function(event){
    //        event.preventDefault();
    //        jQuery('button').removeAttr("disabled")
    //    });

    //jQuery('.next').prop("disabled", true);
    jQuery("#require_Domain_search").click (function () {
        var domain_name_text = document.getElementById("domain");
        if ((domain_name_text.value) !== '') {
            jQuery('.next').removeAttr("disabled");
            //jQuery('.next').text('Continue')
        }
    });
    /*var domain_name_text_simple_03 = document.getElementById("domain");
    var domain_name = document.getElementById("domain_search_div");
    if ((domain_name_text_simple_03.value) === '') {
        //jQuery(".next" ).button( "option", "label", "Skip" );
        jQuery('.next').text('Skip');
        jQuery(".next").click (function () {
            jQuery('.wcop_sp_choose_a_domain').hide();
        });
    }*/


    jQuery("#require_Domain_transfer").click (function () {
        var domain_name_text = document.getElementById("domain_transfer");
        if ((domain_name_text.value) !== '') {
            jQuery('.next').removeAttr("disabled");
        }
    });

    jQuery("#require_Domain_use").click (function () {
        var domain_name_text = document.getElementById("domain_use");
        if ((domain_name_text.value) !== '') {
            jQuery('.next').removeAttr("disabled");
        }
    });




    jQuery(document).ready(function() {
        jQuery('.whcom_label_product.whcom_radio').click(function(){
            jQuery('.whcom_label_product.whcom_radio').addClass('selected');
        });
        jQuery('.open').click(function(){
            jQuery('.whcom_label_product.whcom_radio').removeClass('selected');
            jQuery(this).css("display","none");
            jQuery('.whcom_prod_collapse').css("display","block")
        });
        jQuery('.whcom_prod_collapse').click(function(){
            jQuery('.whcom_label_product.whcom_radio').addClass('selected');
            jQuery(this).css("display","none");
            jQuery('.open').css("display","block")
        });
    });


    jQuery(document).ready(function() {
        jQuery('#login-tab').click(function(){
            jQuery('.login-tab-1').addClass('selected');
            jQuery('.login-tab-2').removeClass('selected');
        });
        jQuery('#register-tab').click(function(){
            jQuery('.login-tab-2').addClass('selected');
            jQuery('.login-tab-1').removeClass('selected');
        });
    });

</script>










