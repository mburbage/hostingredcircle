{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#F1F1F1'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#0171bc'}
{/if}


<style>
	#{$random_id} {
		box-shadow: none;
		padding-top: 0;
		border: solid 1px #D3D3D3;
		border-radius: 7px;
		padding-bottom: 14px;
		background-color: {$primary_color};
		margin-top:20px;
		margin-bottom:20px;
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_submit button {
	background: #ffcb08;
	border: 1px solid #815627;
	box-shadow: 0 3px 0 #815627, 0 6px 4px -2px rgba(0,0,0,0.3);
	color: #333333;
	font-weight: 800;
	font-size: 24px;
	}
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_submit button {
	background: #ffd43d;
	transition: 0.2s;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
		background: none;
	}

	.whmpress.whmpress_pricing_table.retro-02 h2 {
		font-size: 28px;
		font-weight: 800;
		padding-top: 20px;
		padding-bottom: 16px;
		color: white;
	}
	#{$random_id} .pricing_table_heading .holder {
		background-color: {$secondary_color};
		border: solid 1px #0171bc;
		border-top-left-radius: 5px;
		border-top-right-radius: 5px;
	}
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_detail {
		font-size: 18px;
		font-weight: 300;
		color: white;
		background-color: #005793;
		padding: 5px 0;
	}
	.whmpress.whmpress_pricing_table.retro-02 ul {
		border: none;
		text-align: left;
		padding-left: 12px;
	}
	.whmpress.whmpress_pricing_table.retro-02 ul li {
		border: none;
		font-size: 13px;
		color: #666666;
	}
	.whmpress.whmpress_pricing_table.retro-02 i.fa.fa-circle {
		font-size: 8px;
		color: #d05b00;
		margin-right: 2px;
	}
	.whmpress.whmpress_pricing_table.retro-02 span.whmpress_description_title {
		color: #d05b00;
		padding-right: 1px;
	}
	.whmpress.whmpress_pricing_table.retro-02 .pricing_table_price .holder {
		font-size: 21px;
		font-weight: 800;
		color: #d05b00;
		padding: 16px 0;
	}

	.whmpress.whmpress_pricing_table.retro-02.featured {
		-webkit-transform: scaleY(1.05);
		transform: scaleY(1.05);
	}

</style>





<div class="whmpress whmpress_pricing_table retro-02 {$featured}" id="{$random_id}">
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
                             <i class="fa fa-circle"></i>
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
