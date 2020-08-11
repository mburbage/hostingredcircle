{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#F7F7F7'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#1883cf'}
{/if}



<style>
	#{$random_id} {
	background: {$primary_color};
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_submit button {
		background-color: #F89B21;
		width: 80%;
		padding: 12px 0;
		font-size: 22px;
		font-weight: 700;
	}
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_submit button {
		background-color: #d6851c;
	}

	.whmpress.whmpress_pricing_table.advance-03 {
		box-shadow: none;
		padding: 34px 16px;
		border: solid 1px #F0F0F0;
		border-radius: 0;
		text-align: left;
	}
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_heading .holder h2 {
		font-weight: 700;
		color: #333333;
		font-size: 28px;
		margin-bottom: 0;
	}
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_detail {
		padding: 12px 8px;
	}
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_detail .holder {
		font-size: 16px;
		font-weight: 100;
		color: #a0a9ad;
		margin-top: -10px;
	}
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_detail.details {
		padding: 0;
	}
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_price {
		padding: 0 8px;
	}
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_price .holder h3 {
		font-size: 18px;
		color: #333333;
		font-weight: 700;
		margin-bottom: 0;
	}
	#{$random_id} .pricing_table_price .holder  {
		font-size: 40px;
		color:{$secondary_color};
		font-weight: 700;
	}
	#{$random_id} .pricing_table_price .holder .duration {
		font-size: 14px;
		font-weight: 700;
		color: {$secondary_color};
	}
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_price .holder p {
		font-size: 15px;
		font-weight: 400;
		color: #333333;
		margin-top: 4px;
		margin-bottom: 18px;
	}
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_baner h4 {
		border: none;
		position: absolute;
		right: -32px;
		top: 72px;
		transform: rotate(90deg);
		background: #ff9800;
		color: #fff;
		padding: 7px 0;
		letter-spacing: 2px;
		font-weight: bold;
		border-radius: 0 8px 8px 0;
		width: 180px;
		text-align: center;
	}
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_combo .holder select {
		border-radius: 0;
	}
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_features .holder ul li {
		border: none;
		padding: 9px 0;
		font-size: 14px;
		font-weight: 400;
		color: #4e5b61;
	}
	#{$random_id} .pricing_table_features .holder ul li i {
		color: {$secondary_color};
		padding-right: 6px;
	}
	.whmpress.whmpress_pricing_table.advance-03 .pricing_table_features .holder ul {
		border-top-color: #E9E6EB;
	}
	#{$random_id}.featured {
		background-color: #EEF1F5 ;
	}
</style>


<div class="whmpress whmpress_pricing_table advance-03 {$featured}" id="{$random_id}">
	<div class="pricing_table_baner">
		<h4>{$custom_text_1}</h4>
	</div>
	<div class="pricing_table_heading">
		<div class="holder">
			<h2><i class="fa {$sub_icon}"></i> {$product_name}</h2>
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
	<div class="pricing_table_detail details">
		<div class="holder">
			<p>{$product_detail}</p>
		</div>
	</div>
	<div class="pricing_table_price">
		<div class="holder">
			<h3>{$custom_text_2}</h3>
			<span class="currency">{$prefix}</span><span class="amount">{$amount}</span>{if $fraction ne ""}<span
				class="decimal">{$decimal}</span><span class="fraction">{$fraction}</span>{/if}<span class="duration">{$duration}</span>

			<!-- price sub text -->
			{if $price_sub_text ne ""}
			<div class="duration">
				{$price_sub_text}
			</div>
			{/if}
			<!-- /price sub text -->
			<p>{$custom_text_3}</p>
		</div>
	</div>
	<div class="pricing_table_combo">
		<div class="holder">
			{$product_order_combo}
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
					<strong class="whmpress_description_value">{$desc.feature_value}</strong>
				</li>
				{/foreach}
			</ul>
		</div>
	</div>
	{else}
	{$product_description}
	{/if}
	<div class="pricing_table_submit">
		<div class="holder">
			{$product_order_button}
		</div>
	</div>

</div>  <!-- /.price-table -->