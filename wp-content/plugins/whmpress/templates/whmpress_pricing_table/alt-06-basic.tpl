
{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#ddd'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#45B649'}
{/if}

<style>
	#{$random_id} {
		box-shadow: none;
		padding: 0;
		border: 4px solid {$primary_color};
		border-radius: 0;
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_submit button {
		background: #ddd;
	}
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_submit button {
		background: #45B649;
	}
	.whmpress.whmpress_pricing_table.alt-06.featured .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-06.featured .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.alt-06.featured .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.alt-06.featured .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-06.featured .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.alt-06.featured .pricing_table_submit button {
		background: #45B649;
	}



	.whmpress.whmpress_pricing_table.alt-06 {
	}

	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_heading .holder h2 {
		color: #333;
		font-weight: 700;
		font-size: 23px;
		margin: 20px auto -41px 0px;
	}
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_price .holder{
		color: #808080;
		font-size: 38px;
		font-weight: 700;
	}
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_price .holder .duration{
		display: block;
		font-size: 13px;
		font-weight: 300;
		margin-top: -6px;
		border-bottom: 1px solid #eee;
		padding-bottom: 20px;
		width: 50%;
		margin: 0 auto;
	}
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_price .holder .currency{
		font-size: 19px;
		position: relative;
		top: -16px;
		padding-right: 2px;
	}
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_detail .holder{
		font-size: 14px;
		font-weight: 300;
		color: #808080;
	}

	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_features .holder ul{
		border-top: none;
	}
	.whmpress.whmpress_pricing_table.alt-06 .pricing_table_features .holder ul li{
		border: none;
		color: #333333;
	}
	#{$random_id}.featured {
		border: 8px solid {$secondary_color};
		position: relative;
	}

	.whmpress.whmpress_pricing_table.alt-06.featured .pricing_table_price .holder{
		color:{$secondary_color};
	}


	.whmpress.whmpress_pricing_table.alt-06.featured .popular{
		background: #5bc0de;
		color: #fff;
		font-size: 12px;
		font-weight: 400;
		padding: 5px 8px 4px;
		margin-left: auto;
		width: 38%;
		margin-bottom: 2px;
		top: -35px;
		position: relative;
		right: -8px;
	}
	.whmpress.whmpress_pricing_table.alt-06 .popular {
		color:white;
	}
	.whmpress.whmpress_pricing_table.alt-06.featured i.fa.fa-check{
		font-size: 20px;
		text-align: center;
		height: 38px;
		width: 38px;
		border-radius: 50%;
		background: {$secondary_color};
		position: absolute;
		top: 15px;
		left: 15px;
		color: white;
		line-height: 37px;
		display:block;
	}
	.whmpress.whmpress_pricing_table.alt-06 i.fa.fa-check{
		position: absolute;
		display:none;
	}
	.whmpress.whmpress_pricing_table.alt-06.featured {
		transform: scaleY(1);
		position: relative;
		padding-top: 0;
	}
</style>




<div class="whmpress whmpress_pricing_table alt-06 {$featured}" id="{$random_id}">
	<div class="popular">
		{$featured_text}</div>
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
					<span class="whmpress_description_value">{$desc.feature_value}</span>
				</li>
				{/foreach}
			</ul>
		</div>
	</div>
	{else}
	{$product_description}
	{/if}
</div>  <!-- /.price-table -->
