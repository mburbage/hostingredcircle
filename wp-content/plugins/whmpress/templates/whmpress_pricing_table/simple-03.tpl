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
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	}





	.whmpress.whmpress_pricing_table.simple-03 {
		box-shadow: none;
		border: solid 1px #E5E6E9;
		border-radius: 0;
		padding-top: 0;
		padding-bottom: 6px;
		background-color: #F7F8FA;
		margin-top:20px;
		margin-bottom:20px;
	}
	.whmpress.whmpress_pricing_table.simple-03 .pricing_table_heading .holder h2 {
		font-size: 25px;
		font-weight: 700;
		color: {$primary_color};
		padding-top: 44px;
		margin: 0;
		padding-bottom: 10px;
	}
	.whmpress.whmpress_pricing_table.simple-03 .pricing_table_detail {
		display: none;
	}
	.whmpress.whmpress_pricing_table.simple-03 .pricing_table_price .holder .currency {
		font-size: 30px;
		font-weight: 700;
		color: #ffffff;
		padding-right: 4px;
		position: relative;
		bottom: 28px;
	}
	.whmpress.whmpress_pricing_table.simple-03 .pricing_table_price .holder .amount {
		font-size: 60px;
		font-weight: 700;
		color: #ffffff;
	}
	.whmpress.whmpress_pricing_table.simple-03 .pricing_table_price .holder .decimal, .whmpress.whmpress_pricing_table.great .pricing_table_price .holder .fraction {
		display: none;
	}
	.whmpress.whmpress_pricing_table.simple-03 .pricing_table_price .holder .duration {
		font-size: 14px;
		font-weight: 700;
		color: #ffffff;
		display: block;
		margin-top: -3px;
	}
	.whmpress.whmpress_pricing_table.simple-03 .pricing_table_price .holder .fraction {
		display: none;
	}
	.whmpress.whmpress_pricing_table.simple-03 .main {
		background-color: #1c1c1c;
		padding-bottom: 32px;
	}
	.whmpress.whmpress_pricing_table.simple-03 .main1{
		border-top: solid 5px #1c1c1c;
	}
	#{$random_id} .main1:hover {
		border-top: solid 5px;
		border-color: {$primary_color};
	}
	.whmpress.whmpress_pricing_table.simple-03 .pricing_table_features .holder ul {
		border: none;
	}
	.whmpress.whmpress_pricing_table.simple-03 .pricing_table_features .holder ul li {
		width: 302px;
		margin-left: -16px;
		padding: 8px 0;
		font-size: 14px;
		font-weight: 400;
		color: #2f3542;
	}
	.whmpress.whmpress_pricing_table.simple-03 .whmpress.whmpress_order_combo button {
		width: 192px;
		font-size: 19px;
		font-weight: 500;
		color: #ffffff;
		padding: 13px 0;
	}
	.whmpress.whmpress_pricing_table.simple-03 .whmpress.whmpress_order_combo button:hover {
		color: #fff;
		transition: 0.5s;
	}
	.whmpress.whmpress_pricing_table.simple-03.featured .main1 {
		border-top: solid 5px {$primary_color};
	}

</style>



<div class="whmpress whmpress_pricing_table simple-03 {$featured}" id="{$random_id}">
	<div class="main1">
		<div class="main">
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
	</div>
</div>  <!-- /.price-table -->
