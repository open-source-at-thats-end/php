<div class="modal-header">
	<h5 class="modal-title txt-heading heading_txt_color" id="exampleModalLabel">Forgot password</h5>

		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	
</div>
<div id="forgot-error"></div>
<div class="modal-body">
	<form id="frmForgetPwd" for="form">
		<div class="form-group">
			<label for="exampleInputEmail1 text-secondary">Enter your sign in email where we will send you instructions to reset password.</label>
		</div>
		<div class="group position-relative mt-2">
			<input class="form-input w-100 bg-transparent required" type="email" placeholder="" name="user_email" value="">
			<span class="bar"></span>
			<label class="form-label position-absolute">Email</label>
		</div>
		<input type="hidden" name="mlsNum" id="mlsNum" value="{$mlsNum}" />
		<input type="hidden" name="ReqType" id="ReqType" value="{$smarty.request.ReqType|default:''}"/>
		<div class="loading-area"></div>
		<button type="submit" class="btn border-secondary te-btn text-white- w-100 shadow-none rounded-0 text-uppercase btn-fwd lpt-btn lpt-btn-txt">Send Me New Password</button>
	</form>

</div>
<div class="modal-footer justify-content-start">
	<p>Already have an account? <a class="text-main text-decoration-none popup-modal-sm link-color" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login{if isset($ReqType)}&ReqType={$ReqType}{/if}{if isset($mlsNum)}&mlsNum={$mlsNum}{/if}" href="JavaScript:void(0);" data-dismiss="modal">Sign In</a></p>
</div>