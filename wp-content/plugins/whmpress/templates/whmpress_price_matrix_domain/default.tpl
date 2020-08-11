<style>
    @media only screen and (min-width: 641px) {
        .whmpress.whmpress_price_matrix_domain.testing ul {
            width: 100%;
            display: table;
            table-layout: fixed;
        }

        .whmpress.whmpress_price_matrix_domain.testing ul li {
            display: table-cell;
            width: auto;
            vertical-align: middle;
            padding: 15px 8px;
        }

        .whmpress.whmpress_price_matrix_domain.testing .whmpress-table-heading {
            background: #3a679d;
            color: #ffffff;
            text-transform: capitalize;
            font-weight: 700;
        }

        .whmpress.whmpress_price_matrix_domain .whmpress-table-content {
            border: 1px solid grey;
        }
    }
    .whmpress.whmpress_price_matrix_domain.testing .whmpress_table-value:nth-of-type(even) {
        background: #eee;
    }
    @media only screen and (max-width: 640px) {
        .whmpress.whmpress_price_matrix_domain.testing ul li:before {
            content: attr(data-content) ": ";
            display: inline-block;
            font-weight: bold;
            width: 45%;
        }
        .whmpress.whmpress_price_matrix_domain.testing .whmpress-table-heading{
            display: none;
        }
        .whmpress.whmpress_price_matrix_domain.testing .whmpress_table-value{
            padding: 10px;
        }
    }
</style>
<div id="domain-list-id" class="whmpress whmpress_price_matrix_domain testing">
    <div class="whmpress-table-content">
        <ul class="whmpress-table-heading">
            {foreach $data as $index => $single_data_array}
                {if $index eq 0}
                    {foreach $single_data_array as $key=>$value}
                        <li>{$key}</li>
                    {/foreach}
                {/if}

            {/foreach}
        </ul>

        {foreach $data as $index => $single_data_array}
            <ul class="whmpress_table-value">
                {foreach $single_data_array as $key=>$value}
                    <li data-content="{$key}">{$value}</li>
                {/foreach}

            </ul>
        {/foreach}
    </div>
</div>