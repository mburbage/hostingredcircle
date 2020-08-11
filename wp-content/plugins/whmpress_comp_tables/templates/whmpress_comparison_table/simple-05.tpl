<style>

    .wpct_comparison_table.simple-05 .wpct_discounts_container{
        display: none;
    }

    .wpct_comparison_table.simple-05 .wpct_heading .wpct_holder h2{
        background-color: #0e6de2;
        color: #fff;
        padding: 20px;
        text-align: center;
        font-size: 30px;
        font-weight: 300;
        margin-bottom: 44px;
        border-radius: 5px 5px 0 0;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_row.wpct_comparison_table_section_tables .wpct_comparison_table_col{
        border: none;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_row.wpct_comparison_table_section_tables .wpct_comparison_table_col{
        border: none;
    }

    .wpct_comparison_table_row.wpct_comparison_table_section_tables .wpct_comparison_table_col .wpct_pricing_table.simple-05 .wpct_price .wpct_holder.monthly .wpct_unit {
        font-size: 40px;
        font-weight: 600;
        color: #172b5c;
        padding-right: 9px;
        position: relative;
        bottom: 44px;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_col .wpct_pricing_table.simple-05  .wpct_price .wpct_holder.monthly span.wpct_amount{
        font-size: 100px;
        color: #172b5c;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_col .wpct_pricing_table.simple-05  .wpct_price .wpct_holder.monthly span.wpct_decimal{
        font-size: 40px;
        color: #172b5c;
        font-weight: 600;
        position: relative;
        bottom: 44px;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_col .wpct_pricing_table.simple-05  .wpct_price .wpct_holder.monthly span.wpct_fraction{
        font-size: 40px;
        color: #172b5c;
        font-weight: 600;
        position: relative;
        bottom: 44px;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_col .wpct_pricing_table.simple-05  .wpct_price .wpct_holder.monthly span.wpct_period{
        color: #172b5c;
    }
    .wpct_comparison_table_row.wpct_comparison_table_section_tables .wpct_comparison_table_col .wpct_pricing_table.simple-05 .wpct_price .wpct_holder.annually .wpct_unit {
        font-size: 40px;
        font-weight: 600;
        color: #172b5c;
        padding-right: 9px;
        position: relative;
        bottom: 44px;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_col .wpct_pricing_table.simple-05  .wpct_price .wpct_holder.annually span.wpct_amount{
        font-size: 100px;
        color: #172b5c;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_col .wpct_pricing_table.simple-05  .wpct_price .wpct_holder.annually span.wpct_decimal{
        font-size: 40px;
        color: #172b5c;
        font-weight: 600;
        position: relative;
        bottom: 44px;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_col .wpct_pricing_table.simple-05  .wpct_price .wpct_holder.annually span.wpct_fraction{
        font-size: 40px;
        color: #172b5c;
        font-weight: 600;
        position: relative;
        bottom: 44px;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_col .wpct_pricing_table.simple-05  .wpct_price .wpct_holder.annually span.wpct_period{
        color: #172b5c;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_row.wpct_comparison_table_section_content .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li{
        border: none;
        text-align: center
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li{
        border: none;
        background: none;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_col.wpct_comparison_table_titles_col{
        border-right: none;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_row.wpct_comparison_table_section_content .wpct_comparison_table_col{
        border-right: none;
    }
    .wpct_pricing_table.simple-05 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit{
        padding: 0 64px;
        color: #000000;
        border-radius: 4px;
        text-transform: uppercase;
        text-decoration: none;
        font-weight: 400;
        font-size: 15px;
        height: 50px;
        line-height: 50px;
        text-align: center;
        background-color: #ffd24d;
        white-space: nowrap;
        border: 0;
    }
    .wpct_pricing_table.simple-05 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit:hover{

        background-color: #e2bc4b;

    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_col.wpct_comparison_table_titles_col{
        border-right: none;
    }
    .wpct_comparison_table.simple-05 .wpct_comparison_table_row.wpct_comparison_table_section_content .wpct_comparison_table_col{
        border-right: none;
    }
    .wpct_pricing_table.simple-05 .wpct_button .wpct_holder.annually a.wpct_submit-button.wpct_submit{
        padding: 0 64px;
        color: #000000;
        border-radius: 4px;
        text-transform: uppercase;
        text-decoration: none;
        font-weight: 400;
        font-size: 15px;
        height: 50px;
        line-height: 50px;
        text-align: center;
        background-color: #ffd24d;
        white-space: nowrap;
        border: 0;
    }
    .wpct_pricing_table.simple-05 .wpct_button .wpct_holder.annually a.wpct_submit-button.wpct_submit:hover{
        background-color: #e2bc4b;
    }
    .wpct_comparison_table_row.wpct_comparison_table_section_heading{
        background-color: #0e6de2;
    }
</style>
<div class="wpct_comparison_table simple-05 wpct_comparison_has_toggle
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

