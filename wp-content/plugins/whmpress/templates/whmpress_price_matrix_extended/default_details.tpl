<style>
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
<section id="whcom_product">
    <div class="whcom_product_name"><h1>{$product_name}</h1></div>
    <div class="whcom_row container m-auto whmpress">
        <div class="whcom_col_xl_8 whcom_col_lg_12 whcom_col_sm_12 flex-box">
            <div class="main-content-list">
                <div class="main-content-list">
                    <div class="headline-container">BASIC FEATURES</div>
                    <div class="content-container content-container-list">
                        <ul class="list-unstyled list-items">

                            {foreach $product_title as $index=>$product}
                                {foreach $product_value as $num=>$value}
                                    {if $index eq $num}
                                        <li>
                                            <i class="fa fa-check color-green"></i> <strong>{$product}:</strong> {$value}
                                            {foreach $product_tooptip as $num => $tooltip_text}
                                                {if $tooltip_text ne '' and $index eq $num}
                                                    <span class="whcom_tooltip" style="float: right">
                                    <i class="far fa-question-circle"></i>
                                <span class="whcom_tooltiptext">{$tooltip_text}</span>
                                </span>
                                                {/if}
                                            {/foreach}
                                        </li>
                                    {/if}
                                {/foreach}
                            {/foreach}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="whcom_col_xl_4 whcom_col_sm_12 flex-box">
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
</section>