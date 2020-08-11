{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#0071c5'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#ffffff'}
{/if}

<style>
	#{$random_id} {

	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button,
	#{$random_id} .pricing_table_combo a,
	#{$random_id} .pricing_table_combo button,
	#{$random_id} .pricing_table_submit .whmpress_order_button,
	#{$random_id} .pricing_table_submit a,
	#{$random_id} .pricing_table_submit button {
	background: {$primary_color};
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
	background: {$secondary_color};
	color: {$primary_color};
	border: solid 2px {$primary_color};
	transition: 0.2s;
	}


    .whmpress.whmpress_pricing_table.simple-07 {
        box-shadow: none;
        border: solid 1px #C7C7C7;
        border-radius: 4px;
        padding-top: 0;
        margin-top:20px;
        margin-bottom:20px;
    }
	#{$random_id} h2 {
        border-bottom: solid 1px #c7c7c7;
        padding: 15px 0;
        font-size: 18px;
        font-weight: 700;
        color: {$primary_color};
        margin: 0;
    }
    .whmpress.whmpress_pricing_table.simple-07 .pricing_table_detail {
        display: none;
    }
	#{$random_id} .holder.holder1 {
        border-bottom: solid 1px #c7c7c7;
        padding: 38px 0;
        font-size: 34px;
        font-weight: 700;
        color: {$primary_color};
        background-color: #F5F5F5;
    }
	#{$random_id} ul {
        border: none;
    }
	#{$random_id} ul li {
        color: {$primary_color};
        border-bottom-color: #c6c6c6;
        padding-top: 10px;
    }
    .whmpress.whmpress_pricing_table.simple-07 .whmpress.whmpress_order_combo button {
        width: 180px;
        border-radius: 14px;
        color: white;
        border: solid 2px transparent;
    }
	#{$random_id}.featured .holder.holder1 {
        background-color: {$primary_color};
        color: #f5f5f5;
    }
	#{$random_id}.featured{
		transform: scaleY(1.05);
	}

</style>





<div class="whmpress whmpress_pricing_table simple-07 {$featured}" id="{$random_id}">
	<div class="pricing_table_heading">
		<div class="holder">
			<h2><i class="fa {$sub_icon}"></i> {$product_name}</h2>
		</div>
	</div>
	<div class="pricing_table_detail">
		<div class="holder">
			<p>{$product_detail}</p>
		</div>
	</div>
	<div class="pricing_table_price">
		<div class="holder holder1">
			<span class="currency">{$prefix}</span><span class="amount">{$amount}</span><span class="currency">{$suffix}</span>{if $fraction ne ""}<span
				class="decimal">{$decimal}</span><span class="fraction">{$fraction}</span>{/if}<span class="duration">{$duration}</span>

			<!-- price sub text -->
			{if $price_sub_text ne ""}
			<div class="duration">
				{$price_sub_text}
			</div>
			{/if}
			<!-- /price sub text -->

		</div>
	</div>
	{if $product_detail ne "" || $product_tag_line ne ""}
	<div class="pricing_table_detail">
		<div class="holder">
			{if $product_detail ne ""}
			{$product_detail}
			{elseif $product_tag_line ne ""}
			{$product_tag_line}
			{/if}
		</div>
	</div>
	{/if}
	{if $process_description|lower eq "yes"}
	<div class="pricing_table_features">
		<div class="holder">
			<ul>
				{foreach $split_description as $desc}
				<li class="{if $show_description_tooltip eq 'yes' } whmpress_has_tooltip{/if}">
                    <span class="whmpress_description_title">
                        {if $show_description_icon eq 'yes' and $desc.icon_class ne ''}
                            <i class="{$desc.icon_class}"></i>
                        {/if}
						{*
						{if $desc.icon_class ne 'yes' || $desc.icon_class eq ''}
                            <i class="--replace here--"></i>
                        {/if}
						*}

						{$desc.feature_title}
                        {if $show_description_tooltip eq 'yes' and $desc.tooltip_text ne '' }
                            <span class="whmpress_tooltip">{$desc.tooltip_text}</span>
                        {/if}
						{if $desc.feature_value ne "" }: {/if}
                    </span>
					<strong class="whmpress_description_value">{$desc.feature_value}</strong>
				</li>
				{/foreach}
			</ul>
		</div>
	</div>
	{else}
	{$product_description}
	{/if}
	<div class="pricing_table_combo">
		<div class="holder">
			{$product_order_combo}
		</div>
	</div>
	<div class="pricing_table_submit">
		<div class="holder">
			{$product_order_button}
		</div>
	</div>
</div>  <!-- /.price-table -->
