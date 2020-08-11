
{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#515a5f'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#f2c900'}
{/if}



<style>
	#{$random_id} {
		text-align: left;
		border: 1px solid #F5F5F5;
		background-color: #F5F5F5;
		border-top: 3px solid;
		padding: 30px 15px;
		margin: 15px auto;
		box-shadow: none;
		border-radius: 5px;
		padding-bottom: 0;
		border-top-color: {$primary_color};
	}
	#{$random_id}.featured {
	border-top-color: {$secondary_color};
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
		padding: 15px 0;
		background: #515a5f;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
	background: #f2c900;
	}

	#{$random_id}.featured .pricing_table_combo .whmpress_order_button,
	#{$random_id}.featured .pricing_table_combo a,
	#{$random_id}.featured .pricing_table_combo button,
	#{$random_id}.featured .pricing_table_submit .whmpress_order_button,
	#{$random_id}.featured .pricing_table_submit a,
	#{$random_id}.featured .pricing_table_submit button {
		padding: 15px 0;
	background: #f2c900;
	}
	#{$random_id}.featured .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id}.featured .pricing_table_combo a:hover,
	#{$random_id}.featured .pricing_table_combo button:hover,
	#{$random_id}.featured .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id}.featured .pricing_table_submit a:hover,
	#{$random_id}.featured .pricing_table_submit button {
	background: #515a5f;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	}
	.whmpress.whmpress_pricing_table.eleven .holder h2 {
		font-size: 14px;
		font-weight: 500;
		padding-bottom: 14px;
		margin-bottom: 15px;
		border-bottom: 3px solid rgba(139, 144, 157, 0.18);
	}
	.whmpress.whmpress_pricing_table.eleven .pricing_table_price span.amount,
	.whmpress.whmpress_pricing_table.eleven.pricing_table_price span.decimal,
	.whmpress.whmpress_pricing_table.eleven .pricing_table_price span.fraction{
		width: 100%;
		font-size: 42px;
		font-weight: bold;
		color: #515a5f;
	}
	.whmpress.whmpress_pricing_table.eleven .pricing_table_price span.currency{
		font-size: 12px;
		position: relative;
		bottom: 17px;
		padding-right: 10px;
	}
	.whmpress.whmpress_pricing_table.eleven .pricing_table_detail .holder {
		padding: 0 0 0.5em;
		color: #9CA0A9;
		border-bottom: 3px solid rgba(139, 144, 157, 0.18);
	}
	.whmpress.whmpress_pricing_table.eleven .pricing_table_detail.detail-2{
		display:none;
	}
	#{$random_id} .pricing_table_features .holder ul li i {
		display: inline-block;
		vertical-align: middle;
		margin-right:10px;
		color: {$secondary_color};
	}
	.whmpress.whmpress_pricing_table.eleven .pricing_table_features .holder ul li {
		border: none;
		color:#9CA0A9;
	}
	.whmpress.whmpress_pricing_table.eleven .pricing_table_features .holder ul  {
		border: none;
	}
	.whmpress.whmpress_pricing_table.eleven {
		float: left;
		margin: 0 4px;
	}


	.whmpress.whmpress_pricing_table.eleven.featured {
		transform: scaleY(1.05);
	}
	#{$random_id}.featured .pricing_table_features .holder ul li i {
		display: inline-block;
		margin-right: 10px;
		vertical-align: middle;
		color: {$primary_color};
	}

	#{$random_id}.featured .pricing_table_combo .holder button {
		transition: 1s;
	}

</style>

<div class="whmpress whmpress_pricing_table eleven {$featured}" id="{$random_id}">
	<div class="pricing_table_heading">
		<div class="holder">
			<h2><i class="fa {$sub_icon}"></i> {$product_name}</h2>
		</div>
	</div>
	<div class="pricing_table_detail detail-2">
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
						{if $desc.icon_class ne 'yes' || $desc.icon_class eq ''}
                            <i class="fa fa-check"></i>
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