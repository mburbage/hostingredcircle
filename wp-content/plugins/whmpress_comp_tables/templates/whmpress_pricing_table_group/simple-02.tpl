<div id="group_{$random}" class="wpct_table_group simple-02
{if $group.enable_table_carousel eq "1"} wpct_have_carousel {/if}
{if $group.enable_table_dots eq "1"} wpct_have_dots {/if}
{if $group.plans|count eq 1}one_col
{elseif $group.plans|count eq 2}two_cols
{elseif $group.plans|count eq 3}three_cols
{elseif $group.plans|count eq 4}four_cols
{/if}"
     data-wpct-hide-mobile="{$group.mobile_breakpoint}">
    <div class="wpct_comparison_table_row">
        <h2 class="wpct_group_title">{$group.name}</h2>
    </div>
    <div class="wpct_table_group_row wpct_group_carousel" >
        {foreach from=$group.plans item=plan}
        <div class="wpct_table_group_col"
             data-plan-price="{$plan.prefix}{$plan.amount}{if $plan.fraction ne ""}{$plan.decimal}{$plan.fraction}{/if}"
        >
			<div class="whmpress whmpress_pricing_table simple-02 {if $plan.product_id eq $group.important}featured{/if}">
                <div class="pricing_table_heading">
                    <div class="holder">
                        <strong>{$plan.name}</strong>
                    </div>
                </div>
                <div class="pricing_table_price">
                    <div class="holder">
						<span class="currency">{$plan.prefix}</span><span class="amount">{$plan.amount}</span>{if $plan.fraction ne ""}<span class="decimal">{$plan.decimal}</span><span class="fraction">{$plan.fraction}</span>{/if}<span class="duration">/{$plan.duration}</span>
                    </div>
                </div>
				{if $plan.cdescription ne ""}
                    <div class="pricing_table_detail">
                        <div class="holder">
							{$plan.cdescription}
                        </div>
                    </div>
				{/if}
                <div class="pricing_table_features">
                    <div class="holder">
                        <div class="whmpress whmpress_description">
                            <ul>
                                {foreach from=$plan.description item=desc name=i}
                                {if $smarty.foreach.i.index == $group.rows_table}{break}{/if}
                                <li>{$desc}</li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="pricing_table_submit">
                    <div class="holder">
                        <button type="button" class="whmpress-btn whmpress_order_button" onclick="location.href='{$plan.order_url}';">{$group.button_text}</button>
                    </div>
                    <br>
                </div>
            </div>  <!-- /.price-table -->
        </div>
        {/foreach}
    </div>
</div>