<style>
	.whmpress.whmpress_pricing_table.simple-10 {
		box-shadow: none;
		border: solid 3px #EDEDEE;
		border-radius: 0;
		padding-top: 0;
		padding-bottom: 0;
		margin-bottom:20px;
	}
	.whmpress.whmpress_pricing_table.simple-10 .pricing_table_heading .holder h2 {
		font-size: 27px;
		color: white;
		padding-top: 12px;
		font-weight: 400;
		margin-bottom: 0;
	}
	.whmpress.whmpress_pricing_table.simple-10 .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.simple-10 .pricing_table_detail .holder {
		font-size: 14px;
		color: white;
		padding-top: 0px;
	}
	.whmpress_pricing_table .pricing_table_detail {
		padding-top: 6px;
	}
	.whmpress.whmpress_pricing_table.simple-10 .main {
		background: #36d7ac;
		border-bottom: solid 1px #41b91c;
	}
	.whmpress.whmpress_pricing_table.simple-10 .pricing_table_price .holder .currency {
		font-size: 27px;
		color: #B7C39E;
		padding-right: 2px;
		position: relative;
		bottom: 4px;
	}
	.whmpress.whmpress_pricing_table.simple-10 .pricing_table_price .holder .amount {
		font-size: 50px;
		font-weight: 500;
		color: #B4C39D;
	}
	.whmpress.whmpress_pricing_table.simple-10 .pricing_table_price .holder .decimal {
		font-size: 24px;
		color: #B1C39C;
		position: relative;
		bottom: 6px;
		padding-left: 1px;
	}
	.whmpress.whmpress_pricing_table.simple-10 .pricing_table_price .holder .fraction {
		font-size: 28px;
		color: #B1C39C;
		position: relative;
		bottom: 5px;
		padding-left: 1px;
	}
	.whmpress.whmpress_pricing_table.simple-10 .pricing_table_price .holder .duration {
		display: block;
		margin-top: -10px;
		font-size: 18px;
		color: #B1C39C;
	}
	.whmpress.whmpress_pricing_table.simple-10 .pricing_table_price {
		background-color: #FAFFF2;
		border-bottom: solid 1px #F4FAE7;
		padding-bottom: 12px;
	}
	.whmpress.whmpress_pricing_table.simple-10 .pricing_table_features .holder ul {
		border: none;
		padding-top: 0;
	}
	.whmpress.whmpress_pricing_table.simple-10 .pricing_table_features .holder ul li {
		font-size: 14px;
		text-align: left;
		width: 302px;
		margin-left: -16px;
		padding-left: 15px;
		border-bottom-color: #F4FAE7;
		padding-top: 8px;
		padding-bottom: 8px;
	}
	.whmpress.whmpress_pricing_table.simple-10 .whmpress.whmpress_order_combo button {
		width: 92px;
		max-width: none;
		background-color: #ECC620;
		margin-bottom: 6px;
	}
	.whmpress.whmpress_pricing_table.simple-10 .whmpress.whmpress_order_combo button:hover {
		background-color: #cfa500;
		transition: 0s;
	}
	.whmpress.whmpress_pricing_table.simple-10:hover {
		border: 3px solid #36d7ac;
	}
	.whmpress.whmpress_pricing_table.simple-10:hover .pricing_table_price .holder .currency, .whmpress.whmpress_pricing_table.simple-10:hover .pricing_table_price .holder .amount, .whmpress.whmpress_pricing_table.simple-10:hover .pricing_table_price .holder .decimal, .whmpress.whmpress_pricing_table.simple-10:hover .pricing_table_price .holder .fraction, .whmpress.whmpress_pricing_table.simple-10:hover .pricing_table_price .holder .duration {
		color: #36d7ac;
	}
	.whmpress.whmpress_pricing_table.simple-10.featured {
		box-shadow: 8px 6px 6px 0 #DAF7EE;
		border: 3px solid #36d7ac;
	}
	.whmpress.whmpress_pricing_table.simple-10.featured .pricing_table_price .holder .currency, .whmpress.whmpress_pricing_table.simple-10.featured .pricing_table_price .holder .amount, .whmpress.whmpress_pricing_table.simple-10.featured .pricing_table_price .holder .decimal, .whmpress.whmpress_pricing_table.simple-10.featured .pricing_table_price .holder .fraction, .whmpress.whmpress_pricing_table.simple-10.featured .pricing_table_price .holder .duration {
		color: #36d7ac;
	}

</style>
<div class="whmpress whmpress_pricing_table simple-10 {$featured}">
	<div class="main">
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
