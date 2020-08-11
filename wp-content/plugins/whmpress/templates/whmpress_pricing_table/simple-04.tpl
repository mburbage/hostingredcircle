{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#f5f5f5'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#fff'}
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
	background: {$secondary_color};
	}



	.whmpress.whmpress_pricing_table.simple-04 {
		box-shadow: none;
		border: solid 1px #DCDCDC;
		border-radius: 0;
		padding-top: 0;
		padding-bottom: 0;
		margin-top:20px;
		margin-bottom:20px;
	}
	.whmpress.whmpress_pricing_table.simple-04 .pricing_table_heading .holder h2 {
		padding-top: 20px;
		font-size: 13px;
		color: #333333;
		font-weight: 300;
	}
	.whmpress.whmpress_pricing_table.simple-04 .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.simple-04 .pricing_table_price .holder .decimal {
		display: none;
	}
	.whmpress.whmpress_pricing_table.simple-04 .pricing_table_price .holder .fraction {
		display: none;
	}
	.whmpress.whmpress_pricing_table.simple-04 .pricing_table_price .holder .duration {
		display: none;
	}
	.whmpress.whmpress_pricing_table.simple-04 .pricing_table_price .holder .currency {
		font-size: 20px;
		color: #333333;
		position: relative;
		bottom: 44px;
		padding-right: 1px;
	}
	.whmpress.whmpress_pricing_table.simple-04 .pricing_table_price .holder .amount {
		font-size: 70px;
		color: #333333;
		font-weight: 100;
	}
	.whmpress.whmpress_pricing_table.simple-04 .pricing_table_price {
		padding-top: 14px;
	}
	.whmpress.whmpress_pricing_table.simple-04 .pricing_table_detail .holder1 {
		font-size: 14px;
		color: #333333;
	}
	.whmpress.whmpress_pricing_table.simple-04 .pricing_table_detail {
		padding-top: 10px;
	}
	#{$random_id} .main {
		border-bottom: solid 1px #DBDBDB;
		padding-bottom: 9px;
		background-color: {$primary_color};
	}
	.whmpress.whmpress_pricing_table.simple-04 .pricing_table_features .holder ul {
		border: none;
		padding: 0;
	}
	.whmpress.whmpress_pricing_table.simple-04 .pricing_table_features .holder ul li {
		border-width: 1px;
		font-size: 14px;
		color: #333333;
		font-weight: 400;
		text-align: left;
		padding-left: 14px;
		padding-top: 7px;
		padding-bottom: 7px;
	}
	.whmpress.whmpress_pricing_table.simple-04 .whmpress.whmpress_order_combo button {
		margin-top: 3px;
		margin-bottom: 0;
		width: 300px;
		border-radius: 0;
		border-top: solid 1px #DCDCDC;
		font-size: 20px;
		color: #333333;
		padding: 16px 0;
	}
	.whmpress.whmpress_pricing_table.simple-04 .whmpress.whmpress_order_combo {
		padding-bottom: 0;
	}
	.whmpress.whmpress_pricing_table.simple-04 .whmpress.whmpress_order_combo button:hover {
		transition: 0s;
		color: #333333;
	}
	.whmpress.whmpress_pricing_table.simple-04.featured {
		border-color: #BEE7F0;
	}
	#{$random_id}s .main {
		background-color: {$primary_color};
	}
	.whmpress.whmpress_pricing_table.simple-04.featured .pricing_table_heading .holder h2 {
		color: #3a87ad;
	}
	.whmpress.whmpress_pricing_table.simple-04.featured .pricing_table_price .holder .currency {
		color: #3a87ad;
	}
	.whmpress.whmpress_pricing_table.simple-04.featured .pricing_table_price .holder .amount {
		color: #3a87ad;
	}
	.whmpress.whmpress_pricing_table.simple-04.featured .whmpress.whmpress_order_combo button {
		color: #3a87ad;
		border-top-color: #BEE7F0;
	}
	.whmpress.whmpress_pricing_table.simple-04.featured .whmpress.whmpress_order_combo button:hover {
		color: #333333;
	}
	#{$random_id}.featured{
		transform: scaleY(1.05);
	}

</style>





<div class="whmpress whmpress_pricing_table simple-04 {$featured}" id="{$random_id}">
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
</div>  <!-- /.price-table -->
