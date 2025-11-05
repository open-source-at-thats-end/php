<?php
/* Smarty version 4.2.1, created on 2023-08-13 12:39:14
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/mobile-device-search-form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64d915427347d2_45746251',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2dfd621489255b7706cfc971f9889c8e824c6e17' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/mobile-device-search-form.tpl',
      1 => 1646851736,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64d915427347d2_45746251 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/function.html_options.php','function'=>'smarty_function_html_options',),));
?>
<div class="modal fade filter-modal w-100 mbl-searchfrm" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true">
	<div class="modal-dialog modal-dialog-scrollable m-0 mw-100" role="document">
		<div class="modal-content border-0 rounded-0 te-bg-light">

			<div class="modal-header px-3 border-dark">
				<h5 class="modal-title txt-heading heading_txt_color" id="exampleModalScrollableTitle">Filters</h5>
				<button type="button" class="close hide" data-dismiss="modal" aria-label="Close">
					<span class="text-dark" aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body">
				<form class="form" id="mbfrmsearch" role="form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['formAction']->value;?>
">
					<div class="row p-2">
						<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
							<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 pb-3 py-md-0">
								<h5 class="text-capitalize mb-3 font-weight-bold- txt-heading heading_txt_color">Status</h5>
								<div class="w-100">
									<select name="status" class="custom-select rounded-0 border-0 py-0 shadow-none">
										<?php if ($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['status'] && $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['status'] != '') {?>
											<?php ob_start();
echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['status'];
$_prefixVariable1 = ob_get_clean();
$_smarty_tpl->_assignInScope('lsStatus', $_prefixVariable1);?>
										<?php } elseif (!(isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['status']))) {?>
											<?php $_smarty_tpl->_assignInScope('lsStatus', "all");?>
										<?php }?>
										<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrStatus']->value,'selected'=>$_smarty_tpl->tpl_vars['lsStatus']->value),$_smarty_tpl);?>


									</select>
								</div>
							</div>
						<?php }?>
						<div class="col-xl-7 col-lg-7 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?> col-md-12 <?php } else { ?> col-md-7<?php }?> col-sm-12 col-12">
							<h5 class="text-capitalize mb-3 txt-heading heading_txt_color">Price Range </h5>
							<div class="d-flex px-0">
								<div class="w-100">
									<!--<select class="custom-select rounded-0 border-0 shadow-none" name="minprice">
										<option value="" selected="selected">Min</option>
										<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrPriceRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minprice']),$_smarty_tpl);?>

									</select>-->
									<input type="text" name="minprice" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minprice'];?>
" class="form-control rounded-0 py-0 border-0 shadow-none" id="minprice" placeholder="Min Price" aria-describedby="min price">
								</div>
								<div class="mx-3 align-self-center"> - </div>
								<div class="w-100">
									<!--<select class="custom-select rounded-0 border-0 shadow-none" name="maxprice">
										<option value="" selected="selected">Max</option>
										<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrPriceRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxprice']),$_smarty_tpl);?>

									</select>-->
									<input type="text" name="maxprice" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxprice'];?>
" class="form-control border-0 rounded-0 py-0 shadow-none" id="maxprice" placeholder="Max Price" aria-describedby="max price">
								</div>
							</div>
						</div>
					</div>
					<hr class="w-100">
					<div class="row p-2">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<h5 class="txt-heading heading_txt_color">Bathrooms</h5>
						</div>
						<div class="col-xl-12 col-lg-12 py-0 px-3">
							<div class="custom-control custom-radio py-2 te-width-max-content d-inline-block px-4">
								<input type="radio" class="custom-control-input" <?php if ($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minbath'] == '') {?>checked<?php }?> value="" name="minbath" id="ps-small-bath-any">
								<label class="custom-control-label" for="ps-small-bath-any">Any</label>
							</div>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrBathRange']->value, 'bathitem', false, 'bathkey', 'beds', array (
));
$_smarty_tpl->tpl_vars['bathitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['bathkey']->value => $_smarty_tpl->tpl_vars['bathitem']->value) {
$_smarty_tpl->tpl_vars['bathitem']->do_else = false;
?>
								<div class="custom-control custom-radio py-2 te-width-max-content d-inline-block px-4">
									<input type="radio" class="custom-control-input" <?php if ($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minbath'] == $_smarty_tpl->tpl_vars['bathkey']->value) {?>checked<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['bathkey']->value;?>
" name="minbath" id="ps-small-bath-<?php echo $_smarty_tpl->tpl_vars['bathkey']->value;?>
">
									<label class="custom-control-label" for="ps-small-bath-<?php echo $_smarty_tpl->tpl_vars['bathkey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['bathitem']->value;?>
</label>
								</div>
							<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						</div>
					</div>
					<hr class="w-100">
					<div class="row p-2">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<h5 class="txt-heading heading_txt_color">Bedrooms</h5>
						</div>
						<div class="col-xl-12 col-lg-12 py-0 px-3">
							<div class="d-flex px-0">
								<div class="w-100">
									<select class="custom-select rounded-0 border-0 shadow-none py-0" name="minbed">
										<option value="" selected="selected">Min</option>
										<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrBedRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minbed']),$_smarty_tpl);?>

									</select>

								</div>
								<div class="mx-3 align-self-center"> - </div>
								<div class="w-100">
									<select class="custom-select rounded-0 border-0 shadow-none py-0" name="maxbed">
										<option value="" selected="selected">Max</option>
										<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrBedRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxbed']),$_smarty_tpl);?>

									</select>
								</div>
							</div>
						</div>
					</div>
					<hr class="w-100">
					<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
						<div class="row p-2">
							<div class="col-lg-12 col-md-12 col-sm-12 col-12">
								<h5 class="txt-heading heading_txt_color">Type</h5>
							</div>
															<div class="col-lg-12 col-md-12 col-sm-12 col-12">
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrMeta']->value['SubType'], 'sitem', false, 'skey', 'ptype', array (
));
$_smarty_tpl->tpl_vars['sitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['skey']->value => $_smarty_tpl->tpl_vars['sitem']->value) {
$_smarty_tpl->tpl_vars['sitem']->do_else = false;
?>
										<div class="custom-control custom-checkbox py-2 te-width-max-content d-inline-block px-4">
											<input type="checkbox" class="custom-control-input" <?php if (in_array($_smarty_tpl->tpl_vars['skey']->value,$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['stype']) || $_smarty_tpl->tpl_vars['skey']->value == $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['stype']) {?>checked="checked"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
" name="stype[]" id="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
">
											<label class="custom-control-label" for="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['sitem']->value;?>
</label>
										</div>
									<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								</div>
													</div>
						<hr class="w-100">
					<?php }?>

					<div class="row px-2">
						<div class="col-xl-12 col-lg-12">
														<div class="row pb-5">
								<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
									<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Square Feet</h6>
									<div class="d-flex px-0">
										<div class="w-100">
											<select name="minsqft" class="custom-select rounded-0 border-0 py-0 shadow-none">
												<option value="" selected="">Min</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrSqftRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minsqft']),$_smarty_tpl);?>

											</select>
										</div>
										<div class="mx-3 align-self-center"> - </div>
										<div class="w-100">
											<select name="maxsqft" class="custom-select rounded-0 border-0 py-0 shadow-none">
												<option value="" selected="">Max</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrSqftRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxsqft']),$_smarty_tpl);?>

											</select>
										</div>
									</div>
								</div>
							</div>
							<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
								<div class="row pb-5">
									<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
										<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Lot Size</h6>
										<div class="d-flex px-0">
											<div class="w-100">
												<select name="minlotsizesqft" class="custom-select py-0 rounded-0 border-0 shadow-none">
													<option value="" selected="">Min</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrLotSize']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minlotsizesqft']),$_smarty_tpl);?>

												</select>
											</div>
											<div class="mx-3 align-self-center"> - </div>
											<div class="w-100">
												<select name="maxlotsizesqft" class="custom-select py-0 rounded-0 border-0 shadow-none">
													<option value="" selected="">Max</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrLotSize']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxlotsizesqft']),$_smarty_tpl);?>

												</select>
											</div>
										</div>
									</div>
									<div class="col-xl-5 col-lg-5 col-md-5 py-3 py-md-0">
										<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Days on Market</h6>
										<div class="w-100">
											<select name="dom" class="custom-select rounded-0 py-0 border-0 shadow-none">
												<option value="" selected="">Any</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrDayMarket']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['dom']),$_smarty_tpl);?>

											</select>
										</div>
									</div>
								</div>
							<?php }?>
							<div class="row pb-5">
								<div class="col-xl-7 col-lg-7 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?> col-md-12 <?php } else { ?> col-md-7<?php }?> col-sm-12 col-12">
									<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Year Built</h6>
									<div class="d-flex px-0">
										<div class="w-100">
											<select name="minyear" class="custom-select py-0 rounded-0 border-0 shadow-none">
												<option selected="" value="">Min</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrminYearBuild']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minyear']),$_smarty_tpl);?>

											</select>
										</div>
										<div class="mx-3 align-self-center"> - </div>
										<div class="w-100">
											<select name="maxyear" class="custom-select py-0 rounded-0 border-0 shadow-none">
												<option selected="" value="">Max</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrmaxYearBuild']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxyear']),$_smarty_tpl);?>

											</select>
										</div>
									</div>
								</div>
								<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
									<div class="col-xl-5 col-lg-6 col-md-5 col-sm-12 py-3 py-md-0 col-12 mt-5-">
										<div class="d-flex px-0">
											<div class="w-100">
												<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Furnished</h6>
												<select name="furnished" class="custom-select rounded-0 border-0 shadow-none">
													<option value="" selected="">Any</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrFurnished']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['furnished']),$_smarty_tpl);?>

												</select>
											</div>
										</div>
									</div>
								<?php }?>
							</div>

							<div class="row pb-5">
								<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<div class="d-flex px-0">
										<div class="w-100">
											<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Pool</h6>
											<select name="pool" class="custom-select rounded-0 py-0 border-0 shadow-none">
												<option value="" selected="">Any</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['pool']),$_smarty_tpl);?>

											</select>
										</div>
																			</div>
								</div>
								<?php }?>
								<div class="col-xl-6 col-lg-6 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?> col-md-12 <?php } else { ?> col-md-6<?php }?> col-sm-12 col-12">
									<div class="w-100">
										<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Pets Allowed</h6>
										<select name="petsallowed" class="custom-select py-0 rounded-0 border-0 shadow-none">
											<option value="" selected="">Any</option>
											<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['petsallowed']),$_smarty_tpl);?>

										</select>
									</div>
								</div>
							</div>
							<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
								<div class="row pb-5">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 py-3 py-md-0 col-12">
										<div class="d-flex px-0">
											<div class="w-100">
												<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">HOA</h6>
												<select name="ishoa" class="custom-select rounded-0 py-0 border-0 shadow-none">
													<option value="" selected="">Any</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['ishoa']),$_smarty_tpl);?>

												</select>
											</div>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 form-group mb-0">
										<div class="w-100">
											<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">New Construction</h6>
											<select name="isnew" class="custom-select rounded-0 py-0 border-0 shadow-none">
												<option value="" selected="">Any</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrTrueFalse']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['isnew']),$_smarty_tpl);?>

											</select>
										</div>
									</div>
								</div>
							<?php }?>

							<div class="row pb-5">
								<div class="col-xl-6 col-lg-6 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?> col-md-12 <?php } else { ?> col-md-6<?php }?> py-3 py-md-0">
									<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Waterfront</h6>
									<div class="w-100">
										<select name="waterfront" class="custom-select py-0 rounded-0 border-0 shadow-none">
											<option value="" selected="">Any</option>
											<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['waterfront']),$_smarty_tpl);?>

										</select>
									</div>
								</div>
								<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
									<div class="col-xl-6 col-lg-6 col-md-6 form-group mb-0">
										<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Waterfront Description</h6>
										<select name="waterfrontdesc" class="custom-select rounded-0 border-0 shadow-none">
											<option value="" selected="">Any</option>
											<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrWaterfrontDesc']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['waterfrontdesc']),$_smarty_tpl);?>

										</select>
									</div>
								<?php }?>
							</div>
							<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
								<div class="row pb-5">
																		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-5-">
										<div class="d-flex px-0">
											<div class="w-100">
												<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Horse Amenities</h6>
												<select name="horse_yn" class="custom-select rounded-0 border-0 shadow-none">
													<option value="" selected="">Any</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['horse_yn']),$_smarty_tpl);?>

												</select>
											</div>
										</div>
									</div>
																			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 py-3 py-md-0 col-12 mt-5-">
											<div class="d-flex px-0">
												<div class="w-100">
													<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Security</h6>
													<select name="security_safety" class="custom-select rounded-0 border-0 shadow-none">
														<option value="" selected="">No preference</option>
														<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrSecuritySafety']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['security_safety']),$_smarty_tpl);?>

													</select>
												</div>
											</div>
										</div>
																	</div>
							<?php }?>
															<div class="row pb-5">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 py-3 py-md-0">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Membership Required</h6>
										<div class="w-100">
											<select name="membership_required" class="custom-select rounded-0 border-0 py-0 shadow-none">
												<option value="" selected="">Any</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['membership_required']),$_smarty_tpl);?>

											</select>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group mb-0">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Membership Fee</h6>
										<input type="text" name="membership_fee" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['membership_fee'];?>
" class="form-control rounded-0 border-0 py-0 shadow-none" id="membership_fee" placeholder="Membership Fee">
									</div>
								</div>
														<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
								<div class="row pb-5">
									<div class="col-xl-12 col-lg-12 col-md-12 py-md-0 py-0 form-group mb-0">
										<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Keywords</h6>
										<input type="text" name="kword" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['kword'];?>
" placeholder="Try remodel, renovated, turn key, fence, new roof" class="form-control rounded-0 border-0 py-0 shadow-none" id="kword" aria-describedby="kwordHelp">
									</div>
								</div>
							<?php }?>
						</div>
						<input name="addval" class="" id="AddressValuembl" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addval'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" data-type="hidden" type="hidden">
						<input name="addtype" class="" id="AddressTypembl" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addtype'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" data-type="hidden" type="hidden">
																	</div>
				</form>
			</div>
			<div class="modal-footer justify-content-center respo-clear-filters p-0">
				<button type="button" class="btn w-50 text-white- te-btn rounded-0 m-0 py-2 shadow-none te-small-device-search btn-mbl-search lpt-btn lpt-btn-txt">Search</button>
				<button type="button" class="btn w-50 bg-white text-dark border-dark btn-search-reset rounded-0 m-0 py-2 shadow-none">Reset</button>
			</div>

		</div>
	</div>
</div><?php }
}
