{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#f6f8fb'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#25ade6'}
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
		position: relative;
		bottom: -103px;
		font-size: 14px;
		font-weight: 700;
		padding: 8px 20px;
		text-shadow: none;
		text-transform: uppercase;
		box-shadow: none;
		border-radius: 6px;
		background-clip: padding-box;
		padding-top: 0;
		padding-bottom: 0;
		line-height: 43px;
		background-color: #98d54a;
		width: 50% !important;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	}


	#{$random_id} .pricing_table_box-all {
		background-color: {$primary_color};
		margin-bottom: 44px;
	}
	.fa.fa-angle-right{
		position: relative;
		bottom: -45px;
		right: -46px;
		color:white;
	}


	.whmpress.whmpress_pricing_table.alt-03 .pricing_table_detail .holder{
		display:none;
	}

	#{$random_id} .pricing_table_price .holder {
		font-size: 35px;
		color: {$secondary_color};
		margin-top: -51px;
		margin-bottom: 26px !important;
		padding-bottom: 40px;
	}

	.whmpress.whmpress_pricing_table.alt-03 {
		box-shadow: 0 0 15px 2px #ededed;
		border-radius: 6px;
		margin-bottom: 40px;
	}
	.whmpress.whmpress_pricing_table.alt-03 .pricing_table_heading h2{
		padding-bottom: 20px;
	}
	.whmpress.whmpress_pricing_table.alt-03 .pricing_table_price .holder .decimal,
	.whmpress.whmpress_pricing_table.alt-03 .pricing_table_price .holder .fraction{
		display:none;
	}
	.whmpress.whmpress_pricing_table.alt-03 .pricing_table_price .holder .duration{
		font-size: 12px;
		color: #7d8696;
	}
	.whmpress.whmpress_pricing_table.alt-03 .pricing_table_features .holder ul{
		border-top:none;
	}
	.whmpress.whmpress_pricing_table.alt-03 .pricing_table_features .holder ul li span{
		display:block;
	}
	.whmpress.whmpress_pricing_table.alt-03 .pricing_table_features .holder ul li{
		margin: 0 auto;
		width: 75%;
		padding: 15px 0;
		color: #7d8696;
	}
	.whmpress.whmpress_pricing_table.alt-03 .pricing_table_features .holder ul li i{
		opacity: .5;
		color: #72ae49;
	}
	.whmpress.whmpress_pricing_table.alt-03 .pricing_table_features .holder ul li i:hover{
		opacity: 1;
	}
	.whmpress.whmpress_pricing_table.alt-03.featured {
		transform: scaleY(1.05);
	}
</style>

<div class="whmpress whmpress_pricing_table alt-03 {$featured}" id="{$random_id}">
	<div class="pricing_table_heading">
		<div class="holder">
			<h2><i class="fa {$sub_icon}"></i> {$product_name}</h2>
		</div>
	</div>
	<div class="pricing_table_box-all">
	<div class="pricing_table_detail">
		<div class="holder">
			<p>{$product_detail}</p>
		</div>
	</div>
	<div class="pricing_table_combo">
		<div class="holder">
			{$product_order_combo}<i class="fa fa-angle-right" aria-hidden="true"></i>
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
                <li class="{if {$desc.tooltip_text} ne '' }whmpress_has_tooltip{/if}">
                    <span class="whmpress_description_title">

						{if {$desc.tooltip_text} ne '' }
						<span class="whmpress_tooltip">{$desc.tooltip_text}</span>{/if}{$desc.feature_title}{if {$desc.icon_class} ne '' }<i class="fa fa-info-circle"></i>{/if}</span><span class="whmpress_description_value">{$desc.feature_value}</span>
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
