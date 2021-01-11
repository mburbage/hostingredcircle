<style>
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
        padding: 0 10px 36px;
        font-size: 17px;
        text-align: center;
        vertical-align: middle;
        counter-increment: step;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li {
        background-color: #fff;
        color: rgba(0,24,94,.4) ;
        text-align: center;
        padding: 40px 0;
    }

    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li:before {
        content: " ";
        position: absolute;
        border-bottom: 4px solid #59697d;
        left: 63%;
        bottom: -2px;
        width: 73%;
        border-bottom: 1px solid rgba(0,24,94,.4);
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li:last-child:before{
        border: none;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.active:before {
        border-color: #0050d7;
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
        width: 42px;
        height: 42px;
        font-size: 14px;
        line-height: 33px;
        padding: 3px;
        font-weight: 700;
        text-align: center;
        color: #3f5167;
        border-radius: 50%;
        border: 1px solid rgba(0,24,94,.4);
        background: transparent;
        color: rgba(0,24,94,.4);
        box-shadow: none;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.active:after {
        color: #3f5167;
        background-color: #52d2f0;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.current:after {
        color: #0050d7;
        background-color: transparent;
        border: 2px solid #0050d7;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.active:not(.current):after {
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        content: "\f00c";
        font-size: 14px;
        line-height: 33px;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.active.current{
        color: #0050d7;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.active{
        color: #0050d7;
    }

    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .wcop-wight-li ul li.active:after {
        color: #0050d7;
        border: 2px solid #0050d7;
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
        color: #00185e;
        border-bottom: none;
        padding: 15px 0px;
        margin-bottom: 0px;
        padding-top: 0;
        font-weight: 400;
        font-size: 36px;
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
        height: 60px;
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
        height: 60px;
        line-height: 18px !important;
    }
    /*#wcop_sp_main.whcom_main.wcop_sp_06_sleek .whcom_button_block:hover{*/
        /*background-color: #22527b;*/
        /*border-color: #22527b;*/
    /*}*/
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek button.whcom_button.whcom_button_big{
        /*background-color: #0068b1;*/
        /*border: none;*/
        font-size: 20px !important;
        background-color: #59d2ef;
        padding: .8rem 2rem !important;
        border: none;
        font-weight: 700;
        color: #113f6d;
        height: 70px;
        padding: 15px 59px !important;
        margin-top: 20px;
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
        margin-bottom: 31px;
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
        border-radius: 8px;
        font-weight: 700;
        font-size: 18px;
        overflow: hidden;
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
        /*display: none;*/
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
        border: 1px solid #59d2ef;
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
        border: 1px solid #0050d7;
        background: #e0f6fd;
        box-shadow: 0 4px 6px 1px #dfeaf8;
    }
    label.whcom_label_product.whcom_radio.whcom_checked:hover {
        border: 1px solid #59d2ef;
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
        height: 60px !important;
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
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .my-button-item button.prev {
        padding: .7rem 2rem;
        background-color: #fff;
        border: 1px solid #bdbec0;
        color: #113f6d;
        font-weight: 700;
        padding-left: 1rem;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .my-button-item button#skip_prev i,
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .my-button-item button.prev i{
        margin-right: 10px;
    }
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .whcom_prod_collapse,
    .wcop_main.wcop_sp_main.wcop_sp_06_sleek .open{
     cursor: pointer;
        font-size: 18px;
        margin-bottom: 18px;
        font-weight: 700;
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
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek .wcop_sp_section_content {
        max-width: 1100px;
        margin: 0 auto 30px;
        padding: 5% 5% !important;
        overflow: hidden;
        box-shadow: 0 0 0.2em rgba(0,14,156,.4);
        background: #fff;
        border-radius: 4px;
    }

    #wcop_sp_main.whcom_main.wcop_sp_06_sleek .whcom_bg_white{
        background-color: transparent !important;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek .wcop_sp_section_content.wcop_sp_section_navi {
        background: transparent;
        box-shadow: none;
        padding: 10px;
    }

    #wcop_sp_main.wcop_sp_main .whcom_form_field > input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]), #wcop_sp_main.wcop_sp_main .whcom_form_field select, #wcop_sp_main.wcop_sp_main .whcom_form_field textarea, #wcop_sp_main.wcop_sp_main .whcom_form_field .whcom_plus, #wcop_sp_main.wcop_sp_main .whcom_form_field .whcom_minus {
        border-radius: 4px !important;
    }
    #wcop_sp_main.wcop_sp_main .whcom_form_field .whcom_plus,
    #wcop_sp_main.wcop_sp_main .whcom_form_field .whcom_minus{
        background: #113f6d;
        color: #fff;
    }
    #wcop_sp_main.whcom_main.wcop_sp_06_sleek .wcop_sp_section_heading.whcom_bg_primary span#edit_domain {
        border: 2px solid #113f6d;
        font-weight: 700;
        color: #113f6d;
        font-size: 18px;
        padding: 7px 23px;
    }

    #wcop_sp_main.whcom_main.wcop_sp_06_sleek .whcom_tabs_container .whcom_button {
        background: #59d2ef;
        border: 1px solid #59d2ef;
        color: #113f6d;
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
$hide_group_name             = $atts['hide_summary_group_name'];
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
                            <span> <?php esc_html_e("Domain","whcom") ?> </span>
                        </li>
                    <?php } ?>
                    <?php if ($atts['hide_product'] != 'yes'){  ?>
                        <li class="step-<?php echo $steps_array_count['product_count'] ?>">
                            <span> <?php esc_html_e("Hosting Plan","whcom") ?> </span>
                        </li>
                    <?php } ?>
                    <?php if ($atts['hide_additional_services'] != 'yes'){  ?>
                        <li class="step-<?php echo $steps_array_count['service_count'] ?>">
                            <span> <?php esc_html_e("Services",'whcom') ?> </span>
                        </li>
                    <?php } ?>
                    <li class="step-<?php echo $steps_array_count['billing_count'] ?>">
                        <span> <?php esc_html_e("Billing Info","whcom") ?> </span>
                    </li>
                    <li class="step-<?php echo $steps_array_count['checkout_count'] ?>">
                        <span> <?php esc_html_e("Checkout","whcom") ?> </span>
                    </li>
                </ul>
            </div>
        </div>
    <?php } ?>
    <div class="my_container">
        <?php include wcop_get_template_directory() . '/templates/single_page/01_default/01_top_nav.php'?>
        <?php include wcop_get_template_directory() . '/templates/single_page/01_default/02_product_dropdowns.php'?>
        <?php if ( strtolower( $atts['hide_domain'] ) != 'yes' ) { ?>
            <div id="wcop_sp_choose_a_domain" class="wcop_sp_section wcop_sp_section_domain whcom_margin_bottom_0 whcom_bg_white whcom_padding_bottom_30 sleek_domain_section">
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
                        <div id="wcop_sp_domain_config" class="wcop_sp_section wcop_sp_section_domain sleek_domain_config_section" style="display: none">
                            <div class="wcop_sp_section_heading whcom_bg_primary">
                                <i class="whcom_icon_www"></i>
                                <span><?php esc_html_e( "Domain Configuration", "whcom" ) ?></span>
                                <span id="edit_domain" style="float: right; cursor: pointer"><?php esc_html_e( "Edit Domain", "whcom" ) ?></span>
                            </div>
                            <div class="wcop_sp_section_content">
                            </div>
                            <div class="wcop_sp_section_navi">
                                <div class="my-button-item">
                                    <div class="wcop_sp_button">
                                        <button type="button" name="next" class="next"  disabled="disabled" value="continue" onclick="Gotonext('.sleek_domain_config_section')" style="float:right;"> <?php esc_html_e("Next","whcom") ?> <i class="whcom_icon_angle-circled-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ( strtolower( $atts['hide_product'] ) != 'yes' ) { ?>
                        <div id="wcop_choose_a_hosting"
                             class="sleek_product_section wcop_sp_section <?php echo (!empty($atts['hide_selected_product']) && strtolower($atts['hide_selected_product']) == 'yes' && !empty($atts['pid'])) ? 'hidden' : '' ?>">
                            <?php include_once( wcop_get_template_directory() . '/templates/single_page/06_sleek/03_product.php' ); ?>
                        </div>
                    <?php } ?>
                    <?php if ( strtolower( $atts['hide_additional_services'] ) != 'yes' ) { ?>
                        <div id="wcop_additional_services" class="wcop_sp_section sleek_additional_services_section">
                            <?php include_once( wcop_get_template_directory() . '/templates/single_page/06_sleek/04_options.php' ); ?>
                        </div>
                    <?php } ?>
                    <div id="wcop_billing_info" class="wcop_sp_section sleek_billing_info_section">
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

                    <div id="wcop_review_checkout" class="wcop_sp_section sleek_checkout_section">
                        <?php include_once( wcop_get_template_directory() . '/templates/single_page/06_sleek/07_checkout.php' ); ?>
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

    sleek_step_count = 0;
    function Gotonext(current_class_name){
        jQuery('.sleek_domain_section').css('display', 'none');
        jQuery('.sleek_domain_config_section').css('display', 'none');
        jQuery('.sleek_product_section').css('display', 'none');
        jQuery('.sleek_additional_services_section').css('display', 'none');
        jQuery('.sleek_checkout_section').css('display', 'none');
        jQuery('.sleek_billing_info_section').css('display', 'none');

        jQuery(current_class_name).next().css('display', 'block');

        var advanced_sleek_count = sleek_step_count+1;
        if (jQuery('.wcop-wight-li li').hasClass('step-' + sleek_step_count + ' active current')) {
            jQuery(".wcop-wight-li li.step-" + sleek_step_count).removeClass(' current');
            jQuery(".wcop-wight-li li.step-" + advanced_sleek_count).addClass(' active current');
        }
        sleek_step_count++;
    }

    function Gotoprevious(current_class_name) {
        jQuery('.sleek_domain_section').css('display', 'none');
        jQuery('.sleek_domain_config_section').css('display', 'none');
        jQuery('.sleek_product_section').css('display', 'none');
        jQuery('.sleek_additional_services_section').css('display', 'none');
        jQuery('.sleek_checkout_section').css('display', 'none');
        jQuery('.sleek_billing_info_section').css('display', 'none');

        jQuery(current_class_name).prev().css('display', 'block');

        var advanced_sleek_prev_count = sleek_step_count-1;
        if (jQuery('.wcop-wight-li li').hasClass('step-' + sleek_step_count + ' active')) {
            jQuery(".wcop-wight-li li.step-" + sleek_step_count).removeClass(' active current');
            jQuery(".wcop-wight-li li.step-" + advanced_sleek_prev_count).addClass(' active current');
        }
        sleek_step_count--;
    }

    function skip(){
        jQuery('.sleek_domain_section').css('display', 'none');
        jQuery('.sleek_product_section').css('display', 'block');
        jQuery(".wcop-wight-li li.step-" + 0).removeClass(' current');
        jQuery(".wcop-wight-li li.step-" + 1).addClass(' active current');
        sleek_step_count++;
    }

    jQuery(document).on('submit', '.wcop_sp_attach_product_domain', function (e) {
        var domain_name_text = document.getElementById("domain");
        if ((domain_name_text.value) !== '') {
            jQuery('.next').removeAttr("disabled");
        }
    });

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










