<style>
    .wpct_comparison_table.simple-11 .wpct_discounts_container {
        display: none;
    }
    .wpct_comparison_table.simple-11 .wpct_heading .wpct_holder h2{
        font-size: 17px;
        font-weight: 700;
        color: #1a1a1a;
        font-style: normal;
        text-transform: uppercase;
        padding-bottom: 0;
    }
    .wpct_comparison_table.simple-11 .wpct_price{
        background: none;
    }
    .wpct_comparison_table.simple-11 .wpct_price .wpct_holder.monthly span.wpct_unit{
        position: relative;
        bottom: 25px;
        color: #00B194;
    }
    .wpct_comparison_table.simple-11 .wpct_price .wpct_holder.monthly span.wpct_amount{
        color: #00B194;
    }
    .wpct_comparison_table.simple-11 .wpct_price .wpct_holder.monthly span.wpct_decimal{
        position: relative;
        bottom: 25px;
        color: #00B194;
    }
    .wpct_comparison_table.simple-11 .wpct_price .wpct_holder.monthly span.wpct_fraction{
        position: relative;
        bottom: 25px;
        color: #00B194;
    }
    .wpct_comparison_table.simple-11 .wpct_price .wpct_holder.monthly span.wpct_period {
        color: #00B194;
    }
    .wpct_comparison_table.simple-11 .wpct_price .wpct_holder.annually span.wpct_unit{
        position: relative;
        bottom: 25px;
        color: #00B194;
    }
    .wpct_comparison_table.simple-11 .wpct_price .wpct_holder.annually span.wpct_amount{
        color: #00B194;
    }
    .wpct_comparison_table.simple-11 .wpct_price .wpct_holder.annually span.wpct_decimal{
        position: relative;
        bottom: 25px;
        color: #00B194;
    }
    .wpct_comparison_table.simple-11 .wpct_price .wpct_holder.annually span.wpct_fraction{
        position: relative;
        bottom: 25px;
        color: #00B194;
    }
    .wpct_comparison_table.simple-11 .wpct_price .wpct_holder.annually span.wpct_period {
        color: #00B194;
    }
    .wpct_comparison_table.simple-11 .wpct_comparison_table_row.wpct_comparison_table_section_heading{
        background-color: #00B194;
    }
    .wpct_comparison_table.simple-11 .wpct_comparison_table_col.wpct_comparison_table_titles_col .wpct_price_toggle input:checked+span{
        background: #00B194;
        color: #ffffff;
      }
    .wpct_comparison_table.simple-11 .wpct_comparison_table_row.wpct_comparison_table_section_content .wpct_comparison_table_col.wpct_comparison_table_titles_col{
        background-color: #191717;
        color: #ffffff;
            }
    .wpct_comparison_table.simple-11 .wpct_comparison_table_row.wpct_comparison_table_section_content .wpct_comparison_table_col{
        background-color: #ffffff;
    }
    .wpct_comparison_table.simple-11 .wpct_comparison_table_row.wpct_comparison_table_section_content ul.wpct_comparison_table_feature_values li:nth-child(even){
        background-color: #F2F2F2;
        border: none;
    }
    .wpct_comparison_table.simple-11 .wpct_comparison_table_row.wpct_comparison_table_section_content ul.wpct_comparison_table_feature_values li:nth-child(odd){
        background-color: #ffffff;
    }
    .wpct_comparison_table.simple-11 .wpct_comparison_table_row.wpct_comparison_table_section_content .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li{
        border-bottom: 1px dashed;
    }
    .wpct_comparison_table.simple-11 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit{
        background-color: #00b295;
        border-radius: 2px;
        padding: 10px;
        width: 100%;
        border: none;
    }
    .wpct_comparison_table.simple-11 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit:hover{
        background-color: #008b74;
        border-radius: 2px;
        padding: 10px;
        width: 100%;
        border: none;
    }
    .wpct_comparison_table.simple-11 .wpct_comparison_table_row.wpct_comparison_table_section_content .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li:last-child{
        border-bottom: none;
    }
    .wpct_comparison_table.simple-11 .wpct_comparison_table_row.wpct_comparison_table_section_content{
        background: none;
    }

    @media (max-width: 768px){
        .wpct_comparison_table.simple-11 ul{
            margin: 0;
        }
    }

</style>
<div class="wpct_comparison_table simple-11 wpct_comparison_has_toggle
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
