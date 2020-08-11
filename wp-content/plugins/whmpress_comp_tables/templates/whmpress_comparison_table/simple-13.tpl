<style>
    .wpct_comparison_table.simple-13 .wpct_heading .wpct_holder h2{
        color: #5d5d5d;
        font-size: 28px;
        font-weight: 300;
    }
    .wpct_pricing_table.simple-13{
        background-color: #fff;
    }

    .wpct_pricing_table.simple-13 .wpct_price{
        background-color: #fff;
    }
    .wpct_pricing_table.featured.simple-13{
        background: #fff;
    }
    .wpct_pricing_table.featured.simple-13 .wpct_price{
        background: #fff;
    }
    .wpct_pricing_table.simple-13 .wpct_price .wpct_holder.monthly span.wpct_amount {
        font-weight: 400;
        font-size: 56px;
    }
    .wpct_pricing_table.simple-13 .wpct_price .wpct_holder.annually span.wpct_amount {
        font-weight: 400;
        font-size: 56px;
    }
    .wpct_comparison_table.simple-13 .wpct_comparison_table_row.wpct_comparison_table_section_heading {
        background: #75B42D;
    }
    .wpct_comparison_table.simple-13 ul.wpct_comparison_table_feature_titles li{
        border-bottom-color: #f6f4f4;
    }

    .wpct_comparison_table.simple-13 .wpct_comparison_table_col.wpct_comparison_table_titles_col{
        background: #fff;
    }
    .wpct_comparison_table.simple-13 ul.wpct_comparison_table_feature_values{
        background: #fff;
    }
    .wpct_comparison_table.simple-13 ul.wpct_comparison_table_feature_values{
        background: #fff;
    }
    .wpct_comparison_table.simple-13 ul.wpct_comparison_table_feature_values.featured{
        background: #fff;
    }
    .wpct_comparison_table.simple-13 .wpct_comparison_table_row.wpct_comparison_table_section_content{
        background: #fff;
    }
    .wpct_comparison_table.simple-13 ul.wpct_comparison_table_feature_values li{
        border-bottom: 1px solid #f6f1f1;
        padding: 7px 0;
        line-height: 16px;
    }
    .wpct_comparison_table .wpct_comparison_table_section_content .wpct_comparison_table_feature_values li:nth-child(odd){
        background: transparent;
        padding: 15px 0;
        border-bottom-color: #f6f4f4;
    }
    .wpct_comparison_table .wpct_comparison_table_section_content .wpct_comparison_table_feature_values li:nth-child(even){
        background: transparent;
        padding: 15px 0;
        border-bottom-color: #f6f4f4;
    }
    .wpct_pricing_table.simple-13 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit{
        border-radius: 50px;
        text-align: center;
        color: #fff;
        font-weight: 700;
        transition: all .2s ease-in-out;
        max-width: 230px;
        padding: 14px 0;
        width: 100%;
        display: block;
        margin: 12px auto 0;
        background: #7180e4;
        border:0;
    }
    .wpct_pricing_table.simple-13 .wpct_button .wpct_holder.annually a.wpct_submit-button.wpct_submit{
        border-radius: 50px;
        text-align: center;
        color: #fff;
        font-weight: 700;
        transition: all .2s ease-in-out;
        max-width: 230px;
        padding: 14px 0;
        width: 100%;
        display: block;
        margin: 12px auto 0;
        background: #3f52d5;
        border:0;
    }
    .wpct_pricing_table.simple-13 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit:hover{
        border-radius: 50px;
        text-align: center;
        color: #fff;
        font-weight: 700;
        transition: all .2s ease-in-out;
        max-width: 230px;
        padding: 14px 0;
        width: 100%;
        display: block;
        margin: 12px auto 0;
        background: #7180e4;
        border:0;
    }
    .wpct_pricing_table.simple-13 .wpct_button .wpct_holder.annually a.wpct_submit-button.wpct_submit:hover{
        border-radius: 50px;
        text-align: center;
        color: #fff;
        font-weight: 700;
        transition: all .2s ease-in-out;
        max-width: 230px;
        padding: 14px 0;
        width: 100%;
        display: block;
        margin: 12px auto 0;
        background: #3f52d5;
        border:0;
    }
    .wpct_pricing_table.simple-13{
        border: 0;
    }

</style>
<div class="wpct_comparison_table simple-13 wpct_comparison_has_toggle
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
