<?php
/* Smarty version 4.2.1, created on 2023-09-15 00:31:28
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/listing_detail.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_6503ec30f2b510_77093277',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b62e35eeee6e05667ae4b09e27f83db116fc0915' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/listing_detail.tpl',
      1 => 1694755880,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:listing/schedule_showing.tpl' => 1,
    'file:listing/mortgagae_calculator.tpl' => 1,
  ),
),false)) {
function content_6503ec30f2b510_77093277 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/function.math.php','function'=>'smarty_function_math',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),2=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/modifier.replace.php','function'=>'smarty_modifier_replace',),3=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
echo '<script'; ?>
 type="text/javascript">
	var maxViewedExceed 	= '<?php echo $_smarty_tpl->tpl_vars['maxViewedExceed']->value;?>
';
	var maxViewedExceedCount 	= '<?php echo $_smarty_tpl->tpl_vars['arrConfig']->value['Listing']['site_max_viewed_without_login'];?>
';
	var isloginReq 	= '<?php echo $_smarty_tpl->tpl_vars['isloginReq']->value;?>
';
	var url = '<?php echo $_smarty_tpl->tpl_vars['Record']->value['VirtualTourUrl'];?>
';
	var video = document.createElement("iframe");
	//console.log(video);
	video.setAttribute("src", url);
	video.addEventListener("canplay", function() {
		console.log("video true");
		console.log(video.videoHeight);
	});
	video.addEventListener("error", function() {
		console.log("video false");
	});

<?php echo '</script'; ?>
>

<section class="d-none d-md-block">
	<div class="container te-font-family con-div px-md-1 px-lg-2 px-xl-0">
				<div class="row py-md-3 py-lg-4 py-4 border-bottom border-dark">
			<div class="col-xl-3 col-lg-3 col-md-6 px-lg-0 align-self-center pb-3 pb-lg-0">
				<p class="text-left pb-0 mb-0 te-address-heading-property-details txt-color"><?php echo $_smarty_tpl->tpl_vars['Record']->value['address_short'];?>
</p>
				<p class="text-left pb-0 mb-0 txt-color"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</p>
				<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable1 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable1);?>
				<?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?>
					<p class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?>"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {
echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);
} else { ?>+<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);
}?>% (<?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
)</p>
				<?php }?>
			</div>
			<div class="col-xl-5 col-lg-5 col-md-6 align-self-center  price-detail-section px-0 pb-3 pb-lg-0">
				<div class="btn-group btn-group-sm te-heading-property-details-features d-inline-block my-1" role="group" aria-label="Basic example">
					<button type="button" class="btn px-2 px-xl-3 py-0 text-dark shadow-none">

						<h5 class="width-max-content mb-0 txt-heading heading_txt_color"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);
} else {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);
}?></h5>
						<p class="mb-0 text-secondary">Price</p>
					</button>
					<?php if (!in_array($_smarty_tpl->tpl_vars['Record']->value['PropertyType'],$_smarty_tpl->tpl_vars['arrPType']->value) && !in_array($_smarty_tpl->tpl_vars['Record']->value['SubType'],$_smarty_tpl->tpl_vars['arrSType']->value)) {?>
						<button type="button" class="btn px-2 px-xl-3 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
</h5>
							<p class="mb-0 text-secondary">Beds</p>
						</button>
						<button type="button" class="btn px-2 px-xl-3 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
</h5>
							<p class="mb-0 text-secondary">Baths</p>
						</button>
						<button type="button" class="btn px-2 px-xl-3 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</h5>
							<p class="mb-0 text-secondary">Half Baths</p>
						</button>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] != '') {?>
						<button type="button" class="btn px-2 px-xl-3 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
</h5>
							<p class="mb-0 text-secondary">Sq. Ft</p>
						</button>
					<?php }?>
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 col-md-6 align-self-center px-md-1 px-lg-0 pb-3 pb-lg-0 crypto-data">
				<?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != "ResidentialLease") {?>
					<ul class="d-flex p-0 te-font-size-12 justify-content-between- justify-content-center py-1 py-xl-3 text-white crypto-box">
						<?php if ((isset($_smarty_tpl->tpl_vars['bitcoinPrice']->value)) || (isset($_smarty_tpl->tpl_vars['etherium']->value))) {?>
						<?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['bitcoin']->value),$_smarty_tpl);
$_prefixVariable2 = ob_get_clean();
$_smarty_tpl->_assignInScope('bitcoinPrice', $_prefixVariable2);?>
						<?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['etherium']->value),$_smarty_tpl);
$_prefixVariable3 = ob_get_clean();
$_smarty_tpl->_assignInScope('etheriumPrice', $_prefixVariable3);?>
						<?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['cardano']->value),$_smarty_tpl);
$_prefixVariable4 = ob_get_clean();
$_smarty_tpl->_assignInScope('cardanoPrice', $_prefixVariable4);?>
						<li class="px-2- px-3 text-center"><img class="d-block mx-auto mb-1" src="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;?>
API/upload/pictures/bitcoin.png" alt="bitcoin"> <span class="te-font-size-7 text-black font-weight-bold">APPROX</span> <span class="d-block te-font-size-11 te-font-weight-600 text-black"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['bitcoinPrice']->value);?>
</span></li>
						<li class="px-2- px-3 text-center"><img class="d-block mx-auto mb-1" src="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;?>
API/upload/pictures/etherium.png" alt="etherium"> <span class="te-font-size-7 text-black font-weight-bold">APPROX</span> <span class="d-block te-font-size-11 te-font-weight-600 text-black"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['etheriumPrice']->value);?>
</span></li>
						<?php }?>
											</ul>
				<?php }?>
			</div>
			<div class="col-xl-1- col-lg-1- col-md-6- px-lg-0 align-self-center te-heading-save-share-button order-2 order-lg-1 pb-3 pb-md-0 text-lg-right">
				<div class="dropdown d-inline-block mx-1- mx-lg-0-">
					<button id = "share-btn" class="btn btn-sm dropdown-toggle te-font-size-13 te-btn- text-white- shadow-none py-2 py-lg-2 px-lg-2 px-xl-3 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt- btn-gray" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="fas fa-share-alt fa-2x align-middle pr-2"></i>Share
					</button>
					<div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u=<?php echo $_smarty_tpl->tpl_vars['detail_url']->value;?>
" target="_blank"><i class="fab fa-facebook-f pr-2"></i> Facebook</a>
						<a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url=<?php echo $_smarty_tpl->tpl_vars['detail_url']->value;?>
" target="_blank"><i class="fab fa-twitter pr-1"></i> Twitter</a>
						<a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url=<?php echo $_smarty_tpl->tpl_vars['detail_url']->value;?>
" target="_blank"><i class="fab fa-pinterest-p pr-2" ></i> Pinterest</a>
						<a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $_smarty_tpl->tpl_vars['detail_url']->value;?>
" target="_blank"><i class="fab fa-linkedin-in pr-2"></i> LinkedIn</a>
					</div>
				</div>
				<?php if ($_smarty_tpl->tpl_vars['arrConfig']->value['OtherConfig']['login_enable'] == 'Yes') {?>
					<span class="fav-link-container" id="fav-link-container">
						<?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>
							<?php if ((isset($_smarty_tpl->tpl_vars['userFavList']->value)) && in_array($_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'],$_smarty_tpl->tpl_vars['userFavList']->value)) {?>
								<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none py-2 py-lg-2 px-lg-2 px-xl-3 te-save-propery-detail rounded-0 mx-1 mx-lg-0 lpt-btn- lpt-btn-txt- btn-gray" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Remove','FullView','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart fa-2x pr-1 align-middle"></i> Save</a>
							<?php } else { ?>
								<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none py-2 py-lg-2 px-lg-2 px-xl-3 te-save-propery-detail rounded-0 mx-1 mx-lg-0 lpt-btn- lpt-btn-txt- btn-gray" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Add','FullView','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart fa-2x pr-1 align-middle"></i> Save</a>
							<?php }?>
						<?php } else { ?>
							<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none py-2 py-lg-2 px-lg-2 px-xl-3 te-save-propery-detail popup-modal-sm rounded-0 mx-1 mx-lg-0 lpt-btn- lpt-btn-txt- btn-gray" data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login&ReqType=AddFav&mlsNum=<?php echo $_smarty_tpl->tpl_vars['ListingID_MLS']->value;?>
" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart fa-2x pr-1 align-middle"></i> Save</a>
						<?php }?>
					</span>
				<?php }?>
			</div>
		</div>
		<div class="row bg-white position-sticky section-hash-link">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-none d-lg-block py-3 px-0">
				<ul class="list-inline m-0 text-left">
					<li class="list-inline-item px-2"><a class="text-dark" href="#overview-hash"><h6 class="txt-heading heading_txt_color">Overview</h6></a></li>
					<li class="list-inline-item px-2"><a class="text-dark" href="#property-information-hash"><h6 class="txt-heading heading_txt_color">Property Information</h6></a></li>
					<li class="list-inline-item px-2"><a class="text-dark" href="#location-hash"><h6 class="txt-heading heading_txt_color">Location</h6></a></li>
					<li class="list-inline-item px-2"><a class="text-dark" href="#te-mortgage-calculator-hash"><h6 class="txt-heading heading_txt_color">Mortgage Calculator</h6></a></li>
					<?php if (is_array($_smarty_tpl->tpl_vars['arrSimilar']->value) && count($_smarty_tpl->tpl_vars['arrSimilar']->value) > 0) {?><li class="list-inline-item px-2"><a class="text-dark" href="#te-similar-listings-hash"><h6 class="txt-heading heading_txt_color">Similar Properties</h6></a></li><?php }?>

				</ul>
			</div>
		</div>
	</div>
</section>
<div class="content">
	<div class="single-property-gallery-container">
		<div class="single-property-gallery" itemscope itemtype="https://schema.org/ImageGallery">
			<?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
				<?php if (count($_smarty_tpl->tpl_vars['Record']->value['PictureArr']['large']) > 0 && $_smarty_tpl->tpl_vars['Record']->value['TotalPhotos'] > 0) {?>
					<?php $_smarty_tpl->_assignInScope('count', 1);?>
					<?php
$__section_pic_0_loop = (is_array(@$_loop=count($_smarty_tpl->tpl_vars['Record']->value['PictureArr']['large'])) ? count($_loop) : max(0, (int) $_loop));
$_smarty_tpl->tpl_vars['__smarty_section_pic'] = new Smarty_Variable(array('total' => $__section_pic_0_loop));
if ($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['total'] !== 0) {
for ($__section_pic_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] = 0; $__section_pic_0_iteration <= $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['total']; $__section_pic_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']++){
?>
						<?php $_smarty_tpl->_assignInScope('photo_large', $_smarty_tpl->tpl_vars['Record']->value['PictureArr']['large'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null)]['url']);?>
						<?php $_smarty_tpl->_assignInScope('photo_thumb', (($tmp = $_smarty_tpl->tpl_vars['Record']->value['PictureArr']['thumb'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null)]['url'] ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['Record']->value['PictureArr']['large'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null)]['url'] ?? null : $tmp));?>
						<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['total']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['total'] : null) > 0) {?>
							<figure itemprop="associatedMedia" itemscope itemtype="https://schema.org/ImageObject" class="<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null) == 0) {?>sp-gallery-main-img<?php }
if ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null) > 4) {?>d-none<?php }?> <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>disabled-sold<?php }?>">
								<a aria-label="button" href="<?php echo $_smarty_tpl->tpl_vars['photo_large']->value;?>
" itemprop="contentUrl" data-size="1920x1280" class="te-cover image-size <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>disabled<?php }?>" style="background-image: url(<?php echo $_smarty_tpl->tpl_vars['photo_large']->value;?>
);"></a>
								<figcaption itemprop="caption description"><?php echo $_smarty_tpl->tpl_vars['Record']->value['address_short'];?>
 - <?php echo $_smarty_tpl->tpl_vars['count']->value;?>
</figcaption>
								<div class="top-left">
									<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null) == 0 && $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
										<div class="wedges list-detail-wedge">UNDER CONTRACT</div>
									<?php } elseif ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null) == 0 && $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
										<div class="wedges list-detail-wedge">CLOSED</div>
									<?php } elseif ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null) == 0 && $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
										<div class="wedges list-detail-wedge">Pending</div>
									<?php }?>
									<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null) == 0 && (isset($_smarty_tpl->tpl_vars['Record']->value['DOM'])) && $_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
										<div class="wedges-newListing list-detail-wedge">NEW LISTING</div>
									<?php }?>
								</div>
							</figure>

							<?php $_smarty_tpl->_assignInScope('tmpIndex', $_smarty_tpl->tpl_vars['tmpIndex']->value+1);?>
							<?php $_smarty_tpl->_assignInScope('count', $_smarty_tpl->tpl_vars['count']->value+1);?>

							<?php if ($_smarty_tpl->tpl_vars['tmpIndex']->value >= $_smarty_tpl->tpl_vars['cntKeyword']->value) {
$_smarty_tpl->_assignInScope('tmpIndex', 0);
}?>
						<?php }?>
					<?php
}
}
?>
				<?php } else { ?>
										<div class="pdetail-no-img text-center">
						<a aria-label="button" href="<?php echo $_smarty_tpl->tpl_vars['Record']->value['PhotoBaseUrl'];?>
no-photo/0/0/" itemprop="contentUrl" data-size="1920x1280" class="te-cover <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>disabled<?php }?>">
							<img src="<?php echo $_smarty_tpl->tpl_vars['Record']->value['PhotoBaseUrl'];?>
no-photo/0/0/" alt="<?php echo $_smarty_tpl->tpl_vars['Record']->value['address_short'];?>
">
						</a>
												<?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
							<span class="wedges list-detail-wedge">UNDER CONTRACT</span>
						<?php } elseif ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
							<span class="wedges list-detail-wedge">CLOSED</span>

						<?php } elseif ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
							<span class="wedges list-detail-wedge">Pending</span>
						<?php }?>
						<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['DOM'])) && $_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
							<span class="wedges-newListing list-detail-wedge">NEW LISTING</span>
						<?php }?>
					</div>

									<?php }?>
			<?php } else { ?>

								<?php if (count($_smarty_tpl->tpl_vars['Record']->value['PictureArr']) > 0) {?>
					<?php $_smarty_tpl->_assignInScope('count', 1);?>
					<?php
$__section_pic_1_loop = (is_array(@$_loop=count($_smarty_tpl->tpl_vars['Record']->value['PictureArr'])) ? count($_loop) : max(0, (int) $_loop));
$_smarty_tpl->tpl_vars['__smarty_section_pic'] = new Smarty_Variable(array('total' => $__section_pic_1_loop));
if ($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['total'] !== 0) {
for ($__section_pic_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] = 0; $__section_pic_1_iteration <= $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['total']; $__section_pic_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']++){
?>
												<?php $_smarty_tpl->_assignInScope('photo_large', $_smarty_tpl->tpl_vars['Record']->value['PictureArr'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null)]);?>
						<?php $_smarty_tpl->_assignInScope('photo_thumb', (($tmp = $_smarty_tpl->tpl_vars['Record']->value['PictureArr'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null)] ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['Record']->value['PictureArr'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null)] ?? null : $tmp));?>
						<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['total']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['total'] : null) > 0) {?>
							<figure itemprop="associatedMedia" itemscope itemtype="https://schema.org/ImageObject" class="<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null) == 0) {?>sp-gallery-main-img<?php }
if ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null) > 4) {?>d-none<?php }?> <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>disabled-sold<?php }?>">
								<a aria-label="button" href="<?php echo $_smarty_tpl->tpl_vars['photo_large']->value;?>
" itemprop="contentUrl" data-size="1920x1280" class="te-cover image-size <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>disabled<?php }?>" style="background-image: url(<?php echo $_smarty_tpl->tpl_vars['photo_large']->value;?>
);"></a>
								<figcaption itemprop="caption description"><?php echo $_smarty_tpl->tpl_vars['Record']->value['address_short'];?>
 - <?php echo $_smarty_tpl->tpl_vars['count']->value;?>
</figcaption>
								<div class="top-left">
									<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null) == 0 && $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
										<div class="wedges list-detail-wedge">UNDER CONTRACT</div>
									<?php } elseif ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null) == 0 && $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
										<div class="wedges list-detail-wedge">CLOSED</div>
									<?php } elseif ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null) == 0 && $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
										<div class="wedges list-detail-wedge">Pending</div>
									<?php }?>
									<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pic']->value['index'] : null) == 0 && (isset($_smarty_tpl->tpl_vars['Record']->value['DOM'])) && $_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
										<div class="wedges-newListing list-detail-wedge">NEW LISTING</div>
									<?php }?>
								</div>
							</figure>

							<?php $_smarty_tpl->_assignInScope('tmpIndex', $_smarty_tpl->tpl_vars['tmpIndex']->value+1);?>
							<?php $_smarty_tpl->_assignInScope('count', $_smarty_tpl->tpl_vars['count']->value+1);?>

							<?php if ($_smarty_tpl->tpl_vars['tmpIndex']->value >= $_smarty_tpl->tpl_vars['cntKeyword']->value) {
$_smarty_tpl->_assignInScope('tmpIndex', 0);
}?>
						<?php }?>
					<?php
}
}
?>
				<?php } else { ?>
															<div class="pdetail-no-img text-center">
						<a aria-label="button" href="<?php echo $_smarty_tpl->tpl_vars['Record']->value['Pic'];?>
no-photo/0/0/" itemprop="contentUrl" data-size="1920x1280" class="te-cover <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>disabled<?php }?>">
														<img src="<?php echo $_smarty_tpl->tpl_vars['Record']->value['PhotoBaseUrl'];?>
/no-photo/no-property-img.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['Record']->value['address_short'];?>
">
						</a>
												<?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'ActiveUnderContract') {?>
							<span class="wedges list-detail-wedge">UNDER CONTRACT</span>
						<?php } elseif ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>
							<span class="wedges list-detail-wedge">CLOSED</span>

						<?php } elseif ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Pending') {?>
							<span class="wedges list-detail-wedge">Pending</span>
						<?php }?>
						<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['DOM'])) && $_smarty_tpl->tpl_vars['Record']->value['DOM'] < 7) {?>
							<span class="wedges-newListing list-detail-wedge">NEW LISTING</span>
						<?php }?>
					</div>
									<?php }?>
			<?php }?>


		</div>
		<?php if ($_smarty_tpl->tpl_vars['Record']->value['mls_is_pic_url_supported'] == 'Yes') {?>
			<?php if (count($_smarty_tpl->tpl_vars['Record']->value['PictureArr']['large']) > 0) {?>
				<a class="btn btn-sm sp-gallery-btn te-btn text-white- text-uppercase p-2 shadow-none rounded-0 position-absolute te-font-size-14 te-pd-gallery-view-more lpt-btn lpt-btn-txt <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>disabled-sold<?php }?>" href="javascript::void(0);" role="button"><?php echo count($_smarty_tpl->tpl_vars['Record']->value['PictureArr']['large']);?>
 more photos</a>
				<!-- <a href="#" class="sp-gallery-btn">View Photos</a> -->
			<?php }?>
		<?php } else { ?>
			<?php if (count($_smarty_tpl->tpl_vars['Record']->value['PictureArr']) > 0) {?>
				<a class="btn btn-sm sp-gallery-btn te-btn text-white- text-uppercase p-2 shadow-none rounded-0 position-absolute te-font-size-14 te-pd-gallery-view-more lpt-btn lpt-btn-txt <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {?>disabled-sold<?php }?>" href="javascript::void(0);" role="button"><?php echo count($_smarty_tpl->tpl_vars['Record']->value['PictureArr']);?>
 more photos</a>
				<!-- <a href="#" class="sp-gallery-btn">View Photos</a> -->
			<?php }?>
		<?php }?>
				<div class="clearfix"></div>
	</div>
</div>
<section class="d-block d-md-none">
	<div class="container con-div">
				<div class="row pt-4 te-font-family">
			<div class="col-xl-4 col-lg-4 col-md-6 align-self-center pb-3">
				<p class="text-left mb-0 te-address-heading-property-details txt-color"><?php echo $_smarty_tpl->tpl_vars['Record']->value['address_short'];?>
</p>
				<p class="text-left mb-0 txt-color"><?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</p>
			</div>
			<div class="col-xl-5 col-lg-6 col-md-6 align-self-center pb-3">
				<div class="btn-group btn-group-sm te-heading-property-details-features d-inline-block my-1" role="group" aria-label="Basic example">
					<button type="button" class="btn pl-0 pr-2 py-0 text-dark shadow-none">

						<h5 class="width-max-content mb-0 te-pd-features-valuemobile-value txt-heading heading_txt_color"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);
} else {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);
}?></h5>
						<p class="mb-0 text-secondary">Price</p>
					</button>
					<?php if (!in_array($_smarty_tpl->tpl_vars['Record']->value['PropertyType'],$_smarty_tpl->tpl_vars['arrPType']->value) && !in_array($_smarty_tpl->tpl_vars['Record']->value['SubType'],$_smarty_tpl->tpl_vars['arrSType']->value)) {?>
						<button type="button" class="btn px-2 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
</h5>
							<p class="mb-0 text-secondary">Beds</p>
						</button>
						<button type="button" class="btn px-2 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
</h5>
							<p class="mb-0 text-secondary">Baths</p>
						</button>
						<button type="button" class="btn px-2 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</h5>
							<p class="mb-0 text-secondary">Half Baths</p>
						</button>
					<?php }?>
					<button type="button" class="btn pl-2 pr-0 py-0 text-dark shadow-none">
						<h5 class="width-max-content mb-0 txt-heading heading_txt_color"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
</h5>
						<p class="mb-0 text-secondary">Sq. Ft</p>
					</button>
				</div>

			</div>
			<div class="col-xl-1 col-lg-6 col-md-6 align-self-center px-0- pb-3 pb-lg-0 crypto-data">
				<div class="btn-group btn-group-sm te-heading-property-details-features d-inline-block my-1 w-100" role="group" aria-label="Basic example">
					<?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != "ResidentialLease") {?>
						<ul class="d-flex p-0 te-font-size-12 justify-content-around justify-content-sm-start py-1 py-xl-3 text-white crypto-box">
							<?php if ((isset($_smarty_tpl->tpl_vars['bitcoinPrice']->value)) || (isset($_smarty_tpl->tpl_vars['etherium']->value))) {?>
							<?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['bitcoin']->value),$_smarty_tpl);
$_prefixVariable5 = ob_get_clean();
$_smarty_tpl->_assignInScope('bitcoinPrice', $_prefixVariable5);?>
							<?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['etherium']->value),$_smarty_tpl);
$_prefixVariable6 = ob_get_clean();
$_smarty_tpl->_assignInScope('etheriumPrice', $_prefixVariable6);?>
							<?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['cardano']->value),$_smarty_tpl);
$_prefixVariable7 = ob_get_clean();
$_smarty_tpl->_assignInScope('cardanoPrice', $_prefixVariable7);?>
							<li class="px-2 text-center"><img class="d-block mx-auto mb-1" src="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;?>
API/upload/pictures/bitcoin.png" alt="bitcoin"> <span class="te-font-size-7 text-black font-weight-bold">APPROX</span> <span class="d-block te-font-size-11 te-font-weight-600 text-black"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['bitcoinPrice']->value);?>
</span></li>
							<li class="px-2 text-center"><img class="d-block mx-auto mb-1" src="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;?>
API/upload/pictures/etherium.png" alt="etherium"> <span class="te-font-size-7 text-black font-weight-bold">APPROX</span> <span class="d-block te-font-size-11 te-font-weight-600 text-black"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['etheriumPrice']->value);?>
</span></li>
							<?php }?>
													</ul>
					<?php }?>
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 px-lg-0 align-self-center te-heading-save-share-button order-2 order-lg-1 pb-3 pb-md-0">
				<div class="dropdown d-inline-block mx-1 mx-lg-0- w-100">
					<button id = "share-btn" class="btn btn-sm dropdown-toggle te-font-size-13 te-btn- text-white- shadow-none p-2 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt- btn-gray" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="fas fa-share-alt fa-2x align-middle pr-1"></i>Share
					</button>
					<div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u=<?php echo $_smarty_tpl->tpl_vars['detail_url']->value;?>
" target="_blank"><i class="fab fa-facebook-f pr-2"></i> Facebook</a>
						<a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url=<?php echo $_smarty_tpl->tpl_vars['detail_url']->value;?>
" target="_blank"><i class="fab fa-twitter pr-1"></i> Twitter</a>
						<a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url=<?php echo $_smarty_tpl->tpl_vars['detail_url']->value;?>
" target="_blank"><i class="fab fa-pinterest-p pr-2" ></i> Pinterest</a>
						<a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $_smarty_tpl->tpl_vars['detail_url']->value;?>
" target="_blank"><i class="fab fa-linkedin-in pr-2"></i> LinkedIn</a>
					</div>
				</div>
				<span class="fav-link-container w-100 mx-1- mx-lg-0-" id="fav-link-container-mobile">
				<?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>
					<?php if ((isset($_smarty_tpl->tpl_vars['userFavList']->value)) && in_array($_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'],$_smarty_tpl->tpl_vars['userFavList']->value)) {?>
						<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none p-2 te-save-propery-detail rounded-0 mx-1- mx-lg-0- w-100 lpt-btn- lpt-btn-txt- btn-gray" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Remove','FullView','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart align-middle fa-2x pr-1"></i> Save</a>
					<?php } else { ?>
						<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none p-2 te-save-propery-detail rounded-0 mx-1- mx-lg-0- w-100 lpt-btn- lpt-btn-txt- btn-gray" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
', 'Add','FullView','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart align-middle fa-2x pr-1"></i> Save</a>
					<?php }?>
				<?php } else { ?>
					<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none p-2 te-save-propery-detail popup-modal-sm rounded-0 mx-1- mx-lg-0- w-100 lpt-btn- lpt-btn-txt- btn-gray" data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login&ReqType=AddFav&mlsNum=<?php echo $_smarty_tpl->tpl_vars['ListingID_MLS']->value;?>
" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart align-middle fa-2x pr-1"></i> Save</a>
				<?php }?>
				</span>
			</div>
		</div>
	</div>
</section>
<section class="te-property-details-full te-font-family pt-4 pb-5 py-md-4">
	<div class="container con-div">

		<div class="row mt-md-4">
			<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 leftbar">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12 Featured-listings d-block d-md-none">
						<h4 class="pb-2 pl-2 txt-heading heading_txt_color">Property Details</h4>
						<table class="table te-font-size-14 te-table-property-detail table-borderless table-hover">
							<tbody>
							<tr>
								<td nowrap>Price</td>
								<td><?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);
} else {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);
}?></td>

							</tr>
							<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable8 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable8);?>
							<?php if ($_smarty_tpl->tpl_vars['pricedef']->value != 0) {?>
								<tr>
									<td>Price Change</td>
									<td class="<?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {?>text-danger<?php } else { ?>text-success<?php }?>"><?php if (substr($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],0,1) == '-') {
echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);
} else { ?>+<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);
}?>% (<?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
)
									</td>
								</tr>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0 && $_smarty_tpl->tpl_vars['Record']->value['ListPrice'] > 0) {?>
								<tr>
									<td nowrap>Price Per Sq Ft</td>
									<?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable9 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable9);?>
									<td><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);?>
</td>
								</tr>
							<?php }?>
							<tr>
								<td nowrap>MLS#</td>
								<td><?php echo $_smarty_tpl->tpl_vars['Record']->value['MLS_NUM'];?>
</td>
							</tr>
							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['YearBuilt'])) && $_smarty_tpl->tpl_vars['Record']->value['YearBuilt'] != '') {?>
								<tr>
									<td nowrap>Year Built</td>
									<td><?php echo $_smarty_tpl->tpl_vars['Record']->value['YearBuilt'];?>
</td>
								</tr>
							<?php }?>
							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'])) && $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] != '') {?>
								<tr>
									<td nowrap>Status</td>
									<td><?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'];?>
</td>
								</tr>
							<?php }?>
							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['SubType'])) && $_smarty_tpl->tpl_vars['Record']->value['SubType'] != '') {?>
								<tr>
									<td nowrap>Type</td>
									<td><?php echo $_smarty_tpl->tpl_vars['Record']->value['SubType'];?>
</td>
								</tr>
							<?php }?>
							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Tax'])) && $_smarty_tpl->tpl_vars['Record']->value['Tax'] != '') {?>
								<tr>
									<td nowrap>Taxes</td>
									<td><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Tax']);?>
 / year</td>
								</tr>
							<?php }?>
							<?php if (((isset($_smarty_tpl->tpl_vars['Record']->value['HOAFee'])) && $_smarty_tpl->tpl_vars['Record']->value['HOAFee'] != '') || ((isset($_smarty_tpl->tpl_vars['Record']->value['HOAFrequency'])) && $_smarty_tpl->tpl_vars['Record']->value['HOAFrequency'] != '')) {?>
								<tr>
									<td nowrap>HOA Fees</td>
									<td><?php if ($_smarty_tpl->tpl_vars['Record']->value['HOAFee'] != '') {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['HOAFee']);
}?> <?php if ($_smarty_tpl->tpl_vars['Record']->value['HOAFrequency'] != '') {?>/ <?php echo $_smarty_tpl->tpl_vars['Record']->value['HOAFrequency'];
}?></td>
								</tr>
							<?php }?>
							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Subdivision'])) && $_smarty_tpl->tpl_vars['Record']->value['Subdivision'] != '') {?>
								<tr>
									<td nowrap>Subdivision</td>
									<td><?php echo $_smarty_tpl->tpl_vars['Record']->value['Subdivision'];?>
</td>
								</tr>
							<?php }?>
							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Is_Waterfront'])) && $_smarty_tpl->tpl_vars['Record']->value['Is_Waterfront'] != '') {?>
								<tr>
									<td nowrap>Waterfront</td>
									<td><?php echo $_smarty_tpl->tpl_vars['Record']->value['Is_Waterfront'];?>
</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-4 mt-md-0" id="overview-hash">
						<h4 class="text-left mb-3 txt-heading heading_txt_color"><?php echo $_smarty_tpl->tpl_vars['Record']->value['address_short'];?>
</h4>
						<h6 class=" text-left mb-4 txt-heading txt-color">
							<?php if (!in_array($_smarty_tpl->tpl_vars['Record']->value['PropertyType'],$_smarty_tpl->tpl_vars['arrPType']->value) && !in_array($_smarty_tpl->tpl_vars['Record']->value['SubType'],$_smarty_tpl->tpl_vars['arrSType']->value)) {?>
								<?php if ($_smarty_tpl->tpl_vars['Record']->value['Beds'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 <?php } else { ?> 0<?php }?> Beds, <?php if ($_smarty_tpl->tpl_vars['Record']->value['BathsFull'] > 0) {?> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
 <?php } else { ?> 0 <?php }?> Baths, <?php if ($_smarty_tpl->tpl_vars['Record']->value['BathsHalf'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
 <?php } else { ?> 0 <?php }?> Half Baths,
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?> 0 <?php }?>Sq Ft</h6>
						<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Description'])) && $_smarty_tpl->tpl_vars['Record']->value['Description'] != '') {?>
							<p class="te-font-size-14 txt-color">
								<?php echo $_smarty_tpl->tpl_vars['Record']->value['Description'];?>

															</p>
						<?php }?>
					</div>
				</div>
				<div class="card mb-5 mt-3 bg-white text-left te-card border-0" id="location-hash">
					<div class="card-header te-card-header pl-0 border-0 py-2 bg-transparent">
						<div class="col-xl-12 col-lg-12 col-md-12 px-0">
							<h4 class="title-font text-left te-line-height-normal mb-3 txt-heading heading_txt_color">Location</h4>
						</div>
					</div>
					<div class="card-body p-0">
												<iframe width="100%" height="400" id="gmap_canvas" src="https://maps.google.com/maps?key=<?php echo $_smarty_tpl->tpl_vars['google_api_key']->value;?>
&q=<?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'] != '') {
echo $_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'];
}?> <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];?>
,<?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
,<?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
,<?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
&output=embed" frameborder="0" scrolling="no"></iframe>
						<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Office_Name'])) && $_smarty_tpl->tpl_vars['Record']->value['Office_Name'] != '') {?>
							<p class="mt-2 mb-0 txt-color">Listing Courtesy of <?php echo $_smarty_tpl->tpl_vars['Record']->value['Office_Name'];?>
</p>
						<?php }?>
					</div>
				</div>
								<div>
					<div class="card bg-white text-left te-card rounded-0 border-0" id="property-information-hash">
						<h4 class="mb-4 te-pd-all-features-main-title txt-heading heading_txt_color">Property Information for <?php echo $_smarty_tpl->tpl_vars['Record']->value['address_short'];?>
</h4>
						<div class="card-header te-card-header te-bg-light px-2 border-0 py-3">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<h6 class="te-pd-title-font text-left te-line-height-normal pb-0 mb-0 txt-heading heading_txt_color">General Information</h6>
							</div>
						</div>
						<div class="card-body border te-gutter-colum px-4 py-3">
							<div>
								<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
									<div class="NoBreakSection">
										<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">General Information</h6>
																				<li class="d-flex txt-color">For Lease: <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['LeaseTerm'])) && $_smarty_tpl->tpl_vars['Record']->value['LeaseTerm'] != '' && $_smarty_tpl->tpl_vars['Record']->value['LeaseTerm'] != NULL) {?>Yes<?php } else { ?>No<?php }?></li>
										<li class="d-flex txt-color">Pet Restrictions : <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['PetsAllowed'])) && $_smarty_tpl->tpl_vars['Record']->value['PetsAllowed'] == 'No') {?>No<?php } else { ?>Yes<?php }?></li>
									</div>
																											<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['County'])) && $_smarty_tpl->tpl_vars['Record']->value['County'] != '') {?>
										<li class="d-flex txt-color">County Or Parish : <?php echo $_smarty_tpl->tpl_vars['Record']->value['County'];?>
</li>
									<?php }?>
									<!--<li class="d-flex">Municipal Code : 31</li>-->
									<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Township'])) && $_smarty_tpl->tpl_vars['Record']->value['Township'] != '') {?>
										<li class="d-flex txt-color">Township Range : <?php echo $_smarty_tpl->tpl_vars['Record']->value['Township'];?>
</li>
									<?php }?>
									<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['ZipCode'])) && $_smarty_tpl->tpl_vars['Record']->value['ZipCode'] != '') {?>
										<li class="d-flex txt-color">Zip Code : <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</li>
									<?php }?>
																		<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['DevelopmentName'])) && $_smarty_tpl->tpl_vars['Record']->value['DevelopmentName'] != '') {?>
										<li class="d-flex txt-color">Development Name : <?php echo $_smarty_tpl->tpl_vars['Record']->value['DevelopmentName'];?>
</li>
									<?php }?>
									<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['CityName'])) && $_smarty_tpl->tpl_vars['Record']->value['CityName'] != '') {?>
										<li class="d-flex txt-color">City : <?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
</li>
									<?php }?>

									<li class="d-flex txt-color">List Price : <?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</li>
									<li class="d-flex txt-color">List Price : <?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);
} else {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);
}?></li>

								</ul>
							</div>
							<div>
								<?php ob_start();
echo Constants::MLS_ACTRIS;
$_prefixVariable10 = ob_get_clean();
ob_start();
echo Constants::MLS_ACTRIS;
$_prefixVariable11 = ob_get_clean();
if (((isset($_smarty_tpl->tpl_vars['Record']->value['MaintenanceExpense'])) && $_smarty_tpl->tpl_vars['Record']->value['MaintenanceExpense'] != '') || ((isset($_smarty_tpl->tpl_vars['Record']->value['Tax'])) && $_smarty_tpl->tpl_vars['Record']->value['Tax'] != '') || ((isset($_smarty_tpl->tpl_vars['Record']->value['TaxYear'])) && $_smarty_tpl->tpl_vars['Record']->value['TaxYear'] != '') || ((isset($_smarty_tpl->tpl_vars['Record']->value['MembershipRequiredYN'])) && $_smarty_tpl->tpl_vars['Record']->value['MembershipRequiredYN'] != '' && $_smarty_tpl->tpl_vars['Record']->value['SystemName'] != $_prefixVariable10) || ((isset($_smarty_tpl->tpl_vars['Record']->value['MembershipFee'])) && $_smarty_tpl->tpl_vars['Record']->value['MembershipFee'] != '' && $_smarty_tpl->tpl_vars['Record']->value['SystemName'] != $_prefixVariable11)) {?>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Maintenance / Tax Information</h6>
											<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['MaintenanceExpense'])) && $_smarty_tpl->tpl_vars['Record']->value['MaintenanceExpense'] != '') {?>
												<li class="d-flex txt-color">Maintenance Charge Month : <?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo $_smarty_tpl->tpl_vars['Record']->value['MaintenanceExpense'];?>
</li>
											<?php }?>
											<!--<li class="d-flex">Maintenance Fee Paid Per : Monthly</li>
                                            <li class="d-flex">Maintenance Includes : Common Area </li>-->
											<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Tax'])) && $_smarty_tpl->tpl_vars['Record']->value['Tax'] != '') {?>
												<li class="d-flex txt-color">Tax Amount : <?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo $_smarty_tpl->tpl_vars['Record']->value['Tax'];?>
</li>
											<?php }?>
										</div>

										<!--<li class="d-flex">Tax Information : Tax Reflects No</li>-->
										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['TaxYear'])) && $_smarty_tpl->tpl_vars['Record']->value['TaxYear'] != '') {?>
											<li class="d-flex txt-color">Tax Year : <?php echo $_smarty_tpl->tpl_vars['Record']->value['TaxYear'];?>
</li>
										<?php }?>

										<?php ob_start();
echo Constants::MLS_ACTRIS;
$_prefixVariable12 = ob_get_clean();
if ((isset($_smarty_tpl->tpl_vars['Record']->value['MembershipRequiredYN'])) && $_smarty_tpl->tpl_vars['Record']->value['MembershipRequiredYN'] != '' && $_smarty_tpl->tpl_vars['Record']->value['SystemName'] != $_prefixVariable12) {?>
											<li class="d-flex txt-color">Membership Required : <?php echo $_smarty_tpl->tpl_vars['Record']->value['MembershipRequiredYN'];?>
</li>
										<?php }?>
										<?php ob_start();
echo Constants::MLS_ACTRIS;
$_prefixVariable13 = ob_get_clean();
if ((isset($_smarty_tpl->tpl_vars['Record']->value['MembershipFee'])) && $_smarty_tpl->tpl_vars['Record']->value['MembershipFee'] != '' && $_smarty_tpl->tpl_vars['Record']->value['MembershipFee'] > 0 && $_smarty_tpl->tpl_vars['Record']->value['SystemName'] != $_prefixVariable13) {?>
											<li class="d-flex txt-color">Membership Fee : <?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['MembershipFee']);?>
</li>
										<?php }?>
									</ul>
								<?php }?>
							</div>
							<div>
								<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
									<div class="NoBreakSection">
										<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Building Information</h6>
																				<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['PropertyType'])) && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != '') {?>
											<li class="d-flex txt-color">Property Type : <?php echo $_smarty_tpl->tpl_vars['Record']->value['PropertyType'];?>
</li>
										<?php }?>
									</div>

									<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Subdivision'])) && $_smarty_tpl->tpl_vars['Record']->value['Subdivision'] != '') {?>
										<li class="d-flex txt-color">Subdivision : <?php echo $_smarty_tpl->tpl_vars['Record']->value['Subdivision'];?>
</li>
									<?php }?>
								</ul>
							</div>

							<?php if (((isset($_smarty_tpl->tpl_vars['Record']->value['Elementary_School'])) && $_smarty_tpl->tpl_vars['Record']->value['Elementary_School'] != '') || ((isset($_smarty_tpl->tpl_vars['Record']->value['Middle_School'])) && $_smarty_tpl->tpl_vars['Record']->value['Middle_School'] != '') || ((isset($_smarty_tpl->tpl_vars['Record']->value['High_School'])) && $_smarty_tpl->tpl_vars['Record']->value['High_School'] != '')) {?>
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">School Information</h6>
											<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Elementary_School'])) && $_smarty_tpl->tpl_vars['Record']->value['Elementary_School'] != '') {?>
												<li class="d-flex txt-color">Elementary School : <?php echo $_smarty_tpl->tpl_vars['Record']->value['Elementary_School'];?>
 </li>
											<?php }?>
										</div>
										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Middle_School'])) && $_smarty_tpl->tpl_vars['Record']->value['Middle_School'] != '') {?>
											<li class="d-flex txt-color">Middle School : <?php echo $_smarty_tpl->tpl_vars['Record']->value['Middle_School'];?>
 </li>
										<?php }?>
										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['High_School'])) && $_smarty_tpl->tpl_vars['Record']->value['High_School'] != '') {?>
											<li class="d-flex txt-color">Senior High School : <?php echo $_smarty_tpl->tpl_vars['Record']->value['High_School'];?>
 </li>
										<?php }?>
									</ul>
								</div>
							<?php }?>
						</div>
					</div>

					<div class="card bg-white text-left te-card border-0 rounded-0">
						<div class="card-header te-card-header te-bg-light px-2 border-0 py-3">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<h6 class="te-pd-title-font text-left te-line-height-normal pb-0 mb-0 txt-heading heading_txt_color">Virtual Tour / Features / Utilities</h6>
							</div>
						</div>
						<div class="card-body border te-gutter-colum py-3 px-4">
							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['VirtualTourUrl'])) && $_smarty_tpl->tpl_vars['Record']->value['VirtualTourUrl'] != '') {?>
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Virtual Tour</h6>
										<li class="d-block txt-color">Virtual Tour :<br> <div class="pl-4"><a class="virtualTour-link link-color" href="<?php echo $_smarty_tpl->tpl_vars['Record']->value['VirtualTourUrl'];?>
"><?php echo $_smarty_tpl->tpl_vars['Record']->value['VirtualTourUrl'];?>
</a></div></li>
																			</ul>
								</div>
							<?php }?>
							<div>
								<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
									<div class="NoBreakSection">
										<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Interior</h6>

										<li class="d-flex txt-color">Room Count : <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['TotalRooms'])) && $_smarty_tpl->tpl_vars['Record']->value['TotalRooms'] != '') {
echo $_smarty_tpl->tpl_vars['Record']->value['TotalRooms'];
} else { ?>0<?php }?></li>
										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Appliances'])) && $_smarty_tpl->tpl_vars['Record']->value['Appliances'] != '') {?>
											<li class="d-flex txt-color">Equipment Appliances : <?php echo str_replace(',',', ',preg_replace('/(?<!\ )[A-Z]/',' $0',$_smarty_tpl->tpl_vars['Record']->value['Appliances']));?>
</li>
										<?php }?>
																			</div>
									<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Flooring'])) && $_smarty_tpl->tpl_vars['Record']->value['Flooring'] != '') {?>
										<li class="d-flex txt-color">Floor Description : <?php echo $_smarty_tpl->tpl_vars['Record']->value['Flooring'];?>
</li>
									<?php }?>
									<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['InteriorFeatures'])) && $_smarty_tpl->tpl_vars['Record']->value['InteriorFeatures'] != '') {?>
										<li class="d-flex txt-color">Interior Features : <?php echo str_replace(',',', ',preg_replace('/(?<!\ )[A-Z]/',' $0',$_smarty_tpl->tpl_vars['Record']->value['InteriorFeatures']));?>
</li>
									<?php }?>
									<?php if (!in_array($_smarty_tpl->tpl_vars['Record']->value['PropertyType'],$_smarty_tpl->tpl_vars['arrPType']->value) && !in_array($_smarty_tpl->tpl_vars['Record']->value['SubType'],$_smarty_tpl->tpl_vars['arrSType']->value)) {?>
										<li class="d-flex txt-color">Beds Total : <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Beds'])) && $_smarty_tpl->tpl_vars['Record']->value['Beds'] > 0) {?> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 <?php } else { ?> 0 <?php }?></li>
																				<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['BathsFull'])) && $_smarty_tpl->tpl_vars['Record']->value['BathsFull'] != '') {?>
											<li class="d-flex txt-color">Num of Full Baths : <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
</li>
										<?php }?>
										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['BathsHalf'])) && $_smarty_tpl->tpl_vars['Record']->value['BathsHalf'] != '') {?>
											<li class="d-flex txt-color">Num of Half Baths : <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf'],1);?>
</li>
										<?php }?>
									<?php }?>
									<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Furnished'])) && $_smarty_tpl->tpl_vars['Record']->value['Furnished'] != '') {?>
										<li class="d-flex txt-color">Furnished : <?php echo $_smarty_tpl->tpl_vars['Record']->value['Furnished'];?>
</li>
									<?php }?>
																		<li class="d-flex txt-color">Spa : <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['SpaYN'])) && $_smarty_tpl->tpl_vars['Record']->value['SpaYN'] != '') {
echo $_smarty_tpl->tpl_vars['Record']->value['SpaYN'];
} else { ?>No<?php }?></li>
								</ul>
							</div>
							<div>
								<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
									<div class="NoBreakSection">
										<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Exterior</h6>
										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['ExteriorFeatures'])) && $_smarty_tpl->tpl_vars['Record']->value['ExteriorFeatures'] != '') {?>
											<li class="d-flex txt-color">Exterior Features : <?php echo str_replace(',',', ',preg_replace('/(?<!\ )[A-Z]/',' $0',$_smarty_tpl->tpl_vars['Record']->value['ExteriorFeatures']));?>
</li>
										<?php }?>
									</div>
																		<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Construction'])) && $_smarty_tpl->tpl_vars['Record']->value['Construction'] != '') {?>
										<li class="d-flex txt-color">Construction Type : <?php echo $_smarty_tpl->tpl_vars['Record']->value['Construction'];?>
</li>
									<?php }?>
									<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['PropertyStyle'])) && $_smarty_tpl->tpl_vars['Record']->value['PropertyStyle'] != '') {?>
										<li class="d-flex txt-color">Design : <?php echo str_replace(',',', ',preg_replace('/(?<!\ )[A-Z]/',' $0',$_smarty_tpl->tpl_vars['Record']->value['PropertyStyle']));?>
</li>
									<?php }?>
																		<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Direction_Faces'])) && $_smarty_tpl->tpl_vars['Record']->value['Direction_Faces'] != '') {?>
										<li class="d-flex txt-color">Front Exposure : <?php echo $_smarty_tpl->tpl_vars['Record']->value['Direction_Faces'];?>
</li>
									<?php }?>
									<li class="d-flex">Pool : <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['PoolDesc'])) && $_smarty_tpl->tpl_vars['Record']->value['PoolDesc'] != '') {
if (strstr($_smarty_tpl->tpl_vars['Record']->value['PoolDesc'],'Pool')) {?>Yes<?php } else { ?>No<?php }
} else { ?>No<?php }?></li>
									<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['PoolDesc'])) && $_smarty_tpl->tpl_vars['Record']->value['PoolDesc'] != '') {?>
										<li class="d-flex txt-color">Pool Description : <?php echo str_replace(',',', ',$_smarty_tpl->tpl_vars['Record']->value['PoolDesc']);?>
</li>
									<?php }?>
																		<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Roof'])) && $_smarty_tpl->tpl_vars['Record']->value['Roof'] !== '') {?>
										<li class="d-flex txt-color">Roof Description :  <?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['Record']->value['Roof'],',',' Roof, ');?>
</li>
									<?php }?>
									<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Window_Features'])) && $_smarty_tpl->tpl_vars['Record']->value['Window_Features'] != '') {?>
										<li class="d-flex txt-color">Windows Treatment : <?php echo str_replace(',',', ',$_smarty_tpl->tpl_vars['Record']->value['Window_Features']);?>
</li>
									<?php }?>
									<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['HorseYN'])) && $_smarty_tpl->tpl_vars['Record']->value['HorseYN'] != '') {?>
										<li class="d-flex txt-color">Horse Amenities : <?php echo str_replace(',',', ',$_smarty_tpl->tpl_vars['Record']->value['HorseYN']);?>
</li>
									<?php }?>
									<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['SecuritySafety'])) && $_smarty_tpl->tpl_vars['Record']->value['SecuritySafety'] != '') {?>
										<li class="d-flex txt-color">Security : <?php echo str_replace(',',', ',$_smarty_tpl->tpl_vars['Record']->value['SecuritySafety']);?>
</li>
									<?php }?>
								</ul>
							</div>

							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Dining'])) && $_smarty_tpl->tpl_vars['Record']->value['Dining'] != '') {?>
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Room Information</h6>
											<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Dining'])) && $_smarty_tpl->tpl_vars['Record']->value['Dining'] != '') {?>
												<li class="d-flex txt-color">Dining Description : <?php echo $_smarty_tpl->tpl_vars['Record']->value['Dining'];?>
</li>
											<?php }?>
																						
										</div>
										
									</ul>
								</div>
							<?php }?>
							<?php if ((isset($_smarty_tpl->tpl_vars['Recoed']->value['Water'])) && $_smarty_tpl->tpl_vars['Recoed']->value['Water'] != '' || ((isset($_smarty_tpl->tpl_vars['Record']->value['Frontage_Length'])) && $_smarty_tpl->tpl_vars['Record']->value['Frontage_Length'] != '')) {?>
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Waterfront</h6>
																					</div>
										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Frontage_Length'])) && $_smarty_tpl->tpl_vars['Record']->value['Frontage_Length'] != '') {?>
											<li class="d-flex txt-color">Waterfront Frontage : <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Frontage_Length']);?>
</li>
										<?php }?>
										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['WaterfrontDesc'])) && $_smarty_tpl->tpl_vars['Record']->value['WaterfrontDesc'] != '') {?>
											<li class="d-flex txt-color">Waterfront Description : <?php echo $_smarty_tpl->tpl_vars['Record']->value['WaterfrontDesc'];?>
</li>
										<?php }?>
																			</ul>
								</div>

							<?php }?>
							<?php if (((isset($_smarty_tpl->tpl_vars['Record']->value['GarageDescription'])) && $_smarty_tpl->tpl_vars['Record']->value['GarageDescription'] != '') || ((isset($_smarty_tpl->tpl_vars['Record']->value['ParkingFeatures'])) && $_smarty_tpl->tpl_vars['Record']->value['ParkingFeatures'] != '')) {?>
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Parking</h6>
											<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['GarageDescription'])) && $_smarty_tpl->tpl_vars['Record']->value['GarageDescription'] != '') {?>
												<li class="d-flex txt-color">Garage Description : <?php echo str_replace(',',', ',$_smarty_tpl->tpl_vars['Record']->value['GarageDescription']);?>
</li>
											<?php }?>
										</div>

										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['ParkingFeatures'])) && $_smarty_tpl->tpl_vars['Record']->value['ParkingFeatures'] != '') {?>
											<li class="d-flex txt-color">Parking Description : <?php echo str_replace(',',', ',$_smarty_tpl->tpl_vars['Record']->value['ParkingFeatures']);?>
</li>
										<?php }?>

									</ul>
								</div>
							<?php }?>
							<?php if (((isset($_smarty_tpl->tpl_vars['Record']->value['Cooling'])) && $_smarty_tpl->tpl_vars['Record']->value['Cooling'] != '') || ((isset($_smarty_tpl->tpl_vars['Record']->value['Heating'])) && $_smarty_tpl->tpl_vars['Record']->value['Heating'] != '')) {?>
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Utilities</h6>
											<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Cooling'])) && $_smarty_tpl->tpl_vars['Record']->value['Cooling'] != '') {?>
												<li class="d-flex txt-color">Cooling Description : <?php echo str_replace(',',', ',$_smarty_tpl->tpl_vars['Record']->value['Cooling']);?>
</li>
											<?php }?>
										</div>
										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Heating'])) && $_smarty_tpl->tpl_vars['Record']->value['Heating'] != '') {?>
											<li class="d-flex txt-color">Heating Description : <?php echo str_replace(',',', ',$_smarty_tpl->tpl_vars['Record']->value['Heating']);?>
</li>
										<?php }?>
										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Sewer'])) && $_smarty_tpl->tpl_vars['Record']->value['Sewer'] != '') {?>
											<li class="d-flex txt-color">Sewer Description : <?php echo $_smarty_tpl->tpl_vars['Record']->value['Sewer'];?>
</li>
										<?php }?>
																			</ul>
								</div>
							<?php }?>
						</div>
					</div>

					<div class="card bg-white text-left te-card border-0 rounded-0">
						<div class="card-header te-card-header te-bg-light px-2 border-0 py-3">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<h6 class="te-pd-title-font text-left te-line-height-normal pb-0 mb-0 txt-heading heading_txt_color">Property / Lot Information</h6>
							</div>
						</div>
						<div class="card-body border te-gutter-colum py-3 px-4">

							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['HOAFee'])) && $_smarty_tpl->tpl_vars['Record']->value['HOAFee'] != '' || ((isset($_smarty_tpl->tpl_vars['Record']->value['HOAFrequency'])) && $_smarty_tpl->tpl_vars['Record']->value['HOAFrequency'] != '')) {?>
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Community Information</h6>
																						<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['HOAFee'])) && $_smarty_tpl->tpl_vars['Record']->value['HOAFee'] != '') {?>
												<li class="d-flex txt-color">Association Fee: <?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['HOAFee']);?>
</li>
											<?php }?>
											<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['HOAFrequency'])) && $_smarty_tpl->tpl_vars['Record']->value['HOAFrequency'] != '') {?>
												<li class="d-flex txt-color">Assoc Fee Paid Per: <?php echo $_smarty_tpl->tpl_vars['Record']->value['HOAFrequency'];?>
</li>
											<?php }?>
										</div>
										
									</ul>
								</div>
							<?php }?>
							<div>
								<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
									<div class="NoBreakSection">
										<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Building Information</h6>
										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['ParcelNumber'])) && $_smarty_tpl->tpl_vars['Record']->value['ParcelNumber'] != '') {?>
											<li class="d-flex txt-color">Parcel Number Free Text: <?php echo $_smarty_tpl->tpl_vars['Record']->value['ParcelNumber'];?>
</li>
										<?php }?>
										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Zoning_Description'])) && $_smarty_tpl->tpl_vars['Record']->value['Zoning_Description'] != '') {?>
											<li class="d-flex txt-color">Zoning Information: <?php echo $_smarty_tpl->tpl_vars['Record']->value['Zoning_Description'];?>
</li>
										<?php }?>
										<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Garage'])) && $_smarty_tpl->tpl_vars['Record']->value['Garage'] != '') {?>
											<li class="d-flex txt-color">Num Garage Spaces: <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Garage']);?>
</li>
										<?php }?>
									</div>
																	</ul>
							</div>

							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['LotDescription'])) && $_smarty_tpl->tpl_vars['Record']->value['LotDescription'] != '' || ((isset($_smarty_tpl->tpl_vars['Record']->value['LotSize_Area'])) && $_smarty_tpl->tpl_vars['Record']->value['LotSize_Area'] != '')) {?>
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Lot Information</h6>
																																	<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['LotSize_Area'])) && $_smarty_tpl->tpl_vars['Record']->value['LotSize_Area'] != '') {?>
												<li class="d-flex txt-color">Lot Sq Footage : <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['LotSize_Area']);?>
</li>
											<?php }?>
										</div>
										
									</ul>
								</div>
							<?php }?>

						</div>
					</div>

				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 aside">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 Featured-listings d-none d-md-block">
						<h4 class="pb-2 pl-2 txt-heading heading_txt_color">Property Details</h4>
						<table class="table te-font-size-14 te-table-property-detail table-borderless table-hover">
							<tbody>
							<tr>
								<td nowrap>Price</td>
								<td><?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] == 'Closed') {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);
} else {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);
}?></td>
							</tr>
							<?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0 && $_smarty_tpl->tpl_vars['Record']->value['ListPrice'] > 0) {?>
								<tr>
									<td nowrap>Price Per Sq Ft</td>
									<?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable14 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable14);?>
									<td><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);?>
</td>
								</tr>
							<?php }?>
							<tr>
								<td nowrap>MLS#</td>
								<td><?php echo $_smarty_tpl->tpl_vars['Record']->value['MLS_NUM'];?>
</td>
							</tr>
							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['YearBuilt'])) && $_smarty_tpl->tpl_vars['Record']->value['YearBuilt'] != '') {?>
								<tr>
									<td nowrap>Year Built</td>
									<td><?php echo $_smarty_tpl->tpl_vars['Record']->value['YearBuilt'];?>
</td>
								</tr>
							<?php }?>
							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['ListingStatus'])) && $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] != '') {?>
								<tr>
									<td nowrap>Status</td>
									<td><?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'];?>
</td>
								</tr>
							<?php }?>
							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['PropertyType'])) && $_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != '') {?>
								<tr>
									<td nowrap>Type</td>
									<td><?php echo $_smarty_tpl->tpl_vars['Record']->value['PropertyType'];?>
</td>
								</tr>
							<?php }?>
							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Tax'])) && $_smarty_tpl->tpl_vars['Record']->value['Tax'] != '') {?>
								<tr>
									<td nowrap>Taxes</td>
									<td><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Tax']);?>
 / year</td>
								</tr>
							<?php }?>
							<?php if (((isset($_smarty_tpl->tpl_vars['Record']->value['HOAFee'])) && $_smarty_tpl->tpl_vars['Record']->value['HOAFee'] != '') || ((isset($_smarty_tpl->tpl_vars['Record']->value['HOAFrequency'])) && $_smarty_tpl->tpl_vars['Record']->value['HOAFrequency'] != '')) {?>
								<tr>
									<td nowrap>HOA Fees</td>
									<td><?php if ($_smarty_tpl->tpl_vars['Record']->value['HOAFee'] != '') {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['HOAFee']);
}?> <?php if ($_smarty_tpl->tpl_vars['Record']->value['HOAFrequency'] != '') {?>/ <?php echo $_smarty_tpl->tpl_vars['Record']->value['HOAFrequency'];
}?></td>
								</tr>
							<?php }?>
							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Subdivision'])) && $_smarty_tpl->tpl_vars['Record']->value['Subdivision'] != '') {?>
								<tr>
									<td nowrap>Subdivision</td>
									<td><?php echo $_smarty_tpl->tpl_vars['Record']->value['Subdivision'];?>
</td>
								</tr>
							<?php }?>
							<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Is_Waterfront'])) && $_smarty_tpl->tpl_vars['Record']->value['Is_Waterfront'] != '') {?>
								<tr>
									<td nowrap>Waterfront</td>
									<td><?php echo $_smarty_tpl->tpl_vars['Record']->value['Is_Waterfront'];?>
</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="card w-100 rounded-0 mt-4 mt-md-0 mt-lg-4 border te-mortgage-calculator">
							<div class="card-header te-bg-light border-0 px-4 py-3">
								<div class="col-xl-12 col-lg-12 col-md-12 sec-title px-0">
									<h5 class="title-font text-left te-line-height-normal pb-0 mb-0 txt-heading heading_txt_color">Contact Us</h5>
								</div>
							</div>
							<?php $_smarty_tpl->_subTemplateRender("file:listing/schedule_showing.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
						</div>
					</div>
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] != "ResidentialLease") {?>
							<?php $_smarty_tpl->_subTemplateRender("file:listing/mortgagae_calculator.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
						<?php }?>
					</div>
				</div>

			</div>
		</div>
		<div class="row">
			<?php if (is_array($_smarty_tpl->tpl_vars['arrSimilar']->value) && count($_smarty_tpl->tpl_vars['arrSimilar']->value) > 0) {?>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-0">
					<div class="card mb-4 text-left te-card mt-4 border-0" id="te-similar-listings-hash">
						<div class="card-header pl-0 border-0 bg-transparent">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<h4 class="title-font text-left te-line-height-normal mb-0 txt-heading heading_txt_color">Similar Properties</h4>
							</div>
						</div>
						<div class="card-body px-4 py-2 te-featured-properties mw-100 overflow-hidden h-auto">
							<div class="row">
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrSimilar']->value, 'SRecord', false, NULL, 'SearchResult', array (
));
$_smarty_tpl->tpl_vars['SRecord']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['SRecord']->value) {
$_smarty_tpl->tpl_vars['SRecord']->do_else = false;
?>
									<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2">
										<a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['SRecord']->value);?>
" class="te-property-card d-block position-relative overflow-hidden">
											<?php if ($_smarty_tpl->tpl_vars['SRecord']->value['mls_is_pic_url_supported'] == 'Yes') {?>
												<?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['SRecord']->value['MainPicture']['large']['url']);?>
												<?php if ($_smarty_tpl->tpl_vars['SRecord']->value['MainPicture']['large']['url'] != '') {?>
													<?php $_smarty_tpl->_assignInScope('photo_url', $_smarty_tpl->tpl_vars['SRecord']->value['MainPicture']['large']['url']);?>
												<?php } else { ?>
													<?php ob_start();
echo ($_smarty_tpl->tpl_vars['PhotoBaseUrl']->value).('no-photo/0/');
$_prefixVariable15 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable15);?>
												<?php }?>
											<?php } else { ?>
																								<?php ob_start();
echo $_smarty_tpl->tpl_vars['SRecord']->value['MainPicture'];
$_prefixVariable16 = ob_get_clean();
$_smarty_tpl->_assignInScope('photo_url', $_prefixVariable16);?>

											<?php }?>

											<img class="te-property-fig te-property-image position-absolute" src="<?php echo $_smarty_tpl->tpl_vars['photo_url']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['SRecord']->value['Address'];?>
-1">
											<div class="-te-property-gradient position-absolute"></div>
											<div class="te-gradient te-property-details te-animate text-white position-absolute te-z-index-99 te-p-5 pt-5">
												<div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
													<div class="te-property-details-price"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
if ($_smarty_tpl->tpl_vars['SRecord']->value['ListingStatus'] == 'Closed') {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['SRecord']->value['Sold_Price']);
} else {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['SRecord']->value['ListPrice']);
}?></div>
													<div class="te-property-details-features te-font-size-14">
														<?php if (!in_array($_smarty_tpl->tpl_vars['SRecord']->value['PropertyType'],$_smarty_tpl->tpl_vars['arrPType']->value) && !in_array($_smarty_tpl->tpl_vars['SRecord']->value['SubType'],$_smarty_tpl->tpl_vars['arrSType']->value)) {?>
															<?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['SRecord']->value['Beds']);?>
 Beds <span>|</span> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['SRecord']->value['BathsFull']);?>
 Baths <span>|</span>
														<?php }?>
														<?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['SRecord']->value['SQFT']);?>
 Sq Ft
													</div>
													<div class="te-property-title text-truncate te-font-size-14"><?php echo $_smarty_tpl->tpl_vars['SRecord']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['SRecord']->value['StreetName'];?>
, <?php echo $_smarty_tpl->tpl_vars['SRecord']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['SRecord']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['SRecord']->value['ZipCode'];?>
</div>
												</div>
																								<div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
											</div>
										</a>
										<div class="top-left">
											<?php if ((isset($_smarty_tpl->tpl_vars['SRecord']->value['ListingStatus'])) && $_smarty_tpl->tpl_vars['SRecord']->value['ListingStatus'] == 'ActiveUnderContract') {?>
												<span class="wedges list-detail-wedge">Under Contract</span>
											<?php } elseif ((isset($_smarty_tpl->tpl_vars['SRecord']->value['ListingStatus'])) && $_smarty_tpl->tpl_vars['SRecord']->value['ListingStatus'] == 'Pending') {?>
												<span class="wedges list-detail-wedge">Pending</span>
											<?php }?>
											<?php if ((isset($_smarty_tpl->tpl_vars['SRecord']->value['DOM'])) && $_smarty_tpl->tpl_vars['SRecord']->value['DOM'] < 7) {?>
												<span class="wedges-newListing list-detail-wedge">New Listing</span>
											<?php }?>
										</div>
										<?php if ($_smarty_tpl->tpl_vars['arrConfig']->value['OtherConfig']['login_enable'] == 'Yes') {?>
											<div class="position-absolute te-property-favourite te-z-index-99" id="fav-link-container-<?php echo $_smarty_tpl->tpl_vars['SRecord']->value['ListingID_MLS'];?>
">

												<?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>
													<?php if ((isset($_smarty_tpl->tpl_vars['userFavList']->value)) && in_array($_smarty_tpl->tpl_vars['SRecord']->value['ListingID_MLS'],$_smarty_tpl->tpl_vars['userFavList']->value)) {?>
														<a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['SRecord']->value['ListingID_MLS'];?>
', 'Remove','Similar','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart fav-icon"></i></a>
													<?php } else { ?>
														<a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('<?php echo $_smarty_tpl->tpl_vars['SRecord']->value['ListingID_MLS'];?>
', 'Add','Similar','<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart fav-icon"></i></a>
													<?php }?>
												<?php } else { ?>
													<a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login&ReqType=AddFav&mlsNum=<?php echo $_smarty_tpl->tpl_vars['SRecord']->value['ListingID_MLS'];?>
" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart fav-icon"></i></a>
												<?php }?>
											</div>
										<?php }?>
									</div>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" id="ftype" class="ftype" value="similar">
			<?php }?>

			<?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] == 'Residential' && $_smarty_tpl->tpl_vars['Record']->value['ListingStatus'] != 'Closed') {?>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4 px-3">
					<?php if ($_smarty_tpl->tpl_vars['Record']->value['SubType'] != '' && $_smarty_tpl->tpl_vars['Record']->value['SubType'] != 'Other') {?>
						<?php ob_start();
echo preg_replace('/(?<!\ )[A-Z]/',' $0',$_smarty_tpl->tpl_vars['Record']->value['SubType']);
$_prefixVariable17 = ob_get_clean();
$_smarty_tpl->_assignInScope('subtype', $_prefixVariable17);?>
					<?php } else { ?>
						<?php $_smarty_tpl->_assignInScope('subtype', '');?>
					<?php }?>
					<h4 class="mb-4 te-pd-footer-disclaimer-title txt-heading heading_txt_color">More information about <?php echo $_smarty_tpl->tpl_vars['Record']->value['address_short'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
</h4>
					<p class="text-dark mb-3 txt-color seo-text"><?php echo $_smarty_tpl->tpl_vars['Record']->value['address_short'];?>
 is a <?php if ($_smarty_tpl->tpl_vars['Record']->value['Is_Waterfront'] == 'Yes') {?>waterfront<?php }?> <?php if (array_key_exists($_smarty_tpl->tpl_vars['Record']->value['SubType'],$_smarty_tpl->tpl_vars['SEOSubtype']->value)) {
echo $_smarty_tpl->tpl_vars['SEOSubtype']->value[$_smarty_tpl->tpl_vars['Record']->value['SubType']];
} else {
echo $_smarty_tpl->tpl_vars['subtype']->value;
}?> for <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] == 'ResidentialLease') {?>rent<?php } else { ?>sale<?php }?> in <?php echo $_smarty_tpl->tpl_vars['Record']->value['CityName'];?>
, <?php echo $_smarty_tpl->tpl_vars['Record']->value['State'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['ZipCode'];?>
. This property was listed for <?php if ($_smarty_tpl->tpl_vars['Record']->value['PropertyType'] == 'ResidentialLease') {?>rent<?php } else { ?>sale<?php }?> <?php if ($_smarty_tpl->tpl_vars['Record']->value['ListingDate'] != '') {?>on <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['Record']->value['ListingDate'],"M d, Y");
}?> <?php if ($_smarty_tpl->tpl_vars['Record']->value['Office_Name'] != '') {?>by <?php echo $_smarty_tpl->tpl_vars['Record']->value['Office_Name'];
}?> for <?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
. Located in <?php if ($_smarty_tpl->tpl_vars['Record']->value['Subdivision'] != '') {
echo $_smarty_tpl->tpl_vars['Record']->value['Subdivision'];?>
,<?php }?> <?php echo $_smarty_tpl->tpl_vars['Record']->value['address_short'];?>
 is a <?php if (!in_array($_smarty_tpl->tpl_vars['SRecord']->value['PropertyType'],$_smarty_tpl->tpl_vars['arrPType']->value) && !in_array($_smarty_tpl->tpl_vars['SRecord']->value['SubType'],$_smarty_tpl->tpl_vars['arrSType']->value)) {
if ($_smarty_tpl->tpl_vars['Record']->value['Beds'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);
} else { ?>0<?php }?>-bed, <?php if ($_smarty_tpl->tpl_vars['Record']->value['BathsFull'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);
} else { ?>0<?php }?>-bath,<?php }?> <?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);
} else { ?>0<?php }?> sqft <?php if (array_key_exists($_smarty_tpl->tpl_vars['Record']->value['SubType'],$_smarty_tpl->tpl_vars['SEOSubtype']->value)) {
echo $_smarty_tpl->tpl_vars['SEOSubtype']->value[$_smarty_tpl->tpl_vars['Record']->value['SubType']];
} else {
echo $_smarty_tpl->tpl_vars['subtype']->value;
}?> <?php if ($_smarty_tpl->tpl_vars['Record']->value['YearBuilt'] != '') {?> built in <?php echo $_smarty_tpl->tpl_vars['Record']->value['YearBuilt'];
}?>.</p>

				</div>

			<?php }?>
																		<div class="py-xl-3">
				<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['SystemName'])) && $_smarty_tpl->tpl_vars['Record']->value['SystemName'] == 'SEFMIAMI') {?>
					<p class="px-3 text-micro txt-color" align="justify">No guarantee, warranty or representation of any kind is made regarding the completeness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Opportunity Act.</p>
					<p class="px-3 text-micro txt-color" align="justify">The data provided by Miami Association of REALTORS® MLS comes from a copyrighted compilation of listings. The compilation of listings and each individual listing are ©<?php echo date('Y');?>
 Miami Association of REALTORS®. All Rights Reserved. The information provided is for consumers’ personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed reliable but is not guaranteed accurate, and should be independently verified.</p>
					<p class="px-3 text-micro txt-color" align="justify">Miami Association of Realtors MLS data last updated on <?php echo $_smarty_tpl->tpl_vars['MLS_last_update_date']->value;?>
.</p>
				<?php } elseif ((isset($_smarty_tpl->tpl_vars['Record']->value['SystemName'])) && $_smarty_tpl->tpl_vars['Record']->value['SystemName'] == 'FTL') {?>
					<p class="px-3 text-micro txt-color" align="justify">No guarantee, warranty or representation of any kind is made regarding the completeness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Opportunity Act.</p>
					<img class = "disclaimer_img" src="<?php echo $_smarty_tpl->tpl_vars['Templates_Image']->value;?>
/both.png"> <p class="px-3 text-micro txt-color" align="justify">The data provided by Palm Beach Board of Realtors Multiple Listing Service comes from a copyrighted compilation of listings. The compilation of listings and each individual listing are ©<?php echo date('Y');?>
 Palm Beach Board of Realtors Multiple Listing Service. All Rights Reserved. The information provided is for consumers’ personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed reliable but is not guaranteed accurate, and should be independently verified.</p>
					<p class="px-3 text-micro txt-color" align="justify">All listings featuring the BMLS logo are provided by BeachesMLS, Inc. This information is not verified for authenticity or accuracy and is not guaranteed. Copyright ©<?php echo date('Y');?>
 BeachesMLS, Inc.</p>
					<p class="px-3 text-micro txt-color" align="justify">Listing information last updated on <?php echo $_smarty_tpl->tpl_vars['MLS_last_update_date']->value;?>
.</p>
				<?php } else {
ob_start();
echo Constants::MLS_ACTRIS;
$_prefixVariable18 = ob_get_clean();
if ((isset($_smarty_tpl->tpl_vars['Record']->value['SystemName'])) && $_smarty_tpl->tpl_vars['Record']->value['SystemName'] == $_prefixVariable18) {?>
					<p class="px-3 text-micro txt-color" align="justify">The information being provided is for consumers' personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing.</p>
					<p class="px-3 text-micro txt-color" align="justify">Based on information from the Austin Board of REALTORS® (alternatively, from ACTRIS) from <?php echo $_smarty_tpl->tpl_vars['MLS_last_update_date']->value;?>
. Neither the Board nor ACTRIS guarantees or is in any way responsible for its accuracy. The Austin Board of REALTORS®, ACTRIS and their affiliates provide the MLS and all content therein "AS IS" and without any warranty, express or implied. Data maintained by the Board or ACTRIS may not reflect all real estate activity in the market.</p>
					<p class="px-3 text-micro txt-color" align="justify">All information provided is deemed reliable but is not guaranteed and should be independently verified.</p>
				<?php }}?>
			</div>
		</div>
				<input type="hidden" name="OnPage" id="OnPage" value="FullView"/>
			</div>
</section>



<div class="modal fade property-contact-agent-modal" id="modal-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content px-2 rounded-0">

		</div>
	</div>
</div>
<div class="pswp te-z-index-99999" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="pswp__bg"></div>
	<div class="pswp__scroll-wrap">
		<div class="pswp__container">
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
		</div>
		<div class="pswp__ui pswp__ui--hidden">
			<div class="pswp__top-bar">
				<div class="pswp__counter"></div>
				<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
				<button class="pswp__button pswp__button--share" title="Share"></button>
				<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
				<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
				<div class="pswp__preloader">
					<div class="pswp__preloader__icn">
						<div class="pswp__preloader__cut">
							<div class="pswp__preloader__donut"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
				<div class="pswp__share-tooltip"></div>
			</div>
			<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
			<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
			<div class="pswp__caption">
				<div class="pswp__caption__center"></div>
			</div>
		</div>
	</div>
</div><?php }
}
