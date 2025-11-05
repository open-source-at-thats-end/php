<div class="card mb-3 bg-white text-left te-card border-0" id="basic-hash">
	<div class="card-header te-card-header te-bg-light pl-0 border-0 rounded-0 py-2">
		<div class="col-xl-12 col-lg-12 col-md-12 mb-0">
			<h4 class="title-font text-left mb-0 pb-0 txt-heading heading_txt_color">Manage Saved Searches</h4>
		</div>
	</div>
	<div class="card-body py-0 collapse show">
		{if is_array($save_search) && count($save_search) > 0}
			{foreach name="SaveSearch" from=$save_search item=Record}
				<div class="row pt-3">
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<strong>{$Record.search_title}</strong>
					</div>
					<hr class="mx-0 w-100">
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<ul class="list-unstyled text-dark clearfix m-0">
							{if isset($Record.search_criteria['minbed']) && $Record.search_criteria['minbed'] > 0}
								<li class="py-1"><strong class="text-secondary">Beds : </strong> {$Record.search_criteria['minbed']}</li>
							{/if}
							{if isset($Record.search_criteria['minbath']) && $Record.search_criteria['minbath'] > 0}
								<li class="py-1"><strong class="text-secondary">Baths : </strong> {$Record.search_criteria['minbath']}</li>
							{/if}
							{if isset($Record.search_criteria.minprice) && isset($Record.search_criteria.maxprice) && $Record.search_criteria.minprice > 0 && $Record.search_criteria.maxprice > 0}
								<li class="py-1"><strong class="text-secondary">Price Range : </strong> {$currency}{$Record.search_criteria.minprice|number_format} - {$currency}{$Record.search_criteria.maxprice|number_format}</li>
							{elseif isset($Record.search_criteria.minprice) && $Record.search_criteria.minprice > 0}
								<li class="py-1"><strong class="text-secondary">Price More Than : </strong> {$currency}{$Record.search_criteria.minprice|number_format}</li>
							{elseif isset($Record.search_criteria.maxprice) && $Record.search_criteria.maxprice > 0}
								<li class="py-1"><strong class="text-secondary">Price Less Than : </strong> {$currency}{$Record.search_criteria.maxprice|number_format}</li>
							{/if}
							{if isset($Record.search_criteria.stype) && $Record.search_criteria.stype != ''}
								<li class="py-1"><strong class="text-secondary">Property Type : </strong> {if is_array($Record.search_criteria.stype)}{str_replace('|',', ',$Record.search_criteria.stype)|implode:', '}{else}{str_replace('|',', ',$Record.search_criteria.stype)}{/if}</li>
							{/if}
							{if isset($Record.search_criteria.sdivlist) && $Record.search_criteria.sdivlist != ''}
								<li class="py-1"><strong class="text-secondary">Subdivision : </strong> {if is_array($Record.search_criteria.sdivlist)}{$Record.search_criteria.sdivlist|implode:', '|lower|ucwords}{else}{$Record.search_criteria.sdivlist}{/if}</li>
							{/if}
							{if isset($Record.search_criteria.pstyle) && $Record.search_criteria.pstyle != ''}
								<li class="py-1"><strong class="text-secondary">Property Style: </strong>{if is_array($Record.search_criteria.pstyle)}{$Record.search_criteria.pstyle|implode:', '}{else}{$Record.search_criteria.pstyle}{/if}</li>
							{/if}
							{if isset($Record.search_criteria.minsqft) && isset($Record.search_criteria.maxsqft) && $Record.search_criteria.minsqft > 0 && $Record.search_criteria.maxsqft > 0}
								<li class="py-1"><strong class="text-secondary">Square Feet Range: </strong>{$Record.search_criteria.minsqft|number_format} - {$Record.search_criteria.maxsqft|number_format}</li>
							{elseif isset($Record.search_criteria.minsqft) && $Record.search_criteria.minsqft > 0}
								<li class="py-1"><strong class="text-secondary">Square Feet Greater Than: </strong>{$Record.search_criteria.minsqft|number_format}</li>
							{elseif isset($Record.search_criteria.maxsqft) && $Record.search_criteria.maxsqft > 0}
								<li class="py-1"><strong class="text-secondary">Square Feet Less Than: </strong>{$Record.search_criteria.maxsqft|number_format}</li>
							{/if}
							{if isset($Record.search_criteria.status) && $Record.search_criteria.status != ''}
								<li class="py-1"><strong class="text-secondary">Status : </strong> {$Record.search_criteria.status}</li>
							{/if}
							{if isset($Record.search_criteria.minlotsize) && isset($Record.search_criteria.maxlotsize) && $Record.search_criteria.minlotsize > 0 && $Record.search_criteria.maxlotsize > 0}
								<li class="py-1"><strong class="text-secondary">Lotsize Range: </strong>{$Record.search_criteria.minlotsize} - {$Record.search_criteria.maxlotsize}</li>
							{elseif isset($Record.search_criteria.minlotsize) && $Record.search_criteria.minlotsize > 0}
								<li class="py-1"><strong class="text-secondary">Lotsize Greater Than: </strong>{$Record.search_criteria.minlotsize}</li>
							{elseif isset($Record.search_criteria.maxlotsize) && $Record.search_criteria.maxlotsize > 0}
								<li class="py-1"><strong class="text-secondary">Lotsize Less Than: </strong>{$Record.search_criteria.maxlotsize}</li>
							{/if}
							{if isset($Record.search_criteria.dom) && !empty($Record.search_criteria.dom)}
								<li class="py-1"><strong class="text-secondary">Days on Market: </strong>{$Record.search_criteria.dom}</li>
							{/if}
							{if isset($Record.search_criteria.minyear) && isset($Record.search_criteria.maxyear) && $Record.search_criteria.minyear > 0 && $Record.search_criteria.maxyear > 0}
								<li class="py-1"><strong class="text-secondary">Year Built Range: </strong>{$Record.search_criteria.minyear} - {$Record.search_criteria.maxyear}</li>
							{elseif isset($Record.search_criteria.minyear) && $Record.search_criteria.minyear > 0}
								<li class="py-1"><strong class="text-secondary">Year Built After: </strong>{$Record.search_criteria.minyear}</li>
							{elseif isset($Record.search_criteria.maxyear) && $Record.search_criteria.maxyear > 0}
								<li class="py-1"><strong class="text-secondary">Year Built Before: </strong>{$Record.search_criteria.maxyear}</li>
							{/if}
							{if isset($Record.search_criteria.waterfront) && !empty($Record.search_criteria.waterfront)}
								<li class="py-1"><strong class="text-secondary">Water Front: </strong>{$Record.search_criteria.waterfront}</li>
							{/if}
							{if isset($Record.search_criteria.pool) && !empty($Record.search_criteria.pool)}
								<li class="py-1"><strong class="text-secondary">Pool: </strong>{$Record.search_criteria.pool}</li>
							{/if}
							{if isset($Record.search_criteria.petsallowed) && !empty($Record.search_criteria.petsallowed)}
								<li class="py-1"><strong class="text-secondary">Pets Allowed: </strong>{$Record.search_criteria.petsallowed}</li>
							{/if}
							{if isset($Record.search_criteria.petsallowed) && !empty($Record.search_criteria.petsallowed)}
								<li class="py-1"><strong class="text-secondary">Pets Allowed: </strong>{$Record.search_criteria.petsallowed}</li>
							{/if}
							{if isset($Record.search_criteria.kword) && !empty($Record.search_criteria.kword)}
								<li class="py-1"><strong class="text-secondary">Additional: </strong> {$Record.search_criteria.kword}</li>
							{/if}
						</ul>
					</div>

				</div>
				<hr class="mx-0 w-100">

				<div class="row justify-content-between pb-4 pb-lg-0">
					<div class="col-auto">
						<div class="update alert alert-success pull-right" style="display:none;" id="save_search_response_{$Record.search_id}"><i class="fa fa-check"></i>&nbsp;Updated.</div>
						<form id="frmSavedSearch" for="form">
							<div class="group position-relative mb-4">
								<label class="text-secondary font-weight-bold" for="exampleInputEmail1">Email Notification :</label>
								<select class="custom-select rounded-0 border-0 te-form-border-bottom shadow-none px-1" onchange="javascript:change_email_notification(this.value,'{$Record.search_id}');">
									{html_options options=$arr_email_notification selected=$Record.search_alert_type}
								</select>
							</div>
						</form>
					</div>
					<div class="col-auto align-self-center">
						<button  onclick="JavaScript:RunSearch_Click('{$Record.search_id}');" class="btn border-secondary- te-btn text-white- shadow-none rounded-0 px-4 lpt-btn lpt-btn-txt">Run Search</button>
						<button onclick="JavaScript:DeleteSearch_Click('{$Record.search_id}');" class="btn border-secondary- te-btn text-white- shadow-none rounded-0 px-4 ml-2 lpt-btn lpt-btn-txt">Delete Search</button>
					</div>
				</div>
			{/foreach}
		{else}
			<div class="text-center text-danger pt-2">No Save Searches Found.</div>
		{/if}
	</div>
</div>