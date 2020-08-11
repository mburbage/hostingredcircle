{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#F95827'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#22b628'}
{/if}


<style>

	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_submit button {
		margin-top: 12px;
		color: white;
		font-size: 20px;
		font-weight: 100;
		border-radius: 0;
		box-shadow: 5px 5px 17px 0 #D3D3D3;
		border: solid 1px #F95827;
	}
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_submit button {
		color: #F95827;
		background: transparent;
		transition: 0.5s;
	}
	/*{$secondary_color}*/

	.whmpress.whmpress_pricing_table.alt-07.featured .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-07.featured .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.alt-07.featured .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.alt-07.featured .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-07.featured .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.alt-07.featured .pricing_table_submit button {
		background-color: #22B628;
		border: solid 1px #22B628;
	}
	.whmpress.whmpress_pricing_table.alt-07.featured .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-07.featured .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.alt-07.featured .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.alt-07.featured .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-07.featured .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.alt-07.featured .pricing_table_submit button {
		color: #22B628;
		background: transparent;
		transition: 0.5s;
	}

	.whmpress.whmpress_pricing_table.alt-07 {
		box-shadow: none;
		border: solid 1px #CBCBCB;
		border-radius: 0;
		border-top: solid 4px {$primary_color};
		padding-top: 0;
		width: 345px;
		max-width: none;
		margin: 0 -4px;
		margin-bottom:20px;
	}
	.whmpress.whmpress_pricing_table.alt-07 h2 {
		font-size: 32px;
		font-weight: 400;
		color: {$primary_color};
		padding-top: 58px;
	}
	.whmpress.whmpress_pricing_table.alt-07 .decimal,
	.whmpress.whmpress_pricing_table.alt-07 .fraction,
	.whmpress.whmpress_pricing_table.alt-07 .duration{
		display: none;
	}
	.whmpress.whmpress_pricing_table.alt-07 .currency {
		font-size: 24px;
		color: #474747;
		padding-right: 2px;
	}
	.whmpress.whmpress_pricing_table.alt-07 .amount {
		font-size: 24px;
		color: #474747;
	}
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_detail {
		padding-top: 5px;
		font-size: 20px;
		color: #474747;
		font-weight: 100;
	}
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_combo button:hover {
		color: #F95827;
		transition: 0.5s;
	}
	.whmpress.whmpress_pricing_table.alt-07 ul {
		border: none;
		padding-top: 10px;
	}
	.whmpress.whmpress_pricing_table.alt-07 .pricing_table_features .holder ul li {
		border: none;
		padding-bottom: 21px;
		font-size: 20px;
		color: #474747;
		font-weight: 100;
		text-align: left;
		padding-left: 20px;
	}
	.whmpress.whmpress_pricing_table.alt-07 i.fa.fa-check {
		font-weight: 100;
		background-color: {$primary_color};
		height: 25px;
		width: 25px;
		padding: 6px 5px;
		color: white;
		border-radius: 15px;
		font-size: 15px;
		margin-right: 8px;
	}
	.whmpress.whmpress_pricing_table.alt-07.featured {
		border: solid 4px {$secondary_color};
		padding-bottom: 17px;
		margin-top: -10px;
		margin-left: -7px;
		max-width: none;
		width: 345px;
		border-top: solid 14px {$secondary_color};
	}
	.whmpress.whmpress_pricing_table.alt-07.featured i.fa.fa-check {
		background-color: {$secondary_color};
	}
	.whmpress.whmpress_pricing_table.alt-07.featured h2 {
		color: {$secondary_color};
	}
</style>

<div class="whmpress whmpress_pricing_table alt-07 {$featured}" id="{$random_id}">

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
	<div class="pricing_table_combo">
		<div class="holder">
			{$product_order_combo}
		</div>
	</div>
	{/if}
	{if $process_description|lower eq "yes"}
	<div class="pricing_table_features">
		<div class="holder">
			<ul>
                {foreach $split_description as $desc}
                <li class="{if {$desc.tooltip_text} ne '' }whmpress_has_tooltip{/if}">
					<span class="whmpress_description_title">
                        {if {$desc.icon_class} ne '' }
                            <i class="fa fa-check"></i>
                        {/if}
						{$desc.feature_title}
                        {if {$desc.tooltip_text} ne '' }
                            <span class="whmpress_tooltip">{$desc.tooltip_text}</span>
                        {/if}
                    </span>
                    <span class="whmpress_description_value">{$desc.feature_value}</span>
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
