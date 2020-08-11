{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#565656'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#b7b7b7'}
{/if}


<style>
	#{$random_id} .top.top1 {
	background: {$primary_color};
	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.horizontel-02 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.horizontel-02 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.horizontel-02 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.horizontel-02 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.horizontel-02 .pricing_table_submit button {
		width: 35%;
		background-color: #EDEDEE;
		color: #565656;
		font-size: 15px;
		font-weight: 700;
		border-radius: 6px;
		border: solid 2px #CACACA;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.horizontel-02 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.horizontel-02 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.horizontel-02 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.horizontel-02 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.horizontel-02 .pricing_table_submit button {
		background-color:#CACACA;
		color:#EDEDEE;
	}




	.whmpress.whmpress_pricing_table.horizontel-02 {
		border: none;
		box-shadow: none;
		padding: 0;
		max-width: 100%;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .top {
		float: left;
		width: 46%;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .top.top1 .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .top.top1 {
		color: white;
		text-align: left;
		padding-left: 27px;
		padding-top: 12px;
		padding-bottom: 12px;
		width: 24%;
		position: relative;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .top.top1 .pricing_table_heading .holder h2 {
		font-size: 26px;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .top.top1 .pricing_table_price {
		font-size: 32px;
		margin-top: -14px;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .top.top1 .pricing_table_detail {
		font-size: 12px;
		margin-top: -6px;
		padding-left: 0;
	}
	#{$random_id} .top.top1 .arrow-left{
		border-left: 63px solid {$primary_color};
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .top {
		height: 141px;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .top.top1 .arrow-left {
		border-top: 72px solid transparent;
		border-bottom: 67px solid transparent;
		position: absolute;
		left: 100%;
		bottom: 1%;
		z-index: 1;
		height: unset;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .top.bottom .pricing_table_submit {
		margin-top: 51px;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .top.list .pricing_table_features .holder ul {
		border: none;
		margin: 0;
		padding-left: 100px;
		text-align: left;
		padding-top: 1px;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .top.list .pricing_table_features .holder ul li {
		border: none;
		font-size: 13px;
		color: #565656;
		float: left;
		width: 50%;
		padding: 5px 0;
	}
	#{$random_id} .top.list .pricing_table_features .holder ul li i {
		color: {$secondary_color};
		padding-right: 3px;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .top.bottom {
		width: 30%;
	}
	.whmpress.whmpress_pricing_table.horizontel-02 .top.list {
		padding: 16px 0;
	}

	.whmpress.whmpress_pricing_table.horizontel-02 .top.bottom .pricing_table_combo .holder select{

		margin-top: 7px;
	}
	#{$random_id}.featured .top.top1{
		background-color:	#464646;
	}
	#{$random_id}.featured .top.top1 .arrow-left{
		border-left-color:	#464646;
	}
	.whmpress.whmpress_pricing_table.horizontel-02.featured .top{
		background-color: #F5F5F5;
	}





	@media (max-width: 1112px){

		.whmpress.whmpress_pricing_table.horizontel-02 .top.top1{
			float: none;
			width: 100%;
			text-align: center;
			padding: 32px 0;
		}
		.whmpress.whmpress_pricing_table.horizontel-02{
			margin: auto;
		}
		.whmpress.whmpress_pricing_table.horizontel-02 .top.list{
			width: 54%;
			padding: 42px 0;
		}
		.whmpress.whmpress_pricing_table.horizontel-02 .top.bottom{
			width: 46%;
			padding: 42px 0;
		}
		.whmpress.whmpress_pricing_table.horizontel-02 .top.list .pricing_table_features .holder ul li{
			padding: 9px 0;
		}
		.whmpress.whmpress_pricing_table.horizontel-02 .top.list .pricing_table_features .holder ul{
			padding-left: 36px;
			padding-right: 0;
		}
		.whmpress.whmpress_pricing_table.horizontel-02 .top.top1 .arrow-left{
			display: none;
		}
		.whmpress.whmpress_pricing_table.horizontel-02 .top.bottom .pricing_table_combo .holder select{
			width: 62%;
		}
	}




	@media (max-width: 786px) {

		.whmpress.whmpress_pricing_table.horizontel-02 .top {
			float: none;
			max-width: 100%;
			margin: auto;
		}
		.whmpress.whmpress_pricing_table.horizontel-02 .top.list .pricing_table_features .holder ul li {
			float: none;
			width: 100%;
		}
		.whmpress.whmpress_pricing_table.horizontel-02 .top.bottom {
			width: 100%;
			margin-top: -1px;
			padding: 0 0;
		}
		.whmpress.whmpress_pricing_table.horizontel-02 .top.list .pricing_table_features .holder ul{
			padding: 0;
		}
		.whmpress.whmpress_pricing_table.horizontel-02 .top.list {
			width: 100%;
			padding: 22px 29px;
		}




	}
</style>
<div class="whmpress whmpress_pricing_table horizontel-02 {$featured}" id="{$random_id}">
	<div class="top top1">
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
		<span class="arrow-left"></span>
	</div>
	<div class="top list">
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
                            <i class="fa fa-check"></i>
                        {/if}
						<strong class="whmpress_description_value">{$desc.feature_value}</strong>
						{$desc.feature_title}
                        {if $show_description_tooltip eq 'yes' and $desc.tooltip_text ne '' }
                            <span class="whmpress_tooltip">{$desc.tooltip_text}</span>
                        {/if}
                    </span>
					</li>
					{/foreach}
				</ul>
			</div>
		</div>
	{else}
	{$product_description}
	{/if}
	</div>
	<div class="top bottom">
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
	</div>
</div>  <!-- /.price-table -->
