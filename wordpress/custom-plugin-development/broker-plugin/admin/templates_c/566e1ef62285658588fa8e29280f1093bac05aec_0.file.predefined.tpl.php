<?php
/* Smarty version 4.2.1, created on 2023-08-31 13:28:04
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/predefined/predefined.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64f09564298ed6_77581535',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '566e1ef62285658588fa8e29280f1093bac05aec' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/predefined/predefined.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:predefined/predefined-search.tpl' => 1,
    'file:predefined/predefined-list.tpl' => 1,
    'file:predefined/predefined-pagination.tpl' => 1,
  ),
),false)) {
function content_64f09564298ed6_77581535 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="navbar">
    <div class="navbar-inner">
        <ul class="nav apm_nav">
            <li>
				<span class="topmodultitle">
					<i class="icon2 icon2-listings"></i>Manage Predefined Searches
				</span>
            </li>
        </ul>
    </div>
</div>
<h4>Search Filters</h4>
<hr/>
<div>
	<?php $_smarty_tpl->_subTemplateRender('file:predefined/predefined-search.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>
<hr/>
<br>
<a href="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=add"  id="a_add" class="pull-right"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp<b>Add New</b></a>
<br>

<form id="frmStdForm" name="frmStdForm" action="" class="frmStdForm" method="post">
	<?php $_smarty_tpl->_subTemplateRender('file:predefined/predefined-list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</form>

<div id="pre-pagination">
    <?php $_smarty_tpl->_subTemplateRender('file:predefined/predefined-pagination.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>


    <?php echo '<script'; ?>
 type="text/javascript">
        jQuery(document).ready(function(){


        });
        function CDelete_Click(frm, PK, msg)
        {
            if(confirm(msg ? msg : 'Are you sure you want to delete this record?'))
            {
                window.location = frm+'&action=delete&pk='+PK
            }
        }
    <?php echo '</script'; ?>
>
<?php }
}
