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
							{*<th width="">Building Address</th>
							<th width="">Search Criteria</th>
							<th width="">Total Results</th>
							<th width="">Tag</th>*}
							<th width="">Short Code</th>
							{*<th width="">Require Registration</th>*}
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
	<div class="main-">
		<table class="table table-bordered  table-condensed table-hover  table-striped table-pre">
			<tbody id="the-list">
			{if count($rsDevelopment) > 0}
				{foreach $rsDevelopment as $record}
					<tr>
						<td width="">{$record['dev_title']}</td>
						{*<td width="">{$record['csearch_address']}</td>
						<td width="">{include file='predefined/search_criteria.tpl' arrSearchResult=$record.csearch_criteria}</td>
						<td width="">{$objAdminCon->getPropertyCount($record['csearch_id'])}</td>
						<td width="">{if $record['csearch_tag'] != ''}{$record['csearch_tag']}{else}-{/if}</td>*}
						<td width="">{$record['shortcode']}</td>
						{*<td width="">{$record['dev_require_reg']}</td>*}
						<td width="">
							<a href="{$scriptname}&action=edit&pk={$record['dev_id']}"  id="a_edit" ><b>Edit</b></a>&nbsp;&nbsp;
							<a href="javascript:void(0);"  id="a_delete" onclick="JavaScript:CDelete_Click('{$scriptname}', '{$record['dev_id']}', '');"><b>Delete</b></a>&nbsp;&nbsp;
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

