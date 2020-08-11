{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#ffffff'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#03A9F4'}
{/if}


<style>
	#{$random_id} {

	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_submit button {
		background: #03A9F4;
	}
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.pic-03} .pricing_table_submit button {

	}



	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_heading .holder{
		width: 60%;
		padding-bottom: 60%;
		background: #f5f5f5 url({if $sub_image ne ''}{$sub_image}{else}http://sajid.hostriplex.com/whmpress/wp-content/uploads/2018/01/download.png{/if}) no-repeat right bottom;
		background-size: 76%;
		border-radius: 50%;
		cursor: pointer;
		position: relative;
		vertical-align: middle;
		margin: 0 63px;
		transition: all 0.2s ease-in-out;
	}
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_heading .holder h2{
		display:none;
	}
	.whmpress.whmpress_pricing_table.pic-03.featured .pricing_table_heading .holder span.bestchoiswizrd{
		position: absolute;
		top: 14px;
		right: 4px;
		z-index: 5;
		font-size: 12px;
		font-family: 'Ubuntu', sans-serif;
		font-weight: 100;
		background: #8BC34A;
		color: #fff;
		padding: 2px 14px;
		border-radius: 29px;
		display:block;
	}
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_heading .holder span.bestchoiswizrd{
		display:none;
	}
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_heading .holder:hover{
		background: #e8e8e8 url({if $sub_image ne ''}{$sub_image}{else}http://sajid.hostriplex.com/whmpress/wp-content/uploads/2018/01/download.png{/if}) no-repeat right bottom;
		background-size: 80%;
	}
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_price .holder{
		font-weight: bold;
		margin-top: -39px;
	}
	.whmpress.whmpress_pricing_table.pic-03 {
		border: none;
		box-shadow: none;
		border-radius: 0;
	}

	#{$random_id} .pricing_table_features .holder ul{
		padding: 24px 55px 14px;
		border: 1px solid rgba(224, 224, 232, 0.33);
		background-color: {$primary_color};
		border-radius: 6px;
		box-shadow: 0 3px 5px rgba(0, 0, 0, 0.04);
		margin-top: 26px;
		margin-bottom: 26px;
		text-align: left;
		font-size: 13px;
	}

	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_features .holder ul li{
		border:none;
	}

	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_features .holder {
		position: relative;
	}
	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_features .holder  i.fa.fa-caret-up{
		position: absolute;
		top: -20px;
		left: 0;
		right: 0;
		color: #dee2e6;
		font-size: 28px;
	}

	#{$random_id} .pricing_table_features .holder ul li i{
		background: {$secondary_color};
		color: #fff;
		font-size: 13px;
		padding: 3px 4px;
		border-radius: 30px;
		margin-right: 2px;
	}

	.whmpress.whmpress_pricing_table.pic-03 .pricing_table_features .holder ul li span{
		color: #9ea8ad;
	}

</style>



<div class="whmpress whmpress_pricing_table pic-03 {$featured}" id="{$random_id}">
	<div class="pricing_table_heading">
		<div class="holder">
			<span class="bestchoiswizrd">{$featured_text}</span>
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
	{if $process_description|lower eq "yes"}
	<div class="pricing_table_features">
		<div class="holder">
			<i class="fa fa-caret-up" aria-hidden="true"></i>
			<ul>
				{foreach $split_description as $desc}
				<li class="{if $show_description_tooltip eq 'yes' } whmpress_has_tooltip{/if}">
                    <span class="whmpress_description_title">
                        {if $show_description_icon eq 'yes' and $desc.icon_class ne ''}
                            <i class="{$desc.icon_class}"></i>
                        {/if}
						{if $desc.icon_class ne 'yes' || $desc.icon_class eq ''}
                            <i class="fa fa-database"></i>
                        {/if}
						{$desc.feature_title}
                        {if $show_description_tooltip eq 'yes' and $desc.tooltip_text ne '' }
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