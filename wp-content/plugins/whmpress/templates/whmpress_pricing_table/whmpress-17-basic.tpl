
{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#41464D'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#4BC496'}
{/if}

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
	background: #6D93D3;
	width: 170px;
	border-radius: 6px;
	margin-bottom: 0;
	box-shadow: 2px 2px 2px 0 #3B5A7C;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
	background: #43587B;
	box-shadow: none;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
		background: none;
	}



	.whmpress.whmpress_pricing_table.whmpress-17 {
		padding-top: 0;
		border-radius: 0;
		border: solid 1px lightgray;
		box-shadow: none;
		background-color: #D6EDFF;
		padding-bottom: 0;
		margin-bottom:25px;
	}
	#{$random_id} .pricing_table_heading .holder h2 {
		background-color: {$primary_color};
		font-size: 31px;
		font-weight: 700;
		color: #ffffff;
		margin-bottom: 0;
		padding: 18px 0;
		margin-top: 0;
	}
	.whmpress.whmpress_pricing_table.whmpress-17 .pricing_table_price .holder .decimal {
		display: none;
	}
	.whmpress.whmpress_pricing_table.whmpress-17 .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.whmpress-17 .pricing_table_price .holder .fraction {
		display: none;
	}
	.whmpress.whmpress_pricing_table.whmpress-17 .pricing_table_price .holder {
		font-size: 30px;
		color: black;
		font-weight: 400;
		padding-top: 26px;
		padding-bottom: 10px;
	}
	.whmpress.whmpress_pricing_table.whmpress-17 .pricing_table_detail {
		display: none;
	}
	.whmpress.whmpress_pricing_table.whmpress-17 .pricing_table_features .holder ul {
		border: none;
		text-align: left;
		padding-left: 38px;
		padding-bottom: 22px;
	}
	.whmpress.whmpress_pricing_table.whmpress-17 .pricing_table_features .holder ul li {
		border: none;
		color: black;
		font-size: 15px;
		padding-bottom: 10px;
		font-weight: 400;
	}
	#{$random_id} .pricing_table_features .holder ul li i {
		font-size: 23px;
		padding-right: 4px;
		color: {$primary_color};
	}
	#{$random_id} .footer p {
		margin-bottom: 0;
		margin-top: 39px;
		padding: 12px 0;
		font-size: 18px;
		font-weight: 500;
		color: white;
		background-color: {$secondary_color};
	}

	#{$random_id} .arrow-up {
		position: absolute;
		margin: 0 0 0 130px;
		border-left: 20px solid transparent;
		border-right: 20px solid transparent;
		border-bottom: 20px solid {$secondary_color};
		line-height: 0;
		transition: 1.0s;
		bottom: 75px;
	}
	.whmpress.whmpress_pricing_table.whmpress-17.featured .pricing_table_detail {
		display: block;
	}
	.whmpress.whmpress_pricing_table.whmpress-17.featured .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.whmpress-17.featured .pricing_table_detail {
		display: block;
		margin-bottom: -11px;
		margin-top: 25px;
		text-align: left;
		padding-left: 32px;
		font-size: 14px;
		background-color: #BBD1E1;
		font-weight: 600;
		padding-top: 7px;
		padding-bottom: 7px;
	}
	.whmpress.whmpress_pricing_table.whmpress-17.featured .pricing_table_features .holder ul li {
		padding-bottom: 4px;
	}
	#{$random_id}.featured .arrow-up {
		bottom: 48px;
	}
	.whmpress.whmpress_pricing_table.whmpress-17.featured {
		transform: scaleY(1.05);
	}
</style>

<div class="whmpress whmpress_pricing_table whmpress-17 {$featured}" id="{$random_id}">
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
						{if $desc.icon_class ne 'yes' || $desc.icon_class eq ''}
                            <i class="fa fa-check-circle-o"></i>
                        {/if}

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
	<div class="arrow-up"></div>
	<div class="footer"><p>{$custom_text_1}</p></div>
</div>  <!-- /.price-table -->