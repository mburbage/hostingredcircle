{if $primary_color eq '' || $primary_color eq '#000000'}
{$primary_color='#d41111'}
{/if}

{if $secondary_color eq '' || $secondary_color eq '#000000'}
{$secondary_color='#323232'}
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
		background: #d10303;
		border: 0;
		color: #fff;
		position: relative;
		border-color: #d10303;
		transition: all .3s ease-in-out;
		font-size: 14px;
		width: 73%;
		text-transform: uppercase;
	}
	#{$random_id} .pricing_table_combo .whmpress_order_button:hover,
	#{$random_id} .pricing_table_combo a:hover,
	#{$random_id} .pricing_table_combo button:hover,
	#{$random_id} .pricing_table_submit .whmpress_order_button:hover,
	#{$random_id} .pricing_table_submit a:hover,
	#{$random_id} .pricing_table_submit button {
	background: {$secondary_color};
	background:#9f0202;
	}
	#{$random_id} .pricing_table_features ul li:nth-child(odd) {
	}


	.whmpress.whmpress_pricing_table.alt-01 {
		box-shadow: none;
		border: none;
		padding-top: 0;
		margin-top:70px;
	}

	#{$random_id} .pricing_table_heading .holder h2 {
		background: {$primary_color};
		padding: 24px 0 25px;
		text-transform: capitalize;
		font-size: 24px;
		font-weight: bold;
		color: white;
		margin-bottom: 0;
	}

	#{$random_id} .pricing_table_price .holder {
		height: 120px;
		position: relative;
		background: {$secondary_color};
		padding: 40px 0;
		display: block;
		margin: 0 0 4px;
		font-size: 40px;
		font-weight: 600;
		line-height: 28px;
		color: white;
	}

	.whmpress.whmpress_pricing_table.alt-01 .pricing_table_detail {
		display: none;
	}
	#{$random_id} i.fa.fa-caret-up{
		left: 50%;
		top: -26px;
		color: {$secondary_color};
		margin-left: -8px;
		position: absolute;
	}

	.whmpress.whmpress_pricing_table.alt-01 .pricing_table_combo .holder button{
		border: 0;
		color: #fff;
		position: relative;
		border-color: #d10303;
		transition: all .3s ease-in-out;
		font-size: 14px;
		width: 73%;
		text-transform: uppercase;
	}
	.whmpress.whmpress_pricing_table.alt-01 .pricing_table_features .holder ul{
		border: none;
		padding: 15px 0;
		text-align: left;
	}
	#{$random_id} .pricing_table_features .holder ul li{
		border:none;
		padding-left:40px;
		color: {$secondary_color};
	}
	.whmpress.whmpress_pricing_table.alt-01 .pricing_table_features .holder ul li:nth-child(odd){
		background: #f9f9f9;
	}
	.whmpress.whmpress_pricing_table.alt-01 .pricing_table_features .holder ul li i{
		padding-right: 10px;
	}
	.whmpress.whmpress_pricing_table.alt-01.featured {
		position: relative;
		top: -41px;
		box-shadow: 0 5px 20px rgba(0,0,0,.1);
		border-radius: 0;
		transform: scaleY(1);
	}
	#{$random_id}.featured  .pricing_table_heading .holder h2{
		color: #000;
		background: #f6b800;
		padding: 55px 0 34px;
	}
	.whmpress.whmpress_pricing_table.alt-01.featured .pricing_table_heading .populer{
		top: -14px;
		left: 50%;
		opacity: 1;
		width: 124px;
		height: 32px;
		color: #fff;
		font-size: 12px;
		padding: 0 10px;
		line-height: 32px;
		margin-left: -62px;
		border-radius: 2px;
		position: absolute;
		text-align: center;
		background: #d8411e;
		display:block;
	}
	.whmpress.whmpress_pricing_table.alt-01 .pricing_table_heading .populer{
		display:none;
	}
	.whmpress.whmpress_pricing_table.alt-01.featured .pricing_table_heading .populer i.fa.fa-caret-down{
		left: 50%;
		bottom: -8px;
		color: #d8411e;
		position: absolute;
	}

</style>


<div class="whmpress whmpress_pricing_table alt-01 {$featured}" id="{$random_id}">
	<div class="pricing_table_heading">
		<div class="holder">
			<div class="populer"> <i class="fa fa-caret-down" aria-hidden="true"></i>{$featured_text}</div>
			<h2><i class="fa {$sub_icon}" aria-hidden="true"></i>{$product_name}</h2>
		</div>
	</div>
	<div class="pricing_table_detail">
		<div class="holder">
			<p>{$product_detail}</p>
		</div>
	</div>
	<div class="pricing_table_price">
		<div class="holder">
			<i class="fa fa-caret-up" aria-hidden="true"></i>
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
</div>  <!-- /.price-table -->
