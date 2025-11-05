<div class="wrapper vh-100- -overflow-hidden te-wrapper te-font-family">
	<form class="form" id="frmsearch" role="form" method="post" action="{$formAction}">
		<section class="te-bg-light- te-search-form-sec -py-5">
			<div class="container-fluid -py-5 py-l">
				<div class="row -py-md-5">
					<div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12 offset-xl-3 offset-lg-3 offset-md-1 -py-lg-5 mx-auto">
						{if (isset($isTitle) && $isTitle !== 'false' && $isTitle !== false) && (isset($OtherConfig['qsrch_title']) && $OtherConfig['qsrch_title'] != '')}
							<h1 class="qsrch_title pb-4 mb-0">{$OtherConfig['qsrch_title']}</h1>
						{/if}
						<div class="mx-0">
							<div class="btn-group home-search-tab float-left ">
								<label class="btn te-btn shadow-none rounded-0 lpt-hbtn buy lpt-btn-txt border-0 mb-0 active">
									Buy
								</label>
								<label class="btn te-btn shadow-none rounded-0 lpt-hbtn rent lpt-btn-txt border-0 mb-0">
									Rent
								</label>
							</div>
						</div>
						<div class="btn-toolbar w-100 justify-content-center lpt-toolbar" role="toolbar" aria-label="Toolbar with button groups">
							<div class="btn-group w-100 te-search-btn-group bg-white" role="group" aria-label="First group">
								<input type="text" id="AddressName" aria-labelledby="search-box" class="form-control h-auto border-0 px-lg-4 px-2 py-2- py-md-3- shadow-none rounded-0" name="AddressName" placeholder="Search by City, Neighborhood, Address, ZIP, MLS#, School" value="">
								<button id="search-box" type="button" aria-label="button" class="btn px-lg-4 px-3 text-white- te-btn shadow-none rounded-0 lpt-btn lpt-btn-txt">
{*									<i class="fas fa-search"></i>*}Search
								</button>
								<input name="addval" class="" id="AddressValue" value="" data-type="hidden" type="hidden">
								<input name="addtype" class="" id="AddressType" value="" data-type="hidden" type="hidden">
{*								<input type="hidden" value="" id="PropertyType" class="" name="ptype" />*}
{*								<input type="hidden" value="ResidentialLease" id="Not_PropertyType" class="" name="notptype" />*}
								<input name="status" class="" id="status" value="" data-type="hidden" type="hidden">
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</form>
</div>