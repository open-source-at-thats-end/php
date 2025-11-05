<?php
/* Smarty version 4.2.1, created on 2023-10-10 09:36:35
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/condo/condo-list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_65251b23eb19c6_93078256',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e377e227a30cf971932550b8c7c9f37653ea9c5a' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/condo/condo-list.tpl',
      1 => 1696930589,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:predefined/search_criteria.tpl' => 1,
  ),
),false)) {
function content_65251b23eb19c6_93078256 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="col-container">
    <div id="-vcol-right">
        <div id="msg_box"><?php if ($_smarty_tpl->tpl_vars['msgSuccess']->value) {?><div class="alert alert-success"><?php echo $_smarty_tpl->tpl_vars['msgSuccess']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }?></div>
        <div>
            <div class="vlist-head">
                <div class="main-">
                    <table class="wp-list-table table table-bordered  table-condensed table-pre">
                        <thead>
                        <tr>
                            <th width="">Building Name</th>
                            <th width="">Building Address</th>
                            <th width="">Search Criteria</th>
                            <th width="">Total Results</th>
                            <th width="">Tag</th>
                            <th width="">Short Code</th>
                            <th width="">Display In Agent?</th>
                            <th width="">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="-vlist-data" id="agent-list-holder">
    <div class="main-">
        <table class="table table-bordered  table-condensed table-hover  table-striped table-pre">
            <tbody id="the-list">
            <?php if (count($_smarty_tpl->tpl_vars['rsCondo']->value) > 0) {?>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsCondo']->value, 'record');
$_smarty_tpl->tpl_vars['record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['record']->value) {
$_smarty_tpl->tpl_vars['record']->do_else = false;
?>
                    <tr>
                        <td width=""><?php echo $_smarty_tpl->tpl_vars['record']->value['csearch_name'];?>
</td>
                        <td width=""><?php echo $_smarty_tpl->tpl_vars['record']->value['csearch_address'];?>
</td>
                        <td width=""><?php $_smarty_tpl->_subTemplateRender('file:predefined/search_criteria.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('arrSearchResult'=>$_smarty_tpl->tpl_vars['record']->value['csearch_criteria']), 0, true);
?></td>
                        <td width=""><?php echo $_smarty_tpl->tpl_vars['objAdminCon']->value->getPropertyCount($_smarty_tpl->tpl_vars['record']->value['csearch_id']);?>
</td>
                        <td width=""><?php if ($_smarty_tpl->tpl_vars['record']->value['csearch_tag'] != '') {
echo $_smarty_tpl->tpl_vars['record']->value['csearch_tag'];
} else { ?>-<?php }?></td>
                        <td width=""><?php echo $_smarty_tpl->tpl_vars['record']->value['shortcode'];?>
</td>
                        <td width=""><?php echo $_smarty_tpl->tpl_vars['record']->value['csearch_display_in_agent'];?>
</td>
                        <td width="">
                                                        <a href="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=edit&pk=<?php echo $_smarty_tpl->tpl_vars['record']->value['csearch_id'];?>
"  id="a_edit" ><b>Edit</b></a>&nbsp;&nbsp;
                            <a href="javascript:void(0);"  id="a_delete" onclick="JavaScript:CDelete_Click('<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['record']->value['csearch_id'];?>
', '');"><b>Delete</b></a>&nbsp;&nbsp;
                        </td>
                    </tr>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            <?php } else { ?>
                <tr class="alt"><td colspan="5">No Data Found.</td></tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div><?php }
}
