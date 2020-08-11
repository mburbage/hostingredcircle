{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#F8CD36'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#fdf3e1'}
{/if}




<style>
	#{$random_id} {
	background-color: {$secondary_color};
	box-shadow: none;
	border: solid 1px #FDF3E1;
	border-radius: 0;
	padding-top: 0;
	padding-bottom: 0;
	margin-bottom:20px;
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
	background: #f1d140;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
		background-color: none;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
		background: none;
	}


	.whmpress.whmpress_pricing_table.retro-06 .pricing_table_heading .holder h2 {
		font-size: 20px;
		font-weight: 700;
		margin-bottom: 0;
		padding-top: 24px;
		color: #FDF3E1;
	}
	.whmpress.whmpress_pricing_table.retro-06 .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.retro-06 .pricing_table_price .holder .currency {
		font-size: 38px;
		font-weight: 700;
		color: #363636;
	}
	.whmpress.whmpress_pricing_table.retro-06 .pricing_table_price .holder .duration {
		display: none;
	}
	.whmpress.whmpress_pricing_table.retro-06 .pricing_table_price .holder .amount {
		font-size: 40px;
		font-weight: 700;
		color: #363636;
	}
	.whmpress.whmpress_pricing_table.retro-06 .pricing_table_price .holder .decimal {
		display: none;
	}
	.whmpress.whmpress_pricing_table.retro-06 .pricing_table_price .holder .fraction {
		font-weight: 700;
		position: relative;
		bottom: 13px;
		font-size: 18px;
		display: inline;
	}
	.whmpress.whmpress_pricing_table.retro-06 .pricing_table_price .holder .decimal {
		display: inline;
		position: relative;
		bottom: 13px;
	}
	#{$random_id} .main {
		background-color: {$primary_color};
		margin-bottom: 40px;
	}
	#{$random_id} .main .arrow-down {
		position: absolute;
		margin: 0 0 0 -148px;
		border-left: 150px solid transparent;
		border-right: 150px solid transparent;
		border-top: 20px solid {$primary_color};
		line-height: 0;
		transition: 1.0s;
	}
	.whmpress.whmpress_pricing_table.retro-06 .pricing_table_detail .holder {
		font-size: 14px;
		font-weight: 500;
	}
	.whmpress.whmpress_pricing_table.retro-06 .pricing_table_detail {
		padding-bottom: 0;
	}
	.whmpress.whmpress_pricing_table.retro-06 .pricing_table_features .holder ul li {
		width: 112%;
		margin-left: -16px;
		border-color: #D9D7C5;
		font-weight: 500;
		color: #363636;
		padding: 8px 0;
	}
	.whmpress.whmpress_pricing_table.retro-06 .pricing_table_features .holder ul {
		padding-top: 7px;
	}
	.whmpress.whmpress_pricing_table.retro-06 .whmpress.whmpress_order_combo button {
		width: 150px;
		padding: 14px 0;
		font-weight: 500;
		margin-bottom: 10px;
	}
	#{$random_id}.featured .main .arrow-down {
		position: absolute;
		margin: 0 0 0 -39px;
		border-left: 40px solid transparent;
		border-right: 40px solid transparent;
		border-top: 25px solid {$primary_color};
		line-height: 0;
		transition: 1.0s;
		top: 103px;
	}

</style>


<div class="whmpress whmpress_pricing_table retro-06 {$featured}" id="{$random_id}">
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
		<span class="arrow-down"></span>
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
