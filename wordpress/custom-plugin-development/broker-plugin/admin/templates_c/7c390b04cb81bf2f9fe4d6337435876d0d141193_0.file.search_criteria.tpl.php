<?php
/* Smarty version 4.2.1, created on 2023-08-16 19:16:49
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/predefined/search_criteria.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64dd20a13b8008_17147247',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7c390b04cb81bf2f9fe4d6337435876d0d141193' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/predefined/search_criteria.tpl',
      1 => 1663256270,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64dd20a13b8008_17147247 (Smarty_Internal_Template $_smarty_tpl) {
if (is_array($_smarty_tpl->tpl_vars['arrSearchResult']->value) && count($_smarty_tpl->tpl_vars['arrSearchResult']->value) > 0) {?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['mlslist'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['mlslist'])) {?>
               <strong>#MLS: </strong><?php if (is_array($_smarty_tpl->tpl_vars['arrSearchResult']->value['mlslist'])) {
echo implode(', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['mlslist']);
} else {
echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['mlslist'];
}?><br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['add'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['add'])) {?>
        <strong>Address: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['add'];?>
<br />
    <?php }?>
        <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['sdiv']))) {?>
        <strong>Subdivision: </strong><?php if (is_array($_smarty_tpl->tpl_vars['arrSearchResult']->value['sdiv'])) {
echo ucwords(mb_strtolower(implode(implode(', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['sdiv']),', '), 'UTF-8'));
} else {
echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['sdiv'];
}?>
        <br>
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['minprice'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['minprice'] > 0 && (isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['maxprice'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxprice'] > 0) {?>
        <strong>Price: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['minprice'];?>
 - <?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxprice'];?>
<br />
    <?php } elseif ($_smarty_tpl->tpl_vars['arrSearchResult']->value['minprice'] > 0) {?>
        <strong>Price More Than: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['minprice'];?>
<br />
    <?php } elseif ($_smarty_tpl->tpl_vars['arrSearchResult']->value['maxprice'] > 0) {?>
        <strong>Price Less Than: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxprice'];?>
<br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['beds'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['beds'] > 0) {?>
        <strong>Bedrooms: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['beds'];?>
<br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['minbed'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['minbed'] > 0) {?>
        <strong>Bedrooms: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['minbed'];?>
<br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['baths'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['baths'] > 0) {?>
        <strong>Bathroom: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['baths'];?>
<br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['minbath'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['minbath'] > 0) {?>
        <strong>Bathroom: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['minbath'];?>
<br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['minsqft'])) && (isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['maxsqft'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['minsqft'] > 0 && $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxsqft'] > 0) {?>
        <strong>Square Feet Range: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['minsqft'];?>
 - <?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxsqft'];?>
<br />
    <?php } elseif ($_smarty_tpl->tpl_vars['arrSearchResult']->value['minsqft'] > 0) {?>
        <strong>Square Feet Greater Than: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['minsqft'];?>
<br />
    <?php } elseif ($_smarty_tpl->tpl_vars['arrSearchResult']->value['maxsqft'] > 0) {?>
        <strong>Square Feet Less Than: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxsqft'];?>
<br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['mingarage'])) && (isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['maxgarage'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['mingarage'] > 0 && $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxgarage'] > 0) {?>
        <strong>Garage Range: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['mingarage'];?>
 - <?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxgarage'];?>
<br />
    <?php } elseif ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['mingarage'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['mingarage'] > 0) {?>
        <strong>Garage Greater Than: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['mingarage'];?>
<br />
    <?php } elseif ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['maxgarage'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxgarage'] > 0) {?>
        <strong>Garage Less Than: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxgarage'];?>
<br />
    <?php }?>
     <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['minyear'])) && (isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['maxyear'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['minyear'] > 0 && $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxyear'] > 0) {?>
         <strong>Year Built Range: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['minyear'];?>
 - <?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxyear'];?>
<br />
     <?php } elseif ($_smarty_tpl->tpl_vars['arrSearchResult']->value['minyear'] > 0) {?>
         <strong>Year Built After: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['minyear'];?>
<br />
     <?php } elseif ($_smarty_tpl->tpl_vars['arrSearchResult']->value['maxyear'] > 0) {?>
         <strong>Year Built Before: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxyear'];?>
<br />
     <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['minlotsize'])) && (isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['maxlotsize'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['minlotsize'] > 0 && $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxlotsize'] > 0) {?>
        <strong>Lotsize Range: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['minlotsize'];?>
 - <?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxlotsize'];?>
<br />
    <?php } elseif ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['minlotsize'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['minlotsize'] > 0) {?>
        <strong>Lotsize Greater Than: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['minlotsize'];?>
<br />
    <?php } elseif ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['maxlotsize'])) && $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxlotsize'] > 0) {?>
        <strong>Lotsize Less Than: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['maxlotsize'];?>
<br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['dom'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['dom'])) {?>
        <strong>Days on Market: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['dom'];?>
<br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['city']))) {?>
               <strong>City: </strong><?php if (is_array($_smarty_tpl->tpl_vars['arrSearchResult']->value['city'])) {
echo implode(', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['city']);
} else {
echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['city'];
}?><br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['stype']))) {?>
        <strong>Property Type: </strong><?php if (is_array($_smarty_tpl->tpl_vars['arrSearchResult']->value['stype'])) {
echo str_replace('|',', ',implode(', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['stype']));
} else {
echo str_replace('|',', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['stype']);
}?><br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['pstyle']))) {?>
        <strong>Property Style: </strong><?php if (is_array($_smarty_tpl->tpl_vars['arrSearchResult']->value['pstyle'])) {
echo implode(', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['pstyle']);
} else {
echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['pstyle'];
}?><br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['zipcode'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['zipcode'])) {?>
        <strong>ZipCode: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['zipcode'];?>
<br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['ziplist'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['ziplist'])) {?>
        <strong>ZipCode: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['ziplist'];?>
<br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['area']))) {?>
        <strong>Area: </strong><?php if (is_array($_smarty_tpl->tpl_vars['arrSearchResult']->value['area'])) {
echo implode(', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['area']);
} else {
echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['area'];
}?><br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['elemschl']))) {?>
        <strong>Elementary school: </strong><?php if (is_array($_smarty_tpl->tpl_vars['arrSearchResult']->value['elemschl'])) {
echo implode(', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['elemschl']);
} else {
echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['elemschl'];
}?><br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['midschl']))) {?>
        <strong>Middle school: </strong><?php if (is_array($_smarty_tpl->tpl_vars['arrSearchResult']->value['midschl'])) {
echo implode(', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['midschl']);
} else {
echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['midschl'];
}?><br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['highschl']))) {?>
        <strong>High school: </strong><?php if (is_array($_smarty_tpl->tpl_vars['arrSearchResult']->value['highschl'])) {
echo implode(', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['highschl']);
} else {
echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['highschl'];
}?><br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['office'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['office'])) {?>
        <strong>Office ID: </strong><?php if (is_array($_smarty_tpl->tpl_vars['arrSearchResult']->value['office'])) {
echo implode(', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['office']);
} else {
echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['office'];
}?><br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['agent'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['agent'])) {?>
        <strong>Agent ID: </strong><?php if (is_array($_smarty_tpl->tpl_vars['arrSearchResult']->value['agent'])) {
echo implode(', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['agent']);
} else {
echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['agent'];
}?><br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['kword'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['kword'])) {?>
        <strong>Additional: </strong> <?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['kword'];?>
<br />
    <?php }?>
        <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['horse_yn'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['horse_yn'])) {?>
        <strong>Horse Amenities: </strong> <?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['horse_yn'];?>
<br />
    <?php }?>
        <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['waterfrontdesc']))) {?>
        <strong>Waterfront Description: </strong><?php if (is_array($_smarty_tpl->tpl_vars['arrSearchResult']->value['waterfrontdesc'])) {
echo str_replace('|',', ',implode(', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['waterfrontdesc']));
} else {
echo str_replace('|',', ',$_smarty_tpl->tpl_vars['arrSearchResult']->value['waterfrontdesc']);
}?><br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['security_safety'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['security_safety'])) {?>
        <strong>Security: </strong> <?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['security_safety'];?>
 <br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['waterfront'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['waterfront'])) {?>
        <strong>Waterfront : </strong> <?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['waterfront'];?>
<br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['membership_required'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['membership_required'])) {?>
        <strong>Membership Required: </strong> <?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['membership_required'];?>
 <br />
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['sys_name'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['sys_name'])) {?>
        <strong>System Name: </strong> <?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['sys_name'];?>
 <br />
    <?php }?>

    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['petsallowed'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['petsallowed'])) {?>
        <strong>Pets Allowed: </strong> <?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['petsallowed'];?>
 <br />
    <?php }?>

    <?php if ((isset($_smarty_tpl->tpl_vars['arrSearchResult']->value['membership_fee'])) && !empty($_smarty_tpl->tpl_vars['arrSearchResult']->value['membership_fee'])) {?>
        <strong>Membership Fee: </strong><?php echo $_smarty_tpl->tpl_vars['arrSearchResult']->value['membership_fee'];?>
<br />
    <?php }
}
}
}
