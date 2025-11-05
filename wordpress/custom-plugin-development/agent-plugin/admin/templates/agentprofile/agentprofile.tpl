<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav apm_nav">
            <li>
				<span class="topmodultitle">
					<i class="icon2 icon2-listings"></i>Agent profile
				</span>
            </li>
        </ul>
    </div>
</div>

{*<div>*}
{*	{include file='agent/agent-search.tpl'}*}
{*</div>*}

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
                                <th width="10%">Agent Photo</th>
                                <th width="10%">Name</th>
                                <th width="10%">Email</th>
                                <th width="10%">Phone</th>
                                <th width="10%">Office</th>
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

            <table class="wp-list-table table table-bordered  table-condensed">
                <tbody id="the-list">

                {if $total_record > 0}
                    {*{foreach name=f_listing from=$rsAgent item=Record}*}
                    {while $rsAgent->next_record()}

                        <tr class="{cycle values='alt,'}">
                            <td width="15%">
                                {assign var="agentImg" value="{$agentprofileImgUrl}{$rsAgent->f('Agent_Photo')}"}

                                {if $rsAgent->f('Agent_Photo') != '' }
                                    <img src="{$agentprofileImgUrl}{$rsAgent->f('Agent_Photo')}" alt="{$rsAgent->f('Agent_Photo')}" height="50" width="70"/>
                                {else}
                                    <img src="{$agentprofileImgUrl}no-agent-img.jpg" width="45"/>
                                {/if}
                            </td>

                            <td width="15%">{$rsAgent->f('Agent_Name')}</td>
                            <td width="15%">{$rsAgent->f('Agent_Email')}</td>
                            <td width="15%">{$rsAgent->f('Agent_phone')}</td>
                            <td width="15%">{$rsAgent->f('Agent_Office')}</td>
                            <td width="15%">
                                <a href="{$scriptname}&action=edit&pk={$rsAgent->f('Agent_Id')}"  id="a_edit" ><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp<b>Edit</b></a>&nbsp;&nbsp;
                                <a href="javascript:void(0);"  id="a_delete" onclick="JavaScript:CDelete_Click('{$scriptname}', '{$rsAgent->f('Agent_Id')}', '');"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp<b>Delete</b></a>&nbsp;&nbsp;
                            </td>

                        </tr>
                    {/while}
                {else}
                    <tr class="alt"><td colspan="5">No Data Found.</td></tr>
                {/if}
                </tbody>
            </table>
        </div>
    </div>
</form>

<div id="pre-pagination">
    {include file='agentprofile/agentprofile-pagination.tpl'}
</div>

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


