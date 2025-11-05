<?php
/* Smarty version 4.2.1, created on 2023-12-06 05:57:22
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/email_templates/email_header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_657053921eba00_78336216',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cf796b993bdaf3c0c0ac36f824fb083c20bacd74' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/email_templates/email_header.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_657053921eba00_78336216 (Smarty_Internal_Template $_smarty_tpl) {
if (((isset($_smarty_tpl->tpl_vars['logo']->value)) && $_smarty_tpl->tpl_vars['logo']->value != '') || ((isset($_smarty_tpl->tpl_vars['title']->value)) && $_smarty_tpl->tpl_vars['title']->value != '')) {?>
	<table align="center" width="100%" class="full" >
		<tr style="/*padding:5px 10px; text-align:center;*//*background-color: #676767;*/">
			<td class="logo250-" style="text-align: center; line-height: 1px;width: 100%;/*border-bottom:1px solid #ccc; padding: 5px;*/">
				<?php if ((isset($_smarty_tpl->tpl_vars['logo']->value)) && $_smarty_tpl->tpl_vars['logo']->value != '') {?>
					<img src="<?php echo $_smarty_tpl->tpl_vars['uploadPath']->value;
echo $_smarty_tpl->tpl_vars['logo']->value;?>
" style="width: 300px;height:auto;border-bottom: 1px solid #f2f2f2;"/>
				<?php } elseif ($_smarty_tpl->tpl_vars['title']->value != '') {?>
					<h1> <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 </h1>
				<?php }?>

			</td>
		</tr>
	</table>
<?php }
}
}
