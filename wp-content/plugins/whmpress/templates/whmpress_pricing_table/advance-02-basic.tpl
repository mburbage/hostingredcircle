{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#f45e40'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#FBFBFB'}
{/if}


<style>
	#{$random_id} .pricing_table_detail .holder {
		font-size: 14px;
		font-weight: 400;
	color: {$primary_color};
	margin-top: -5px;
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_submit button {
		background-color: #EE6147;
		border: solid 2px #F17C67;
		border-radius: 0;
		width: 45%;
		padding: 6px 0;
		font-size: 13px;
		font-weight: 400;
	}
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_submit button {
		background-color: #F17C67;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	background: {$secondary_color};
	}






	.whmpress.whmpress_pricing_table.advance-02 {
		box-shadow: none;
		border: 1px solid #e4e4e4;
		border-radius: 0;
		padding: 0;
	}
	.whmpress.whmpress_pricing_table.advance-02 .baner {
		display: none;
	}
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_heading .holder h2 {
		font-size: 23px;
		font-weight: 700;
		color: #555555;
		margin-bottom: 0;
		padding-top: 15px;
	}
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_detail.deatails {
		display: none;
	}
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_price .holder .starting_text {
		display: block;
		font-size: 20px;
		font-weight: 400;
		color: #555555;
	}
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_price .holder .currency {
		font-size: 32px;
		font-weight: 400;
		color: #555555;
		padding-right: 1px;
		position: relative;
		bottom: 21px;
	}
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_price .holder .amount {
		font-size: 60px;
		font-weight: 400;
		color: #555555;
	}
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_price .holder .decimal, .whmpress.whmpress_pricing_table.advance-02 .pricing_table_price .holder .fraction {
		font-size: 32px;
		font-weight: 400;
		color: #555555;
		position: relative;
		bottom: 19px;
	}
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_price .holder .fraction {
		text-decoration: underline;
	}
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_price .holder .duration {
		font-size: 12px;
		font-weight: 400;
		color: #555555;
		position: relative;
		right: 32px;
	}
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_features .holder ul {
		border: none;
		padding: 0;
		margin: 0;
	}
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_features .holder ul li {
		padding: 10px 15px;
		line-height: 1.5em;
		text-align: center;
		border-top: solid #e4e4e4 1px;
		font-size: 13px;
		border-bottom: 0;
		font-weight: 400;
		color: #555555;
	}
	.whmpress.whmpress_pricing_table.advance-02 .pricing_table_features .holder ul li .whmpress_description_value {
		display: block;
	}

	.whmpress.whmpress_pricing_table.advance-02.featured {
		background-color: #F3FAFD;
		position: relative;
		overflow: hidden;
	}
	#{$random_id}.featured .pricing_table_features .holder ul li:nth-child(odd) {
		background-color: #EEF9FD;
	}
	.whmpress.whmpress_pricing_table.advance-02.featured .baner {
		position: absolute;
		top: 21px;
		right: -28px;
		width: 110px;
		z-index: 5;
		transform: rotate(50deg);
		background-color: #F9361F;
		color: #ffffff;
		display:block;
	}

</style>

<div class="whmpress whmpress_pricing_table advance-02 {$featured}" id="{$random_id}">
	<div class="baner">{$featured_text}</div>
	<div class="pricing_table_heading">
		<div class="holder">
			<h2><i class="fa {$sub_icon}"></i> {$product_name}</h2>
		</div>
	</div>
	<div class="pricing_table_detail deatails">
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
	<div class="pricing_table_price">
		<div class="holder">
			<span class="starting_text">{$custom_text_1}</span>
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