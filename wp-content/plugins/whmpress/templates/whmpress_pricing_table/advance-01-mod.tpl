
{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#2A363F'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#E66D00'}
{/if}
<style>
	#{$random_id} .main {
	background-color: {$primary_color};
	color: white;
	padding: 20px 0;
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_submit button {
		width: 44%;
		padding: 10px 0;
		background-color: #DF701D;
		font-size: 13px;
		font-weight: 400;
	}
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_submit button {
		background-color: #ca671d;
		transition: 0.2s;
	}



	.whmpress.whmpress_pricing_table.advance-01 {
		box-shadow: none;
		border: solid 1px #F4F4F5;
		border-radius: 0;
		padding: 0;
	}
	.whmpress.whmpress_pricing_table.advance-01 .main .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.advance-01 .main .pricing_table_heading .holder h2 {
		margin-bottom: 0;
		font-size: 16px;
		font-weight: 400;
	}
	.whmpress.whmpress_pricing_table.advance-01 .main .pricing_table_detail {
		font-size: 24px;
		font-weight: 700;
	}
	#{$random_id} .main hr {
		margin: auto;
		margin-top: 14px;
		background-color: {$secondary_color};
		width: 12%;
	}
	.whmpress.whmpress_pricing_table.advance-01 .main .icon i.fa {
		font-size: 60px;
		opacity: 0.15;
		position: absolute;
		right: 44px;
		top: 9px;
	}
	#{$random_id} .pricing_table_price .holder .currency {
		font-size: 26px;
		font-weight: 600;
		color: {$secondary_color};
		padding-right: 5px;
		position: relative;
		bottom: 24px;
	}
	#{$random_id} .pricing_table_price .holder .amount {
		font-size: 54px;
		font-weight: 600;
		color: {$secondary_color};
	}
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_price .holder .decimal, .whmpress.whmpress_pricing_table.advance-01 .pricing_table_price .holder .fraction {
		font-size: 25px;
		font-weight: 600;
		color: #d3d3d3;
	}
	#{$random_id} .pricing_table_price .holder .duration {
		display: block;
		margin-top: -7px;
		font-size: 14px;
		font-weight: 600;
		color: {$secondary_color};
	}
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_price {
		padding: 22px 0;
		border-bottom: solid 1px #EDEDEE;
	}
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_features .holder ul {
		border: none;
		padding: 0;
		margin: 0;
	}
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_features .holder ul li {
		border-color: #EDEDEE;
		padding: 8px 0;
		color: #666666;
		font-size: 14px;
		font-weight: 400;
	}
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_features .holder ul li:nth-child(odd) {
		background-color: #F8F8F8;
	}
	.whmpress.whmpress_pricing_table.advance-01 .pricing_table_combo {
		padding-bottom: 12px;
	}
	#{$random_id}.featured .main {
		background-color: {$secondary_color};
		position: relative;
		overflow: hidden;
	}
	#{$random_id}.featured .main hr{
		background-color:#ffffff;
	}
	.whmpress.whmpress_pricing_table.advance-01.featured .main .icon i.fa.fa-database {
		right: 19px;
	}
	.whmpress.whmpress_pricing_table.advance-01.featured .baner {
		color: #fff;
		left: -60px;
		line-height: 37px;
		margin: 0;
		position: absolute;
		text-transform: uppercase;
		top: 15px;
		transform: rotate(-45deg);
		width: 190px;
		background-color: #2F3841;
		display: block;
		font-size: 14px;
		font-weight: 600;
	}
	.whmpress.whmpress_pricing_table.advance-01 .baner {
		display: none;
	}
</style>


<div class="whmpress whmpress_pricing_table advance-01 {$featured}" id="{$random_id}">
	<div class="main">
		<div class="baner">{$featured_text}</div>
		<div class="icon">
			<i class="fa {$sub_icon}"></i>
		</div>
	<div class="pricing_table_heading">
		<div class="holder">
			<h2>{$product_name}</h2>
		</div>
		<hr>
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
	<div class="pricing_table_price okay">
		<div class="holder">
			<span class="currency">{$prefix}</span><span class="amount">{$amount}</span>{if $fraction ne ""}
			<span class="decimal">{$decimal}</span><span class="fraction">{$fraction}</span>{/if}<span class="duration">{$duration}</span>

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