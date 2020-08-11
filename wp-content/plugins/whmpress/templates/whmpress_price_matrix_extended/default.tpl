<div class="whmpress whmpress_price_matrix">
    {if $params.data_table|lower eq "yes"}
        <script>
            jQuery(function () {
                jQuery('table#{$params.table_id}').DataTable();
            });
        </script>
    {elseif $params.hide_search|lower eq "yes"}
        <label>{$search_label}</label>
        <input type='search' placeholder='Search' id='{$params.table_id}_search_price_table' style='width:50%'>
        <script>
            jQuery(function () {
                jQuery('input#{$params.table_id}_search_price_table').quicksearch('table#{$params.table_id} tbody tr');
            });
        </script>
    {/if}
    <div class="table-responsive">
        <table id='{$params.table_id}' class="table-responsive table-striped table-condensed">
            <thead>
            <tr>
                {if $sr_title}
                    <th>{$sr_title}</th>
                {/if}
                {if $id_title}
                    <th>{$id_title}</th>
                {/if}
                {if $name_title}
                    <th>{$name_title}</th>
                {/if}
                {if $group_title}
                    <th>{$group_title}</th>
                {/if}
                {if !empty($description_column) || $description_column gt "0" }
                    {foreach $custom_description_label as $index => $desciption_column}
                        <th>{$desciption_column}</th>
                    {/foreach}
                {/if}
                {if $monthly_title}
                    <th>{$monthly_title}</th>
                {/if}
                {if $quarterly_title}
                    <th>{$quarterly_title}</th>
                {/if}
                {if $semiannually_title}
                    <th>{$semiannually_title}</th>
                {/if}
                {if $annually_title}
                    <th>{$annually_title}</th>
                {/if}
                {if $biennially_title}
                    <th>{$biennially_title}</th>
                {/if}
                {if $triennially_title}
                    <th>{$triennially_title}</th>
                {/if}
                <th>Order Now</th>
                <th>Details</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$data item=whmp}
                <tr>
                    {if $sr_title}
                        <td data-content="{$sr_title}">{$whmp.sr}</td>
                    {/if}
                    {if $id_title}
                        <td data-content="{$id_title}">{$whmp.id}</td>
                    {/if}
                    {if $name_title}
                        <td data-content="{$name_title}">{$whmp.name}</td>
                    {/if}
                    {if $group_title}
                        <td data-content="{$group_title}">{$whmp.group}</td>
                    {/if}
                    {if !empty($description_column) || $description_column gt "0" }
                        {assign var=val value=0}
                        {foreach $whmp.description_extended as $product_index => $value_array}
                            {if !empty($value_array.feature_value)}
                                {if $val lt $description_column}
                                    <td data-content="">{$value_array.feature_value}</td>
                                    {assign var=val value=$val+1}
                                {/if}
                            {else}
                                {foreach $value_array as $value_index => $value}
                                    {if $val lt $description_column}
                                        <td data-content="">{$value.feature_value}</td>
                                        {assign var=val value=$val+1}
                                    {/if}
                                {/foreach}
                            {/if}
                        {/foreach}
                    {/if}
                    {if $monthly_title}
                        <td data-content="{$monthly_title}">{$whmp.monthly}</td>
                    {/if}
                    {if $quarterly_title}
                        <td data-content="{$quarterly_title}">{$whmp.quarterly}</td>
                    {/if}
                    {if $semiannually_title}
                        <td data-content="{$semiannually_title}">{$whmp.semiannually}</td>
                    {/if}
                    {if $annually_title}
                        <td data-content="{$annually_title}">{$whmp.annually}</td>
                    {/if}
                    {if $biennially_title}
                        <td data-content="{$biennially_title}">{$whmp.biennially}</td>
                    {/if}
                    {if $triennially_title}
                        <td data-content="{$triennially_title}">{$whmp.triennially}</td>
                    {/if}
                    <td data-content="Order Now">{if $whmp.order_url}{$whmp.order_url}{/if}</td>
                    <td>{$whmp.detail_url}</td>

                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>