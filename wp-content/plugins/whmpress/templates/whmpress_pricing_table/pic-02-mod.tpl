{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#f8f8fa'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#a1aeb5'}
{/if}



<style>
	#{$random_id} {
	background: {$primary_color};
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_submit button {
		letter-spacing: 0.5px;
		margin-top: 30px;
		background: #8BC34A;
		color: #fff;
		font-weight: 600;
		text-transform: uppercase;
		padding: 11px;
		font-size: 12px;
		border-radius: 2px;
	}
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_submit button {
		background: #77a93e;
	}


	.whmpress.whmpress_pricing_table.pic-02 {
		border: none;
		box-shadow: none;
		padding-top: 0;
		padding-bottom: 2px;
		transition: 500ms;
		border-radius: 7px 7px 0 0;
	}
	.whmpress.whmpress_pricing_table.pic-02:hover{
		transform: scale(1.02);
	}
	.whmpress.whmpress_pricing_table.pic-02:hover .pricing_table_heading .holder img{
		transform: rotate(6deg) scale(1.2)
	}
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_heading .holder img{
		vertical-align: middle;
		border-radius: 8px;
		border-bottom-right-radius: 0;
		transition: 500ms;
	}
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_heading .holder{
		overflow: hidden;
		border-radius: 6px 6px 0;
		position: relative;
	}
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_price .holder {
		font-weight: 400;
		font-size: 24px;
		color: #448cb3;
		padding-top:20px;
	}
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_detail {
		padding:0;
	}
	.whmpress.whmpress_pricing_table.pic-02  .pricing_table_detail.pricing_table_detail-2{
		display:none;
	}

	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_detail .holder {
		font-size: 11px;
		background: #e8eef1;
		color: #afb9bd;
		margin: auto;
		padding: 7px 17px;
		width: max-content;
		border-radius: 35px;
		font-weight: bold;
		text-transform: uppercase;
		margin-top: 9px;
	}
	.whmpress.whmpress_pricing_table.pic-02 .pricing_table_features .holder ul{
		border:none;
		padding:0;
		margin-top: 20px;
	}
	#{$random_id}  .pricing_table_features .holder ul li{
		border:none;
		font-size: 13px;
		font-weight: 600;
		line-height: 21px;
		padding: 2px 0;
		color: {$secondary_color};
		margin: 0 0 10px;
	}

	.whmpress.whmpress_pricing_table.pic-02.featured .pricing_table_heading .poplar {
		position: absolute;
		left: -16px;
		top: 34px;
		color: #ffffff;
		text-transform: uppercase;
		transform: rotate(90deg);
		z-index: 3;
		transition: all 0.3s ease;
		background: #fdb714;
		padding: 13px;
		text-align: center;
		line-height: 0px;
		font-weight: 600;
		height: 26px;
		font-size: 11px;
		letter-spacing: 2px;
		display:block;
	}
	.whmpress.whmpress_pricing_table.pic-02.featured .pricing_table_heading .poplar:before{
		content: '';
		position: absolute;
		width: 0;
		height: 0;
		border-style: solid;
		border-width: 13px 0 0 10px;
		border-color: transparent transparent transparent #fdb714;
		right: -9px;
		bottom: 0;
	}
	.whmpress.whmpress_pricing_table.pic-02.featured .pricing_table_heading .poplar:after{
		content: '';
		position: absolute;
		width: 0;
		height: 0;
		border-style: solid;
		border-width: 13px 10px 0 0;
		border-color: #fdb714 transparent transparent transparent;
		right: -9px;
		top: 0;
	}
	.whmpress.whmpress_pricing_table.pic-02.featured {
		transform: scale(1.09);
	}
	.whmpress.whmpress_pricing_table.coodiv .pricing_table_heading .poplar{
		display:none;
	}
	.set_pic_02_img {
		content:  url({if $sub_image ne ''}{$sub_image}{else}http://sajid.hostriplex.com/whmpress/wp-content/uploads/2018/01/plan02.jpg{/if});
	}
</style>


<div class="whmpress whmpress_pricing_table pic-02 {$featured}" id="{$random_id}">
	<div class="pricing_table_heading">
		<div class="poplar">{$featured_text}</div>
		<div class="holder">
			<img class="set_pic_02_img">
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