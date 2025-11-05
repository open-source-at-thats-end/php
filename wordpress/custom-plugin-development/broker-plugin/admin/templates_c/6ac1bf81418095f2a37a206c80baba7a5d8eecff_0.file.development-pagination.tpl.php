<?php
/* Smarty version 4.2.1, created on 2023-11-20 08:57:58
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/development/development-pagination.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_655b1f96c617d3_21638780',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ac1bf81418095f2a37a206c80baba7a5d8eecff' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/development/development-pagination.tpl',
      1 => 1679412074,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_655b1f96c617d3_21638780 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_pager2.php','function'=>'smarty_function_html_pager2',),));
if ($_smarty_tpl->tpl_vars['totalFetched']->value >= $_smarty_tpl->tpl_vars['page_size']->value) {?>
    <div class="vlist-footer" id="list-pagination">
        <div class="navbar">
            <div class="navbar-inner">
                <div class=" pull-left" >
                    <div class="pagination-text">
                        <label>Items: <span class="footertalabitems"><?php echo $_smarty_tpl->tpl_vars['total_record']->value;?>
 row(s) / <?php echo $_smarty_tpl->tpl_vars['totalFetched']->value;?>
 total result(s) (on <?php echo $_smarty_tpl->tpl_vars['totalFetched']->value;?>
 items)</span></label>
                    </div>

                </div>
                <div class="pull-right" >
                    <div class="pagination pagination-mini">
                        <ul class=''>
                            <?php echo smarty_function_html_pager2(array('num_items'=>$_smarty_tpl->tpl_vars['totalFetched']->value,'per_page'=>$_smarty_tpl->tpl_vars['page_size']->value,'add_prevnext_text'=>true,'start_item'=>$_smarty_tpl->tpl_vars['startRecord']->value),$_smarty_tpl);?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }
}
}
