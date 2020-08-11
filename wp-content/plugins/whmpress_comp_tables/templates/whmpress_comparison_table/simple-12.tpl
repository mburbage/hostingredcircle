<style>
    .wpct_comparison_table.simple-12 .wpct_heading .wpct_holder h2{
        color: #39f;
        font-size: 20px;
        font-weight: 400;
    }
    .wpct_pricing_table.simple-12 {
        background-color: #f8fbfc;
    }
    .wpct_pricing_table.simple-12 .wpct_price{
        background-color: #f8fbfc;
    }
    .wpct_pricing_table.featured.simple-12{
        background: #fff;
    }
    .wpct_pricing_table.featured.simple-12 .wpct_price{
        background: #fff;
    }
    .wpct_pricing_table.simple-12 .wpct_price .wpct_holder.monthly span.wpct_amount {
        font-weight: 400;
        font-size: 56px;
    }
    .wpct_pricing_table.simple-12 .wpct_price .wpct_holder.annually span.wpct_amount {
        font-weight: 400;
        font-size: 56px;
    }
    .wpct_comparison_table.simple-12 .wpct_comparison_table_row.wpct_comparison_table_section_heading {
        background: #79b600;
    }
    .wpct_comparison_table.simple-12 .wpct_comparison_table_col.wpct_comparison_table_titles_col{
        background: #fff;
    }
    .wpct_comparison_table.simple-12 ul.wpct_comparison_table_feature_values{
        border: 2px solid #c2c2c2;
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
    }
    .wpct_comparison_table.simple-12 ul.wpct_comparison_table_feature_values{
        border: 2px solid #c2c2c2;
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
    }
    .wpct_comparison_table.simple-12 ul.wpct_comparison_table_feature_values.featured{
        border: 2px solid #0e4d81;
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
        box-shadow: 0 0 24px 0 rgba(0,0,0,.45);
        background: #fff;
    }
    .wpct_comparison_table.simple-12 .wpct_comparison_table_row.wpct_comparison_table_section_content{
        background: #f8fbfc;
    }
    .wpct_comparison_table.simple-12 ul.wpct_comparison_table_feature_values li{
        border-bottom: 1px solid #c2c2c2;
        padding: 7px 0;
        line-height: 16px;
    }
    .wpct_comparison_table .wpct_comparison_table_section_content .wpct_comparison_table_feature_values li:nth-child(odd){
        background: transparent;
        padding: 15px 0;
    }
    .wpct_comparison_table .wpct_comparison_table_section_content .wpct_comparison_table_feature_values li:nth-child(even){
        background: transparent;
        padding: 15px 0;
    }
    .wpct_pricing_table.simple-12 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit{
        background-color: #79b600;
        border: 0;
    }
    .wpct_pricing_table.simple-12 .wpct_button .wpct_holder.annually a.wpct_submit-button.wpct_submit{
        background-color: #79b600;
        border: 0;
    }
    .wpct_pricing_table.simple-12 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit:hover{
        background-color: #87c32b;
    }
    .wpct_pricing_table.simple-12 .wpct_button .wpct_holder.annually a.wpct_submit-button.wpct_submit:hover{
        background-color: #87c32b;
    }

</style>
<div class="wpct_comparison_table simple-12 wpct_comparison_has_toggle
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
