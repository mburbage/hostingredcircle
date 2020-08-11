{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#2B9F84'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#1B8569'}
{/if}

<style>
	#{$random_id} {
		box-shadow: none;
		border: solid 3px {$primary_color};
		border-radius: 0;
		padding-top: 0;
		padding-bottom: 0;
		border-bottom: solid 9px {$secondary_color};
		margin-bottom: 25px;
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
	background: #2B9F84;
	padding: 12px 0;
	border-radius: 0;
	font-weight: 100;
	width: 166px;
	margin-bottom: 10px;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
	background: #1B8569;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	}


	.whmpress.whmpress_pricing_table.whmpress-15 .pricing_table_price .holder {
		font-size: 28px;
		font-weight: 700;
		padding-top: 22px;
		padding-bottom: 22px;
		color: white;
	}
	.whmpress.whmpress_pricing_table.whmpress-15 .pricing_table_price .holder .decimal, .whmpress.whmpress_pricing_table.whmpress-15 .pricing_table_price .holder .fraction {
		display: none;
	}
	.whmpress.whmpress_pricing_table.whmpress-15 .pricing_table_price .holder .currency {
		padding-right: 6px;
	}
	.whmpress.whmpress_pricing_table.whmpress-15 .pricing_table_heading .holder h2 {
		font-size: 22px;
		font-weight: 400;
		color: white;
		padding-bottom: 16px;
		margin-bottom: 0;
		padding-top: 20px;
	}
	.whmpress.whmpress_pricing_table.whmpress-15 .pricing_table_detail {
		display: none;
	}
	#{$random_id} .main {
		background-color: {$primary_color};
		border-bottom: solid 9px {$secondary_color};
	}
	.whmpress.whmpress_pricing_table.whmpress-15 .pricing_table_features .holder ul {
		border: none;
		padding-top: 0;
		border-bottom: dotted 2px #9E9E9E;
		width: 280px;
		margin-left: 7px;
		margin-bottom: 20px;
	}
	.whmpress.whmpress_pricing_table.whmpress-15 .pricing_table_features .holder ul li {
		border: none;
		padding-top: 3px;
	}
	.whmpress.whmpress_pricing_table.whmpress-15.featured .main{
		margin-top: -1px;
	}
	.whmpress.whmpress_pricing_table.whmpress-15.featured {
		transform: scaleY(1.05);
	}
</style>


<div class="whmpress whmpress_pricing_table whmpress-15 {$featured}" id="{$random_id}">
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
</div>  <!-- /.price-table -->
