<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav apm_nav">
            <li>
				<span class="topmodultitle">
					<i class="icon2 icon2-listings"></i>Leads
				</span>
            </li>
        </ul>
    </div>
</div>
<div id="msg_box">{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}</div>
<div>
	<a href="{$scriptname}&action=export"  id="a_export"  rel="tooltip" title="Export" class="float-right"><i class="icon-download-alt" aria-hidden="true"></i><b>Excel Export</b></a>
</div>
<form id="frmStdForm" name="frmStdForm" action="" method="post">
    <div id="col-container">
        <div id="-vcol-right">
            <div>
                <div class="vlist-head">
                    <div class="main-">
                        <table class="wp-list-table table table-bordered  table-condensed">
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="12%">Name</th>
                                <th width="10%">Email</th>
                                <th width="10%">Phone</th>
                               {* <th width="10%">Address</th>
                                <th width="10%">Zipcode</th>
                                <th width="10%">State</th>*}
                                <th width="12%">Lead Type</th>
                                <th width="10%">User Type</th>
                                <th width="10%">Date</th>
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
                    {assign var=i value=1}
                    {foreach $rsUser as $record}
{*                    {while $rsUser->next_record()}*}
                        <tr>
                           {* <td width="5%">{$i}</td>
                            <td width="12%">{$rsUser->f('lead_first_name')|ucwords} {$rsUser->f('lead_last_name')|ucwords}</td>
                            <td width="10%">{$rsUser->f('lead_email')}</td>
                            <td width="10%">{$rsUser->f('lead_home_phone')}</td>*}
                            <td width="5%">{$i}</td>
                            <td width="12%">{$record['user_first_name']} {$record['user_last_name']}</td>
                            <td width="10%">{$record['user_email']}</td>
                            <td width="10%">{$record['user_phone']}</td>
                            <td width="12%">{$record['lead_type']}</td>
                            <td width="10%">{if $record['user_id'] == 0}Unregistered{else}Registered{/if}</td>
                             <td width="10%">{$record['lead_date']|date_format:'Y-m-d'}</td>
                            <td width="10%"> <a href="javascript:void(0);"  id="a_delete" onclick="JavaScript:CDeleteUser_Click('{$scriptname}', '{$record['user_email']}', '', '{$record['user_id']}');" rel="tooltip" title="Delete"><i class="icon-remove" aria-hidden="true"></i>&nbsp</a>&nbsp;</td>
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
</form>&nbsp;&nbsp;
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
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function(){


        });
        function CDeleteUser_Click(frm, email, msg, user_id)
        {

            if(confirm(msg ? msg : 'Are you sure you want to delete this record?'))
            {
                window.location = frm+'&action=delete&email='+email+'&user_id='+user_id

            }

        }
    </script>
{/literal}