<style>
    .wpct_comparison_table.simple-01 .wpct_heading .wpct_holder h2 {
        background: #631d16;
        margin-bottom: 0px;
        color: #fff;
        padding: 20px 30px;
        font-size: 17px;
        text-transform: uppercase;
        font-weight: normal;
    }
    .wpct_comparison_table.simple-01 .wpct_pricing_table{
        padding:0;
    }

    .wpct_comparison_table_row.wpct_comparison_table_section_tables .wpct_price {
        display: block;
        padding: 35px 39px 28px 39px;
        margin:0;
        border: 1px solid #e2dddd;
    }

    .wpct_comparison_table.simple-01 .wpct_price .wpct_holder.monthly{
        color: #100f0d;
        font-size: 34px;
        font-weight: normal;
        margin-bottom: 0;
    }

    .wpct_comparison_table.simple-01 .wpct_price .wpct_holder.monthly span.wpct_period{
        color: #a79a98;
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 0;
    }
    .wpct_comparison_table.simple-01 .wpct_price .wpct_holder.monthly span.wpct_unit{
        color: #aea7a6;
        font-size: 30px;
        position: relative;
        top: -12px;
        left: -2px;
    }
    .wpct_comparison_table.simple-01 .wpct_discounts_container {
        display: none;
    }
    .wpct_comparison_table.simple-01 .wpct_price .wpct_holder.annually{
        color: #100f0d;
        font-size: 34px;
        font-weight: normal;
        margin-bottom: 0;
    }


    .wpct_comparison_table.simple-01 .wpct_price .wpct_holder.annually span.wpct_period{
        color: #a79a98;
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 0;
    }
    .wpct_comparison_table.simple-01 .wpct_price .wpct_holder.annually span.wpct_unit{
        color: #aea7a6;
        font-size: 30px;
        position: relative;
        top: -12px;
        left: -2px;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_row .wpct_comparison_table_col {
        border:none;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_row.wpct_comparison_table_section_heading{
        background: #631D16;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li{

        text-align: center;
        color: #585c61;
        font-size: 12px;
        padding: 12px 20px;
        border-left: 1px solid #e2dddd;
        background: #fff;
        border-bottom: 1px dashed;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li{
        padding: 0px;
        text-align: center;
        color: #585c61;
        font-size: 12px;
        padding: 12px 20px;
        border-left: 1px solid #e2dddd;
        background: #fff;
    }
    .wpct_comparison_table.simple-01 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit{
        width: 140px;
        height: 39px;
        display: block;
        background: #e94d3a;
        color: #fff;
        line-height: 39px;
        border-radius: 4px;
        margin: auto;
        text-transform: uppercase;
    }
    .wpct_comparison_table.simple-01 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit:hover{
        background: #f4260c;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li i.fa.wpct_icon_yes.fa-check{
        color: #ffffff;
        background-color: #F08275;
        padding: 3px 3px;
        border-radius: 15px;
        font-size: 12px;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li i.fa.wpct_icon_no.fa-close{
        color: #ffffff;
        background-color: #F08275;
        padding: 3px 4px;
        border-radius: 20px;
        font-size: 12px;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li span.wpct_feature_title_text:before{
        content: "\f00c";
        font: normal normal normal 12px/1 FontAwesome;
        color:#F08275;
        margin-right: 2px;
    }

    @media (max-width: 768px){
        .wpct_comparison_table.simple-01 ul{
            margin: 0;
        }
    }
</style>
<div class="wpct_comparison_table simple-01 wpct_comparison_has_toggle
{if $group.plans|count eq 1}one_col
{elseif $group.plans|count eq 2}two_cols
{elseif $group.plans|count eq 3}three_cols
{elseif $group.plans|count eq 4}four_cols
{elseif $group.plans|count eq 5}five_cols
{elseif $group.plans|count eq 6}six_cols
{elseif $group.plans|count eq 7}seven_cols
{elseif $group.plans|count eq 8}eight_cols
{elseif $group.plans|count eq 9}nine_cols
{elseif $group.plans|count eq 10}ten_cols
{elseif $group.plans|count eq 11}eleven_cols
{/if}"
     id="wpct_comparison_table_{$random}"
     data-wpct-hide-mobile="{$group.mobile_breakpoint}">
	{$group_new.top}
	{$group_new.middle}
	{$group_new.bottom}
</div>

