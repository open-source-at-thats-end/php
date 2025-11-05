<div class="modal-header">
	<h5 class="modal-title" id="exampleModalLabel">Contact {if $agentInfo.agent_name != ''}{$agentInfo.agent_name}{/if}</h5>
	<button type="button" class="close te-contact-agent-close-icon" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body py-3">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 Featured-listings d-md-none px-0 pb-4">
		<div class="card w-100 agent border rounded-0">
			<img src="{$agentImgUrl}{if $agentInfo.agent_photo != ''}{$agentInfo.agent_photo}{else}default-client.jpg{/if}" class="w-100 h-100" alt="...">
			<div class="card-body bg-white px-3 mx-3 te-property-agent-detail pb-0">
				<h5>{if $agentInfo.agent_name != ''}{$agentInfo.agent_name}{/if}</h5>
				<p class="mb-1">Real Estate Agent</p>
				<ul class="list-unstyled w-100 p-0">
					<li class="py-1"><i class="fas fa-phone pr-2 text-secondary"></i> {if $agentInfo.agent_phone != ''}{$agentInfo.agent_phone}{/if}
					</li>
					<li class="py-1 text-truncate"><i class="far fa-envelope pr-2 text-secondary"></i> {if $agentInfo.agent_email != ''}{$agentInfo.agent_email}{/if}
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div id="message-container" class="col-12"></div>
	<form role="form" id="frmInquiry">
		<div id="message-container" class="col-12"></div>
		<div class="group position-relative mt-2">
			<input class="form-input w-100 bg-transparent required" type="text" placeholder="" name="lead_first_name" value="{str_replace('_',' ',$current_user->display_name|default:'')}">
			<span class="bar"></span>
			<label class="form-label position-absolute">Name</label>
		</div>
		<div class="group position-relative">
			<input class="form-input w-100 bg-transparent required" type="email" placeholder="" name="lead_email" value="{$current_user->user_email|default:''}">
			<span class="bar"></span>
			<label class="form-label position-absolute">Email</label>
		</div>
		<div class="group position-relative">
			<input class="form-input w-100 bg-transparent required phone_no" type="tel" placeholder="" name="lead_home_phone" value="{$meta['user_phone'][0]|default:''}" >
			<span class="bar"></span>
			<label class="form-label position-absolute">Phone Number</label>
		</div>
		<div class="group position-relative mb-4">
			<textarea class="form-input w-100 bg-transparent" type="text" placeholder="" name="lead_comment"></textarea>
			<span class="bar"></span>
			<label class="form-label position-absolute">Message</label>
		</div>
		<input name="ListingID_MLS" id="ListingID_MLS" type="hidden" value="{$Record.ListingID_MLS}" />
		<input name="email_to" id="email_to" type="hidden" value="{$agentInfo.agent_email}" />
		<input name="agent_id" id="agent_id" type="hidden" value="{$agentInfo.agent_id|default:0}" />
		<input name="reset" id="reset" type="reset" value="" class="d-none"/>
		<span class="inquiry-loading-area">

		</span>
		<button type="submit" class="btn border-secondary te-btn text-white shadow-none rounded-0 text-uppercase btn-inquiry">Send Message</button>
	</form>
</div>