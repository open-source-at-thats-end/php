<?php
/* Smarty version 4.2.1, created on 2023-08-11 21:24:44
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/agent/agent-search.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64d6a71cc85344_49490367',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eff298f8a4c8344dc0a087f833da74694a98fbe3' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/agent/agent-search.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64d6a71cc85344_49490367 (Smarty_Internal_Template $_smarty_tpl) {
?><form id="FrmAgent" method="get" action="">
    <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
"/>
	<div class="row">
		<div class="span6">
			<label><b>First Name</b></label>
			<input type="text" id="agent_first_name" name="agent_first_name" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['agent_first_name'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" class="input-lg for-search "/>
		</div>
		<div class="span8">
			<label><b>Last Name</b></label>
			<input type="text" id="agent_last_name" name="agent_last_name" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['agent_last_name'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" class="input-lg for-search"/>
		</div>
		
	</div>
    <div class="row">
    <div class="span1">
			<label></label>
			<input type="submit" id="search"  value="Search" class="input-lg btn btn-sm for-search"/>
		</div>
		<div class="span1">
			<label></label>
			<a href="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
" type="button" value="" class="for-search btn btn-sm">Reset</a>
		</div>
	</div>
</form><?php }
}
