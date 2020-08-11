{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#00ce1b'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#ffe3d4'}
{/if}
<style>
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button,
	#{$random_id} .pricing_table_combo a,
	#{$random_id} .pricing_table_combo button,
	#{$random_id} .pricing_table_submit .whmpress_order_button,
	#{$random_id} .pricing_table_submit a,
	#{$random_id} .pricing_table_submit button {
					  margin-top: 30px;
					  background-color: #00ce1b;
					  color: #737373;
					  padding: 15px 30px 15px 30px;
					  border-radius: 50px 50px 50px 50px;
		text-transform: uppercase;

	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
					  background-color: #f8e604;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {

	}

	#{$random_id}.whmpress.whmpress_pricing_table.whmpress-twenty{
		box-shadow: none;
		 padding: 25px 25px 25px 25px;
		 background-color: rgba(242,242,242,0.67);
		 border-radius: 25px 25px 25px 25px;
		border: 3px solid #000000;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.whmpress-twenty .pricing_table_heading h2 {
		 padding: 30px 30px 0 30px;
		 color: #232c3b;
		 font-size: 35px;
		 font-weight: 900;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.whmpress-twenty .pricing_table_price {
		 color: #ff3800;
		font-weight: 900;
		font-size: 28px;
		 padding: 40px 0;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.whmpress-twenty .pricing_table_price span.amount {
		 font-size: 80px;
		line-height: 64px;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.whmpress-twenty .pricing_table_price span.decimal{
		display: none;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.whmpress-twenty .pricing_table_price span.currency,
	#{$random_id}.whmpress.whmpress_pricing_table.whmpress-twenty .pricing_table_price span.fraction{
		 vertical-align: top;
		line-height: 35px;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.whmpress-twenty .pricing_table_price span.duration {
		 color: #000000;
		 font-weight: 400;
		font-size: 16px;
		display: block;
		text-align: center;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.whmpress-twenty .pricing_table_features ul {
		padding: 0;
		margin: 0;
		border: none;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.whmpress-twenty .pricing_table_features ul li{
		padding: 11px 0;
		 font-size: 15px;
		 font-weight: 500;
		 letter-spacing: 0.5px;
		line-height: 26px;
		border-width: 2px;
		border-color: rgba(0,0,0,0.62);
	 }

</style>

<div class="whmpress whmpress_pricing_table whmpress-twenty {$featured}" id="{$random_id}">
	<div class="pricing_table_heading">
		<div class="holder">
			<div class="whmpress-icon-host"><i class="fa {$sub_icon}"></i></div>
			<h2> {$product_name}</h2>
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
	{if $process_description|lower eq "yes"}
	<div class="pricing_table_features">
		<div class="holder">
			<ul>
				{foreach $split_description as $desc}
				<li class="{if $show_description_tooltip eq 'yes' } whmpress_has_tooltip{/if}">
					<span class="whmpress_description_value">{$desc.feature_value}</span>
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
						{*{if $desc.feature_value ne "" }: {/if}*}
                    </span>
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
