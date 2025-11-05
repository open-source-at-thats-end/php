<?php
/* Smarty version 4.2.1, created on 2023-12-09 07:57:34
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/user_main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_65741deed61062_18995470',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '38aa29430b50514e21313f3a0bbfc56dc3ee57df' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/user_main.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:user_additional_filter.tpl' => 1,
  ),
),false)) {
function content_65741deed61062_18995470 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_options.php','function'=>'smarty_function_html_options',),2=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),3=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_pager_responsive_loopt.php','function'=>'smarty_function_html_pager_responsive_loopt',),));
?>

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
				<?php if ($_smarty_tpl->tpl_vars['msgSuccess']->value) {?><div class="alert alert-success"><?php echo $_smarty_tpl->tpl_vars['msgSuccess']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }?>
				<?php if ($_smarty_tpl->tpl_vars['msgError']->value) {?><div class="alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['msgError']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }?>
				<div class="row">
					<div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
															<div class="card-body">
									<div class="d-flex justify-content-between align-content-center">
										<span class="card-title font-weight-bold"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['total_record']->value,0);?>
 Contacts</span>
										<div>
											<?php if ($_smarty_tpl->tpl_vars['page']->value == 'lpt-user') {?>
												<a href="javaScript:void(0)" id="add-contacts" class="card-title font-weight-bold text-primary pop popup-modal-sm" data-toggle="#modal-sm-popup" data-value="" data-url="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=add" data-type="Contacts" ><i class="mdi mdi-account card-title font-weight-bold text-primary"></i> Add New</a> &nbsp;&nbsp;
											<?php }?>
											<a href="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=export" id="a_export"  rel="tooltip" title="Export" class="card-title font-weight-bold text-primary"><i class="mdi mdi-file-excel card-title font-weight-bold text-primary" aria-hidden="true"></i> Excel Export</a>
										</div>
									</div>
									<br/>
									<div>
										<a data-toggle="collapse" href="#SearchFilter" class="card-title- fs-15 font-weight-bold text-primary">Expand for Additional Filter Options</a>
									</div>
									<div id="SearchFilter" class="collapse">
										<?php $_smarty_tpl->_subTemplateRender('file:user_additional_filter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
									</div>
									<hr/>

									<form id="frmStdForm" name="frmStdForm" action="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
" method="get">
										<input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
"/>
										<div class="d-flex justify-content-between">
											<div>
												<span>Show </span>
												<div class="btn-group btn-mini page-size-group">
													<select name="page_size" id="page_size">
														<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrPageSize']->value,'selected'=>$_smarty_tpl->tpl_vars['arrParams']->value['page_size']),$_smarty_tpl);?>

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
											<?php $_smarty_tpl->_assignInScope('date1', date_create());?>
											<?php if (count($_smarty_tpl->tpl_vars['rsUser']->value) > 0) {?>
												<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsUser']->value, 'record');
$_smarty_tpl->tpl_vars['record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['record']->value) {
$_smarty_tpl->tpl_vars['record']->do_else = false;
?>
													<tr>
														<td>

															<?php $_smarty_tpl->_assignInScope('date2', date_create($_smarty_tpl->tpl_vars['record']->value['lead_created_date']));?>
															<?php $_smarty_tpl->_assignInScope('diff', date_diff($_smarty_tpl->tpl_vars['date1']->value,$_smarty_tpl->tpl_vars['date2']->value));?>
															<?php if ($_smarty_tpl->tpl_vars['diff']->value->format("%a") == 0) {?>
																Today
															<?php } elseif ($_smarty_tpl->tpl_vars['diff']->value->format("%a") < 10) {?>
																<?php echo $_smarty_tpl->tpl_vars['diff']->value->format("%a days");?>

															<?php } else { ?>
																<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['record']->value['lead_created_date'],'%m-%d-%Y');?>

															<?php }?>
														</td>
														<td><span class="text-primary"><?php echo $_smarty_tpl->tpl_vars['record']->value['lead_type'];?>
</span></td>
														<td><span class="text-primary"><?php echo $_smarty_tpl->tpl_vars['record']->value['lead_first_name'];?>
</span><br/><br/><span class="text-gray"><?php echo $_smarty_tpl->tpl_vars['record']->value['lead_last_name'];?>
</span></td>
														<td>
														    <?php if ($_smarty_tpl->tpl_vars['record']->value['log_datetime'] != '') {?>

															    <?php $_smarty_tpl->_assignInScope('date_time', date_create($_smarty_tpl->tpl_vars['record']->value['log_datetime']));?>
															    <?php $_smarty_tpl->_assignInScope('date_time_lead', $_smarty_tpl->tpl_vars['record']->value['log_datetime']);?>

														    <?php } else { ?>
														         <?php $_smarty_tpl->_assignInScope('date_time', date_create($_smarty_tpl->tpl_vars['record']->value['lead_created_date']));?>
														         <?php $_smarty_tpl->_assignInScope('date_time_lead', $_smarty_tpl->tpl_vars['record']->value['lead_created_date']);?>
															<?php }?>
															<?php if ($_smarty_tpl->tpl_vars['date_time']->value->format("%m-%d-%Y") == $_smarty_tpl->tpl_vars['date1']->value->format("%m-%d-%Y")) {?>
																<p class="font-weight-bold mb-1">Today</p>

																<p class="mb-0 text-lowercase"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['date_time_lead']->value,'%I:%M %p');?>
</p>
															<?php } else { ?>
																<p class="font-weight-bold mb-1"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['date_time_lead']->value,'%m-%d-%Y');?>
</p>

																<p class="mb-0 text-lowercase"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['date_time_lead']->value,'%I:%M %p');?>
</p>
															<?php }?>

														</td>
														<td>
															<?php if ($_smarty_tpl->tpl_vars['record']->value['open_datetime'] != '') {?>
																<?php if (smarty_modifier_date_format($_smarty_tpl->tpl_vars['record']->value['open_datetime'],'%m-%d-%Y') == smarty_modifier_date_format($_smarty_tpl->tpl_vars['date1']->value,'%m-%d-%Y')) {?>
																	<p class="font-weight-bold mb-1">Today</p>
																<?php } else { ?>
																	<p class="font-weight-bold mb-1"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['record']->value['open_datetime'],'%m-%d-%Y');?>
</p>
																<?php }?>
																	<p class="mb-0 text-lowercase"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['record']->value['open_datetime'],'%I:%M %p');?>
</p>
															<?php } else { ?>
															-
															<?php }?>
														</td>
														<td>
														    <?php if ($_smarty_tpl->tpl_vars['record']->value['system_datetime'] != '') {?>
														    <?php $_smarty_tpl->_assignInScope('date_time', date_create($_smarty_tpl->tpl_vars['record']->value['system_datetime']));?>
															<?php if ($_smarty_tpl->tpl_vars['date_time']->value->format("%m-%d-%Y") == $_smarty_tpl->tpl_vars['date1']->value->format("%m-%d-%Y")) {?>
																<p class="font-weight-bold mb-1">Today</p>

																<p class="mb-0 text-lowercase"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['record']->value['system_datetime'],'%I:%M %p');?>
</p>
															<?php } else { ?>
																<p class="font-weight-bold mb-1"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['record']->value['system_datetime'],'%m-%d-%Y');?>
</p>

																<p class="mb-0 text-lowercase"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['record']->value['system_datetime'],'%I:%M %p');?>
</p>
															<?php }?>
															<?php } else { ?>
															  -
															<?php }?>
															</td>
														<td><?php if ($_smarty_tpl->tpl_vars['record']->value['statstic_price'] != '') {?><strong>$<?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['record']->value['statstic_price']);?>
 - <?php }
if ($_smarty_tpl->tpl_vars['record']->value['statstic_ptype'] != '') {
echo $_smarty_tpl->tpl_vars['record']->value['statstic_ptype'];?>
</strong><strong><sup><?php echo $_smarty_tpl->tpl_vars['record']->value['statstic_ptype_per'];?>
%</sup></strong><?php }?>
														<br/>
														<br/>
														<?php if ($_smarty_tpl->tpl_vars['record']->value['statstic_city_name'] != '') {
echo $_smarty_tpl->tpl_vars['record']->value['statstic_city_name'];?>
<strong><sup><?php echo $_smarty_tpl->tpl_vars['record']->value['stastic_city_per'];?>
%</sup></strong><?php }?>

														</td>
																												<td>
															<?php if ($_smarty_tpl->tpl_vars['record']->value['lead_type'] != 'ContactForm') {?>
																<?php if ($_smarty_tpl->tpl_vars['record']->value['lead_ref_id'] != '' || $_smarty_tpl->tpl_vars['record']->value['lead_user_id'] != '') {?>
																	<a href="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=emails_sent&userId=<?php if ($_smarty_tpl->tpl_vars['record']->value['lead_user_id'] != '') {
echo $_smarty_tpl->tpl_vars['record']->value['lead_user_id'];
} else {
echo $_smarty_tpl->tpl_vars['record']->value['lead_ref_id'];
}?>" target="_blank"><?php echo $_smarty_tpl->tpl_vars['record']->value['sent_emails'];?>
</a>/<?php echo $_smarty_tpl->tpl_vars['record']->value['open_emails'];?>

																<?php } else { ?>
																	<?php echo $_smarty_tpl->tpl_vars['record']->value['sent_emails'];?>
/<?php echo $_smarty_tpl->tpl_vars['record']->value['open_emails'];?>

																<?php }?>
															<?php } else { ?>
																-
															<?php }?>
														</td>
														<td>
															<?php if ($_smarty_tpl->tpl_vars['record']->value['lead_ref_id'] != '') {?>
																<a href="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=view&refId=<?php echo $_smarty_tpl->tpl_vars['record']->value['lead_ref_id'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['record']->value['viewed_property'];?>
</a>/<?php echo $_smarty_tpl->tpl_vars['record']->value['total_favorites'];?>

															<?php } else { ?>
																<?php echo $_smarty_tpl->tpl_vars['record']->value['viewed_property'];?>
/<?php echo $_smarty_tpl->tpl_vars['record']->value['total_favorites'];?>

															<?php }?>
														</td>
														<td width="">
															<a href="javaScript:void(0)" class="popup-modal-sm text-primary" data-url="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=edit&pk=<?php echo $_smarty_tpl->tpl_vars['record']->value['lead_id'];?>
" data-placement="top" title="Edit" data-toggle="modal"><b><i class="mdi mdi-table-edit " style="font-size: 20px;"></i></b></a>&nbsp;&nbsp;
																													</td>
													</tr>
												<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
											<?php } else { ?>
												<tr class="alt"><td colspan="12">No Data Found.</td></tr>
											<?php }?>
											</tbody>
										</table>
										<?php if (count($_smarty_tpl->tpl_vars['rsUser']->value) > 0) {?>
											<hr/>
											<div class="btn-group float-left" role="group" aria-label="Basic example">
												<span class="card-title- font-weight-bold">Showing <?php echo $_smarty_tpl->tpl_vars['startRecord']->value+1;?>
 to <?php if ($_smarty_tpl->tpl_vars['total_record']->value <= $_smarty_tpl->tpl_vars['page_size']->value || $_smarty_tpl->tpl_vars['totalFetched']->value < $_smarty_tpl->tpl_vars['page_size']->value) {
echo $_smarty_tpl->tpl_vars['total_record']->value;
} else {
echo $_smarty_tpl->tpl_vars['startRecord']->value+$_smarty_tpl->tpl_vars['page_size']->value;
}?> of <?php echo $_smarty_tpl->tpl_vars['total_record']->value;?>
 entries</span>
																							</div>
																						<div class="btn-group float-right" role="group" aria-label="Basic example">
												<?php if ($_smarty_tpl->tpl_vars['total_record']->value >= $_smarty_tpl->tpl_vars['page_size']->value) {?>
													<?php echo smarty_function_html_pager_responsive_loopt(array('num_items'=>$_smarty_tpl->tpl_vars['total_record']->value,'per_page'=>$_smarty_tpl->tpl_vars['page_size']->value,'start_item'=>$_smarty_tpl->tpl_vars['startRecord']->value,'add_prevnext_text'=>true),$_smarty_tpl);?>

												<?php }?>
											</div>
										<?php }?>
									</form>
								</div>
													</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-sm-popup" tabindex="-1" role="dialog" aria-labelledby="add_modal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		</div>
	</div>
</div>

	<?php echo '<script'; ?>
 type="text/javascript">
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
	<?php echo '</script'; ?>
>
<?php }
}
