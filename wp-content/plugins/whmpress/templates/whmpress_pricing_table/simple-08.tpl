
{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#36d7ac'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#2be0b0'}
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
	background: {$primary_color};
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
	background: {$secondary_color};
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	}


	.whmpress.whmpress_pricing_table.simple-08 {
		box-shadow: none;
		border: solid 3px #EDEDEE;
		border-radius: 0;
		padding-top: 0;
		padding-bottom: 0;
		margin-bottom:20px;
	}
	.whmpress.whmpress_pricing_table.simple-08 .pricing_table_heading .holder h2 {
		font-size: 27px;
		color: white;
		padding-top: 12px;
		font-weight: 400;
		margin-bottom: 0;
	}
	.whmpress.whmpress_pricing_table.simple-08 .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.simple-08 .pricing_table_detail .holder {
		font-size: 14px;
		color: white;
		padding-top: 0px;
	}
	.whmpress_pricing_table .pricing_table_detail {
		padding-top: 6px;
	}
	#{$random_id} .main {
		background: {$primary_color};
		border-bottom: solid 1px #41b91c;
	}
	.whmpress.whmpress_pricing_table.simple-08 .pricing_table_price .holder{
		color: #B7C39E;
	}
	.whmpress.whmpress_pricing_table.simple-08 .pricing_table_price .holder .currency {
		font-size: 27px;
		padding-right: 2px;
		position: relative;
		bottom: 4px;
	}
	.whmpress.whmpress_pricing_table.simple-08 .pricing_table_price .holder .amount {
		font-size: 50px;
		font-weight: 500;
	}
	.whmpress.whmpress_pricing_table.simple-08 .pricing_table_price .holder .decimal {
		font-size: 24px;
		position: relative;
		bottom: 6px;
		padding-left: 1px;
	}
	.whmpress.whmpress_pricing_table.simple-08 .pricing_table_price .holder .fraction {
		font-size: 28px;
		position: relative;
		bottom: 5px;
		padding-left: 1px;
	}
	.whmpress.whmpress_pricing_table.simple-08 .pricing_table_price .holder .duration {
		display: block;
		margin-top: -10px;
		font-size: 18px;
	}
	.whmpress.whmpress_pricing_table.simple-08 .pricing_table_price {
		background-color: #FAFFF2;
		border-bottom: solid 1px #F4FAE7;
		padding-bottom: 12px;
	}
	.whmpress.whmpress_pricing_table.simple-08 .pricing_table_features .holder ul {
		border: none;
		padding-top: 0;
	}
	.whmpress.whmpress_pricing_table.simple-08 .pricing_table_features .holder ul li {
		font-size: 14px;
		text-align: left;
		width: 302px;
		margin-left: -16px;
		padding-left: 15px;
		border-bottom-color: #F4FAE7;
		padding-top: 8px;
		padding-bottom: 8px;
	}
	.whmpress.whmpress_pricing_table.simple-08 .whmpress.whmpress_order_combo button {
		width: 92px;
		max-width: none;
		margin-bottom: 6px;
	}
	.whmpress.whmpress_pricing_table.simple-08 .whmpress.whmpress_order_combo button:hover {
		transition: 0s;
	}
	#{$random_id}:hover {
		border: 3px solid {$primary_color};
	}
	#{$random_id}:hover .pricing_table_price .holder {
		color: {$primary_color};
	}
	#{$random_id}.featured {
		box-shadow: 8px 6px 6px 0 #DAF7EE;
		border: 3px solid {$primary_color};
	transform: scaleY(1.05);
	}
	#{$random_id}.featured .pricing_table_price .holder {
		color: {$primary_color};
	}
	#{$random_id}.featured{
		transform: scaleY(1.05);
	}
</style>



<div class="whmpress whmpress_pricing_table simple-08 {$featured}" id="{$random_id}">
	<div class="main">
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
