<section class="te-admin-pages">
	<div class="container py-5">
		<div class="row">
			<div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12 mt-3 mt-md-0">
				<aside class="box-shadow-main">
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link {if $Action == 'edit-profile'} active {/if}text-dark py-3 border-bottom rounded-0" id="te-update-profile-tab" href="{get_home_url()}/{Constants::TYPE_MY_ACCOUNT}/?action=edit-profile" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-user pr-2"></i>Update Profile</a>
						<a class="nav-link {if $Action == 'change-password'} active {/if} text-dark py-3 border-bottom rounded-0" id="te-update-password-tab"  href="{get_home_url()}/{Constants::TYPE_MY_ACCOUNT}/?action=change-password" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fa fa-lock pr-2"></i>Update Password</a>
						<a class="nav-link {if $Action == 'fav-property'} active {/if} text-dark py-3 border-bottom rounded-0" id="te-manage-favourite-properties-tab" href="{get_home_url()}/{Constants::TYPE_MY_ACCOUNT}/?action=fav-property" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="fa fa-heart pr-2"></i>Manage Favorite Properties</a>
						{*<a class="nav-link {if $Action == 'save-searches'} active {/if} text-dark py-3 border-bottom rounded-0" id="te-manage-saved-searches-tab" href="{get_home_url()}/{Constants::TYPE_MY_ACCOUNT}/?action=save-searches" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fas fa-bell pr-2"></i>Manage Saved Searches</a>*}
						{*<a class="nav-link {if $Action == 'fav-condo'} active {/if} text-dark py-3 border-bottom rounded-0" id="te-manage-favourite-condos-tab" href="{get_home_url()}/{Constants::TYPE_MY_ACCOUNT}/?action=fav-condo" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="fa fa-heart pr-2"></i>Manage Favorite Condos</a>*}
					</div>
				</aside>
			</div>
			<div class="col-xl-8 col-lg-8 col-md-7 col-sm-12 col-12 bg-white mt-3 mt-md-0">
				<div class="tab-content" id="v-pills-tabContent">
					<div class="tab-pane fade {if $Action == 'edit-profile'} show active{/if} " id="te-update-profile" role="tabpanel" aria-labelledby="te-update-profile-tab">
						{include file="my-account/edit-profile.tpl"}
					</div>
					<div class="tab-pane {if $Action == 'change-password'} show active{/if} fade" id="-te-update-password" role="tabpanel" aria-labelledby="te-update-password">
						{include file="my-account/change-password.tpl"}
					</div>
					<div class="tab-pane {if $Action == 'fav-property'} show active{/if} fade" id="te-manage-favourite-properties" role="tabpanel" aria-labelledby="te-manage-favourite-properties-tab">
						{include file="my-account/favourite-property.tpl"}
					</div>
					{*<div class="tab-pane {if $Action == 'save-searches'} show active{/if} fade" id="te-manage-saved-searches" role="tabpanel" aria-labelledby="te-manage-saved-searches-tab">
						{include file="my-account/saved-searches.tpl"}
					</div>
					<div class="tab-pane {if $Action == 'fav-condo'} show active{/if} fade" id="te-manage-favourite-condos" role="tabpanel" aria-labelledby="te-manage-favourite-condos-tab">
						{include file="my-account/favourite-condo.tpl"}
					</div>*}
				</div>
			</div>
		</div>
	</div>
</section>