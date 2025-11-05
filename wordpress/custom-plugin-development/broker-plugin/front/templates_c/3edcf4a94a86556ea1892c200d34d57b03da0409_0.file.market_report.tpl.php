<?php
/* Smarty version 4.2.1, created on 2023-08-10 08:43:00
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/market_report.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64d4e964e5d402_72218516',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3edcf4a94a86556ea1892c200d34d57b03da0409' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/market_report.tpl',
      1 => 1668793292,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64d4e964e5d402_72218516 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/function.math.php','function'=>'smarty_function_math',),));
?>
<section id="te-market-report-container" class="py-5 px-xl-5 te-font-family">
	<div class="container-fluid con-mar- te-market-report-container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 offset-xl-1-">
				<?php if (is_array($_smarty_tpl->tpl_vars['statistic']->value) && count($_smarty_tpl->tpl_vars['statistic']->value) > 0) {?>
					<div class="row py-2">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-1 te-market-report-title">
							<h4 class="te-market-title txt-heading heading_txt_color">Market Insights for <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h4>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 te-closed-sales-as text-left">
							<p class="text-dark mb-0 te-font-size-14">As of <?php echo $_smarty_tpl->tpl_vars['TodayDate']->value;?>
</p>
						</div>
					</div>
					<div class="row pt-3 market-statistics text-dark">
						<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pt-1 pr-xl-3">
							<h3 class="title-font text-left te-market-title- text-border-bottom pt-4 pb-3">For Sale</h3>
							<ul class="p-0 pt-3">
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Active For Sale</span><span class="font-weight-bold"><?php echo $_smarty_tpl->tpl_vars['statistic']->value['statistic_total_active_listing'];?>
</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price</span><span class="font-weight-bold"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_active_price']);?>
</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price / Sqft</span><span class="font-weight-bold"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_active_price_sqft']);?>
</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Days on Market</span><span class="font-weight-bold"><?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_active_dom']) {
echo $_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_active_dom'];
} else { ?>-<?php }?></span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Reduction</span><span class="font-weight-bold <?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_price_diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_price_reduction']);?>
 </span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Increase</span><span class="font-weight-bold <?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_price_diff_increase'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_price_increase']);?>
 </span></li>

															</ul>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pt-1 px-xl-3">
							<h3 class="title-font text-left te-market-title- text-border-bottom pt-4 pb-3">Pending Sales</h3>
							<ul class="p-0 pt-3">
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Pending For Sale</span><span class="font-weight-bold"><?php echo $_smarty_tpl->tpl_vars['statistic']->value['statistic_total_pending_listing'];?>
</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price</span><span class="font-weight-bold"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_pending_price']);?>
</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price / Sqft</span><span class="font-weight-bold"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_pending_price_sqft']);?>
</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Days on Market</span><span class="font-weight-bold"><?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_pending_dom'] > 0) {
echo $_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_pending_dom'];
} else { ?>-<?php }?></span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Reduction</span><span class="font-weight-bold <?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_pending_price_diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_pending_largest_price_reduction']);?>
 </span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Increase</span><span class="font-weight-bold <?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_pending_price_diff_increase'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_pending_largest_price_increase']);?>
 </span></li>

															</ul>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pt-1 pl-xl-3">
							<h3 class="title-font text-left te-market-title- text-border-bottom pt-4 pb-3">Closed Sales</h3>
							<ul class="p-0 pt-3">
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Sold (Last 180 Days)</span><span class="font-weight-bold"><?php echo $_smarty_tpl->tpl_vars['statistic']->value['statistic_sixmon_tot_sold_listing'];?>
</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price</span><span class="font-weight-bold"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_six_month_avg_sold_price']);?>
</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price / Sqft</span><span class="font-weight-bold"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_six_month_avg_sold_price_sqft']);?>
</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Days on Market</span><span class="font-weight-bold"><?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_six_month_avg_sold_dom'] > 0) {
echo $_smarty_tpl->tpl_vars['statistic']->value['statistic_six_month_avg_sold_dom'];
} else { ?>-<?php }?></span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Reduction</span><span class="font-weight-bold <?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_sold_price_diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_six_month_sold_largest_price_reduction']);?>
 </span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Increase</span><span class="font-weight-bold <?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_sold_price_diff_increase'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_six_month_sold_largest_price_increase']);?>
 </span></li>

															</ul>
						</div>
					</div>
					<div id="list-view" class="row pt-5">

						<?php if (is_array($_smarty_tpl->tpl_vars['recent_sales']->value) && count($_smarty_tpl->tpl_vars['recent_sales']->value) > 0) {?>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
								<h4 class="title-font text-left te-market-title text-border-bottom txt-heading heading_txt_color pb-4">Recent Sales</h4>
								<div class="table-responsive pt-4">
									<table class="table te-table-striped- table-hover mb-0">
										<thead>
											<tr class="text-center te-font-size-14">
												<th nowrap scope="col" class="border">Address</th>
												<th nowrap scope="col" class="border">Closed Price</th>
												<th nowrap scope="col" class="border">List Price</th>
												<th nowrap scope="col" class="border">Price Change</th>
												<th nowrap scope="col" class="border">Sq Ft</th>
												<th nowrap scope="col" class="border"><?php echo $_smarty_tpl->tpl_vars['currency']->value;?>
/Sq Ft</th>
												<th nowrap scope="col" class="border">Beds/Baths</th>
												<th nowrap scope="col" class="border">Closing Date</th>
											</tr>
										</thead>

										<tbody>

											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['recent_sales']->value, 'Record', false, NULL, 'recentSale', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>

												<tr class="text-center">
													<td nowrap>
														<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['StreetNumber'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'] != '' && (isset($_smarty_tpl->tpl_vars['Record']->value['StreetName'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetName'] != '') {?>
															<a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
" class="text-dark"><h6 class="my-0 txt-heading pb-0"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];
if ((isset($_smarty_tpl->tpl_vars['Record']->value['UnitNo'])) && $_smarty_tpl->tpl_vars['Record']->value['UnitNo'] != '') {?>, #<?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];
}?></h6></a>
															<small><?php echo $_smarty_tpl->tpl_vars['Record']->value['Subdivision'];?>
</small>
														<?php } else { ?>
															<a href="#" class="text-dark"><h6 class="my-0 txt-heading pb-0">Address Not Available</h6></a>
														<?php }?>
													</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);?>
</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
													<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['Sold_Price']),$_smarty_tpl);
$_prefixVariable1 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable1);?>
													<?php ob_start();
echo smarty_function_math(array('equation'=>"(z)*100*(a)/p",'z'=>$_smarty_tpl->tpl_vars['pricedef']->value,'p'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'a'=>-1),$_smarty_tpl);
$_prefixVariable2 = ob_get_clean();
$_smarty_tpl->_assignInScope('difference', $_prefixVariable2);?>

													<td nowrap class="<?php if ($_smarty_tpl->tpl_vars['difference']->value >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['difference']->value,2);?>
%)</td>
													<td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
</td>

													<?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>

														<?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['Sold_Price'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable3 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable3);?>
														<td nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);?>

															<?php } else { ?>0<?php }?></td>
													<?php } else { ?>
														<td nowrap>0</td>

													<?php }?>
													<td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['Sold_Date'];?>
</td>
												</tr>
											<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
										</tbody>
									</table>
								</div>
							</div>
						<?php }?>
						<?php if (is_array($_smarty_tpl->tpl_vars['rsPending']->value['rs']) && count($_smarty_tpl->tpl_vars['rsPending']->value['rs']) > 0) {?>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2 pt-5">
								<h4 class="title-font text-left te-market-title text-border-bottom txt-heading heading_txt_color pb-4">Pending Sales</h4>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
								<div class="table-responsive pt-4">
									<table class="table te-table-striped- table-hover mb-0">
										<thead>
											<tr class="text-center te-font-size-14">
												<th nowrap scope="col" class="border">Address</th>
												<th nowrap scope="col" class="border">List Price</th>
												<th nowrap scope="col" class="border">Price Change</th>
												<th nowrap scope="col" class="border">Sq Ft</th>
												<th nowrap scope="col" class="border"><?php echo $_smarty_tpl->tpl_vars['currency']->value;?>
/Sq Ft</th>
												<th nowrap scope="col" class="border">Beds/Baths</th>
												<th nowrap scope="col" class="border">Days Listed</th>
											</tr>
										</thead>
										<tbody class="te-tbody">
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsPending']->value['rs'], 'Record', false, NULL, 'pendinglist', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
												<?php $_smarty_tpl->_assignInScope('arrPendingPrice', array_column($_smarty_tpl->tpl_vars['Record']->value,'Price_Diff'));?>
												<tr class="text-center">
													<td nowrap>
														<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['StreetNumber'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'] != '' && (isset($_smarty_tpl->tpl_vars['Record']->value['StreetName'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetName'] != '') {?>
															<a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
" class="text-dark"><h6 class="my-0 txt-heading pb-0"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];
if ((isset($_smarty_tpl->tpl_vars['Record']->value['UnitNo'])) && $_smarty_tpl->tpl_vars['Record']->value['UnitNo'] != '') {?>, #<?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];
}?></h6></a>
															<small><?php echo $_smarty_tpl->tpl_vars['Record']->value['Subdivision'];?>
</small>
														<?php } else { ?>
															<a href="#" class="text-dark"><h6 class="my-0 txt-heading pb-0">Address Not Available</h6></a>
														<?php }?>
													</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
													<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable4 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable4);?>
													<td nowrap class="<?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
													<td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
</td>
													<?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>

														<?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable5 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable5);?>
														<td nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?></td>
														<?php } else { ?>
														<td nowrap>0</td>

													<?php }?>

													<td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
												</tr>
											<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
										</tbody>
									</table>
								</div>
							</div>
						<?php }?>
						<?php if (is_array($_smarty_tpl->tpl_vars['price_red']->value['rs']) && count($_smarty_tpl->tpl_vars['price_red']->value['rs']) > 0) {?>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4 pt-5">
								<h4 class="title-font text-left te-market-title text-border-bottom txt-heading heading_txt_color pb-4">Largest Price Reductions</h4>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
								<div class="table-responsive pt-4">
									<table class="table table-hover mb-0">
										<thead>
											<tr class="text-center te-font-size-14">
												<th nowrap scope="col" class="border">Address</th>
												<th nowrap scope="col" class="border">New Price</th>
												<th nowrap scope="col" class="border">List Price</th>
												<th nowrap scope="col" class="border">Price Change</th>
												<th nowrap scope="col" class="border">Sq Ft</th>
												<th nowrap scope="col" class="border"><?php echo $_smarty_tpl->tpl_vars['currency']->value;?>
/Sq Ft</th>
												<th nowrap scope="col" class="border">Beds/Baths</th>
												<th nowrap scope="col" class="border">Days Listed</th>
											</tr>
										</thead>
										<tbody class="te-tbody">
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['price_red']->value['rs'], 'Record', false, NULL, 'priceRed', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
												<?php $_smarty_tpl->_assignInScope('arrLargestPrice', array_column($_smarty_tpl->tpl_vars['Record']->value,'Price_Diff'));?>
												<tr class="text-center">
													<td nowrap>
														<?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['StreetNumber'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'] != '' && (isset($_smarty_tpl->tpl_vars['Record']->value['StreetName'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetName'] != '') {?>
															<a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
" class="text-dark"><h6 class="my-0 txt-heading pb-0"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetName'];
if ((isset($_smarty_tpl->tpl_vars['Record']->value['UnitNo'])) && $_smarty_tpl->tpl_vars['Record']->value['UnitNo'] != '') {?>, #<?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];
}?></h6></a>
															<small><?php echo $_smarty_tpl->tpl_vars['Record']->value['Subdivision'];?>
</small>
														<?php } else { ?>
															<a href="#" class="text-dark"><h6 class="my-0 txt-heading pb-0">Address Not Available</h6></a>
														<?php }?>
													</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice']);?>
</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
																																							<?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable6 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable6);?>
													<td nowrap class="<?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
													<td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
</td>
													<?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>

														<?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable7 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable7);?>
														<td nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?></td>
														<?php } else { ?>
														<td nowrap>0</td>

													<?php }?>

													<td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
													<td nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
												</tr>
											<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
										</tbody>
									</table>
								</div>
							</div>
						<?php }?>
					</div>
				<?php } else { ?>
					No Statistics Available for <?php echo $_smarty_tpl->tpl_vars['title']->value;?>

				<?php }?>
			</div>
		</div>
	</div>
</section><?php }
}
