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
								<span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
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
											<a href="javaScript:void(0)" class="card-title font-weight-bold text-primary" data-toggle="modal" data-value="" data-target="#add_modal"><i class="mdi mdi-account card-title font-weight-bold text-primary"></i> Add New</a> &nbsp;&nbsp;
											<a href="{$scriptname}&action=export"  id="a_export"  rel="tooltip" title="Export" class="card-title font-weight-bold text-primary"><i class="mdi mdi-file-excel card-title font-weight-bold text-primary" aria-hidden="true"></i> Excel Export</a>
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
									<form id="frmStdForm" name="frmStdForm" action="" method="post">
										<table class="table table-hover c-table">
											<thead>
											<tr>
												<th class="text-primary">Date Added</th>
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
												{*<th class="text-primary">Action<br/>*}
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
																{$record.lead_created_date|date_format:'%Y-%m-%d'}
															{/if}
														</td>
														<td><span class="text-primary">{$record.lead_first_name}</span><br/><br/><span class="text-gray">{$record.lead_last_name}</span></td>
														<td>
															{$date_time =date_create($record.log_datetime)}
															{if $date_time->format("%Y-%m-%d") == $date1->format("%Y-%m-%d")}
																<p class="font-weight-bold mb-1">Today</p>

																<p class="mb-0 text-lowercase">{$record.log_datetime|date_format:'%I:%M %p'}</p>
															{else}
																<p class="font-weight-bold mb-1">{$record.log_datetime|date_format:'%Y-%m-%d'}</p>

																<p class="mb-0 text-lowercase">{$record.log_datetime|date_format:'%I:%M %p'}</p>
															{/if}
														</td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td width="">
															{*<a href="javaScript:void(0)" data-link="{$scriptname}&action=edit&pk={$record['lead_id']}" data-toggle="modal" *}{*data-value={$record}*}{* data-target="#add_modal"><b>Edit</b></a>&nbsp;&nbsp;*}
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
												<span class="card-title- font-weight-bold">Showing {$startRecord} to {$page_size} of {$total_record} entries</span>
												{*{html_pager_text num_items=$total_record per_page=$smarty.session.page_size start_item=$smarty.session.start_record}*}
											</div>
											{*<div class="btn-group float-right" role="group" aria-label="Basic example">
												<a class="btn btn-outline-secondary direction-btn">Previous</a>
												<a class="btn btn-gradient-primary page-num">1</a>
												<a class="btn btn-outline-secondary direction-btn">Next</a>
											</div>*}
											<div class="btn-group float-right" role="group" aria-label="Basic example">
												{if $totalFetched >= $page_size}
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
<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="add_modal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
						<div class="card m-0 pt-0">
							<div class="card-body ">
								<form class="forms-sample add-cntct-frm" action="{*{if is_array($record)}{$scriptname}&action=edit&pk={$record.lead_id} {else} {$scriptname}&action=add{/if}*}{$scriptname}&action=add" method="post" enctype="multipart/form-data" onsubmit="JavaScript: resetFormAttributes(this);">
									<div class="form-group row">
										<div class="col-6">
											<label for="user_name">First Name</label>
											<input type="text" class="form-control" id="user_name" placeholder="" value="{*{$record.lead_first_name}*}" name="lead_first_name">
										</div>
										<div class="col-6">
											<label for="lead_last_name">Last Name</label>
											<input type="text" class="form-control" id="lead_last_name" value="{*{$record.lead_last_name}*}" placeholder="" name="lead_last_name">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-6">
											<label for="lead_email">Email Address</label>
											<input type="email" class="form-control" id="lead_email" value="{*{$record.lead_email}*}" placeholder="" name="lead_email">
										</div>
										<div class="col-6">
											<label for="lead_cc_email">CC Email Address</label>
											<input type="email" class="form-control" id="lead_cc_email" value="{*{$record.lead_cc_email}*}" placeholder="" name="lead_cc_email">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-6">
											<label for="lead_mobile">Mobile Phone</label>
											<input type="text" class="form-control" id="lead_mobile" value="{*{$record.lead_mobile}*}" placeholder="" name="lead_mobile">
										</div>
										<div class="col-6">
											<label for="lead_type">Lead Type</label>
											<select class="form-control form-control-lg" id="lead_type" value="{$record.lead_type}" name="lead_type">
												<option value="Buyer" {if $record.lead_type == 'Buyer'} selected {/if}>Buyer</option>
												<option value="Seller" {if $record.lead_type == 'Seller'} selected {/if}>Seller</option>
												<option value="Renter" {if $record.lead_type == 'Renter'} selected {/if}>Renter</option>
											</select>
											{*<select class="form-control form-control-lg" id="lead_type" name="lead_type">
												{html_options options=$arrLeadType selected=$record.lead_type}
											</select>*}
										</div>
									</div>
									<div class="form-group row">
										<div class="col-6">
											<label for="lead_time_frame">Time Frame</label>
											<select class="form-control form-control-lg" id="lead_time_frame" value="{$record.lead_time_frame}" name="lead_time_frame">
												<option value="1-3 months">1-3 months</option>
												<option value="3-6 months">3-6 months</option>
												<option value="6-12 months">6-12 months</option>
												<option value="Just Looking">Just Looking</option>
											</select>
											{*<select class="form-control form-control-lg" id="lead_time_frame" name="lead_time_frame">
												{html_options options=$arrTimeFrame selected=$record.lead_time_frame}
											</select>*}
										</div>
										<div class="col-6">
											<label for="lead_pre_qualified">Pre-Qualified</label>
											<select class="form-control form-control-lg" id="lead_pre_qualified" value="{$record.lead_pre_qualified}"" name="lead_pre_qualified">
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
											{*<select class="form-control form-control-lg" id="lead_pre_qualified" name="lead_pre_qualified" *}{*class="apm_monoselect input-large"*}{*>
												{html_options options=$arrYesNo selected=$record.lead_pre_qualified}
											</select>*}
										</div>
									</div>
									<div class="form-group row">
										<div class="col-6">
											<label for="lead_source">Source</label>
											<select class="form-control form-control-lg" id="lead_source" value="{$record.lead_source}" name="lead_source">
												<option value="Search Engine">Search Engine</option>
												<option value="Website">Website</option>
												<option value="Referral">Referral</option>
												<option value="Open House">Open House</option>
												<option value="Paid Ads-Google">Paid Ads-Google</option>
												<option value="Paid Ads Por-tal">Paid Ads Por-tal</option>
												<option value="Paid Ads AdWerx">Paid Ads AdWerx</option>
												<option value="Paid Ads Facebook">Paid Ads Facebook</option>
												<option value="Paid Ads Instagram">Paid Ads Instagram</option>
											</select>
											{*<select class="form-control form-control-lg" id="lead_source" name="lead_source" *}{*class="apm_monoselect input-large"*}{*>
												{html_options options=$arrSource selected=$record.lead_source}
											</select>*}
										</div>
										<div class="col-6">
											<label for="lead_ip_address">Location/ IP Address Lookup</label>
											<input type="text" class="form-control" id="lead_ip_address" value="{$record.lead_ip_address}" placeholder="" name="lead_ip_address">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-12">
											<label for="lead_subs">Subscription</label>
												<div class="form-group d-flex justify-content-between m-0">
													<div class="form-check">
														<label class="form-check-label">
															<input type="checkbox" class="form-check-input" value="Property Alerts" name="lead_subs[]" checked> Property Alerts </label>
													</div>
													<div class="form-check">
														<label class="form-check-label">
															<input type="checkbox" class="form-check-input" value="Auto-Followup"  name="lead_subs[]" checked> Auto-Followup </label>
													</div>
													<div class="form-check">
														<label class="form-check-label">
															<input type="checkbox" class="form-check-input" value="Market Trends"  name="lead_subs[]" checked> Market Trends </label>
													</div>

												</div>
												<div class="form-group d-flex justify-content-between m-0">
													<div class="form-check">
														<label class="form-check-label">
															<input type="checkbox" class="form-check-input" value="Welcome Email"  name="lead_subs[]" checked> Welcome Email </label>
													</div>
													<div class="form-check">
														<label class="form-check-label">
															<input type="checkbox" class="form-check-input" value="Hot Lead"  name="lead_subs[]"> Hot Lead </label>
													</div>
													<div class="form-check">
														<label class="form-check-label">
															<input type="checkbox" class="form-check-input" value="Opportunity" name="lead_subs[]"> Opportunity </label>
													</div>
												</div>
											{*<div class="form-group d-flex- justify-content-between- m-0-">
												{foreach name=lead_subs from=$arrSubscription key=skey item=sitem}
													<div class="form-check">
														<label class="form-check-label" for="lead_subs_{$skey}">
															<input type="checkbox" class="form-check-input" name="lead_subs[]" {if $skey|in_array:explode(',',$record.lead_subs) || $skey == $record.lead_subs}checked="checked"{/if} id="lead_subs_{$skey}" value="{$skey}" />&nbsp;{$sitem}
														</label>
													</div>
												{/foreach}
											</div>*}
										</div>
									</div>
									<div class="form-group row">
										<div class="col-12">
											<label for="lead_note_desc ">Notes</label>
											<textarea class="form-control" id="lead_note_desc" rows="6" value="" name="lead_note_desc">{*{$record.lead_note_desc}*}</textarea>
										</div>
									</div>
									<div class="form-group row d-flex justify-content-between">
										<div class="pt-13">
											{*<a href="#" class="fs-15 error">Delete Contact</a>*}
											<a href="javascript:void(0);" class="fs-15 error" id="a_delete" onclick="JavaScript:CDelete_Click('{$scriptname}', '{$record.lead_id}', '{$record.lead_ref_id}', '');"><b>Delete Contact</b></a>&nbsp;&nbsp;
										</div>
										<div>
											<button class="btn btn-light mr-3 font-weight-light" onclick="JavaScript: window.location='{$scriptname}';">Cancel</button>
											<input type="submit" name="submit" value="{*{if is_array($record) && $record != ''}Update{else}Add{/if}*}Add" class="btn btn-gradient-primary mr-2 font-weight-light">
											<input type="hidden" value="{$record.lead_id|default:''}" name="pk" />
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{literal}
	<script type="text/javascript">
		jQuery(document).ready(function(){


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