<?php
/* Smarty version 4.2.1, created on 2023-11-20 08:56:46
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/listing/list-data.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_655b1f4e6239d9_41106463',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1a195f958662f0dece970bc120b43436717ccb8c' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/listing/list-data.tpl',
      1 => 1646851722,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_655b1f4e6239d9_41106463 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.cycle.php','function'=>'smarty_function_cycle',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),));
?>
<div class="main">
    <table class="table table-bordered  table-condensed table-hover  table-striped">
        <tbody id="the-list">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrRecordSet']->value['rs'], 'row', false, 'key', 'listingInfo', array (
));
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
    <tr class="<?php echo smarty_function_cycle(array('values'=>'alt,'),$_smarty_tpl);?>
">
        <td width="10%"><?php echo $_smarty_tpl->tpl_vars['row']->value['MLS_NUM'];?>
</td>
        <td width="10%">
            <a href="JavaScript: void(0);" class="vlink_view" data-link="<?php echo $_smarty_tpl->tpl_vars['basePageUrl']->value;?>
&action=view&mls_no=<?php echo $_smarty_tpl->tpl_vars['row']->value['ListingID_MLS'];?>
" data-title="MLS# <?php echo $_smarty_tpl->tpl_vars['row']->value['MLS_NUM'];?>
">
                <?php if ($_smarty_tpl->tpl_vars['row']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['row']->value['MainPicture']['large']['url']);?>
                    <?php if ($_smarty_tpl->tpl_vars['photo_url']->value != '') {?>
                        <img src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
" alt="<?php if ($_smarty_tpl->tpl_vars['imgAlt']->value) {
echo $_smarty_tpl->tpl_vars['imgAlt']->value;
} else { ?>MLS# <?php echo $_smarty_tpl->tpl_vars['row']->value['MLS_NUM'];
}?>" width="75" height=""/>
                    <?php } else { ?>
                        <img src="<?php echo $_smarty_tpl->tpl_vars['PhotoBaseUrl']->value;?>
no-photo/0/75/" alt="<?php if ($_smarty_tpl->tpl_vars['imgAlt']->value) {
echo $_smarty_tpl->tpl_vars['imgAlt']->value;
} else { ?>MLS# <?php echo $_smarty_tpl->tpl_vars['row']->value['MLS_NUM'];
}?>"/>
                    <?php }?>
                <?php } else { ?>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['MainPicture'];?>
" alt="<?php if ($_smarty_tpl->tpl_vars['imgAlt']->value) {
echo $_smarty_tpl->tpl_vars['imgAlt']->value;
} else { ?>MLS# <?php echo $_smarty_tpl->tpl_vars['row']->value['MLS_NUM'];
}?>"/>
                <?php }?>
            </a>
        </td>
        <td width="10%"><?php if ($_smarty_tpl->tpl_vars['row']->value['ListPrice'] > 0) {?>$<?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['row']->value['ListPrice'],0);
}?></td>
        <td width="20%"><a href="JavaScript: void(0);" class="vlink_view" data-link="<?php echo $_smarty_tpl->tpl_vars['basePageUrl']->value;?>
&action=view&mls_no=<?php echo $_smarty_tpl->tpl_vars['row']->value['ListingID_MLS'];?>
" data-title="MLS# <?php echo $_smarty_tpl->tpl_vars['row']->value['MLS_NUM'];?>
"><?php echo $_smarty_tpl->tpl_vars['objUtility']->value->formatListingAddress($_smarty_tpl->tpl_vars['arrListingConfig']->value['AddressFull'],$_smarty_tpl->tpl_vars['row']->value);?>
</a></td>


        <td width="10%"><?php echo $_smarty_tpl->tpl_vars['row']->value['SubType'];?>
</td>
        <td width="10%">
            Beds: <?php echo $_smarty_tpl->tpl_vars['row']->value['Beds'];?>
<br />
            Baths: <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['row']->value['Baths'],0);?>
<br />
                        Sqft: <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['row']->value['SQFT'],0);?>
<br />
        </td>
                    <td width="10%"><?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSystemName']->value[$_smarty_tpl->tpl_vars['row']->value['SystemName']] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</td>
           </tr>
    <?php
}
if ($_smarty_tpl->tpl_vars['row']->do_else) {
?>
    <tr class="alt"><td colspan="7">No listings.</td></tr>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </tbody>
    </table>
</div>
<?php }
}
