<?php
/* Smarty version 4.2.1, created on 2023-08-31 13:29:17
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/search_form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64f095ad0f9ce9_72505705',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9ab2b67d7ebbba08256d4fe3623f65e0d5a7ced8' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/search_form.tpl',
      1 => 1683297456,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64f095ad0f9ce9_72505705 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_options.php','function'=>'smarty_function_html_options',),));
?>
<div>
    <div class="fholder2">
        <label><b>MLS#</b></label>
        <input type="text" id="mlslist" name="mlslist" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['mlslist'];?>
" class="input-lg for-search"/>
    </div>
    <div class="fholder2">
        <label><b>Address</b></label>
        <input type="text" id="add" name="add" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['add'];?>
" class="input-lg for-search"/>
    </div>
    <div class="fholder2">
        <label><b>Price Range</b></label>
       <!-- <select name="minprice" class="apm_monoselect input-large">
            <option value="">Min</option>
            <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrPriceRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minprice']),$_smarty_tpl);?>

        </select>-->
		<input type="text" id="minprice" name="minprice" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minprice'];?>
" class="input-large for-search"/>
        To
       <!-- <select name="maxprice" class="apm_monoselect input-large">
            <option value="">Max</option>
            <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrPriceRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxprice']),$_smarty_tpl);?>

        </select>-->
		<input type="text" id="maxprice" name="maxprice" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxprice'];?>
" class="input-large for-search"/>
    </div>
    <br class="fclear">
            <div class="fholder2">
        <label><b>City</b></label><br>
              
            <div class="multi-opt cols3 multi-options-container">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrMeta']->value['City']['MIAMI/BEACHES'], 'citem', false, 'ckey', 'city', array (
));
$_smarty_tpl->tpl_vars['citem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['ckey']->value => $_smarty_tpl->tpl_vars['citem']->value) {
$_smarty_tpl->tpl_vars['citem']->do_else = false;
?>
                     <label><input type="checkbox" name="city[]" <?php if (((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['city']))) && (in_array($_smarty_tpl->tpl_vars['ckey']->value,$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['city']) || $_smarty_tpl->tpl_vars['ckey']->value == $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['city'])) {?>checked="checked"<?php } else {
}?> id="<?php echo $_smarty_tpl->tpl_vars['ckey']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['ckey']->value;?>
" />&nbsp<?php echo $_smarty_tpl->tpl_vars['citem']->value;?>
</label>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </div><br>
            </div>
    <div class="fholder2">
        <label><b>Subdivision</b></label>
        <input type="text" id="sdivlist" name="sdivlist" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['sdivlist'];?>
" class="input-lg for-search"/>
            </div>
    <div class="fholder2">
        <label><b>Lot Size</b></label>
        <select name="minlotsizesqft" class="apm_monoselect input-large">
            <option value="">Min</option>
            <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrLotSize']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minlotsizesqft']),$_smarty_tpl);?>

        </select>
        To
        <select name="maxlotsizesqft" class="apm_monoselect input-large">
            <option value="">Max</option>
            <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrLotSize']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxlotsizesqft']),$_smarty_tpl);?>

        </select>
    </div>
    <div class="fholder2">
        <label><b>Year Built</b></label>
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
        <label><b>Date Range</b></label>
        <input name="mindate" id="datepickermin" value="<?php if (((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['mindate'])) && $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['mindate'] != '')) {
echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['mindate'];
}?>" class="apm_monoselect datepickermin input-large">
        To
        <input name="maxdate" id="datepickermax" value="<?php if (((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxdate'])) && $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxdate'] != '')) {
echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxdate'];
}?>" class="apm_monoselect datepickermax input-large">
    </div>
    <br class="fclear">
    <div class="fholder2 pt-10">
        <label><b>Property Type</b></label><br>
                   <div class="multi-opt cols3 multi-options-container ProperTypeActris">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrMeta']->value['SubType'], 'pitem', false, 'pkey', 'ptype', array (
));
$_smarty_tpl->tpl_vars['pitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['pkey']->value => $_smarty_tpl->tpl_vars['pitem']->value) {
$_smarty_tpl->tpl_vars['pitem']->do_else = false;
?>
                    <label><input type="checkbox" name="stype[]" <?php if (((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['stype']))) && (in_array($_smarty_tpl->tpl_vars['pkey']->value,$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['stype']) || $_smarty_tpl->tpl_vars['pkey']->value == $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['stype'])) {?>checked="checked"<?php }?> id="<?php echo $_smarty_tpl->tpl_vars['pkey']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['pkey']->value;?>
" />&nbsp;<?php echo $_smarty_tpl->tpl_vars['pitem']->value;?>
</label>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                <label><input type="checkbox" name="stype[]" <?php if (((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['stype']))) && (in_array('CommercialLease',$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['stype']) || 'CommercialLease' == $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['stype'])) {?>checked="checked"<?php }?> id="CommercialLease" value="CommercialLease" />&nbsp;Commercial Lease</label>
            </div>
            </div>
            <div class="fholder2 pt-10">
            <label class="prpty-style"><b>Property Style</b></label>
            <div class="multi-opt cols3 multi-options-container prpty-style">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrMeta']->value['PropertyStyle'], 'sitem', false, 'skey', 'pstyle', array (
));
$_smarty_tpl->tpl_vars['sitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['skey']->value => $_smarty_tpl->tpl_vars['sitem']->value) {
$_smarty_tpl->tpl_vars['sitem']->do_else = false;
?>
                    <label><input type="checkbox" name="pstyle[]" <?php if (((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['pstyle']))) && (in_array($_smarty_tpl->tpl_vars['skey']->value,$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['pstyle']) || $_smarty_tpl->tpl_vars['skey']->value == $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['pstyle'])) {?>checked="checked"<?php }?> id="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
" />&nbsp;<?php echo $_smarty_tpl->tpl_vars['sitem']->value;?>
</label>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </div>
        </div>
       <div class="fholder2 pt-10">
        <label><b>Days on Market</b></label>
        <select name="dom" class="apm_monoselect input-lg">
            <option value="">Any</option>
            <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrDayMarket']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['dom']),$_smarty_tpl);?>

        </select>

    </div>

    <div class="fholder2">
        <div class="col6">
            <label><b>Waterfront</b></label>
            <select name="waterfront" class="apm_monoselect input-large">
                <option value="">Any</option>
                <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['waterfront']),$_smarty_tpl);?>

            </select>
        </div>

        <div class="col6">
            <label><b>Pool</b></label>
            <select name="pool" class="apm_monoselect input-large">
                <option value="">Any</option>
                <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['pool']),$_smarty_tpl);?>

            </select>
        </div>
    </div>
    <div class="fholder2">
        <label><b>Status</b></label>
        <div class="multi-opt cols3 multi-options-container">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrStatus']->value, 'sitem', false, 'skey', 'status', array (
));
$_smarty_tpl->tpl_vars['sitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['skey']->value => $_smarty_tpl->tpl_vars['sitem']->value) {
$_smarty_tpl->tpl_vars['sitem']->do_else = false;
?>
                <label><input type="checkbox" name="status[]" <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['status'])) && (in_array($_smarty_tpl->tpl_vars['skey']->value,$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['status']) || $_smarty_tpl->tpl_vars['skey']->value == $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['status'])) {?>checked="checked"<?php }?> id="ck-<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
" />&nbsp;<?php echo $_smarty_tpl->tpl_vars['sitem']->value;?>
</label>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </div>
    </div>
    <div class="fholder2">
        <label><b>Waterfront Descripton</b></label>
        <div class="multi-opt cols3 multi-options-container">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrWaterfrontDesc']->value, 'sitem', false, 'skey', 'waterfrontdesc', array (
));
$_smarty_tpl->tpl_vars['sitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['skey']->value => $_smarty_tpl->tpl_vars['sitem']->value) {
$_smarty_tpl->tpl_vars['sitem']->do_else = false;
?>
                <label><input type="checkbox" name="waterfrontdesc[]" <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['waterfrontdesc'])) && (in_array($_smarty_tpl->tpl_vars['skey']->value,$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['waterfrontdesc']) || $_smarty_tpl->tpl_vars['skey']->value == $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['waterfrontdesc'])) {?>checked="checked"<?php }?> id="ck-<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
" />&nbsp;<?php echo $_smarty_tpl->tpl_vars['sitem']->value;?>
</label>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </div>
    </div>

    <div class="fholder2">
        <div class="col6">
            <label><b>Pets Allowed</b></label>
            <select name="petsallowed" class="apm_monoselect input-large">
                <option value="">Any</option>
                <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['petsallowed']),$_smarty_tpl);?>

            </select>
        </div>

    </div>


    <br class="fclear">
    <div class="fholder2">
        <label><b>Sqft Range</b></label>
        <select name="minsqft" class="apm_monoselect input-large">
            <option value="">Min</option>
            <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrSqftRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minsqft']),$_smarty_tpl);?>

        </select>
        To
        <select name="maxsqft" class="apm_monoselect input-large">
            <option value="">Max</option>
            <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrSqftRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxsqft']),$_smarty_tpl);?>

        </select>
    </div>
    <div class="fholder2">
		<label><b># of Bedrooms</b></label>
		<select name="minbed" class="apm_monoselect input-large">
			<option value="">Min</option>
			<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrBedRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minbed']),$_smarty_tpl);?>

		</select>
		To
		<select name="maxbed" class="apm_monoselect input-large">
			<option value="">Max</option>
			<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrBedRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxbed']),$_smarty_tpl);?>

		</select>
    </div>
    <div class="fholder2">
		<label><b># of Bathrooms</b></label>
		<select name="minbath" class="apm_monoselect input-lg">
			<option value="">Select</option>
			<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrBathRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minbath']),$_smarty_tpl);?>

		</select>
	</div>
	<br class="fclear">
    <div class="fholder2">
        <label><b>Zipcode</b></label>
        <input type="text" id="zipcode" name="zipcode" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['zipcode'];?>
" class="input-lg for-search"/>
    </div>

        
    <div class="fholder2">
        <label><b>Office Id</b></label>
        <input type="text" id="office" name="office" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['office'];?>
" class="input-lg for-search"/>
    </div>
    <div class="fholder2">
        <label><b>Agent Id</b></label>
        <input type="text" id="agent" name="agent" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['agent'];?>
" class="input-lg for-search"/>
    </div>
    <br class="fclear" />
    <div class="fholder2">
        <label><b>Keyword</b></label>
        <input type="text" id="kword" name="kword" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['kword'];?>
" class="input-lg for-search"/>
        <div class="note-box input-lg"><b>Note: Keyword will be searched in Public, Private & Legal Remarks.</b></div>
    </div>
            <div class="fholder2">
            <label><b>System Name</b></label>
            <select name="sys_name" class="apm_monoselect input-lg sys-name">
                <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrSystemName']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['sys_name']),$_smarty_tpl);?>


            </select>
        </div>
            <div class="fholder2">
                   <label><b>Is Horse?</b></label>
            <select name="horse_yn" class="apm_monoselect input-lg">
                <option value="">Any</option>
                <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['horse_yn']),$_smarty_tpl);?>

            </select>
            </div>
    >

            <div class="fholder2">
                            <label class="security"><b>Security</b></label>
                <select name="security_safety" class="apm_monoselect input-lg security">
                    <option value="">No preference</option>
                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrSecuritySafety']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['security_safety']),$_smarty_tpl);?>

                </select>
                   </div>
        <div class="fholder2">
                            <div class="col6">
                <label><b>Membership Required</b></label>
                <select name="membership_required" class="apm_monoselect input-large">
                    <option value="">Any</option>
                    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['membership_required']),$_smarty_tpl);?>

                </select>
            </div>
           </div>
            <div class="fholder2">
            <div class="fholder2">
                <label><b>Membership Fee</b></label>
                <input type="text" id="membership_fee" name="membership_fee" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['membership_fee'];?>
" class="input-lg for-search"/>
            </div>
        </div>
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
