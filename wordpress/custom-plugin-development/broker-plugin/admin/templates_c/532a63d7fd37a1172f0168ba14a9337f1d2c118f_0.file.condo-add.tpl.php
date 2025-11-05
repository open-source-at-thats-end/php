<?php
/* Smarty version 4.2.1, created on 2024-02-05 06:38:07
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/condo/condo-add.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_65c0824f23d4a8_17236738',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '532a63d7fd37a1172f0168ba14a9337f1d2c118f' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/condo/condo-add.tpl',
      1 => 1707114955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:condo_search_form.tpl' => 1,
  ),
),false)) {
function content_65c0824f23d4a8_17236738 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),));
echo '<script'; ?>
 type="text/javascript">
    var url = '<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
';
<?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['msgSuccess']->value) {?><div class="alert alert-success"><?php echo $_smarty_tpl->tpl_vars['msgSuccess']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }
if ($_smarty_tpl->tpl_vars['msgError']->value) {?><div class="alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['msgError']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }?>
<h2>Condo Search Details</h2>

<form id="frmCondoSearch" class="frmCondoSearch advanced-search search" action="" method="post" enctype="multipart/form-data" onsubmit="JavaScript: resetFormAttributes(this);">
    <div class="tab-content">
        <div id="tab-agent" class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="span10-">
                    <h3>Basic Details</h3>
                    <div class="fholder2">
                        <b><input type="checkbox" id="csearch_generate_mrktreport" name="csearch_generate_mrktreport" value="Yes" <?php if ($_smarty_tpl->tpl_vars['rsCondo']->value['csearch_generate_mrktreport'] == 'Yes') {?>checked<?php }?> class="input-lg"/> Generate Market Report</b>
                    </div>
                    <div class="fholder2">
                        <input type="checkbox" value="Yes" name="csearch_building" <?php if ($_smarty_tpl->tpl_vars['rsCondo']->value['csearch_building'] == 'Yes') {?>checked<?php }?> class="input-xxlarge required">&nbsp;<b>Building</b>
                    </div>
                    <div class="fholder2">
                        <input type="checkbox" value="Yes" name="csearch_luxury" <?php if ($_smarty_tpl->tpl_vars['rsCondo']->value['csearch_luxury'] == 'Yes') {?>checked<?php }?> class="input-xxlarge required">&nbsp;<b>Luxury</b>
                    </div>
                    <br class="fclear">
                    <br class="fclear">
                    <div class="fholder2">
                        <input type="checkbox" value="Yes" name="csearch_pet_friendly" <?php if ($_smarty_tpl->tpl_vars['rsCondo']->value['csearch_pet_friendly'] == 'Yes') {?>checked<?php }?> class="input-xxlarge required">&nbsp;<b>Pet-friendly</b>
                    </div>
                    <br class="fclear">
                    <br class="fclear">
                    <div class="fholder2">
                        <label><b>Building Name</b></label></br>
                        <input type="text" id="csearch_name" name="csearch_name" value="<?php echo $_smarty_tpl->tpl_vars['rsCondo']->value['csearch_name'];?>
" class="input-lg required"/>
                        <label class="error" for="csearch_name">Enter Condo Building Name</label>
                    </div>
                    <div class="fholder2">
                        <label><b>Limit Results by Number</b></label></br>
                            <input type="text" id="csearch_result_limit" name="csearch_result_limit" value="<?php echo $_smarty_tpl->tpl_vars['rsCondo']->value['csearch_result_limit'];?>
" class="input-lg"/>
                    </div>
                    <div class="fholder2">
                        <label><b>Tag</b></label></br>
                        <input type="text" id="csearch_tag" name="csearch_tag" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['rsCondo']->value['csearch_tag'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"  class="input-lg"/>
                    </div>
                    <br class="fclear">
                    <div class="fholder2">
                        <label><b>Building Address*</b></label></br>
                        <input type="text" id="csearch_address" name="csearch_address" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['rsCondo']->value['csearch_address'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"  class="input-lg for-search" required/>
                        <div class="note">Enter address without Unit Number, City and State</div>
                    </div>
                                        <div class="fholder2">
                        <label><b>City</b></label><br>
                        <input type="text" id="csearch_city" name="csearch_city" value="<?php echo $_smarty_tpl->tpl_vars['rsCondo']->value['csearch_city'];?>
" class="input-lg for-search"/>
                        <div class="note">Enter city with state for ex., Miami, FL</div>
                    </div>
                    <div class="fholder2">
                        <label><b>Zipcode</b></label><br>
                        <input type="text" id="csearch_zipcode" name="csearch_zipcode" value="<?php echo $_smarty_tpl->tpl_vars['rsCondo']->value['csearch_zipcode'];?>
" class="input-lg for-search"/>
                    </div>
                    <br class="fclear">
                    <div class="fholder2">
                        <label><b>Year Built</b></label><br>
                        <input type="text" id="csearch_year_built" name="csearch_year_built" value="<?php echo $_smarty_tpl->tpl_vars['rsCondo']->value['csearch_year_built'];?>
" class="input-lg for-search"/>
                    </div>
                    <div class="fholder2">
                        <label><b>Units</b></label></br>
                        <input type="text" id="csearch_unit" name="csearch_unit" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['rsCondo']->value['csearch_unit'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"  class="input-lg"/>
                    </div>
                    <div class="fholder2">
                        <label><b>Stories</b></label></br>
                        <input type="text" id="csearch_stories" name="csearch_stories" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['rsCondo']->value['csearch_stories'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"  class="input-lg"/>
                    </div>
                    <br class="fclear">
                                                            <div class="fholder2">
                        <label><b>Is Visible?</b></label></br>
                                                <select name="csearch_is_visible" class="apm_monoselect input-lg">
                            <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['rsCondo']->value['csearch_is_visible']),$_smarty_tpl);?>

                        </select>
                    </div>
                    <div class="fholder2">
                        <label><b>Neighborhood</b></label></br>
                                                <input type="text" id="csearch_neighborhood" name="csearch_neighborhood" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['rsCondo']->value['csearch_neighborhood'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"  class="input-lg"/>
                    </div>
                     <div class="fholder2">
                        <label><b>Rental Restrictions</b></label></br>
                        <input type="text" id="csearch_rental_restrictions" name="csearch_rental_restrictions" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['rsCondo']->value['csearch_rental_restrictions'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"  class="input-lg"/>
                    </div>

                    <div class="fholder2">
                        <label><b>Amenities</b></label></br>
                        <input type="text" id="csearch_amenities" name="csearch_amenities" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['rsCondo']->value['csearch_amenities'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"  class="input-lg"/>
                                            </div>
                                        <br class="fclear">
                    <div class="fholder2">
                        <input type="checkbox" value="Yes" name="csearch_display_in_agent" <?php if ($_smarty_tpl->tpl_vars['rsCondo']->value['csearch_display_in_agent'] == 'Yes') {?>checked<?php }?> class="input-xxlarge required">&nbsp;<b>Display in Agent</b>
                    </div>
                    <br class="fclear">
                                                                                <br class="fclear">
                    <br class="fclear">
                </div>
            </div>
        </div>
        <h3 class="title-red">Search Criteria</h3>
        <div id="tab-agent" class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="span10-">
                    <?php $_smarty_tpl->_subTemplateRender('file:condo_search_form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                    <div class="fright">
                        <p class="result-count aright">
                            <a href="JavaScript: void(0);" class="match button" onclick="JavaScript: Show_MatchedListing();"><i class="fa fa-filter fa-lg"></i>&nbsp;<b><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['total_record']->value,'0');?>
 MATCHES</b></a>
                            <input type="hidden" name="Action" value="<?php echo $_smarty_tpl->tpl_vars['Action']->value;?>
">
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <input id="condo-save" type="submit"  pk="<?php echo $_smarty_tpl->tpl_vars['pk']->value;?>
" class="btn" value="Save" name="Submit" />
        <input type="button" class="btn" value="Cancel" name="Submit" onclick="JavaScript: window.location='<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
';"/>
        <input type="hidden" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['pk']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" name="pk" />
        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value;?>
" name="searchC[]" class="searchC"/>
        <input type="hidden" value="Condominium" name="stype" />
    </div>
</form><?php }
}
