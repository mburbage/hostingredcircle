
{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#DEE2EF'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#3BA9D8'}
{/if}


<style>
	#{$random_id} {
		box-shadow: none;
		border: solid 1px {$primary_color};
		border-radius: 15px;
		padding-top: 0;
		padding-bottom: 0;
		margin-bottom:20px;
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
		width: 100px;
		background-color: white;
		color: #00aeda;
		font-size: 16px;
		font-weight: 400;
		border: solid 1px #3BA9D8;
		border-radius: 8px
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
		background-color: rgba(0,174,218,.1);
		color: #00aeda;
		border-color: #adadad;
	}




	.whmpress.whmpress_pricing_table.whmpress-18 .pricing_table_heading .holder h2 {
		font-size: 16px;
		font-weight: 400;
		color: #364656;
		padding-top: 50px;
	}
	#{$random_id} .pricing_table_heading .holder h2 i.fa.fa.fa-thumbs-o-up {
		position: absolute;
		top: -34px;
		margin-left: 7px;
		background-color: {$secondary_color};
		height: 60px;
		font-size: 32px;
		width: 60px;
		padding: 14px 0;
		border-radius: 38px;
		color: white;
	}
	.whmpress.whmpress_pricing_table.whmpress-18 .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.whmpress-18 .pricing_table_price .holder .duration {
		display: block;
		font-size: 16px;
		color: #6c848f;
		font-weight: 300;
	}
	.whmpress.whmpress_pricing_table.whmpress-18 .pricing_table_price .holder .fraction {
		display: inline;
	}
	.whmpress.whmpress_pricing_table.whmpress-18 .pricing_table_price .holder {
		font-size: 32px;
		font-weight: 500;
		color: #364656;
		padding-top: 26px;
	}
	.whmpress.whmpress_pricing_table.whmpress-18 .pricing_table_detail {
		padding-top: 0;
	}
	.whmpress.whmpress_pricing_table.whmpress-18 .pricing_table_detail .holder {
		font-size: 16px;
		color: #6c848f;
		font-weight: 100;
	}
	.whmpress.whmpress_pricing_table.whmpress-18 .pricing_table_features .holder ul {
		border: none;
	}
	.whmpress.whmpress_pricing_table.whmpress-18 .pricing_table_features .holder ul li {
		border: none;
		padding-top: 0px;
		font-size: 16px;
		font-weight: 100;
		color: #6c848f;
	}
	#{$random_id} .pricing_table_features .holder ul li .whmpress_description_value {
		color: {$secondary_color};
	}
	#{$random_id}.featured {
		border: solid 2px {$secondary_color};
		box-shadow: 0 0 35px 0 lightgray;
		transform: scaleY(1.05);
	}
	.whmpress.whmpress_pricing_table.whmpress-18 .pricing_table_price .holder .currency {
		padding-right: 8px;
	}
</style>



<div class="whmpress whmpress_pricing_table whmpress-18 {$featured}" id="{$random_id}">
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