<?php
/* Smarty version 4.2.1, created on 2023-09-22 08:16:02
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/condo/condo-result.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_650d9392b8ec80_84627295',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d7fac4127ad895375947b0c3dbbc2fea58bdfa4' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/condo/condo-result.tpl',
      1 => 1695387894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_650d9392b8ec80_84627295 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/function.math.php','function'=>'smarty_function_math',),));
if ((isset($_smarty_tpl->tpl_vars['arrCondo']->value['csearch_is_visible'])) && $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_is_visible'] == "Yes") {?>
    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'table_header', null, null);?>
        <thead class="te-bg-table">
        <tr>
            <th class="border text-center" nowrap scope="col">Unit #</th>
            <th class="border text-center" nowrap scope="col">List Price</th>
            <th class="border text-center" nowrap scope="col">Price Change</th>
            <th class="border text-center" nowrap scope="col">Beds/Baths</th>
            <th class="border text-center" nowrap scope="col">Sq Ft</th>
            <th class="border text-center" nowrap scope="col">M<sup>2</sup></th>
            <th class="border text-center" nowrap scope="col">$/Sq Ft</th>
            <th class="border text-center" nowrap scope="col">Days Listed</th>
        </tr>
        </thead>
    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'sold_table_header', null, null);?>
        <thead class="te-bg-table">
        <tr>
            <th class="border text-center" nowrap scope="col">Unit #</th>
            <th class="border text-center" nowrap scope="col">Closed Price</th>
            <th class="border text-center" nowrap scope="col">List Price</th>
            <th class="border text-center" nowrap scope="col">Beds/Baths</th>
            <th class="border text-center" nowrap scope="col">Sq Ft</th>
            <th class="border text-center" nowrap scope="col">M<sup>2</sup></th>
            <th class="border text-center" nowrap scope="col">Days Listed</th>
            <th class="border text-center" nowrap scope="col">Closing Date</th>
        </tr>
        </thead>
    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'no_results', null, null);?>
        <div class="col-12 no-data-msg text-center- text-danger pt-3- px-0 mt-3 n-result  font-weight-bold">
                        <div class="no-result py-2 px-2"> No listings were found matching your search criteria. Contact us for off-market listings that may be available or coming soon.</div>
        </div>
    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
    <?php if ($_smarty_tpl->tpl_vars['arrCondoStatisticResult']->value > 0) {?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrCondoStatisticResult']->value['rs'], 'Record', false, 'key', 'CondoStatisticResult', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
            <?php $_smarty_tpl->_assignInScope('rsAttributes', Utility::generateListingAttributes($_smarty_tpl->tpl_vars['Record']->value));?>
            <?php if ($_smarty_tpl->tpl_vars['Record']->value['Beds'] == 6) {?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease' && ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Active' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ComingSoon' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending')) {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforsale6');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value;?>
"">
                        <td class="border text-center" nowrap>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable1 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable1);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable2 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable2);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                        <td class="border text-center" nowrap>
                            <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable3 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable3);?>
                            <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforsale6');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable4 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable4);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable5 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable5);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable6 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable6);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable7 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable7);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Active' && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] == 'ResidentialLease') {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforrent6');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value;?>
"">
                        <td class="border text-center" nowrap>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable8 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable8);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable9 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable9);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                        <td class="border text-center" nowrap>
                            <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable10 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable10);?>
                            <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforrent6');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable11 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable11);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable12 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable12);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable13 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable13);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable14 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable14);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease' && ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract')) {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforpending6');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value;?>
"">
                        <td class="border text-center" nowrap>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable15 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable15);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable16 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable16);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                        <td class="border text-center" nowrap>
                            <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable17 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable17);?>
                            <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforpending6');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable18 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable18);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable19 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable19);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable20 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable20);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable21 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable21);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed' && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease') {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforsold6');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable22 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable22);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['Sold_Date'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforsold6');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable23 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable23);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable24 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable24);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable25 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable25);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable26 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable26);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['Record']->value['Beds'] == 5) {?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease' && ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Active' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ComingSoon' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending')) {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforsale5');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                        <div class="d-flex justify-content-start">
                            <div class="te-property-favourite fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" id="fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                                <?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>
                                    <?php if ((isset($_smarty_tpl->tpl_vars['userFavList']->value)) && in_array($_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'],$_smarty_tpl->tpl_vars['userFavList']->value)) {?>
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Remove','CondoSearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                    <?php } else { ?>
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Add','CondoSearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                    <?php }?>
                                <?php } else { ?>
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login&ReqType=AddFav&mlsNum=<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                <?php }?>
                            </div>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </div>
                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable27 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable27);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable28 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable28);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                        <td class="border text-center" nowrap>
                            <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable29 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable29);?>
                            <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforsale5');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable30 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable30);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable31 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable31);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable32 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable32);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable33 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable33);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Active' && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] == 'ResidentialLease') {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforrent5');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                            <div class="d-flex justify-content-start">
                                <div class="te-property-favourite fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" id="fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                                    <?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['userFavList']->value)) && in_array($_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'],$_smarty_tpl->tpl_vars['userFavList']->value)) {?>
                                            <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Remove','SearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                        <?php } else { ?>
                                            <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Add','SearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        <?php }?>
                                    <?php } else { ?>
                                        <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login&ReqType=AddFav&mlsNum=<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                    <?php }?>
                                </div>
                                <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                            </div>
                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable34 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable34);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable35 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable35);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                        <td class="border text-center" nowrap>
                            <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable36 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable36);?>
                            <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforrent5');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable37 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable37);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable38 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable38);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable39 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable39);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable40 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable40);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" id="fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                                <?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>
                                    <?php if ((isset($_smarty_tpl->tpl_vars['userFavList']->value)) && in_array($_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'],$_smarty_tpl->tpl_vars['userFavList']->value)) {?>
                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Remove','SearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    <?php } else { ?>
                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Add','SearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    <?php }?>
                                <?php } else { ?>
                                    <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login&ReqType=AddFav&mlsNum=<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                <?php }?>
                            </div>
                        </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease' && ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract')) {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforpending5');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable41 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable41);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable42 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable42);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                        <td class="border text-center" nowrap>
                            
                            <?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>
                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable43 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable43);?>
                                <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                            <?php } else { ?>0<?php }?>
                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforpending5');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable44 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable44);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable45 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable45);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable46 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable46);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable47 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable47);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" id="fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                                <?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>
                                    <?php if ((isset($_smarty_tpl->tpl_vars['userFavList']->value)) && in_array($_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'],$_smarty_tpl->tpl_vars['userFavList']->value)) {?>
                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Remove','SearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    <?php } else { ?>
                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Add','SearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    <?php }?>
                                <?php } else { ?>
                                    <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login&ReqType=AddFav&mlsNum=<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                <?php }?>
                            </div>
                        </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed' && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease') {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforsold5');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable48 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable48);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['Sold_Date'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforsold5');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable49 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable49);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable50 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable50);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable51 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable51);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable52 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable52);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['Record']->value['Beds'] == 4) {?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease' && ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Active' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ComingSoon' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending')) {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforsale4');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                        <div class="d-flex justify-content-start">
                            <div class="te-property-favourite fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" id="fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                                <?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>
                                    <?php if ((isset($_smarty_tpl->tpl_vars['userFavList']->value)) && in_array($_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'],$_smarty_tpl->tpl_vars['userFavList']->value)) {?>
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Remove','CondoSearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                    <?php } else { ?>
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Add','CondoSearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                    <?php }?>
                                <?php } else { ?>
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login&ReqType=AddFav&mlsNum=<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                <?php }?>
                            </div>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </div>
                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable53 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable53);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable54 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable54);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                                                <?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>
                            <td class="border text-center" nowrap>
                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable55 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable55);?>
                                <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                            </td>
                        <?php } else { ?>
                            <td class="border text-center" nowrap>0</td>
                        <?php }?>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforsale4');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable56 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable56);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable57 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable57);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable58 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable58);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable59 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable59);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Active' && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] == 'ResidentialLease') {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforrent4');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                                                        <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable60 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable60);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable61 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable61);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                                                <?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>
                            <td class="border text-center" nowrap>
                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable62 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable62);?>
                                <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                            </td>
                        <?php } else { ?>
                            <td class="border text-center" nowrap>0</td>
                        <?php }?>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforrent4');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable63 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable63);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable64 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable64);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable65 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable65);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable66 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable66);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease' && ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract')) {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforpending4');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable67 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable67);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable68 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable68);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] != 0) {?>
                            <td class="border text-center" nowrap>
                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable69 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable69);?>
                                <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                            </td>
                        <?php } else { ?>
                            <td class="border text-center" nowrap>0</td>
                        <?php }?>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforpending4');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable70 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable70);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable71 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable71);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable72 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable72);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable73 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable73);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" id="fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                                <?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>
                                    <?php if ((isset($_smarty_tpl->tpl_vars['userFavList']->value)) && in_array($_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'],$_smarty_tpl->tpl_vars['userFavList']->value)) {?>
                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Remove','SearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    <?php } else { ?>
                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Add','SearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    <?php }?>
                                <?php } else { ?>
                                    <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login&ReqType=AddFav&mlsNum=<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                <?php }?>
                            </div>
                        </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed' && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease') {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforsold4');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable74 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable74);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['Sold_Date'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforsold4');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable75 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable75);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable76 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable76);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable77 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable77);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable78 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable78);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['Record']->value['Beds'] == 3) {?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease' && ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Active' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ComingSoon' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending')) {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforsale3');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                        <div class="d-flex justify-content-start">
                            <div class="te-property-favourite fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" id="fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                                <?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>
                                    <?php if ((isset($_smarty_tpl->tpl_vars['userFavList']->value)) && in_array($_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'],$_smarty_tpl->tpl_vars['userFavList']->value)) {?>
                                         <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Remove','CondoSearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                    <?php } else { ?>
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Add','CondoSearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                    <?php }?>
                                <?php } else { ?>
                                        <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login&ReqType=AddFav&mlsNum=<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                <?php }?>
                            </div>
                        <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </div>
                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable79 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable79);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable80 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable80);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] != 0) {?>
                            <td class="border text-center" nowrap>
                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable81 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable81);?>
                                <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                            </td>
                        <?php } else { ?>
                            <td class="border text-center" nowrap>0</td>
                        <?php }?>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforsale3');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable82 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable82);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable83 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable83);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable84 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable84);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable85 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable85);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Active' && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] == 'ResidentialLease') {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforrent3');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable86 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable86);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable87 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable87);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] != 0) {?>
                            <td class="border text-center" nowrap>
                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable88 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable88);?>
                                <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                            </td>
                        <?php } else { ?>
                            <td class="border text-center" nowrap>0</td>
                        <?php }?>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforrent3');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable89 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable89);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable90 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable90);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable91 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable91);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable92 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable92);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease' && ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract')) {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforpending3');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </td>
                                                                  <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
                          <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable93 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable93);?>
                  <td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable94 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable94);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] != 0) {?>
                            <td class="border text-center" nowrap>
                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable95 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable95);?>
                                <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                            </td>
                        <?php } else { ?>
                            <td class="border text-center" nowrap>0</td>
                        <?php }?>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforpending3');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable96 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable96);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable97 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable97);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable98 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable98);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable99 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable99);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed' && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease') {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforsold3');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable100 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable100);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['Sold_Date'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforsold3');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable101 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable101);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable102 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable102);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable103 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable103);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable104 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable104);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['Record']->value['Beds'] == 2) {?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease' && ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Active' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ComingSoon' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending')) {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforsale2');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                        <div class="d-flex justify-content-start">
                            <div class="te-property-favourite fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" id="fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                                <?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>
                                    <?php if ((isset($_smarty_tpl->tpl_vars['userFavList']->value)) && in_array($_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'],$_smarty_tpl->tpl_vars['userFavList']->value)) {?>
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Remove','CondoSearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                    <?php } else { ?>
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Add','CondoSearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                    <?php }?>
                                <?php } else { ?>
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login&ReqType=AddFav&mlsNum=<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                <?php }?>
                            </div>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </div>
                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable105 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable105);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable106 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable106);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] != 0) {?>
                            <td class="border text-center" nowrap>
                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable107 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable107);?>
                                <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                            </td>
                        <?php } else { ?>
                            <td class="border text-center" nowrap>0</td>
                        <?php }?>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforsale2');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable108 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable108);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable109 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable109);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable110 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable110);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable111 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable111);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Active' && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] == 'ResidentialLease') {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforrent2');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable112 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable112);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable113 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable113);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] != 0) {?>
                            <td class="border text-center" nowrap>
                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable114 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable114);?>
                                <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                            </td>
                        <?php } else { ?>
                            <td class="border text-center" nowrap>0</td>
                        <?php }?>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforrent2');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable115 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable115);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable116 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable116);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable117 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable117);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable118 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable118);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease' && ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract')) {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforpending2');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable119 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable119);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable120 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable120);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] != 0) {?>
                            <td class="border text-center" nowrap>
                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable121 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable121);?>
                                <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                            </td>
                        <?php } else { ?>
                            <td class="border text-center" nowrap>0</td>
                        <?php }?>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforpending2');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable122 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable122);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable123 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable123);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable124 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable124);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable125 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable125);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed' && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease') {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforsold2');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable126 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable126);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['Sold_Date'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforsold2');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable127 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable127);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable128 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable128);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable129 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable129);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable130 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable130);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['Record']->value['Beds'] == 1) {?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease' && ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Active' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ComingSoon' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending')) {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforsale1');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                        <div class="d-flex justify-content-start">
                            <div class="te-property-favourite fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" id="fav-link-container-<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                                <?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>
                                    <?php if ((isset($_smarty_tpl->tpl_vars['userFavList']->value)) && in_array($_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'],$_smarty_tpl->tpl_vars['userFavList']->value)) {?>
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Remove','CondoSearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                    <?php } else { ?>
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Add','CondoSearchResult','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                    <?php }?>
                                <?php } else { ?>
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login&ReqType=AddFav&mlsNum=<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                <?php }?>
                            </div>
                        <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </div>
                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable131 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable131);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable132 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable132);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] != 0) {?>
                            <td class="border text-center" nowrap>
                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable133 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable133);?>
                                <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                            </td>
                        <?php } else { ?>
                            <td class="border text-center" nowrap>0</td>
                        <?php }?>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforsale1');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable134 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable134);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable135 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable135);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable136 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable136);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable137 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable137);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Active' && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] == 'ResidentialLease') {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforrent1');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable138 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable138);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable139 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable139);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] != 0) {?>
                            <td class="border text-center" nowrap>
                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable140 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable140);?>
                                <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                            </td>
                        <?php } else { ?>
                            <td class="border text-center" nowrap>0</td>
                        <?php }?>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforrent1');?>
                        <div class="listings-box col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable141 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable141);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable142 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable142);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable143 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable143);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable144 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable144);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease' && ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending' || $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract')) {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforpending1');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap>
                            <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>

                        </td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable145 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable145);?>
<td class="border text-center <?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable146 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable146);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] != 0) {?>
                            <td class="border text-center" nowrap>
                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable147 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable147);?>
                                <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
                            </td>
                        <?php } else { ?>
                            <td class="border text-center" nowrap>0</td>
                        <?php }?>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforpending1');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable148 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable148);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable149 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable149);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable150 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable150);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable151 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable151);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed' && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != 'ResidentialLease') {?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'listforsold1');?>
                        <tr class="clickable-row" data-href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
">
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
                        <td class="border text-center" nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                        <td class="border text-center" nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?></td>
                        <td class="border text-center" nowrap><?php ob_start();
echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT'],'y'=>'0.0929'),$_smarty_tpl);
$_prefixVariable152 = ob_get_clean();
$_smarty_tpl->_assignInScope('meterssquare', $_prefixVariable152);?>
                            <?php if ($_smarty_tpl->tpl_vars['meterssquare']->value > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['meterssquare']->value);
} else { ?>-<?php }?></td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                        <td class="border text-center" nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['Sold_Date'];?>
</td>
                        </tr>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, 'gridforsold1');?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable153 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable153);?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php ob_start();
echo ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']).('/350/300/f/80');
$_prefixVariable154 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable154);?>
                                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable155 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable155);?>
                                <?php }?>
                                <img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
                                <div class="top-left">
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                        <div class="wedges list-wedge">Under Contract</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                        <div class="wedges list-wedge">Pending</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                        <div class="wedges-newListing list-wedge">New Listing</div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                        <span class="wedges list-wedge">Closed</span>
                                    <?php }?>
                                </div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable156 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable156);?>
                                        <div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> font-weight-normal"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></div>
                                        <div class="te-property-details-features te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
</div>
<div class="te-property-title text-truncate te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                                                    </div>
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <?php }?>
            <?php }?>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php }?>
    <section id="condo-building" class="condo-building te-font-family">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-0">
                    <div class="properties-slider condo-slider border-0">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrCondoResult']->value, 'Record', false, NULL, 'CondoSearchResult', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
                            <?php $_smarty_tpl->_assignInScope('rsAttributes', Utility::generateListingAttributes($_smarty_tpl->tpl_vars['Record']->value));?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['Host_Url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rsAttributes']->value['SFUrl'];?>
" tabindex="0" class="cp-2">
                                <div id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" class="listing-box px-0 slick-slide w-100" data-ref-id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" data-slick-index="0" aria-hidden="false" tabindex="0">
                                    <div class="listings-height d-block te-property-card te-property-gradient position-relative overflow-hidden">
                                        <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                            <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                            <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '') {?>
                                                <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                            <?php } else { ?>
                                                <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable157 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable157);?>
                                            <?php }?>
                                        <?php } else { ?>
                                            <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable158 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable158);?>
                                        <?php }?>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
" class="te-property-fig te-property-image w-100" alt="<?php echo $_smarty_tpl->tpl_vars['Record']->value['Address'];?>
">
                                        <div class="top-left">
                                            <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
                                                <div class="wedges list-wedge">Under Contract</div>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
                                                <div class="wedges list-wedge">Pending</div>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
                                                <div class="wedges-newListing list-wedge">New Listing</div>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
                                                <span class="wedges list-wedge">Closed</span>
                                            <?php }?>
                                                                                    </div>
                                        <div class="condo-overlay"></div>
                                        <div class="property-info te-smooth-gradient te-text-shadow">
                                                                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable159 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable159);?>
                                            <h3 class="text-white pb-1"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 <?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?><span class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?> te-font-size-18"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?><i class="fas fa-arrow-down"></i><?php } else { ?><i class="fas fa-arrow-up"></i><?php }
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
</span><?php }?></h3>
                                            <div class="pb-2- style-3-address te-font-size-12"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds &nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp; <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths</div>
                                            <div class="te-property-details-features te-font-size-12 pb-2- text-uppercase- font-weight-normal"><?php echo $_smarty_tpl->tpl_vars['Record']->value['Address'];?>
</div>
                                            <div class="te-property-details-features te-font-size-12 pb-2- text-uppercase- font-weight-normal"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </div>
                </div>
            </div>
            <div class="row d-lg-none condo-idx-list">
                <div class="col-12 px-0">
                    <ul class="nav nav-tabs p-0 border-0 conTabs" id="dataListTab" role="tablist">
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsale1" href="#mainListTabs" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_active_listing']);?>
<span class="d-block font-weight-normal- tabsFSize">FOR SALE</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forrent1" href="#mainListTabs" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_rental_listing']);?>
<span class="d-block font-weight-normal- tabsFSize">FOR RENT</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forpending1" href="#mainListTabs" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_pending_listing']);?>
<span class="d-block font-weight-normal- tabsFSize">PENDING</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsold1" href="#mainListTabs" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_sold_listing']);?>
<span class="d-block font-weight-normal- tabsFSize">SOLD</span></a></li>
                    </ul>
                    <ul class="nav nav-tabs p-0 border-0 conTabs d-none" id="dataGridTab" role="tablist">
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsale" href="#mainGridTabs" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_active_listing']);?>
<span class="d-block font-weight-normal- tabsFSize">FOR SALE</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forrent" href="#mainGridTabs" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_rental_listing']);?>
<span class="d-block font-weight-normal- tabsFSize">FOR RENT</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forpending" href="#mainGridTabs" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_pending_listing']);?>
<span class="d-block font-weight-normal- tabsFSize">PENDING</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsold" href="#mainGridTabs" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_sold_listing']);?>
<span class="d-block font-weight-normal- tabsFSize">SOLD</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="row px-xl-5 py-3- pt-4 pt-lg-5 align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-8 align-self-center- pb-0 heading text-left- px-2">
                    <h3 class="align-middle pb-2"><b><?php echo $_smarty_tpl->tpl_vars['csearch_name']->value;?>
</b></h3>
                                        <span class="text-uppercase te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_address'];?>
, <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_city'];?>
, <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_zipcode'];?>
</span>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4 col-4 align-self-center- px-2">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="dropdown d-inline-block mx-1- mx-lg-0 align-self-center col-md-auto- col-xl-auto- p-0 px-sm-5 px-xl-4 btn-gray py-lg-2-">
                            <button id="share-btn" class="btn btn-sm dropdown-toggle font-tab- dropdown-block font-size-sm-10- font-size-sm-12- te-btn- text-white- te-font-size-12- te-btn- text-white- shadow-none p-2 p-lg-2- px-xl-3- px-4 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt-" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-share-alt fa-2x align-middle pr-2"></i><span class="d-none- d-sm-inline d-lg-inline">SHARE</span>
                            </button>
                            <div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u=<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" target="_blank"><i class="fab fa-facebook-f pr-2"></i> Facebook</a>
                                <a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url=<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" target="_blank"><i class="fab fa-twitter pr-1"></i> Twitter</a>
                                <a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url=<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" target="_blank"><i class="fab fa-pinterest-p pr-2" ></i> Pinterest</a>
                                <a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" target="_blank"><i class="fab fa-linkedin-in pr-2"></i> LinkedIn</a>
                                <a class="dropdown-item font-size-14 py-1" href="mailto:?subject=Share <?php if ((isset($_smarty_tpl->tpl_vars['csearch_name']->value)) && $_smarty_tpl->tpl_vars['csearch_name']->value != '') {
echo $_smarty_tpl->tpl_vars['csearch_name']->value;
}?>&body=<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" target="_blank"><i class="fas fa-envelope pr-2 pr-2"></i> Email</a>
                            </div>
                        </div>
                            <?php if ((isset($_smarty_tpl->tpl_vars['arrCondo']->value['csearch_generate_mrktreport'])) && $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_generate_mrktreport'] == 'Yes') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['marketReportURL']->value;?>
" class="btn btn-sm font-size-sm-12 te-font-size-14 font-size-sm-10 shadow-none p-0 p-1- p-lg-2 p-xl-2 px-2- font-tab- text-sm-right rounded-0 font-weight-bold- lpt-btn text-white d-none- d-lg-block-">
                                    <i class="fas fa-2x fa-poll text-white- pr-2 align-middle"></i>
                                    <span class="d-none- d-sm-inline d-lg-inline align-middle"><?php if (cw::$screen == 'XS') {?>INSIGHTS <?php } else { ?> MARKET INSIGHTS<?php }?></span>
                                </a>
                            <?php }?>
                                                                    </div>
                </div>
                            </div>
            <div class="row px-lg-1 px-xl-5 pt-2 pt-lg-4"><div class="col-12 px-1 px-lg-1"><div class="border-top"></div></div></div>
            <?php if ((isset($_smarty_tpl->tpl_vars['arrCondo']->value['csearch_short_desc'])) && $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_short_desc'] != '') {?>
                <div class="row px-xl-5 py-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <p><?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_short_desc'];?>
</p>
                    </div>
                </div>
            <?php }?>
            <div class="row pt-lg-2 px-lg-2 px-xl-5 condo-idx-list">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-2">
                    <div class=" py-lg-3 d-none- d-md-block-">
                        <div class="row">
                            <div class="col-xl-8 col-lg-6 col-12 d-flex justify-content-between align-items-center pt-4 pt-lg-0">
                                <h4 class="align-middle- text-center text-sm-left pb-0 condo-sub-title pl-2- pl-md-0"><b><?php echo $_smarty_tpl->tpl_vars['csearch_name']->value;?>
 Condos</b></h4>
                                                            </div>
                            <div class="col-xl-4 col-lg-6 col-12 order-1 order-lg-2 d-none d-lg-block">
                                <ul class="nav nav-tabs p-0 border-0 conTabs" id="dataListTab" role="tablist">
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsale1" href="#mainListTabs" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_active_listing']);?>
<span class="d-block font-weight-normal tabsFSize">FOR SALE</span></a></li>
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forrent1" href="#mainListTabs" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_rental_listing']);?>
<span class="d-block font-weight-normal tabsFSize">FOR RENT</span></a></li>
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forpending1" href="#mainListTabs" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_pending_listing']);?>
<span class="d-block font-weight-normal tabsFSize">PENDING</span></a></li>
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsold1" href="#mainListTabs" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_sold_listing']);?>
<span class="d-block font-weight-normal tabsFSize">SOLD</span></a></li>
                                </ul>
                                <ul class="nav nav-tabs p-0 border-0 conTabs d-none" id="dataGridTab" role="tablist">
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsale" href="#mainGridTabs" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_active_listing']);?>
<span class="d-block font-weight-normal tabsFSize">FOR SALE</span></a></li>
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forrent" href="#mainGridTabs" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_rental_listing']);?>
<span class="d-block font-weight-normal tabsFSize">FOR RENT</span></a></li>
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forpending" href="#mainGridTabs" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_pending_listing']);?>
<span class="d-block font-weight-normal tabsFSize">PENDING</span></a></li>
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsold" href="#mainGridTabs" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_sold_listing']);?>
<span class="d-block font-weight-normal tabsFSize">SOLD</span></a></li>
                                </ul>
                            </div>
                        </div>
                                            </div>
                    <div class="row pt-3 te-font-size-14 px-2 px-lg-0 text-dark">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pb-md-5- pb-lg-0 px-2">
                            <ul class="p-0">
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Year Built</span><span class="font-weight-bold"><?php if ($_smarty_tpl->tpl_vars['arrCondo']->value['csearch_year_built'] != '') {
echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_year_built'];
} else { ?>-<?php }?></span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Units</span><span class="font-weight-bold"><?php if ($_smarty_tpl->tpl_vars['arrCondo']->value['csearch_unit'] != '') {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCondo']->value['csearch_unit']);
} else { ?>-<?php }?></span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Stories</span><span class="font-weight-bold"><?php if ($_smarty_tpl->tpl_vars['arrCondo']->value['csearch_stories'] != '') {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCondo']->value['csearch_stories']);
} else { ?>-<?php }?></span></li>
                            </ul>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pb-md-5- pb-lg-0 px-2">
                            <ul class="p-0">
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Active Units For Sale</span><span class="font-weight-bold"><?php if ($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_active_listing'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_active_listing']);
} else { ?>-<?php }?></span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Units Under Contract</span><span class="font-weight-bold"><?php if ($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_under_contract_listing'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_under_contract_listing']);
} else { ?>-<?php }?></span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Units Sold (6 months)</span><span class="font-weight-bold"><?php if ($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_sixmon_tot_sold_listing'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_sixmon_tot_sold_listing']);
} else { ?>-<?php }?></span></li>
                            </ul>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 px-2">
                            <ul class="p-0">
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price Listed / SqFt</span><span class="font-weight-bold"><?php if ($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_avg_price_sqft'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_avg_price_sqft']);
} else { ?>-<?php }?></span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price Sold / SqFt</span><span class="font-weight-bold"><?php if ($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_avg_sold_price_sqft'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_avg_sold_price_sqft']);
} else { ?>-<?php }?></span></li>
                                                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Discount</span><span class="font-weight-bold <?php if ($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_biggest_price_change'] < 0) {?>text-danger<?php } else { ?>text-success<?php }?>"><?php if ($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_biggest_price_change'] != '') {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_largest_price_reduction']);?>
 <?php if ($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_biggest_price_change'] > 0) {?>+<?php }?>(<?php echo smarty_modifier_number_format(round($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_biggest_price_change'],2));?>
%)<?php } else { ?>-<?php }?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                                                                            </div>
            <div class="row pt-2 pt-md-4 pt-lg-5 px-lg-2 px-xl-5 condo-idx te-font-size-14 px-2 px-md-0">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-lg-0">
                    <?php if (cw::$screen == 'XS') {?>
                        <div class="row text-center py-4">
                            <div class="col-12 px-2">
                                <?php if ((isset($_smarty_tpl->tpl_vars['arrCondo']->value['csearch_generate_mrktreport'])) && $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_generate_mrktreport'] == 'Yes') {?>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['marketReportURL']->value;?>
" class="btn btn-lg shadow-none rounded-0 lpt-btn text-white d-lg-none w-100">
                                        <span class="d-none- d-sm-inline d-lg-inline align-middle">MARKET TRENDS</span>
                                    </a>
                                <?php }?>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-6 pr-0 conTabs pl-2">
                                <div class="p-0 border w-100 mblList" id="myListTab">
                                    <div id="mainListTabs" class="hidden"></div>
                                    <select class="custom-select cusOptions border-0 w-75- w-auto py-0 px-3 text-center">
                                        <option id="for-sale-tab" value="forsale" aria-controls="forsale" data-title="!for-sale" data-target="#forsale1">FOR SALE</option>
                                        <option id="for-rent-tab" value="forrent" aria-controls="forrent" data-title="!for-rent" data-target="#forrent1">FOR RENT</option>
                                        <option id="for-pending-tab" value="forpending" aria-controls="forpending" data-title="!pending" data-target="#forpending1">PENDING</option>
                                        <option id="for-sold-tab" value="forsold" aria-controls="forsold" data-title="!sold" data-target="#forsold1">SOLD</option>
                                    </select>
                                </div>
                                                               <div class="p-0 border w-100 d-none mblGrid" id="myGridTab">
                                    <div id="mainGridTabs" class="hidden"></div>
                                    <select class="custom-select cusOptions border-0 w-75- w-auto py-0 px-3 text-center">
                                        <option id="for-sale-tab" value="forsale" aria-controls="forsale" data-title="!for-sale" data-target="#forsale">FOR SALE</option>
                                        <option id="for-rent-tab" value="forrent" aria-controls="forrent" data-title="!for-rent" data-target="#forrent">FOR RENT</option>
                                        <option id="for-pending-tab" value="forpending" aria-controls="forpending" data-title="!pending" data-target="#forpending">PENDING</option>
                                        <option id="for-sold-tab" value="forsold" aria-controls="forsold" data-title="!sold" data-target="#forsold">SOLD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 pl-0 pr-2">
                                <div class="border- w-100 conTabs mblView">
                                                                        <div class="dropdown list-grid-dropdown">
                                        <button class="btn btn-secondary- text-primary custom-select border- dropdown-toggle listgridOptions" type="button"    id="listgridOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            LIST <i class="fas fa-bars pl-2-"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <div id="condo-list" value="condo-list"  class="dropdown-item text-primary " href="#">LIST <i class="fas fa-bars"></i></div>
                                            <div id="condo-grid" value="condo-grid"  class="dropdown-item text-primary" href="#">GRID <i class="fas fa-th"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <ul class="nav nav-tabs p-0 border-0 conTabs" id="myListTab" role="tablist">
                            <div id="mainListTabs" class="hidden"></div>
                            <li class="nav-item w-25"><a id="for-sale-tab" data-target="#forsale1" data-toggle="tab" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">(<?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_active_listing']);?>
) <?php if (cw::$screen == 'XS') {?><span class="d-block tabsFSize">FOR SALE</span><?php } else { ?>FOR SALE<?php }?></a></li>
                            <li class="nav-item w-25"><a id="for-rent-tab" data-target="#forrent1" data-toggle="tab" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">(<?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_rental_listing']);?>
) <?php if (cw::$screen == 'XS') {?><span class="d-block tabsFSize">FOR RENT</span><?php } else { ?>FOR RENT<?php }?></a></li>
                            <li class="nav-item w-25"><a id="for-pending-tab" data-target="#forpending1" data-toggle="tab" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">(<?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_pending_listing']);?>
) <?php if (cw::$screen == 'XS') {?><span class="d-block tabsFSize">PENDING</span><?php } else { ?>PENDING<?php }?></a></li>
                            <li class="nav-item w-25"><a id="for-sold-tab" data-target="#forsold1" data-toggle="tab" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">(<?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_sold_listing']);?>
) <?php if (cw::$screen == 'XS') {?><span class="d-block tabsFSize">SOLD</span><?php } else { ?>SOLD<?php }?></a></li>
                        </ul>
                        <ul class="nav nav-tabs p-0 border-0 conTabs d-none" id="myGridTab" role="tablist">
                            <div id="mainGridTabs" class="hidden"></div>
                            <li class="nav-item w-25"><a id="for-sale-tab" data-target="#forsale" data-toggle="tab" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">(<?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_active_listing']);?>
) <?php if (cw::$screen == 'XS') {?><span class="d-block tabsFSize">FOR SALE</span><?php } else { ?>FOR SALE<?php }?></a></li>
                            <li class="nav-item w-25"><a id="for-rent-tab" data-target="#forrent" data-toggle="tab" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">(<?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_rental_listing']);?>
) <?php if (cw::$screen == 'XS') {?><span class="d-block tabsFSize">FOR RENT</span><?php } else { ?>FOR RENT<?php }?></a></li>
                            <li class="nav-item w-25"><a id="for-pending-tab" data-target="#forpending" data-toggle="tab" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">(<?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_pending_listing']);?>
) <?php if (cw::$screen == 'XS') {?><span class="d-block tabsFSize">PENDING</span><?php } else { ?>PENDING<?php }?></a></li>
                            <li class="nav-item w-25"><a id="for-sold-tab" data-target="#forsold" data-toggle="tab" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">(<?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['arrCStatistics']->value['statistic_total_sold_listing']);?>
) <?php if (cw::$screen == 'XS') {?><span class="d-block tabsFSize">SOLD</span><?php } else { ?>SOLD<?php }?></a></li>
                        </ul>
                        <ul class="nav nav-tabs p-0 border-0 justify-content-end pt-3 py-0" id="viewTab" role="tablist">
                            <li class="nav-item active"><a id="condo-list" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true" class="nav-link active font-size-sm-10 font-size-sm-12 te-font-size-12 tab-btn- border-0"><span class="condo-font-size-18 align-middle">List</span> <i class="fa fa-bars pr-md-1 pr-0 <?php if (cw::$screen == 'XS') {?> fa-1x <?php } else { ?> fa-2x <?php }?> align-middle"></i></a></li>
                            <li class="nav-item"><a id="condo-grid" data-toggle="tab" href="#grid" role="tab" aria-controls="grid" aria-selected="false" class="nav-link font-size-sm-10 font-size-sm-12 te-font-size-12 pr-3 tab-btn- border-0"><span class="condo-font-size-18 align-middle">Grid</span> <i class="fa fa-th pr-md-1 pr-0 <?php if (cw::$screen == 'XS') {?> fa-1x <?php } else { ?> fa-2x <?php }?> align-middle"></i></a></li>
                        </ul>
                    <?php }?>
                    <div class="tab-content" id="myTabContent">
                        <div id="grid" role="tabpanel" aria-labelledby="condo-grid" class="tab-pane show">
                            <div id="datagrid" class="tab-content py-5">
                                <div id="forsale" role="tabpanel" aria-labelledby="for-sale-tab condo-grid" class="tab-pane show active">
                                    <div class="row">
                                        <?php if (((isset($_smarty_tpl->tpl_vars['gridforsale6']->value)) && is_array($_smarty_tpl->tpl_vars['gridforsale6']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforsale5']->value)) && is_array($_smarty_tpl->tpl_vars['gridforsale5']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforsale4']->value)) && is_array($_smarty_tpl->tpl_vars['gridforsale4']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforsale3']->value)) && is_array($_smarty_tpl->tpl_vars['gridforsale3']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforsale3']->value)) && is_array($_smarty_tpl->tpl_vars['gridforsale2']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforsale1']->value)) && is_array($_smarty_tpl->tpl_vars['gridforsale1']->value))) {?>

                                            <?php if ($_smarty_tpl->tpl_vars['gridforsale6']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforsale6']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforsale5']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforsale5']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforsale4']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforsale4']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforsale3']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforsale3']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforsale2']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforsale2']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforsale1']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforsale1']->value);?>
 <?php }?>
                                                                                    <?php } else { ?>
                                            <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'no_results');?>

                                        <?php }?>
                                    </div>
                                </div>
                                <div id="forrent" role="tabpanel" aria-labelledby="for-rent-tab condo-grid" class="tab-pane show">
                                    <div class="row">
                                        <?php if (((isset($_smarty_tpl->tpl_vars['gridforrent6']->value)) && is_array($_smarty_tpl->tpl_vars['gridforrent6']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforrent5']->value)) && is_array($_smarty_tpl->tpl_vars['gridforrent5']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforrent4']->value)) && is_array($_smarty_tpl->tpl_vars['gridforrent4']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforrent3']->value)) && is_array($_smarty_tpl->tpl_vars['gridforrent3']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforrent2']->value)) && is_array($_smarty_tpl->tpl_vars['gridforrent2']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforrent1']->value)) && is_array($_smarty_tpl->tpl_vars['gridforrent1']->value))) {?>

                                            <?php if ($_smarty_tpl->tpl_vars['gridforrent6']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforrent6']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforrent5']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforrent5']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforrent4']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforrent4']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforrent3']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforrent3']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforrent2']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforrent2']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforrent1']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforrent1']->value);?>
 <?php }?>
                                                                                    <?php } else { ?>
                                            <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'no_results');?>

                                        <?php }?>
                                    </div>
                                </div>
                                <div id="forpending" role="tabpanel" aria-labelledby="for-pending-tab condo-grid" class="tab-pane show">
                                    <div class="row">
                                        <?php if (((isset($_smarty_tpl->tpl_vars['gridforpending6']->value)) && is_array($_smarty_tpl->tpl_vars['gridforpending6']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforpending5']->value)) && is_array($_smarty_tpl->tpl_vars['gridforpending5']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforpending4']->value)) && is_array($_smarty_tpl->tpl_vars['gridforpending4']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforpending3']->value)) && is_array($_smarty_tpl->tpl_vars['gridforpending3']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforpending2']->value)) && is_array($_smarty_tpl->tpl_vars['gridforpending2']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforpending1']->value)) && is_array($_smarty_tpl->tpl_vars['gridforpending1']->value))) {?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforpending6']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforpending6']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforpending5']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforpending5']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforpending4']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforpending4']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforpending3']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforpending3']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforpending2']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforpending2']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforpending1']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforpending1']->value);?>
 <?php }?>
                                                                                    <?php } else { ?>
                                            <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'no_results');?>

                                        <?php }?>
                                    </div>
                                </div>
                                <div id="forsold" role="tabpanel" aria-labelledby="for-sold-tab condo-grid" class="tab-pane show">
                                    <div class="row">
                                        <?php if (((isset($_smarty_tpl->tpl_vars['gridforsold6']->value)) && is_array($_smarty_tpl->tpl_vars['gridforsold6']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforsold5']->value)) && is_array($_smarty_tpl->tpl_vars['gridforsold5']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforsold4']->value)) && is_array($_smarty_tpl->tpl_vars['gridforsold4']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforsold3']->value)) && is_array($_smarty_tpl->tpl_vars['gridforsold3']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforsold2']->value)) && is_array($_smarty_tpl->tpl_vars['gridforsold2']->value)) || ((isset($_smarty_tpl->tpl_vars['gridforsold1']->value)) && is_array($_smarty_tpl->tpl_vars['gridforsold1']->value))) {?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforsold6']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforsold6']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforsold5']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforsold5']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforsold4']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforsold4']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforsold3']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforsold3']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforsold2']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforsold2']->value);?>
 <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['gridforsold1']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['gridforsold1']->value);?>
 <?php }?>
                                                                                    <?php } else { ?>
                                            <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'no_results');?>

                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="list" role="tabpanel" aria-labelledby="condo-list" class="tab-pane show active">
                            <div id="datalist" class="tab-content pt-3 py-sm-0">
                                <div id="forsale1" role="tabpanel" aria-labelledby="for-sale-tab condo-list" class="tab-pane show active">
                                    <?php if (((isset($_smarty_tpl->tpl_vars['listforsale6']->value)) && is_array($_smarty_tpl->tpl_vars['listforsale6']->value)) || ((isset($_smarty_tpl->tpl_vars['listforsale5']->value)) && is_array($_smarty_tpl->tpl_vars['listforsale5']->value)) || ((isset($_smarty_tpl->tpl_vars['listforsale4']->value)) && is_array($_smarty_tpl->tpl_vars['listforsale4']->value)) || ((isset($_smarty_tpl->tpl_vars['listforsale3']->value)) && is_array($_smarty_tpl->tpl_vars['listforsale3']->value)) || ((isset($_smarty_tpl->tpl_vars['listforsale2']->value)) && is_array($_smarty_tpl->tpl_vars['listforsale2']->value)) || ((isset($_smarty_tpl->tpl_vars['listforsale1']->value)) && is_array($_smarty_tpl->tpl_vars['listforsale1']->value))) {?>
                                        <?php if (is_array($_smarty_tpl->tpl_vars['listforsale6']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">6 Bedroom Condos For Sale at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforsale6']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    <?php if ($_smarty_tpl->tpl_vars['listforsale6']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforsale6']->value);?>
 <?php }?>

                                                                                                        </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforsale5']->value)) && is_array($_smarty_tpl->tpl_vars['listforsale5']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">5 Bedroom Condos For Sale at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforsale5']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    
                                                    <?php if ($_smarty_tpl->tpl_vars['listforsale5']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforsale5']->value);?>
 <?php }?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if (is_array($_smarty_tpl->tpl_vars['listforsale4']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">4 Bedroom Condos For Sale at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforsale4']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforsale4']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforsale4']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforsale3']->value)) && is_array($_smarty_tpl->tpl_vars['listforsale3']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">3 Bedroom Condos For Sale at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforsale3']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforsale3']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforsale3']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforsale2']->value)) && is_array($_smarty_tpl->tpl_vars['listforsale2']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">2 Bedroom Condos For Sale at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforsale2']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforsale2']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforsale2']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforsale1']->value)) && is_array($_smarty_tpl->tpl_vars['listforsale1']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">1 Bedroom Condos For Sale at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforsale1']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforsale1']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforsale1']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                    <?php } else { ?>
                                        <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'no_results');?>

                                    <?php }?>
                                </div>
                                <div id="forrent1" role="tabpanel" aria-labelledby="for-rent-tab condo-list" class="tab-pane show" >
                                    <?php if (((isset($_smarty_tpl->tpl_vars['listforrent6']->value)) && is_array($_smarty_tpl->tpl_vars['listforrent6']->value)) || ((isset($_smarty_tpl->tpl_vars['listforrent5']->value)) && is_array($_smarty_tpl->tpl_vars['listforrent5']->value)) || ((isset($_smarty_tpl->tpl_vars['listforrent4']->value)) && is_array($_smarty_tpl->tpl_vars['listforrent4']->value)) || ((isset($_smarty_tpl->tpl_vars['listforrent3']->value)) && is_array($_smarty_tpl->tpl_vars['listforrent3']->value)) || ((isset($_smarty_tpl->tpl_vars['listforrent2']->value)) && is_array($_smarty_tpl->tpl_vars['listforrent2']->value)) || ((isset($_smarty_tpl->tpl_vars['listforrent1']->value)) && is_array($_smarty_tpl->tpl_vars['listforrent1']->value))) {?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforrent6']->value)) && is_array($_smarty_tpl->tpl_vars['listforrent6']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">6 Bedroom Condos For Rent at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforrent6']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforrent6']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforrent6']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforrent5']->value)) && is_array($_smarty_tpl->tpl_vars['listforrent5']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">5 Bedroom Condos For Rent at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforrent5']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                       <?php if ($_smarty_tpl->tpl_vars['listforrent5']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforrent5']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforrent4']->value)) && is_array($_smarty_tpl->tpl_vars['listforrent4']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">4 Bedroom Condos For Rent at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforrent4']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforrent4']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforrent4']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforrent3']->value)) && is_array($_smarty_tpl->tpl_vars['listforrent3']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">3 Bedroom Condos For Rent at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforrent3']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforrent3']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforrent3']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforrent2']->value)) && is_array($_smarty_tpl->tpl_vars['listforrent2']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">2 Bedroom Condos For Rent at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforrent2']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforrent2']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforrent2']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforrent1']->value)) && is_array($_smarty_tpl->tpl_vars['listforrent1']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">1 Bedroom Condos For Rent at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforrent1']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforrent1']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforrent1']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                    <?php } else { ?>
                                        <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'no_results');?>

                                    <?php }?>
                                </div>
                                <div id="forpending1" role="tabpanel" aria-labelledby="for-pending-tab condo-list" class="tab-pane show" >
                                    <?php if (((isset($_smarty_tpl->tpl_vars['listforpending6']->value)) && is_array($_smarty_tpl->tpl_vars['listforpending6']->value)) || ((isset($_smarty_tpl->tpl_vars['listforpending5']->value)) && is_array($_smarty_tpl->tpl_vars['listforpending5']->value)) || ((isset($_smarty_tpl->tpl_vars['listforpending4']->value)) && is_array($_smarty_tpl->tpl_vars['listforpending4']->value)) || ((isset($_smarty_tpl->tpl_vars['listforpending3']->value)) && is_array($_smarty_tpl->tpl_vars['listforpending3']->value)) || ((isset($_smarty_tpl->tpl_vars['listforpending2']->value)) && is_array($_smarty_tpl->tpl_vars['listforpending2']->value)) || ((isset($_smarty_tpl->tpl_vars['listforpending1']->value)) && is_array($_smarty_tpl->tpl_vars['listforpending1']->value))) {?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforpending6']->value)) && is_array($_smarty_tpl->tpl_vars['listforpending6']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">6 Bedroom Condos Pending at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforpending6']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                       <?php if ($_smarty_tpl->tpl_vars['listforpending6']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforpending6']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforpending5']->value)) && is_array($_smarty_tpl->tpl_vars['listforpending5']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">5 Bedroom Condos Pending at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforpending5']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforpending5']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforpending5']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforpending4']->value)) && is_array($_smarty_tpl->tpl_vars['listforpending4']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">4 Bedroom Condos Pending at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforpending4']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                       <?php if ($_smarty_tpl->tpl_vars['listforpending4']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforpending4']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforpending3']->value)) && is_array($_smarty_tpl->tpl_vars['listforpending3']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">3 Bedroom Condos Pending at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforpending3']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforpending3']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforpending3']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforpending2']->value)) && is_array($_smarty_tpl->tpl_vars['listforpending2']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">2 Bedroom Condos Pending at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforpending2']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforpending2']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforpending2']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforpending1']->value)) && is_array($_smarty_tpl->tpl_vars['listforpending1']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">1 Bedroom Condos Pending at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforpending1']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforpending1']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforpending1']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                    <?php } else { ?>
                                        <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'no_results');?>

                                    <?php }?>
                                </div>
                                <div id="forsold1" role="tabpanel" aria-labelledby="for-sold-tab condo-list" class="tab-pane show" >
                                    <?php if (((isset($_smarty_tpl->tpl_vars['listforsold6']->value)) && is_array($_smarty_tpl->tpl_vars['listforsold6']->value)) || ((isset($_smarty_tpl->tpl_vars['v']->value)) && is_array($_smarty_tpl->tpl_vars['listforsold5']->value)) || ((isset($_smarty_tpl->tpl_vars['listforsold4']->value)) && is_array($_smarty_tpl->tpl_vars['listforsold4']->value)) || ((isset($_smarty_tpl->tpl_vars['listforsold3']->value)) && is_array($_smarty_tpl->tpl_vars['listforsold3']->value)) || ((isset($_smarty_tpl->tpl_vars['listforsold2']->value)) && is_array($_smarty_tpl->tpl_vars['listforsold2']->value)) || ((isset($_smarty_tpl->tpl_vars['listforsold2']->value)) && is_array($_smarty_tpl->tpl_vars['listforsold2']->value))) {?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforsold6']->value)) && is_array($_smarty_tpl->tpl_vars['listforsold6']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">6 Bedroom Condos Sold at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforsold6']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'sold_table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforsold6']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforsold6']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforsold5']->value)) && is_array($_smarty_tpl->tpl_vars['listforsold5']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">5 Bedroom Condos Sold at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforsold5']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'sold_table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforsold5']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforsold5']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforsold4']->value)) && is_array($_smarty_tpl->tpl_vars['listforsold4']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">4 Bedroom Condos Sold at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforsold4']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'sold_table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforsold4']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforsold4']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforsold3']->value)) && is_array($_smarty_tpl->tpl_vars['listforsold3']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">3 Bedroom Condos Sold at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforsold3']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'sold_table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforsold3']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforsold3']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforsold2']->value)) && is_array($_smarty_tpl->tpl_vars['listforsold2']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">2 Bedroom Condos Sold at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforsold2']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'sold_table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforsold2']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforsold2']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['listforsold1']->value)) && is_array($_smarty_tpl->tpl_vars['listforsold1']->value)) {?>
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">1 Bedroom Condos Sold at <?php echo $_smarty_tpl->tpl_vars['arrCondo']->value['csearch_name'];?>
 (<?php echo count($_smarty_tpl->tpl_vars['listforsold1']->value);?>
)</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'sold_table_header');?>

                                                    <tbody class="border-bottom cus-fwight-bold">
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['listforsold1']->value != '') {?> <?php echo implode('',$_smarty_tpl->tpl_vars['listforsold1']->value);?>
 <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }?>
                                    <?php } else { ?>
                                        <?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'no_results');?>

                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } else { ?>
    <div class="col-12 no-data-msg text-center text-danger pt-3 font-weight-bold">
        The <?php echo $_smarty_tpl->tpl_vars['csearch_name']->value;?>
 condo page is disabled.
    </div>
<?php }
}
}
