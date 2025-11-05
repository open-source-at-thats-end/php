<?php
/* Smarty version 4.2.1, created on 2023-08-10 08:02:25
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/main-device-search-form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64d4dfe1602659_58497027',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e04f8076ac028955b1ffe7504df6d0dce7d798d2' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/main-device-search-form.tpl',
      1 => 1663781528,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64d4dfe1602659_58497027 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/function.html_options.php','function'=>'smarty_function_html_options',),));
?>
<form class="form" id="frmlistingsearch" role="form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['formAction']->value;?>
">
	<div id="search-filters" class="row te-search-filter-row shadow-none">
		<div class="col-xl-4 col-lg-10 col-md-10 col-sm-10 col-10 px-0 px-lg-3-  px-xl-0 py-0 py-xl-0 te-filter-searchbar ">
			<div class="input-group h-100 px-xl-2 px-md-2 px-0 btn-gray border-right-">
				<input type="text" id="AddressName" class="form-control shadow-none rounded-0 align-self-center h-100 py-1 py-lg-4 pl-2 border-0 te-filter-searchbox btn-gray" name="AddressName" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addval'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" placeholder="City, Neighborhood, Address, School, ZIP, MLS#" aria-label="Username" aria-describedby="basic-addon1">
				<div id="search-box" class="input-group-prepend px-xl-4 px-1">
					<span class="input-group-text border-0 btn-gray svg-icon-color te-btn- text-white- lpt-btn- lpt-btn-txt-" id="basic-addon1"><i class="fas fa-search fa-lg"></i></span>
				</div>
				<input name="addval" class="" id="AddressValue" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addval'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" data-type="hidden" type="hidden">
				<input name="addtype" class="" id="AddressType" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addtype'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" data-type="hidden" type="hidden">
			</div>
		</div>

		
		<div class="col-2 col-lg-2 col-md-2 col-sm-2 d-block d-xl-none d-flex- justify-content-around- py-2  py-0 mb-2- px-0 btn-gray border-right- px-md-3-">
			<div class="d-flex d-xl-none svg-icon-color">
				<a class="btn te-btn- text-white- w-100 rounded-0 responsive-filters-tab align-self-center shadow-none te-font-size-14 font-weight-bold te-width-max-content- px-4 mr-3- lpt-btn- lpt-btn-txt-" role="button" data-toggle="modal" data-target="#exampleModalScrollable"><i class="fas fa-sliders-h fa-2x font-svg pr-1 align-middle"></i>
				</a>
							</div>
		</div>
							
		<?php if ($_smarty_tpl->tpl_vars['deviceType']->value == 'computer' || $_smarty_tpl->tpl_vars['deviceType']->value == 'tablet') {?>
			<div class="col-xl-7 col-lg-5- col-md-9- col-sm-12- col-12- d-none d-xl-block d-xl-inline-flex justify-content-around- px-1 py-0 mt-2 mt-md-0 te-filter-dropdowns btn-gray border-right-">
				<div class="row w-100 btn-gray-  px-0 mx-0 justify-content-around-">
					<div class="col-xl-2 col col-lg col-lg-3- search-btn-hover">
						<div class="dropdown d-none d-xl-flex justify-content-center py-0 filter-dropdown te-white-space-no-wrap h-100">
							<a class="btn dropdown-toggle rounded-0 shadow-none text-uppercase- align-self-center te-font-weight-500" href="#" role="button" id="dropdownStype" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Property Type
							</a>
							<div class="dropdown-menu mt-12 bg-white px-4 border rounded-0 mx-height" aria-labelledby="dropdownStype">
								<div class="row">
																		<div class="col-xl-12 col-lg-12 px-3 py-0">
										<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrMeta']->value['SubType'], 'sitem', false, 'skey', 'ptype', array (
));
$_smarty_tpl->tpl_vars['sitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['skey']->value => $_smarty_tpl->tpl_vars['sitem']->value) {
$_smarty_tpl->tpl_vars['sitem']->do_else = false;
?>
											<div class="custom-control custom-checkbox py-2">
												<input type="checkbox" class="custom-control-input fstype" <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['stype'])) && (in_array($_smarty_tpl->tpl_vars['skey']->value,$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['stype']) || $_smarty_tpl->tpl_vars['skey']->value == $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['stype'])) {?>checked="checked"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
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
							</div>
						</div>
					</div>
					<div class="col-xl-2 col col-lg col-lg-3- filter-button search-btn-hover">
						<div class="dropdown d-none d-xl-flex justify-content-center py-0 filter-dropdown te-white-space-no-wrap h-100">
							<a class="btn dropdown-toggle rounded-0 shadow-none text-uppercase- align-self-center te-font-weight-500 filter-btn-txt" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Status
							</a>
							<div class="dropdown-menu mt-12 bg-white px-3 py-1 border rounded-0">
								<div class="row">
									<div class="col-xl-12 col-lg-12 py-0">
										<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrStatus']->value, 'statusitem', false, 'statuskey', 'beds', array (
));
$_smarty_tpl->tpl_vars['statusitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['statuskey']->value => $_smarty_tpl->tpl_vars['statusitem']->value) {
$_smarty_tpl->tpl_vars['statusitem']->do_else = false;
?>
											<div class="custom-control custom-radio py-2">
												<input type="radio" class="custom-control-input fstatus" <?php if ($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['status'] == $_smarty_tpl->tpl_vars['statuskey']->value) {?>checked<?php } elseif (!(isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['status'])) && $_smarty_tpl->tpl_vars['statuskey']->value == 'all') {?> checked<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['statuskey']->value;?>
" name="status" id="status-<?php echo $_smarty_tpl->tpl_vars['statuskey']->value;?>
">
												<label class="custom-control-label" for="status-<?php echo $_smarty_tpl->tpl_vars['statuskey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['statusitem']->value;?>
</label>
											</div>
										<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-2 col col-lg col-lg-3- search-btn-hover">
						<div class="dropdown d-none d-xl-flex justify-content-center py-0 filter-dropdown te-white-space-no-wrap h-100">
							<a class="btn dropdown-toggle rounded-0 shadow-none text-uppercase- align-self-center te-font-weight-500" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Price
							</a>
							<div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content">
								<div class="row">
									<div class="col-xl-12 col-lg-12 d-flex py-1">
										<div class="te-width-max-content">
																						<input type="text" name="minprice" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minprice'];?>
" class="form-control rounded-0 fprice" id="minprice" placeholder="Min Price" aria-describedby="min price">
										</div>

										<div class="mx-3 align-self-center"> To </div>
										<div class="te-width-max-content">
																						<input type="text" name="maxprice" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxprice'];?>
" class="form-control rounded-0 fprice" id="maxprice" placeholder="Max Price" aria-describedby="max price">
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-2 col col-lg col-lg-3- d-lg-none d-xl-block search-btn-hover">
						<div class="dropdown d-none d-xl-flex justify-content-center py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds">
							<a class="btn dropdown-toggle rounded-0 shadow-none text-uppercase- align-self-center te-font-weight-500" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Beds
							</a>
							<div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content">
								<div class="row">
									<div class="col-xl-12 col-lg-12 d-flex py-1">
										<div class="te-width-max-content- w-100">
											<select class="custom-select rounded-0 fbed pr-5 py-0" name="minbed">
												<option value="" selected>Min</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrBedRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minbed']),$_smarty_tpl);?>

											</select>

										</div>

										<div class="mx-3 align-self-center"> To </div>
										<div class="te-width-max-content- w-100">
											<select class="custom-select rounded-0 fbed pr-5 py-0" name="maxbed">
												<option value="" selected>Max</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrBedRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxbed']),$_smarty_tpl);?>

											</select>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-2 col col-lg col-lg-3- d-lg-none d-xl-block search-btn-hover">
						<div class="dropdown d-none d-xl-flex justify-content-center py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds">
							<a class="btn dropdown-toggle rounded-0 shadow-none text-uppercase- align-self-center te-font-weight-500" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Baths
							</a>
							<div class="dropdown-menu mt-12 bg-white px-4 border rounded-0">
								<div class="row">
									<div class="col-xl-12 col-lg-12 px-3 py-0">
										<div class="custom-control custom-radio py-2">
											<input type="radio" class="custom-control-input fbath" <?php if ($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minbath'] == '') {?>checked<?php }?> value="" name="minbath" id="bath-any">
											<label class="custom-control-label" for="bath-any">Any</label>
										</div>
										<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrBathRange']->value, 'bathitem', false, 'bathkey', 'beds', array (
));
$_smarty_tpl->tpl_vars['bathitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['bathkey']->value => $_smarty_tpl->tpl_vars['bathitem']->value) {
$_smarty_tpl->tpl_vars['bathitem']->do_else = false;
?>
											<div class="custom-control custom-radio py-2">
												<input type="radio" class="custom-control-input fbath" <?php if ($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minbath'] == $_smarty_tpl->tpl_vars['bathkey']->value) {?>checked<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['bathkey']->value;?>
" name="minbath" id="bath-<?php echo $_smarty_tpl->tpl_vars['bathkey']->value;?>
">
												<label class="custom-control-label" for="bath-<?php echo $_smarty_tpl->tpl_vars['bathkey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['bathitem']->value;?>
</label>
											</div>
										<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-2 align-self-center d-none d-lg-flex  py-2 py-xl-0 border-right- d-flex justify-content-around search-filter-btn-hover h-100">
						<div class="dropdown d-none d-xl-flex py-1- filter-dropdown te-more-filter-dropdown align-self-center">
							<a class="dropdown-toggle btn bg-white- px-4 rounded-0 shadow-none text-uppercase- te-font-weight-500 more-filter-dropdown" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-sliders-h fa-2x pr-2 align-middle"></i>More Filters
							</a>
							<div class="dropdown-menu dropdown-menu-right bg-white p-4 te-bg-light border-0 rounded-0 te-more-filter" aria-labelledby="dropdownMenuLink" style="">
								<div class="te-close-more-filter position-absolute te-btn text-white-  lpt-btn p-3 lpt-btn-txt">
									<a aria-label="button" href="javascript:void(0);" role="button">
										<i class="fas fa-times p-3-  te-more-filter-close"></i>
									</a>
								</div>

								<div class="row pb-5 d-lg-block d-xl-none d-sm-none lg-device-bedbath">
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<h5 class="txt-heading heading_txt_color">Bathrooms</h5>
									</div>
									<div class="col-xl-12 col-lg-12 py-0 px-3">
										<div class="custom-control custom-radio py-2 te-width-max-content d-inline-block px-4">
											<input type="radio" class="custom-control-input" <?php if ($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minbath'] == '') {?>checked<?php }?> value="" name="lgminbath" id="ps-small-bath-any">
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
" name="lgminbath" id="ps-small-bath-<?php echo $_smarty_tpl->tpl_vars['bathkey']->value;?>
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

								<div class="row pb-5 d-lg-block d-xl-none d-sm-none lg-device-bedbath">
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<h5 class="txt-heading heading_txt_color">Bedrooms</h5>
									</div>
									<div class="col-xl-12 col-lg-12 py-0 px-3">
										<div class="d-flex px-0">
											<div class="w-100">
												<select class="custom-select rounded-0 border-0 shadow-none" name="minbed">
													<option value="" selected="selected">Min</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrBedRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minbed']),$_smarty_tpl);?>

												</select>

											</div>
											<div class="mx-3 align-self-center"> - </div>
											<div class="w-100">
												<select class="custom-select rounded-0 border-0 shadow-none" name="maxbed">
													<option value="" selected="selected">Max</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrBedRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxbed']),$_smarty_tpl);?>

												</select>
											</div>
										</div>
									</div>
									<div class="row pb-5">
										<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group mb-0">
											<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Waterfront Description</h6>
											<select name="waterfrontdesc" class="custom-select rounded-0 border-0 shadow-none">
												<option value="" selected="">Any</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrWaterfrontDesc']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['waterfrontdesc']),$_smarty_tpl);?>

											</select>
										</div>
																				<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
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

									<div class="row pb-5" style="bottom: 0;">
										<div class="col-xl-12">
											<a class="btn btn-secondary- rounded-0 te-btn border-secondary- te-btn px-5 btn-search-filter lpt-btn lpt-btn-txt" href="javascript:void(0);" role="button">Search</a>
											<a class="btn btn-white rounded-0 border-dark bg-white px-5 ml-2 btn-search-reset" href="javascript:void(0);" role="button">Reset</a>
																					</div>
									</div>

								</div>

								<h5 class="text-uppercase text-secondary mb-5 font-weight-bold txt-heading heading_txt_color">Filters</h5>
																
								<div class="row pb-5">
									<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Square Feet</h6>
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
									<div class="col-xl-5 col-lg-5 col-md-5">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Days on Market</h6>
										<div class="w-100">
											<select name="dom" class="custom-select rounded-0 border-0 py-0 shadow-none">
												<option value="" selected="">Any</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrDayMarket']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['dom']),$_smarty_tpl);?>

											</select>
										</div>
									</div>
								</div>

								<div class="row pb-5">
									<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Lot Size</h6>
										<div class="d-flex px-0">
											<div class="w-100">
												<select name="minlotsizesqft" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Min</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrLotSize']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minlotsizesqft']),$_smarty_tpl);?>

												</select>
											</div>
											<div class="mx-3 align-self-center"> - </div>
											<div class="w-100">
												<select name="maxlotsizesqft" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Max</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrLotSize']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxlotsizesqft']),$_smarty_tpl);?>

												</select>
											</div>
										</div>
									</div>
									<div class="col-xl-5 col-lg-5 col-md-5">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">HOA</h6>
										<div class="w-100">
											<select name="ishoa" class="custom-select rounded-0 border-0 py-0 shadow-none">
												<option value="" selected="">Any</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['ishoa']),$_smarty_tpl);?>

											</select>
										</div>
									</div>

								</div>

								<div class="row pb-5">
									<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Year Built</h6>
										<div class="d-flex px-0">
											<div class="w-100">
												<select name="minyear" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Min</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrminYearBuild']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minyear']),$_smarty_tpl);?>

												</select>
											</div>
											<div class="mx-3 align-self-center"> - </div>
											<div class="w-100">
												<select name="maxyear" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Max</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrmaxYearBuild']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxyear']),$_smarty_tpl);?>

												</select>
											</div>
										</div>
									</div>
									<div class="col-xl-5 col-lg-5 col-md-5">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">New Construction</h6>
										<div class="w-100">
											<select name="isnew" class="custom-select rounded-0 border-0 py-0 shadow-none">
												<option value="" selected="">Any</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrTrueFalse']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['isnew']),$_smarty_tpl);?>

											</select>
										</div>
									</div>

								</div>

								<div class="row pb-5">
									<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
										<div class="d-flex px-0">
											<div class="w-100">
												<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Pool</h6>
												<select name="pool" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Any</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['pool']),$_smarty_tpl);?>

												</select>
											</div>
											<div class="mx-3 align-self-center"></div>
											<div class="w-100">
												<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Pets Allowed</h6>
												<select name="petsallowed" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Any</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['petsallowed']),$_smarty_tpl);?>

												</select>
											</div>
										</div>
									</div>
									<div class="col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12">
										<div class="d-flex px-0">
											<div class="w-100">
												<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Furnished</h6>
												<select name="furnished" class="custom-select rounded-0 border-0 shadow-none">
													<option value="" selected="">Any</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrFurnished']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['furnished']),$_smarty_tpl);?>

												</select>
											</div>
										</div>
									</div>

								</div>

								<div class="row pb-5">
									<div class="col-xl-6 col-lg-5 col-md-5">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Waterfront</h6>
										<div class="w-100">
											<select name="waterfront" class="custom-select rounded-0 border-0 py-0 shadow-none">
												<option value="" selected="">Any</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrYesNo']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['waterfront']),$_smarty_tpl);?>

											</select>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group mb-0">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Waterfront Description</h6>
										<select name="waterfrontdesc" class="custom-select rounded-0 border-0 shadow-none">
											<option value="" selected="">Any</option>
											<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrWaterfrontDesc']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['waterfrontdesc']),$_smarty_tpl);?>

										</select>
									</div>
																	</div>
								<div class="row pb-5">
																		<div class="col-xl-6 col-lg-4 col-md-12 col-sm-12 col-12">
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

																		<div class="col-xl-6 col-lg-4 col-md-12 col-sm-12 col-12">
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
																<div class="row pb-5">
									<div class="col-xl-6 col-lg-6 col-md-6">
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
																<div class="row pb-5">
									<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 form-group mb-0">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Keywords</h6>
										<input type="text" name="kword" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['kword'];?>
" class="form-control rounded-0 border-0 py-0 shadow-none" id="kword" placeholder="Try remodel, renovated, turn key, fence, new roof" aria-describedby="kwordHelp">
									</div>
								</div>
								<div class="row pb-5" style="bottom: 0;">
									<div class="col-xl-12">
										<a class="btn btn-secondary- rounded-0 te-btn border-secondary- te-btn px-5 btn-search-filter lpt-btn lpt-btn-txt" href="javascript:void(0);" role="button">Search</a>
										<a class="btn btn-white rounded-0 border-dark bg-white px-5 ml-2 btn-search-reset" href="javascript:void(0);" role="button">Reset</a>
																			</div>
								</div>
							</div>
						</div>
					</div>
																								</div>
							</div>
			<div class="col-xl-1 col-lg-5- col-md-9- col-sm-12- col-12- d-none d-xl-block d-xl-inline-flex px-1 px-xl-0 mt-md-0 te-filter-dropdowns btn-gray">
				<div class="row w-100 px-0 mx-0 search-filter-btn-hover">
															<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
						<div class="col-xl-12 align-self-center hover-unset text-center">
							<div class=" <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && ($_smarty_tpl->tpl_vars['device']->value != 'XS' && $_smarty_tpl->tpl_vars['device']->value != 'SM' && $_smarty_tpl->tpl_vars['device']->value != 'MD')) {?>order-1 col-xl-6 mt-1 py-1 <?php } else { ?>col-xl-1 <?php }?> custom-control custom-switch d-none d-xl-inline-flex te-map-switch-grid btn-gray align-items-center te-font-weight-500" data-toggle="modal" data-target="#te-map-modal">
								<input type="checkbox" class="custom-control-input" id="toggle-trigger-grid" name="toggle-trigger-grid" <?php if ((isset($_smarty_tpl->tpl_vars['is_map']->value)) && $_smarty_tpl->tpl_vars['is_map']->value == 'true') {?>checked<?php }?>>
								<label class="custom-control-label py-1" for="toggle-trigger-grid">Map</label>
							</div>
						</div>
					<?php }?>
				</div>
			</div>
					<?php }?>
	</div>
</form><?php }
}
