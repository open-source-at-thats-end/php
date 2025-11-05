<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav apm_nav">
            <li>
				<span class="topmodultitle">
					<i class="icon2 icon2-listings"></i>Agent Master
				</span>
            </li>
        </ul>
    </div>
</div>
<h4>Search Filters</h4>
<hr/>
<div>
	{include file='agent/agent-search.tpl'}
</div>
<hr/>
<a href="{$scriptname}&action=add"  id="a_add" class="pull-right"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp<b>Add New</b></a>&nbsp;&nbsp;
<form id="frmStdForm" name="frmStdForm" action="" method="post">
    <div id="col-container">
        <div id="-vcol-right">
            <div id="msg_box">{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}</div>
            <div> {*include file='agent/list.tpl'*}
                <div class="vlist-head">
                    <div class="main-">
                        <table class="wp-list-table table table-bordered  table-condensed">
                            <thead>
                            <tr>
                                <th width="12%">Photo</th>
                                <th width="12%">First Name</th>
                                <th width="12%">Last Name</th>
                                <th width="10%">Email</th>
                                <th width="10%">Phone</th>
                                <th width="12%">Website</th>
                                <th width="10%">Key Code</th>
                                <th width="10%">Is Enabled</th>
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
                {if $total_record > 0}
                    {foreach $rsAgent as $record}
                        <tr class="{cycle values='alt,'}">
                            <td width="12%">
                                {assign var="agentImg" value="{$agentImgUrl}{$record['agent_photo']}"}
                                {*{var_dump($agentImg|file_exists)}*}
                                {if $record['agent_photo'] != '' }
                                    <img src="{$agentImgUrl}{$record['agent_photo']}" alt="{$record['agent_first_name']}" height="" width="45"/>
                                {else}
                                    <img src="{$agentImgUrl}no-agent-img.jpg" width="45"/>
                                {/if}
                            </td>
                            <td width="12%">{$record['agent_first_name']}</td>
                            <td width="12%">{$record['agent_last_name']}</td>
                            <td width="10%">{$record['agent_email']}</td>
                            <td width="10%">{$record['agent_phone']}</td>
                            <td width="12%">{$record['agent_website']}</td>
                            <td width="10%">{$record['agent_key_code']}</td>
                            <td width="10%">{if $record['agent_active'] == true}Yes{else}No{/if}</td>
                            <td width="10%">
                                <a href="{$scriptname}&action=edit&pk={$record['agent_id']}"  id="a_edit" ><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp<b>Edit</b></a>&nbsp;&nbsp;
                                <a href="javascript:void(0);"  id="a_delete" onclick="JavaScript:CDelete_Click('{$scriptname}', '{$record['agent_id']}', '');"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp<b>Delete</b></a>&nbsp;&nbsp;
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
</form>
{if $totalFetched >= $page_size}
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
