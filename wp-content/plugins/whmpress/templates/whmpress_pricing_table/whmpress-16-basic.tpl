{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='##43Ac6A'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#c83600'}
{/if}


<style>
	#{$random_id} {

	}
	#{$random_id}:before {
		border-color: transparent transparent transparent transparent;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button,
	#{$random_id} .pricing_table_combo a,
	#{$random_id} .pricing_table_combo button,
	#{$random_id} .pricing_table_submit .whmpress_order_button,
	#{$random_id} .pricing_table_submit a,
	#{$random_id} .pricing_table_submit button {
	background: #fb4400;
	width: 170px;
	padding: 8px 8px;
	border-radius: 25px;
	color: white;
	border: solid 2px #f79468;
	margin-top: 18px;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
	background: #c83600;
	color: white;
	transition: 0s;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	}


	.whmpress.whmpress_pricing_table.whmpress-16 {
		box-shadow: none;
		border-radius: 4px;
		border: solid 1px #B7C1C6;
		padding-bottom: 0;
		margin-top:20px;
		margin-bottom:20px;
	}
	.whmpress.whmpress_pricing_table.whmpress-16 h2 {
		font-size: 36px;
		color: #66757f;
		font-weight: 300;
	}
	.whmpress.whmpress_pricing_table.whmpress-16 .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.whmpress-16 .pricing_table_detail {
		font-size: 14px;
		color: #66757f;
		padding-top: 12px;
		padding-bottom: 7px;
	}
	.whmpress.whmpress_pricing_table.whmpress-16 .currency {
		font-size: 28px;
		color: #66757f;
		padding-right: 4px;
	}
	.whmpress.whmpress_pricing_table.whmpress-16 .amount {
		font-size: 28px;
		color: #66757f;
	}
	.whmpress.whmpress_pricing_table.whmpress-16 .decimal {
		font-size: 28px;
		color: #66757f;
	}
	.whmpress.whmpress_pricing_table.whmpress-16 .fraction {
		font-size: 28px;
		color: #66757f;
	}
	.whmpress.whmpress_pricing_table.whmpress-16 .duration {
		font-size: 28px;
		color: #66757f;
	}
	.whmpress.whmpress_pricing_table.whmpress-16 ul {
		border: none;
		margin-top: 0;
	}
	.whmpress.whmpress_pricing_table.whmpress-16 ul li {
		border: none;
		padding-bottom: 8px;
		text-align: left;
		padding-left: 38px;
	}
	.whmpress.whmpress_pricing_table.whmpress-16 i {
		color: #43Ac6A;
		font-size: 20px;
	}
	.whmpress.whmpress_pricing_table.whmpress-16.featured {
		background-color: #37778f;
		transform: scaleY(1.05);
	}
	.whmpress.whmpress_pricing_table.whmpress-16.featured h2 {
		color: white;
	}
	.whmpress.whmpress_pricing_table.whmpress-16.featured .pricing_table_detail {
		color: white;
	}
	.whmpress.whmpress_pricing_table.whmpress-16.featured .pricing_table_price .currency{
		color: white;
	}
	.whmpress.whmpress_pricing_table.whmpress-16.featured .pricing_table_price .amount{
		color:white;
	}
	.whmpress.whmpress_pricing_table.whmpress-16.featured .pricing_table_price .decimal{
		color:white;
	}
	.whmpress.whmpress_pricing_table.whmpress-16.featured .pricing_table_price .fraction{
		color:white;
	}
	.whmpress.whmpress_pricing_table.whmpress-16.featured .pricing_table_price .duration{
		color:white;
	}
	.whmpress.whmpress_pricing_table.whmpress-16.featured ul li {
		color: white;
	}
	.whmpress.whmpress_pricing_table.whmpress-16.featured .pricing_table_combo button {
		color: white;
		border: solid 2px #F49A3B;
	}
	.whmpress.whmpress_pricing_table.whmpress-16.featured .pricing_table_combo button:hover {
		color: white;
		border: solid 2px #FBBB78;
	}
</style>


<div class="whmpress whmpress_pricing_table whmpress-16 {$featured}" id="{$random_id}">
	<div class="pricing_table_heading">
		<div class="holder">
			<h2><i class="fa {$sub_icon}"></i> {$product_name}</h2>
		</div>
	</div>
	<div class="pricing_table_detail details">
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
