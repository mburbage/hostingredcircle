{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#FCFCFC'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#3CBFDF'}
{/if}





<style>
	#{$random_id} {
	background: {$primary_color};
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.icon .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.icon .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.icon .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.icon .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.icon .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.icon .pricing_table_submit button {
		width: 20%;
		padding: 7px 0;
		color: #3CBFDF;
		background: white;
		border: solid 1px #F5F5F5;
		border-radius: 45px;
		font-size: 15px;
	}
	.whmpress.whmpress_pricing_table.icon .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.icon .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.icon .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.icon .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.icon .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.icon .pricing_table_submit button {
		color: white;
		background: #3CBFDF;
	}
	.whmpress.whmpress_pricing_table.icon.featured .pricing_table_combo .holder button {
		background: #3CBFDF;
		color: white;
	}


	.whmpress.whmpress_pricing_table.icon {
		box-shadow: none;
		border: solid 1px #F0F0F0;
		padding: 0;
		border-radius: 6px;
	}
	#{$random_id} .pricing_table_heading .holder i.fa.fa.fa-cloud {
		padding: 20px 0;
		color: {$secondary_color};
		font-size: 32px;
		border: solid 2px #F8F8F8;
		background-color: white;
		width: 78px;
		border-radius: 37px;
		text-align: center;
		margin: 20px 0;

	}
	.whmpress.whmpress_pricing_table.icon .pricing_table_heading .holder h2 {
		font-size: 21px;
		margin-top: -7px;
		font-weight: 500;
		margin-bottom: 0;
	}
	.whmpress.whmpress_pricing_table.icon .pricing_table_detail {
		display: none;
	}
	.whmpress.whmpress_pricing_table.icon .pricing_table_features .holder ul {
		border: none;
		padding-top: 33px;
		margin: 0;
	}
	.whmpress.whmpress_pricing_table.icon .pricing_table_features .holder ul li {
		border: none;
		font-size: 14px;
		font-weight: 500;
		color: #181818;
		padding: 4px 0;
	}
	.whmpress.whmpress_pricing_table.icon .pricing_table_price .holder {
		font-size: 30px;
		font-weight: 700;
		padding: 8px 0;
	}
	.whmpress.whmpress_pricing_table.icon .pricing_table_price .holder .duration {
		font-size: 16px;
	}
	.whmpress.whmpress_pricing_table.icon .pricing_table_combo .holder select {
		width: 70%;
		border-radius: 0;
	}
	#{$random_id}.featured {
		border: solid 2px {$secondary_color};
		transform: scaleY(1.05);
	}
	#{$random_id}.featured .pricing_table_heading .holder i.fa.fa.fa-cloud {
		border-color: {$secondary_color};
	}


</style>

<div class="whmpress whmpress_pricing_table icon {$featured}" id="{$random_id}">
	<div class="pricing_table_heading">
		<div class="holder">
			<i class="fa {$sub_icon}"></i>
			<h2>{$product_name}</h2>
		</div>
	</div>
	<div class="pricing_table_detail">
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

</div>  <!-- /.price-table -->