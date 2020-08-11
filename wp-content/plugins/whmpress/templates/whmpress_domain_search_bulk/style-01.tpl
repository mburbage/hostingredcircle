
<div class="whmpress whmpress_domain_search_bulk bulk_appended" id="Bulk_HTML_id">    <div>
        <form method="post">
            <div class="bulk-domains">
                {$search_textarea}
            </div>
            <div class="bulk-options">
                <div class="extention-selection">
                    {$extension_selection}
                </div>
                <div class="extentions" style="display:none">
                    {foreach $data_extensions as $ext}
                        <div class="">
                            <input value="{$ext}" id="{$ext}" name="extension[]" type="checkbox">
                            <label for="{$ext}">{$ext}</label>
                        </div>
                    {/foreach}
                </div>
                <div style="clear:both"></div>
                <div class="search-button">
                    {$search_button}
                </div>
            </div>
        </form>
    </div>
    <div style="clear:both"></div>
    {$search_results}
</div>