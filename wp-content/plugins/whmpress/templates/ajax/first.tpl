

<div class="whmp_domain_search_ajax_results">
	{literal}

	<script>
		function openWhois( a ) {
			window.open( a, "whmpwin", "width=600,height=600,toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=0" );
		}
	</script>


	{/literal}
	<div class="whmp_search_ajax_title {if $data.available == 1} whmp_found_title {else} whmp_not_found_title {/if}">
		<div class="whmp_search_ajax_domain">
			{$data.domain}
		</div>
		<div class="whmp_search_ajax_message">
			{$data.message}
		</div>
		<div class="whmp_search_ajax_buttons">
			{if $data.available == 1}
			<div class="whmp_title_price">
				{if $smarty.post.show_price == "1"}<span class="whmp_domain_price">{$data.price}</span>{/if}
				{if $smarty.post.show_years == "1"}<span class="whmp_duration">{$data.duration}</span>{/if}
			</div>

			{if $data.order_button_text != ""}
			<a href="{$data.order_url}" {if $data.params.order_link_new_tab|lower eq "1"} target="_blank" {/if} class="" {$data.button_action}><i class="fa fa-cart-plus"></i>
				{$data.order_button_text}</a>
			{$data.hidden_form}
			{/if}
			{else}
			{if $smarty.post.enable_transfer_link|lower eq "yes"}
			<a class="" href="{$data.order_url}" {if $data.params.order_link_new_tab|lower eq "1"} target="_blank" {/if} {$data.button_action}>{$data.params.transfer_text}</a>
			{$data.hidden_form}
			{/if}
			{if $smarty.post.www_link|lower != "no"}
			<a class="" target="_blank" href="http://{$data.domain}">{$data.params.www_text}</a>
			{/if}
			{if $smarty.post.whois_link|lower != "no"}
			<a class="whois-btn" onclick="openWhois('{$data.whois_link}')">{$data.params.whois_text}</a>
			{/if}
			{/if}
		</div>
	</div>
	<h3>{$data.recommended_domains_text}</h3>
	<div class="result-div">
		{foreach from=$domains item=domain}
		<ul class="whmp_search_ajax_result {if $domain.available == 1}whmp_found_result {else} whmp_not_found_result{/if}">
			<li class="whmp_icon"><i class="fa fa-2x fa-{if $domain.available == 1}check{else}close{/if}"></i></li>
			<li class="whmp_domain"><strong>{$domain.domain}</strong>{$domain.message}</li>
			{if $smarty.post.show_price != "0"}
			<li class="whmp_domain_price">{$domain.price}</li>
			{/if}
			{if $smarty.post.show_years != "0"}
			<li class="whmp_duration">{$domain.duration}</li>
			{/if}
			<li class="whmp_search_ajax_buttons">
				{if $domain.available == 1}
				{if $domain.order_button_text != ""}
				<a class="" href="{$domain.order_url}" {if $data.params.order_link_new_tab|lower eq "1"} target="_blank" {/if} {$domain.button_action}><i class="fa fa-cart-plus"></i>
					{$domain.order_button_text}</a>
				{$domain.hidden_form}
				{/if}
				{else}
				{if $smarty.post.enable_transfer_link|lower eq "yes"}
				<a class="" {if $data.params.order_link_new_tab|lower eq "1"} target="_blank" {/if} href="{$domain.order_url}" {$domain.button_action}>{$data.params.transfer_text}</a>
				{$domain.hidden_form}
				{/if}
				{if $smarty.post.www_link|lower != "no"}<a class="" target="_blank" href="http://{$domain.domain}">{$data.params.www_text}</a>{/if}
				{if $smarty.post.whois_link|lower != "no"}<a class="whois-btn" onclick="openWhois('{$domain.whois_link}')">{$data.params.whois_text}</a>{/if}
				{/if}
			</li>
		</ul>
		{/foreach}
		{$load_more}
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