
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


	.whmpress.whmpress_pricing_table.simple-05 {
		box-shadow: none;
		background-color: #67b0ff;
		border: solid 1px #67b0ff;
		border-radius: 6px;
		padding-top: 0;
		padding-bottom: 6px;
		margin-top:20px;
		margin-bottom:20px;
	}
	.whmpress.whmpress_pricing_table.simple-05:hover {
		background-color: #3395ff;
		box-shadow: 0 0 14px 0 grey;
		transition: 0.5s;
		cursor: pointer;
	}
	.whmpress.whmpress_pricing_table.simple-05 h2 {
		font-size: 16px;
		color: white;
		padding-top: 10px;
		font-weight: 400;
		border-bottom: solid 1px white;
		padding-bottom: 10px;
	}
	.whmpress.whmpress_pricing_table.simple-05 .currency {
		font-size: 25px;
		font-weight: 300;
		color: white;
		position: relative;
		bottom: 26px;
		padding-right: 6px;
	}
	.whmpress.whmpress_pricing_table.simple-05 .digit {
		font-size: 55px;
		color: white;
	}
	.whmpress.whmpress_pricing_table.simple-05 .duration {
		display: block;
		color: white;
		font-size: 15px;
		padding-top: 5px;
		border-bottom: solid 1px white;
		padding-bottom: 10px;
		margin: auto;
		width: 50px;
	}
	.whmpress.whmpress_pricing_table.simple-05 ul {
		border: none;
		padding-top: 7px;
	}
	.whmpress.whmpress_pricing_table.simple-05 li {
		border: none;
		color: white;
		font-size: 15px;
	}
	.whmpress.whmpress_pricing_table.simple-05 .whmpress_description_value {
		font-weight: 100;
	}
	.whmpress.whmpress_pricing_table.simple-05 .whmpress_description_title {
		font-weight: 100;
	}
	.whmpress.whmpress_pricing_table.simple-05 .whmpress.whmpress_order_combo button {
		color: #558AFE;
		margin-top: 10px;
		margin-bottom: 12px;
	}
	.whmpress.whmpress_pricing_table.simple-05.featured {
		background-color: #3395ff;
		transform: scaleY(1.05);
	}
	.whmpress.whmpress_pricing_table.simple-05 .whmpress.whmpress_order_combo button:hover {
		color: white;
		transition: 0s;
	}

</style>



<div class="whmpress whmpress_pricing_table simple-05 {$featured}" id="{$random_id}">
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
			<span class="currency">{$prefix}</span><span class="amount digit">{$amount}</span><span class="currency">{$suffix}</span>{if $fraction ne ""}<span
				class="decimal digit">{$decimal}</span><span class="fraction digit">{$fraction}</span>{/if}<span class="duration">{$duration}</span>

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
