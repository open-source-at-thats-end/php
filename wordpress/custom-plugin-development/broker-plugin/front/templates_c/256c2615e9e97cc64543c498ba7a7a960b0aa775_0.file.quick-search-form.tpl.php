<?php
/* Smarty version 4.2.1, created on 2023-08-22 03:32:07
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/quick-search-form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64e4728720c191_07122636',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '256c2615e9e97cc64543c498ba7a7a960b0aa775' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/quick-search-form.tpl',
      1 => 1662850998,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64e4728720c191_07122636 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="<?php if ((isset($_smarty_tpl->tpl_vars['style']->value)) && $_smarty_tpl->tpl_vars['style']->value == 6) {?>qstyle6 mx-0 w-100<?php }?> quick-container te-font-family <?php if ((isset($_smarty_tpl->tpl_vars['style']->value)) && ($_smarty_tpl->tpl_vars['style']->value == 2 || $_smarty_tpl->tpl_vars['style']->value == 3 || $_smarty_tpl->tpl_vars['style']->value == 4 || $_smarty_tpl->tpl_vars['style']->value == 5 || $_smarty_tpl->tpl_vars['style']->value == 6)) {?>h-container<?php }?>" style="<?php if ((isset($_smarty_tpl->tpl_vars['style']->value)) && ($_smarty_tpl->tpl_vars['style']->value == 2 || $_smarty_tpl->tpl_vars['style']->value == 3 || $_smarty_tpl->tpl_vars['style']->value == 4 || $_smarty_tpl->tpl_vars['style']->value == 5 || $_smarty_tpl->tpl_vars['style']->value == 6)) {?>height:100vh<?php }?>">
	<?php if ((isset($_smarty_tpl->tpl_vars['style']->value)) && $_smarty_tpl->tpl_vars['style']->value == 2) {?>
		<div class="style2-content text-center search-bar">
			<div>
				<h2 class="quick2-head-title quick2-style">Quick <strong class="quick2-sub-title quick2-style">Search</strong></h2>
				<div class="quick-form">
					<form action="<?php echo $_smarty_tpl->tpl_vars['formAction']->value;?>
" method="post">
						<div class="quick-field  qs-long arrow-clr">
							<select name="stype" class="quick-ptype">
								<option value="">PROPERTY TYPE</option>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['OtherConfig']->value['quick_ptype2'], 'sitem', false, 'skey', 'ptype', array (
));
$_smarty_tpl->tpl_vars['sitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['skey']->value => $_smarty_tpl->tpl_vars['sitem']->value) {
$_smarty_tpl->tpl_vars['sitem']->do_else = false;
?>
																			<option value="<?php echo $_smarty_tpl->tpl_vars['sitem']->value;?>
"><?php if ($_smarty_tpl->tpl_vars['arrMeta']->value['SubType'][$_smarty_tpl->tpl_vars['sitem']->value] == 'Lease') {?>Rental<?php } else {
echo $_smarty_tpl->tpl_vars['arrMeta']->value['SubType'][$_smarty_tpl->tpl_vars['sitem']->value];
}?></option>
																	<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</select>
						</div>
						<div class="quick-field  qs-long">
							<select name="city">
								<option value="">SELECT A CITY</option>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['OtherConfig']->value['quick_city2'], 'cityitem', false, 'citykey', 'city', array (
));
$_smarty_tpl->tpl_vars['cityitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['citykey']->value => $_smarty_tpl->tpl_vars['cityitem']->value) {
$_smarty_tpl->tpl_vars['cityitem']->do_else = false;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['cityitem']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['cityitem']->value;?>
</option>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</select>
						</div>
						<div class="quick-field  qs-short qs-left">
							<select name="minbed">
								<option value="">BEDS</option>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrBathRange']->value, 'beditem', false, 'bedkey', 'minbed', array (
));
$_smarty_tpl->tpl_vars['beditem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['bedkey']->value => $_smarty_tpl->tpl_vars['beditem']->value) {
$_smarty_tpl->tpl_vars['beditem']->do_else = false;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['bedkey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['beditem']->value;?>
</option>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</select>
						</div>
						<div class="quick-field  qs-short qs-right">
							<select name="minbath">
								<option value="">BATHS</option>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrBathRange']->value, 'bathitem', false, 'bathkey', 'minbath', array (
));
$_smarty_tpl->tpl_vars['bathitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['bathkey']->value => $_smarty_tpl->tpl_vars['bathitem']->value) {
$_smarty_tpl->tpl_vars['bathitem']->do_else = false;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['bathkey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['bathitem']->value;?>
</option>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</select>
						</div>
						<div class="quick-field  qs-short qs-left">
							<select name="minprice">
							
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrPriceRange']->value, 'mitem', false, 'mkey', 'minprice', array (
));
$_smarty_tpl->tpl_vars['mitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['mkey']->value => $_smarty_tpl->tpl_vars['mitem']->value) {
$_smarty_tpl->tpl_vars['mitem']->do_else = false;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['mkey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['mitem']->value;?>
</option>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
									<option value="" selected="selected">Any </option>
							</select>
						</div>
						<div class="quick-field  qs-short qs-right">
							<select name="maxprice">
							
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrPriceRange']->value, 'maxitem', false, 'maxkey', 'maxprice', array (
));
$_smarty_tpl->tpl_vars['maxitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['maxkey']->value => $_smarty_tpl->tpl_vars['maxitem']->value) {
$_smarty_tpl->tpl_vars['maxitem']->do_else = false;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['maxkey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['maxitem']->value;?>
</option>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								<option value="" selected="selected">Any</option>
							</select>
						</div>
						<div class="qs-btn qs-left">
							<input type="submit" value="SEARCH" class="qs-submit lpt-btn- te-btn"/>
						</div>
						<div class="qs-btn qs-right">
							<a href="<?php echo $_smarty_tpl->tpl_vars['formAction']->value;?>
" class="qs-adv te-btn">Advanced</a>
						</div>
						<input type="hidden" name="status" value="active" class="status">
					</form>
				</div>
			</div>
		</div>
	<?php } elseif ((isset($_smarty_tpl->tpl_vars['style']->value)) && $_smarty_tpl->tpl_vars['style']->value == 3) {?>
	    <div class="style2-content style3-content quick-content mw-100">
            <form action="<?php echo $_smarty_tpl->tpl_vars['formAction']->value;?>
" method="post" class="w-100">
				<div class="text-center">
					<?php if (((isset($_smarty_tpl->tpl_vars['OtherConfig']->value['quick3_title'])) && $_smarty_tpl->tpl_vars['OtherConfig']->value['quick3_title'] != '')) {?>
						<h1 class="quick3_title pb-4 mb-0"><?php echo $_smarty_tpl->tpl_vars['OtherConfig']->value['quick3_title'];?>
</h1>
					<?php }?>
					<span class="quick3-style font-bold f-30 text-white"> I want to </span>
					<span class=" position-relative d-inline-block">
					    	<i class="fa fa-chevron-down f-arrow  fa-lg" aria-hidden="true"></i>
						<select name="status" class="quick3-style f-27 f-select lpt-quick-color-">
							<option value="active">Buy</option>
							<option value="rental">Rent</option>
						</select>
					

					</span> <span class="quick3-style font-bold f-30 text-white"> a </span>
					<span class=" position-relative d-inline-block">
					    	<i class="fa fa-chevron-down f-arrow  fa-lg" aria-hidden="true"></i>
						<select name="stype" class="quick3-style f-27 f-select lpt-quick-color-">
							<option value="">Property Type</option>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['OtherConfig']->value['quick_ptype2'], 'sitem', false, 'skey', 'ptype', array (
));
$_smarty_tpl->tpl_vars['sitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['skey']->value => $_smarty_tpl->tpl_vars['sitem']->value) {
$_smarty_tpl->tpl_vars['sitem']->do_else = false;
?>
																	<?php if ($_smarty_tpl->tpl_vars['arrMeta']->value['SubType'][$_smarty_tpl->tpl_vars['sitem']->value] != 'Lease') {?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['sitem']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['arrMeta']->value['SubType'][$_smarty_tpl->tpl_vars['sitem']->value];?>
</option>
									<?php }?>
															<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						</select>
					</span>
					<span class="quick3-style font-bold f-30 text-white"> in </span>
					<span class=" position-relative d-inline-block">
					    	<i class="fa fa-chevron-down f-arrow  fa-lg" aria-hidden="true"></i>
						<select name="city" class="quick3-style f-27 f-select lpt-quick-color-">
								<option value="">Select A City</option>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['OtherConfig']->value['quick_city2'], 'cityitem', false, 'citykey', 'city', array (
));
$_smarty_tpl->tpl_vars['cityitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['citykey']->value => $_smarty_tpl->tpl_vars['cityitem']->value) {
$_smarty_tpl->tpl_vars['cityitem']->do_else = false;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['cityitem']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['cityitem']->value;?>
</option>
							<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						</select>
					</span>
				</div>
				<div class="quick text-center w-100 mw-100 -mt-3">
				<button type="submit" class="quick3-style d-inline-block w-auto text-italic text-uppercase px-5 py-2 btn btn-success- lpt-btn- text-white">Search</button>
				</div>
			</form>
		</div>
	<?php } elseif ((isset($_smarty_tpl->tpl_vars['style']->value)) && $_smarty_tpl->tpl_vars['style']->value == 4) {?>
		<div class="style4-content text-center mw-100">
			<form class="form w-100" id="frmsearch" role="form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['formAction']->value;?>
">
					<?php if (((isset($_smarty_tpl->tpl_vars['OtherConfig']->value['quick4_title'])) && $_smarty_tpl->tpl_vars['OtherConfig']->value['quick4_title'] != '')) {?>
						<h1 class="quick4_title pb-4 mb-0"><?php echo $_smarty_tpl->tpl_vars['OtherConfig']->value['quick4_title'];?>
</h1>
					<?php }?>
					<div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
						<div class="btn-group w-100- te-search-btn-group bg-white" role="group" aria-label="First group">
							<div class="status-div">
								<span class=" position-relative d-inline-block status"><i class="fa fa-chevron-down f-arrow fa-sm" aria-hidden="true"></i>
								<select class="" name="status">
								<option value="active">Buy</option>
								<option value="rental">Rent</option>
								</select></span>
							</div>
							<input type="text" id="AddressName" aria-labelledby="search-box" class="form-control h-auto border-0 px-lg-4 px-2 py-2- py-md-3- shadow-none rounded-0" name="AddressName" placeholder="Search by City, Neighborhood, Address, ZIP, MLS#, School" value="">
							<button id="search-box" type="submit" aria-label="button" class="btn px-lg-4 px-3 text-white- te-btn shadow-none rounded-0 lpt-btn lpt-btn-txt">
								Search
							</button>
							<input name="addval" class="" id="AddressValue" value="" data-type="hidden" type="hidden">
							<input name="addtype" class="" id="AddressType" value="" data-type="hidden" type="hidden">
							<input type="hidden" value="" id="PropertyType" class="" name="ptype" />
							<input type="hidden" value="ResidentialLease" id="Not_PropertyType" class="" name="notptype" />
						</div>
					</div>
			</form>
		</div>
	<?php } elseif ((isset($_smarty_tpl->tpl_vars['style']->value)) && $_smarty_tpl->tpl_vars['style']->value == 5) {?>
		<div class="style5-content text-center mw-100">
			<form class="form w-100" id="frmsearch" role="form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['formAction']->value;?>
">
								<?php if (((isset($_smarty_tpl->tpl_vars['OtherConfig']->value['quick5_title'])) && $_smarty_tpl->tpl_vars['OtherConfig']->value['quick5_title'] != '')) {?>
					<h1 class="quick5_title pb-4 mb-0"><?php echo $_smarty_tpl->tpl_vars['OtherConfig']->value['quick5_title'];?>
</h1>
				<?php }?>
				<div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
					<div class="btn-group w-100- te-search-btn-group bg-white" role="group" aria-label="First group">
						<div class="status-div">
								<span class=" position-relative d-inline-block status"><i class="fa fa-chevron-down f-arrow fa-sm" aria-hidden="true"></i>
								<select class="" name="status">
								<option value="active">Buy</option>
								<option value="rental">Rent</option>
								</select></span>
						</div>
						<input type="text" id="AddressName" aria-labelledby="search-box" class="form-control h-auto border-0 px-lg-4 px-2 py-2- py-md-3- shadow-none rounded-0" name="AddressName" placeholder="Search by City, Neighborhood, Address, ZIP, MLS#, School" value="">
						<button id="search-box" type="submit" aria-label="button" class="btn px-lg-4 px-3  shadow-none rounded-0">
							<i class="fas fa-search fa-lg"></i>
						</button>
						<input name="addval" class="" id="AddressValue" value="" data-type="hidden" type="hidden">
						<input name="addtype" class="" id="AddressType" value="" data-type="hidden" type="hidden">
					</div>
					<div class="textright advanced-search-link">
						<a href="<?php echo $_smarty_tpl->tpl_vars['formAction']->value;?>
" class="text-white text-right  link-hover"> + Advanced Search Options</a>
					</div>
				</div>

							</form>
		</div>
	<?php } elseif ((isset($_smarty_tpl->tpl_vars['style']->value)) && $_smarty_tpl->tpl_vars['style']->value == 6) {?>
		<div class="style6-content text-center search-bar pb-0">
							<div class="quick-form w-100 mw-100 <?php if ((isset($_smarty_tpl->tpl_vars['darkmode']->value)) && $_smarty_tpl->tpl_vars['darkmode']->value == 'true') {?>darkmode<?php }?>">
					<form class="form mw-100 " id="frmsearch" role="form" action="<?php echo $_smarty_tpl->tpl_vars['formAction']->value;?>
" method="post">
						<div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
							<div class="btn-group w-100- te-search-btn-group " role="group" aria-label="First group" style="background-color: <?php echo $_smarty_tpl->tpl_vars['bgcolor']->value;?>
">
								<div class="status-div">
								<span class=" position-relative d-inline-block status"><i class="fa fa-chevron-down f-arrow fa-sm" aria-hidden="true"></i>
								<select class="<?php if ((isset($_smarty_tpl->tpl_vars['darkmode']->value)) && $_smarty_tpl->tpl_vars['darkmode']->value == 'true') {?>bg-black- text-white<?php }?> font-weight-bold" name="status">
								<option value="active">BUY</option>
								<option value="rental">RENT</option>
								</select></span>
								</div>
								<input type="text" id="AddressName" aria-labelledby="search-box" class="form-control h-auto border-0 px-lg-4 px-2 py-2- py-md-3- shadow-none rounded-0 <?php if (cw::$screen == 'MD') {?>w-50<?php } else { ?>w-75<?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['darkmode']->value)) && $_smarty_tpl->tpl_vars['darkmode']->value == 'true') {?>bg-black-<?php } else { ?>bg-white- font-weight-bold<?php }?>" name="AddressName" placeholder="Search by City, Name, Neighborhood, Address, Zip Code, MLS#" value="">
								<button id="search-box" type="submit" aria-label="button" class="btn px-lg-4 px-3  shadow-none rounded-0 pad-right <?php if ((isset($_smarty_tpl->tpl_vars['darkmode']->value)) && $_smarty_tpl->tpl_vars['darkmode']->value == 'true') {?>text-white<?php }?> font-weight-bold" style="background-color: <?php echo $_smarty_tpl->tpl_vars['bgcolor']->value;?>
">
									<?php if ((cw::$screen == 'MD') || (cw::$screen == 'LG') || (cw::$screen == 'XL')) {?>SEARCH&nbsp;<?php }?> <i class="fas fa-search fa-lg"></i>
								</button>
								<input name="addval" class="" id="AddressValue" value="" data-type="hidden" type="hidden">
								<input name="addtype" class="" id="AddressType" value="" data-type="hidden" type="hidden">
							</div>
						</div>
					</form>
				</div>
					</div>
	<?php } else { ?>
		<div class="quick-content">
			<div class="float-left pt-4">
				<h2><strong class="head-title quick-head-title quick_text_color quick-style quick_font_family pl-0 quick_title_transform quick_title_space">quick</strong>
					<strong class="head-sub-title quick-sub-title quick_text_color quick-style quick_font_family mt-3 pl-0 quick_title_transform quick_title_space">search</strong>
				</h2>
			</div>
			<div class="float-right quick-right">
				<form action="<?php echo $_smarty_tpl->tpl_vars['formAction']->value;?>
" method="post">
					<div class="quick-row">
						<div class="quick quick-w-100 quick_text_color arrow-clr">
							<select name="stype" class="quick-ptype quick_font_size quick_srch_fnt_fmly quick_search_transform">
								<option value="">property type</option>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['OtherConfig']->value['quick_ptype'], 'sitem', false, 'skey', 'ptype', array (
));
$_smarty_tpl->tpl_vars['sitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['skey']->value => $_smarty_tpl->tpl_vars['sitem']->value) {
$_smarty_tpl->tpl_vars['sitem']->do_else = false;
?>
																			<option value="<?php echo $_smarty_tpl->tpl_vars['sitem']->value;?>
"><?php if ($_smarty_tpl->tpl_vars['arrMeta']->value['SubType'][$_smarty_tpl->tpl_vars['sitem']->value] == 'Lease') {?>Rental<?php } else {
echo $_smarty_tpl->tpl_vars['arrMeta']->value['SubType'][$_smarty_tpl->tpl_vars['sitem']->value];
}?></option>
																	<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</select>
						</div>
						<div class="quick quick-w-100 quick_text_color arrow-clr">
							<select name="city" class="quick_font_size quick_srch_fnt_fmly quick_search_transform">
								<option value=""> select a city</option>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['OtherConfig']->value['quick_city'], 'cityitem', false, 'citykey', 'city', array (
));
$_smarty_tpl->tpl_vars['cityitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['citykey']->value => $_smarty_tpl->tpl_vars['cityitem']->value) {
$_smarty_tpl->tpl_vars['cityitem']->do_else = false;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['cityitem']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['cityitem']->value;?>
</option>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</select>
						</div>
						<div class="quick quick_text_color arrow-clr">
							<select name="minprice" class="quick_font_size quick_srch_fnt_fmly quick_search_transform">
								<option value="" selected="selected">any price</option>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrPriceRange']->value, 'mitem', false, 'mkey', 'minprice', array (
));
$_smarty_tpl->tpl_vars['mitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['mkey']->value => $_smarty_tpl->tpl_vars['mitem']->value) {
$_smarty_tpl->tpl_vars['mitem']->do_else = false;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['mkey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['mitem']->value;?>
</option>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

							</select>
						</div>
						<div class="quick quick_text_color arrow-clr">
							<select name="maxprice" class="quick_font_size quick_srch_fnt_fmly quick_search_transform">
								<option value="" selected="selected">any price</option>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrPriceRange']->value, 'maxitem', false, 'maxkey', 'maxprice', array (
));
$_smarty_tpl->tpl_vars['maxitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['maxkey']->value => $_smarty_tpl->tpl_vars['maxitem']->value) {
$_smarty_tpl->tpl_vars['maxitem']->do_else = false;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['maxkey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['maxitem']->value;?>
</option>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

							</select>
						</div>
					</div>
					<div class="quick-row mt-3">
						<div class="quick quick_text_color arrow-clr">
							<select name="minbed" class="minimal quick_font_size quick_srch_fnt_fmly quick_search_transform">
								<option value="">beds</option>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrBathRange']->value, 'beditem', false, 'bedkey', 'minbed', array (
));
$_smarty_tpl->tpl_vars['beditem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['bedkey']->value => $_smarty_tpl->tpl_vars['beditem']->value) {
$_smarty_tpl->tpl_vars['beditem']->do_else = false;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['bedkey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['beditem']->value;?>
</option>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</select>
						</div>
						<div class="quick quick_text_color arrow-clr">
							<select name="minbath " class="quick_font_size quick_srch_fnt_fmly quick_search_transform">
								<option value="">baths</option>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrBathRange']->value, 'bathitem', false, 'bathkey', 'minbath', array (
));
$_smarty_tpl->tpl_vars['bathitem']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['bathkey']->value => $_smarty_tpl->tpl_vars['bathitem']->value) {
$_smarty_tpl->tpl_vars['bathitem']->do_else = false;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['bathkey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['bathitem']->value;?>
</option>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</select>
						</div>
						<div class="quick-w-100 quick-btn">
							<div class="quick ">
								<input type="submit" class="quick_text_color quick_btn_color quick_font_size quick_srch_fnt_fmly quick_search_transform" value="Search"/>
							</div>
							<div class="quick quick-m-t-4">
								<a href="<?php echo $_smarty_tpl->tpl_vars['formAction']->value;?>
" class="quick_text_color quick_btn_color quick_font_size quick_srch_fnt_fmly quick_search_transform"><span>Advanced</span></a>
							</div>
						</div>
					</div>
					<input type="hidden" name="status" value="active" class="status"> 
				</form>
			</div>
		</div>
	<?php }?>
</div><?php }
}
