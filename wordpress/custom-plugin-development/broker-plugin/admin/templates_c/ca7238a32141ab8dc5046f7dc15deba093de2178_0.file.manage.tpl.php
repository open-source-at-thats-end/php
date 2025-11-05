<?php
/* Smarty version 4.2.1, created on 2023-11-20 08:56:46
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/listing/manage.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_655b1f4e5f88a3_93905167',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ca7238a32141ab8dc5046f7dc15deba093de2178' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/listing/manage.tpl',
      1 => 1633748294,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:search_form.tpl' => 1,
    'file:listing/list.tpl' => 1,
  ),
),false)) {
function content_655b1f4e5f88a3_93905167 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_options.php','function'=>'smarty_function_html_options',),));
?>
<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav apm_nav">
            <li>
				<span class="topmodultitle">
					<i class="icon2 icon2-listings"></i>MLS Listings
				</span>
            </li>
        </ul>
    </div>
</div>
<div id="col-container">
    <div id="vmanage">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                    Search Filters
                </a>
            </div>
            <div id="collapseOne" class="accordion-body collapse show">
                <form id="frmlistingSearch" class="frmlistingSearch advanced-search search" action="" method="post" enctype="multipart/form-data">
                    <div class="accordion-inner">
                        <?php $_smarty_tpl->_subTemplateRender('file:search_form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                        <div class="fright">
                            <p class="result-count aright">
                                <a href="JavaScript: void(0);" onclick="JavaScript: return getListing();" class="match button"><i class="fa fa-filter fa-lg"></i>&nbsp;<b><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['total_record']->value,'0');?>
 MATCHES</b></a>
                                <input type="hidden" name="Action" value="<?php echo $_smarty_tpl->tpl_vars['Action']->value;?>
">
                                <button type="submit" name="ShowAll" value="Show All" class=" button" ><b>Show All</b></button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="msg_box"><?php if ($_smarty_tpl->tpl_vars['msgSuccess']->value) {?><div class="alert alert-success"><?php echo $_smarty_tpl->tpl_vars['msgSuccess']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }?></div>
                <form class="navbar-form pull-right- px-10">
            <label class="sortbyName">Sort By</label>
            <select name="sort_by">
                <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrSortBy']->value),$_smarty_tpl);?>

            </select>
        </form>

        <div> <?php $_smarty_tpl->_subTemplateRender('file:listing/list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?> </div>
    </div>
</div><?php }
}
