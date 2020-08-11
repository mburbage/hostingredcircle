<style>
    .comobo-section .headline-container,
    .comobo-section .box0,
    .comobo-section .product-order-sidebar-ordering {
        background: #337ab7;
    }

    ul.list-unstyled.list-items {
        background-color: #ffffff;
    }

    .headline-container {
        clear: both;
    }

    ul.list-items li.icon-box-list {
        float: left;
        text-align: center;
        width: 100%;
        max-width: 33.3333333333%;
        padding: 15px;
        font-size: 16px;
    }

    li.icon-box-list p {
        margin: 0;
    }

    .comobo-section .side-barleft,
    .comobo-section .side-baright {
        font-size: 18px;
    }

    .comobo-section .box0 span {
        font-size: 20px;
    }

    .product-label {
        background-color: #d05b00;
        font-size: 22px;
    }

    .icon_image:before {
        content: "\f00c";
        font: normal normal normal 14px/1 FontAwesome;
    }

    .icon_image_close:before {
        content: "\f00d";
        font: normal normal normal 14px/1 FontAwesome;
    }

    .color-red {
        color: red;
    }

    .comobo-section .btn.btn-yellow button {
        background: #FFD520;
    }

    ul li img {
        width: 40px;
    }
    #whcom_product .whcom_row .whcom_col_6 {
        padding: 0;
    }

    #whcom_product .whcom_row.row-content {
        margin: 0;
    }

    #whcom_product .whcom_row .whcom_col_6.right-side-border {
        border-right: 1px solid #e0e0e0;
    }

    ul.list-items.side-barleft label.detail_billing_radio input {
        display: none;
    }

    ul.list-items.side-barleft label.detail_billing_radio {
        position: relative;
        padding-left: 23px;
    }

    ul.list-items.side-barleft label.detail_billing_radio:before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 20px;
        left: -7px;
        top: 50%;
        margin-top: -10px;
        border: 2px solid #CFCFCF;
        background: white;
    }

    ul.list-items.side-barleft label.detail_billing_radio.detail_billing_radio_checked:before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 20px;
        left: -7px;
        top: 50%;
        margin-top: -10px;
        border: 2px solid #337ab7;
        background: white;
    }

    ul.list-items.side-barleft label.detail_billing_radio.detail_billing_radio_checked:after {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 10px;
        left: -2px;
        top: 50%;
        margin-top: -5px;
        background: #337ab7;
    }
</style>
<section id="whcom_product" class="comobo-section">
    <div class="whcom_product_name"><h1>{$product_name}</h1></div>
    <div class="whcom_row container m-auto whmpress">
        <div class="whcom_col_xl_8 whcom_col_lg_12 whcom_col_sm_12 flex-box">
            <div class="main-content-list">
                <div class="main-content-list">
                    {foreach $product_headings as $index => $heading} <!-- foreach-1 start -->
                    {if !empty($heading)} <!-- if-1 start -->
                    <div class="headline-container">{{$heading}}</div>
                    {/if}<!-- if-1 end -->
                    {foreach $product_headings_desc as $num => $desc}<!-- foreach-2 start -->
                    {if $index eq $num} <!-- index match if start -->
                        {foreach $desc as $innerindex => $real_desc}<!-- foreach-3 start -->
                            <ul class="list-unstyled list-items">
                                {if $real_desc.feature_title eq "description"}
                                    <li>
                                        {$real_desc.feature_value}
                                    </li>
                                {/if}
                            </ul>
                            {if $index eq 1 && !empty($heading)}<!-- if-2 start -->
                                <ul class="list-unstyled list-items icon-box-list name-2">
                                <li class="icon-box-list">
                                    <img src="{$whmpress_path}/images/check_with_yello.png" alt="">
                                    <p><strong>{$real_desc.feature_title}</strong> </p>
                                    <p>{$real_desc.feature_value}</p>
                                </li>

                            {/if}<!-- if-2 end -->


                        {/foreach}<!-- foreach-3 end -->
                    {/if} <!-- index match if end -->
                    {/foreach}<!-- foreach-2 end -->

                    {/foreach}<!-- foreach-1 end -->
                    <ul class="list-unstyled list-items name-3">
                        {foreach $desc as $innerindex => $real_desc}
                            {if $index > 1 && !empty($heading)}<!-- if-3 start -->
                                <li>
                                    {if $real_desc.feature_value eq "No"}
                                        <i class="fa fa-close color-red"></i>
                                    {else}
                                        <i class="fa fa-check color-green"></i>
                                    {/if}
                                    <strong>{$real_desc.feature_title}:</strong> {$real_desc.feature_value}
                                    {if $real_desc.tooltip_text ne ''}
                                        <span class="whcom_tooltip" style="float: right">
                                    <i class="fa fa-question-circle"></i>
                                <span class="whcom_tooltiptext">{$real_desc.tooltip_text}</span>
                                </span>
                                    {/if}
                                </li>
                            {/if}<!-- if-3 end -->
                        {/foreach}
                    </ul>
                </div>
            </div>
        </div>

        <div class="whcom_col_xl_4 whcom_col_sm_12 flex-box">
            <div class="pricing-box">
                {*<div class="product-label">New!</div>*}
                <div class="box0">
                    <strong>SUMMARY</strong>
                </div>
                {$detail_section_summary_area}
                <div class="product-order-sidebar-ordering">

                    <div class="price ">


                    </div>

                    <span class="btn btn-yellow btn-md btn-block">
                        {$detail_order_button}
                    </span>
                </div>
                <div class="price-additional ">
                    <div class="product-order-sidebar-check-availability">
                        <a href="javascript:history.go(-1)" class="link-single-internal"><b><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back to
                                List</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>