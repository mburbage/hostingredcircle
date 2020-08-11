<style>
    .wpct_comparison_table.first .wpct_tooltip:after {
        border-color: #337ab7 transparent transparent transparent;
    }
</style>
<div class="wpct_comparison_table first wpct_comparison_has_toggle
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