{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#493e5e'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#eaeaea'}
{/if}

<style>
	#{$random_id} {
		box-shadow: none;
		border: 1px solid {$primary_color};
		border-radius: 0;
		padding: 0;
		margin-top:20px;
		margin-bottom: 30px;
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_submit button {
		background: #493e5e;
		background: -moz-linear-gradient(45deg, #493e5e 0%, #5b366e 100%);
		background: -webkit-linear-gradient(45deg, #493e5e 0%, #5b366e 100%);
		background: linear-gradient(45deg, #493e5e 0%, #5b366e 100%);
		padding: 15px 25px;
		font-size: 16px;
		font-weight: normal;
		border-radius: 50px;
		display: inline-block;
		width: 50%;
		transition: border .25s linear, color .25s linear, background-color .25s linear;
	}
	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_submit button {
		opacity: .8;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(even) {
	background: {$secondary_color};
	}






	#{$random_id} .whmpress-table-box{
		color: #fff;
		background: {$primary_color};
	}
	.whmpress.whmpress_pricing_table.retro-04  .pricing_table_heading .holder h2{
		text-transform: uppercase;
		padding: 15px 0;
		background: rgba(0,0,0,0.2);
		font-size: 17px;
	}

	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_detail.pricing_table_detail-2{
		display:none;
	}

	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_price .holder{
		font-size: 65px;
	}

	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_price .holder .duration{
		font-size: 25px;
	}

	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_detail .holder {
		background: rgba(255,255,255,0.1);
		font-weight: 700;
		border-radius: 5px;
		padding: 5px 15px;
		display: inline-block;
	}

	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_features .holder ul{
		border:none;
		margin: 0;
		padding: 0;
	}
	.whmpress.whmpress_pricing_table.retro-04 .pricing_table_features .holder ul li{
		padding: 8px;
		border:none;
		color: #333333;
	}
	.whmpress.whmpress_pricing_table.retro-04 .whmpress.whmpress_order_combo button{

	}

	.whmpress.whmpress_pricing_table.retro-04 .whmpress.whmpress_order_combo button:hover{

	}
	#{$random_id}.featured .whmpress-table-box{
		background: #2fc19a;
	}

	#{$random_id}.featured {
		transform: scaleY(1);
		border-color: #2fc19a;
	}

	.whmpress.whmpress_pricing_table.retro-04.featured .whmpress.whmpress_order_combo button{
		background: #2fc19a;
		background: -moz-linear-gradient(45deg, #2fc19a 0%, #79db45 100%);
		background: -webkit-linear-gradient(45deg, #2fc19a 0%, #79db45 100%);
		background: linear-gradient(45deg, #2fc19a 0%, #79db45 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2fc19a', endColorstr='#79db45',GradientType=1 );
	}
	.whmpress.whmpress_pricing_table.retro-04.featured .whmpress.whmpress_order_combo button:hover{
		opacity: .8;
	}
</style>
<div class="whmpress whmpress_pricing_table retro-04 {$featured}" id="{$random_id}">
	<div class="whmpress-table-box">
		<div class="pricing_table_heading">
			<div class="holder">
				<h2><i class="fa {$sub_icon}"></i> {$product_name}</h2>
			</div>
		</div>
		<div class="pricing_table_detail pricing_table_detail-2">
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
	</div>
	{if $process_description|lower eq "yes"}
	<div class="pricing_table_features">
		<div class="holder">
			<ul>
				{foreach $split_description as $desc}

				<li class="{if {$show_description_tooltip} eq 'yes' }whmpress_has_tooltip{/if}">

					<!-- a. Description Key Span -->
					<span class="whmpress_description_title">

						<!--  1. Icon -->
						{* ---code start for icon--- *}
                        {if {$show_description_icon} eq 'yes' and {$desc.icon_class} ne ''}
                            <i class="{$desc.icon_class}"></i>
                        {/if}

						{if {$show_description_icon} ne 'yes'}
                            <i class="--replace here--"></i>
                        {/if}
						{* ---code ends for icon--- *}

						<!-- 2. description key -->
						{$desc.feature_title}

						<!-- 3. Tooltip -->
                        {if {$show_description_tooltip} eq 'yes' and {$desc.tooltip_text} ne '' }
                            <span class="whmpress_tooltip">{$desc.tooltip_text}</span>
                        {/if}

						<!-- 4. description separator -->
						{if {$desc.feature_value} ne "" }: {/if}
                    </span>

					<!-- b. description value -->
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
