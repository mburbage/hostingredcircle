<style>
	.wpct_hosting_slider.slider-06 .ui-state-default,
	.wpct_hosting_slider.slider-06 .ui-widget-content .ui-state-default,
	.wpct_hosting_slider.slider-06 .ui-widget-header .ui-state-default {
		background: url("{$smarty.const.WPCT_GRP_URL}/images/slider/handle6.png");
		height: 20px;
		width: 20px;
		top: -2px;
		border: 0;
		outline-color: transparent;
		cursor: pointer;
		margin-left: -10px;
		background-size: cover;
	}
	.wpct_hosting_slider.slider-06 {
		background: url("{$smarty.const.WPCT_GRP_URL}/images/slider/bg-slider-6.png") no-repeat center center,
		#6a94d2 radial-gradient(ellipse at center,  #6f8ccd 0%, #414a8e  100%);
	}
</style>


<div class="wrapper">
	<div class="wpct_hosting_slider slider-06" id="slider_{$random}"
		 data-wpct-hide-mobile="{$group.mobile_breakpoint}">

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

		<div class="wpct_slider_content_container">
			{foreach $group.plans as $plan}
				<div class="wpct_slider_content {if $plan@index ne 0}wpct_hidden{/if}" id="description_{$plan@index+1}">
					<div class="wpct_description_holder">
						{foreach $plan.description_array as $desc}
							{if $desc@index eq 4}{break}{/if}
							<div class="wpct_slider_output" id="{$desc@key|regex_replace:'/[^a-zA-Z]/':''}">
								<strong class="wpct_slider_description_detail">{$desc.value}</strong>
								<div class="wpct_slider_description_title">{$desc@key}:</div>
							</div>
						{/foreach}
					</div>
					<div class="wpct_price_holder wpct_slider_output">
						<div class="wpct_price">
							<div class="wpct_holder">
						<span class="wpct_slider_description_detail">
                        	<span class="currency">{$plan.prefix}</span><span class="amount">{$plan.amount}</span>{if $plan.fraction ne ""}<span
									class="decimal">{$plan.decimal}</span><span class="fraction">{$plan.fraction}</span>{/if}<span
									class="duration"> /{$plan.billingcycle}</span>
                    	</span>
							</div>
						</div>
						<div class="wpct_slider_submit">
							<a href="{$plan.order_url}" class="wpct_submit whmpress_order_button">{$group.button_text}</a>
						</div>
					</div> <!-- /.wpct_price -->
					<div style="clear: both"></div>
				</div>
			{/foreach}
		</div>

		<div class="wpct_slider_container">
			<div id="wpct_slider"></div>
		</div>
		<div class="wpct_package_title" id="wpct_package_title"><input type="hidden">
			<ul class="wpct_packages_list">
				{foreach $group.plans as $plan}
					<li class="wpct_package_title"
					    data-index="{$plan@index+1}"
					    data-title="{$plan.name}"
					    data-orderUrl="{$plan.order_url}"
					>
						<div class="wpct_package_title_desktop">
							<div>{$plan.name}</div>
							<div>{$plan.price}</div>
						</div>
						<div class="wpct_package_title_mobile">{$plan@index+1}</div>
					</li>
					</li>
				{/foreach}
			</ul>
		</div>
		<div style="clear: both"></div>
	</div>
</div>


<script>
	jQuery(document).ready(function () {
		runSlider(jQuery("#slider_{$random}"));
	});
</script>