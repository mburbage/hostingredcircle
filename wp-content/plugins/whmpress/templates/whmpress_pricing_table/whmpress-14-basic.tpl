{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#81d28d'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#92d89d'}
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
	background: #81d28d;
	font-size: 12px;
	text-transform: uppercase;
	padding: 11px 35px;
	text-decoration: none;
	border-radius: 50px;
	box-shadow: 0 12px 15px 0 rgba(37, 61, 88, 0.05);
	width: 50%;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
	background: #92d89d;
	box-shadow: 0 12px 15px 0 rgba(37, 61, 88, 0.1);
	text-decoration: none;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	}
	.whmpress.whmpress_pricing_table.whmpress-14 {
		background: #fff;
		border: 2px solid rgba(110, 176, 220, 0.09);
		padding: 40px 20px;
		text-align: center;
		border-radius: 21px;
		box-shadow: none;
		transition: 500ms all;
		padding-bottom: 0;
		margin-bottom: 30px;
	}
	.whmpress.whmpress_pricing_table.whmpress-14:hover {
		box-shadow: 0px 0px 39px -5px rgb(184, 197, 206);
	}
	.whmpress.whmpress_pricing_table.whmpress-14 .pricing_table_heading .holder h2{
		font-size: 22px;
		font-weight: bold;
		color: #38434a;
		text-transform: uppercase;
	}
	.whmpress.whmpress_pricing_table.whmpress-14 .pricing_table_detail{
		display: block;
		height: 0;
		width: 30px;
		border-top: 2px solid #475b69;
		margin: auto;
		margin-top: -12px;
		padding:0;
		transition: 500ms all;
	}
	.whmpress.whmpress_pricing_table.whmpress-14 .pricing_table_detail.details {
		display: none;
		visibility: hidden;
	}
	.whmpress.whmpress_pricing_table.whmpress-14:hover .pricing_table_detail{
		width: 80px;
	}
	.whmpress.whmpress_pricing_table.whmpress-14 .pricing_table_price .holder {
		font-size: 45px;
		color: #81d28d;
	}
	.whmpress.whmpress_pricing_table.whmpress-14 .pricing_table_price{
		margin: 30px 0;
		padding-bottom: 15px;
		margin-bottom: 15px;
		border-bottom: 1px solid #f2f8fc;
	}

	.whmpress.whmpress_pricing_table.whmpress-14 .pricing_table_price .holder .currency,
	.whmpress.whmpress_pricing_table.whmpress-14 .pricing_table_price .holder .duration{
		font-weight: bold;
		color: #beefc6;
		font-size: 20px;
	}

	.whmpress.whmpress_pricing_table.whmpress-14 .pricing_table_features .holder ul{
		border:none;
		padding:0;
		margin-top: 35px;
		margin-bottom:10px;
	}

	.whmpress.whmpress_pricing_table.whmpress-14 .pricing_table_features .holder ul li{
		font-weight: 100;
		font-size: 16px;
		background: rgba(242, 248, 252, 0.48);
		padding: 5px;
		border-radius: 6px;
		border: 1px solid rgba(239, 241, 243, 0.39);
		margin-bottom: 8px;
		color: black;
	}

	#{$random_id} .pricing_table_features .holder ul li i{
		background: {$primary_color};
		float: left;
		padding: 7px 7px;
		margin-top: -5px;
		border-radius: 4px 0 0 4px;
		margin-left: -5px;
		font-size: 18px;
		color: #fff;
		width: 38px;
	}
	.whmpress.whmpress_pricing_table.whmpress-14.featured {
		transform: scaleY(1.05);
		box-shadow: 0px 0px 39px -5px rgb(184, 197, 206);
	}
</style>



<div class="whmpress whmpress_pricing_table whmpress-14 {$featured}" id="{$random_id}">
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
	<div class="pricing_table_detail details">
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
