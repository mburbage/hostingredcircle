<style>
    .wpct_comparison_table.simple-15 .wpct_heading .wpct_holder h2{
        color: #fff;
        font-size: 24px;
        font-weight: 400;
    }
    .wpct_pricing_table.simple-15{
        background-color: #48545C;
    }

    .wpct_pricing_table.simple-15 .wpct_price{
        background-color: #48545C;
    }
    .wpct_pricing_table.featured.simple-15{
        background: #48545C;
    }
    .wpct_pricing_table.featured.simple-15 .wpct_price{
        background: #48545C;
    }
    .wpct_pricing_table.simple-15 .wpct_price .wpct_holder.monthly {
        font-weight: 500;
        font-size: 92px;
        color:#fff;
    }
    .wpct_pricing_table.simple-15 .wpct_price .wpct_holder.annually {
        font-weight: 400;
        font-size: 92px;
        color: #ffffff;
    }
    .wpct_comparison_table.simple-15 .wpct_comparison_table_row.wpct_comparison_table_section_heading {
        background: #48545C;
    }
    .wpct_comparison_table.simple-15 ul.wpct_comparison_table_feature_titles li{
        border-bottom-color: #48545C;
        background: #48545C;
        text-align: center;
    }

    .wpct_comparison_table.simple-15 .wpct_comparison_table_col.wpct_comparison_table_titles_col{
        background: #48545C;
    }
    .wpct_comparison_table.simple-15 ul.wpct_comparison_table_feature_values{
        background: #48545C;
        color: #B7BDC0;
    }
    .wpct_comparison_table.simple-15 ul.wpct_comparison_table_feature_values{
        background: #48545C;
        color:#B7BDC0;
    }
    .wpct_comparison_table.simple-15 ul.wpct_comparison_table_feature_values.featured{
        background: #48545C;
        color:#B7BDC0;
    }
    .wpct_comparison_table.simple-15 ul.wpct_comparison_table_feature_values.featured:hover{
        background: #48545C;
        color:#fff;
    }
    .wpct_comparison_table.simple-15 .wpct_comparison_table_row.wpct_comparison_table_section_content{
        background: #48545C;
        color:#B7BDC0;
    }
    .wpct_comparison_table.simple-15 .wpct_comparison_table_row.wpct_comparison_table_section_content:hover{
        background: #48545C;
        color:#fff;
    }

    .wpct_comparison_table.simple-15 ul.wpct_comparison_table_feature_values li{
        border-bottom: 1px solid #48545C;
        padding: 7px 0;
        line-height: 16px;
    }
    .wpct_comparison_table .wpct_comparison_table_section_content .wpct_comparison_table_feature_values li:nth-child(odd){
        background: #48545C;
        padding: 15px 0;
        border-bottom-color: #48545C;
    }
    .wpct_comparison_table.simple-15 ul.wpct_comparison_table_feature_values:hover{
        color:#fff;
    }
    .wpct_comparison_table .wpct_comparison_table_section_content .wpct_comparison_table_feature_values li:nth-child(even){
        background: #48545C;
        padding: 15px 0;
        border-bottom-color: #48545C;
    }
    .wpct_pricing_table.simple-15 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit{
        border-radius: 50px;
        background-color: #82b33f;
        font-size: 18px;
        border: 0;
        padding: 10px 30px;
    }
    .wpct_pricing_table.simple-15 .wpct_button .wpct_holder.annually a.wpct_submit-button.wpct_submit{
        border-radius: 50px;
        background-color: #82b33f;
        font-size: 18px;
        border: 0;
        padding: 10px 30px;
    }
    .wpct_pricing_table.simple-15{
        border: 0;
    }
    .wpct_comparison_table .wpct_comparison_table_col{
        padding:0;
        background: #48545C;
    }

</style>
<div class="wpct_comparison_table simple-15 wpct_comparison_has_toggle
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
