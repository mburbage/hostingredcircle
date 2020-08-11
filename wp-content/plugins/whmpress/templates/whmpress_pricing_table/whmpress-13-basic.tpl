{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#53bce6'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#7ed321'}
{/if}

<style>
	#{$random_id} {
	background: {$primary_color};
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
		background: #53bce6;
		font-size: 14px;
		font-weight: 700;
		border-top-left-radius: 0;
		border-top-right-radius: 0;
		margin-bottom: 0;
		width: 100%;
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






	.whmpress.whmpress_pricing_table.whmpress-13 .pricing_table_heading .holder h2 {
		color: #666666;
		font-weight: bold;
		font-size: 16px;
		line-height: 16px;
		text-transform: uppercase;
		padding: 10px 0;
		background-color: #ffffff;
		border-bottom: 1px solid #dddddd;
		margin: -20px 0px;
		border-top-left-radius: 7px;
		border-top-right-radius: 7px;
	}
	.whmpress.whmpress_pricing_table.whmpress-13 {
		box-shadow: none;
		border: 1px solid #dddddd;
		border-radius: 7px;
		padding-bottom: 0;
		margin-bottom: 30px;
	}
	.whmpress.whmpress_pricing_table.whmpress-13 .pricing_table_price .holder{
		font-size: 35px;
		margin-bottom: 5px;
		color: white;
	}

	.whmpress.whmpress_pricing_table.whmpress-13 .pricing_table_features .holder{
		padding: 19px 0;
		background: white;
		text-align: left;
		padding-left: 56px;
		color: #7d7d7d;
	}
	.whmpress.whmpress_pricing_table.whmpress-13 .pricing_table_features .holder ul {
		border: none;
		padding: 0;
		margin: auto;
	}
	.whmpress.whmpress_pricing_table.whmpress-13 .pricing_table_features .holder ul li {
		padding: 2px 0;
		border: none;
	}
	#{$random_id} .pricing_table_features .holder i{
		color:{$secondary_color};
		margin-right: 13px;
	}

	.whmpress.whmpress_pricing_table.whmpress-13 .pricing_table_combo .holder{
		background:white;
	}
	.whmpress.whmpress_pricing_table.whmpress-13 .whmpress.whmpress_order_combo{
		padding-bottom: 0;
	}
	.whmpress.whmpress_pricing_table.whmpress-13 .pricing_table_detail.detail-1 .holder{
		padding: 0;
	}
	.whmpress.whmpress_pricing_table.whmpress-13 .pricing_table_detail .holder{
		color:white;
		padding-bottom: 20px;
		font-size: 14px;
	}
	.whmpress.whmpress_pricing_table.whmpress-13 .pricing_table_detail {
		font-size: 18px;
	}
	.whmpress.whmpress_pricing_table.whmpress-13 .pricing_table_features div {
		color: #7b7b7b;
	}
	.whmpress.whmpress_pricing_table.whmpress-13.featured{
		transform: scaleY(1.05);
	}

</style>


<div class="whmpress whmpress_pricing_table whmpress-13 {$featured}" id="{$random_id}">
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
