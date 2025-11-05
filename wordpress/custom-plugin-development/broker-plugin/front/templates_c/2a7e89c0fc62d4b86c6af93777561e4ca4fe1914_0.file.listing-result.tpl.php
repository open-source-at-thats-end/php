<?php
/* Smarty version 4.2.1, created on 2023-08-10 07:08:40
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/listing-result.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64d4d348854b37_29997060',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2a7e89c0fc62d4b86c6af93777561e4ca4fe1914' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/listing-result.tpl',
      1 => 1670595700,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:listing/mobile-device-search-form.tpl' => 1,
    'file:listing/map-view.tpl' => 1,
  ),
),false)) {
function content_64d4d348854b37_29997060 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/function.html_options.php','function'=>'smarty_function_html_options',),));
if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && (isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value != 'true') {?>
    <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && ((isset($_smarty_tpl->tpl_vars['isFilter']->value)) && $_smarty_tpl->tpl_vars['isFilter']->value !== 'false') || ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'Yes' && (isset($_smarty_tpl->tpl_vars['tabs']->value)) && $_smarty_tpl->tpl_vars['tabs']->value !== 'false')) {?>
        <div class="row te-search-filter-row- <?php if ($_smarty_tpl->tpl_vars['isstyle']->value == '') {?>justify-content-start btn-gray <?php } else { ?>justify-content-between<?php }?> pre-filter-line pb-2- pr-1- border-bottom- bg-white <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true' && (isset($_smarty_tpl->tpl_vars['isstyle']->value)) && ($_smarty_tpl->tpl_vars['isstyle']->value !== false)) {?> px-3 <?php }?> customize-ldesign <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && ($_smarty_tpl->tpl_vars['isPredefined']->value == 'true' || $_smarty_tpl->tpl_vars['isPredefined']->value == true)) {?>no-follow-link<?php }?>">
                <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'Yes' && (isset($_smarty_tpl->tpl_vars['tabs']->value)) && $_smarty_tpl->tpl_vars['tabs']->value !== 'false') {?>
            <div class="col-12 col-xl-8 col-lg-8  col-md-8  pl-md-2  pr-md-0  px-1 text-md-left text-center align-self-center btn-gray py-2 border-btm pl-xl-3">
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
            <?php if ($_smarty_tpl->tpl_vars['isstyle']->value == '') {?>
                <form class="form w-25 d-none d-lg-block d-xl-block pre-search py-1- <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?>pre-search-arrow <?php }?>" id="frmlistingsearch" role="form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['formAction']->value;?>
">
                    <div class="col-12 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>col-xl-8 col-lg-8<?php } else { ?>col-xl-12 col-lg-12<?php }?> col-md-12 pl-md-2  pr-md-0  px-1 py-3- pt-11- align-self-center- btn-gray d-none d-lg-flex align-items-center <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>d-xl-inline-flex justify-content-between- text-center h-100<?php }?>">
                        <div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap search-btn-hover d-inline-flex justify-content-around h-100 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>pr-xl-3 pr-lg-3 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>px-xl-3 <?php }
} else { ?>pr-xl-1 pr-lg-1 px-xl-5 px-0 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>col-4<?php }
}?> pr-1">
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
                        <div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap search-btn-hover d-inline-flex justify-content-around h-100 xl-beds <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>pr-xl-3 pr-lg-3 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>px-xl-3 <?php }
} else { ?>pr-xl-1 pr-lg-1 px-xl-5 px-0 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>col-4 <?php }
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
                        <div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap search-btn-hover d-inline-flex justify-content-around h-100 xl-beds <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>pr-3<?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?> px-xl-3 <?php }
} else { ?>pr-1 px-xl-5 px-0 <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == 'true') {?>col-4<?php }?> <?php }?> pl-0">
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
                    </div>
                </form>
            <?php } else { ?>
                <div class="col-12 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>col-xl-8 col-lg-8<?php } else { ?>col-xl-3 col-lg-3<?php }?> col-md-12 pl-md-2  pr-md-0  px-1 py-2 pt-11- align-self-center- btn-gray d-none d-lg-flex align-items-center">
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
        <?php }?>
        <div class="col-12 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>col-xl-4 col-lg-4 <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'No') {?>text-sm-right<?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?> justify-content-between- justify-content-sm-center font-size-sm-10 <?php if (cw::$screen !== 'XS') {?>p-unset<?php }?> justify-content-md-end px-xl-3 <?php }?> <?php } else { ?> justify-content-between- justify-content-sm-end- <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'Yes') {?> <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>col-xl-4 col-lg-4 <?php } else { ?> col-xl-12 col-lg-12 mt-lg-2 <?php }?> <?php } else { ?> <?php if ((isset($_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value)) && $_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value == 'No') {?> col-xl-3 col-lg-3 text-right <?php } else { ?> col-xl-9 col-lg-9 <?php }
}
}?>   px-1- px-md-0-  text-left <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'Yes') {?> btn-gray col-md-4 justify-content-between py-1 <?php } else { ?> btn-gray col-md-12 py-2 <?php }?>  pt-lg-0- pt-2- <?php if ((isset($_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value)) && $_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value == 'Yes') {?>d-flex<?php }?> d-md-inline-block  px-3 px-lg-2 <?php if ((isset($_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value)) && $_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value == 'No') {?>px-xl-5<?php } else { ?>px-xl-3<?php }?> py-xl-1 py-md-0- pb-2-  <?php if ((isset($_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value)) && $_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value == 'No') {
if (cw::$screen == 'XS' || cw::$screen == 'SM') {?>d-none<?php }
}?>">
            <?php if ((isset($_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value)) && $_smarty_tpl->tpl_vars['psearch_generate_mrktreport']->value == 'Yes') {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['marketReportURL']->value;?>
" class="btn btn-sm btn-primary- btn-market-insight text-primary align-self-center  <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'No') {?>font-size-sm-12<?php }?> te-font-size-13 font-size-sm-10 shadow-none p-1 p-lg-1 p-xl-2 px-2 <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>te-pre-saveser<?php } else { ?>font-tab text-sm-right text-lg-left- <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && (cw::$screen == 'MD' || cw::$screen == 'SM')) {?>col col-md-4- <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?> col-xl-auto <?php } else { ?> col-xl-auto- <?php }?> px-sm-3 <?php }?> <?php }?> rounded-0"><i class="fas fa-2x fa-poll text-dark pr-2 align-middle"></i><span class="d-none- d-sm-inline <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'Yes') {?>d-md-none<?php }?> d-lg-inline">Market Insights</span></a>
            <?php }?>
            <div class="dropdown d-inline-block mx-1- mx-lg-0- align-self-center  <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && (isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true' && (cw::$screen == 'MD' || cw::$screen == 'SM')) {?> col-md-auto- col-xl-auto- px-sm-3<?php }?>">
                <button id="share-btn" class="btn btn-sm dropdown-toggle  <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value == 'true') {?>f-tab btn-gray- <?php } else { ?>font-tab dropdown-block <?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'No') {?> font-size-sm-10 font-size-sm-12  <?php } else { ?>te-btn- text-white- <?php }?> te-font-size-12- te-btn- text-white- shadow-none p-lg-2 px-xl-3 px-2 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt-" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-share-alt fa-2x align-middle pr-2"></i><span class="d-none- d-sm-inline- <?php if ((isset($_smarty_tpl->tpl_vars['psearch_display_tab']->value)) && $_smarty_tpl->tpl_vars['psearch_display_tab']->value == 'Yes') {?>d-md-none<?php }?> d-lg-inline">Share</span>
                </button>
                <div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u=<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" target="_blank"><i class="fab fa-facebook-f pr-2-"></i> Facebook</a>
                    <a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url=<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" target="_blank"><i class="fab fa-twitter pr-1-"></i> Twitter</a>
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
            <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
                <div class="pre-map-toggle <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && ($_smarty_tpl->tpl_vars['device']->value != 'XS' && $_smarty_tpl->tpl_vars['device']->value != 'SM' && $_smarty_tpl->tpl_vars['device']->value != 'MD')) {?>order-1 mt-1 py-1 <?php } else { ?>col-xl-1 mt-2- float-right py-0 <?php }?>align-self-center custom-control custom-switch te-width-max-content- d-xl-block- d-none te-map-switch-grid d-lg-inline-flex mx-5-" data-toggle="modal" data-target="#te-map-modal">
                    <input type="checkbox" class="custom-control-input" id="toggle-trigger-grid" name="toggle-trigger-grid" <?php if ((isset($_smarty_tpl->tpl_vars['is_map']->value)) && $_smarty_tpl->tpl_vars['is_map']->value == 'true') {?>checked<?php }?>>
                    <label class="custom-control-label font-tab te-font-weight-500" for="toggle-trigger-grid">Map</label>
                </div>
            <?php }?>
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
}?>
<div class="wrapper te-search-result-wrapper pms-map-listing customize-ldesign <?php if ((isset($_smarty_tpl->tpl_vars['isstyle']->value)) && ($_smarty_tpl->tpl_vars['isstyle']->value !== false) && $_smarty_tpl->tpl_vars['isstyle']->value == 7) {?> slider-7<?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && ($_smarty_tpl->tpl_vars['isPredefined']->value == 'true' || $_smarty_tpl->tpl_vars['isPredefined']->value == true)) {?>no-follow-link<?php }?>">
    <section class="te-search-results-sec  p-0 <?php if ((isset($_smarty_tpl->tpl_vars['isstyle']->value)) && ($_smarty_tpl->tpl_vars['isstyle']->value !== false) && $_smarty_tpl->tpl_vars['isstyle']->value == 1) {?> slider-1<?php }?>">
        <div class="<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true' && $_smarty_tpl->tpl_vars['isstyle']->value != 9 && $_smarty_tpl->tpl_vars['isstyle']->value != 11 && $_smarty_tpl->tpl_vars['isstyle']->value != 12) {?>container-fluid<?php } elseif ((isset($_smarty_tpl->tpl_vars['isstyle']->value)) && ($_smarty_tpl->tpl_vars['isstyle']->value !== false) && $_smarty_tpl->tpl_vars['isstyle']->value != 9 && $_smarty_tpl->tpl_vars['isstyle']->value != 10 && $_smarty_tpl->tpl_vars['isstyle']->value != 11 && $_smarty_tpl->tpl_vars['isstyle']->value != 12) {?> con-style <?php } else { ?> <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && $_smarty_tpl->tpl_vars['isstyle']->value != 9 && $_smarty_tpl->tpl_vars['isstyle']->value != 10 && $_smarty_tpl->tpl_vars['isstyle']->value != 11) {?>container-fluid pt-0<?php } else { ?>container con-div p-xl-0 p-md-0 pt-0<?php }
}?>">
            <div class="row <?php if ((isset($_smarty_tpl->tpl_vars['isstyle']->value)) && ($_smarty_tpl->tpl_vars['isstyle']->value !== false) && ($_smarty_tpl->tpl_vars['isstyle']->value == 1 || $_smarty_tpl->tpl_vars['isstyle']->value == 7 || $_smarty_tpl->tpl_vars['isstyle']->value == 9)) {?> h-100<?php }?>">
                <?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>
                    <?php if (cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD') {?>
                        <div class="modal fade d-xl-none" id="te-map-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog mw-100 m-0 h-100" role="document">
                                <div class="modal-content h-100 rounded-0 border-0">
                                    <div class="modal-header position-fixed te-z-index-99 w-100">

                                        <button type="button" class="close bg-white" data-dismiss="modal" aria-label="Close" id="closeMap">
                                            <span class="text-secondary" aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div id="pms-area-map" class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 px-0 d-xl-block te-half-map-div order-2">
                                            <div id="pms-map" data-map='true'>

                                            </div>
                                            <div id="map-infobox-small" class="oeibSmall hide-me">
                                                <div class="ibContent"></div>
                                            </div>
                                            <div id="m-loader" class="hide-me-">
                                                <div><img src="<?php echo $_smarty_tpl->tpl_vars['TPL_images']->value;?>
/ajax-loader-small.gif"/>&nbsp;Loading...</div>
                                            </div>

                                            <div class="te-draw-radius-button position-absolute">
                                                <a id="btn_draw" class="btn bg-white text-dark text-uppercase rounded-0 border-0 shadow-none te-font-size-14 d-block py-2" href="JavaScript:void(0)" role="button">
                                                    <i class="fas fa-draw-polygon text-secondary te-icon-draw"></i><br>draw
                                                </a>
                                                <a id="btn_cir" class="btn bg-white text-dark text-uppercase rounded-0 border-0 shadow-none te-font-size-14 d-block py-2" href="JavaScript:void(0)" role="button">
                                                    <i class="far fa-dot-circle text-secondary te-icon-radius"></i><br>radius
                                                </a>
                                                <a class="btn bg-white- te-btn text-white- text-uppercase rounded-0 border-0 shadow-none te-font-size-14 py-2 d-none lpt-btn lpt-btn-txt" href="javascript:void(0);" id="btn_remove">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div id="pms-area-map" class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 px-0 visible-xl d-xl-block te-half-map-div order-2 d-none ">
                            <div id="pms-map" data-map='true'>

                            </div>
                            <div id="map-infobox-small" class="oeibSmall hide-me">
                                <div class="ibContent"></div>
                            </div>
                            <div id="m-loader" class="hide-me-">
                                <div><img src="<?php echo $_smarty_tpl->tpl_vars['TPL_images']->value;?>
/ajax-loader-small.gif"/>&nbsp;Loading...</div>
                            </div>

                            <div class=" te-draw-radius-button  position-absolute">
                                <a id="btn_draw" class="btn bg-white text-dark text-uppercase rounded-0 border-0 shadow-none te-font-size-14 d-block py-2" href="JavaScript:void(0)" role="button">
                                    <i class="fas fa-draw-polygon text-secondary te-icon-draw"></i><br>draw
                                </a>
                                <a id="btn_cir" class="btn bg-white text-dark text-uppercase rounded-0 border-0 shadow-none te-font-size-14 d-block py-2" href="JavaScript:void(0)" role="button">
                                    <i class="far fa-dot-circle text-secondary te-icon-radius"></i><br>radius
                                </a>
                                <a class="btn bg-white- te-btn text-white- text-uppercase rounded-0 border-0 shadow-none te-font-size-14 py-2 d-none lpt-btn lpt-btn-txt" href="javascript:void(0);" id="btn_remove">Reset</a>
                            </div>
                        </div>
                    <?php }?>
                <?php }?>

                <div id="pms-area-listing" class="<?php if ((isset($_smarty_tpl->tpl_vars['isGrid']->value)) && $_smarty_tpl->tpl_vars['isGrid']->value !== 'true') {?>col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 te-featured-properties  <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true && !(isset($_smarty_tpl->tpl_vars['isstyle']->value))) {?>px-3<?php } else { ?>px-2<?php }?> pb-0 pb-xl-2 te-search-results-properties <?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?>order-1 <?php } else { ?> pt-0 pt-xl-1 order-1 px-md-4 <?php }
} else { ?>col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 te-featured-properties px-3 <?php if ((isset($_smarty_tpl->tpl_vars['isstyle']->value)) && ($_smarty_tpl->tpl_vars['isstyle']->value !== false) && ($_smarty_tpl->tpl_vars['isstyle']->value == 1 || $_smarty_tpl->tpl_vars['isstyle']->value == 3 || $_smarty_tpl->tpl_vars['isstyle']->value == 2)) {?>py-0<?php } else {
if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value)) && $_smarty_tpl->tpl_vars['isPredefined']->value == true) {?>pb-3 <?php } else { ?>py-3<?php }
}?> mw-100 te-mls-property-embedding h-auto<?php }?> <?php if ($_smarty_tpl->tpl_vars['isstyle']->value == 10) {?> py-5 <?php }?>">
                    <?php $_smarty_tpl->_subTemplateRender('file:listing/map-view.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('device'=>cw::$screen), 0, false);
?>
                </div>
            </div>
        </div>
    </section>
</div>
<form id="pms-form-filter" method="post">
    <input type="hidden" id="so" name="so" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['so'] ?? null)===null||$tmp==='' ? 'price' ?? null : $tmp);?>
">
    <input type="hidden" id="sd" name="sd" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['sd'] ?? null)===null||$tmp==='' ? 'asc' ?? null : $tmp);?>
">
    <input type="hidden" name="page_size" id="page_size" value="<?php echo $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['page_size'];?>
" data-type="hidden"/>
    <input type="hidden" id="MapZoomLevel" name="mz" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['mz'] ?? null)===null||$tmp==='' ? 13 ?? null : $tmp);?>
">
    <input type="hidden" id="MapCenterLat" name="clat" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['clat'] ?? null)===null||$tmp==='' ? 25.761681 ?? null : $tmp);?>
">
    <input type="hidden" id="MapCenterLng" name="clng" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['clng'] ?? null)===null||$tmp==='' ? -80.191788 ?? null : $tmp);?>
">
        <input type="hidden" id="poly" name="poly" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['poly'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
    <input type="hidden" id="cir" name="cir" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['cir'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
    <input type="hidden" id="is_map" name="is_map" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['is_map']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">

</form>
<?php echo '<script'; ?>
 type="text/javascript">
    var mapZoomLevel 	= <?php echo $_smarty_tpl->tpl_vars['mapZoomLevel']->value;?>
;
    var mapCenterLat 	= <?php echo $_smarty_tpl->tpl_vars['mapCenterLat']->value;?>
;
    var mapCenterLng 	= <?php echo $_smarty_tpl->tpl_vars['mapCenterLng']->value;?>
;
    var jsonMapData		= '<?php echo $_smarty_tpl->tpl_vars['jsonMapData']->value;?>
';
    var Site_Url	    = '<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;?>
';
    var currency	    = '<?php echo $_smarty_tpl->tpl_vars['currency']->value;?>
';
    var total_record	= '<?php echo $_smarty_tpl->tpl_vars['total_record']->value;?>
';
    var page_size	    = '<?php echo $_smarty_tpl->tpl_vars['page_size']->value;?>
';
    var page	        = '<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
';
    var URL	            = '<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
';
    var isUserLoggedIn	= '<?php echo $_smarty_tpl->tpl_vars['isUserLoggedIn']->value;?>
';
    var memberDetail	= '<?php echo $_smarty_tpl->tpl_vars['memberDetail']->value;?>
';
    var user_id	        = '<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
';
    var issorting	    = '<?php echo $_smarty_tpl->tpl_vars['issorting']->value;?>
';
    var isFilter	    = '<?php echo $_smarty_tpl->tpl_vars['isFilter']->value;?>
';
    var sys_name	    = '<?php echo $_smarty_tpl->tpl_vars['sys_name']->value;?>
';
    var isRental	    = '<?php echo $_smarty_tpl->tpl_vars['is_rental']->value;?>
';
    var isHeading	    = '<?php echo $_smarty_tpl->tpl_vars['isHeading']->value;?>
';
    var issavesearch	= '<?php echo $_smarty_tpl->tpl_vars['issavesearch']->value;?>
';
    var isGrid	        = '<?php echo $_smarty_tpl->tpl_vars['isGrid']->value;?>
';
    var predefinedId	= '<?php echo $_smarty_tpl->tpl_vars['predefinedId']->value;?>
';
    var arrSearchCriteria            = '<?php echo json_encode($_smarty_tpl->tpl_vars['arrSearchCriteria']->value);?>
';
    var userFavList	    = '<?php if ((isset($_smarty_tpl->tpl_vars['userFavList']->value)) && is_array($_smarty_tpl->tpl_vars['userFavList']->value)) {
echo ucwords(mb_strtolower(implode($_smarty_tpl->tpl_vars['userFavList']->value,','), 'UTF-8'));
} else {
echo (($tmp = $_smarty_tpl->tpl_vars['userFavList']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);
}?>';
    var isPredefined    = '<?php if ((isset($_smarty_tpl->tpl_vars['isPredefined']->value))) {
echo $_smarty_tpl->tpl_vars['isPredefined']->value;
}?>';
    var isstyle         = '<?php if ((isset($_smarty_tpl->tpl_vars['isstyle']->value))) {
echo $_smarty_tpl->tpl_vars['isstyle']->value;
}?>';
    if(isstyle == 8 || isstyle == 9)
        {
            var view_page_url = '<?php echo $_smarty_tpl->tpl_vars['view_page_url']->value;?>
'
        }
    //var isMap	        = '<?php echo $_smarty_tpl->tpl_vars['isMap']->value;?>
';
    //var disclaimer      = '<?php echo $_smarty_tpl->tpl_vars['disclaimer']->value;?>
';
    var tabs            = '<?php echo $_smarty_tpl->tpl_vars['tabs']->value;?>
';
    var ViewURL            = '<?php echo $_smarty_tpl->tpl_vars['ViewURL']->value;?>
';
    if(isstyle == 12)
    {
        var CustomCSS   = '<?php echo $_smarty_tpl->tpl_vars['CustomCSS']->value;?>
';
        var CustomTitle   = '<?php echo $_smarty_tpl->tpl_vars['CustomTitle']->value;?>
';
        var Background   = '<?php echo $_smarty_tpl->tpl_vars['Background']->value;?>
';
    }
    var login_enable    = '<?php echo $_smarty_tpl->tpl_vars['login_enable']->value;?>
';
    var bitcoin         = '<?php echo $_smarty_tpl->tpl_vars['bitcoin']->value;?>
';
    var etherium        = '<?php echo $_smarty_tpl->tpl_vars['etherium']->value;?>
';
    var cardano         = '<?php echo $_smarty_tpl->tpl_vars['cardano']->value;?>
';
    var rel         = '<?php echo $_smarty_tpl->tpl_vars['rel']->value;?>
';
                if(rel !='' && rel !=undefined){
                 setTimeout(function () {
                    jQuery('.no-follow-link a').attr('rel',rel);
                 }, 500);
                }
    var maxViewedExceed 	= '<?php echo $_smarty_tpl->tpl_vars['maxViewedExceed']->value;?>
';
    var maxViewedExceedCount 	= '<?php echo $_smarty_tpl->tpl_vars['arrConfig']->value['Listing']['site_max_viewed_without_login'];?>
';
    var isloginReq 	= '<?php echo $_smarty_tpl->tpl_vars['isloginReq']->value;?>
';

<?php echo '</script'; ?>
><?php }
}
