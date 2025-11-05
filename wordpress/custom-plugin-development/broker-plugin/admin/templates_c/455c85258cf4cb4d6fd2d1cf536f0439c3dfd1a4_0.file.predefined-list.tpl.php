<?php
/* Smarty version 4.2.1, created on 2023-08-31 13:28:04
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/predefined/predefined-list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64f095642b1b01_63711247',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '455c85258cf4cb4d6fd2d1cf536f0439c3dfd1a4' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/predefined/predefined-list.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:predefined/search_criteria.tpl' => 1,
  ),
),false)) {
function content_64f095642b1b01_63711247 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="col-container">
	<div id="-vcol-right">
		<div id="msg_box"><?php if ($_smarty_tpl->tpl_vars['msgSuccess']->value) {?><div class="alert alert-success"><?php echo $_smarty_tpl->tpl_vars['msgSuccess']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }?></div>
		<div> 			<div class="vlist-head">
				<div class="main-">
					<table class="wp-list-table table table-bordered  table-condensed table-pre">
						<thead>
						<tr>
							<th width="">Title</th>
							<th width="">Search Criteria</th>
							<th width="">Total Results</th>
							<th width="">Tag</th>
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
			<?php if (count($_smarty_tpl->tpl_vars['rsPredefined']->value) > 0) {?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsPredefined']->value, 'record');
$_smarty_tpl->tpl_vars['record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['record']->value) {
$_smarty_tpl->tpl_vars['record']->do_else = false;
?>
					<tr>
						<td width=""><?php echo $_smarty_tpl->tpl_vars['record']->value['psearch_title'];?>
</td>
						<td width=""><?php $_smarty_tpl->_subTemplateRender('file:predefined/search_criteria.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('arrSearchResult'=>$_smarty_tpl->tpl_vars['record']->value['psearch_criteria']), 0, true);
?></td>
						<td width=""><?php echo $_smarty_tpl->tpl_vars['objAdminPre']->value->getPropertyCount($_smarty_tpl->tpl_vars['record']->value['psearch_id']);?>
</td>
						<td width=""><?php echo $_smarty_tpl->tpl_vars['record']->value['psearch_tag'];?>
</td>
						<td width=""><?php echo $_smarty_tpl->tpl_vars['record']->value['shortcode'];?>
</td>
						<td width="">
							<a href="JavaScript: void(0);" class="vlink_listing" data-link="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=view&psearch_id=<?php echo $_smarty_tpl->tpl_vars['record']->value['psearch_id'];?>
" id="a_view" ><b>View Listing</b></a>&nbsp;&nbsp;
							<a href="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=edit&pk=<?php echo $_smarty_tpl->tpl_vars['record']->value['psearch_id'];?>
"  id="a_edit" ><b>Edit</b></a>&nbsp;&nbsp;
							<a href="javascript:void(0);"  id="a_delete" onclick="JavaScript:CDelete_Click('<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['record']->value['psearch_id'];?>
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
</div><?php }
}
