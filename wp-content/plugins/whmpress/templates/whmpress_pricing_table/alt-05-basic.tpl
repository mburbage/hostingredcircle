{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#4d4e4f'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#f2f2f2'}
{/if}

<style>
	#{$random_id} {
		box-shadow: none;
		background: {$secondary_color};
		padding-top: 0;
		border-radius: 5px;
		border:none;
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
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	}


	#{$random_id} .whmpress-table-box{
		color: #f7f5f2;
		background: {$primary_color};
		border-top-left-radius: 5px;
		border-top-right-radius: 5px;
		padding-top: 2em;
		padding-bottom: 16px;
	}
	.whmpress.whmpress_pricing_table.alt-05 .pricing_table_heading .holder h2{
		font-size: 1.5em;
		line-height: 1.25;
		font-weight: 700;
	}
	.whmpress.whmpress_pricing_table.alt-05 .pricing_table_price .holder{
		font-size: 58px;
		font-weight: 700;
		margin-top: -14px;
		padding-bottom: 35px;
	}
	.whmpress.whmpress_pricing_table.alt-05 .pricing_table_price .holder .currency,
	.whmpress.whmpress_pricing_table.alt-05 .pricing_table_price .holder .decimal,
	.whmpress.whmpress_pricing_table.alt-05 .pricing_table_price .holder .fraction{
		font-size: 35px;
		position: relative;
		top: -17px;
	}
	.whmpress.whmpress_pricing_table.alt-05 .pricing_table_price .holder .duration{
		font-size:18px;
	}
	.whmpress.whmpress_pricing_table.alt-05 .pricing_table_detail .holder{
		margin: 11px;
		padding:0;
		text-align: left;
	}
	.whmpress.whmpress_pricing_table.alt-05 .pricing_table_features .holder ul{
		padding-left: 0;
		padding-right: 0;
		padding-top: 0;
		color: #6d6e70;
		font-weight: bold;
		text-align: left;
	}
	.whmpress.whmpress_pricing_table.alt-05 .pricing_table_features .holder ul li{
		padding: 16px 34px;
		color: #6d6e70;
	}
	#{$random_id}.featured {
		border: 3px solid #f8b760;
		transform: scaleY(1);
	}

	#{$random_id}.featured .popular{
		position: relative;
		top: -5px;
		color: #f8b760;
		font-size: 18px;
	}
	.whmpress.whmpress_pricing_table.alt-05 .popular{
		position: relative;
		top: -12px;
		color: #4d4e4f;
		font-size: 18px;
	}

</style>


<div class="whmpress whmpress_pricing_table alt-05 {$featured}" id="{$random_id}">
	<div class="whmpress-table-box">
		<div class="popular">{$featured_text}</div>
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
</div>  <!-- /.price-table -->