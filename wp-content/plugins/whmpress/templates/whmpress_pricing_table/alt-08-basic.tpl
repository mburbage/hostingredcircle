
{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#414452'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#88C943'}
{/if}



<style>
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}

	.whmpress.whmpress_pricing_table.alt-08 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-08 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.alt-08 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.alt-08 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-08 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.alt-08 .pricing_table_submit button {
		background: #414452;
		width: 244px;
	}
	.whmpress.whmpress_pricing_table.alt-08 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-08 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.alt-08 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.alt-08 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-08 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.alt-08 .pricing_table_submit button {
		background: #2e323d;
		transition: 0.7s;
	}
	.whmpress.whmpress_pricing_table.alt-08.featured .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-08.featured .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.alt-08.featured .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.alt-08.featured .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.alt-08.featured .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.alt-08.featured .pricing_table_submit button {
		background: #88C943;
		width: 244px;
	}
	.whmpress.whmpress_pricing_table.alt-08.featured .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-08.featured .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.alt-08.featured .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.alt-08.featured .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.alt-08.featured .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.alt-08.featured .pricing_table_submit button {
		background: #89c84a;
		transition: 0.7s;
	}

	::selection{
		background-color:#89C749;
	}
	#{$random_id}{
		box-shadow: none;
		border: none;
		border-top: solid 4px {$primary_color};
		border-radius: 6px;
		padding-top: 0;
		margin-top: 50px;
		margin-bottom:20px;
	}
	#{$random_id} h2 {
		font-size: 19px;
		font-weight: 500;
		color: {$primary_color};
		padding-top: 24px;
	}
	.whmpress.whmpress_pricing_table.alt-08 p {
		font-size: 16px;
		font-weight: 400;
		color: #6b6f78;
		margin-bottom: 0;
	}
	.whmpress.whmpress_pricing_table.alt-08 .decimal {
		/*display: none;*/
		color: {$secondary_color};

	}
	.whmpress.whmpress_pricing_table.alt-08 .fraction {
		/*display: none;*/
		color: {$secondary_color};
	}
	#{$random_id} .currency {
		font-size: 21px;
		padding-right: 7px;
		position: relative;
		bottom: 38px;
		color: {$primary_color};
		font-weight: 500;
	}
	#{$random_id} .amount {
		font-size: 72px;
		font-weight: 500;
		color: {$primary_color};
		margin-right: -6px;
	}
	.whmpress.whmpress_pricing_table.alt-08 .duration {
		font-size: 18px;
		font-weight: 500;
		color: #9da0a7;
	}
	#{$random_id} .pricing_table_detail.price1 {
		padding-top: 4px;
		color: #414452;
		font-size: 14px;
	}
	.whmpress.whmpress_pricing_table.alt-08 .pricing_table_combo {
		padding-top: 6px;
		padding-bottom: 6px;
	}
	.whmpress.whmpress_pricing_table.alt-08 ul {
		border: none;
		padding-bottom: 0;
		background-color: transparent;
	}
	.whmpress.whmpress_pricing_table.alt-08 ul li {
		font-size: 15px;
		font-weight: 500;
		color: #3d4351;
	}

	#{$random_id}.featured {
		border-top: solid 29px {$secondary_color};
		margin-top: 20px;
	}
	#{$random_id}.featured .amount {
	color:{$secondary_color};
	}
	#{$random_id}.featured .currency {
	color: {$secondary_color};
	}
	.whmpress.whmpress_pricing_table.alt-08 .main {
		border: solid 1px white;
		box-shadow: 0 0 20px 0 #ECEEF0;
		padding-bottom: 15px;
	}
	.whmpress.whmpress_pricing_table.alt-08.featured .top {
		position: relative;
		bottom: 26px;
		color: white;
		font-size: 14px;
		display:block;
		margin-bottom: -17px;
	}
	.whmpress.whmpress_pricing_table.alt-08 .top {
		display: none;
	}
</style>



<div class="whmpress whmpress_pricing_table alt-08 {$featured}" id="{$random_id}">
	<div class="main">
		<div class="top">{$featured_text}</div>
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
		<div class="pricing_table_detail price1">
		<div class="holder">
			{if $product_detail ne ""}
			{$product_detail}
			{elseif $product_tag_line ne ""}
			{$product_tag_line}
			{/if}
		</div>
	</div>
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
</div>  <!-- /.price-table -->