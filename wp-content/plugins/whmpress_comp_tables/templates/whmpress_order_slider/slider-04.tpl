<style>
	.wpct_hosting_slider.fourth .ui-state-default,
	.wpct_hosting_slider.fourth .ui-widget-content .ui-state-default,
	.wpct_hosting_slider.fourth .ui-widget-header .ui-state-default {
		background: url("{$smarty.const.WPCT_GRP_URL}/images/slider/handle4.png");
		height: 33px;
		width: 46px;
		top: -20px;
		border: 0;
		outline-color: transparent;
		cursor: pointer;
		margin-left: -23px;
	}
	.wpct_hosting_slider.fourth .wpct_slider_lines {
		background: url("{$smarty.const.WPCT_GRP_URL}/images/slider/slider4-lines1.png") center top;
		height: 10px;
	}
</style>


<div class="wrapper">
	<div class="wpct_hosting_slider fourth" id="slider_{$random}"
		 data-wpct-hide-mobile="{$group.mobile_breakpoint}">

		{foreach $group.plans as $plan}{/foreach}
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
		<div class="wpct_slider_container">
			<div id="wpct_slider"></div>
			<div class="wpct_slider_lines"></div>
		</div>
		<div class="wpct_package_title" id="wpct_package_title"><input type="hidden">
			<ul class="wpct_packages_list">
				{foreach $group.plans as $plan}
					<li class="wpct_package_title"
					    data-index="{$plan@index+1}"
					    data-title="{$plan.name}"
					    data-orderUrl="{$plan.order_url}"
					>
						<span class="wpct_package_title_desktop">{$plan.name}</span>
						<span class="wpct_package_title_mobile">{$plan@index+1}</span>
					</li>
				{/foreach}
			</ul>
		</div>
		<div style="clear: both"></div>

		{foreach $group.plans as $plan}
			<div class="wpct_slider_content {if $plan@index ne 0}wpct_hidden{/if}" id="description_{$plan@index+1}">
				<div class="wpct_slider_output wpct_plan_title_responsive">
					<h3 class="wpct_slider_description_title">{$plan.name}</h3>
				</div>
				{foreach $plan.description_array as $desc}
					{if $desc@index eq 3}{break}{/if}
					<div class="wpct_slider_output" id="{$desc@key|regex_replace:'/[^a-zA-Z]/':''}">
						<h3 class="wpct_slider_description_title">{$desc@key}: </h3>
						<span class="wpct_slider_description_detail">{$desc.value}</span>
					</div>
				{/foreach}
				<div class="wpct_price wpct_slider_output">
					<div class="wpct_price">
						<div class="wpct_holder">
						<span class="wpct_slider_description_detail">
                        	<span class="wpct_unit">{$plan.prefix}</span>
                        	<span class="wpct_amount">{$plan.amount}</span>{if $plan.fraction ne ""}<span class="wpct_decimal">{$plan.decimal}</span><span class="wpct_fraction">{$plan.fraction}</span>{/if}<span class="wpct_period"> /{$plan.billingcycle}</span>
                    	</span>
						</div>
					</div>
					<div class="wpct_slider_submit">
						<a href="{$plan.order_url}" class="wpct_submit">{$group.button_text}</a>
					</div>
				</div> <!-- /.wpct_price -->
				<div style="clear: both"></div>
			</div>
		{/foreach}
	</div>
</div>




<script>
	jQuery(document).ready(function(){
		runSlider(jQuery("#slider_{$random}"));
	});
</script>