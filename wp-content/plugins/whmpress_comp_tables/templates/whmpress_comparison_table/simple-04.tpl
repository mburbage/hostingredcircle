<style>
    .wpct_comparison_table.simple-04 .wpct_comparison_table_row.wpct_comparison_table_section_content
    .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles{
        text-align: left;
    }
    .wpct_comparison_table.simple-04{
        border: none;
    }
    .wpct_pricing_table.simple-04{
        background: none;
        border: none;
    }
    .wpct_pricing_table.simple-04 .wpct_price{
        background: none;
    }
    .wpct_comparison_table.simple-04 .wpct_discounts_container{
        display: none;
    }
    .wpct_pricing_table.simple-04 .wpct_heading .wpct_holder h2{
        font-size: 26px;
        color: #000000;
    }
    .wpct_comparison_table_row.wpct_comparison_table_section_heading{

        background-color: #139c8e;
        color: #e6e6e6;
    }
    .wpct_comparison_table.simple-04 .wpct_comparison_table_row{
        border-bottom: 0;
    }
    .wpct_pricing_table.simple-04 .wpct_price .wpct_holder.monthly{
        color: #139c8e;
        font-size: 80px;
    }
    .wpct_pricing_table.simple-04 .wpct_price .wpct_holder.monthly span.wpct_period{
        color: #999999;
        font-size: 16px;
        padding-top: 20px;

    }
    .wpct_pricing_table.simple-04 .wpct_price .wpct_holder.annually{
        color: #139c8e;
        font-size: 80px;
    }
    .wpct_pricing_table.simple-04 .wpct_price .wpct_holder.annually span.wpct_period{
        color: #999999;
        font-size: 16px;
        padding-top: 20px;

    }
    .wpct_comparison_table.simple-04 .wpct_comparison_table_row.wpct_comparison_table_section_content
    .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li {
        border-bottom: none;
        padding-left: 30px;
        position: relative;
    }

    .wpct_comparison_table.simple-04 .wpct_comparison_table_row.wpct_comparison_table_section_tables .wpct_comparison_table_col{
        border-right: 0;
    }
    .wpct_comparison_table.simple-04 .wpct_comparison_table_col ul li:nth-child(even) {
        background-color: transparent;
        border-bottom: transparent;
    }
    .wpct_comparison_table.simple-04 .wpct_comparison_table_col ul li:nth-child(odd) {
        background-color: transparent;
        border-bottom: transparent;
    }
    .wpct_comparison_table.simple-04 .wpct_comparison_table_col.wpct_comparison_table_titles_col{
        border-right: 0;
    }
    .wpct_comparison_table.simple-04 .wpct_comparison_table_row.wpct_comparison_table_section_content .wpct_comparison_table_col{
        border-right: 0;
    }
    .wpct_comparison_table.simple-04 .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li span.wpct_feature_title_text:before{
        position: absolute;
        top: 19px;
        left: 10px;
        position: absolute;
        border-width: 4px;
        border-style: solid;
        content: "";
        color: #2ea3f2;
        border-radius: 5px;
    }
    .wpct_comparison_table.simple-04 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit{
        padding: 0 0;
        color: #139c8e;
        text-transform: uppercase;
        font-weight: 400;
        font-size: 15px;
        height: 50px;
        line-height: 50px;
        text-align: center;
        background-color: #ffffff;
        white-space: nowrap;
        border: 3px solid;
        border-radius: 4px;
        width: 100%;
    }
    .wpct_comparison_table.simple-04 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit:hover{
        padding: 0 0;
        border: 2px solid transparent;
        background: #EFEFEF;
    }
    .wpct_comparison_table.simple-04 .wpct_button .wpct_holder.annually a.wpct_submit-button.wpct_submit{
        padding: 0 0;
        color: #139c8e;
        text-transform: uppercase;
        font-weight: 400;
        font-size: 15px;
        height: 50px;
        line-height: 50px;
        text-align: center;
        background-color: #ffffff;
        white-space: nowrap;
        border: 3px solid;
        border-radius: 4px;
        width: 100%;
    }
    .wpct_comparison_table.simple-04 .wpct_button .wpct_holder.annually a.wpct_submit-button.wpct_submit:hover{
        padding: 0 0;
        border: 2px solid transparent;
        background: #EFEFEF;
    }
    .wpct_comparison_table.simple-04 .wpct_button .wpct_holder.annually a.wpct_submit-button.wpct_submit:hover:after {
        content: "\35";
        font: normal normal normal 12px/1 FontAwesome;
        color:#F08275;
        opacity: 1;


</style>
<div class="wpct_comparison_table simple-04 wpct_comparison_has_toggle
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

