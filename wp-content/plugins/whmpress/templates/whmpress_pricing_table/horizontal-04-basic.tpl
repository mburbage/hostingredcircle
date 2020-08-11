{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#62ccd1'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#989898'}
{/if}

<style>
	#{$random_id} .top.top1 .pricing_table_price .holder {
	color: {$primary_color};
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.horizontal-04 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.horizontal-04 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.horizontal-04 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.horizontal-04 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.horizontal-04 .pricing_table_submit button {
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.horizontal-04 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.horizontal-04 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.horizontal-04 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.horizontal-04 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.horizontal-04 .pricing_table_submit button {
		color: #fff;
		background-color: #ec2706;
		border-color: #e22505;
	}








	.whmpress.whmpress_pricing_table.horizontal-04 {
		border: solid 1px #EEEEEF;
		border-radius: 8px;
		box-shadow: none;
		padding: 172px 0;
		margin: auto;
		max-width: 100%;
		border-bottom: solid 3px #BFBFBF;

	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top {
		float: left;
		width: 50%;
		margin: auto;
		position: relative;
		bottom: 152px;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.top1 .pricing_table_heading,
	.whmpress.whmpress_pricing_table.horizontal-04 .top.top1 .pricing_table_detail.deatils {
		display: none;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.top1 .pricing_table_price .holder .currency {
		font-size: 50px;
		font-weight: 300;
		position: relative;
		bottom: 30px;
		padding-right: 4px;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.top1 .pricing_table_price .holder .amount {
		font-size: 80px;
		font-weight: 200;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.top1 .pricing_table_price .holder .decimal, .whmpress.whmpress_pricing_table.horizontal-04 .top.top1 .pricing_table_price .holder .fraction {
		font-size: 40px;
		font-weight: 300;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.top1 .pricing_table_price .holder .duration {
		display: block;
		font-size: 16px;
		font-weight: 400;
		color: #333333;
		margin-top: -12px;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.top1 .pricing_table_price .holder {
		padding: 22px 0;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.top1 .pricing_table_combo .holder select {
		width: 50%;
		border-radius: 0;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.top1 .pricing_table_combo .holder button {
		width: 32%;
		font-size: 16px;
		font-weight: 600;
		border-radius: 3px;
		padding: 8px 0;
	}

	.whmpress.whmpress_pricing_table.horizontal-04 .top.top1 .pricing_table_detail .holder {
		font-size: 11px;
		color: #999999;
		font-weight: 400;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.top1 .pricing_table_detail {
		padding: 0;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.top1 {
		border-right: solid 1px #EEEEEF;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.bottom .pricing_table_features .holder ul {
		border: none;
		margin: 0;
		padding: 15px 42px;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.bottom .pricing_table_features .holder ul li {
		border: none;
		color: #333333;
		font-size: 18px;
		font-weight: 400;
		text-align: left;
	}
	.top.bottom .pricing_table_features .holder ul li i{
		color: {$secondary_color};
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.bottom .pricing_table_features .holder ul li i {
		font-size: 16px;
		font-weight: 400;
	}
	.whmpress.whmpress_pricing_table.horizontal-04 .top.bottom .pricing_table_features .holder ul li i.fa.fa-question-circle:hover {
		color: #000000;
		transition: 0.5s;
	}


	@media (max-width:786px) {

		.whmpress.whmpress_pricing_table.horizontal-04 .top{
			float: none;
			max-width: 100%;
			margin: auto;
		}
		.whmpress.whmpress_pricing_table.horizontal-04 .top.top1{
			border: none;
			width: 100%;
		}
		.whmpress.whmpress_pricing_table.horizontal-04 {
			padding-bottom: 0;
		}
		.whmpress.whmpress_pricing_table.horizontal-04 .top.bottom .pricing_table_features .holder ul {
			border-top: solid 1px #EEEDEF;
			padding: 15px 0;
		}
		.whmpress.whmpress_pricing_table.horizontal-04 .top.bottom {
			padding-top: 55px;
			width: 85%;
		}
		.whmpress.whmpress_pricing_table.horizontal-04 .top.bottom .pricing_table_features .holder ul li {
			padding: 10px 0;
		}
		.whmpress.whmpress_pricing_table.horizontal-04 .top.top1 .pricing_table_combo .holder select {
			width: 75%;
		}


	}

</style>
<div class="whmpress whmpress_pricing_table horizontal-04 {$featured}" id="{$random_id}">
	<div class=" top top1">
	<div class="pricing_table_heading">
		<div class="holder">
			<h2><i class="fa {$sub_icon}"></i> {$product_name}</h2>
		</div>
	</div>
	<div class="pricing_table_detail deatils">
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
	<div class="top bottom">
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
						{$desc.feature_title}
                        {if $show_description_tooltip eq 'yes' and $desc.tooltip_text ne '' }
                            <span class="whmpress_tooltip">{$desc.tooltip_text}</span>{/if}{if $desc.feature_value ne "" }:{/if}
                    </span><span class="whmpress_description_value">{$desc.feature_value}</span>
						{if $desc.icon_class ne 'yes' || $desc.icon_class eq ''}
						<i class="fa fa-question-circle"></i>
						{/if}
					</li>
					{/foreach}
				</ul>
			</div>
		</div>
	{else}
	{$product_description}
	{/if}
	</div>
</div>  <!-- /.price-table -->
