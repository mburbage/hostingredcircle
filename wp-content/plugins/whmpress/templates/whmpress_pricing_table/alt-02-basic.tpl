{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#E3EBF4'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#5273A5'}
{/if}


<style>
	#{$random_id} {
		border: 4px solid {$primary_color};
		text-align: center;
		box-shadow: none;
		border-radius: 0;
		max-width: 100%;
		margin-bottom: 40px;
	}
	#{$random_id}:before {
		border-color:  transparent transparent transparent;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button,
	#{$random_id} .pricing_table_combo a,
	#{$random_id} .pricing_table_combo button,
	#{$random_id} .pricing_table_submit .whmpress_order_button,
	#{$random_id} .pricing_table_submit a,
	#{$random_id} .pricing_table_submit button {
	background: #6fac2f;
	width: 80%;
	margin-top: 40px;
	max-width: 20rem;
	border-radius: 0;
	box-shadow: -5px -5px 0 0 #f0f0f5;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
	background: #f0f0f5;
	box-shadow:none;
	color:#6fac2f;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	}





	.whmpress.whmpress_pricing_table.alt-02 .pricing_table_heading .holder h2{
		font-size: 35px;
		text-transform: uppercase;
		font-weight: bold;
		margin-top: 5px;
		margin-bottom: 0;
	}
	.whmpress.whmpress_pricing_table.alt-02 .pricing_table_detail {
		display: none;
	}
	.whmpress.whmpress_pricing_table.alt-02 .pricing_table_detail.details {
		display: block;
	}
	.whmpress.whmpress_pricing_table.alt-02 .pricing_table_detail .holder{
		font-size: 17px;
		margin-top: 5px;
		color: #848484;
		line-height: 1.2;
	}
	.whmpress.whmpress_pricing_table.alt-02 .pricing_table_price .holder {
		font-size: 65px;
		font-weight: 900;
		color: #484848;
	}
	.whmpress.whmpress_pricing_table.alt-02 .pricing_table_price .holder .currency{
		font-size: 46px;
	}
	.whmpress.whmpress_pricing_table.alt-02 .pricing_table_price .holder .duration{
		font-size: 33px;
		font-weight: 400;
	}


	.whmpress.whmpress_pricing_table.alt-02 .pricing_table_features .holder ul{
		border:none;
		padding: 30px 0 0 0;
	}
	.whmpress.whmpress_pricing_table.alt-02 .pricing_table_features .holder ul li{
		border-top: 1px dashed #d7dee8;
		border-bottom:none;
		font-size:17px;
		color:#484848;
		padding: 18px 0;
	}
	.whmpress.whmpress_pricing_table.alt-02 .pricing_table_features .holder ul li strong{
		display:block;
	}
	.whmpress.whmpress_pricing_table.alt-02 .pricing_table_features .holder ul li span{
		border-bottom: 1px dashed #BCBEC0;
	}
	.vc_column_container>.vc_column-inner{
		padding: 0 0;
	}
	#{$random_id}.featured{
		border: 4px solid {$secondary_color};
		transform: scaleY(1);
	}

</style>


<div class="whmpress whmpress_pricing_table alt-02 {$featured}" id="{$random_id}">
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
	{if $product_detail ne "" || $product_tag_line ne ""}
	<div class="pricing_table_detail details">
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
	<div class="pricing_table_submit">
		<div class="holder">
			{$product_order_button}
		</div>
	</div>
</div>  <!-- /.price-table -->