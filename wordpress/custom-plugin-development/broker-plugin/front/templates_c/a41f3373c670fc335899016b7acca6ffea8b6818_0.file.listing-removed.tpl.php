<?php
/* Smarty version 4.2.1, created on 2023-08-10 07:41:50
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/listing-removed.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64d4db0ec0a067_28397553',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a41f3373c670fc335899016b7acca6ffea8b6818' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/listing-removed.tpl',
      1 => 1647884306,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64d4db0ec0a067_28397553 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),));
?>
<section class="te-search-results-sec">
    <div class="container te-mls-property-embedding-container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 te-featured-properties px-3 py-3 mw-100 te-mls-property-embedding h-auto">
                <div class="row justify-content-between mb-2">

                </div>

                <div class="row clearfix te-main-search-property">
                    <div class="col-12 col-sm-12 p-2">
                        <h2 class="py-3 p-title mb-0 txt-heading heading_txt_color"><?php if ((isset($_smarty_tpl->tpl_vars['recDeletedListing']->value))) {
echo $_smarty_tpl->tpl_vars['recDeletedListing']->value['address_full'];
} else { ?>Property Information<?php }?></h2>
                    </div>

                    <?php if ($_smarty_tpl->tpl_vars['recDeletedListing']->value) {?>
                        <p class="off">Off Market</p>
                        <p><span>Price </span> <?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['recDeletedListing']->value['ListPrice'],0);?>
</p>
                        <?php if ($_smarty_tpl->tpl_vars['recDeletedListing']->value['Baths']) {?><p><span>Bathrooms </span> <?php echo $_smarty_tpl->tpl_vars['recDeletedListing']->value['Baths'];?>
</p><?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['recDeletedListing']->value['Beds']) {?><p><span>Bedrooms </span> <?php echo $_smarty_tpl->tpl_vars['recDeletedListing']->value['Beds'];?>
</p><?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['recDeletedListing']->value['SQFT']) {?><p><span>Square Footage </span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['recDeletedListing']->value['SQFT'],0);?>
</p><?php }?>
                    <?php } else { ?>
                        <div class="col-12 col-sm-12 p-2">
                            <p class="alert alert-info p-1 mb-0">Sorry, we did not find property information. Information might be removed from MLS Listings.</p>
                        </div>
                    <?php }?>
                    <div class="col-12 col-sm-12 p-2">
                        <p class="alert alert-info p-1">Please check it out below more similar listing(s) or start new search for your desired home.</p>
                    </div>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsResult']->value, 'Record', false, NULL, 'SearchResult', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
">
                            <a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                <?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
                                    <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php if ($_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url'] != '' && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
                                        <?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['Record']->value['MainPicture']['large']['url']);?>
                                    <?php } else { ?>
                                        <?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable1 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable1);?>
                                    <?php }?>
                                <?php } else { ?>
                                                                        <?php ob_start();
echo $_smarty_tpl->tpl_vars['Record']->value['MainPicture'];
$_prefixVariable2 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable2);?>
                                <?php }?>
								<img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
">
                                <div class="-te-property-gradient position-absolute"></div>
								<div class="te-gradient te-property-details te-animate text-white position-absolute te-z-index-99 te-p-5 pt-5">
									<div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
										<div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</div>
										<div class="te-property-details-features te-font-size-14"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Baths']);?>
 Baths <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
 Sq Ft</div>
										<div class="te-property-title text-truncate te-font-size-14"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</div>
									</div>
                                	<div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
								</div>
							</a>
                            <?php if ($_smarty_tpl->tpl_vars['arrConfig']->value['OtherConfig']['login_enable'] == 'Yes') {?>
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
                            <?php }?>
                        </div>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </div>
                <input type="hidden" name="OnPage" id="OnPage" value="RandomResult"/>
            </div>
        </div>
    </div>
</section>
<?php if (!$_smarty_tpl->tpl_vars['isUserLoggedIn']->value) {?>
    <input type="hidden" name="isredirect" id="isredirect" value="true" />
<?php }?>
<div class="modal fade property-contact-agent-modal" id="modal-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content px-2 rounded-0">

        </div>
    </div>
</div><?php }
}
