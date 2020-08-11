{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#f4f8fb'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#fff'}
{/if}



<style>
	#{$random_id} {

	}
	#{$random_id}:before {
	border-color: {$primary_color} transparent transparent transparent;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button,
	#{$random_id} .pricing_table_combo a,
	#{$random_id} .pricing_table_combo button,
	#{$random_id} .pricing_table_submit .whmpress_order_button,
	#{$random_id} .pricing_table_submit a,
	#{$random_id} .pricing_table_submit button {
					  color: #646f79;
					  background-color: transparent;
					  border:1px solid #646f79;
		width: 100%;
					  max-width: 77px;
		margin-top: 20px;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button:hover {
		color: #ffffff;
					  background-color: #646f79;
					  border-color: #646f79;
					  -webkit-box-shadow: 0 1px 10px rgba(100, 111, 121, 0.4) ;
					  box-shadow: 0 1px 10px rgba(100, 111, 121, 0.4) ;
	}
	#{$random_id}.featured .pricing_table_combo .whmpress_order_button,
	#{$random_id}.featured .pricing_table_combo a,
	#{$random_id}.featured .pricing_table_combo button,
	#{$random_id}.featured .pricing_table_submit .whmpress_order_button,
	#{$random_id}.featured .pricing_table_submit a,
	#{$random_id}.featured .pricing_table_submit button {
		 background-color: #892fff;
		 border-color: #8222ff;
		color: #ffffff;
				  }
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	background: {$secondary_color};
	}



	.whmpress.whmpress_pricing_table.fawateir {
		box-shadow: none;
		border: solid 1px #DCDCDC;
		border-radius: 4px;
		padding-top: 0;
		padding-bottom: 0;
		margin-top:20px;
		margin-bottom:20px;
		max-width: 100%;
	}
	.whmpress.whmpress_pricing_table.fawateir .pricing_table_heading .holder h2 {
		padding-top: 0;
		font-size: 24px;
		color: #333333;
		font-weight: 300;
		margin-bottom: 0;
	}
	.whmpress.whmpress_pricing_table.fawateir .pricing_table_price .holder .decimal {
		display: none;
	}
	.whmpress.whmpress_pricing_table.fawateir .pricing_table_price .holder .fraction {
		display: none;
	}
	.whmpress.whmpress_pricing_table.fawateir .pricing_table_price .holder .currency {
		font-size: 20px;
		color: #333333;
		position: relative;
		bottom: 23px;
		padding-right: 1px;
	}
	.whmpress.whmpress_pricing_table.fawateir .pricing_table_price .holder .amount {
		font-size: 52px;
		color: #333333;
		font-weight: 700;
	}
	.whmpress.whmpress_pricing_table.fawateir .pricing_table_price {
		padding-top: 14px;
	}
	.whmpress.whmpress_pricing_table.fawateir .pricing_table_detail .holder1 {
		font-size: 14px;
		color: #333333;
	}
	.whmpress.whmpress_pricing_table.fawateir .pricing_table_detail {
		padding-top: 10px;
		font-size: 20px;
	}
	#{$random_id} .main {
		border-bottom: solid 1px #DBDBDB;
		padding-bottom: 25px;
		background-color: {$primary_color};
		padding-top: 40px;
	}
	.whmpress.whmpress_pricing_table.fawateir .pricing_table_features .holder ul {
		border: none;
		padding: 0;
	}
	.whmpress.whmpress_pricing_table.fawateir .pricing_table_features .holder ul li {
		font-size: 20px;
		color: #333333;
		font-weight: 400;
		text-align: center;
		padding: 7px 7px;
		padding-right: 14px;
		border-bottom: 1px solid rgba(0, 0, 0, 0.125);

	}
	#{$random_id}s .main {
		background-color: {$primary_color};
	}
	.whmpress.whmpress_pricing_table.fawateir.featured .pricing_table_heading .holder h2 {
		color: #ffffff;
	}
	.whmpress.whmpress_pricing_table.fawateir.featured .pricing_table_price .holder .currency {
		color: #ffffff;
	}
	.whmpress.whmpress_pricing_table.fawateir.featured .pricing_table_price .holder .amount {
		color: #ffffff;
	}
	.whmpress.whmpress_pricing_table.fawateir.featured .whmpress.whmpress_order_combo button {
		color: #ffffff;
	}
	.whmpress.whmpress_pricing_table.fawateir.featured .whmpress.whmpress_order_combo button:hover {
		color: #333333;
	}
	#{$random_id}.featured .main {
		 background: linear-gradient(#a159ff, #9F55FF);
		color: #ffffff;
	 }
	#{$random_id}.featured{
		transform: scaleY(1);
	}

</style>





<div class="whmpress whmpress_pricing_table fawateir {$featured}" id="{$random_id}">
	<div class="main">
	<div class="pricing_table_heading">
		<div class="holder">
			<h2><i class="fa {$sub_icon}"></i> {$product_name}</h2>
		</div>
	</div>
	<div class="pricing_table_price">
		<div class="holder">
			{if trim($duration) eq 'Annually'}
				{assign var="duration" value="/سنة واحدة"}
			{/if}
			{if trim($duration) eq 'Biennially'}
				{assign var="duration" value="/سنتان"}
			{/if}
			{if trim($duration) eq 'One Time'}
				{assign var="duration" value="/أربع سنوات"}
			{/if}
			<span class="currency">{$prefix}</span><span class="amount">{$amount}</span><span class="currency">{$suffix}</span>{if $fraction ne ""}<span
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
