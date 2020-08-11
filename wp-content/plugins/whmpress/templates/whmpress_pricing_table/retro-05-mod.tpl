{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#F4F4F4'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#7786A0'}
{/if}


<style>
	#{$random_id} .main {
	background-color: {$primary_color};
	box-shadow: 0 3px 8px 0 #EBEBEB;
	padding-bottom: 12px;
	border-bottom: solid 1px #CBCBCB;
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_submit button {
		background: #ef663c;
		border-radius: 5px;
		margin-top: 20px;
		font-size: 14px;
		font-weight: 700;
		width: 225px;
		padding: 12px 0;
	}
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_submit button {
		background: #f58058;
		color: white;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
		background: none;
	}


	.whmpress.whmpress_pricing_table.retro-05 {
		padding-top: 0;
		box-shadow: none;
		border: solid 1px #E1E1E1;
		border-radius: 6px;
		margin-top:20px;
		margin-bottom:20px;
	}
	.whmpress.whmpress_pricing_table.retro-05 i.fa.fa-home {
		font-size: 32px;
		border: solid 1px #4B9F34;
		border-radius: 22px;
		height: 44px;
		width: 44px;
		line-height: 41px;
		background-color: #4B9F34;
		color: white;
	}
	.whmpress.whmpress_pricing_table.retro-05 .icon {
		padding-top: 25px;
		padding-bottom: 10px;
	}
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.retro-05 h2 {
		font-size: 26px;
		font-weight: 700;
		color: #333333;
	}
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_detail {
		padding-top: 3px;
		font-size: 14px;
		color: #666666;
		font-weight: 400;
	}
	.whmpress.whmpress_pricing_table.retro-05 .pricing_table_price .holder {
		font-size: 26px;
		font-weight: 700;
		color: #59a345;
		padding-bottom: 5px;
		padding-top: 12px;
		border-bottom: solid 1px #CBCBCB;
		width: 270px;
		margin: auto;
	}
	.whmpress.whmpress_pricing_table.retro-05 ul {
		border: none;
		text-align: left;
		margin-top: 0;
	}
	.whmpress.whmpress_pricing_table.retro-05 ul li {
		border: none;
		font-size: 14px;
		color: #666666;
		font-weight: 400;
	}
	#{$random_id} i.fa.fa-check-square {
		color: {$secondary_color};
		font-size: 15px;
		padding-right: 4PX;
	}

	.whmpress.whmpress_pricing_table.retro-05.featured {
		-webkit-transform: scaleY(1.05);
		transform: scaleY(1.05);
	}
</style>

<div class="whmpress whmpress_pricing_table retro-05 {$featured}" id="{$random_id}">
	<div class="main">
		<div class="icon">
   <span class="green">
      <i class="fa {$sub_icon}" aria-hidden="true"></i>
   </span>
		</div>
	<div class="pricing_table_heading">
		<div class="holder">
			<h2>{$product_name}</h2>
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
                    <span class="whmpress_description_title">
                        {if $show_description_icon eq 'yes' and $desc.icon_class ne ''}
                            <i class="{$desc.icon_class}"></i>
                        {/if}
						{if $desc.icon_class ne 'yes' || $desc.icon_class eq ''}
                            <i class="fa fa-check-square"></i>
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

</div>  <!-- /.price-table -->