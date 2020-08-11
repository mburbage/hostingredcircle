
<div class="whmpress_domain_price_list whmpress simple-01">
    <ul>
        {foreach $data as $domain}
            <li>
			<span class="domain_tld">
				<span class="domain_tld_title price_title">TLD Text:</span>
				<span class="domain_tld_value price_value">{$domain.tld}</span>
			</span>
                <span class="registration_price">
				<span class="registration_price_title price_title">Registration Price:</span>
				<span class="registration_price_value price_value">
                    <span class="price_complete">{$domain.register}</span>
                    {*<span class="price_unit">$</span><span class="price_amount">9</span><span class="price_decimal">.</span><span class="price_fraction">98</span>*}
				</span>
			</span>
                <span class="registration_duration">
				<span class="registration_duration_title price_title">Registration Period:</span>
				<span class="registration_duration_value price_value">{$domain.years}</span>
			</span>
                <span class="renew_price">
				<span class="renew_price_title price_title">Renew Price:</span>
				<span class="renew_price_value price_value">
                    <span class="price_complete">{$domain.renewal}</span>
				</span>
			</span>
                <span class="transfer_price">
				<span class="transfer_price_title price_title">Transfer Price:</span>
				<span class="transfer_price_value price_value">
                    <span class="price_complete">{$domain.transfer}</span>
				</span>
			</span>
            </li>
        {/foreach}

    </ul>
</div>