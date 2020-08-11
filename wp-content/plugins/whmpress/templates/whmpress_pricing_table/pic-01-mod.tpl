{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#EEF1F1'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#9ba6af'}
{/if}


<style>
	#{$random_id} {
	background: {$primary_color};
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_submit button {
		color: #955db8;
		font-weight: bold;
		text-transform: capitalize;
		border: 2px solid #955db8;
		padding: 7px 40px;
		border-radius: 40px;
		text-decoration: none;
		background: transparent;
		margin: 0;
		transition: all 0.2s ease-in-out;
	}
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_submit button {
		color:#fff;
		background:#955db8;
	}





	.whmpress.whmpress_pricing_table.pic-01 {
		border: none;
		box-shadow: none;
		padding-top: 0;
		position: relative;
		border-radius: 0;
		transition: all 0.2s ease-in-out;
		padding-bottom: 0;
	}
	.whmpress.whmpress_pricing_table.pic-01:hover{
		box-shadow: 0px 0px 43px -1px rgba(0,0,0,0.1);
		transform: scale(1.02);
		transition: all 0.2s ease-in-out;
	}
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_heading .holder img{
		vertical-align: middle;
		border-radius: 12px 12px 0 0;
	}

	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_price .holder {
		position: absolute;
		left: 0;
		width: 100%;
		height: 167px;
		background: rgba(61, 148, 206, 0.74);
		top: 0;
		border-radius: 12px 12px 0 0;
		transition: all 0.2s ease-in-out;
		color: #fff;
		font-weight: bold;
		font-size: 39px;
		padding-top: 40px;
	}
	.whmpress.whmpress_pricing_table.pic-01:hover .pricing_table_price .holder{
		background: rgba(44, 119, 169, 0.74);
		transition: all 0.2s ease-in-out;
	}
	.whmpress.whmpress_pricing_table.pic-01  .pricing_table_detail .holder{
		background: linear-gradient(to right, #06a8f1, #22ce9c);
		font-weight: bold;
		color: #fff;
		text-transform: uppercase;
		font-size: 13px;
		display: block;
		max-width: 140px;
		text-align: center;
		padding: 11px;
		border-radius: 41px;
		margin: auto;
		margin-top: -22px;
		position: relative;
	}
	.whmpress.whmpress_pricing_table.pic-01  .pricing_table_detail {
		padding:0;
	}
	.whmpress.whmpress_pricing_table.pic-01  .pricing_table_detail.pricing_table_detail-2{
		display:none;
	}
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_price .holder .currency{
		font-weight: 100;
		font-size: 19px;
	}
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_price .holder .duration{
		font-weight: 100;
		display: block;
		color: #fff;
		position: relative;
		z-index: 3;
		font-size: 12px;
		margin-top: -3px;
	}

	.whmpress.whmpress_pricing_table.pic-01  .pricing_table_features .holder ul{
		border:none;
		text-align:left;
	}
	#{$random_id} .pricing_table_features .holder ul li{
		list-style: none;
		margin: 18px 0;
		font-size: 13px;
		cursor: pointer;
		color: {$secondary_color};
		border: none;
		padding: 0 30px;
	}
	.whmpress.whmpress_pricing_table.pic-01  .pricing_table_features .holder ul li i{
		margin-right: 5px;
	}
	.whmpress.whmpress_pricing_table.pic-01 .pricing_table_submit .holder{
		background: rgb(249, 250, 250);
		border-top: 1px solid rgba(227, 232, 232, 0.55);
		padding: 23px 69px;
	}


	.whmpress.whmpress_pricing_table.pic-01.featured{
		transform: scaleY(1);
	}
	.whmpress.whmpress_pricing_table.pic-01 .ribbon{
		display:none;
	}
	.whmpress.whmpress_pricing_table.pic-01.featured .ribbon{
		width: 35px;
		height: 70px;
		background: #efe94f;
		top: -6px;
		left: 8px;
		position: absolute;
		z-index: 22;
		display:block;
		transition: all 0.2s ease-in-out;
	}
	.whmpress.whmpress_pricing_table.pic-01.featured .ribbon span {
		position: absolute;
		display: -webkit-box;
		-ms-transform: rotate(90deg);
		-webkit-transform: rotate(90deg);
		transform: rotate(-90deg);
		top: 28px;
		margin-left: 2px;
		font-weight: bold;
		font-size: 13px;
		text-transform: uppercase;
		color: rgba(3, 36, 58, 0.52);
		transition: all 0.2s ease-in-out;
	}
	.whmpress.whmpress_pricing_table.pic-01.featured .ribbon:before{
		content: "";
		position: absolute;
		height: 0;
		width: 0;
		border-bottom: 6px solid #cac441;
		border-right: 6px solid transparent;
		right: -6px;
	}

	.whmpress.whmpress_pricing_table.pic-01.featured .ribbon:after{
		content: "";
		position: absolute;
		height: 0;
		width: 0;
		border-left: 18px solid #efe94f;
		border-right: 17px solid #efe94f;
		border-bottom: 18px solid transparent;
		bottom: -17px;
		left: 0;
	}
	.whmpress.whmpress_pricing_table.pic-01.featured:hover{
		box-shadow: 0px 0px 43px -1px rgba(0,0,0,0.1);
		transform: scale(1.02);
		transition: all 0.2s ease-in-out;
	}
	.whmpress.whmpress_pricing_table.pic-01.featured:hover .ribbon{
		height: 20px;
	}
	.whmpress.whmpress_pricing_table.pic-01.featured:hover .ribbon span{
		opacity: 0;
	}

	.set_pic_01_img {
		content:  url({if $sub_image ne ''}{$sub_image}{else}http://sajid.hostriplex.com/whmpress/wp-content/uploads/2018/01/plan02.jpg{/if});
	}

</style>


<div class="whmpress whmpress_pricing_table pic-01 {$featured}" id="{$random_id}">
	<div class="ribbon"><span>{$featured_text}</span></div>
	<div class="pricing_table_heading">
		<div class="holder">
			<img class="set_pic_01_img">
		</div>
	</div>
	<div class="pricing_table_detail  pricing_table_detail-2">
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
                    <strong class="whmpress_description_title">
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
                    </strong>
					<span class="whmpress_description_value">{$desc.feature_value}</span>
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
