<?php
/* Smarty version 4.2.1, created on 2023-11-20 08:57:58
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/development/development-search.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_655b1f96c50851_61585837',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '16353d2104aa571bd94ea837715ee4c0c4718ee2' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/development/development-search.tpl',
      1 => 1679412082,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_655b1f96c50851_61585837 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form id="FrmDev" method="get" action="">
    <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
"/>
	<div class="row">
		<div class="span6">
			<label><b>Title</b></label>
			<input type="text" id="dev_title" name="dev_title" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['dev_title'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" class="input-lg for-search"/>
		</div>
				<div class="span8">
			<label></label>
			<input type="submit" id="devsearch" value="Search" class="input-lg for-search"/>
		</div>
		<input type="hidden"  value="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
"/>
	</div>

</form><?php }
}
