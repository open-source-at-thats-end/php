<?php
/* Smarty version 4.2.1, created on 2024-01-05 12:13:15
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/user_add.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_6597f25b00b261_43848670',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7cb41e00b9ee37cbfbeaeb950eaab20d23fd7b0e' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/user_add.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6597f25b00b261_43848670 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_options.php','function'=>'smarty_function_html_options',),));
?>
<div class="modal-header">
	<h5 class="modal-title" id="exampleModalLongTitle">Add New</h5>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card m-0 pt-0">
				<div class="card-body ">
					<form id="FrmContacts" class="forms-sample add-cntct-frm" action="<?php if (is_array($_smarty_tpl->tpl_vars['record']->value)) {
echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=edit&pk=<?php echo $_smarty_tpl->tpl_vars['record']->value['lead_id'];?>
 <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=add<?php }?>" method="post" enctype="multipart/form-data">
						<div class="form-group row">
							<div class="col-6">
								<label for="user_name">First Name</label>
								<input type="text" class="form-control" id="user_name" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['lead_first_name'];?>
" name="lead_first_name">
							</div>
							<div class="col-6">
								<label for="lead_last_name">Last Name</label>
								<input type="text" class="form-control" id="lead_last_name" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['lead_last_name'];?>
" placeholder="" name="lead_last_name">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-6">
								<label for="lead_email">Email Address</label>
								<input type="email" class="form-control" id="lead_email" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['lead_email'];?>
" placeholder="" name="lead_email">
							</div>
							<div class="col-6">
								<label for="lead_cc_email">CC Email Address</label>
								<input type="email" class="form-control" id="lead_cc_email" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['lead_cc_email'];?>
" placeholder="" name="lead_cc_email">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-6">
								<label for="lead_mobile">Mobile Phone</label>
								<input type="text" class="form-control" id="lead_mobile" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['lead_mobile'];?>
" placeholder="" name="lead_mobile">
							</div>
							<div class="col-6">
								<label for="lead_type">Lead Type</label>
																<select class="form-control form-control-lg" id="lead_type" name="lead_type">
									<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrLeadType']->value,'selected'=>$_smarty_tpl->tpl_vars['record']->value['lead_type']),$_smarty_tpl);?>

								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-6">
								<label for="lead_time_frame">Time Frame</label>
																<select class="form-control form-control-lg" id="lead_time_frame" name="lead_time_frame">
									<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrTimeFrame']->value,'selected'=>$_smarty_tpl->tpl_vars['record']->value['lead_time_frame']),$_smarty_tpl);?>

								</select>
							</div>
							<div class="col-6">
								<label for="lead_pre_qualified">Pre-Qualified</label>
																<select class="form-control form-control-lg" id="lead_pre_qualified" name="lead_pre_qualified" class="apm_monoselect input-large">
									<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['record']->value['lead_pre_qualified']),$_smarty_tpl);?>

								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-6">
								<label for="lead_source">Source</label>
																<select class="form-control form-control-lg" id="lead_source" name="lead_source" class="apm_monoselect input-large">
									<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrSource']->value,'selected'=>$_smarty_tpl->tpl_vars['record']->value['lead_source']),$_smarty_tpl);?>

								</select>
							</div>
							<div class="col-6">
								<label for="lead_ip_address">Location/ <a href="<?php echo $_smarty_tpl->tpl_vars['main_host_url']->value;?>
/ip-location" target="_blank">IP Address Lookup</a></label>
								<input type="text" class="form-control" id="lead_ip_address" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['lead_ip_address'];?>
" placeholder="" name="lead_ip_address">
							</div>
						</div>
																												<div class="form-group row">
							<div class="col-12">
								<label for="lead_subs">Subscription</label>
								<div class="form-group d-flex flex-wrap justify-content-between m-0">
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrSubscription']->value, 'sitem', false, 'skey', 'lead_subs', array (
));
$_smarty_tpl->tpl_vars['sitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['skey']->value => $_smarty_tpl->tpl_vars['sitem']->value) {
$_smarty_tpl->tpl_vars['sitem']->do_else = false;
?>
										<div class="form-check">
											<label class="form-check-label">
												<input type="checkbox" class="form-check-input" name="lead_subs[]" <?php if (in_array($_smarty_tpl->tpl_vars['skey']->value,explode(',',$_smarty_tpl->tpl_vars['record']->value['lead_subs'])) || $_smarty_tpl->tpl_vars['skey']->value == $_smarty_tpl->tpl_vars['record']->value['lead_subs']) {?>checked="checked"<?php }?> id="lead_subs_<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['action']->value != 'edit' && ($_smarty_tpl->tpl_vars['sitem']->value != 'Hot Lead' && $_smarty_tpl->tpl_vars['sitem']->value != 'Opportunity')) {?> checked="checked" <?php }?> />&nbsp;<?php echo $_smarty_tpl->tpl_vars['sitem']->value;?>

												<i class="input-helper"></i>
											</label>
										</div>
									<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-12">
								<label for="lead_note_desc ">Notes</label>
								<textarea class="form-control" id="lead_note_desc" rows="6" value="" name="lead_note_desc"><?php echo $_smarty_tpl->tpl_vars['record']->value['lead_note_desc'];?>
</textarea>
							</div>
						</div>
						<div class="form-group row d-flex justify-content-between">
							<?php if ($_smarty_tpl->tpl_vars['action']->value == 'edit') {?>
								<div class="pt-13">
																		<a href="javascript:void(0);" class="fs-15 error" id="a_delete" onclick="JavaScript:CDelete_Click('<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['record']->value['lead_id'];?>
', '<?php echo $_smarty_tpl->tpl_vars['record']->value['lead_ref_id'];?>
', '');"><b>Delete Contact</b></a>&nbsp;&nbsp;
								</div>
							<?php }?>
							<div>
								<button class="btn btn-light mr-3 font-weight-light btn-cancel" type="button" onclick="JavaScript: window.location='<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
';">Cancel</button>
								<input type="submit" name="submit" value="<?php if (is_array($_smarty_tpl->tpl_vars['record']->value)) {?>Update<?php } else { ?>Add<?php }?>" class="btn btn-gradient-primary mr-2 font-weight-light">
								<input type="hidden" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['record']->value['lead_id'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" name="pk" />
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div><?php }
}
