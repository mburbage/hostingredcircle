<style>
	.wpct_hosting_slider.third .ui-state-default,
	.wpct_hosting_slider.third .ui-widget-content .ui-state-default,
	.wpct_hosting_slider.third .ui-widget-header .ui-state-default {
		background: url("{$smarty.const.WPCT_GRP_URL}/images/slider/handle3.png");
		height: 28px;
		width: 12px;
		top: -5px;
		border: 0;
		margin-left: -6px;
		outline-color: transparent;
		cursor: pointer;
	}
</style>

<div class="wrapper"
	 data-wpct-hide-mobile="{$group.mobile_breakpoint}">
	<div class="wpct_hosting_slider third" id="slider_{$random}">

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

		<div class="wpct_slider_heading wpct_package_title_mobile">
			<span>{$group.plans[0].name}</span>
		</div>

		{foreach $group.plans as $plan}
			<div class="wpct_slider_content {if $plan@index ne 0}wpct_hidden{/if}" id="description_{$plan@index+1}">
				{foreach $plan.description_array as $desc}
					{if $desc@index eq $group.rows_slider}{break}{/if}
					<div class="wpct_slider_output" id="{$desc@key|regex_replace:'/[^a-zA-Z]/':''}">
						<span class="wpct_slider_description_title">{$desc@key}: </span>
						<span class="wpct_slider_description_detail">{$desc.value}</span>
					</div>
				{/foreach}
				<div style="clear: both"></div>
			</div>
		{/foreach}
		<div class="bottom-holder">
			<div class="slider-container">
				<div id="wpct_slider"></div>
				<div class="wpct_package_title" id="wpct_package_title"><input type="hidden">
					<ul class="wpct_packages_list">
						{foreach $group.plans as $plan}
							<li class="wpct_package_title"
							    data-index="{$plan@index+1}"
							    data-title="{$plan.name}"
							    data-orderUrl="{$plan.order_url}"
							>{$plan@index}</li>
						{/foreach}
					</ul>
				</div>
			</div>
			{foreach $group.plans as $plan}
				<div class="wpct_price wpct_price_sep wpct_slider_output {if $plan@index ne 0}wpct_hidden{/if}" id="wpct_price_{$plan@index+1}">
					<div class="wpct_holder">
						<span class="wpct_period wpct_slider_description_title">{$plan.billingcycle}</span>
						<span class="wpct_slider_description_detail">
                        <span class="wpct_unit">{$plan.prefix}</span>
                        <span class="wpct_amount">{$plan.amount}</span>{if $plan.fraction ne ""}<span class="wpct_decimal">{$plan.decimal}</span><span class="wpct_fraction">{$plan.fraction}</span>{/if}
                    </span>
					</div>
				</div> <!-- /.wpct_price -->
			{/foreach}
			<div style="clear: both"></div>
		</div>



		<div style="clear: both"></div>
		<div class="wpct_slider_submit_button no_multi">
			<a href="{$plan.order_url}" class="wpct_submit">{$group.button_text}</a>
		</div>
	</div>
</div>


<script>
	jQuery(document).ready(function(){
		runSlider(jQuery("#slider_{$random}"));
	});
</script>