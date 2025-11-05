<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav apm_nav">
            <li>
				<span class="topmodultitle">
					<i class="icon2 icon2-listings"></i>Manage Market Reports
				</span>
            </li>
        </ul>
    </div>
</div>

<a href="{$scriptname}&action=add"  id="a_add" class="pull-right"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp<b>Add New</b></a>&nbsp;&nbsp;

<form id="frmStdForm" name="frmStdForm" action="" method="post">
    <div id="col-container">
        <div id="-vcol-right">
            <div id="msg_box">{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}</div>
            <div>
                <div class="vlist-head">
                    <div class="main-">
                        <table class="wp-list-table table table-bordered  table-condensed">
                            <thead>
                            <tr>
                                <th width="12%">No.</th>
                                <th width="12%">Name</th>
                                <th width="12%">City</th>
                                <th width="10%">Action</th>
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
            <table class="table table-bordered  table-condensed table-hover  table-striped">
                <tbody id="the-list">
                {if count($rsMarketRepo) > 0}
                    {assign var=i value=1}
                    {foreach $rsMarketRepo as $record}
                        <tr>
                            <td width="12%">{$i}</td>
                            <td width="12%">{$record['mr_name']}</td>
                            <td width="12%">{$record['mr_city']}</td>
                            <td width="10%">
                                <a href="{$scriptname}&action=edit&pk={$record['mr_id']}"  id="a_edit" ><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp<b>Edit</b></a>&nbsp;&nbsp;
                                <a href="javascript:void(0);"  id="a_delete" onclick="JavaScript:CDelete_Click('{$scriptname}', '{$record['mr_id']}', '');"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp<b>Delete</b></a>&nbsp;&nbsp;
                            </td>
                        </tr>
                        {capture assign=i}{$i+1}{/capture}
                    {/foreach}
                {else}
                    <tr class="alt"><td colspan="5">No Data Found.</td></tr>
                {/if}
                </tbody>
            </table>
        </div>
    </div>
</form>
{if $totalFetched >= $page_size}
    <div class="vlist-footer" id="list-pagination">
        <div class="navbar">
            <div class="navbar-inner">
                <div class=" pull-left" >
                    <div class="pagination-text">
                        <label>Items: <span class="footertalabitems">{$total_record} row(s) / {$totalFetched} total result(s) (on {$totalFetched} items)</span></label>
                    </div>

                </div>
                <div class="pull-right" >
                    <div class="pagination pagination-mini">
                        <ul class=''>
                            {html_pager2 num_items=$totalFetched per_page=$page_size add_prevnext_text=true start_item=$startRecord}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function(){


        });
        function CDelete_Click(frm, PK, msg)
        {

            if(confirm(msg ? msg : 'Are you sure you want to delete this record?'))
            {
                window.location = frm+'&action=delete&pk='+PK

            }

        }
    </script>
{/literal}
