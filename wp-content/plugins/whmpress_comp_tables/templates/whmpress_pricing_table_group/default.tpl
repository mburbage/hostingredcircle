<div id="group_{$random}" class="wpct_table_group
{if $group.enable_table_carousel eq '1'} wpct_have_carousel {/if}
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
     data-wpct-hide-mobile="{$group.mobile_breakpoint}">
    <div class="wpct_comparison_table_row">
    </div>
    <div class="wpct_table_group_row wpct_group_carousel">
        {foreach from=$group.plans item=plan}
            <div class="wpct_table_group_col">
                <div class="whmpress whmpress_pricing_table one {if $plan.product_id eq $group.important}featured{/if}">
                    <div class="pricing_table_heading">
                        <div class="holder">
                            <h2>{$plan.name}</h2>
                        </div>
                    </div>
                    <div class="pricing_table_price">
                        <div class="holder">
                            <span class="currency">{$plan.prefix}</span><span class="amount">{$plan.amount}</span>{if $plan.fraction ne ""}
                            <span class="decimal">{$plan.decimal}</span>
                            <span class="fraction">{$plan.fraction}</span>{/if}
                            <span class="duration">{if $plan.duration ne ""}Per {$plan.duration}{else}&nbsp;{/if}</span>
                        </div>
                    </div>
                    <div class="pricing_table_features">
                        <div class="holder">
                            <ul>
                                {foreach from=$plan.description item=desc name=i}
                                    {if $smarty.foreach.i.index == $group.rows_table}{break}{/if}
                                    <li>{$desc}</li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                    <div class="pricing_table_submit">
                        <div class="holder">
                            <a type="button" class="whmpress-btn whmpress_order_button" href="{$plan.order_url}">{$group.button_text}</a>
                        </div>
                    </div>
                </div>  <!-- /.price-table -->
            </div>
        {/foreach}
    </div>
</div>

