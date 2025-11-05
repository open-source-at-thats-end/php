<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav apm_nav">
            <li>
				<span class="topmodultitle">
					<i class="icon2 icon2-listings"></i>Broker Office
				</span>
            </li>
        </ul>
    </div>
</div>
<h4>Search Filters</h4>
<hr/>
<form id="FrmBrokerInfo" method="get" action="">
	<input type="hidden" name="page" value="{$page}"/>
	<div class="row">
		<div class="span6">
			<label><b>ID</b></label>
			<input type="text" id="agent_first_name" name="broker_id" value="{$arrParams.broker_id|default:''}" class="input-lg for-search"/>
		</div>
		<div class="span9">
			<label><b>Name</b></label>
			<input type="text" id="agent_last_name" name="broker_name" value="{$arrParams.broker_name|default:''}" class="input-lg for-search"/>
		</div>
        
		
      
	</div>
	<div class="row">
    <div class="span1">
			<label></label>
			<input type="submit" id="search"  value="Search" class="input-lg btn btn-sm for-search"/>
		</div>
		<div class="span1">
			<label></label>
			<a href="{$scriptname}" type="button" value="" class="for-search btn btn-sm">Reset</a>
		</div>
	</div>
</form>
<hr/>
<form id="frmStdForm" name="frmStdForm" action="" method="post">
    <div id="col-container">
        <div id="-vcol-right">
            <div>
                <div class="vlist-head">
                    <div class="main-">
                        <table class="wp-list-table table table-bordered  table-condensed">
                            <thead>
                            <tr>
                                <th width="15%">Broker Id</th>
                                <th width="85%">Broker Name</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="-vlist-data" id="agent-list-holder">
        <div class="main-">
            <table class="table table-bordered  table-condensed table-hover  table-striped">
                <tbody id="the-list">
                {if $total_record > 0}
                    {while $rsBroker->next_record()}
                        <tr>
                            <td width="15%">{$rsBroker->f('Office_ID')}</td>
                            <td width="85%">{$rsBroker->f('Office_Name')}</td>
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