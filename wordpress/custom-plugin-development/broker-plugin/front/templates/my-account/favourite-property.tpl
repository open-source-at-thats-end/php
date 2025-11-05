<div class="card mb-3 bg-white text-left te-card border-0" id="Exterior-hash">
	<div class="card-header te-card-header te-bg-light pl-0 border-0 rounded-0 py-3">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<h5 class="title-font text-left te-line-height-normal mb-0 pb-0 px-2 txt-heading heading_txt_color">Manage Favorites Properties</h5>
		</div>
	</div>
	<div class="card-body collapse show te-mls-property-embedding te-featured-properties mw-100" id="exterior">
		<div class="row">
			{if is_array($rsResult)  && count($rsResult) > 0}
				{foreach name='FavProperty' from=$rsResult item=Record}
					<div class="col-xl-6 col-lg-12 col-md-6 col-sm-12 col-12 p-2">

						<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
							{if $Record.mls_is_pic_url_supported == 'Yes'}
								{assign var=photo_url value=$Record.MainPicture.thumb.url}
								{if $Record.MainPicture.thumb.url != '' && $Record.TotalPhotos > 0}
									{assign var=photo_url value=$Record.MainPicture.thumb.url}
								{else}
									{assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
								{/if}
							{else}
								{*{assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}*}
								{assign var=photo_url value={$Record.MainPicture}}

							{/if}
							<img class="te-property-fig te-property-image position-absolute" src="{$photo_url}" alt="{$Record.Address}-1">
							<div class="-te-property-gradient position-absolute"></div>
							<div class="te-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-5 te-p-5">
								<div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
									<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format}</div>
									<div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.BathsFull|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
									<div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
								</div>
								<div  class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
							</div>

						</a>
						{if $smarty.section.pic.index == 0 && $Record.ListingStatus == 'ActiveUnderContract'}
							<span class="wedges list-detail-wedge">UNDER CONTRACT</span>
						{elseif $smarty.section.pic.index == 0 && $Record.ListingStatus == 'Closed'}
							<span class="wedges list-detail-wedge">CLOSED</span>
						{elseif $smarty.section.pic.index == 0 && $Record.ListingStatus == 'Pending'}
							<span class="wedges list-detail-wedge">Pending</span>
						{/if}
						{if isset($Record.dom) && $Record.dom < 7}
							<span class="wedges-newListing list-detail-wedge">NEW LISTING</span>
						{/if}
						{if $arrConfig['OtherConfig']['login_enable'] == 'Yes'}
							<div class="position-absolute te-property-favourite te-z-index-99" id="fav-link-container-{$Record.ListingID_MLS}">
								{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
									<a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','Other','{$userInfo->ID}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart fav-icon"></i></a>
								{else}
									<a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','Other','{$userInfo->ID}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart fav-icon"></i></a>
								{/if}

							</div>
						{/if}
					</div>
				{/foreach}
			{else}
				<div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12 p-2">
					<div class="text-center text-danger">No Favorite Properties Found</div>
				</div>
			{/if}
		</div>
	</div>
</div>