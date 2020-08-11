<div class="wrapper">
	<div class="wpct_hosting_slider slider-10 wpct_slider_has_toggle" id="slider_{$random}" data-wpct-hide-mobile="{$group.mobile_breakpoint}">

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

		{if $group.show_discount ne "no"}
			<div class="wpct_price_toggle">
				{$group.duration_toggle}
			</div>
			{foreach $group.plans as $plan}
				<div class="wpct_slider_discount {if $plan@index ne 0}wpct_hidden{/if}" id="discount_{$plan@index+1}">
					{$plan.multi_discount}
				</div>
			{/foreach}
		{/if}
		<div class="wpct_price_heading">
			{foreach $group.plans as $plan}
				<div class="wpct_slider_head_prices {if $plan@index ne 0}wpct_hidden{/if}"
				     id="head_price_{$plan@index+1}">
					{$plan.multi_price}
				</div>
			{/foreach}
		</div>
		<div style="clear: both"></div>


		<div class="wpct_slider_heading">
			<span>{$group.plans[0].name}</span>
		</div>
		<div class="wpct_slider_container">
			<div>
				<div id="wpct_slider">
					{foreach $group.plans as $plan}
					<span class="wpct_slider_pipe"></span>
					{/foreach}
				</div>
				<div class="wpct_package_title" id="wpct_package_title"><input type="hidden">
					<ul class="wpct_packages_list">
						{foreach $group.plans as $plan}
						<li class="wpct_package_title"
						    data-index="{$plan@index+1}"
						    data-title="{$plan.name}"
						    data-orderUrl="{$plan.order_url}"
						>
							<div class="wpct_package_title_desktop"><span class="currency">{$plan.prefix}</span><span class="amount">{$plan.amount}</span>{if $plan.fraction ne ""}<span class="decimal">{$plan.decimal}</span><span class="fraction">{$plan.fraction}</span>{/if}</div>
							<div class="wpct_package_title_mobile"><span class="currency">{$plan.prefix}</span><span class="amount">{$plan.amount}</span>{if $plan.fraction ne ""}<span class="decimal">{$plan.decimal}</span><span class="fraction">{$plan.fraction}</span>{/if}</div>
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
						<strong class="wpct_slider_description_detail">{$desc.value}</strong>
						<div class="wpct_slider_description_title">{$desc@key}:</div>
					</div>
					{/foreach}
					<div class="wpct_price_holder wpct_slider_output">
						<div class="wpct_price_d">
							<div class="wpct_holder">
								<strong class="wpct_slider_description_detail wpct_price">Per {$plan.multi_duration}</strong>
								<div class="wpct_slider_description_title">Duration</div>
							</div>
						</div>
					</div> <!-- /.wpct_price -->
					<div style="clear: both"></div>
				</div>
				<div class="wpct_slider_submit">
					{$plan.multi_button}
				</div>
			</div>
			{/foreach}
		</div>
	</div>
</div>