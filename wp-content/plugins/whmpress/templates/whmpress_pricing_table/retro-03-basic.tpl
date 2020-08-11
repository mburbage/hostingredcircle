<div class="whmpress whmpress_pricing_table retro-o3 {$featured}">
	<div class="pricing_table_heading">
		<div class="holder">
			<img src="http://sajid.hostriplex.com/whmpress/wp-content/uploads/2018/01/1.png" alt="akt">
			<h2><i class="fa {$sub_icon}"></i> {$product_name}</h2>
		</div>
	</div>
	<div class="pricing_table_detail pricing_table_detail-2">
		<div class="holder">
			<p>{$product_detail}</p>
		</div>
	</div>
	<div class="pricing_table_price">
		<div class="holder">
			*<span class="currency">{$prefix}</span><span class="amount">{$amount}</span>{if $fraction ne ""}<span
			class="decimal">{$decimal}</span><span class="fraction">{$fraction}</span>{/if}<span class="duration">{$duration}</span>*

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
										{if {$desc.feature_value} ne "" }
					:
					{/if}
 </span><strong class="whmpress_description_value">{$desc.feature_value}</strong></li>
				{/foreach}
			</ul>
		</div>
	</div>
	<i class="fa fa-check-circle" aria-hidden="true"></i>
	<i class="fa fa-times-circle" aria-hidden="true"></i>
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
