<div class="row">
	
		{foreach from=$group.plans item=plan}
		<div class="wpb_column vc_column_container  
		{if $group.plans|count eq 1}vc_col-sm-12
{elseif $group.plans|count eq 2}vc_col-md-4
{elseif $group.plans|count eq 3}vc_col-md-4
{elseif $group.plans|count eq 4}vc_col-md-3
{/if}"
			data-plan-price="{$plan.prefix}{$plan.amount}{if $plan.fraction ne ""}{$plan.decimal}{$plan.fraction}{/if}">

			<div class="vc_column-inner">
				<div class="wpb_wrapper">
					<div class="pricing  {if $plan.product_id eq $group.important}active{/if}">



						<h3 class="pricing-title id-color">{$plan.name}</h3>

						<script>console.log({json_encode($plan)});</script>

						<div class="pricing-price">
							
							<p class="price">{$plan.prefix}{$plan.amount}{if
								$plan.fraction ne ""}<span class="decimal">{$plan.decimal}</span><span
									class="fraction">{$plan.fraction}</span>{/if}</p>
							{if $plan.duration ne ""}
							<span class="per">{$plan.duration}</span>{/if}
							<br/>
							{if trim($plan.duration, " ") ne "Monthly"}
							<span class="per">{$plan.all_durations.annually.discount.discount_string}</span>
							{else}
							<span class="per">{$plan.all_durations.monthly.discount.discount_string}</span>
							{/if}
						</div>
						<div class="pricing-features">
							{if $plan.cdescription ne ""}
							<div class="pricing_table_detail">
								<div class="holder">
									{$plan.cdescription}
								</div>
							</div>
							{/if}
							<ul class="price-list">
								{foreach from=$plan.description item=desc name=i}
								{if $smarty.foreach.i.index == $group.rows_table}{break}{/if}
								<li>{$desc}</li>
								{/foreach}
							</ul>
							<div class="price-btn">

								<a type="button" class="ot-btn btn-dark"
									href="{$plan.order_url}">{$group.button_text}</a>

							</div>
						</div>
					</div> <!-- /.price-table -->
				</div>
			</div>
		</div>
		{/foreach}
	
</div>