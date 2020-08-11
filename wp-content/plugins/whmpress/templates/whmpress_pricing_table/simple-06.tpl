{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#d35553'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#c33634'}
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
	}


	::selection{
		background-color:#444444;
		color:white;
	}
	.whmpress.whmpress_pricing_table.simple-06 {
		box-shadow: none;
		border: solid 1px #DCDCDC;
		margin: 10px;
		padding-top: 0;
		background-color: #F5F5F5;
		border-radius: 2px;
		margin-top:20px;
		margin-bottom:20px;
		padding-bottom: 0;
	}
	.whmpress.whmpress_pricing_table.simple-06 h2 {
		font-size: 20px;
		font-weight: 700;
		color: #555555;
		border-bottom: solid 1px #ECECEC;
		padding-top: 24px;
		padding-bottom: 24px;
		background-color: #F9F9F9;
	}
	.whmpress.whmpress_pricing_table.simple-06 .currency {
		font-size: 28px;
		color: #444444;
		font-weight: 400;
		position: relative;
		bottom: 28px;
		padding-right: 5px;
	}
	.whmpress.whmpress_pricing_table.simple-06 .amount {
		font-size: 72px;
		color: #444444;
	}
	.whmpress.whmpress_pricing_table.simple-06 .duration {
		font-size: 16px;
		color: #999999;
	}
	.whmpress.whmpress_pricing_table.simple-06 .pricing_table_price {
		padding-bottom: 15px;
		border-bottom: solid 1px lightgray;
		margin: auto;
		width: 130px;
	}
	.whmpress.whmpress_pricing_table.simple-06.whmpress_pricing_table ul li {
		border-bottom: none;
	}
	.whmpress_pricing_table ul li {
		font-size: 14px;
		color: #555555;
	}
	.whmpress.whmpress_pricing_table.simple-06 .pricing_table_combo{
		border-top: solid 1px #ECECEC;
		padding-top: 15px;
	}
	.whmpress.whmpress_pricing_table.simple-06 .whmpress.whmpress_order_combo button {
		color: white;
		font-size: 18px;
		font-weight: 400;
		border-radius: 7px;
		padding: 10px 0;
		width: 194px;
	}
	.whmpress.whmpress_pricing_table.simple-06.whmpress_pricing_table .pricing_table_detail {
		padding: 0;
	}
	.whmpress.whmpress_pricing_table.simple-06.featured {
		margin-right: -12px;
		box-shadow: 0 0 12px 0 lightgrey;
		background-color: #ffffff;
	}
	.whmpress.whmpress_pricing_table.simple-06.featured .whmpress.whmpress_order_combo button {
		color: white;
	}
	.whmpress.whmpress_pricing_table.simple-06.featured .whmpress.whmpress_order_combo button:hover {
		color: white;
		transition: 0s;
	}
	.whmpress.whmpress_pricing_table.simple-06.featured h2 {

		background-color: #ffffff;
	}
	.whmpress.whmpress_pricing_table.simple-06 ul {
		border: none;
	}
	#{$random_id}.featured{
		transform: scaleY(1.05);
	}

</style>



<div class="whmpress whmpress_pricing_table simple-06 {$featured}" id="{$random_id}">
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