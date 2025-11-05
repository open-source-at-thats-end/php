<?php
/* Smarty version 4.2.1, created on 2023-08-10 08:02:25
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/listing-searchfrm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64d4dfe15d18b9_70052036',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2b13895128e52a952944b0510350e20c80cccd9d' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/listing-searchfrm.tpl',
      1 => 1677161924,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:listing/main-device-search-form.tpl' => 1,
    'file:listing/mobile-device-search-form.tpl' => 1,
  ),
),false)) {
function content_64d4dfe15d18b9_70052036 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="wrapper vh-100- mb-0 overflow-hidden- te-search-result-wrapper shadow-sm-">
    <section class="te-search-results-sec te-search-result-wrapper p-0">
    <div id="pms-searchfrm" class="container-fluid customize-ldesign">
        <?php $_smarty_tpl->_subTemplateRender("file:listing/main-device-search-form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </div>
</section>
</div>

<?php if (cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD') {?>
    <?php $_smarty_tpl->_subTemplateRender("file:listing/mobile-device-search-form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
}
