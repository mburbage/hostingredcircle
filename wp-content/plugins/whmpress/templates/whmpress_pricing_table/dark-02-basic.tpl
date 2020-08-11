
<div class="whmpress whmpress_pricing_table dark-02 {$featured}" id="{$random_id}">
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
            background: none;
        }


		.whmpress.whmpress_pricing_table.dark-02 {
			box-shadow: none;
			border: solid 1px #CBFFC8;
			border-radius: 0;
			background-color: transparent;
			padding-top: 0;
			padding-bottom: 0;
			margin-top:20px;
			margin-bottom:20px;
		}
		.whmpress.whmpress_pricing_table.dark-02 .pricing_table_heading .holder h2 {
			font-size: 32px;
			color: white;
			font-weight: 700;
			padding-top: 30px;
		}
		.whmpress.whmpress_pricing_table.dark-02 .pricing_table_detail.details {
			display: none;
		}
		.whmpress.whmpress_pricing_table.dark-02 .pricing_table_price {
			background-color: #eac36e;
			padding: 18px 0px;
			width: 102px;
			margin: auto;
			border-radius: 63px;
			height: 96px;
			line-height: 60px;
			margin: 34px 96px;
		}
		.whmpress.whmpress_pricing_table.dark-02 .holder.holder1 {
			font-size: 23px;
			font-weight: 700;
			color: white;
		}
		.whmpress.whmpress_pricing_table.dark-02 .duration {
			display: none;
		}
		.whmpress.whmpress_pricing_table.dark-02 .pricing_table_detail .holder.holder2 {
			font-size: 16px;
			font-weight: 700;
			color: white;
		}
		.whmpress.whmpress_pricing_table.dark-02 .pricing_table_features .holder ul {
			border: none;
			padding-top: 14px;
			color: white;
		}
		.whmpress.whmpress_pricing_table.dark-02 .pricing_table_features .holder ul li {
			border: none;
			font-size: 16px;
			font-weight: 400;
			color:white;
			padding-bottom: 0;
		}
		.whmpress.whmpress_pricing_table.dark-02 .pricing_table_combo button {
			font-weight: bold;
			margin-top: 62px;
			padding: 0.75em 2em;
			opacity: 0;
			color: #fff;
		-webkit-transition: -webkit-transform 0.3s, opacity 0.3s;
			transition: transform 0.3s, opacity 0.3s;
			-webkit-transform: translate3d(0, -15px, 0);
			transform: translate3d(0, -15px, 0);
			width: 210px;
		}
		.whmpress.whmpress_pricing_table.dark-02:hover {
			background-color: #CBFFC8;
			color:black;
			transition: 0.7s;
		}
		.whmpress.whmpress_pricing_table.dark-02:hover .pricing_table_heading .holder h2 {
			color: #444444;
		}
		.whmpress.whmpress_pricing_table.dark-02:hover .pricing_table_price {
			background-color: #82C57E;
		}
		.whmpress.whmpress_pricing_table.dark-02:hover .pricing_table_features .holder ul li {
			color: #444444;
		}
		.whmpress.whmpress_pricing_table.dark-02:hover .pricing_table_detail .holder.holder2 {
			color: #444444;
		}
		.whmpress.whmpress_pricing_table.dark-02:hover  .pricing_table_combo button {
			background-color: #6EA76B;
			opacity: 1;
		}
		.whmpress.whmpress_pricing_table.dark-02.featured .pricing_table_price {
			background-color: #E57270;
		}
		.whmpress.whmpress_pricing_table.dark-02.featured:hover .pricing_table_price {
			background-color: #82C57E;
		}


	</style>
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
		<div class="holder holder1">
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
		<div class="holder holder2">
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
				<li class="{if {$desc.tooltip_text} eq 'yes' }whmpress_has_tooltip{/if}"><span class="whmpress_description_title">{if {$desc.icon_class} ne 'yes' || {$desc.icon_class} eq ''}<i class="--replace here--"></i>{/if}{$desc.feature_title}{if {$desc.tooltip_text} eq 'yes' and {$desc.tooltip_text} ne '' }<span class="whmpress_tooltip">{$desc.tooltip_text}</span>{/if}{if {$desc.feature_value} ne "" }:{/if}</span><span class="whmpress_description_value">{$desc.feature_value}</span>
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
