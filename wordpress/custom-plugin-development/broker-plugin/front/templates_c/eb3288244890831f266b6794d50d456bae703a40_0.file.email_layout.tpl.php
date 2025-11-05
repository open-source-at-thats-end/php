<?php
/* Smarty version 4.2.1, created on 2023-12-06 05:57:22
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/email_templates/email_layout.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_657053921e2305_87615626',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb3288244890831f266b6794d50d456bae703a40' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/email_templates/email_layout.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_657053921e2305_87615626 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE HTML>
<meta http-equiv="content-type" content="text/html" />
<meta name="author" content="" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>

<?php if ((isset($_smarty_tpl->tpl_vars['Host_Url']->value))) {?>
<link rel='stylesheet' id='chld_thm_cfg_parent-css'  href='<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/wp-content/themes/Divi-2/style.css' type='text/css' media='all' />
<?php }?>


	<style type="text/css">
	.stdEmail tr td {
		font-family:Arial, Helvetica, sans-serif;
		font-size:9pt;
		color:#333
	}
	.border, .border td, .border th	{ border:1px solid #efefef; padding:0.5em }
	body{width: 100%; height: 100%; margin:0; padding:0; -webkit-font-smoothing: antialiased;}
	html{width: 100%; }
	</style>
	<style type="text/css">
		/*.stdEmail tr td {
			font-family:Arial, Helvetica, sans-serif;
			font-size:9pt;
			color:#333
		}
		.border, .border td, .border th	{ border:1px solid #efefef; padding:0.5em }*/
	</style>

	<style type="text/css"> @media only screen and (max-width: 479px){
			body{width:auto!important;  }
			table[class=full] {width: 100%!important; clear: both; }
			table[class=mobile] {width: 100%!important; clear: both; }
			table[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
			td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
			.td-responsive{width:100%;display: block}
		}
	</style>
	<style type="text/css"> @media only screen and (max-width: 640px){
			body{width:auto!important;}
			table[class=full] {width: 100%!important; clear: both; }
			table[class=mobile] {width: 100%!important; clear: both; }
			td[class=mobile] {width: 100%!important; clear: both; }
			table[class=fullCenter] {width:100%!important; text-align: center!important; clear: both; }
			td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
		} </style>
	<style type="text/css">@media screen and (max-width: 1024px) and (min-width: 768px) {
			body{width:auto!important; }
			table[class=full] {width: 100%!important; clear: both; }
			td[class=mobile] {width: 100%!important; clear: both; }
			table[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
			td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
		} </style>
	<style type="text/css">@media screen and (max-width: 1366px) and (min-width: 1024px) {
			body{width:auto!important;  }
			table[class=full] {width: 100%!important; clear: both; }
			td[class=mobile] {width: 100%!important; clear: both; }
			table[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
			td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
		} </style>
	<style type="text/css">@media screen and (max-width: 1024px) and (min-width: 1024px) {
			body{width:auto!important;  }
			table[class=full] {width: 100%!important; clear: both; }
			td[class=mobile] {width: 100%!important;  clear: both; }
			table[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
			td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
		} </style>

<div class="wrapper" style="width: 100%;margin: 0 auto;font-size: 15px; font-style: normal;">
	<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['Email_Header']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
	<table class="full" cellpadding="0" cellspacing="0" width="100%" height="100%" align="center" border="0">
		<tr>
			<td>
				<?php if ($_smarty_tpl->tpl_vars['isContent']->value === true) {?>
					<br />
					<?php echo $_smarty_tpl->tpl_vars['Email_Body']->value;?>

				<?php } else { ?>
					<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['Email_Body']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
				<?php }?>
				<br />&nbsp;
			</td>
		</tr>
	</table>

		<?php if ((isset($_smarty_tpl->tpl_vars['Email_Footer']->value))) {?>
		<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['Email_Footer']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
	<?php }?>
</div>
<?php }
}
