<style>

	.whmpress.whmpress_pricing_table.simple-11 {
		box-shadow: none;
		border: solid 1px #f9f9f9;
		border-radius: 3px;
		padding-top: 0;
		background-color: #f9f9f9;
		padding-bottom: 0;
		margin-top:20px;
		margin-bottom:20px;
	}
	.whmpress.whmpress_pricing_table.simple-11 .pricing_table_heading .holder h2 {
		font-size: 30px;
		font-weight: 600;
		color: black;
		padding-top: 16px;
		padding-bottom: 18px;
		border-bottom: solid 1px #E5E4E4;
	}
	.whmpress.whmpress_pricing_table.simple-11 .pricing_table_detail {
		display: none;
	}
	.whmpress.whmpress_pricing_table.simple-11 .pricing_table_price .holder.holder1 {
		padding: 26px 0;
		border-bottom: solid 1px #E4E3E3;
	}
	.whmpress.whmpress_pricing_table.simple-11 .pricing_table_price .holder.holder1 .decimal, .whmpress.whmpress_pricing_table.simple-11 .pricing_table_price .holder.holder1 .fraction {
		display: none;
	}
	.whmpress.whmpress_pricing_table.simple-11 .pricing_table_features .holder ul {
		border: none;
		padding-top: 2px;
	}
	.whmpress.whmpress_pricing_table.simple-11 .pricing_table_features .holder ul li {
		border-bottom-color: #E5E4E4;
		color: #727272;
		font-size: 14px;
		font-weight: 400;
		width: 242px;
		margin: auto;
		padding-bottom: 13px;
	}
	.whmpress.whmpress_pricing_table.simple-11 .pricing_table_combo button {
		width: 150px;
		background-color: #119ee7;
		font-size: 14px;
		font-weight: 400;
	}
	.whmpress.whmpress_pricing_table.simple-11:hover {
		background-color: #119ee7;
		transition: 1.0s;
	}
	.whmpress.whmpress_pricing_table.simple-11 .pricing_table_price .holder.holder1 .currency {
		font-size: 22px;
		color: black;
		font-weight: 700;
		padding-right: 2px;
		bottom: 13px;
		position: relative;
	}
	.whmpress.whmpress_pricing_table.simple-11 .pricing_table_price .holder.holder1 .amount {
		font-size: 45px;
		font-weight: 700;
		color: black;
	}
	.whmpress.whmpress_pricing_table.simple-11 .pricing_table_price .holder.holder1 .duration {
		font-size: 16px;
		color: black;
		font-weight: 500;
	}
	.whmpress.whmpress_pricing_table.simple-11:hover .pricing_table_heading .holder h2 {
		color: #F9F9F9;
		border-bottom-color: #62AEE4;
	}
	.whmpress.whmpress_pricing_table.simple-11:hover .pricing_table_price .holder.holder1 {
		border-bottom-color: #62AEE4;
	}
	.whmpress.whmpress_pricing_table.simple-11:hover .pricing_table_features .holder ul li {
		color: #f9f9f9;
		border-bottom-color: #6FA9E2;
	}
	.whmpress.whmpress_pricing_table.simple-11:hover .pricing_table_combo button {
		background-color: white;
		color: #119ee7;
	}
	.whmpress.whmpress_pricing_table.simple-11:hover .pricing_table_price .holder .currency {
		color: white;
	}
	.whmpress.whmpress_pricing_table.simple-11:hover .pricing_table_price .holder .amount {
		color: white;
	}
	.whmpress.whmpress_pricing_table.simple-11:hover .pricing_table_price .holder .decimal {
		color: white;
	}
	.whmpress.whmpress_pricing_table.simple-11:hover .pricing_table_price .holder .duration {
		color: white;
	}

</style>
<div class="whmpress whmpress_pricing_table simple-11 {$featured}">
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
	{if $process_description|lower eq "yes"}
	<div class="pricing_table_features">
		<div class="holder">
			<ul>
				{foreach $split_description as $desc}
				<li class="{if {$desc.tooltip_text} ne '' }whmpress_has_tooltip{/if}">
                    <span class="whmpress_description_title">
                        {if {$desc.icon_class} ne '' }
                            <i class="{$desc.icon_class}"></i>
                        {/if}
						{$desc.feature_title}
                        {if {$desc.tooltip_text} ne '' }
                            <span class="whmpress_tooltip">{$desc.tooltip_text}</span>
                        {/if}
						{if {$desc.feature_value} ne "" }: {/if}
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
