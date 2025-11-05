{*<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav apm_nav">
            <li>
				<span class="topmodultitle">
					<i class="icon2 icon2-listings"></i>User Master
				</span>
            </li>
        </ul>
    </div>
</div>*}
{*<form id="frmStdForm" name="frmStdForm" action="" method="post">
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
{* <th width="10%">User Type</th>
  <th width="10%">Date</th>
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
{* <div class="main-">
	 <table class="table table-bordered  table-condensed table-hover  table-striped">
		 <tbody id="the-list">
		 {if count($rsUser) > 0}
			 {assign var=i value=1}
			 {foreach $rsUser as $record}
				 <tr>
					 <td width="5%">{$i}</td>
					 <td width="12%">{$record['user_first_name']} {$record['user_last_name']}</td>
					 <td width="10%">{$record['user_email']}</td>
					 <td width="10%">{$record['user_phone']}</td>
					 {*<td width="10%">{$record['user_address']}</td>
					 <td width="10%">{$record['user_zipcode']}</td>
					 <td width="10%">{$record['user_state']}</td>*}

{* <td width="10%">{if $record['user_id'] == 0}Unregistered{else}Registered{/if}</td>
  <td width="10%">{$record['lead_date']|date_format:'Y-m-d'}</td>


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
</form>&nbsp;&nbsp;*}
<div class="container-scroller">
	<div class="container-fluid page-body-wrapper">
		<div class="main-panel">
			<div class="content-wrapper">
				<div class="page-header">
					<h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> All Leads
					</h3>
					<nav aria-label="breadcrumb">
						<ul class="breadcrumb">
							<li class="breadcrumb-item active" aria-current="page">
								<span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle" title="Manage All User Information"></i>
							</li>
						</ul>
					</nav>
				</div>
				{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
				{if $msgError}<div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
				<div class="row">
					<div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
							{*<form id="frmStdForm" name="frmStdForm" action="" method="post">*}
								<div class="card-body">
									<div class="d-flex justify-content-between align-content-center">
										<span class="card-title font-weight-bold">{$total_record|number_format:0} Contacts</span>
										<div>
											{if $page == 'lpt-user'}
												<a href="javaScript:void(0)" id="add-contacts" class="card-title font-weight-bold text-primary pop popup-modal-sm" data-toggle="#modal-sm-popup" data-value="" data-url="{$scriptname}&action=add" data-type="Contacts" {*data-target="#add_modal"*}><i class="mdi mdi-account card-title font-weight-bold text-primary"></i> Add New</a> &nbsp;&nbsp;
											{/if}
											<a href="{$scriptname}&action=export" id="a_export"  rel="tooltip" title="Export" class="card-title font-weight-bold text-primary"><i class="mdi mdi-file-excel card-title font-weight-bold text-primary" aria-hidden="true"></i> Excel Export</a>
										</div>
									</div>
									<br/>
									<div>
										<a data-toggle="collapse" href="#SearchFilter" class="card-title- fs-15 font-weight-bold text-primary">Expand for Additional Filter Options</a>
									</div>
									<div id="SearchFilter" class="collapse">
										{include file='user_additional_filter.tpl'}
									</div>
									<hr/>

									<form id="frmStdForm" name="frmStdForm" action="{$scriptname}" method="get">
										<input type="hidden" name="page" value="{$page}"/>
										<div class="d-flex justify-content-between">
											<div>
												<span>Show </span>
												<div class="btn-group btn-mini page-size-group">
													<select name="page_size" id="page_size">
														{html_options options=$arrPageSize selected=$arrParams.page_size}
													</select>

												</div>
												<span> Entries</span>
											</div>
											<div>
												<input type="text" placeholder="Search" name="kword" value="">
											</div>
										</div>
										<table class="table table-hover c-table mt-3">
											<thead>
											<tr>
												<th class="text-primary">Date Added</th>
												<th class="text-primary">Lead Type</th>
												<th class="text-primary">First Name<br/><br/>Last Name</th>
												<th class="text-primary">Website Visit</th>
												<th class="text-primary">Email Open</th>
												<th class="text-primary">System Activity</th>
												<th class="text-primary">Top Data</th>
												<th class="text-primary">Emails<br/>
													<small>Sent/Open</small>
												</th>
												<th class="text-primary">Properties<br/>
													<small>Viewed/Saved</small>
												</th>
												<th class="text-primary">Action<br/>
											</tr>
											</thead>
											<tbody>
											{$date1=date_create()}
											{if count($rsUser) > 0}
												{foreach $rsUser as $record}
													<tr>
														<td>

															{$date2=date_create($record.lead_created_date)}
															{$diff=date_diff($date1,$date2)}
															{if $diff->format("%a") == 0}
																Today
															{elseif $diff->format("%a") < 10}
																{$diff->format("%a days")}
															{else}
																{$record.lead_created_date|date_format:'%m-%d-%Y'}
															{/if}
														</td>
														<td><span class="text-primary">{$record.lead_type}</span></td>
														<td><span class="text-primary">{$record.lead_first_name}</span><br/><br/><span class="text-gray">{$record.lead_last_name}</span></td>
														<td>
														    {if $record.log_datetime != ''}

															    {$date_time =date_create($record.log_datetime)}
															    {$date_time_lead =$record.log_datetime}

														    {else}
														         {$date_time =date_create($record.lead_created_date)}
														         {$date_time_lead =$record.lead_created_date}
															{/if}
															{if $date_time->format("%m-%d-%Y") == $date1->format("%m-%d-%Y")}
																<p class="font-weight-bold mb-1">Today</p>

																<p class="mb-0 text-lowercase">{$date_time_lead|date_format:'%I:%M %p'}</p>
															{else}
																<p class="font-weight-bold mb-1">{$date_time_lead|date_format:'%m-%d-%Y'}</p>

																<p class="mb-0 text-lowercase">{$date_time_lead|date_format:'%I:%M %p'}</p>
															{/if}

														</td>
														<td>
															{if $record.open_datetime != ''}
																{if $record.open_datetime|date_format:'%m-%d-%Y' == $date1|date_format:'%m-%d-%Y'}
																	<p class="font-weight-bold mb-1">Today</p>
																{else}
																	<p class="font-weight-bold mb-1">{$record.open_datetime|date_format:'%m-%d-%Y'}</p>
																{/if}
																	<p class="mb-0 text-lowercase">{$record.open_datetime|date_format:'%I:%M %p'}</p>
															{else}
															-
															{/if}
														</td>
														<td>
														    {if $record.system_datetime != ''}
														    {$date_time =date_create($record.system_datetime)}
															{if $date_time->format("%m-%d-%Y") == $date1->format("%m-%d-%Y")}
																<p class="font-weight-bold mb-1">Today</p>

																<p class="mb-0 text-lowercase">{$record.system_datetime|date_format:'%I:%M %p'}</p>
															{else}
																<p class="font-weight-bold mb-1">{$record.system_datetime|date_format:'%m-%d-%Y'}</p>

																<p class="mb-0 text-lowercase">{$record.system_datetime|date_format:'%I:%M %p'}</p>
															{/if}
															{else}
															  -
															{/if}
															</td>
														<td>{if $record.statstic_price !=''}<strong>${$record.statstic_price|number_format} - {/if}{if $record.statstic_ptype !=''}{$record.statstic_ptype}</strong><strong><sup>{$record.statstic_ptype_per}%</sup></strong>{/if}
														<br/>
														<br/>
														{if $record.statstic_city_name !=''}{$record.statstic_city_name}<strong><sup>{$record.stastic_city_per}%</sup></strong>{/if}

														</td>
														{*<td><a href="{$scriptname}&action=emails_sent&userId={if $record['lead_ref_id'] != ''}{$record['lead_ref_id']}{else}{$record['lead_user_id']}{/if}" target="_blank">{$record.sent_emails}</a>/{$record.open_emails}</td>
														<td><a href="{$scriptname}&action=view&refId={$record['lead_ref_id']}" target="_blank">{$record.viewed_property}</a>/{$record.total_favorites}</td>*}
														<td>
															{if $record['lead_type'] != 'ContactForm'}
																{if $record['lead_ref_id'] != '' || $record['lead_user_id'] != ''}
																	<a href="{$scriptname}&action=emails_sent&userId={if $record['lead_user_id'] != ''}{$record['lead_user_id']}{else}{$record['lead_ref_id']}{/if}" target="_blank">{$record.sent_emails}</a>/{$record.open_emails}
																{else}
																	{$record.sent_emails}/{$record.open_emails}
																{/if}
															{else}
																-
															{/if}
														</td>
														<td>
															{if $record['lead_ref_id'] != ''}
																<a href="{$scriptname}&action=view&refId={$record['lead_ref_id']}" target="_blank">{$record.viewed_property}</a>/{$record.total_favorites}
															{else}
																{$record.viewed_property}/{$record.total_favorites}
															{/if}
														</td>
														<td width="">
															<a href="javaScript:void(0)" class="popup-modal-sm text-primary" data-url="{$scriptname}&action=edit&pk={$record['lead_id']}" data-placement="top" title="Edit" data-toggle="modal"><b><i class="mdi mdi-table-edit " style="font-size: 20px;"></i></b></a>&nbsp;&nbsp;
															{*<a href="javascript:void(0);"  id="a_delete" onclick="JavaScript:CDelete_Click('{$scriptname}', '{$record['lead_id']}', '{$record['lead_ref_id']}', '');"><b>Delete</b></a>&nbsp;&nbsp;*}
														</td>
													</tr>
												{/foreach}
											{else}
												<tr class="alt"><td colspan="12">No Data Found.</td></tr>
											{/if}
											</tbody>
										</table>
										{if count($rsUser) > 0}
											<hr/>
											<div class="btn-group float-left" role="group" aria-label="Basic example">
												<span class="card-title- font-weight-bold">Showing {$startRecord+1} to {if $total_record <= $page_size || $totalFetched < $page_size}{$total_record}{else}{$startRecord+$page_size}{/if} of {$total_record} entries</span>
												{*{html_pager_text num_items=$total_record per_page=$smarty.session.page_size start_item=$smarty.session.start_record}*}
											</div>
											{*<div class="btn-group float-right" role="group" aria-label="Basic example">
												<a class="btn btn-outline-secondary direction-btn">Previous</a>
												<a class="btn btn-gradient-primary page-num">1</a>
												<a class="btn btn-outline-secondary direction-btn">Next</a>
											</div>*}
											<div class="btn-group float-right" role="group" aria-label="Basic example">
												{if $total_record >= $page_size}
													{html_pager_responsive_loopt num_items=$total_record per_page=$page_size start_item=$startRecord add_prevnext_text=true}
												{/if}
											</div>
										{/if}
									</form>
								</div>
							{*</form>*}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{*{if $totalFetched >= $page_size}
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
{/if}*}
<div class="modal fade" id="modal-sm-popup" tabindex="-1" role="dialog" aria-labelledby="add_modal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		</div>
	</div>
</div>
{literal}
	<script type="text/javascript">
		jQuery(document).ready(function(){

			jQuery('#page_size').on('change',function () {
				jQuery('#frmStdForm').submit();
            })
		});
		function CDelete_Click(frm, PK, Ref_id, msg)
		{
			if(confirm(msg ? msg : 'Are you sure you want to delete this record?'))
			{
				window.location = frm+'&action=delete&pk='+PK+'&ref_id='+Ref_id
			}
		}
	</script>
{/literal}