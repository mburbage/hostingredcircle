
{foreach from=$domains item=domain}

	<ul class="wcop_df_domain_result {if $domain.available == 1}wcop_df_domain_result_found {else} wcop_df_domain_result_not_found{/if} whcom_clearfix">
		<li class="wcop_df_domain_result_icon">
			{if $domain.available == 1}
				{$domain_year = ''}
				{$domain_price = ''}
				{foreach $domain.multi_price as $multi}
					{$domain_year = $multi@key}
					{$domain_price = $multi['price']}
					{break}
				{/foreach}
				<input
						type="checkbox"
						id="whcom_tld_{$domain.extension|replace:'.':'_'}"
						value="{$domain.extension}"
						name="whcom_tld_add_remove"
						style="display: none"
						data-cart-index="-1"
						data-domain="{$domain.domain}"
						data-domain-price="{$domain_price}"
						data-domain-type="register"
						data-domain-duration="{$domain_year}"
				>
				<label for="whcom_tld_{$domain.extension|replace:'.':'_'}" class="label_icon"><i class="whcom_icon_circle-empty"></i></label>
			{else}
				<i class="whcom_icon_cancel-circled2"></i>
			{/if}
		<li class="wcop_df_domain_result_name">{$domain.domain}</li>
		<li class="wcop_df_domain_result_extension"><strong>.{$domain.extension}</strong></li>
		<li class="wcop_df_domain_result_buttons">
			{if $domain.available == 1}
				{if $domain.order_button_text != ""}
					<div style="display: block" id="whcom_tld_{$domain.extension|replace:'.':'_'}_add_sub" class="wcop_df_domain_result_add">
						<label for="whcom_tld_{$domain.extension|replace:'.':'_'}" class="button_label whcom_button">{$domain.order_button_text}</label>
					</div>
					<div style="display: none" id="whcom_tld_{$domain.extension|replace:'.':'_'}_remove_sub" class="wcop_df_domain_result_added">
									<span class="wcop_df_domain_selected_button">
										<i class="whcom_icon_user-2"></i> Selected
									</span>
						<label for="whcom_tld_{$domain.extension|replace:'.':'_'}" class="remove_label">
							<i class="whcom_icon_cancel"></i>
						</label>
					</div>
				{/if}
			{else}
				<span class="wcop_df_domain_result_message">{$domain.message}</span>
			{/if}
		</li>
	</ul>
{/foreach}

{$load_more}

{*------------Notes------------

See first.html

------------End Notes------------*}