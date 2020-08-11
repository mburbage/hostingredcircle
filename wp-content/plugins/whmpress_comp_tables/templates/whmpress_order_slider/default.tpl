<div class="wrapper">
    <div class="wpct_hosting_slider first wpct_slider_has_toggle" id="slider_{$random}" data-wpct-hide-mobile="{$group.mobile_breakpoint}">

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

        <div class="wpct_slider_heading wpct_package_title_mobile">
            <span>{$group.plans[0].name}</span>
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
        <div id="wpct_slider"></div>

        {foreach $group.plans as $plan}
        <div class="wpct_slider_content {if $plan@index ne 0}wpct_hidden{/if}" id="description_{$plan@index+1}">
            {foreach $plan.description_array as $desc}
            {if $desc@index eq $group.rows_slider}{break}{/if}
            <div class="wpct_slider_output" id="{$desc@key|regex_replace:'/[^a-zA-Z]/':''}">
                <span class="wpct_slider_description_title {if $desc.tooltip ne ''}wpct_has_tooltip{/if}" {if $desc.tooltip !=""} title="{$desc.tooltip}"{/if}>{$desc@key}: </span>
                <span class="wpct_slider_description_detail">{$desc.value}</span>
            </div>
            {/foreach}
            <div class="wpct_price wpct_slider_output">
	            {$plan.multi_price}
            </div> <!-- /.wpct_price -->
            <div style="clear: both"></div>
	        <br>
            <div class="wpct_slider_submit_button">
		        {$plan.multi_button}
            </div>
        </div>
        {/foreach}
    </div>
</div>