
<div class="whmpress whmpress_pricing_table dark-01 {$featured}" id="{$random_id}">
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
            background: {$secondary_color};
        }




		.whmpress.whmpress_pricing_table.dark-01 {
			margin: 1em .5em 1.625em;
			padding: .25em 0 2em;
			background: #0F1012;
			font-family: 'Open Sans', sans-serif;
			font-weight: 400;
			line-height: 1.625;
			color: #f9f9f9;
			text-align: center;
			box-shadow: none;
			border-radius: 0;
			padding-bottom: 0;
			margin-bottom: 30px;
		}

		.whmpress.whmpress_pricing_table.dark-01 .pricing_table_heading .holder h2{
			margin: .25em 0 0;
			font-size: 170%;
			font-weight: normal;
		}
		.whmpress.whmpress_pricing_table.dark-01 .pricing_table_detail .holder {
			color: #f9f9f9;
			padding-top: 12px;
		}
		.whmpress_pricing_table.dark-01 .pricing_table_detail {
			padding-bottom: 10px;
		}
		.whmpress.whmpress_pricing_table.dark-01 .pricing_table_price .holder{
			padding: .25em 0;
			background: #292b2e;
			font-size: 250%;
			color: #f9f9f9;
			margin: -10px -5px 0 -5px;
		}
		.whmpress.whmpress_pricing_table.dark-01 .pricing_table_price .holder span.decimal,
		.whmpress.whmpress_pricing_table.dark-01 .pricing_table_price .holder span.fraction,
		.whmpress.whmpress_pricing_table.dark-01 .pricing_table_price .holder span.duration{
			display:none;
		}
		.whmpress.whmpress_pricing_table.dark-01 .pricing_table_features .holder ul{
			border:none;
			color: #999999;
		}
		.whmpress.whmpress_pricing_table.dark-01 .pricing_table_features .holder ul li{
			border:none;
		}
		.whmpress.whmpress_pricing_table.dark-01 .whmpress.whmpress_order_combo button{
			padding: 1em 3.25em;
			border: none;
			border-radius: 40px;
			background: #292b2e;
			color: #f9f9f9;
			cursor: pointer;
		}
		.whmpress.whmpress_pricing_table.dark-01 .whmpress.whmpress_order_combo button:hover{
			background: #27282b;
		}
		.whmpress.whmpress_pricing_table.dark-01.featured .whmpress.whmpress_order_combo button{
			background: #64AAA4;
		}
		.whmpress.whmpress_pricing_table.dark-01.featured .whmpress.whmpress_order_combo button:hover{
			background: #4e8d88;
		}
		.whmpress.whmpress_pricing_table.dark-01.featured .pricing_table_price .holder {
			color: #64AAA4;
		}

	</style>
	<div class="pricing_table_heading">
		<div class="holder">
			<h2><i class="fa {$sub_icon}"></i> {$product_name}</h2>
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
	{if $process_description|lower eq "yes"}
	<div class="pricing_table_features">
		<div class="holder">
			<ul>
				{foreach $split_description as $desc}
				<li class="{if {$desc.tooltip_text} eq 'yes' }whmpress_has_tooltip{/if}">
                    <span class="whmpress_description_title">
                        {if {$desc.icon_class} eq 'yes' and {$desc.icon_class} ne ''}
                        {/if}

						{if {$desc.icon_class} ne 'yes' || {$desc.icon_class} eq ''}
                            <i class="--replace here--"></i>
                        {/if}

						{$desc.feature_title}
                        {if {$desc.tooltip_text} eq 'yes' and {$desc.tooltip_text} ne '' }
                            <span class="whmpress_tooltip">{$desc.tooltip_text}</span>
                        {/if}
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
