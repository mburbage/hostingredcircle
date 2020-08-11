<style>
	.wpct_hosting_slider.slider-09 .ui-state-default,
	.wpct_hosting_slider.slider-09 .ui-widget-content .ui-state-default,
	.wpct_hosting_slider.slider-09 .ui-widget-header .ui-state-default {
		width: 19px;
		height: 25px;
		top: -9px;
		margin-left: -9px;
		background: url({$smarty.const.WPCT_GRP_URL}/images/slider/handle9.png) no-repeat left;
		outline-color: transparent;
		cursor: pointer;
		border: 0;
	}
	.wpct_hosting_slider.slider-09 .wpct_package_title ul li > .wpct_package_title_desktop{
		background: url({$smarty.const.WPCT_GRP_URL}/images/slider/slider-9-plan.gif) no-repeat center;
		height: 27px;
		width: 46px;
		margin: 0 auto;
	}
	.wpct_hosting_slider.slider-09 .wpct_package_title ul li.active > .wpct_package_title_desktop{
		background: url({$smarty.const.WPCT_GRP_URL}/images/slider/slider-9-plan-active.gif) no-repeat center;
	}
</style>


<div class="wrapper">
	<div class="wpct_hosting_slider slider-09 wpct_slider_has_toggle" id="slider_{$random}" data-wpct-hide-mobile="{$group.mobile_breakpoint}">

		<ul id="JS_Data" style="display: none !important;">
			{foreach $group.plans as $plan}
			<li data-index="{$plan@index+1}" data-order="{$plan.order_url}">
				{foreach $plan.description_array as $desc}
				{if $desc@index eq $group.rows_slider}{break}{/if}
				<span data-index="{$desc@key}">{$desc.value}</span>
				{/foreach}
			</li>
			{/foreach}
		</ul>


		<div class="wpct_price_toggle">
			{$group.duration_toggle}
		</div>
		{if $group.show_discount ne "no"}
			<div class="wpct_slider_discounts_container">
				{foreach $group.plans as $plan}
					<div class="wpct_slider_discount {if $plan@index ne 0}wpct_hidden{/if}"
					     id="discount_{$plan@index+1}">
						{$plan.multi_discount}
					</div>
				{/foreach}
			</div>
		{/if}
		<div style="clear: both;"></div>


		<div class="wpct_slider_heading">
			<span>{$group.plans[0].name}</span>
		</div>
		<div class="wpct_slider_container">
			<div>
				<div id="wpct_slider"></div>
				<div class="wpct_package_title" id="wpct_package_title"><input type="hidden">
					<ul class="wpct_packages_list">
						{foreach $group.plans as $plan}
						<li class="wpct_package_title"
						    data-index="{$plan@index+1}"
						    data-title="{$plan.name}"
						    data-orderUrl="{$plan.order_url}"
						>
							<div class="wpct_package_title_desktop"></div>
							<div class="wpct_package_title_mobile">{$plan@index+1}</div>
						</li>
						</li>
						{/foreach}
					</ul>
				</div>
				<div style="clear: both"></div>
			</div>
		</div>
		<div class="wpct_slider_content_container">
			{foreach $group.plans as $plan}
			<div class="wpct_slider_content {if $plan@index ne 0}wpct_hidden{/if}" id="description_{$plan@index+1}">
				<div class="wpct_description_holder">
					{foreach $plan.description_array as $desc}
					{if $desc@index eq 4}{break}{/if}
					<div class="wpct_slider_output" id="{$desc@key|regex_replace:'/[^a-zA-Z]/':''}">
						<div class="wpct_slider_description_title">{$desc@key}:</div>
						<strong class="wpct_slider_description_detail">{$desc.value}</strong>
					</div>
					{/foreach}
					<div class="wpct_price_holder wpct_slider_output">
						<div class="wpct_slider_description_title">
							{$plan.multi_price}
						</div>
						<div class="wpct_slider_description_detail">
							{$plan.multi_price}
						</div>
					</div> <!-- /.wpct_price -->
					<div class="wpct_slider_submit">
						{$plan.multi_button}
					</div>
				</div>
				<div style="clear: both"></div>
			</div>
			{/foreach}
		</div>
	</div>
</div>