<?php
/* Smarty version 4.2.1, created on 2023-12-09 07:57:34
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/user_additional_filter.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_65741deed72077_84866110',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6dbc901edc3ca934537db403952f760fd122ad90' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/user_additional_filter.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65741deed72077_84866110 (Smarty_Internal_Template $_smarty_tpl) {
?><hr/>
<form id="FrmCntct" action="" method="get">
    <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
"/>
    <div class="form-group row">
        <div class="col-sm">
            <label >First Name</label>
            <input type="text" class="form-control" id="csearch_fname" name="csearch_fname" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['csearch_fname'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" placeholder="">
        </div>
        <div class="col-sm">
            <label >Last Name</label>
            <input type="text" class="form-control" id="csearch_lname" name="csearch_lname" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['csearch_lname'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" placeholder="">
        </div>
        <div class="col-sm">
            <label >Area or City</label>
            <input type="text" class="form-control" id="csearch_area_city" name="csearch_area_city" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['csearch_area_city'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" placeholder="">
        </div>
        <div class="col-sm">
            <label >Zip Code</label>
            <input type="text" class="form-control" id="csearch_zipcode" name="csearch_zipcode" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['csearch_zipcode'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" placeholder="">
        </div>
        <div class="col-sm">
            <label >Lead Type</label>
            <input type="text" class="form-control" id="csearch_lead_type" name="csearch_lead_type" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['csearch_lead_type'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" placeholder="">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm">
            <label >Price Minimum</label>
            <input type="text" class="form-control" id="csearch_min_price" name="csearch_min_price" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['csearch_min_price'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" placeholder="">
        </div>
        <div class="col-sm">
            <label >Price Maximum</label>
            <input type="text" class="form-control" id="csearch_max_price" name="csearch_max_price" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['csearch_max_price'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" placeholder="">
        </div>
        <div class="col-sm">
            <label >Property Type</label>
            <input type="text" class="form-control" id="csearch_ptype" name="csearch_ptype" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['csearch_ptype'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" placeholder="">
        </div>
        <div class="col-sm">
            <label >Source</label>
            <input type="text" class="form-control" id="csearch_source" name="csearch_source" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['csearch_timeframe'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" placeholder="">
        </div>
        <div class="col-sm">
            <label >Timeframe</label>
            <input type="text" class="form-control" id="csearch_timeframe" name="csearch_timeframe" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['psearch_title'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" placeholder="">
        </div>
    </div>
    <div class="form-group row align-items-center">
        <div class="col-10">
            <label >Tags (separate mutile by commas)</label>
            <input type="text" class="form-control" id="csearch_tags" name="csearch_tags" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['csearch_tags'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" placeholder="">
        </div>
        <div class="col-2">
            <input type="submit" id="csearch"  name="submit" value="Search" class="btn btn-gradient-primary font-weight-light w-100">
        </div>
    </div>
    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
"/>
</form><?php }
}
