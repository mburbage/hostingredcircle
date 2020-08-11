<div class="wcop_df_domain_search_ajax_result " style="margin-top: -20px;">
	<form action="{$whmcs_url}"></form>
	{literal}
		<script>
			function openWhois( a ) {
				window.open( a, "whmpwin", "width=600,height=600,toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=0" );
			}
		</script>
	{/literal}
	<div class="wcop_df_page_header" style="margin-bottom: 20px;">
		<div class="wcop_df_domain_title {if $data.available == 1} wcop_df_domain_title_found {else} wcop_df_domain_title_not_found {/if}">
			<div class="wcop_df_domain_name">
				<strong>{$data.domain}</strong>
			</div>
			<div class="wcop_df_domain_message">
				{if $data.available == 1}
					{$data_year = ''}
					{$data_price = ''}
					{foreach $data.multi_price as $multi}
						{$data_year = $multi@key}
						{$data_price = $multi['price']}
						{break}
					{/foreach}
					<input
							type="checkbox"
							id="whcom_tld_{$data.extension|replace:'.':'_'}"
							value="{$data.extension}"
							name="whcom_tld_add_remove"
							style="display: none"
							data-cart-index="-1"
							data-domain="{$data.domain}"
							data-domain-price="{$data_price}"
							data-domain-type="register"
							data-domain-duration="{$data_year}"
					>
					<label for="whcom_tld_{$data.extension|replace:'.':'_'}" class="title_label">
						{$data.message}
					</label>
				{else}
					<i class="whcom_icon_attention-alt"></i>
					{$data.message}
				{/if}
			</div>
		</div>
	</div>
	<div class="wcop_df_sub_heading whcom_text_center_xs">
		<span>{$data.recommended_domains_text}</span>
	</div>
	<div class="wcop_df_domain_search_result_content wcop_df_page_content">
		<div class="wcop_df_domain_icon wcop_df_page_content_icon">
			<i class="whcom_icon_user-2"></i>
		</div>
		<div class="wcop_df_page_content_icon_text">
			<strong>Stake Your Claim !</strong>
		</div>
		<div class="wcop_df_domain_submit">
			<a href="{$form_url}" id="wcop_df_domain_submit_button" class="whcom_button whcom_button_large whcom_button_success" {$data.button_action} disabled="disabled">
				Continue <i class="fa fa-chevron-right"></i>
			</a>
		</div>
		<div class="result-div">
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
		</div>
	</div>
</div>
{*
<pre>{$data|@var_dump}</pre>
<pre>{$domains|@var_dump}</pre>
<pre>{$smarty.post|@print_r}</pre>
*}

{*------------Notes------------


Short-code:
=========
Template in folder ajax are used to display result part of ajax domain search. These are used for ajax part of following short-codes
[domain_search_ajax]
[domain_search_ajax_results]
[domain_search_ajax_extended]
[domain_search_ajax_extended_results]

There are two templates.
first.html = used for first ajax results
more.html = used for results that come after "load more"

following place holders are available for both templates in all short-codes above

Place Holders:
=============

$data: Data array containing all details for searched domain with default tld.

Following Elements are used with $data array only
{$data.domain}: returns searched domain name with default tld.
{$data.message}: returns success of failure message set in whmpress settings
{$data.available}: returns a boolean value of "1" or "0" based on search result
{$data.order_button_text}: returns text value entered in short-code for "order button text".
{$data.recommended_domains_text}: returns recommended domains text set in whmpress settings

$domains: Domains array containing all details for searched domain results. Can be used in foreach loop

Following Elements are used with $domains array only
{foreach from=$domains item=domain}: example for usage of $domains array in foreach loop.
{$domain.domain}: returns searched domain name with tld.
{$domain.message}: returns success of failure message set in whmpress settings.
{$domain.price}: returns registration price for current tld in loop.
{$domain.duration}: returns duration of registration.
{$domain.order_url}: returns order url for each domain if domain is available.
{$domain.whois_link}: returns whois url for each domain if domain is not available.

{$load_more}: returns html for "Load More" button.


Example:
========
Template is example itself

Important:
==========
class="result-div" on results container is required for AJAX functionality.
------------End Notes------------*}