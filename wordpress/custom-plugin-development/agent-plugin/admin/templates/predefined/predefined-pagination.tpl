{if $total_record >= $page_size}
    <div class="vlist-footer" id="list-pagination">
        <div class="navbar">
            <div class="navbar-inner">
                <div class=" pull-left" >
                    <div class="pagination-text">
                        <label>Items: <span class="footertalabitems">{$totalFetched} row(s) / {$total_record} total result(s) (on {$total_record} items)</span></label>
                    </div>

                </div>
                <div class="pull-right" >
                    <div class="pagination pagination-mini">
                        <ul class=''>
                            {html_pager2 num_items=$total_record per_page=$page_size add_prevnext_text=true start_item=$startRecord}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}