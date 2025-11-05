<?php
/* Smarty version 4.2.1, created on 2023-08-16 19:34:21
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/condo_search_form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64dd24bdc1d117_20036023',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9aeba1745df159a672ae3511986c5ac836267cf3' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/condo_search_form.tpl',
      1 => 1683297464,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64dd24bdc1d117_20036023 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_options.php','function'=>'smarty_function_html_options',),));
?>
<div>
    <div class="fholder2">
        <label><b>Building Address</b></label><br>
        <input type="text" id="add" name="add" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['add'];?>
" class="input-lg for-search"/>
    </div>
    <div class="fholder2">
        <label><b>City</b></label><br>
        <input type="text" id="city" name="city" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['city'];?>
" class="input-lg for-search"/>
        <div class="note">Enter city with state for ex., Miami, FL</div>
    </div>
    <div class="fholder2">
        <label><b>Zipcode</b></label><br>
        <input type="text" id="zipcode" name="zipcode" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['zipcode'];?>
" class="input-lg for-search"/>
    </div>
    <br class="fclear">
        <div class="fholder2">
        <label><b>Subdivision</b></label><br>
        <input type="text" id="sdivlist" name="sdivlist" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['sdivlist'];?>
" class="input-lg for-search"/>
    </div>
    <div class="fholder2">
        <label><b>Year Built</b></label><br>
        <select name="minyear" class="apm_monoselect input-large">
            <option value="">Min</option>
            <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrminYearBuild']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minyear']),$_smarty_tpl);?>

        </select>
        To
        <select name="maxyear" class="apm_monoselect input-large">
            <option value="">Max</option>
            <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrmaxYearBuild']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxyear']),$_smarty_tpl);?>

        </select>
    </div>
    <div class="fholder2">
        <label><b>Date Range</b></label><br>
        <input id="datepickermin" name="mindate" value="<?php if (((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['mindate'])) && $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['mindate'] != '')) {
echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['mindate'];
}?>" class="input-large for-search"/>
        To
        <input id="datepickermax" name="maxdate" value="<?php if (((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxdate'])) && $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxdate'] != '')) {
echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxdate'];
}?>" class="input-large for-search"/>
    </div>
    <br class="fclear">
    <div class="fholder2">
        <label><b>Price Range</b></label><br>
        <input type="text" id="minprice" name="minprice" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minprice'];?>
" class="input-large for-search"/>
        To
        <input type="text" id="maxprice" name="maxprice" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxprice'];?>
" class="input-large for-search"/>
    </div>
    <br class="fclear">
    <div class="fholder2">
        <label><b>Waterfront</b></label><br>
        <select name="waterfront" class="apm_monoselect input-lg">
            <option value="">Any</option>
            <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['waterfront']),$_smarty_tpl);?>

        </select>
    </div>
    <div class="fholder2">
        <label><b>Pets Allowed</b></label><br>
        <select name="petsallowed" class="apm_monoselect input-lg">
            <option value="">Any</option>
            <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['petsallowed']),$_smarty_tpl);?>

        </select>
    </div>
    <?php ob_start();
echo constant('Constants::ACTRIS');
$_prefixVariable2 = ob_get_clean();
if ((isset($_smarty_tpl->tpl_vars['AgentSystemName']->value)) && $_smarty_tpl->tpl_vars['AgentSystemName']->value != $_prefixVariable2) {?>
        <div class="fholder2">
            <label><b>System Name</b></label><br>
            <select name="sys_name" class="apm_monoselect input-lg sys-name">
                <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrSystemName']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['sys_name']),$_smarty_tpl);?>

            </select>
        </div>
    <?php }?>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
    var minprice	= '<?php if ((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minprice'])) && $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minprice'] != '') {
echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minprice'];
} else { ?>0<?php }?>';
    var maxprice	= '<?php if ((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxprice'])) && $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxprice'] != '') {
echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxprice'];
} else { ?>0<?php }?>';
<?php echo '</script'; ?>
><?php }
}
