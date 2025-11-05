<?php
/* Smarty version 4.2.1, created on 2023-08-10 07:14:51
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/schedule_showing.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64d4d4bb77f237_54236995',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '06283d81c9227f29eed2cb94efe829fcd2dc7de1' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/listing/schedule_showing.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64d4d4bb77f237_54236995 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="schedule-message-container" class="col-12"></div>
<div class="card-body bg-white px-4">

	<form id="frmSchedule" role="form"  method="POST">

		<div class="group position-relative mt-2">
			<input class="form-input w-100 bg-transparent required" type="text" placeholder="" name="lead_first_name" value="<?php echo str_replace('_',' ',(($tmp = $_smarty_tpl->tpl_vars['current_user']->value->display_name ?? null)===null||$tmp==='' ? '' ?? null : $tmp));?>
" >
			<span class="bar"></span>
			<label class="form-label position-absolute">Name</label>
		</div>
		<div class="group position-relative">
			<input class="form-input w-100 bg-transparent required" type="email" placeholder="" name="lead_email" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['current_user']->value->user_email ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" >
			<span class="bar"></span>
			<label class="form-label position-absolute">Email</label>
		</div>
		<div class="group position-relative">
			<input class="form-input w-100 bg-transparent required phone_no-" maxlength="15" minlength="10" type="tel" placeholder="" name="lead_home_phone" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['meta']->value['user_phone'][0] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" >
			<span class="bar"></span>
			<label class="form-label position-absolute ">Mobile Number</label>
		</div>
		<div class="group position-relative mb-4">
			<textarea class="form-input w-100 bg-transparent pb-4 pb-lg-5 pb-xl-3 required" type="text" placeholder="I would like more information about <?php echo $_smarty_tpl->tpl_vars['Record']->value['address_short'];?>
." name="lead_comment" >I would like more information about <?php echo $_smarty_tpl->tpl_vars['Record']->value['address_short'];?>
.</textarea>
			<span class="bar"></span>
			<label class="form-label position-absolute"></label>
		</div>
				<input name="ListingID_MLS" id="ListingID_MLS" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['Record']->value['ListingID_MLS'];?>
" />
		<input name="email_to" id="email_to" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['agentInfo']->value['agent_email'];?>
" />
		<input name="agent_id" id="agent_id" type="hidden" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['agentInfo']->value['agent_id'] ?? null)===null||$tmp==='' ? 0 ?? null : $tmp);?>
" />
		<input name="reset" id="reset" type="reset" value="" class="d-none"/>
		<input name="AType" id="AType" type="hidden" value="" />
		<span class="inquiry-loading-area">

		</span>
		<button type="submit" class="btn border-secondary- te-btn text-white- shadow-none rounded-0 w-100 py-2 text-uppercase btn-schedule lpt-btn lpt-btn-txt">Send Message</button>
		<?php if ($_smarty_tpl->tpl_vars['arrConfig']->value['Listing']['enable_google_captcha'] == 'Yes' && $_smarty_tpl->tpl_vars['arrConfig']->value['Listing']['google_site_key'] != '') {?>
			<input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
			<input type="hidden" name="action" value="contact_agent">
		<?php }?>
	</form>
</div>
<?php echo '<script'; ?>
 src="https://www.google.com/recaptcha/api.js?render=<?php echo $_smarty_tpl->tpl_vars['arrConfig']->value['Listing']['google_site_key'];?>
"><?php echo '</script'; ?>
><?php }
}
