{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#CF9F24'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#31C371'}
{/if}

<style>
	#{$random_id} {
		box-shadow: none;
		border: 1px solid #D3D3D3;
		border-top: 6px solid {$primary_color};
		border-radius: 0;
		margin-bottom: 30px;
	}
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_submit button {
		color: #fff;
		border: none;
		font-size: 16px;
		transition: all .2s linear;
		background: #CF9F24;
		border-radius: 0;
		width: 50%;
		font-weight: 300;
		padding: 6px;
	}
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_submit button {
	background: #B79337;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	}
	.whmpress.whmpress_pricing_table.alt-04.featured .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-04.featured .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.alt-04.featured .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.alt-04.featured .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-04.featured .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.alt-04.featured .pricing_table_submit button{
		background: #31C371;
	}
	.whmpress.whmpress_pricing_table.alt-04.featured .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-04.featured .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.alt-04.featured .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.alt-04.featured .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-04.featured .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.alt-04.featured .pricing_table_submit button {
		background: #299E5D;
	}

	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_heading .holder h2 {
		font-size: 22px;
		font-weight: 400;
		color: #000000;
	}
	.whmpress.whmpress_pricing_table.alt-04 .decimal {
		display: none;
	}
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_detail {
		font-size: 16px;
		font-weight: 400;
		color: #000000;
	}
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_price .holder .amount{
		font-size: 48px;
		font-weight: 400;
	}
	#{$random_id} .pricing_table_price .holder{
		color: {$primary_color};
	}
	#{$random_id} .pricing_table_price .holder .currency{
		position: relative;
		top: -13px;
		font-size: 28px;
	}
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_price .holder .decimal,
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_price .holder .fraction,
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_price .holder .duration{
		position: relative;
		top: -20px;
		font-size: 14px;
	}
	.whmpress.whmpress_pricing_table.alt-04 .pricing_table_features .holder ul{
		border-top:none;
		margin-top: 0;
		padding-top: 0;
	}
	#{$random_id} .pricing_table_features .holder .content-text{
		border-top: 1px solid #cbcbcb;
		width: 86%;
		margin: 24px auto;
		margin-bottom: 4px;
		padding-to
		.whmpress.whmprp: 25px;
		color: {$primary_color};
	}ess_pricing_table.alt-04 .pricing_table_features .holder ul li{
		border:none;
		font-size: 15px;
		font-weight: 300;
		color: #000000;
	}

	#{$random_id}.featured{
		border-top: 6px solid {$secondary_color};
		transform: scaleY(1);
	}
	#{$random_id}.featured .pricing_table_price .holder{
		color: {$secondary_color};
	}
	#{$random_id}.featured .pricing_table_features .holder .content-text{
		color: {$secondary_color};
	}

</style>

<div class="whmpress whmpress_pricing_table alt-04 {$featured}" id="{$random_id}">
	<div class="pricing_table_heading">
		<div class="holder">
			<h2><i class="fa {$sub_icon}"></i> {$product_name}</h2>
		</div>
	</div>
	<div class="pricing_table_detail details">
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
	{if $process_description|lower eq "yes"}
	<div class="pricing_table_features">
		<div class="holder">
			<div class="content-text">Individual Includes</div>
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



