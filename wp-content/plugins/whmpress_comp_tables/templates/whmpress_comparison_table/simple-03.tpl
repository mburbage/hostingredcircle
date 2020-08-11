<style>

    .wpct_comparison_table.simple-03 .wpct_discounts_container{
        display: none;
    }
    .wpct_comparison_table.simple-03{
        border: none;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_col .wpct_pricing_table.simple-03 .wpct_heading .wpct_holder h2 {
        font-size: 28px;
        font-weight: 900;
        color: #303326;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_row.wpct_comparison_table_section_tables .wpct_comparison_table_col{
        border-right: 0;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_col .wpct_pricing_table.simple-03 .wpct_holder.monthly{
        color: #303326;
        font-size: 18px;
        font-weight: bold;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_col .wpct_pricing_table.simple-03 .wpct_holder.annually{
        color: #303326;
        font-size: 18px;
        font-weight: bold;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_col .wpct_pricing_table.simple-03 .wpct_holder.monthly span.wpct_period{
        font-size: 14px;
        color: #7E8271;
        font-weight: 900;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_col .wpct_pricing_table.simple-03 .wpct_holder.annually span.wpct_period{
        font-size: 14px;
        color: #7E8271;
        font-weight: 900;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_col .wpct_pricing_table.simple-03 .wpct_holder.annually{
        color: #303326;
        font-size: 18px;
        font-weight: bold;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_row.wpct_comparison_table_section_tables .wpct_comparison_table_col{
        border-right: 0;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_row.wpct_comparison_table_section_tables .wpct_comparison_table_col .wpct_pricing_table.simple-03 .wpct_heading{
        border-bottom: 1px solid;
        margin-bottom: 10px;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_row.wpct_comparison_table_section_tables .wpct_comparison_table_col .wpct_pricing_table.simple-03 .wpct_holder{
        margin-bottom: 10px;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_row.wpct_comparison_table_section_heading{
        background: #ffffff;
        color: black;
        text-transform: uppercase;
        padding: 15px;
        font-size: 22px;
        font-weight: bold;
        justify-content: flex-start;
        text-indent: -11px;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li:nth-child(odd){
        background-color: #ededed;
        border: none;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles  li:nth-child(odd){
        background-color: #ededed;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li:nth-child(even){
        background-color: #ffffff;
        border: none;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_row.wpct_comparison_table_section_content .wpct_comparison_table_col.wpct_comparison_table_titles_col{
        border: none;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_row.wpct_comparison_table_section_content .wpct_comparison_table_col{
        border: none;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_row.wpct_comparison_table_section_content .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li {
        border-bottom: none;
        padding-left: 10px;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_row.wpct_comparison_table_section_summary .wpct_comparison_table_col .wpct_button .wpct_submit-button{
        position: relative;
        cursor: pointer;
        padding: 0 40px;
        color: #fff;
        border-radius: 10px 35px 35px 10px;
        text-transform: uppercase;
        font-size: 15px;
        line-height: 43px;
        background-color: #B6D65A;
        border: 4px solid #f1f1f0;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_row.wpct_comparison_table_section_summary .wpct_comparison_table_col .wpct_button .wpct_submit-button:hover{
        background-color: #FFAA40;
    }
    .wpct_comparison_table.simple-03 .wpct_comparison_table_col{
        background: none;
    }
    @media (max-width: 768px){
        .wpct_comparison_table.simple-03 ul{
            margin: 0;
        }
    }

</style>
<div class="wpct_comparison_table simple-03 wpct_comparison_has_toggle
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

