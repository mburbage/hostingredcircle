{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#1A8CFF'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#06c'}
{/if}

<style>
	#{$random_id} {
		border-radius: 0;
		box-shadow: none;
		background-color: {$primary_color};
		color: white;
		padding-top: 0px;
		padding-bottom: 0;
		margin-bottom: 30px;
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
	background: white;
	border-radius: 30px;
	color: #1A8CFF;
	margin-top: 15px;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
		transition: all 0.2s ease-in-out;
		box-shadow: 0 8px 34px 0 rgba(0,0,0,0.3);
		transform: scale(1.05);
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	}



	#{$random_id} .pricing_table_heading .holder h2 {
		background: {$secondary_color};
		margin: -6px;
		font-size: 21px;
		padding: 13px 0;
	}

	.whmpress.whmpress_pricing_table.twelve .pricing_table_price .amount {
		font-weight: 600;
		font-size: 72px;
	}

	.whmpress.whmpress_pricing_table.twelve .pricing_table_price .currency, .whmpress.whmpress_pricing_table.twelve .pricing_table_price .decimal,
	.whmpress.whmpress_pricing_table.twelve .pricing_table_price .fraction, .whmpress.whmpress_pricing_table.twelve .pricing_table_price .duration{
		font-size: 24px;
		letter-spacing: -1px;
		font-weight: 600;
		line-height: 0;
		padding-right: 3px;
		top: -31px;
		position: relative;
	}
    .whmpress.whmpress_pricing_table.twelve .pricing_table_features .holder ul {
        border: none;
        padding: 0;
    }
    .whmpress.whmpress_pricing_table.twelve .pricing_table_features .holder ul li {
        border: none;
        padding: 2px 0;
        color: white;
    }

	.whmpress.whmpress_pricing_table.twelve.featured {
		transform: scaleY(1.05);
	}
</style>




<div class="whmpress whmpress_pricing_table twelve {$featured}" id="{$random_id}">
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
		<div class="holder">
			<span class="currency">{$prefix}</span><span class="amount">{$amount}</span>{if $fraction ne ""}<span
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
	<div class="pricing_table_detail details">
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






