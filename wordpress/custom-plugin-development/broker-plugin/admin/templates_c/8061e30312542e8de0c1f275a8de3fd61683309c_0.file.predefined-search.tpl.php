<?php
/* Smarty version 4.2.1, created on 2023-08-31 13:28:04
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/predefined/predefined-search.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64f095642a1ed7_85741426',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8061e30312542e8de0c1f275a8de3fd61683309c' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/predefined/predefined-search.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64f095642a1ed7_85741426 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form id="FrmPre" method="get" action="">
    <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
"/>
	<div class="row">
		<div class="span6">
			<label><b>Title</b></label>
			<input type="text" id="psearch_title" name="psearch_title" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['psearch_title'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" class="input-lg for-search"/>
		</div>
		<div class="span8">
			<label><b>Tag</b></label>
			<input type="text" id="psearch_tag" name="psearch_tag" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['psearch_tag'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" class="input-lg for-search"/>
		</div>
		<div class="span8">
			<label></label>
			<input type="submit" id="presearch" value="Search" class="input-lg for-search"/>
		</div>
		<input type="hidden"  value="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
"/>
	</div>

</form><?php }
}
