<?php
/* Smarty version 4.2.1, created on 2023-08-16 19:16:49
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/condo/condo-search.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64dd20a136c049_71314187',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '552c2a0050ec6bf3c852bdecf14be8fae2cde7f4' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/condo/condo-search.tpl',
      1 => 1646851716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64dd20a136c049_71314187 (Smarty_Internal_Template $_smarty_tpl) {
?><form id="FrmCondo" method="get" action="">
    <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
"/>
    <div class="row">
        <div class="span6">
            <label><b>Building Name</b></label>
            <input type="text" id="csearch_name" name="csearch_name" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['csearch_name'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" class="input-lg for-search"/>
        </div>
        <div class="span8">
            <label><b>Building Address</b></label>
            <input type="text" id="csearch_address" name="csearch_address" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['csearch_address'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" class="input-lg for-search"/>
        </div>
        <div class="span4">
            <label></label>
            <input type="submit" id="csearch" value="Search" class="input-lg for-search"/>
        </div>
        <input type="hidden"  value="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
"/>
    </div>
</form><?php }
}
