<?php
/* Smarty version 4.2.1, created on 2023-09-18 02:37:36
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/map-view.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_6507fe4036b884_05026362',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2ebbe4e4f5510b825b7d2b40fb698baee4e0ed80' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/map-view.tpl',
      1 => 1695022568,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:listing/mobile-device-search-form.tpl' => 1,
  ),
),false)) {
function content_6507fe4036b884_05026362 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/modifier.capitalize.php','function'=>'smarty_modifier_capitalize',),2=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),));
if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && (isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>
		<?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && ((isset($_smarty_tpl->tpl_vars['isFilter']->value)) && $_smarty_tpl->tpl_vars['isFilter']->value !== 'false') || ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'Yes' && (isset($_smarty_tpl->tpl_vars['tabs']->value)) && $_smarty_tpl->tpl_vars['tabs']->value !== 'false')) {?>
		<div class="row te-search-filter-row- justify-content-between pre-filter-line pb-2 pr-1- border-bottom- bg-white <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true' && (isset($_smarty_tpl->tpl_vars['isstyle']->value)) && ($_smarty_tpl->tpl_vars['isstyle']->value !== false)) {?> px-3 <?php }?>">
						<?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'Yes' && (isset($_smarty_tpl->tpl_vars['tabs']->value)) && $_smarty_tpl->tpl_vars['tabs']->value !== 'false') {?>
				<div class="col-12 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>col-xl-8 col-lg-8<?php } else { ?>col-xl-12 col-lg-12<?php }?> col-md-8  pl-md-2  pr-md-0  px-1 text-md-left text-center align-self-center btn-gray py-2 border-btm pl-xl-3">
					<a href="<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-2 p-xl-2 px-1 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>te-pre-saveser<?php } else { ?>font-tab<?php }?> rounded-0 lpt-btn- lpt-btn-txt-"><i class="fa fa-th pr-md-1 pr-0 <?php if (cw::$screen == 'XS') {?> fa-1x <?php } else { ?> fa-2x <?php }?> align-middle"></i> <?php if ((isset($_smarty_tpl->tpl_vars['is_rental']->value)) && $_smarty_tpl->tpl_vars['is_rental']->value == true) {?> GRID VIEW <?php } else { ?>GRID VIEW<?php }?></a>
					<a href="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_SALES;?>
/<?php echo str_replace(' ','-',$_smarty_tpl->tpl_vars['presearch_title']->value);?>
" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12  shadow-none p-lg-2 p-xl-2 px-1 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>te-pre-saveser<?php } else { ?>font-tab<?php }?> rounded-0 tab-btn-"><i class="fa fa-list pr-md-1 pr-0 <?php if (cw::$screen == 'XS') {?> fa-1x <?php } else { ?> fa-2x <?php }?> align-middle"></i> LIST VIEW</a>
					<a href="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_RENTALS;?>
/<?php echo str_replace(' ','-',$_smarty_tpl->tpl_vars['presearch_title']->value);?>
" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12  shadow-none p-lg-2 p-xl-2 px-1 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>te-pre-saveser<?php } else { ?>font-tab<?php }?> rounded-0 tab-btn-"><i class="fa fa-list pr-md-1 pr-0 <?php if (cw::$screen == 'XS') {?> fa-1x <?php } else { ?> fa-2x <?php }?> align-middle"></i> RENTALS</a>
					<a href="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_SOLD;?>
/<?php echo str_replace(' ','-',$_smarty_tpl->tpl_vars['presearch_title']->value);?>
" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12  shadow-none p-lg-2 p-xl-2 px-1 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>te-pre-saveser<?php } else { ?>font-tab<?php }?> rounded-0 tab-btn-"><i class="fa fa-list pr-md-1 pr-0 <?php if (cw::$screen == 'XS') {?> fa-1x <?php } else { ?> fa-2x <?php }?> align-middle"></i> PAST SALES</a>
				</div>
			<?php } elseif ((isset($_smarty_tpl->tpl_vars['isFilter']->value)) && $_smarty_tpl->tpl_vars['isFilter']->value !== 'false' && $_smarty_tpl->tpl_vars['isFilter']->value !== false) {?>
				<div class="col-12 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>col-xl-8 col-lg-8<?php } else { ?>col-xl-6 col-lg-6<?php }?> col-md-12 pl-md-2  pr-md-0  px-1 py-2 pt-11- align-self-center- btn-gray d-none d-lg-flex align-items-center">
					<form class="form w-100 d-none d-lg-block d-xl-block pre-search py-1 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?>pre-search-arrow <?php }?>" id="frmlistingsearch" role="form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['formAction']->value;?>
">
						<div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>pr-xl-3 pr-lg-3 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>px-xl-3 <?php }
} else { ?>pr-xl-1 pr-lg-1 px-xl-3 px-0 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>col-3<?php }
}?> pr-1 px-0">
							<a class="btn dropdown-toggle <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>f-tab<?php } else { ?>font-tab<?php }?> rounded-0 shadow-none align-self-center font-size-sm-12 te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Price
							</a>
							<div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content pre-dropdowen">
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
									<div class="col-xl-12 col-lg-12 d-flex py-1">
										<div id="price-range"></div>
									</div>
								</div>
							</div>
						</div>

						<div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>pr-xl-3 pr-lg-3 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>px-xl-3 <?php }
} else { ?>pr-xl-1 pr-lg-1 px-xl-3 px-0 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>col-3 <?php }
}?> pr-1 pl-0 ">
							<a class="btn dropdown-toggle <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>f-tab<?php } else { ?>font-tab<?php }?> rounded-0 shadow-none align-self-center font-size-sm-12 te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Beds</a>
							<div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content pre-dropdowen">
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
						<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>
							<div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>pr-3 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>px-xl-3 <?php }
} else { ?>pr-1 px-xl-2 px-0 <?php }?> pl-0">
								<a class="btn dropdown-toggle <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>f-tab<?php } else { ?>font-tab<?php }?> rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Baths
								</a>
								<div class="dropdown-menu mt-12 bg-white px-4 border rounded-0">
									<div class="row">
										<div class="col-xl-12 col-lg-12 px-3 py-0">
											<div class="custom-control custom-radio py-2">
												<input type="radio" class="custom-control-input fbath" <?php if ($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minbath'] == '') {?>checked<?php }?> value="" name="minbath" id="bath-any">
												<label class="custom-control-label" for="bath-any">Any</label>
											</div>
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrBathRange']->value, 'bathitem', false, 'bathkey', 'bath', array (
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
						<?php }?>
						<div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>pr-3<?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?> px-xl-3 <?php }
} else { ?>pr-1 px-xl-3 px-0 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>col-3<?php }?> <?php }?> pl-0">
							<a class="btn dropdown-toggle <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>f-tab<?php } else { ?>font-tab<?php }?> rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Square Ft
							</a>
							<div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content">
								<div class="row">
									<div class="col-xl-12 col-lg-12 d-flex py-1">
										<div class="te-width-max-content">
											<select name="minsqft" class="custom-select rounded-0 fsqft shadow-none">
												<option value="" selected="">Min</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrSqftRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minsqft']),$_smarty_tpl);?>

											</select>
										</div>

										<div class="mx-3 align-self-center"> To </div>
										<div class="te-width-max-content">
											<select name="maxsqft" class="custom-select rounded-0 fsqft shadow-none">
												<option value="" selected="">Max</option>
												<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrSqftRange']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxsqft']),$_smarty_tpl);?>

											</select>
										</div>

									</div>
								</div>
							</div>
						</div>
						<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>
							<div class="dropdown d-none d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 pr-3 pl-0 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>px-xl-3 <?php }?>">
								<a class="btn dropdown-toggle rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Waterfront
								</a>
								<div class="dropdown-menu mt-12 bg-white px-3 py-2 border rounded-0">
									<div class="row">
										<div class="col-xl-12 col-lg-12 py-0">
											<div class="custom-control custom-radio py-2">
												<input type="radio" class="custom-control-input fwf" <?php if ($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['waterfront'] == '') {?>checked<?php }?> value="" name="waterfront" id="wf-any">
												<label class="custom-control-label" for="wf-any">Any</label>
											</div>
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrYesNo']->value, 'wfitem', false, 'wfkey', 'beds', array (
));
$_smarty_tpl->tpl_vars['wfitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['wfkey']->value => $_smarty_tpl->tpl_vars['wfitem']->value) {
$_smarty_tpl->tpl_vars['wfitem']->do_else = false;
?>
												<div class="custom-control custom-radio py-2">
													<input type="radio" class="custom-control-input fwf" <?php if ($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['waterfront'] == $_smarty_tpl->tpl_vars['wfkey']->value) {?>checked<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['wfkey']->value;?>
" name="waterfront" id="wf-<?php echo $_smarty_tpl->tpl_vars['wfkey']->value;?>
">
													<label class="custom-control-label" for="wf-<?php echo $_smarty_tpl->tpl_vars['wfkey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['wfitem']->value;?>
</label>
												</div>
											<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
										</div>
									</div>
								</div>
							</div>

							<div class="dropdown d-none d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 pr-3 pl-0 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true' && (isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>px-xl-3 <?php }?>">
								<a class="btn dropdown-toggle <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>f-tab  <?php } else { ?>font-tab<?php }?> rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pets
								</a>
								<div class="dropdown-menu mt-12 bg-white px-3 py-2 border rounded-0">
									<div class="row">
										<div class="col-xl-12 col-lg-12 py-0">
											<div class="custom-control custom-radio py-2">
												<input type="radio" class="custom-control-input fpetsa" <?php if ($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['petsallowed'] == '') {?>checked<?php }?> value="" name="petsallowed" id="pets-any">
												<label class="custom-control-label" for="pets-any">Any</label>
											</div>
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrYesNo']->value, 'petsitem', false, 'petskey', 'beds', array (
));
$_smarty_tpl->tpl_vars['petsitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['petskey']->value => $_smarty_tpl->tpl_vars['petsitem']->value) {
$_smarty_tpl->tpl_vars['petsitem']->do_else = false;
?>
												<div class="custom-control custom-radio py-2">
													<input type="radio" class="custom-control-input fpetsa" <?php if ($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['petsallowed'] == $_smarty_tpl->tpl_vars['petskey']->value) {?>checked<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['petskey']->value;?>
" name="petsallowed" id="pets-<?php echo $_smarty_tpl->tpl_vars['petskey']->value;?>
">
													<label class="custom-control-label" for="pets-<?php echo $_smarty_tpl->tpl_vars['petskey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['petsitem']->value;?>
</label>
												</div>
											<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
										</div>
									</div>
								</div>
							</div>

							<div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds pr-3 pl-0">
								<a class="btn dropdown-toggle <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>f-tab <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>px-xl-3 <?php }
} else { ?>font-tab<?php }?> rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Year built
								</a>
								<div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content">
									<div class="row">
										<div class="col-xl-12 col-lg-12 d-flex py-1">
											<div class="te-width-max-content">
												<select name="minyear" class="custom-select rounded-0 shadow-none fyear">
													<option value="" selected="">Min</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrminYearBuild']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['minyear']),$_smarty_tpl);?>

												</select>
											</div>

											<div class="mx-3 align-self-center"> To </div>
											<div class="te-width-max-content">
												<select name="maxyear" class="custom-select rounded-0 shadow-none fyear">
													<option value="" selected="">Max</option>
													<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrmaxYearBuild']->value,'selected'=>$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['maxyear']),$_smarty_tpl);?>

												</select>
											</div>

										</div>
									</div>
								</div>
							</div>
						<?php }?>
					</form>
				</div>
			<?php }?>
			<div class="col-12 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>col-xl-4 col-lg-4 <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'No') {?>text-sm-right<?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?> justify-content-between justify-content-sm-center font-size-sm-10 <?php if (cw::$screen !== 'XS') {?>p-unset<?php }?> justify-content-md-end px-xl-3 <?php }?> <?php } else { ?> justify-content-between justify-content-sm-end <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'Yes') {?>col-xl-12 col-lg-12 mt-lg-2 <?php } else { ?>col-xl-6 col-lg-6 <?php }
}?>   px-1- px-md-0-  text-center <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'Yes') {?> btn-gray col-md-4 justify-content-between py-1 <?php } else { ?> btn-gray col-md-12 py-2 <?php }?>  pt-lg-0- pt-2- d-flex d-md-block-  px-2 px-xl-2 py-xl-2 py-md-0 pb-2- ">
				<?php if ((isset($_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value)) && $_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value == 'Yes') {?>
					<a href="<?php echo $_smarty_tpl->tpl_vars['marketReportURL']->value;?>
" class="btn btn-sm btn-primary- btn-market-insight text-primary align-self-center  <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'No') {?>font-size-sm-12<?php }?> te-font-size-13 font-size-sm-10 shadow-none p-1 p-lg-1 p-xl-2 px-2 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>te-pre-saveser<?php } else { ?>font-tab text-sm-right <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && (cw::$screen == 'MD' || cw::$screen == 'SM')) {?>col col-md-4- col-xl-auto- px-sm-3 <?php }?> <?php }?> rounded-0"><i class="fas fa-2x fa-poll text-dark pr-2 align-middle"></i><span class="d-none- d-sm-inline <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'Yes') {?>d-md-none<?php }?> d-lg-inline">Market Insights</span></a>
				<?php }?>
				<div class="dropdown d-inline-block mx-1- mx-lg-0 align-self-center<?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && (isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true' && (cw::$screen == 'MD' || cw::$screen == 'SM')) {?> col-md-auto- col-xl-auto- px-sm-3<?php }?>">
					<button id="share-btn" class="btn btn-sm dropdown-toggle  <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>f-tab btn-gray- <?php } else { ?>font-tab dropdown-block <?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'No') {?> font-size-sm-10 font-size-sm-12  <?php } else { ?>te-btn- text-white- <?php }?> te-font-size-12- te-btn- text-white- shadow-none p-lg-2 px-xl-3 px-2 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt-" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="fas fa-share-alt fa-2x align-middle pr-2"></i><span class="d-none- d-sm-inline- <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'Yes') {?>d-md-none<?php }?> d-lg-inline">Share</span>
					</button>
					<div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u=<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" target="_blank"><i class="fab fa-facebook-f pr-2-"></i> Facebook</a>
						<a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url=<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" target="_blank"><i class="fab fa-fa-w-16 pr-1-"></i> Twitter</a>
						<a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url=<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" target="_blank"><i class="fab fa-pinterest-p pr-2-" ></i> Pinterest</a>
						<a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" target="_blank"><i class="fab fa-linkedin-in pr-2-"></i> LinkedIn</a>
						<a class="dropdown-item font-size-14 py-1" href="mailto:?subject=Share <?php if ((isset($_smarty_tpl->tpl_vars['presearch_title']->value)) && $_smarty_tpl->tpl_vars['presearch_title']->value != '') {
echo $_smarty_tpl->tpl_vars['presearch_title']->value;
}?>&body=<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" target="_blank"><i class="fas fa-envelope pr-2-"></i> Email</a>
					</div>
				</div>
				<?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'No') {?>
					<?php if (cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD') {?>
						<a class="btn btn-sm rounded-0 d-lg-none <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'No') {?>font-size-sm-12 font-size-sm-10<?php }?> te-font-size-13 responsive-filters-tab align-self-center shadow-none te-font-size-14 px-3 lpt-btn- lpt-btn-txt- btn-gray- <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>te-pre-mblf<?php } else { ?>font-tab <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?>d-none <?php }
}?>" role="button" data-toggle="modal" data-target="#exampleModalScrollable"><i class="fas fa-sliders-h fa-2x pr-2 align-middle"></i>More Filters <i class="fas fa-angle-down align-middle"></i>
						</a>
					<?php }?>
				<?php }?>
							</div>
		</div>
		<?php if (cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD') {?>
			<?php $_smarty_tpl->_subTemplateRender("file:listing/mobile-device-search-form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
		<?php }?>
	<?php }
}
if (!(isset($_smarty_tpl->tpl_vars['isHeading']->value)) || ((isset($_smarty_tpl->tpl_vars['isHeading']->value)) && $_smarty_tpl->tpl_vars['isHeading']->value !== 'false' && $_smarty_tpl->tpl_vars['isHeading']->value !== false)) {?>
	<?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && ($_smarty_tpl->tpl_vars['device']->value !== 'XS' && $_smarty_tpl->tpl_vars['device']->value !== 'SM' && $_smarty_tpl->tpl_vars['device']->value !== 'MD')) {?><div class="row <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true' && ((isset($_smarty_tpl->tpl_vars['isstyle']->value)) && ($_smarty_tpl->tpl_vars['isstyle']->value !== false))) {?> px-3 <?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?> px-3 pt-1 pt-md-2 <?php }?>"><?php }?>
	<div class="<?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && ($_smarty_tpl->tpl_vars['device']->value != 'XS' && $_smarty_tpl->tpl_vars['device']->value != 'SM' && $_smarty_tpl->tpl_vars['device']->value != 'MD')) {?>col <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>col-lg-4 col-xl-5<?php } else { ?>col-xl-7<?php }?> px-0<?php } else { ?>row <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?>border-sm-btm <?php }
}?>  <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?>pre-search-arrow py-1 py-md-0<?php }?> justify-content-between <?php if ((isset($_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value)) && $_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value == 'No') {
if (cw::$screen == 'XS' || cw::$screen == 'SM') {?>pt-2<?php }
}?>">
		<div class="<?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?>col-xl-12 col-md-12 d-flex<?php } else { ?>col-xl-9<?php }?>  col-lg-8 col-md-auto col-sm-auto px-2 align-self-center">
			<?php if ((isset($_smarty_tpl->tpl_vars['presearch_title']->value)) && $_smarty_tpl->tpl_vars['presearch_title']->value != '' && cw::$screen != 'MD') {?>
				<h1 class="te-search-property-title te-font-family mt-xl-2 pt-1 pt-md-0 pb-0 mb-0 txt-heading heading_txt_color col-10 col-xl-12 d-lg-block d-xl-block d-sm-none heading-font heading-truncate- mr-auto"><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['presearch_title']->value);?>
</h1>
			<?php } elseif ((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addtype'])) && $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addtype'] == 'cs') {?>
								<h1 class="te-search-property-title te-font-family mt-xl-2 pt-1 pt-md-0 pb-0 mb-0 txt-heading heading_txt_color col-10 col-xl-12 d-lg-block d-xl-block d-sm-none heading-font heading-truncate- mr-auto"><?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addval'];?>
 Real Estate & Homes For Sale</h1>
			<?php }?>
			<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
				<div class="col-2 d-block- d-xl-none align-self-center- mt-1 px-2 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>d-sm-none d-block<?php } else { ?> d-none <?php }?>">
					<div class="custom-control custom-switch te-width-max-content- d-block d-xl-none d-inline-block te-map-switch float-right pre-map-mbl-toggle"  data-target="#te-map-modal">
						<input type="checkbox" class="custom-control-input" id="toggle-trigger">
						<label class="custom-control-label te-font-size-14" for="toggle-trigger">Map</label>
					</div>
				</div>
			<?php }?>
		</div>

				<?php if ((isset($_smarty_tpl->tpl_vars['presearch_title']->value)) && $_smarty_tpl->tpl_vars['presearch_title']->value != '') {?>
			<div id="user-savesearch" class="col-xl-3 col-lg-4 col-md-auto col-sm-auto px-2 px-lg-0 text-right px-xl-2 <?php if ((isset($_smarty_tpl->tpl_vars['issavesearch']->value)) && $_smarty_tpl->tpl_vars['issavesearch']->value == 'true' && ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) || $_smarty_tpl->tpl_vars['isGrid']->value !== 'true')) {?>d-none d-xl-block- <?php } else { ?> d-none <?php }?>">
				<button id="save_search" type="buttocon" class="btn ml-1 ml-lg-1 rounded-0 shadow-none border-secondary- te-btn text-white- popup-modal-sm lpt-btn lpt-btn-txt" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;
if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>/?action=SaveSearch<?php } else { ?>/?action=member-login&ReqType=SaveSearch<?php }?>" data-toggle="modal" data-target="<?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value == true) {?>savesearch<?php } else { ?>MemberLogin<?php }?>">
					Save Search
				</button>
			</div>
		<?php }?>

	</div>
	
					<?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && ($_smarty_tpl->tpl_vars['device']->value != 'XS' && $_smarty_tpl->tpl_vars['device']->value != 'SM' && $_smarty_tpl->tpl_vars['device']->value != 'MD')) {?><div class="col <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>col-lg-8 col-xl-7<?php } else { ?>col-xl-5<?php }?>"><?php }?>
	<div id ="sort_content_end" class="row te-font-family- <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && ($_smarty_tpl->tpl_vars['device']->value != 'XS' && $_smarty_tpl->tpl_vars['device']->value != 'SM' && $_smarty_tpl->tpl_vars['device']->value != 'MD')) {?> <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>float-right <?php }
}?> <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true' || (!(isset($_smarty_tpl->tpl_vars['presearch_title']->value)) && $_smarty_tpl->tpl_vars['presearch_title']->value == '' && (!(isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addtype'])) && $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addtype'] == ''))) {?>justify-content-between<?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?>pre-search-arrow <?php } else { ?> <?php if ((!(isset($_smarty_tpl->tpl_vars['presearch_title']->value)) && $_smarty_tpl->tpl_vars['presearch_title']->value == '') && (!(isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addtype'])) && $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addtype'] == '')) {?>mt-xl-1 mt-0<?php }
}?> mb-2- mb-xl-0 px-2 px-md-2 px-xl-0-">
		<?php if (cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD') {?>
			<?php if ((isset($_smarty_tpl->tpl_vars['presearch_title']->value)) && $_smarty_tpl->tpl_vars['presearch_title']->value != '') {?>
				<h1 class="te-search-property-title te-font-family mt-xl-2 pt-1 pt-md-0 mb-0 txt-heading heading_txt_color col-sm-6 col-lg-6 d-none d-sm-block heading-font heading-truncate- mr-auto"><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['presearch_title']->value);?>
</h1>
			<?php } elseif ((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addtype'])) && $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addtype'] == 'cs') {?>
								<h1 class="te-search-property-title te-font-family mt-xl-2 pt-1 pt-md-0 mb-0 txt-heading heading_txt_color col-sm-6 col-lg-4 d-none d-sm-block heading-font heading-truncate- mr-auto"><?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['addval'];?>
 Real Estate & Homes For Sale</h1>
			<?php }?>
		<?php }?>
		<?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && (isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>
			<div class="col-auto <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?>order-1<?php }?> align-self-center px-2 d-none d-lg-block">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrPreQuickSorting']->value, 'qsortitem', false, 'qsortkey', 'quicksort', array (
));
$_smarty_tpl->tpl_vars['qsortitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['qsortkey']->value => $_smarty_tpl->tpl_vars['qsortitem']->value) {
$_smarty_tpl->tpl_vars['qsortitem']->do_else = false;
?>
					<a href="javascript::void(0);" class="link-color link-hover preqsort te-font-weight-600 pr-3" data-value="<?php echo $_smarty_tpl->tpl_vars['qsortkey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['qsortitem']->value;?>
</a>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</div>
		<?php }?>
				<div class=" <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && ($_smarty_tpl->tpl_vars['device']->value != 'XS' && $_smarty_tpl->tpl_vars['device']->value != 'SM' && $_smarty_tpl->tpl_vars['device']->value != 'MD')) {?>order-2 text-right <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>col-auto <?php } else { ?> col-xl-7 col-lg-3 <?php }?> <?php } else { ?> col-5  mt-1 col-xl-3 col-lg-3 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?>order-sm-3 col-sm-2 <?php }?> <?php }?> align-self-center px-3 px-md-2 px-xl-2 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && (isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?> text-xl-right <?php } else { ?> text-xl-left <?php }?>">
			<h5 class="font-weight-bold te-font-weight-500 text-dark my-0 te-search-result-count pb-0 txt-heading-"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['total_record']->value);?>
 Results</h5>
		</div>
		<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
			<div class="col-2 d-block- d-xl-none align-self-center mt-1 px-2  <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>d-none d-sm-block<?php } else { ?> d-block <?php }?>">
				<div class="custom-control custom-switch te-width-max-content- d-xl-none d-inline-block te-map-switch float-right"  data-target="#te-map-modal">
					<input type="checkbox" class="custom-control-input" id="toggle-trigger">
					<label class="custom-control-label" for="toggle-trigger">Map</label>
				</div>
			</div>
		<?php }?>
		
		<?php if ((isset($_smarty_tpl->tpl_vars['issorting']->value)) && $_smarty_tpl->tpl_vars['issorting']->value == 'true') {?>
			<div class="<?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?> col-auto <?php } else { ?> col-5 col-sm-2 col-xl-8 text-right mt-xl-2- mt-1- oreder-2 <?php }
if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && ($_smarty_tpl->tpl_vars['device']->value != 'XS' && $_smarty_tpl->tpl_vars['device']->value != 'SM' && $_smarty_tpl->tpl_vars['device']->value != 'MD')) {?>order-2 text-right <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>col-auto <?php } else { ?> col-xl-5 <?php }?>   <?php }?> align-self-center px-2">
				<div class="dropdown te-width-max-content d-inline-block pr-md-2">
					<button class="btn dropdown-toggle  bg-transparent border-0 shadow-none font-weight-bold- te-font-weight-600 te-sort-by" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Sort By
					</button>
					<div class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrSortingOption']->value, 'sortitem', false, 'sortkey', 'SortingOption', array (
));
$_smarty_tpl->tpl_vars['sortitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['sortkey']->value => $_smarty_tpl->tpl_vars['sortitem']->value) {
$_smarty_tpl->tpl_vars['sortitem']->do_else = false;
?>
							<a class="dropdown-item fsort <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['so'])) && (($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['so']).('|')).($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['sd']) == $_smarty_tpl->tpl_vars['sortkey']->value) {?>active<?php }?>" href="javascript:void(0);" data-value="<?php echo $_smarty_tpl->tpl_vars['sortkey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['sortitem']->value;?>
</a>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</div>
				</div>
			</div>
		<?php }?>
			</div>
	<?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && ($_smarty_tpl->tpl_vars['device']->value != 'XS' && $_smarty_tpl->tpl_vars['device']->value != 'SM' && $_smarty_tpl->tpl_vars['device']->value != 'MD')) {?></div></div><?php }
}?>
<div class="<?php if ((!(isset($_smarty_tpl->tpl_vars['isstyle']->value)) || ((isset($_smarty_tpl->tpl_vars['isstyle']->value)) && ($_smarty_tpl->tpl_vars['isstyle']->value == false || $_smarty_tpl->tpl_vars['isstyle']->value == 4 || $_smarty_tpl->tpl_vars['isstyle']->value == 6 || $_smarty_tpl->tpl_vars['isstyle']->value == 5 || $_smarty_tpl->tpl_vars['isstyle']->value == 10))) || (!(isset($_smarty_tpl->tpl_vars['isGrid']->value)) || ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'false' && ((isset($_smarty_tpl->tpl_vars['isstyle']->value)) && ($_smarty_tpl->tpl_vars['isstyle']->value !== false))))) {?>row <?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['isstyle']->value)) && ($_smarty_tpl->tpl_vars['isstyle']->value == 4 || $_smarty_tpl->tpl_vars['isstyle']->value == 5 || $_smarty_tpl->tpl_vars['isstyle']->value == 6) || ($_smarty_tpl->tpl_vars['isstyle']->value == 10 && $_smarty_tpl->tpl_vars['device']->value == 'MD' && $_smarty_tpl->tpl_vars['device']->value != 'XS' && $_smarty_tpl->tpl_vars['device']->value != 'SM')) {?>px-4<?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && $_smarty_tpl->tpl_vars['isstyle']->value == '') {?> px-xl-3 px-2 px-md-3 <?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['predefinedId']->value)) && $_smarty_tpl->tpl_vars['predefinedId']->value != '' && (isset($_smarty_tpl->tpl_vars['isstyle']->value)) && $_smarty_tpl->tpl_vars['isstyle']->value != '') {?> pms-listing-result-<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
 <?php } else { ?> pms-listing-result <?php }?>">

</div>
<?php if (!(isset($_smarty_tpl->tpl_vars['isstyle']->value)) || ((isset($_smarty_tpl->tpl_vars['isstyle']->value)) && $_smarty_tpl->tpl_vars['isstyle']->value != 1 && $_smarty_tpl->tpl_vars['isstyle']->value != 2 && $_smarty_tpl->tpl_vars['isstyle']->value != 3 && $_smarty_tpl->tpl_vars['isstyle']->value != 4 && $_smarty_tpl->tpl_vars['isstyle']->value != 7 && $_smarty_tpl->tpl_vars['isstyle']->value != 8 && $_smarty_tpl->tpl_vars['isstyle']->value != 9 && $_smarty_tpl->tpl_vars['isstyle']->value != 11 && $_smarty_tpl->tpl_vars['isstyle']->value != 12) || ((isset($_smarty_tpl->tpl_vars['isstyle']->value)) && $_smarty_tpl->tpl_vars['isstyle']->value == 5 && $_smarty_tpl->tpl_vars['page_size']->value >= 10) || ((isset($_smarty_tpl->tpl_vars['isstyle']->value)) && $_smarty_tpl->tpl_vars['isstyle']->value == 6 && $_smarty_tpl->tpl_vars['page_size']->value >= 10)) {?>
	<div class="row py-2">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-2- <?php if ($_smarty_tpl->tpl_vars['isstyle']->value == 10) {?> style-10 px-xl-2 <?php }?>">
			<nav aria-label="...">
				<?php if ($_smarty_tpl->tpl_vars['total_record']->value > $_smarty_tpl->tpl_vars['page_size']->value) {?>
					<ul id="pms-area-pager" class="pagination mb-0<?php if ($_smarty_tpl->tpl_vars['isstyle']->value == 10) {?> p-0 <?php }?>">

					</ul>
				<?php }?>
			</nav>
		</div>
	</div>

	<?php if ((isset($_smarty_tpl->tpl_vars['is_rental']->value)) && $_smarty_tpl->tpl_vars['is_rental']->value == false && (isset($_smarty_tpl->tpl_vars['psearch_generate_rental']->value)) && $_smarty_tpl->tpl_vars['psearch_generate_rental']->value == 'Yes') {?>
		<div class="row pt-2 pb-4">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center pms-market-report">
				<?php if ((isset($_smarty_tpl->tpl_vars['psearch_generate_rental']->value)) && $_smarty_tpl->tpl_vars['psearch_generate_rental']->value == 'Yes') {?>
					<div class=" no-data-msg text-center  d-inline-block">
						<a class="btn btn-primary p-3" href="<?php echo $_smarty_tpl->tpl_vars['rental_url']->value;?>
"> View Rentals</a>
					</div>
					<input type="hidden" name="rental" value="true" id="prenatl">
				<?php }?>
			</div>
		</div>
	<?php }
}?>
<input type="hidden" id="cur-page" value="<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
">
<input type="hidden" class="pid" id="pid" name="pid" value="<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
">
<?php if ((isset($_smarty_tpl->tpl_vars['predefinedId']->value)) && $_smarty_tpl->tpl_vars['predefinedId']->value != '' && (isset($_smarty_tpl->tpl_vars['isstyle']->value)) && $_smarty_tpl->tpl_vars['isstyle']->value != '') {?>
    <input type="hidden" class="json" id="json_<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
" name="json_<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['jsonMapData']->value;?>
" data-pid="<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
">
	<input type="hidden" class="json_css" id="css_<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
" name="json_css" value="<?php echo $_smarty_tpl->tpl_vars['attr']->value['css'];?>
" data-pid="css_<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
">
	<input type="hidden" class="json_title" id="title_<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
" name="json_title" value="<?php echo $_smarty_tpl->tpl_vars['attr']->value['title'];?>
" data-pid="title_<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
">
	<input type="hidden" class="json_bg" id="bg_<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
" name="json_bg" value="<?php echo $_smarty_tpl->tpl_vars['attr']->value['background'];?>
" data-pid="bg_<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
">
	<input type="hidden" class="json_url" id="url_<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
" name="json_url" value="<?php echo $_smarty_tpl->tpl_vars['attr']->value['url'];?>
" data-pid="url_<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
">
<?php }?>
<input type="hidden" name="OnPage" id="OnPage" value="SearchResult"/>
<?php }
}
