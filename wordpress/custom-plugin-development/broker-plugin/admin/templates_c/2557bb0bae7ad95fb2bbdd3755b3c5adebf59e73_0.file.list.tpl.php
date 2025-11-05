<?php
/* Smarty version 4.2.1, created on 2023-11-20 08:56:46
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/listing/list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_655b1f4e608037_85704839',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2557bb0bae7ad95fb2bbdd3755b3c5adebf59e73' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/listing/list.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:listing/list-data.tpl' => 1,
    'file:listing/list-pagination.tpl' => 1,
  ),
),false)) {
function content_655b1f4e608037_85704839 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="vlist-head">
    <div class="main">
        <table class="wp-list-table table table-bordered  table-condensed">
            <thead>
            <tr>
                <th width="10%">MLS #</th>
                <th width="10%">Photo</th>
                <th width="10%">Price</th>
                <th width="20%">Address</th>
                <th width="10%">Type</th>
                <th width="10%">Overview</th>
                <th width="10%">System Name</th>

            </tr>
            </thead>

        </table>
    </div>
</div>
<div class="vlist-data" id="list-holder">
    <?php $_smarty_tpl->_subTemplateRender("file:listing/list-data.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>

<div class="vlist-footer" id="list-pagination">
    <?php $_smarty_tpl->_subTemplateRender("file:listing/list-pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>
<?php }
}
