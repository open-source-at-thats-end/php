<?php
/* Smarty version 4.2.1, created on 2024-01-31 00:20:24
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/sales.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_65b9e6a857d0d3_05457439',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '27194cedbe265718debc0a0714674e74e7197497' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/sales.tpl',
      1 => 1706682018,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65b9e6a857d0d3_05457439 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/modifier.capitalize.php','function'=>'smarty_modifier_capitalize',),2=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/function.math.php','function'=>'smarty_function_math',),));
?>
<section class="pb-5 te-font-family">
	<div class="container-fluid btn-gray">
		<div class="row">
			<div class="container btn-gray con-mar te-market-report-container px-xl-0 px-md-4 px-2">
				<div class="row test">
					<div class="col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12 offset-xl-1">
						<div class="row te-search-filter-row- justify-content-between pre-filter-line pb-sm-2 pb-md-2 p-md-0 m-md-0 btn-align btn-gray pl-xl-3- customize-market-design <?php if (cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD') {?>border-btm<?php }?>">
							<div class=" col-xl-9 col-lg-9 col-md-9 col-sm-10 col-11 px-2 px-sm-3 px-md-2 px-0 text-lg-left text-xl-left text-md-left align-self-center text-center- py-2 pt-sm-2 pb-sm-0 pt-xl-2 pb-md-0 ">
								<a href="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo str_replace(' ','-',$_smarty_tpl->tpl_vars['pre_search']->value['psearch_title']);?>
" class="btn btn-sm font-size-sm-12 font-size-sm-10 te-font-size-13  shadow-none p-lg-2 p-xl-2 px-1 te-pre-saveser rounded-0  "><i class="fa fa-th pr-md-1 pr-0 <?php if (cw::$screen == 'XS') {?> fa-1x <?php } else { ?> fa-2x <?php }?> align-middle"></i> GRID VIEW</a>
								<a href="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_SALES;?>
/<?php echo str_replace(' ','-',$_smarty_tpl->tpl_vars['pre_search']->value['psearch_title']);?>
" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-13  shadow-none p-lg-2 p-xl-2 px-1 te-pre-saveser rounded-0 "><i class="fa fa-list pr-md-1 pr-0 <?php if (cw::$screen == 'XS') {?> fa-1x <?php } else { ?> fa-2x <?php }?> align-middle"></i> LIST VIEW</a>
								<a href="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_RENTALS;?>
/<?php echo str_replace(' ','-',$_smarty_tpl->tpl_vars['pre_search']->value['psearch_title']);?>
" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-13  shadow-none p-lg-2 p-xl-2 px-1 te-pre-saveser rounded-0 "><i class="fa fa-list pr-md-1 pr-0 <?php if (cw::$screen == 'XS') {?> fa-1x <?php } else { ?> fa-2x <?php }?> align-middle"></i> RENTALS</a>
								<a href="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_SOLD;?>
/<?php echo str_replace(' ','-',$_smarty_tpl->tpl_vars['pre_search']->value['psearch_title']);?>
" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-13  shadow-none p-lg-2 p-xl-2 px-1 te-pre-saveser rounded-0 "><i class="fa fa-list pr-md-1 pr-0 <?php if (cw::$screen == 'XS') {?> fa-1x <?php } else { ?> fa-2x <?php }?> align-middle"></i> PAST SALES </a>
															</div>
							<div class="col-1 col-sm-2 col-xl-3 col-lg-3 col-md-3 px-0 px-lg-0 pt-1 pt-sm-2 px-xl-2  text-center text-md-right">
								<div class="dropdown d-inline-block mx-1- mx-lg-0">
									<button class="btn btn-sm dropdown-toggle- font-size-sm-12 te-font-size-13 te-btn- text-white- shadow-none p-lg-2 p-xl-2 px-1 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt-" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-share-alt fa-2x align-middle pr-2"></i><span class="d-none d-sm-inline d-md-none d-lg-inline">Share</span>
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
										<a class="dropdown-item font-size-14 py-1" href="mailto:?subject=Share <?php if ((isset($_smarty_tpl->tpl_vars['pre_search']->value['psearch_title'])) && $_smarty_tpl->tpl_vars['pre_search']->value['psearch_title'] != '') {
echo $_smarty_tpl->tpl_vars['pre_search']->value['psearch_title'];
}?>&body=<?php echo $_smarty_tpl->tpl_vars['shareUrl']->value;?>
" target="_blank"><i class="fas fa-envelope pr-2 pr-2"></i> Email</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container con-mar te-market-report-container px-md-4 px-2">
		<div class="row">
			<div class="col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12 offset-xl-1">
				<?php if ((isset($_smarty_tpl->tpl_vars['arrRecord']->value)) && count($_smarty_tpl->tpl_vars['arrRecord']->value) > 0) {?>
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4">
							<h4 class="title-font text-left te-market-title txt-heading heading_txt_color"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['total_record']->value);?>
 <?php if ((isset($_smarty_tpl->tpl_vars['Action']->value)) && $_smarty_tpl->tpl_vars['Action']->value != Constants::TYPE_SOLD) {?>Total<?php }?> Units <?php if ((isset($_smarty_tpl->tpl_vars['Action']->value)) && $_smarty_tpl->tpl_vars['Action']->value == Constants::TYPE_SALES) {?>For Sale<?php } elseif ((isset($_smarty_tpl->tpl_vars['Action']->value)) && $_smarty_tpl->tpl_vars['Action']->value == Constants::TYPE_RENTALS) {?>For Rent<?php } else { ?>Sold<?php }?> - <?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['pre_search']->value['psearch_title']);?>
</h4>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
							<div class="table-responsive">
								<table class="table te-table-striped table-hover table-borderless mb-0">
									<thead class="te-bg-table">
										<tr>
											<th nowrap scope="col">Bedrooms</th>
											<th nowrap scope="col"># of Units</th>
											<th nowrap scope="col">Avg. $/SqFt</th>
											<th nowrap scope="col">Avg. Listing Price </th>
											<th nowrap scope="col">Avg. Days on Market</th>
											<th nowrap scope="col">Min Price</th>
										</tr>
									</thead>
									<tbody>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrRecord']->value, 'Record', false, 'key', 'arrRecord', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
										<?php $_smarty_tpl->_assignInScope('arrPrice', array_column($_smarty_tpl->tpl_vars['Record']->value,'ListPrice'));?>
										<?php $_smarty_tpl->_assignInScope('arrDOM', array_column($_smarty_tpl->tpl_vars['Record']->value,'DayOnMarket'));?>
										<?php $_smarty_tpl->_assignInScope('arrSQFT', array_column($_smarty_tpl->tpl_vars['Record']->value,'SQFT'));?>
										<tr>
											<td nowrap>

												<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 Bedroom Units
											</td>
											<td nowrap><?php echo count($_smarty_tpl->tpl_vars['Record']->value);?>
</td>
											<td nowrap class="">
												<?php if (((isset($_smarty_tpl->tpl_vars['arrPrice']->value)) && $_smarty_tpl->tpl_vars['arrPrice']->value > 0) && ((isset($_smarty_tpl->tpl_vars['arrSQFT']->value)) && $_smarty_tpl->tpl_vars['arrSQFT']->value > 0)) {
ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>array_sum($_smarty_tpl->tpl_vars['arrPrice']->value)/count($_smarty_tpl->tpl_vars['arrPrice']->value),'y'=>array_sum($_smarty_tpl->tpl_vars['arrSQFT']->value)/count($_smarty_tpl->tpl_vars['arrSQFT']->value)),$_smarty_tpl);
$_prefixVariable1 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable1);
}?>
												<?php if ($_smarty_tpl->tpl_vars['pripsqft']->value > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
											</td>
											<td nowrap>
												<?php $_smarty_tpl->_assignInScope('a', array_filter($_smarty_tpl->tpl_vars['arrPrice']->value));?>
												<?php $_smarty_tpl->_assignInScope('average', array_sum($_smarty_tpl->tpl_vars['a']->value)/count($_smarty_tpl->tpl_vars['a']->value));?>
												<?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['average']->value);?>
</td>
											<td nowrap>
												<?php $_smarty_tpl->_assignInScope('dom', array_filter($_smarty_tpl->tpl_vars['arrDOM']->value));?>
												<?php $_smarty_tpl->_assignInScope('avdom', array_sum($_smarty_tpl->tpl_vars['dom']->value)/count($_smarty_tpl->tpl_vars['dom']->value));?>
												<?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['avdom']->value,0);?>
</td>
											</td>
											<td nowrap>

												<?php $_smarty_tpl->_assignInScope('min_Price', min($_smarty_tpl->tpl_vars['arrPrice']->value));?>
												From <?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['min_Price']->value);?>

											</td>
										</tr>
									<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row ">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrRecord']->value, 'Record', false, 'key', 'arrRecord', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4">
								<h4 class="title-font text-left te-market-title txt-heading text-muted "><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 Bedroom In <?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['pre_search']->value['psearch_title']);?>
 - <?php if ((isset($_smarty_tpl->tpl_vars['Action']->value)) && $_smarty_tpl->tpl_vars['Action']->value == Constants::TYPE_SALES) {?>For Sale<?php } elseif ((isset($_smarty_tpl->tpl_vars['Action']->value)) && $_smarty_tpl->tpl_vars['Action']->value == Constants::TYPE_RENTALS) {?>For Rent<?php } else { ?>Units Sold<?php }?> - (<?php echo count($_smarty_tpl->tpl_vars['Record']->value);?>
)</h4>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
								<div class="table-responsive">
									<table class="table te-table-striped table-hover table-borderless mb-0">
										<thead class="te-bg-table">
										<?php if ((isset($_smarty_tpl->tpl_vars['Action']->value)) && $_smarty_tpl->tpl_vars['Action']->value == Constants::TYPE_SOLD) {?>
											<tr>
												<th nowrap scope="col">List Price</th>
												<th nowrap scope="col">Sale Price</th>
												<th nowrap scope="col">Closing Date</th>
												<th nowrap scope="col">Unit # </th>
												<th nowrap scope="col">MLS # </th>
												<th nowrap scope="col">Bed / Bath</th>
												<th nowrap scope="col">Living Area</th>
												<th nowrap scope="col">$/SqFt</th>
												<th nowrap scope="col">Days Listed</th>
											</tr>
										<?php } else { ?>
											<tr>
												<th nowrap scope="col">Details</th>
												<th nowrap scope="col">List Price</th>
												<th nowrap scope="col">Unit #</th>
												<th nowrap scope="col">MLS # </th>
												<th nowrap scope="col">Bed / Bath</th>
												<th nowrap scope="col">Living Area</th>
												<th nowrap scope="col">$/SqFt</th>
												<th nowrap scope="col">Days Listed</th>
											</tr>
										<?php }?>
										</thead>
										<tbody class="border-bottom">
										<?php if ((isset($_smarty_tpl->tpl_vars['Action']->value)) && $_smarty_tpl->tpl_vars['Action']->value == Constants::TYPE_SOLD) {?>
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Record']->value, 'subRecord', false, 'subkey', 'SubRecord', array (
));
$_smarty_tpl->tpl_vars['subRecord']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['subkey']->value => $_smarty_tpl->tpl_vars['subRecord']->value) {
$_smarty_tpl->tpl_vars['subRecord']->do_else = false;
?>
												<tr>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['subRecord']->value['ListPrice']);?>
</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['subRecord']->value['Sold_Price']);?>
</td>
													<td nowrap class=""><?php echo $_smarty_tpl->tpl_vars['subRecord']->value['Sold_Date'];?>
</td>
													<td nowrap class=""><?php echo $_smarty_tpl->tpl_vars['subRecord']->value['UnitNo'];?>
</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['subRecord']->value['MLS_NUM'];?>
</td>
													<td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['subRecord']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['subRecord']->value['BathsFull']);?>
</td>
													<td nowrap><?php if ($_smarty_tpl->tpl_vars['subRecord']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['subRecord']->value['SQFT']);
} else { ?>0<?php }?></td>
													<td nowrap>
                                                    	
														<?php if (((isset($_smarty_tpl->tpl_vars['subRecord']->value['ListPrice'])) && $_smarty_tpl->tpl_vars['subRecord']->value['ListPrice'] > 0) && ((isset($_smarty_tpl->tpl_vars['subRecord']->value['SQFT'])) && $_smarty_tpl->tpl_vars['subRecord']->value['SQFT'] > 0)) {
ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['subRecord']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['subRecord']->value['SQFT']),$_smarty_tpl);
$_prefixVariable2 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable2);
}?>
														<?php if ($_smarty_tpl->tpl_vars['subRecord']->value['SQFT'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
													</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['subRecord']->value['DayOnMarket'];?>
</td>
												</tr>
											<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
										<?php } else { ?>
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Record']->value, 'subRecord', false, 'subkey', 'SubRecord', array (
));
$_smarty_tpl->tpl_vars['subRecord']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['subkey']->value => $_smarty_tpl->tpl_vars['subRecord']->value) {
$_smarty_tpl->tpl_vars['subRecord']->do_else = false;
?>
												<tr>
													<td nowrap>

														<a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['subRecord']->value);?>
" class="text-dark"><h6 class="my-0 txt-heading text-primary"><i class="fa fa-info-circle" aria-hidden="true"></i> Details</h6></a>
													</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['subRecord']->value['ListPrice']);?>
</td>
													<td nowrap class=""><?php echo $_smarty_tpl->tpl_vars['subRecord']->value['UnitNo'];?>
</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['subRecord']->value['MLS_NUM'];?>
</td>
													<td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['subRecord']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['subRecord']->value['BathsFull']);?>
</td>
													<td nowrap><?php if ($_smarty_tpl->tpl_vars['subRecord']->value['SQFT'] > 0) {
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['subRecord']->value['SQFT']);
} else { ?>0<?php }?></td>
													<td nowrap>
														<?php if (((isset($_smarty_tpl->tpl_vars['subRecord']->value['ListPrice'])) && $_smarty_tpl->tpl_vars['subRecord']->value['ListPrice'] > 0) && ((isset($_smarty_tpl->tpl_vars['subRecord']->value['SQFT'])) && $_smarty_tpl->tpl_vars['subRecord']->value['SQFT'] > 0)) {
ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['subRecord']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['subRecord']->value['SQFT']),$_smarty_tpl);
$_prefixVariable3 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable3);
}?>
														<?php if ($_smarty_tpl->tpl_vars['subRecord']->value['SQFT'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?>
													</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['subRecord']->value['DayOnMarket'];?>
</td>
												</tr>
											<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
										<?php }?>
										</tbody>
									</table>
								</div>
							</div>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</div>
					<?php if ((isset($_smarty_tpl->tpl_vars['Action']->value)) && $_smarty_tpl->tpl_vars['Action']->value != Constants::TYPE_SOLD) {?>
						<div class="row pt-4">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 pt-md-0 pt-4">
								<h4 class="title-font text-left te-market-title txt-heading heading_txt_color border-bottom pb-3">New Listings</h4>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['new_prop']->value, 'Record', false, 'key', 'new_prop', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
									<p class="pt-2">
										<a class="text-primary" href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
"> Unit <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>
 <?php if ((isset($_smarty_tpl->tpl_vars['Action']->value)) && $_smarty_tpl->tpl_vars['Action']->value == Constants::TYPE_SALES) {?>For Sale<?php } else { ?>For Rent<?php }?> at <?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 listed <?php echo $_smarty_tpl->tpl_vars['Record']->value['DayOnMarket'];?>
 days ago.</a>
									</p>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 -pr-0 pt-md-0 pt-3">
								<h4 class="title-font text-left te-market-title txt-heading heading_txt_color border-bottom pb-3">Recently Reduced</h4>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['recent_reduce']->value, 'Record', false, 'key', 'recent_reduce', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
									<?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] < 0) {?>
										<p class="pt-2">
											<a class="text-dark" href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
"> Unit <?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];?>
 <?php if ((isset($_smarty_tpl->tpl_vars['Action']->value)) && $_smarty_tpl->tpl_vars['Action']->value == Constants::TYPE_SALES) {?>For Sale<?php } else { ?>For Rent<?php }?> at <?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
 Reduced by (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%) </a>
										</p>
									<?php }?>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</div>
						</div>
					<?php }?>
				<?php } else { ?>

				<div class="col-12 no-data-msg text-center- text-danger n-result pt-3- px-0 mt-3">
											<div class="no-result py-2 px-2">No listings were found matching your search criteria. Contact us for off-market listings that may be available or coming soon.</div>
				</div>
				<?php }?>
			</div>
		</div>
	</div>
</section><?php }
}
