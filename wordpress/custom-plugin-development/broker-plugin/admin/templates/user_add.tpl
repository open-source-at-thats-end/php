<div class="modal-header">
	<h5 class="modal-title" id="exampleModalLongTitle">Add New</h5>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card m-0 pt-0">
				<div class="card-body ">
					<form id="FrmContacts" class="forms-sample add-cntct-frm" action="{if is_array($record)}{$scriptname}&action=edit&pk={$record.lead_id} {else} {$scriptname}&action=add{/if}" method="post" enctype="multipart/form-data">
						<div class="form-group row">
							<div class="col-6">
								<label for="user_name">First Name</label>
								<input type="text" class="form-control" id="user_name" placeholder="" value="{$record.lead_first_name}" name="lead_first_name">
							</div>
							<div class="col-6">
								<label for="lead_last_name">Last Name</label>
								<input type="text" class="form-control" id="lead_last_name" value="{$record.lead_last_name}" placeholder="" name="lead_last_name">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-6">
								<label for="lead_email">Email Address</label>
								<input type="email" class="form-control" id="lead_email" value="{$record.lead_email}" placeholder="" name="lead_email">
							</div>
							<div class="col-6">
								<label for="lead_cc_email">CC Email Address</label>
								<input type="email" class="form-control" id="lead_cc_email" value="{$record.lead_cc_email}" placeholder="" name="lead_cc_email">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-6">
								<label for="lead_mobile">Mobile Phone</label>
								<input type="text" class="form-control" id="lead_mobile" value="{$record.lead_mobile}" placeholder="" name="lead_mobile">
							</div>
							<div class="col-6">
								<label for="lead_type">Lead Type</label>
								{*<select class="form-control form-control-lg" id="lead_type" value="{$record.lead_type}" name="lead_type">
									<option value="Buyer" {if $record.lead_type == 'Buyer'} selected {/if}>Buyer</option>
									<option value="Seller" {if $record.lead_type == 'Seller'} selected {/if}>Seller</option>
									<option value="Renter" {if $record.lead_type == 'Renter'} selected {/if}>Renter</option>
								</select>*}
								<select class="form-control form-control-lg" id="lead_type" name="lead_type">
									{html_options options=$arrLeadType selected=$record.lead_type}
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-6">
								<label for="lead_time_frame">Time Frame</label>
								{*<select class="form-control form-control-lg" id="lead_time_frame" value="{$record.lead_time_frame}" name="lead_time_frame">
									<option value="1-3 months">1-3 months</option>
									<option value="3-6 months">3-6 months</option>
									<option value="6-12 months">6-12 months</option>
									<option value="Just Looking">Just Looking</option>
								</select>*}
								<select class="form-control form-control-lg" id="lead_time_frame" name="lead_time_frame">
									{html_options options=$arrTimeFrame selected=$record.lead_time_frame}
								</select>
							</div>
							<div class="col-6">
								<label for="lead_pre_qualified">Pre-Qualified</label>
								{*<select class="form-control form-control-lg" id="lead_pre_qualified" value="{$record.lead_pre_qualified}"" name="lead_pre_qualified">
									<option value="Yes">Yes</option>
									<option value="No">No</option>
								</select>*}
								<select class="form-control form-control-lg" id="lead_pre_qualified" name="lead_pre_qualified" class="apm_monoselect input-large">
									{html_options options=$arrYesNo selected=$record.lead_pre_qualified}
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-6">
								<label for="lead_source">Source</label>
								{*<select class="form-control form-control-lg" id="lead_source" value="{$record.lead_source}" name="lead_source">
									<option value="Search Engine">Search Engine</option>
									<option value="Website">Website</option>
									<option value="Referral">Referral</option>
									<option value="Open House">Open House</option>
									<option value="Paid Ads-Google">Paid Ads-Google</option>
									<option value="Paid Ads Por-tal">Paid Ads Por-tal</option>
									<option value="Paid Ads AdWerx">Paid Ads AdWerx</option>
									<option value="Paid Ads Facebook">Paid Ads Facebook</option>
									<option value="Paid Ads Instagram">Paid Ads Instagram</option>
								</select>*}
								<select class="form-control form-control-lg" id="lead_source" name="lead_source" class="apm_monoselect input-large">
									{html_options options=$arrSource selected=$record.lead_source}
								</select>
							</div>
							<div class="col-6">
								<label for="lead_ip_address">Location/ <a href="{$main_host_url}/ip-location" target="_blank">IP Address Lookup</a></label>
								<input type="text" class="form-control" id="lead_ip_address" value="{$record.lead_ip_address}" placeholder="" name="lead_ip_address">
							</div>
						</div>
						{*<div class="form-group row">
							<div class="col-12">
								<label for="lead_subs">Subscription</label>*}
								{*<div class="form-group d-flex justify-content-between m-0">
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
								</div>*}
								{*<div class="form-group d-flex justify-content-between m-0">
									{foreach name=lead_subs from=$arrSubscription key=skey item=sitem}
										<div class="form-check">
											<label class="form-check-label" for="lead_subs_{$skey}">
												<input type="checkbox" class="form-check-input" name="lead_subs[]" {if $skey|in_array:explode(',',$record.lead_subs) || $skey == $record.lead_subs}checked="checked"{/if} id="lead_subs_{$skey}" value="{$skey}" />&nbsp;{$sitem}
											</label>
										</div>
									{/foreach}
								</div>*}
						<div class="form-group row">
							<div class="col-12">
								<label for="lead_subs">Subscription</label>
								<div class="form-group d-flex flex-wrap justify-content-between m-0">
									{foreach name=lead_subs from=$arrSubscription key=skey item=sitem}
										<div class="form-check">
											<label class="form-check-label">
												<input type="checkbox" class="form-check-input" name="lead_subs[]" {if $skey|in_array:explode(',',$record.lead_subs) || $skey == $record.lead_subs}checked="checked"{/if} id="lead_subs_{$skey}" value="{$skey}" {if $action != 'edit' && ($sitem != 'Hot Lead' && $sitem != 'Opportunity')} checked="checked" {/if} />&nbsp;{$sitem}
												<i class="input-helper"></i>
											</label>
										</div>
									{/foreach}
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-12">
								<label for="lead_note_desc ">Notes</label>
								<textarea class="form-control" id="lead_note_desc" rows="6" value="" name="lead_note_desc">{$record.lead_note_desc}</textarea>
							</div>
						</div>
						<div class="form-group row d-flex justify-content-between">
							{if $action == 'edit'}
								<div class="pt-13">
									{*<a href="#" class="fs-15 error">Delete Contact</a>*}
									<a href="javascript:void(0);" class="fs-15 error" id="a_delete" onclick="JavaScript:CDelete_Click('{$scriptname}', '{$record.lead_id}', '{$record.lead_ref_id}', '');"><b>Delete Contact</b></a>&nbsp;&nbsp;
								</div>
							{/if}
							<div>
								<button class="btn btn-light mr-3 font-weight-light btn-cancel" type="button" onclick="JavaScript: window.location='{$scriptname}';">Cancel</button>
								<input type="submit" name="submit" value="{if is_array($record)}Update{else}Add{/if}" class="btn btn-gradient-primary mr-2 font-weight-light">
								<input type="hidden" value="{$record.lead_id|default:''}" name="pk" />
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>