<div class="modal-header">
	<h5 class="modal-title txt-heading heading_txt_color" id="exampleModalLabel">Sign In</h5>
	
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>

</div>
<div id="login-error"></div>
<div class="modal-body pb-0 mt-3">
	<form for="form" id="frmLogin">
		<span id="login_message_area_topbar"></span>
		<div class="group position-relative">
			<input class="form-input w-100 bg-transparent required" type="text" placeholder="" name="username" id="username"  value="">
			<span class="bar"></span>
			<label class="form-label position-absolute">Email  <span class="text-danger">*</span></label>
		</div>
		<div class="group position-relative mb-4">
			<input class="form-input w-100 bg-transparent required" type="password" placeholder="" name="password" id="password"  value="">
			<span class="bar"></span>
			<label class="form-label position-absolute"  >Password <span class="text-danger">*</span></label>
		</div>

		<input type="hidden" name="mlsNum" id="mlsNum" value="{$mlsNum}" />
		<input type="hidden" name="ReqType" id="ReqType" value="{$smarty.request.ReqType|default:''}"/>
		<input type="hidden" name="pid" id="pid" value="{$smarty.request.pid|default:''}"/>
		<button type="submit" class="btn border-secondary te-btn text-white- w-100 shadow-none rounded-0 text-uppercase btn-signin lpt-btn lpt-btn-txt">Sign In</button>

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

	<div class="form-group mt-3 text-center">
		<p class="te-font-size-14 p-0">Trouble Logging In? <u><a class="text-main text-decoration-none popup-modal-sm link-color" data-toggle="modal" data-target="ForgotPassword" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=forgot-password{if isset($ReqType)}&ReqType={$ReqType}{/if}{if isset($mlsNum)}&mlsNum={$mlsNum}{/if}" href="javascript:void(0);" data-dismiss="modal">Reset Password</a></u></p>
		{*<p class="te-font-size-14 p-0"><a class="text-main text-decoration-none popup-modal-sm link-color" data-toggle="modal" data-target="ForgotPassword" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=forgot-password{if isset($ReqType)}&ReqType={$ReqType}{/if}{if isset($mlsNum)}&mlsNum={$mlsNum}{/if}" href="javascript:void(0);" data-dismiss="modal">Forgot password ?</a></p>*}
{*		<small>I accept the <a href="#" class="text-main text-decoration-none">Terms of Use</a> and <a class="text-main text-decoration-none" href="#">Privacy Policy</a></small>*}
	</div>
	<div class="form-group mt-3 mb-4 text-center">
			<p class="te-font-size-14 p-0">Not a member yet? <u><a class="text-main text-decoration-none popup-modal-sm link-color" href="JavaScript:void(0);"  data-toggle="modal" data-target="MemberRegister" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-register{if isset($ReqType)}&ReqType={$ReqType}{/if}{if isset($mlsNum)}&mlsNum={$mlsNum}{/if}" data-dismiss="modal">Register Now</a></u></p>
	</div>
	<div class="form-group mt-3 text-center">
		<p class="te-font-size-12 p-0">This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" class="text-main text-decoration-none link-color">Privacy Policy</a> and <a class="text-main text-decoration-none link-color" href="https://policies.google.com/terms">Terms of Service</a> apply.</p>
	</div>
</div>
{*
<div class="modal-footer justify-content-start justify-content-between">

</div>*}
