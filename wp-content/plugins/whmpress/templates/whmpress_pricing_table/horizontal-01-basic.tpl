{if $primary_color eq '' || $primary_color eq '#000000'}
    {$primary_color='#B9CC4B'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
    {$secondary_color='#FAFAFA'}
{/if}



<style>
	#{$random_id}, #{$random_id} .top.top1 {
		background-color: {$primary_color};
	}
	#{$random_id}:before {
		 border-color: {$primary_color} transparent transparent transparent;
	 }
	.whmpress.whmpress_pricing_table.horizontel-01 .pricing_table_combo .whmpress_order_button,
	.whmpress.whmpress_pricing_table.horizontel-01 .pricing_table_combo a,
	.whmpress.whmpress_pricing_table.horizontel-01 .pricing_table_combo button,
	.whmpress.whmpress_pricing_table.horizontel-01 .pricing_table_submit .whmpress_order_button,
	.whmpress.whmpress_pricing_table.horizontel-01 .pricing_table_submit a,
	.whmpress.whmpress_pricing_table.horizontel-01 .pricing_table_submit button {
		font-size: 14px;
		font-weight: 900;
		color: #ffffff;
		padding: 14px 0;
		width: 116px;
		border-radius: 10px;
		background-color: #B9CC4B;
		transition: 0.5s;
	}
	.whmpress.whmpress_pricing_table.horizontel-01 .pricing_table_combo .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.horizontel-01 .pricing_table_combo a:hover,
	.whmpress.whmpress_pricing_table.horizontel-01 .pricing_table_combo button:hover,
	.whmpress.whmpress_pricing_table.horizontel-01 .pricing_table_submit .whmpress_order_button:hover,
	.whmpress.whmpress_pricing_table.horizontel-01 .pricing_table_submit a:hover,
	.whmpress.whmpress_pricing_table.horizontel-01 .pricing_table_submit button {
	}




	.whmpress.whmpress_pricing_table.horizontel-01 {
		border: none;
		box-shadow: none;
		padding: 0;
		margin: auto;
		max-width: max-content;
		border-radius: 0;
		transition: 1.0s all;
		margin-bottom: 10px;
	}
	#{$random_id} .top.list{
					  background-color: {$secondary_color};
				  }
	.whmpress.whmpress_pricing_table.horizontel-01 .top.list {
		padding: 19px 74px;
	}
	.whmpress.whmpress_pricing_table.horizontel-01 .top .pricing_table_detail.details {
		display: none;
	}
	.whmpress.whmpress_pricing_table.horizontel-01 .top {
		float: left;
		padding: 60px 60px;
		text-align: left;
		position: relative;
		max-width: 40%;
		height: 273px;
	}
	.whmpress.whmpress_pricing_table.horizontel-01 .top .pricing_table_heading .holder h2 {
		font-size: 37px;
		color: #ffffff;
		font-weight: 400;
		margin-bottom: 0;
	}
	.whmpress.whmpress_pricing_table.horizontel-01 .top .pricing_table_price .holder {
		font-size: 36px;
		color: white;
		font-weight: 400;
		margin-bottom: -9px;
		padding-top: 6px;
	}
	.whmpress.whmpress_pricing_table.horizontel-01 .bottom .pricing_table_submit{
		margin-top: 45px;
	}
	.whmpress.whmpress_pricing_table.horizontel-01 .pricing_table_detail {
		font-size: 12px;
		font-weight: 400;
		color: white;
	}
	#{$random_id} .top .arrow-left{
					  border-left: 1rem solid {$primary_color};
				  }
	.whmpress.whmpress_pricing_table.horizontel-01 .top .arrow-left {
		border-top: 2rem solid transparent;
		border-bottom: 2rem solid transparent;
		position: absolute;
		left: 100%;
		bottom: 104px;
		z-index: 1;
	}
	.whmpress.whmpress_pricing_table.horizontel-01 .list .pricing_table_features .holder ul {
		border: none;
		margin: 0;
		padding: 0;
	}
	.whmpress.whmpress_pricing_table.horizontel-01 .list .pricing_table_features .holder ul li {
		font-size: 14px;
		font-weight: 400;
		color: #363636;
	}
	.whmpress.whmpress_pricing_table.horizontel-01 .list .pricing_table_features .holder ul li i.fa.fa-check {
		padding-right: 10px;
	}
	#{$random_id} .list .pricing_table_features .holder ul li i.fa.fa-check {
					  color: {$primary_color};
				  }
	.whmpress.whmpress_pricing_table.horizontel-01 .bottom {
		padding: 64px 47px 71px 47px;
		background-color: #ffffff;
		transition: 1.0s all;
	}
	#{$random_id} .bottom{
					  border-right: solid 6px {$primary_color};
				  }
	.clear{
		clear:both;
	}
	.whmpress.whmpress_pricing_table.horizontel-01:hover {
		transform: scalex(1.05);
		box-shadow: 0 0 34px 0 grey;
	}
	.whmpress.whmpress_pricing_table.horizontel-01:hover .top .arrow-left {
		transition: 1.0s all;
	}
	#{$random_id}:hover .bottom {
		 background-color: {$primary_color};
	 }
	.whmpress.whmpress_pricing_table.horizontel-01:hover .bottom .pricing_table_submit .holder button,
	.whmpress.whmpress_pricing_table.horizontel-01:hover .bottom .pricing_table_combo .holder button {
		background-color: #393939;
	}
	#{$random_id}.featured, #{$random_id}.featured .top.top1 {
								 background-color: #36cccb;
							 }
	.whmpress.whmpress_pricing_table.horizontel-01.featured {
		transform: scaleY(1);
	}

	#{$random_id}.featured .top .arrow-left {
		 border-left-color: #36cccb;
	 }
	#{$random_id}.featured .list {
		 background-color: #ffffff;
	 }
	.whmpress.whmpress_pricing_table.horizontel-01.featured .bottom {
		background-color: #FAFAFA;
	}
	#{$random_id}.featured:hover .bottom {
		 background-color: #36cccb;
	 }
	#{$random_id}.featured .list .pricing_table_features .holder ul li i.fa.fa-check {
		 color: #36cccb;
	 }
	.whmpress.whmpress_pricing_table.horizontel-01.featured:hover {
		box-shadow: 0 0 34px 0 grey;
		transform: scalex(1.05);
	}
	#{$random_id}.featured .bottom{
		 border-right-color: #36cccb;
	 }
	.whmpress.whmpress_pricing_table.horizontel-01.featured .bottom .pricing_table_combo .holder button {
		background-color: #36cccb;
	}
	.whmpress.whmpress_pricing_table.horizontel-01.featured:hover .bottom .pricing_table_submit .holder button,
	.whmpress.whmpress_pricing_table.horizontel-01.featured:hover .bottom .pricing_table_combo .holder button {
		background-color: #393939;
	}


	@media (max-width: 1307px){


		.whmpress.whmpress_pricing_table.horizontel-01{
			width: 100%;
		}
		.whmpress.whmpress_pricing_table.horizontel-01 .top {
			max-width: 100%;
		}
		.whmpress.whmpress_pricing_table.horizontel-01 .top.top1{
			float: none;
			text-align: center;
			padding: 60px 0;
		}
		.whmpress.whmpress_pricing_table.horizontel-01 .top.list,
		.whmpress.whmpress_pricing_table.horizontel-01 .top.bottom{
			float: left;
			width: 50%;
		}
	#{$random_id} .top.bottom {
					  padding-left: 71px;
					  border-right: none;
				  }
		.whmpress.whmpress_pricing_table.horizontel-01.featured .top.bottom {
			border-right-color: #36cccb;
		}
		.whmpress.whmpress_pricing_table.horizontel-01 .list .pricing_table_features .holder ul li {
			text-align: left;
		}
		.whmpress.whmpress_pricing_table.horizontel-01 .list .pricing_table_features .holder ul li i.fa.fa-check {
			padding-right: 10px;
		}
		.whmpress.whmpress_pricing_table.horizontel-01 .top .arrow-left{
			display: none;
		}
	}


	@media (max-width: 786px){
		.whmpress.whmpress_pricing_table.horizontel-01 .top.top1,
		.whmpress.whmpress_pricing_table.horizontel-01 .top.list,
		.whmpress.whmpress_pricing_table.horizontel-01 .top.bottom {
			float: none;
			width: 100%;
		}

		.whmpress.whmpress_pricing_table.horizontel-01 {
			width: 100%;
		}
	#{$random_id} .top.bottom{
					  border-bottom: solid 6px {$primary_color};
					  border-right: none;
				  }
	#{$random_id}.featured .top.bottom{
		 border-bottom-color: #36cccb;
	 }
		.whmpress.whmpress_pricing_table.horizontel-01:hover {
			transform: scaleY(1.05);
		}
		.whmpress.whmpress_pricing_table.horizontel-01 .top.list{
			padding: 24px;
		}

		.whmpress.whmpress_pricing_table.horizontel-01 .top.bottom{
			padding: 42px 40px;
		}



	}
</style>







<div class="whmpress whmpress_pricing_table horizontel-01 {$featured}" id="{$random_id}">
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
		<div class="arrow-left"></div>
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
                        {$desc.feature_title}
                        {if $show_description_tooltip eq 'yes' and $desc.tooltip_text ne '' }
							<span class="whmpress_tooltip">{$desc.tooltip_text}</span>
                        {/if}{if $desc.feature_value ne "" }:{/if}
                    </span><span class="whmpress_description_value">{$desc.feature_value}</span>
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
	<div class="clear"></div>
</div>  <!-- /.price-table -->