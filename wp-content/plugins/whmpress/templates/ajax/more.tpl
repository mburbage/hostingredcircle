
{foreach from=$domains item=domain}
<ul class="whmp_search_ajax_result {if $domain.available == 1}whmp_found_result {else} whmp_not_found_result{/if}">
	<li class="whmp_icon"><i class="fa fa-2x fa-{if $domain.available == 1}check{else}close{/if}"></i></li>
	<li class="whmp_domain"><strong>{$domain.domain}</strong>{$domain.message}</li>
	
	{if $params.show_price == '1'}
	<li class="whmp_domain_price"><span>{$domain.price}</span></li>
	{/if}
	{if $params.show_years == '1'}
	<li class="whmp_duration"><span>{$domain.duration}</span></li>
	{/if}
	
	<li class="whmp_search_ajax_buttons">
		{if $domain.available == 1}
		{if $domain.order_button_text != ""}
		<a class="" href="{$domain.order_url}" {$domain.button_action} {if $params.order_link_new_tab|lower eq "1"} target="_blank" {/if}><i class="fa fa-cart-plus"></i>
			{$domain.order_button_text}</a>
		{$domain.hidden_form}
		{/if}
		{else}
		{if $params.enable_transfer_link|lower eq "yes"}
		<a class="" {$domain.button_action} {if $params.order_link_new_tab|lower eq "1"} target="_blank" {/if} href="{$domain.order_url}" {$domain.button_action}>{$params.transfer_text}</a>
		{$domain.hidden_form}
		{/if}
		{if $smarty.post.www_link != "no"}<a class="" target="_blank"
		                                     href="http://{$domain.domain}">{$params.www_text}</a>{/if}
		{if $smarty.post.whois_link != "no"}<a class="whois-btn" onclick="openWhois('{$domain.whois_link}')">{$params.whois_text}</a>{/if}
		{/if}
	</li>
</ul>
{/foreach}

{$load_more}

{*------------Notes------------

See first.html

------------End Notes------------*}