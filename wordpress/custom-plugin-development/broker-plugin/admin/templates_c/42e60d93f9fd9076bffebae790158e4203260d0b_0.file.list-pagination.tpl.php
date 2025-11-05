<?php
/* Smarty version 4.2.1, created on 2023-11-20 08:56:46
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/listing/list-pagination.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_655b1f4e62b8b0_36718317',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '42e60d93f9fd9076bffebae790158e4203260d0b' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/listing/list-pagination.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_655b1f4e62b8b0_36718317 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_pager2.php','function'=>'smarty_function_html_pager2',),));
?>
<div class="navbar">
    <div class="navbar-inner">
        <div class=" pull-left" >
            <div class="pagination-text">
                <label>Items: <span class="footertalabitems"><?php echo count($_smarty_tpl->tpl_vars['arrRecordSet']->value['rs']);?>
 row(s) / <?php echo $_smarty_tpl->tpl_vars['total_record']->value;?>
 total result(s) (on <?php echo $_smarty_tpl->tpl_vars['total_record']->value;?>
 items)</span></label> |
                <label>Items/Pages: </label>
            </div>
            <div class="btn-group btn-mini page-size-group">
                <select name="page_size" id="page_size">
                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrPageSize']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchParams']->value['page_size']),$_smarty_tpl);?>

                </select>
                           </div>
        </div>
        <div class="pull-right" >
            <div class="pagination pagination-mini">
                <ul class=''>
                    <?php echo smarty_function_html_pager2(array('num_items'=>$_smarty_tpl->tpl_vars['total_record']->value,'per_page'=>$_smarty_tpl->tpl_vars['arrSearchParams']->value['page_size'],'add_prevnext_text'=>true,'start_item'=>$_smarty_tpl->tpl_vars['arrSearchParams']->value['start_record']),$_smarty_tpl);?>

                </ul>
            </div>
        </div>
    </div>
</div><?php }
}
