<style>

	.whmpress.whmpress_pricing_table.minimal-1 {
		box-shadow: none;
		text-align: left;
		margin-top:20px;
	}
	.whmpress.whmpress_pricing_table.minimal-1 .pricing_table_detail {
		display: none;
	}
	.holder.holder1 {
		padding-top: 23px;
		padding-bottom: 23px;
		font-size: 32px;
		color: #222222;
	}
	.whmpress.whmpress_pricing_table.minimal-1 h2 {
		font-size: 12px;
		font-weight: 700;
		color: #222222;
	}
	.whmpress.whmpress_pricing_table.minimal-1 ul {
		border: none;
	}
	.whmpress.whmpress_pricing_table.minimal-1 ul li {
		border: none;
		padding-bottom: 20px;
		color: #222222;
	}
	.whmpress.whmpress_pricing_table.minimal-1 .whmpress.whmpress_order_combo button {
		color: #a9a9a9;
		background-color: transparent;
		text-decoration: underline;
		font-size: 12px;
		font-weight: 700;
		margin-top: -17px;
		text-align: left;
	}

</style>
<div class="whmpress whmpress_pricing_table minimal-1 {$featured}">
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
	<div class="pricing_table_features">
		<div class="holder">
			<ul>
				{foreach $split_description as $desc}
				<li><span class="whmpress_description_title">{$desc.feature_title}

 </span><span class="whmpress_description_value">{$desc.feature_value}</span></li>
				{/foreach}
			</ul>
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
</div>  <!-- /.price-table -->
