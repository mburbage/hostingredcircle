<style>
    .wpct_comparison_table.simple-02 .wpct_discounts_container{
        display: none;
    }

    .wpct_comparison_table.simple-02{
        overflow: hidden;
    }

    .wpct_comparison_table.simple-02 .wpct_comparison_table_col .wpct_pricing_table.simple-02{
        text-align: center;
        padding: 10px 8px;
        background: #112b37;
    }
    .wpct_comparison_table.simple-02 .wpct_pricing_table.simple-02 .wpct_heading .wpct_holder h2{
        font-size: 24px;
        line-height: 1.7;
        color: #ffffff;
        font-weight: 300;
    }
    .wpct_comparison_table.simple-02 .wpct_price{
        color: #ffffff;
        background: none;
    }
    .wpct_comparison_table.simple-02 .wpct_price_toggle{
        background: #112b37;
    }
    .wpct_comparison_table.simple-02 .wpct_comparison_table_col .wpct_pricing_table.simple-02 .wpct_heading .wpct_holder:before{
        content: "\f0b1";
        font: normal normal normal 20px/1 FontAwesome;
        color: #ffffff;
        position: relative;
        top: 33px;
        right: 80px;
    }
    .wpct_comparison_table_row.wpct_comparison_table_section_heading{
        background: #112b37;
    }
    .wpct_comparison_table.simple-02 .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li span.wpct_feature_title_text{
        color: #2e4453;
        font-weight: 700;
        padding-left:15px;

    }
    .wpct_comparison_table.simple-02 .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li{
        border-left:1px #D9D9D9 solid;
    }
    .wpct_comparison_table.simple-02 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li:nth-child(odd){
        background: #f9f9f9;
    }
    .wpct_comparison_table.simple-02 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li:nth-child(even){
        background: #ffffff;
    }
    .wpct_comparison_table.simple-02 .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li:nth-child(odd){
        background: #f9f9f9;
    }
    .wpct_comparison_table.simple-02 .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li:nth-child(even){
        background: #ffffff;
    }
    .wpct_comparison_table.simple-02 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit{
        background-color: #f27226;
        border-radius: 27px;
        padding: 10px 60px;
    }
    .wpct_comparison_table.simple-02 .wpct_button .wpct_holder.annually a.wpct_submit-button.wpct_submit{
        background-color: #f27226;
        border-radius: 27px;
        padding: 10px 60px;
    }
    .wpct_comparison_table.simple-02 .wpct_comparison_table_col.wpct_comparison_table_titles_col .wpct_price_toggle input:checked+span{
        background: #f27226;
    }
    .wpct_comparison_table.simple-02 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li i.fa.wpct_icon_yes.fa-check{
        color: #2e4453;
    }
    .wpct_comparison_table.simple-02 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li i.fa.wpct_icon_yes.fa-check{
        color: #2e4453;
    }
    .wpct_comparison_table.simple-02 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li i.fa.wpct_icon_no.fa-close{
        color: #f27226;
    }
    .wpct_comparison_table.simple-02 .wpct_comparison_table_row.wpct_comparison_table_section_content .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles{
        text-align: left;
    }

    @media (max-width: 768px){
        .wpct_comparison_table.simple-02 ul{
            margin: 0;
        }
    }
</style>
<div class="wpct_comparison_table simple-02 wpct_comparison_has_toggle
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

