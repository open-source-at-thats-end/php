<div class="navbar">
    <div class="navbar-inner">
        <div class=" pull-left" >
            <div class="pagination-text">
                <label>Items: <span class="footertalabitems">{count($arrRecordSet.rs)} row(s) / {$total_record} total result(s) (on {$total_record} items)</span></label> |
                <label>Items/Pages: </label>
            </div>
            <div class="btn-group btn-mini page-size-group">
                <select name="page_size" id="page_size">
                    {html_options options=$arrPageSize selected=$arrSearchParams.page_size}
                </select>
               {* {foreach name=psizeInfo from=$arrPageSize item=pageSize}
                    <span class="btn btn-mini hasTooltip {if $pageSize == $arrSearchParams.page_size}active{/if}" data-value="{$pageSize}"  title='Load {$pageSize} rows by page' data-placement='right'>{$pageSize}</span>
                {/foreach}*}
            </div>
        </div>
        <div class="pull-right" >
            <div class="pagination pagination-mini">
                <ul class=''>
                    {html_pager2 num_items=$total_record per_page=$arrSearchParams.page_size add_prevnext_text=true start_item=$arrSearchParams.start_record}
                </ul>
            </div>
        </div>
    </div>
</div>