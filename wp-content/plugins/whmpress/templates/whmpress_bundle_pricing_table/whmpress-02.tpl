<div class="whmpress whmpress_pricing_bundle whmpress-02">
    <div class="pricing_bundle_heading">
        <div class="holder">
            <span>{$name}</span>
        </div>
    </div>
    <div class="pricing_bundle_items">
        {foreach $itemdata as $item}
            <div class="pricing_bundle_item">
                <div class="holder">
                    {if isset($item.id)}
                        <div class="bundle_item_name">
                            Product Name: {$item.item_name}
                        </div>
                    {/if}
                    {if isset($item.billingcycle)}
                        <div class="bundle_item_name">
                            Billing Cycle: {$item.billingcycle}
                        </div>
                    {/if}
                    {if isset($item.price)}
                        <div class="bundle_item_name">
                            Price: {$item.price}
                        </div>
                    {/if}
                    {if isset($item.tlds)}
                        <div class="bundle_item_name">
                            <span>TLDs:</span>
                            {foreach $item.tlds as $tld}
                                <span>{$tld}</span>
                            {/foreach}
                        </div>
                    {/if}
                    {if isset($item.price)}
                        <div class="bundle_item_name">
                            Registration Period: {$item.regperiod }
                        </div>
                    {/if}
                </div>
            </div>
        {/foreach}
    </div>
    <div class="pricing_bundle_submit">
        <div class="holder">
            <a class="whmpress_order_button" href="{$order_link}">{$button_text}</a>
        </div>
    </div>
</div>  <!-- /.price-bundle -->
