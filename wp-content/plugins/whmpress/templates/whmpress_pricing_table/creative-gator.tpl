{if $primary_color eq '' || $primary_color eq '#000000'}
	{$primary_color='#176fb7'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
	{$secondary_color='#ff8034'}
{/if}
<style>
	#{$random_id}:before {
		border-color: {$primary_color} transparent transparent transparent;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button,
	#{$random_id} .pricing_table_combo a,
	#{$random_id} .pricing_table_combo button,
	#{$random_id} .pricing_table_submit .whmpress_order_button,
	#{$random_id} .pricing_twhen ordered Annuallyable_submit a,
	#{$random_id} .pricing_table_submit button {
		background-color: {$primary_color};
		font-size: 20px;
		font-weight: 700;
		margin-bottom: 15px;
				  }
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
				  }
	#{$random_id}.featured .pricing_table_combo .whmpress_order_button,
	#{$random_id}.featured .pricing_table_combo a,
	#{$random_id}.featured .pricing_table_combo button,
	#{$random_id}.featured .pricing_table_submit .whmpress_order_button,
	#{$random_id}.featured .pricing_table_submit a,
	#{$random_id}.featured .pricing_table_submit button {
					  background-color: {$secondary_color};
				  }
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {

				  }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator {
		box-shadow: none;
		background: #fff;
		border-radius: 4px;
		border: none;
		padding: 25px 0;
		max-width: 100%;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .pricing_table_heading h2{
		font-weight: bold;
		color: {$primary_color};
		margin-bottom: 0;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .pricing_table_detail{
		 border-bottom: 1px solid #dfecff;
		margin-bottom: 25px;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .pricing_table_detail .holder{
		font-size: 18px;
		 font-weight: 300;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .pricing_table_price{
		color: {$primary_color};
		font-size: 15px;
		 margin-bottom: 25px;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .pricing_table_price span.amount,
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .pricing_table_price span.decimal,
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .pricing_table_price span.fraction{
		font-size: 32px;
		font-weight: 700;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .pricing_table_features ul {
		border-color: #dfecff;
		text-align: left;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .pricing_table_features ul li{
		border: none;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .pricing_table_features ul li strong{
		font-weight: 600;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator.featured{
		position: relative;
		 -webkit-transform: scaleY(1);
		 -moz-transform: scaleY(1);
		 -ms-transform: scaleY(1);
		 -o-transform: scaleY(1);
		 transform: scaleY(1);
		max-width: 100%;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator.featured .pricing_table_heading h2{
		 color: {$secondary_color};
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator.featured .pricing_table_price{
		 color: {$secondary_color};
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .whmpres_featured_content{
		display: none;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator.featured .whmpres_featured_content{
		font-size: 11px;
		background-color: {$secondary_color};
		 color: #ffffff;
		 padding: 5px 14px;
		 border-top-left-radius: 5px;
		 border-top-right-radius: 5px;
		 text-transform: uppercase;
		 position: absolute;
		 left: 0;
		 right: 0;
		 top: -23px;
		display: block;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator li.whmpress_has_tooltip span.whcom_tooltip_text_line {
		border-bottom: 1px dashed #9eb8dc;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .whmpress_discount_price{
		font-weight: 300;
		font-size: 13px;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .whmpress_discount_price span {
		 margin-left: 4px;
		 padding: 1px 10px;
		 font-size: 12px;
		 font-weight: 400;
		 color: #fff;
		 background-color: #51C197;
		 border-radius: 10px;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator  span.whmpress_discount_save_money {
		display: inline-block;
		margin-top: 4px;
		padding: 4px 8px;
		background-color: #F1F4FB;
		color: #2E578B;
		border-radius: 15px;
		font-size: 13px;
		font-weight: 300;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator.featured  span.whmpress_discount_save_money {
		 background-color: #FEF5F0;
		 color: #FF6A17;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .whmpress_domain_free strong{
		font-weight: 600;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .whmpress_domain_free i{
		color: {$primary_color};
	 }




	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .whcom_popup_item {
		color: #fff;
		display: inline-block;
		padding: 4px 10px 8px 10px;
		font-size: 14px;
		font-weight: bold;
		margin-bottom: -4px;
		text-transform: uppercase;
		background-color: #40B186;
		border-top-left-radius: 3px;
		border-top-right-radius: 3px;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .whcom_popup_item p{
		margin-bottom: 0;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .modal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 13; /* Sit on top */
		padding-top: 205px; /* Location of the box */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .modal.myModal{
		display: block;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator.featured .modal.myModal{
		 display: none;
	 }

	/* Modal Content */
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .modal-content {
		background-color: #fefefe;
		margin: auto;
		width: 80%;
		max-width: 600px;
		position: relative;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator  .modal-content p{
		margin-bottom: 0;
		padding: 10px 15px;
		border-bottom: 4px solid #40B186;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator  .modal-content strong{
		display: block;
		padding: 10px 15px;
		width: 100%;
	}
	/* The Close Button */
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .close {
		color: #40B186;
		position: absolute;
		right: 0;
		top: 7px;
		font-weight: bold;
		fill: currentColor;
		width: 1em;
		height: 1em;
		display: inline-block;
		font-size: 24px;
		transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
		user-select: none;
		flex-shrink: 0;
		opacity: 1;
	}

	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .close:hover,
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .close:focus {
		color: #000;
		text-decoration: none;
		cursor: pointer;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator span.whmpress_featured_best{
		display: none;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator.featured span.whmpress_featured_best {
		position: absolute;
		top: -36px;
		right: -24px;
		padding-top: 21px;
		width: 65px;
		height: 65px;
		background-color: #FBCE3B;
		color: #333;
		font-size: 16px;
		font-weight: 700;
		border-radius: 50%;
		text-align: center;
		display: block;
		z-index: 3;
	}
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .whmpress_has_tooltip .whmpress_tooltip{
		 padding: 4px 6px;
		 font-size: 12px;
		 border-radius: 6px;
		 top: 100%;
		 bottom: auto;
		 width: auto;
		 min-width: 0;
		 left: 0;
		 right: auto;
		background-color: #2e578b;
	 }
	#{$random_id}.whmpress.whmpress_pricing_table.creative-gator .whmpress_has_tooltip .whmpress_tooltip:after {
		content: "";
		position: absolute;
		width: 0;
		height: 0;
		border-style: solid;
		border-width: 1px 10px 10px 10px;
		border-color: transparent transparent #2e578b transparent;
		left: 50%;
		top: -9px;
		margin-left: -10px;
	}
</style>
<div class="whmpress whmpress_pricing_table creative-gator {$featured}" id="{$random_id}">
	<div class="whmpres_featured_content">we recommend</div>
	<span class="whmpress_featured_best">{$featured_text}</span>
	<div class="pricing_table_heading">
		<div class="holder">
			<h2><i class="fa {$sub_icon}"></i> {$product_name}</h2>
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
	<div class="whmpress_discount_price">
		{if $total_price_according_month ne ''}<del>{$prefix}{$total_price_according_month}</del>{/if} <b>{$prefix}{$product_price_without_conversion}</b> <span>-{$product_discount}%</span>
		<div>equivalent to</div>
	</div>
	<div class="pricing_table_price">
		<div class="holder">
			<span class="currency">{$prefix}</span><span class="amount">{$amount}</span>{if $fraction ne ""}<span
					class="decimal">{$decimal}</span><span class="fraction">{$fraction}</span>{/if}<span class="duration">{$duration}</span>

			<!-- price sub text -->
			{*{if $price_sub_text ne ""}
				<div class="duration">
					{$price_sub_text}
				</div>
			{/if}*}
			<!-- /price sub text -->

		</div>
	</div>
	<div class="pricing_table_submit">
		<div class="holder">
			{if $order_button_with_parameters ne ""}
			{$order_button_with_parameters}
			{else}
				{$product_order_button}
			{/if}
		</div>
	</div>
	<div class="whmpress_domain_free">
		<strong>1 Year Free Domain</strong> <i class="fa fa-info-circle myBtn"></i>
	</div>
	<span class="whmpress_discount_save_money">
		save {$prefix}{$free_domain_price}
	</span>
	{if $process_description|lower eq "yes"}
		<div class="pricing_table_features">
			<div class="holder">
				<ul>
					{foreach $split_description as $desc}
						<li class="{if $show_description_tooltip eq 'yes' and $desc.tooltip_text ne ''} whmpress_has_tooltip{/if}">
							<span class="whcom_tooltip_text_line">
								<strong class="whmpress_description_value">{$desc.feature_value}</strong>
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
                    </span>
							</span>
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
    {foreach $all_tooltips_data as $tooltip}
    {if $tooltip.match_string eq 'modal'}
        {assign var="modal_text" value= $tooltip.tooltip_text }
    {/if}
    {/foreach}
	<div  class="modal">

		<!-- Modal content -->
		<div class="modal-content">
			<span class="close">&times;</span>
            <p>{$modal_text}</p>
		</div>
	</div>
</div>  <!-- /.price-table -->

<script>
   jQuery(".myBtn").click(function(){
       jQuery(".modal").addClass("myModal");
    });
    jQuery(".close").click(function(){
        jQuery(".modal").removeClass("myModal");
    });
</script>