<div class="row">
	{foreach from=$group.plans item=plan}
	<div class="wpb_column vc_column_container  
		{if $group.plans|count eq 1}vc_col-sm-12
{elseif $group.plans|count eq 2}vc_col-md-4
{elseif $group.plans|count eq 3}vc_col-md-4
{elseif $group.plans|count eq 4}vc_col-md-3
{/if}" data-plan-price="{$plan.prefix}{$plan.amount}{if $plan.fraction ne ""}{$plan.decimal}{$plan.fraction}{/if}">

		<div class="vc_column-inner">
			<div class="wpb_wrapper">
				<div class="pricing  {if $plan.product_id eq $group.important}active{/if}">



					<h3 class="pricing-title id-color">{$plan.name}</h3>


					<div class="pricing-price">

						<p class="price">{$plan.prefix}{$plan.amount}{if
							$plan.fraction ne ""}<span class="decimal">{$plan.decimal}</span><span class="fraction">{$plan.fraction}</span>{/if}</p>
						{if $plan.duration ne ""}
						<span class="per">{$plan.duration}</span>{/if}
						<br /><span class="per">{$plan.all_durations.monthly.discount.discount_string}</span>
					</div>
					<div class="pricing-features">
						{if $plan.cdescription ne ""}
						<div class="pricing_table_detail">
							<div class="holder">
								{$plan.cdescription}
							</div>
						</div>
						{/if}
						{$desc_array = explode(" ", $plan.description[0])}
						{if count($desc_array) lt 25}<div id="desc-{$plan.product_id}" class="pricing-description">{else}
							<div id="desc-{$plan.product_id}" class="expandable-description">{/if}
							{foreach from=$plan.description item=desc name=i}
							{if $smarty.foreach.i.index == $group.rows_table}{break}{/if}
							
							{$string = array_slice($desc_array, 0, 25)}
							{$string_two = array_slice($desc_array, 26)}
							{implode(" ", $string)}
							{/foreach}
							{if count($desc_array) gte 25 }
							<div id="more-btn-{$plan.product_id}" class="more-button" onclick="toggleMoreDescription({$plan.product_id})">Read More<i class="fa-down-chevron"></i></div>
							<span id="{$plan.product_id}" class="full-description">{implode(" ", $string_two)}</span>
							<div id="hide-btn-{$plan.product_id}" class="more-button hide-btn" onclick="toggleMoreDescription({$plan.product_id})"><i class="fa-up-chevron"></i>Close</div>
							{/if}

						</div>
						<div class="price-btn">

							<a type="button" class="ot-btn btn-dark" href="{$plan.order_url}">{$group.button_text}</a>

						</div>

					</div>
				</div> <!-- /.price-table -->
			</div>
		</div>
	</div>
	{/foreach}
	<script>
		/**
			* 
			* ----------- More Button Price Descriptions
			* 
			*/
		function toggleMoreDescription(eventId) {
			document.getElementById(eventId).classList.toggle("show-desc");
			document.getElementById('desc-' + eventId).classList.toggle("show-pricing-description");
			document.getElementById('more-btn-' + eventId).classList.toggle('hide-btn');
			document.getElementById('hide-btn-' + eventId).classList.toggle('hide-btn');
		}

	</script>
</div>
