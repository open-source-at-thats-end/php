<div id="col-container">
    <div id="-vcol-right">
        <div id="msg_box">{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}</div>
        <div>
            <div class="vlist-head">
                <div class="main-">
                    <table class="wp-list-table table table-bordered  table-condensed table-pre">
                        <thead>
                        <tr>
                            <th width="">Title</th>
                            <th width="">Search Criteria</th>
{*                            <th width="">Total Results</th>*}
                            <th width="">Tag</th>
                            <th width="">Short Code</th>
                            <th width="">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="-vlist-data" id="agent-list-holder">
    {*include file="listing/list-data.tpl"*}
    <div class="main-">
        <table class="table table-bordered  table-condensed table-hover  table-striped table-pre">
            <tbody id="the-list">
            {if count($rsPredefined) > 0}
                {foreach $rsPredefined as $record}
                    <tr>
                        <td width="">{$record['psearch_title']}</td>
                        <td width="">{include file='predefined/search_criteria.tpl' arrSearchResult=$record.psearch_criteria}</td>
{*                        <td width="">{$objAdminPre->getPropertyCount($record['psearch_id'])}</td>*}
                        <td width="">{$record['psearch_tag']}</td>
                        <td width="">{$record['shortcode']}</td>
                        <td width="">
                            <a href="JavaScript: void(0);" class="vlink_listing" data-link="{$scriptname}&action=view&psearch_id={$record['psearch_id']}" id="a_view" ><b>View Listing</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                {/foreach}
            {else}
                <tr class="alt"><td colspan="5">No Data Found.</td></tr>
            {/if}
            </tbody>
        </table>
    </div>
</div>