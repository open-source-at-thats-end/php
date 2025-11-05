<div class="modal-header">
	<h5 class="modal-title txt-heading heading_txt_color" id="exampleModalLabel">Create an Account</h5>

		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>

</div>
<div id="signup-error"></div>
<div class="modal-body mt-3">
{*	<p class="mb-4">Already a Member ? <a class="text-main text-decoration-none popup-modal-sm" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login{if isset($ReqType)}&ReqType={$ReqType}{/if}{if isset($mlsNum)}&mlsNum={$mlsNum}{/if}" href="JavaScript:void(0);" data-dismiss="modal">Sign In</a></p>*}
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
		{*{if $arrConfig['Listing']['enable_google_captcha'] == 'Yes' && $arrConfig['Listing']['google_site_key'] != ''}
			<div class="g-recaptcha mb-4" data-sitekey="{$arrConfig['Listing']['google_site_key']}"></div>
		{/if}*}
		{*<div class="group position-relative mb-4">
			<input class="form-input w-100 bg-transparent required" id="user_confirm_password" name="user_confirm_password" type="password" placeholder="" value="">
			<span class="bar"></span>
			<label class="form-label position-absolute">Confirm Password</label>
		</div>*}
		<input type="hidden" name="mlsNum" id="mlsNum" value="{$mlsNum}" />
		<input type="hidden" name="ReqType" id="ReqType" value="{$smarty.request.ReqType|default:''}"/>
		<span class="loading-area"></span>
		<button type="submit" class="btn border-secondary te-btn text-white w-100 shadow-none rounded-0 text-uppercase btn-signup lpt-btn lpt-btn-txt">Register Now</button>
		{if $arrConfig['Listing']['enable_google_captcha'] == 'Yes' && $arrConfig['Listing']['google_site_key'] != ''}
			<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
			<input type="hidden" name="action" value="user_register">
		{/if}

		{if (isset($fb_loginUrl) && $fb_loginUrl != '') || (isset($authUrl) && $authUrl != '')}
			<div class="group position-relative text-center my-3 line_or"><span class="line">OR</span></div>
			<div class="group position-relative m-0">
				<div class="form-group">
					<div class="et-social-icon et-social-facebook center social-i social-btn"><a onclick="JavaScript:return popupWindowURL('{$fb_loginUrl}','Facebook',800,600);" class="btn btn-facebook icon facebook-btn text-white rounded-0 w-100" href="javascript:void(0);"><span><i class="glyphicon glyphicon-hand-right"></i></span> Login with Facebook</a></div>
				</div>
				<div class="form-group">
					<div class="et-social-icon center social-i social-btn"><a onclick="JavaScript:return popupWindowURL('{$authUrl}','Google',800,600);" class="btn btn-google icon googleplus-btn text-white rounded-0 w-100" href="javascript:void(0);"><i class="fab fa-google"></i><span><i class="fab fa-google"></i></span> Login with Google</a></div>
				</div>
			</div>
		{/if}
	</form>

	{*<div class="form-group mt-3 text-center">
		<p class="te-font-size-14 p-0">Already a Member? <a class="text-main text-decoration-none popup-modal-sm link-color" href="JavaScript:void(0);"  data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login{if isset($ReqType)}&ReqType={$ReqType}{/if}{if isset($mlsNum)}&mlsNum={$mlsNum}{/if}" data-dismiss="modal">Sign In</a></p>
		<small>I accept the <a href="{$site_url}/terms-of-use" class="text-main text-decoration-none link-color">Terms of Use</a> and <a class="text-main text-decoration-none link-color" href="{$site_url}/privacy-policy">Privacy Policy</a></small>
	</div>*}
	<div class="form-group mt-3 mb-4 text-center">
		<p class="te-font-size-14 p-0">Returning User? <u><a class="text-main text-decoration-none popup-modal-sm link-color" href="JavaScript:void(0);"  data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login{if isset($ReqType)}&ReqType={$ReqType}{/if}{if isset($mlsNum)}&mlsNum={$mlsNum}{/if}" data-dismiss="modal">Login Here</a></u></p>
	</div>
	<div class="form-group mt-3 mb-4 text-center">
		<p class="te-font-size-12 p-0 ltr-spc-0">By registering you agree to our <u><a href="{$site_url}/privacy-policy" class="text-main text-decoration-none link-color">Privacy Policy</a></u> and <u><a class="text-main text-decoration-none link-color" href="{$site_url}/terms-of-service">Terms of Service</a></u></p>
	</div>
	<div class="form-group mt-3 mb-0 text-center">
		<p class="te-font-size-12 p-0">This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" class="text-main text-decoration-none link-color">Privacy Policy</a> and <a class="text-main text-decoration-none link-color" href="https://policies.google.com/terms">Terms of Service</a> apply.</p>
	</div>

</div>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render={$arrConfig['Listing']['google_site_key']}"></script>
<script type="text/javascript">
	var secret_key = "{$arrConfig['Listing']['google_site_key']}";
</script>
{literal}
<script>
	function onloadCallback() {
		grecaptcha.ready(function () {
			grecaptcha.execute(secret_key, {action: 'user_register'}).then(function (token) {
				var recaptchaResponse = document.getElementById('g-recaptcha-response');
				recaptchaResponse.value = token;
			});
		});
	}
</script>
{/literal}
{*
<div class="modal-footer justify-content-start">
	<small>By sending this form you agree to <strong class="text-secondary">CustomWpPlugin.com</strong> <a href="#" class="text-main text-decoration-none">Terms of Use</a> and <a class="text-main" href="#">Privacy Policy</a></small>
</div>*}
