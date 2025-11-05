<?php
/* Smarty version 4.2.1, created on 2024-01-10 03:54:21
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/sign-up.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_659e694d593f68_79156679',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd48f2668ea387283aec37ee2df927b905ec38f77' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/sign-up.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_659e694d593f68_79156679 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="modal-header">
	<h5 class="modal-title txt-heading heading_txt_color" id="exampleModalLabel">Create an Account</h5>

		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>

</div>
<div id="signup-error"></div>
<div class="modal-body mt-3">
	<form role="form" id="frmRegister">
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-6">
				<div class="group position-relative mt-2">
					<input class="form-input w-100 bg-transparent required" type="text" placeholder="" id="user_first_name" name="user_first_name" value="">
					<span class="bar"></span>
					<label class="form-label position-absolute">First Name <span class="text-danger">*</span></label>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6">
				<div class="group position-relative mt-2">
					<input class="form-input w-100 bg-transparent required" id="user_last_name" name="user_last_name" type="text" placeholder="" value="">
					<span class="bar"></span>
					<label class="form-label position-absolute">Last Name <span class="text-danger">*</span></label>
				</div>
			</div>
		</div>
		<div class="group position-relative">
			<input class="form-input w-100 bg-transparent required" id="user_email" name="user_email" type="email" placeholder="" value="">
			<span class="bar"></span>
			<label class="form-label position-absolute">Email <span class="text-danger">*</span></label>
		</div>
		<div class="group position-relative">
			<input class="form-input w-100 bg-transparent required" id="user_password" name="user_password" type="password" placeholder="" value="">
			<span class="bar"></span>
			<label class="form-label position-absolute">Phone Number<span>(used as your password)</span> <span class="text-danger">*</span></label>
		</div>
						<input type="hidden" name="mlsNum" id="mlsNum" value="<?php echo $_smarty_tpl->tpl_vars['mlsNum']->value;?>
" />
		<input type="hidden" name="ReqType" id="ReqType" value="<?php echo (($tmp = $_REQUEST['ReqType'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"/>
		<span class="loading-area"></span>
		<button type="submit" class="btn border-secondary te-btn text-white w-100 shadow-none rounded-0 text-uppercase btn-signup lpt-btn lpt-btn-txt">Register Now</button>
		<?php if ($_smarty_tpl->tpl_vars['arrConfig']->value['Listing']['enable_google_captcha'] == 'Yes' && $_smarty_tpl->tpl_vars['arrConfig']->value['Listing']['google_site_key'] != '') {?>
			<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
			<input type="hidden" name="action" value="user_register">
		<?php }?>

		<?php if (((isset($_smarty_tpl->tpl_vars['fb_loginUrl']->value)) && $_smarty_tpl->tpl_vars['fb_loginUrl']->value != '') || ((isset($_smarty_tpl->tpl_vars['authUrl']->value)) && $_smarty_tpl->tpl_vars['authUrl']->value != '')) {?>
			<div class="group position-relative text-center my-3 line_or"><span class="line">OR</span></div>
			<div class="group position-relative m-0">
				<div class="form-group">
					<div class="et-social-icon et-social-facebook center social-i social-btn"><a onclick="JavaScript:return popupWindowURL('<?php echo $_smarty_tpl->tpl_vars['fb_loginUrl']->value;?>
','Facebook',800,600);" class="btn btn-facebook icon facebook-btn text-white rounded-0 w-100" href="javascript:void(0);"><span><i class="glyphicon glyphicon-hand-right"></i></span> Login with Facebook</a></div>
				</div>
				<div class="form-group">
					<div class="et-social-icon center social-i social-btn"><a onclick="JavaScript:return popupWindowURL('<?php echo $_smarty_tpl->tpl_vars['authUrl']->value;?>
','Google',800,600);" class="btn btn-google icon googleplus-btn text-white rounded-0 w-100" href="javascript:void(0);"><i class="fab fa-google"></i><span><i class="fab fa-google"></i></span> Login with Google</a></div>
				</div>
			</div>
		<?php }?>
	</form>

		<div class="form-group mt-3 mb-4 text-center">
		<p class="te-font-size-14 p-0">Returning User? <u><a class="text-main text-decoration-none popup-modal-sm link-color" href="JavaScript:void(0);"  data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login<?php if ((isset($_smarty_tpl->tpl_vars['ReqType']->value))) {?>&ReqType=<?php echo $_smarty_tpl->tpl_vars['ReqType']->value;
}
if ((isset($_smarty_tpl->tpl_vars['mlsNum']->value))) {?>&mlsNum=<?php echo $_smarty_tpl->tpl_vars['mlsNum']->value;
}?>" data-dismiss="modal">Login Here</a></u></p>
	</div>
	<div class="form-group mt-3 mb-4 text-center">
		<p class="te-font-size-12 p-0 ltr-spc-0">By registering you agree to our <u><a href="<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/privacy-policy" class="text-main text-decoration-none link-color">Privacy Policy</a></u> and <u><a class="text-main text-decoration-none link-color" href="<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/terms-of-service">Terms of Service</a></u></p>
	</div>
	<div class="form-group mt-3 mb-0 text-center">
		<p class="te-font-size-12 p-0">This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" class="text-main text-decoration-none link-color">Privacy Policy</a> and <a class="text-main text-decoration-none link-color" href="https://policies.google.com/terms">Terms of Service</a> apply.</p>
	</div>

</div>
<?php echo '<script'; ?>
 src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=<?php echo $_smarty_tpl->tpl_vars['arrConfig']->value['Listing']['google_site_key'];?>
"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
	var secret_key = "<?php echo $_smarty_tpl->tpl_vars['arrConfig']->value['Listing']['google_site_key'];?>
";
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
	function onloadCallback() {
		grecaptcha.ready(function () {
			grecaptcha.execute(secret_key, {action: 'user_register'}).then(function (token) {
				var recaptchaResponse = document.getElementById('g-recaptcha-response');
				recaptchaResponse.value = token;
			});
		});
	}
<?php echo '</script'; ?>
>

<?php }
}
