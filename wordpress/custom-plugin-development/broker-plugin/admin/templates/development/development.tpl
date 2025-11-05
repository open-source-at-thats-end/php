<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav apm_nav">
            <li>
				<span class="topmodultitle">
					<i class="icon2 icon2-listings"></i>Manage Development Page
				</span>
            </li>
        </ul>
    </div>
</div>
<h4>Search Filters</h4>
<hr/>
<div>
	{include file='development/development-search.tpl'}
</div>
<hr/>
<br>
<a href="{$scriptname}&action=add"  id="a_add" class="pull-right"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp<b>Add New</b></a>
<br>

<form id="frmStdForm" name="frmStdForm" action="" class="frmStdForm" method="post">
	{include file='development/development-list.tpl'}
</form>

<div id="pre-pagination">
    {include file='development/development-pagination.tpl'}
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