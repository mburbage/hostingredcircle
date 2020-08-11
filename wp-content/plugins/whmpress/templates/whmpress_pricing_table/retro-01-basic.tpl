{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#202b34'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#e8e9ea'}
{/if}

<style>
	#{$random_id} {
	background: {$secondary_color};
	box-shadow: none;
	border-radius: 0;
	padding: 0;
	transition: 500ms;
	border: none;
	margin-top: 71px;
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_submit button {
		padding: 20px 35px;
		width: 100%;
		background: #02A3C8;
		font-size: 18px;
		border: 1px solid transparent;
		transition: 500ms;
		border-radius: 0;
	}
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_submit button {
		background-color: #414141;
		border-color:#2cc76a;
	}



	.whmpress.whmpress_pricing_table.retro-01:hover {
		transform: scale(1.1);
	}
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_price .holder{
		background: #02A3C8;
		padding: 5px;
		color: #FFF;
		font-size: 30px;
		border-radius: 100%;
		display: block;
		width: 120px;
		height: 120px;
		margin: 0 auto;
		position: absolute;
		margin-top: -68px;
		line-height: 107px;
		margin-bottom: 10px !important;
		top: 0;
		left: 94px;
	}
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_price .holder .decimal,
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_price .holder .fraction,
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_price .holder .duration{
		display:none;
	}
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_detail {
		padding:0;
		color: #999;
		font-size: 14px;

	}
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_heading .holder h2{
		color: #FFF;
		text-align: center;
		padding: 0;
		margin: 0;
		text-transform: uppercase;
		font-size: 24px;
		font-weight: 700;
	}
	#{$random_id} .whmpress-table-box {
		position: relative;
		background: {$primary_color};
		padding-top: 60px;
		padding-bottom: 10px;
		text-align: center;
	}
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_features .holder ul{
		color:#70747a;
		font-size:14px;
		border-top:none;
		font-weight: 400;
	}
	.whmpress.whmpress_pricing_table.retro-01 .pricing_table_features .holder ul li{
		border:none;
		padding: 13px 0;
		color: #70747a;
	}



	.whmpress.whmpress_pricing_table.retro-01 .whmpress.whmpress_order_combo {
		padding-bottom:0;
	}

	.whmpress.whmpress_pricing_table.retro-01.featured {
		transform: scale(1);
	}
	.whmpress.whmpress_pricing_table.retro-01.featured:hover {
		transform: scale(1.1);
	}
	.whmpress.whmpress_pricing_table.retro-01.featured .pricing_table_price .holder{
		background-color:#2cc76a;
	}
	.whmpress.whmpress_pricing_table.retro-01.featured .whmpress.whmpress_order_combo button{
		background-color:#2cc76a;
	}
	.whmpress.whmpress_pricing_table.retro-01.featured .whmpress.whmpress_order_combo button:hover{
		background-color: #414141;
		border-color:#ac2925;
	}

</style>


<div class="whmpress whmpress_pricing_table retro-01 {$featured}" id="{$random_id}">
	<div class="whmpress-table-box">
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