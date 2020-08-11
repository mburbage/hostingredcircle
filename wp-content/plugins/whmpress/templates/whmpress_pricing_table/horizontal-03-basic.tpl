{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#F6474F'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#333F51'}
{/if}


<style>
	#{$random_id} .top.top1 .pricing_table_heading .holder h2{
	background: {$primary_color};
		margin-top: 0;
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.horizontal-03 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.horizontal-03 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.horizontal-03 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.horizontal-03 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.horizontal-03 .pricing_table_submit button {
		width: 35%;
		border-radius: 27px;
		padding: 5px 0;
		background-color: #F6474F;
		font-size: 16px;
		margin-bottom: 26px;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.horizontal-03 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.horizontal-03 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.horizontal-03 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.horizontal-03 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.horizontal-03 .pricing_table_submit button {
		background-color: #e63e45;
		color: white;
	}





	.whmpress.whmpress_pricing_table.horizontal-03 {
		box-shadow: none;
		border: none;
		padding: 0;
		margin:auto;
		max-width: 100%;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top {
		float: left;
		width: 33%;
	}

	.whmpress.whmpress_pricing_table.horizontal-03 .pricing_table_heading .holder{
		position: relative;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.top1 {
		background-color: #76B8D9;
		padding: 0;
		width: 33%;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.top1 .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.top1 .pricing_table_heading .holder h2 {
		color: white;
		padding: 9px 0;
		box-shadow: 0 6px 16px -3px #405d6b;
		margin-bottom:0;
		position: relative;
	}
	#{$random_id} .top.top1 .arrow-down{
		border-top: 18px solid {$primary_color};
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.top1 .arrow-down {
		border-right: 18px solid transparent;
		border-left: 18px solid transparent;
		position: absolute;
		left: 154px;
		top: 100%;
		z-index: 1;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.top1 .pricing_table_detail {
		font-size: 30px;
		color: #3B4366;
		font-weight: 100;
		padding:53px 0;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.bottom .pricing_table_combo {
		margin-bottom: -18px;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.bottom .pricing_table_price .holder {
		padding: 15px 0;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.bottom {
		padding: 5px 0;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.bottom .pricing_table_price .holder .currency {
		font-size: 23px;
		position: relative;
		bottom: 10px;
		padding-right: 6px;
		font-weight: 500;
		color: black;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.bottom .pricing_table_price .holder .amount, .whmpress.whmpress_pricing_table.horizontal-03 .top.bottom .pricing_table_price .holder .decimal, .whmpress.whmpress_pricing_table.horizontal-03 .top.bottom .pricing_table_price .holder .fraction {
		font-size: 32px;
		font-weight: 700;
		color: black;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.bottom .pricing_table_price .holder .duration {
		font-size: 15px;
		font-weight: 700;
		color: black;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.bottom .pricing_table_combo select {
		width: 58%;
		border-radius: 0;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.list .pricing_table_features .holder ul {
		border: none;
		padding: 0;
		margin: 0;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.list .pricing_table_features .holder ul li {
		border: none;
		padding: 1px 0;
		text-align: left;
		font-size: 15px;
		color: white;
		font-weight: 100;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.list .pricing_table_features .holder ul li i.fa.fa-square {
		font-size: 11px;
		color: #76B8D9;
		padding-right: 10px;
	}
	.whmpress.whmpress_pricing_table.horizontal-03 .top.list {
		background-color: #333F51;
		padding: 9px 22px;
		border-bottom-right-radius: 100px;
	}
	#{$random_id} .top.list {
	background: {$secondary_color};
	}








	@media(max-width: 1108px){
		.whmpress.whmpress_pricing_table.horizontal-03 .top.top1 {
			float: none;
			width: 100%;
		}
		.whmpress.whmpress_pricing_table.horizontal-03 .top.top1 .arrow-down {
			display: none;
		}
		.whmpress.whmpress_pricing_table.horizontal-03 .top.list,
		.whmpress.whmpress_pricing_table.horizontal-03 .top.bottom{
			width: 50%;
			border-radius: 0;
		}
	}


	@media(max-width: 786px){
		.whmpress.whmpress_pricing_table.horizontal-03 .top {
			float: none;
			max-width: 100%;
			margin: auto;
		}
		.whmpress.whmpress_pricing_table.horizontal-03 .top.bottom {
			width: 100%;
		}
		.whmpress.whmpress_pricing_table.horizontal-03 .top.list {
			width: 100%;
		}

	}
</style>
<div class="whmpress whmpress_pricing_table horizontal-03 {$featured}" id="{$random_id}">
	<div class="top top1">
	<div class="pricing_table_heading">
		<div class="holder">
			<div class="arrow-down"></div>
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
	<div class="top bottom">
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
	</div>
	<div class="top list">
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
                            <i class="fa fa-square"></i>
                        {/if}
						<span class="whmpress_description_value">{$desc.feature_value}</span>
						{$desc.feature_title}
                        {if $show_description_tooltip eq 'yes' and $desc.tooltip_text ne '' }
                            <span class="whmpress_tooltip">{$desc.tooltip_text}</span>
                        {/if}
                    </span>
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
