<?php
/* Smarty version 4.2.1, created on 2023-11-20 08:57:58
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/development/development-list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_655b1f96c5a865_23941385',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8d277305363c4d74c160fe51e8f2edbfc22b796e' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/development/development-list.tpl',
      1 => 1679683140,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_655b1f96c5a865_23941385 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="col-container">
	<div id="-vcol-right">
		<div id="msg_box"><?php if ($_smarty_tpl->tpl_vars['msgSuccess']->value) {?><div class="alert alert-success"><?php echo $_smarty_tpl->tpl_vars['msgSuccess']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }?></div>
		<div>
			<div class="vlist-head">
				<div class="main-">
					<table class="wp-list-table table table-bordered  table-condensed table-pre">
						<thead>
						<tr>
							<th width="">Title</th>
														<th width="">Short Code</th>
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
			<?php if (count($_smarty_tpl->tpl_vars['rsDevelopment']->value) > 0) {?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsDevelopment']->value, 'record');
$_smarty_tpl->tpl_vars['record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['record']->value) {
$_smarty_tpl->tpl_vars['record']->do_else = false;
?>
					<tr>
						<td width=""><?php echo $_smarty_tpl->tpl_vars['record']->value['dev_title'];?>
</td>
												<td width=""><?php echo $_smarty_tpl->tpl_vars['record']->value['shortcode'];?>
</td>
												<td width="">
							<a href="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=edit&pk=<?php echo $_smarty_tpl->tpl_vars['record']->value['dev_id'];?>
"  id="a_edit" ><b>Edit</b></a>&nbsp;&nbsp;
							<a href="javascript:void(0);"  id="a_delete" onclick="JavaScript:CDelete_Click('<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['record']->value['dev_id'];?>
', '');"><b>Delete</b></a>&nbsp;&nbsp;
						</td>
					</tr>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			<?php } else { ?>
				<tr class="alt"><td colspan="5">No Data Found.</td></tr>
			<?php }?>
			</tbody>
		</table>
	</div>
</div>

<?php }
}
